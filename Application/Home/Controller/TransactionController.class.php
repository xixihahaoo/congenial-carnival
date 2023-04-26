<?php
// +----------------------------------------------------------------------
// | 订单下单控制器
// +----------------------------------------------------------------------
// | Author wang <li>
// +----------------------------------------------------------------------
namespace Home\Controller;

class TransactionController extends CommonController
{


    public function _initialize()
    {
        parent::_initialize();

        $this->user_id = session('user_id');

        if (!$this->user_id) {
            if (IS_AJAX) {
                outjson([
                    'code' => 400,
                    'msg'  => L('no_login'),
                ]);
            } else {
                $this->redirect('Login/login');
            }
        }
    }


    //接口下单
    public function trade()
    {
        //参数检测
        $data = $this->testing();

        $post   = $data['post'];
        $option = $data['option'];
        $info   = $data['info'];

        //止盈止损点位
        $orderData = $this->calculateProfit($post, $option, '', $info);

        //判断金额是否充足
        $returnUser = $this->userCondition($post, $info);
        $user       = $returnUser['user'];
        $sumPrice   = $returnUser['sumPrice'];
        $fee        = $returnUser['fee'];

        //滑点
        $slippage = M('slippage')
            ->where([
                'user_id'   => $this->user_id,
                'option_id' => $post['pid'],
            ])
            ->getField('slippage');

        //        if ($slippage > 0) {

        if ($post['ostyle'] == 0) {
            $order['buyprice'] = $orderData['price'] + $slippage;      //下单价格
        } else {
            $order['buyprice'] = $orderData['price'] - $slippage;      //下单价格
        }
        //        } else {
        //            $order['buyprice'] = $orderData['price'];      //下单价格
        //        }

        $order['option_name'] = $option['capital_name'];    //产品名称
        $order['en_name']     = $option['en_name'];         //产品英文名称
        $order['orderno']     = generate_code(7);         //订单号码
        $order['uid']         = $this->user_id;           //客户编号
        $order['pid']         = $post['pid'];             //下单产品
        $order['buytime']     = time();                   //下单时间
        $order['ostyle']      = $post['ostyle'];          //0涨 1跌，
        $order['onumber']     = $post['number'];          //下单手数
        $order['ostaus']      = 0;                        //0交易，1平仓
        $order['sellprice']   = $orderData['sellprice'];  //平仓价
        $order['endprofit']   = $orderData['endprofit'];  //止盈
        $order['endloss']     = $orderData['endloss'];    //止损
        $order['fee']         = $fee;                     //手续费
        $order['Bond']        = $post['bond'];            //保证金
        $order['type']        = $user['now_trade_status'];//1实盘 2模拟
        $order['order_type']  = 1;                        //自持订单

        $returnArr = $this->placeOrder($order, $sumPrice, $user['rid'], $user['now_trade_status']);

        outjson($returnArr);
    }

    /**
     * [firmOrder 实盘下单]
     * @author wang  li
     */
    private function placeOrder($order, $sumPrice, $rid, $now_trade_status)
    {
        $orderObj    = M('order');
        $flowObj     = M('MoneyFlow');
        $accouontObj = M('accountinfo');

        $accouontObj->startTrans();

        $order_res = $orderObj->add($order);

        //如果实盘下单
        if ($now_trade_status == 1) {
            $member_integral = C('INTE.TRADE');

            $account_res = $accouontObj->where(['uid' => $this->user_id])
                                       ->setDec('balance', $sumPrice);

            //添加资金流水
            $account['uid']      = $this->user_id;
            $account['type']     = 1;
            $account['oid']      = $order_res;
            $account['note']     = '购买'.$order['option_name'].'包含交易费共扣除['.$sumPrice.']美元';
            $account['en_note']  = 'purchase '.$order['en_name'].' Including transaction fee deduction['.$sumPrice.']Dollar';
            $account['ar_note']  = 'يشتمل شراء '.$order['en_name'].' على رسوم المعاملات ، ويتم خصم إجمالي ['.$sumPrice.'] دولار أمريكي';
            $account['ja_note']  = ''.$order['en_name'].'の購入には、取引手数料と合計['.$sumPrice.'] USDが含まれます';
            $account['th_note']  = 'การซื้อ '.$order['en_name'].' รวมค่าธรรมเนียมการทำธุรกรรมและหัก ['.$sumPrice.'] USD ทั้งหมด';
            $account['vi_note']  = 'Mua '.$order['en_name'].' bao gồm phí giao dịch, tổng cộng được khấu trừ ['.$sumPrice.'] USD';
            $account['id_note']  = 'Pembelian '.$order['en_name'].' sudah termasuk biaya transaksi dan dikurangi total ['.$sumPrice.'] USD';

            $account['balance']  = $accouontObj->where(['uid' => $this->user_id])
                                               ->sum('balance');
            $account['op_id']    = $this->user_id;
            $account['dateline'] = time();
            $flow_res            = $flowObj->add($account);


            if ($order_res && $account_res && $flow_res) {
                //检测上级会员等级
                setExtensionLevel($this->user_id);
                //佣金返还
                $this->rebate($order['pid'], $order_res, $order['onumber'], $order['fee'], $rid);
                $accouontObj->commit();

                return [
                    'code' => 200,
                    'msg'  => L('api_success'),
                ];
            } else {
                $accouontObj->rollback();

                return [
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ];
            }
        } else {
            $account_res = $accouontObj->where(['uid' => $this->user_id])
                                       ->setDec('gold', $sumPrice);
            if ($order_res && $account_res) {
                $accouontObj->commit();

                return [
                    'code' => 200,
                    'msg'  => L('api_success'),
                ];
            } else {
                $accouontObj->rollback();

                return [
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ];
            }
        }
    }

    /**
     * [testing 对必要参数进行检测]
     * status  休市是否可以挂单
     * @return [type] [description]
     */
    private function testing($status = false)
    {
        $post['pid'] = trim(I('post.pid'));      //产品id

        $post['ostyle'] = trim(I('post.ostyle'));   //购买方向

        $post['number'] = trim(I('post.number'));   //购买手数

        $post['bond'] = trim(I('post.bond'));     //购买保证金

        $post['endprofit'] = trim(I('post.endprofit')); //止盈点位

        $post['endloss'] = trim(I('post.endloss'));   //止损点位

        //参数进行检测
        if (empty($post['pid'])) {
            outjson([
                'code' => 400,
                'msg'  => L('api_product_not'),
            ]);
        }

        if ($post['ostyle'] != '0' && $post['ostyle'] != 1) {
            outjson([
                'code' => 400,
                'msg'  => L('api_direction_fail'),
            ]);
        }

        if (empty($post['number'])) {
            outjson([
                'code' => 400,
                'msg'  => L('api_direction_lots'),
            ]);
        }

        if (empty($post['bond'])) {
            outjson([
                'code' => 400,
                'msg'  => L('api_choice_bond'),
            ]);
        }

        $optionObj     = M('option');
        $optionInfoObj = M('OptionInfo');

        $option = $optionObj->where(['id' => $post['pid']])
                            ->find();

        if (!$option) {
            outjson([
                'code' => 400,
                'msg'  => L('api_product_not'),
            ]);
        }

        $info = $optionInfoObj->where(['option_id' => $post['pid']])
                              ->find();


        //是否休市
        if ($status == false) {
            if ($option['global_flag'] == 0 || $option['flag'] == 0) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_close_market'),
                ]);
            }

            if ($option['sell_flag'] == 0) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_closing_soon'),
                ]);
            }
        }

        return [
            'post'   => $post,
            'option' => $option,
            'info'   => $info,
        ];
    }

    /**
     * [calculateProfit 止盈止损点位计算]
     * @author wang li
     */
    private function calculateProfit($post, $option, $price, $info)
    {
        //计算止盈止损点位 ostyle 0涨 1跌
        $wave = round($option['wave'] * $post['number'], 2);
        $loss = ($post['bond'] / $wave) / $option['capital_dot_length'];

        if ($post['ostyle'] == 0) {
            $order['price']     = $option['sp'];   //当前点位
            $order['sellprice'] = $option['bp'];   //对手价点位

            if ($post['endprofit'] && $post['endloss']) {
                if ($price) {
                    $nowPrice = $price;
                } else {
                    $nowPrice = $option['sp'];
                }

                if ($post['endprofit'] < $nowPrice) {
                    outjson([
                        'code' => 400,
                        'msg'  => L('api_earnings_error'),
                    ]);
                }

                if ($post['endloss'] > $nowPrice) {
                    outjson([
                        'code' => 400,
                        'msg'  => L('api_loss_error'),
                    ]);
                }

                $order['endprofit'] = sprintf("%.".$info['capital_length']."f", $post['endprofit']);
                $order['endloss']   = sprintf("%.".$info['capital_length']."f", $post['endloss']);
            } else {

                //                $order['endprofit']  = sprintf("%.".$info['capital_length']."f",($order['price'] + ($loss/2))); //止盈默认保证金的50%
                //                $order['endloss']    = sprintf("%.".$info['capital_length']."f",($order['price'] - ($loss/2))); //止损默认保证金的50%

                //设置止盈止损默认50点差
//                $point = $info['coefficient'] * 1000;

//                $order['endprofit'] = sprintf("%.".$info['capital_length']."f", ($order['price'] + $point));
//                $order['endloss']   = sprintf("%.".$info['capital_length']."f", ($order['price'] - $point));

                //简单模式下单，不设置止盈止损
                $order['endprofit'] = 999999;
                $order['endloss']   = $this->setPrice($info['capital_length']);
            }
        } else {
            $order['price']     = $option['bp'];   //当前点位
            $order['sellprice'] = $option['sp'];   //对手价点位
            if ($post['endprofit'] && $post['endloss']) {
                if ($price) {
                    $nowPrice = $price;
                } else {
                    $nowPrice = $option['bp'];
                }

                if ($post['endprofit'] > $nowPrice) {
                    outjson([
                        'code' => 400,
                        'msg'  => L('api_earnings_error'),
                    ]);
                }

                if ($post['endloss'] < $nowPrice) {
                    outjson([
                        'code' => 400,
                        'msg'  => L('api_loss_error'),
                    ]);
                }

                $order['endprofit'] = sprintf("%.".$info['capital_length']."f", $post['endprofit']);
                $order['endloss']   = sprintf("%.".$info['capital_length']."f", $post['endloss']);

            } else {
                //                $order['endprofit']  = sprintf("%.".$info['capital_length']."f",($order['price'] - ($loss/2))); //止盈默认保证金的50%
                //                $order['endloss']    = sprintf("%.".$info['capital_length']."f",($order['price'] + ($loss/2))); //止损默认保证金的50%

                //设置止盈止损默认50点差
//                $point = $info['coefficient'] * 1000;

//                $order['endprofit'] = sprintf("%.".$info['capital_length']."f", ($order['price'] - $point));
//                $order['endloss']   = sprintf("%.".$info['capital_length']."f", ($order['price'] + $point));

                //简单模式下单，不设置止盈止损
                $order['endprofit'] = $this->setPrice($info['capital_length']);
                $order['endloss']   = 999999;
            }
        }

        return $order;
    }

    /**
     * [userCondition 判断用户是否有条件下单]
     * @author wang li
     */
    private function userCondition($post, $info)
    {
        $userObj     = M('userinfo');    //用户
        $accouontObj = M('accountinfo'); //资金

        $user    = $userObj->field('trade_frozen,rid,now_trade_status')
                           ->where(['uid' => $this->user_id])
                           ->find();
        $account = $accouontObj->field('balance,gold')
                               ->where(['uid' => $this->user_id])
                               ->find();

        if (!$user) {
            outjson([
                'code' => 400,
                'msg'  => L('api_user_not'),
            ]);
        }

        //判断用户是否被冻结
        if ($user['trade_frozen'] == 1) {
            outjson([
                'code' => 400,
                'msg'  => L('api_account_inactivated'),
            ]);
        }

        $fee      = ($info['CounterFee'] * $post['number']);  //订单手续费
        $sumPrice = $fee + $post['bond'];                     //总支出费用

        //判断用户当前交易状态 1实盘交易 2模拟交易
        if ($user['now_trade_status'] == 1) {
            //判断用户金额是否充足
            if ($account['balance'] < $sumPrice) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_balance_insufficient'),
                ]);
            }

            //判断运营中心阈值是否充足
            $exchange_id = exchange($this->user_id, 2);
            $acc         = $accouontObj->field('balance,frozen_threshold')
                                       ->where(['uid' => $exchange_id])
                                       ->find();

            if ($acc['frozen_threshold'] == 0) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_no_deal'),
                ]);
            }

            if ($acc['balance'] <= $acc['frozen_threshold']) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_no_deal'),
                ]);
            }

            //运营中心金额是否小于用户下单最大保证金
            if ($acc['balance'] < $post['bond']) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_no_deal'),
                ]);
            }

            $amount = $account['balance'];

        } else {
            //判模拟金额是否充足
            if ($account['gold'] < $sumPrice) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_sim_insufficient'),
                ]);
            }

            $amount = $account['gold'];
        }

        //判断下单条件 保证金比例是否小于50%
        $orderTotal = M('order')
            ->field('sum(Bond) bond,sum(ploss) ploss')
            ->where([
                'uid'    => $this->user_id,
                'type'   => $user['now_trade_status'],
                'ostaus' => 0,
            ])
            ->find();

        if (!empty($orderTotal['bond'])) {
            $guadanBond = M('gudan_order')
                ->where([
                    'user_id' => $this->user_id,
                    'type'    => $user['now_trade_status'],
                    'status'  => 1,
                ])
                ->sum('bond');

            $useBond  = round($orderTotal['bond'] + $guadanBond);
            $worth    = round($amount + $useBond + $orderTotal['ploss'], 2);
            $bondRate = round(($worth / $useBond) * 100, 2);
            if ($bondRate < C('BOND_RATE')) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_bond_rate').C('BOND_RATE').'%，'.L('api_no_order'),
                ]);
            }
        }


        return [
            'user'     => $user,
            'sumPrice' => $sumPrice,
            'fee'      => $fee,
        ];
    }


    /**
     * [restingOrder 挂单]
     * @author wang li
     */
    public function restingOrder()
    {
        $data = $this->testing(true);   //休市也可挂单

        $post   = $data['post'];
        $option = $data['option'];
        $info   = $data['info'];

        $price = trim(I('post.price'));

        $type = trim(I('post.type'));

        $time = trim(I('post.time'));

        if (empty($price)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_entrust_price'),
            ]);
        }

        if (empty($type)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_entrust_type'),
            ]);
        }

        if ($type == 1) {
            if ($price < $option['bp']) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_entrust_section'),
                ]);
            }
        } elseif ($type == 2) {
            if ($price > $option['sp']) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_entrust_section'),
                ]);
            }
        } elseif ($type == 3) {
            if ($price > $option['bp']) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_entrust_section'),
                ]);
            }
        } elseif ($type == 4) {
            if ($price < $option['sp']) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_entrust_section'),
                ]);
            }
        } else {
            outjson([
                'code' => 400,
                'msg'  => L('api_entrust_type_not'),
            ]);
        }


        if ($time) {
            $time = strtotime($time);
            //设置时间在半小时以后
            $nowTime = time() + (30 * 60);
            if ($time < $nowTime) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_entrust_time'),
                ]);
            }
        } else {
            $time = strtotime('+1 day');    //推迟一天
        }

        //止盈止损计算
        $order = $this->calculateProfit($post, $option, $price);

        //判断金额是否充足
        $returnUser = $this->userCondition($post, $info);
        $user       = $returnUser['user'];
        $fee        = $returnUser['fee'];
        $sumPrice   = $returnUser['sumPrice'];

        $dataArr['option_name']  = $option['capital_name'];
        $dataArr['en_name']      = $option['en_name'];
        $dataArr['user_id']      = $this->user_id;
        $dataArr['option_id']    = $post['pid'];
        $dataArr['order_no']     = generate_code(7); //订单号码
        $dataArr['ostyle']       = $post['ostyle'];
        $dataArr['guadan_type']  = $type;
        $dataArr['guadan_price'] = $price;
        $dataArr['now_price']    = $post['ostyle'] == 0 ? $option['sp'] : $option['bp'];     //当前价格
        $dataArr['number']       = $post['number'];
        $dataArr['bond']         = $post['bond'];
        $dataArr['fee']          = $fee;
        $dataArr['endprofit']    = $order['endprofit'];
        $dataArr['endloss']      = $order['endloss'];
        $dataArr['end_time']     = $time;
        $dataArr['status']       = 1;
        $dataArr['type']         = $user['now_trade_status'];
        $dataArr['create_time']  = time();

        $returnArr = $this->restingTrade($dataArr, $sumPrice, $user['now_trade_status']);  //挂单操作
        outjson($returnArr);
    }

    /**
     * [restingTrade 订单挂单]
     * @param  [type] $order    [description]
     * @param  [type] $sumPrice [description]
     * @return [type]           [description]
     */
    private function restingTrade($order, $sumPrice, $now_trade_status)
    {
        $restingObj  = M('GuadanOrder'); //挂单
        $flowObj     = M('MoneyFlow');   //流水
        $accouontObj = M('accountinfo'); //账户

        $accouontObj->startTrans();

        $resting_res = $restingObj->add($order);

        if ($now_trade_status == 1) {
            $account_res = $accouontObj->where(['uid' => $this->user_id])
                                       ->setDec('balance', $sumPrice);

            //添加资金流水
            $map['uid']      = $this->user_id;
            $map['type']     = 1;
            $map['oid']      = $resting_res;
            $map['note']     = '挂单'.$order['option_name'].'包含交易费共扣除['.$sumPrice.']美元';
            $map['en_note']  = 'Entrusted '.$order['en_name'].' including transaction fee deducted ['.$sumPrice.'] USD';
            $map['ar_note']  = ''.$order['en_name'].' المعتمد بما في ذلك رسوم المعاملة المخصومة ['.$sumPrice.'] دولار أمريكي';
            $map['ja_note']  = '差し引かれる取引手数料を含む委託 '.$order['en_name'].' ['.$sumPrice.'] USD';
            $map['th_note']  = ''.$order['en_name'].' ที่ได้รับความไว้วางใจรวมถึงค่าธรรมเนียมการทำธุรกรรมที่หัก ['.$sumPrice.'] USD';
            $map['vi_note']  = 'Ủy thác '.$order['en_name'].' bao gồm phí giao dịch, đã khấu trừ ['.$sumPrice.'] USD';
            $map['id_note']  = 'Entrust '.$order['en_name'].' termasuk biaya transaksi dikurangi ['.$sumPrice.'] USD';

            $map['balance']  = $accouontObj->where(['uid' => $this->user_id])
                                           ->sum('balance');
            $map['op_id']    = $this->user_id;
            $map['dateline'] = time();

            $flow_res = $flowObj->add($map);

            if ($resting_res && $flow_res && $account_res) {
                $accouontObj->commit();

                return [
                    'code' => 200,
                    'msg'  => L('api_success'),
                ];
            } else {
                $accouontObj->rollback();

                return [
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ];
            }
        } else {
            $account_res = $accouontObj->where(['uid' => $this->user_id])
                                       ->setDec('gold', $sumPrice);
            if ($resting_res) {
                $accouontObj->commit();

                return [
                    'code' => 200,
                    'msg'  => L('api_success'),
                ];
            } else {
                $accouontObj->rollback();

                return [
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ];
            }
        }
    }


    /**
     * 返佣操作
     * @param  [type] $option_id [产品id]
     * @param  [type] $order_id [订单id]
     * @param  [type] $number   [交易手数]
     * @param  [type] $fee      [总手续费]
     * @return [type] void      [description]
     */
    private function rebate($option_id, $order_id, $number, $fee, $rid)
    {
        if ($fee > 0) {
            $userObj = M('userinfo');

            $info = $userObj->field('uid,extension_level')
                            ->where(['uid' => $rid])
                            ->find();

            if ($info) {
                $rateObj   = M('UserinfoRate');
                $classObj  = M('OptionClassify');
                $optionObj = M('option');

                $pid     = $optionObj->where(['id' => $option_id])
                                     ->getField('pid');
                $classId = $classObj->where([
                    'id'    => $pid,
                    'level' => 2,
                ])
                                    ->getField('pid');

                $data  = F('data');
                $level = $rateObj->where(['id' => $info['extension_level']])
                                 ->getField('level');
                $price = $data[$classId]['level'][$level]['price'];

                if (!empty($price)) {
                    $money = round($number * $price, 2);             //收益

                    $datas['order_id']     = $order_id;        //订单id
                    $datas['user_id']      = $info['uid'];     //领取人id 0表示交易所
                    $datas['profit']       = $money;           //佣金收益
                    $datas['fee']          = $fee;             //订单总手续费
                    $datas['create_time']  = time();           //创建时间
                    $datas['status']       = 2;                //1已经发放  2未发放
                    $datas['type']         = 1;                //1用户 2交易所 3运营中心  4 经纪人
                    $datas['purchaser_id'] = $this->user_id;   //购买人
                    M('FeeReceive')->add($datas);
                }
            }
        }
    }

    /**
     * 时间盘下单交易
     * @author 王海东
     * @date
     * @return void
     */
    public function timeTradeOrder()
    {
        $pid     = trim(I('post.pid'));      //产品id
        $ostyle  = trim(I('post.ostyle'));   //购买方向
        $bond    = trim(I('post.bond'));     //购买保证金
        $time_id = trim(I('post.time_id'));  //下单时长

        //参数进行检测
        if (empty($pid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_product_not'),
            ]);
        }

        if ($ostyle != '0' && $ostyle != 1) {
            outjson([
                'code' => 400,
                'msg'  => L('api_direction_fail'),
            ]);
        }

        if (empty($bond)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_purchase_amount'),
            ]);
        }

        if (empty($time_id)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_due_time'),
            ]);
        }

        if ($bond < 20) {
            outjson([
                'code' => 400,
                'msg'  => L('api_amount_less'),
            ]);
        }

        $optionObj    = M('option');
        $infoObj      = M('option_info');
        $parameterObj = M('OptionParameter');
        $userObj      = M('userinfo');
        $accountObj   = M('accountinfo');
        $orderObj     = M('order');
        $flowObj      = M('money_flow');

        $option = $optionObj->where(['id' => $pid])
                            ->find();
        $info   = $infoObj->where(['option_id' => $pid])
                          ->find();

        if (!$option) {
            outjson([
                'code' => 400,
                'msg'  => L('api_product_not'),
            ]);
        }

        if ($option['global_flag'] == 0 || $option['flag'] == 0) {
            outjson([
                'code' => 400,
                'msg'  => L('api_close_market'),
            ]);
        }

        if ($option['sell_flag'] == 0) {
            outjson([
                'code' => 400,
                'msg'  => L('api_closing_soon'),
            ]);
        }

        $parameter = $parameterObj->where([
            'id'   => $time_id,
            'flag' => 0,
        ])
                                  ->find();

        if (!$parameter) {
            outjson([
                'code' => 400,
                'msg'  => L('api_due_time_not'),
            ]);
        }

        $user = $userObj->where(['uid' => $this->user_id])
                        ->find();

        if ($user['trade_frozen'] == 1) {
            outjson([
                'code' => 400,
                'msg'  => L('api_you_frozen'),
            ]);
        }

        $account = $accountObj->where(['uid' => $this->user_id])
                              ->find();

        $fee    = round($bond * ($info['fee_time'] / 100), 2);
        $amount = $fee + $bond;

        if ($user['now_trade_status'] == 1) {
            if ($account['balance'] < $amount) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_balance_insufficient'),
                ]);
            }
        } else {
            if ($account['gold'] < $amount) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_sim_insufficient'),
                ]);
            }
        }

        //滑点
        $slippage = M('slippage')
            ->where([
                'user_id'   => $this->user_id,
                'option_id' => $pid,
            ])
            ->getField('slippage');

        if ($slippage > 0) {

            if ($ostyle == 0) {
                $order['buyprice'] = $option['Price'] + $slippage;      //下单价格
            } else {
                $order['buyprice'] = $option['Price'] - $slippage;      //下单价格
            }
        } else {
            $order['buyprice'] = $option['Price'];         //下单价格
        }

        $order['option_name'] = $option['capital_name'];  //产品名称
        $order['en_name']     = $option['en_name'];  //产品名称
        $order['orderno']     = generate_code(7);         //订单号码
        $order['uid']         = $this->user_id;           //客户编号
        $order['pid']         = $pid;                     //下单产品
        $order['buytime']     = time();                   //下单时间
        $order['ostyle']      = $ostyle;                  //0涨 1跌，
        //$order['onumber']   = 1;                        //下单手数
        $order['ostaus']      = 0;                        //0交易，1平仓
        $order['fee']         = $fee;                     //手续费
        $order['Bond']        = $bond;                    //保证金
        $order['type']        = $user['now_trade_status'];//1实盘 2模拟
        $order['order_type']  = 1;                        //自持订单
        $order['order_scene'] = 2;                        //时间模式
        $order['finirm_time'] = date('Y-m-d H:i:s', time() + $parameter['time']);                        //持单自动到期时间
        $order['second']      = $parameter['time'];       //持单时长
        $order['odds']        = $parameter['rate'];       //收益比例

        $accountObj->startTrans();

        $order_res = $orderObj->add($order);

        if ($user['now_trade_status'] == 1) {

            $account_res = $accountObj->where(['uid' => $this->user_id])
                                      ->setDec('balance', $amount);

            //添加资金流水
            $account['uid']      = $this->user_id;
            $account['type']     = 1;
            $account['oid']      = $order_res;
            $account['note']     = '购买'.$option['capital_name'].'包含交易费共扣除['.$amount.']美元';
            $account['en_note']  = 'purchase '.$option['en_name'].' Including transaction fee deduction['.$amount.']Dollar';
            $account['ar_note']  = 'يشتمل شراء '.$option['en_name'].' على رسوم المعاملات ، ويتم خصم إجمالي ['.$amount.'] دولار أمريكي';
            $account['ja_note']  = ''.$option['en_name'].'の購入には、取引手数料と合計['.$amount.'] USDが含まれます';
            $account['th_note']  = 'การซื้อ '.$option['en_name'].' รวมค่าธรรมเนียมการทำธุรกรรมและหัก ['.$amount.'] USD ทั้งหมด';
            $account['vi_note']  = 'Mua '.$option['en_name'].' bao gồm phí giao dịch, tổng cộng được khấu trừ ['.$amount.'] USD';
            $account['id_note']  = 'Pembelian '.$option['en_name'].' sudah termasuk biaya transaksi dan dikurangi total ['.$amount.'] USD';

            $account['balance']  = $accountObj->where(['uid' => $this->user_id])
                                              ->sum('balance');
            $account['op_id']    = $this->user_id;
            $account['dateline'] = time();
            $flow_res            = $flowObj->add($account);

            //返佣
            //            if(!empty($user['rid'])) {
            //                $this->rebate($order['pid'],$order_res,$order['onumber'],$order['fee'],$user['rid']);
            //            }

            if ($order_res && $account_res && $flow_res) {
                $accountObj->commit();
                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                    'id' => $order_res
                ]);
            } else {
                $accountObj->rollback();
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }
        } else {
            $account_res = $accountObj->where(['uid' => $this->user_id])
                                      ->setDec('gold', $amount);

            if ($order_res && $account_res) {
                $accountObj->commit();
                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                    'id' => $order_res
                ]);
            } else {
                $accountObj->rollback();
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }
        }
    }

    /**
     * 根据小数点增加相应点位
     * @author 王海东
     * @date   2020-11-03 15:01
     * @param $capital_length
     * @return mixed
     */
    private function setPrice($capital_length)
    {
        $data = [
            '1',
            '0.1',
            '0.01',
            '0.001',
            '0.0001',
            '0.00001',
            '0.000001',
        ];

        return $data[ $capital_length ];
    }
}