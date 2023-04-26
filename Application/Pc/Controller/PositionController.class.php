<?php
// +----------------------------------------------------------------------
// | 持仓控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Pc\Controller;

use Think\Controller;

class PositionController extends CommonController
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
            }
            else {
                $this->redirect('Login/login');
            }
        }

        $this->assign('lang',LANG);
    }

    /**
     * [trade 持仓记录]
     * @author wang li
     */
    public function trade()
    {


        $orderObj   = D('order');
        $userObj    = M('userinfo');
        $accountObj = M('accountinfo');

        $now_trade_status = $userObj->where(['uid' => $this->user_id])
                                    ->getField('now_trade_status');    //1实盘 2模拟交易

        $account = $accountObj->where(['uid' => $this->user_id])
                              ->find();

        $order = $orderObj->getList($this->user_id, 0, $now_trade_status);

        $positionBond   = 0;
        $positionPloss  = 0;

        foreach ($order as $key => $value) {

            //持仓保证金
            $positionBond += $value['Bond'];
            //总盈亏金额
            $positionPloss += $value['ploss'];
        }

        //挂单订单
        $restingObj  = M('guadan_order');
        $restingBond = $restingObj->field('bond')
                                  ->where([
                                      'user_id' => $this->user_id,
                                      'status'  => 1,
                                      'type'    => $now_trade_status,
                                  ])
                                  ->sum('bond');

        //根据当前用户状态取出对应值
        if ($now_trade_status == 1) {
            $account['balance'] = $account['balance'];
        }
        else {
            $account['balance'] = $account['gold'];
        }

        //已用保证金
        $account['usedBond'] = round($positionBond + $restingBond, 2);
        //账户净值
        $account['worth'] = round(($account['balance'] + $account['usedBond']) + $positionPloss, 2);
        //浮动盈亏
        $account['floatloss'] = round($positionPloss, 2);

        // vD($order);die;
        $this->assign('account', $account);
        $this->assign('user_id', $this->user_id);

        $this->assign('now_trade_status', $now_trade_status);
        $this->display();
    }


    /**
     * [equityDetails 持仓详情]
     * @return [type] [description]
     */
    public function equityDetails()
    {
        $oid = trim(I('get.oid')); //订单ID

        $orderObj      = M('order');
        $optionObj     = M('option');
        $optionInfoObj = M('option_info');

        $order = $orderObj->where([
            'oid'    => $oid,
            'ostaus' => 0,
        ])
                          ->find();    //只查询持仓的产品
//        echo 111;die;
        if (!$order) {
            $this->redirect('trade');
        }


        $option = $optionObj->field('wave,capital_dot_length,capital_key')
                            ->where(['id' => $order['pid']])
                            ->find();
        $info   = $optionInfoObj->field('capital_length')
                                ->where(['option_id' => $order['pid']])
                                ->find();


        $order['remaining_time'] = strtotime($order['finirm_time']) - time();

        $order['ostyleMsg']   = $order['ostyle'] == 0 ? L('api_buy') : L('api_sell');
        $order['ostyleColor'] = $order['ostyle'] == 0 ? 'bg_green' : 'bg_red';

        $order['endloss']   = sprintf("%.".$info['capital_length']."f", $order['endloss']);
        $order['endprofit'] = sprintf("%.".$info['capital_length']."f", $order['endprofit']);
        $order['buyprice']  = sprintf("%.".$info['capital_length']."f", $order['buyprice']);
        $order['sellprice'] = sprintf("%.".$info['capital_length']."f", $order['sellprice']);

        $order['onumber'] = round($order['onumber'], 2);

        $wave = round($option['wave'] * $order['onumber'], 2);

        if ($order['ostyle'] == 0) {
            $order['lossSymbol']   = '≤';
            $order['profitSymbol'] = '≥';
        }
        else {
            $order['lossSymbol']   = '≥';
            $order['profitSymbol'] = '≤';
        }

        $order['lossLoss'] = abs(($order['buyprice'] - $order['endloss']) * $wave * $option['capital_dot_length']);

        if(LANG == 'en-us') {
            $order['option_name'] = $order['en_name'];
        } else if(LANG == 'zh-tw') {
            $order['option_name'] = simpleTradition($order['option_name']);
        }


        $this->assign('option', $option);
        $this->assign('info', $info);
        $this->assign('order', $order);
        $this->display();
    }

    /**
     * [saveProfitAndLoss 持仓订单止盈止损修改]
     * @return [type] [description]
     */
    public function saveProfitAndLoss()
    {
        $oid       = trim(I('post.oid'));
        $endprofit = trim(I('post.endprofit'));
        $endloss   = trim(I('post.endloss'));

        if (empty($oid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        if (empty($endprofit) || empty($endloss)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_ps_cannot'),
            ]);
        }

        $orderObj      = M('order');
        $optionObj     = M('option');
        $optionInfoObj = M('option_info');

        $order = $orderObj->field('oid,pid,uid,bond,ostyle,buyprice,sellprice,onumber,type')
                          ->where([
                              'oid'    => $oid,
                              'ostaus' => 0,
                          ])
                          ->find();

        if (!$order) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $option = $optionObj->field('wave,capital_dot_length')
                            ->where(['id' => $order['pid']])
                            ->find();

        $info = $optionInfoObj->where(['option_id' => $order['pid']])
                              ->getField('capital_length');

        $wave = round($option['wave'] * $order['onumber'], 2);

        $point = ($order['bond'] / $wave) / $option['capital_dot_length'];

        $ostyle = $order['ostyle'];

        if ($ostyle == 1) {
            if ($order['sellprice'] <= $order['buyprice']) {
                $plossPrice  = $order['buyprice'];
                $profitPrice = $order['sellprice'];
            }
            else {
                $plossPrice  = $order['sellprice'];
                $profitPrice = $order['buyprice'];
            }
        }
        else {
            if ($order['sellprice'] <= $order['buyprice']) {
                $plossPrice  = $order['sellprice'];
                $profitPrice = $order['buyprice'];
            }
            else {
                $plossPrice  = $order['buyprice'];
                $profitPrice = $order['sellprice'];
            }
        }

        $upperLimit = 999999;   //上限
        $lowerLimit = self::lengthToNumber(1)[ $info['capital_length'] ]; //下限

        if ($ostyle == 1) {
            //止损
            if ($endloss < $plossPrice || $endloss > $upperLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_loss_error'),
                ]);
            }

            //止盈
            if ($endprofit > $profitPrice || $endprofit < $lowerLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_earnings_error'),
                ]);
            }
        }
        else {

            //止损
            if ($endloss > $plossPrice || $endloss < $lowerLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_loss_error'),
                ]);
            }

            //止盈
            if ($endprofit < $profitPrice || $endprofit > $upperLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_earnings_error'),
                ]);
            }
        }

        $dataArr = [
            'endprofit' => $endprofit,
            'endloss'   => $endloss,
        ];

        $res = $orderObj->where(['oid' => $oid])
                        ->save($dataArr);

        if (!$res) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        //自动调整跟随订单的止盈止损 (只针对于实盘)
        if ($order['type'] == 1) {

            $orderObj->where([
                'follow_order_id' => $order['oid'],
                'follow_user_id'  => $order['uid'],
                'ostaus'          => 0,
                'order_type'      => 2,
                'type'            => 1,
            ])
                     ->save($dataArr);
        }

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
    }


    /**
     * [cover 订单平仓操作]
     * @author wang li
     */
    public function cover()
    {
        $oid = trim(I('post.oid'));

        file_put_contents('/tmp/order.log', __FUNCTION__."-".$oid."\n", FILE_APPEND | LOCK_EX);

        if (empty($oid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $orderObj = M('order');

        $order = $orderObj->field('oid,uid,pid,ostyle,sellprice,buyprice,Bond,ploss,type,fee,option_name,onumber,order_type,follow_user_id,overnight_fee,selltime,en_name')
                          ->where([
                              'oid'    => $oid,
                              'ostaus' => 0,
                          ])
                          ->find();

        if (!$order) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        //跟随订单禁止平仓
        if ($order['order_type'] == 2) {
            outjson([
                'code' => 400,
                'msg'  => L('api_follow_closing'),
            ]);
        }

        file_put_contents('/tmp/order.log', __FUNCTION__."-".json_encode($order)."\n", FILE_APPEND | LOCK_EX);

        $this->operationOrder($order);
    }


    /**
     * [operationOrder 操作平仓]
     * @author wang li
     */
    public function operationOrder($order)
    {
        $orderObj   = M('order');
        $accountObj = M('accountinfo');
        $optionObj  = M('option');


        $option = $optionObj->field('wave,capital_dot_length,flag,capital_key')
                            ->where(['id' => $order['pid']])
                            ->find();

        //休市禁止平仓
        if ($option['flag'] == 0) {
            outjson([
                'code' => 400,
                'msg'  => L('api_close_prohibited'),
            ]);
        }


        $wave = round($option['wave'] * $order['onumber'], 2);

        $orderObj->startTrans(); //开启事务

        //        if ($order['ostyle'] == 0) {
        //
        //            /*********************禁止爆仓***************************/
        //            $ploss = (($order['sellprice'] - $order['buyprice']) * $wave) * $option['capital_dot_length'];
        //
        //            if ($ploss > $order['Bond']) {
        //                $data['sellprice'] = $order['buyprice'] + (($order['Bond'] / $wave) / $option['capital_dot_length']);
        //                $data['ploss']     = $order['Bond'];
        //            } elseif ($ploss < -$order['Bond']) {
        //                $data['sellprice'] = $order['buyprice'] - (($order['Bond'] / $wave) / $option['capital_dot_length']);
        //                $data['ploss']     = -$order['Bond'];
        //            } else {
        //                $data['sellprice'] = $order['sellprice'];
        //                $data['ploss']     = $ploss;
        //            }
        //            /*************************************************/
        //
        //        } else {
        //
        //            /*********************禁止爆仓***************************/
        //            $ploss = (($order['buyprice'] - $order['sellprice']) * $wave) * $option['capital_dot_length'];
        //
        //            if ($ploss > $order['Bond']) {
        //                $data['sellprice'] = $order['buyprice'] - (($order['Bond'] / $wave) / $option['capital_dot_length']);
        //                $data['ploss']     = $order['Bond'];
        //            } elseif ($ploss < -$order['Bond']) {
        //                $data['sellprice'] = $order['buyprice'] + (($order['Bond'] / $wave) / $option['capital_dot_length']);
        //                $data['ploss']     = -$order['Bond'];
        //            } else {
        //                $data['sellprice'] = $order['sellprice'];
        //                $data['ploss']     = $ploss;
        //            }
        //            /*************************************************/
        //        }

        if($order['uid']==330 ){

        }
        file_put_contents('/tmp/order.log', json_encode($order)."\n", FILE_APPEND | LOCK_EX);

        $data['sellprice'] = $order['sellprice'];
        $data['ploss']     = $order['ploss'];


        $data['selltime'] = time();
        $data['ostaus']   = 1;
        $data['auto']     = 1;

        if ($data['ploss'] == 0) {
            $data['order_result'] = 1;
        }
        elseif ($data['ploss'] > 0) {
            $data['order_result'] = 2;
        }
        else {
            $data['order_result'] = 3;
        }


        $ostaus = $orderObj->where([
            'oid'    => $order['oid'],
            'ostaus' => 0,
            'uid'    => $order['uid'],
        ])
                           ->save($data);

        if ($ostaus) {
            $data['ploss'] = round($data['ploss'], 2);

            $money = ($order['Bond'] + $data['ploss']);  //保证金+盈亏
            if ($order['type'] == 1)    //如果为实盘交易
            {
                //设置运营中心 (盈亏)
                $exchangeId = exchange($order['uid'], 2);

                $yingkui = $data['ploss'] < 0 ? (abs($data['ploss'])) : -$data['ploss'];

                $accountObj->where(['uid' => $exchangeId])
                           ->setInc('balance', $yingkui);                        //修改运营中心金额

                $account        = $accountObj->where(['uid' => $order['uid']])
                                             ->setInc('balance', $money);    //修改用户金额
                $surplusBalance = $accountObj->where(['uid' => $order['uid']])
                                             ->getField('balance');

                if ($surplusBalance) {
                    if ($yingkui < 0) {
                        $accountObj->where(['uid' => $order['uid']])
                                   ->setInc('income_total', abs($yingkui));    //修改用户总盈利
                    }
                    else {
                        $accountObj->where(['uid' => $order['uid']])
                                   ->setInc('loss_total', abs($yingkui));    //修改用户总亏损
                    }
                }

            }
            else {
                $account        = $accountObj->where(['uid' => $order['uid']])
                                             ->setInc('gold', $money);     //修改用户金币
                $surplusBalance = $accountObj->where(['uid' => $order['uid']])
                                             ->getField('gold');
            }

            if ($ostaus) {

                $orderObj->commit();
                if ($order['type'] == 1) {
                    //添加资金流水
                    $this->balanceFlow($order['uid'], $order['oid'], $order['option_name'], $money, $surplusBalance, $exchangeId, $yingkui, $order['en_name']);

                    //处理交易员以及跟随者
                    /**********************************/
                    $order = $orderObj->where(['oid' => $order['oid']])
                                      ->find();
                    $this->setByFollowBalance($data, $order);
                    $this->followOrder($order);
                    $this->autoOrder($data['ploss'], $order['uid'], $order['oid']);
                    /**********************************/
                }
                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                ]);
            }
            else {

                $orderObj->rollback();
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }

        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }

    /**
     * [balanceFlow 添加资金流水]
     * @param    int    $uid            [用户编号]
     * @param    int    $oid            [订单id]
     * @param    string $option_name    [产品名称]
     * @param    float  $money          [用户要增加的金额]
     * @param    float  $surplusBalance [用户剩余金额]
     * @param    int    $exchangeId     [运营中心id]
     * @param    float  $yingkui        [运营中心盈亏]
     * @author    wang li
     */
    private function balanceFlow(int $uid, int $oid, string $option_name, float $money, float $surplusBalance, int $exchangeId, float $yingkui, $en_name)
    {
        $flowObj = M('MoneyFlow');

        //用户资金流水表
        $userNote   = $money >= 0 ? '增加' : '扣除';
        $enUserNote = $money >= 0 ? 'increase' : 'deduction';

        $map['uid']       = $uid;
        $map['type']      = 2;
        $map['oid']       = $oid;
        $map['note']      = '对'.$option_name.'进行平仓'.$userNote.'['.$money.']美元';
        $map['en_note']   = 'Products '.$en_name.' Liquidate'.$enUserNote.'['.$money.']Dollar';
        $map['balance']   = $surplusBalance;
        $map['op_id']     = $uid;
        $map['user_type'] = 1;
        $map['dateline']  = time();
        $flowObj->add($map);

        //运营中心资金流水表
        $operateNote   = $yingkui >= 0 ? '增加' : '扣除';
        $enOperateNote = $yingkui >= 0 ? 'increase' : 'deduction';

        $operate['uid']       = $exchangeId;
        $operate['type']      = 2;
        $operate['oid']       = $oid;
        $operate['note']      = '用户对'.$option_name.'进行平仓'.$operateNote.'['.$yingkui.']美元';
        $operate['en_note']   = 'User pairs '.$en_name.' Liquidate'.$enOperateNote.'['.$yingkui.']Dollar';
        $operate['balance']   = M('accountinfo')
            ->where('uid='.$exchangeId)
            ->sum('balance');
        $operate['op_id']     = $uid;
        $operate['user_type'] = 2;
        $operate['dateline']  = time();
        $flowObj->add($operate);
    }


    /**
     * [cancelOrder 订单撤单]
     * @author wang li
     */
    public function cancelOrder()
    {
        $id = trim(I('post.id'));

        if (empty($id)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $guadanObj   = M('guadan_order');
        $accouontObj = M('accountinfo');

        $data = $guadanObj->where([
            'user_id' => $this->user_id,
            'id'      => $id,
            'status'  => 1,
        ])
                          ->find();

        if (!$data) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $dataArr = [
            'status'      => 2,
            'handle_time' => time(),
        ];

        $accouontObj->startTrans();

        $res = $guadanObj->where([
            'user_id' => $this->user_id,
            'id'      => $id,
            'status'  => 1,
        ])
                         ->save($dataArr);

        $sumPrice = $data['bond'] + $data['fee'];

        if ($data['type'] == 1) {
            $account_res = $accouontObj->where(['uid' => $this->user_id])
                                       ->setInc('balance', $sumPrice);

            //添加资金流水
            $account['uid']      = $this->user_id;
            $account['type']     = 7;
            $account['oid']      = $id;
            $account['note']     = '撤单'.$data['option_name'].'成功返还金额['.$sumPrice.']美元';
            $account['en_note']  = 'Cancel the order '.$data['en_name'].' Successful Return Amount['.$sumPrice.']Dollar';
            $account['balance']  = $accouontObj->where(['uid' => $this->user_id])
                                               ->sum('balance');
            $account['op_id']    = $this->user_id;
            $account['dateline'] = time();
            $flow_res            = M('MoneyFlow')->add($account);
        }
        else {
            $account_res = $accouontObj->where(['uid' => $this->user_id])
                                       ->setInc('gold', $sumPrice);
        }

        if ($res && $account_res) {
            $accouontObj->commit();
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
        else {
            $accouontObj->rollback();
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }


    /**
     * [cancelDetails 挂单单详情]
     * @author wang li
     */
    public function cancelDetails()
    {
        $id = trim(I('get.id')); //订单ID

        $guadanObj     = M('guadan_order');
        $optionObj     = M('option');
        $optionInfoObj = M('option_info');

        $order = $guadanObj->where(['id' => $id])
                           ->find();

        $option = $optionObj->field('wave,capital_dot_length,capital_key')
                            ->where(['id' => $order['option_id']])
                            ->find();
        $info   = $optionInfoObj->field('capital_length')
                                ->where(['option_id' => $order['option_id']])
                                ->find();

        $order['ostyleMsg']   = $order['ostyle'] == 0 ? L('api_buy') : L('api_sell');
        $order['ostyleColor'] = $order['ostyle'] == 0 ? 'bg_red' : 'bg_green';

        $order['endloss']   = sprintf("%.".$info['capital_length']."f", $order['endloss']);
        $order['endprofit'] = sprintf("%.".$info['capital_length']."f", $order['endprofit']);

        $order['guadan_price'] = sprintf("%.".$info['capital_length']."f", $order['guadan_price']);
        $order['now_price']    = sprintf("%.".$info['capital_length']."f", $order['now_price']);

        $order['number'] = round($order['number'], 2);

        $wave = round($option['wave'] * $order['number'], 2);

        $methond = [
            1 => L('api_sell_limit'),
            2 => L('api_buy_limit'),
            3 => L('api_break_sell'),
            4 => L('api_break_buy'),
        ];

        $order['typeMsg'] = $methond[ $order['guadan_type'] ];

        if ($order['ostyle'] == 0) {
            $order['lossSymbol']   = '≤';
            $order['profitSymbol'] = '≥';
        }
        else {
            $order['lossSymbol']   = '≥';
            $order['profitSymbol'] = '≤';
        }

        $order['lossLoss'] = abs(($order['guadan_price'] - $order['endloss']) * $wave * $option['capital_dot_length']);

        if(LANG == 'en-us') {
            $order['option_name'] = $order['en_name'];
        } else if(LANG == 'zh-tw') {
            $order['option_name'] = simpleTradition($order['option_name']);
        }

        $this->assign('option', $option);
        $this->assign('info', $info);
        $this->assign('order', $order);
        $this->display();
    }


    /**
     * [saveProfitAndLoss 挂单止盈止损修改]
     * @return [type] [description]
     */
    public function guadanSaveProfitAndLoss()
    {
        $id        = trim(I('post.id'));
        $endprofit = trim(I('post.endprofit'));
        $endloss   = trim(I('post.endloss'));

        if (empty($id)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        if (empty($endprofit) || empty($endloss)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_ps_cannot'),
            ]);
        }

        $orderObj      = M('guadan_order');
        $optionObj     = M('option');
        $optionInfoObj = M('option_info');

        $order = $orderObj->field('id,option_id,bond,ostyle,guadan_price,now_price,number')
                          ->where([
                              'id'     => $id,
                              'status' => 1,
                          ])
                          ->find();

        if (!$order) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $option = $optionObj->field('wave,capital_dot_length')
                            ->where(['id' => $order['option_id']])
                            ->find();

        $info = $optionInfoObj->where(['option_id' => $order['option_id']])
                              ->getField('capital_length');

        $wave = round($option['wave'] * $order['number'], 2);

        $point = ($order['bond'] / $wave) / $option['capital_dot_length'];

        $ostyle = $order['ostyle'];

        if ($ostyle == 1) {
            if ($order['now_price'] <= $order['guadan_price']) {
                $plossPrice  = $order['guadan_price'];
                $profitPrice = $order['now_price'];
            }
            else {
                $plossPrice  = $order['now_price'];
                $profitPrice = $order['guadan_price'];
            }
        }
        else {
            if ($order['now_price'] <= $order['guadan_price']) {
                $plossPrice  = $order['now_price'];
                $profitPrice = $order['guadan_price'];
            }
            else {
                $plossPrice  = $order['guadan_price'];
                $profitPrice = $order['now_price'];
            }
        }

        $upperLimit = 999999;   //上限
        $lowerLimit = self::lengthToNumber(1)[ $info['capital_length'] ]; //下限


        if ($ostyle == 1) {
            //止损
            if ($endloss < $plossPrice || $endloss > $upperLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_loss_error'),
                ]);
            }

            //止盈
            if ($endprofit > $profitPrice || $endprofit < $lowerLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_earnings_error'),
                ]);
            }
        }
        else {
            //止损
            if ($endloss > $plossPrice || $endloss < $lowerLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_loss_error'),
                ]);
            }

            //止盈
            if ($endprofit < $profitPrice || $endprofit > $upperLimit) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_earnings_error'),
                ]);
            }
        }

        $dataArr = [
            'endprofit' => $endprofit,
            'endloss'   => $endloss,
        ];

        $res = $orderObj->where([
            'id'     => $id,
            'status' => 1,
        ])
                        ->save($dataArr);
        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }


    /**
     * [followData 订单跟随]
     * @author wang li
     */
    public function followData()
    {
        $this->redirect('Index/profitAll');
    }

    /**
     * [changeOrder 跟随订单转自持]
     * @author wang li
     */
    public function changeOrder()
    {
        $oid = trim(I('post.oid'));

        if (empty($oid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $orderObj = M('order');

        $order = $orderObj->field('oid')
                          ->where([
                              'oid'        => $oid,
                              'ostaus'     => 0,
                              'order_type' => 2,
                              'uid'        => $this->user_id,
                          ])
                          ->find();

        if (!$order) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $res = $orderObj->where([
            'oid'        => $oid,
            'ostaus'     => 0,
            'order_type' => 2,
            'uid'        => $this->user_id,
        ])
                        ->setField('order_type', 1);

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }

    /**
     * [followDetails 跟随订单详情]
     * @author wang li
     */
    public function followDetails()
    {
        $oid = trim(I('get.oid'));    //订单id

        $orderObj      = M('order');
        $optionObj     = M('option');
        $optionInfoObj = M('option_info');

        $order = $orderObj->where([
            'oid'    => $oid,
            'ostaus' => 0,
        ])
                          ->find();    //跟随订单中必然是持仓的
        if (!$order) {
            $this->redirect('trade');
        }

        $option = $optionObj->field('wave,capital_dot_length,capital_key')
                            ->where(['id' => $order['pid']])
                            ->find();
        $info   = $optionInfoObj->field('capital_length')
                                ->where(['option_id' => $order['pid']])
                                ->find();


        $order['ostyleMsg']   = $order['ostyle'] == 0 ? L('api_buy') : L('api_sell');
        $order['ostyleColor'] = $order['ostyle'] == 0 ? 'bg_green' : 'bg_red';

        $order['endloss']   = sprintf("%.".$info['capital_length']."f", $order['endloss']);
        $order['endprofit'] = sprintf("%.".$info['capital_length']."f", $order['endprofit']);

        $order['buyprice']  = sprintf("%.".$info['capital_length']."f", $order['buyprice']);
        $order['sellprice'] = sprintf("%.".$info['capital_length']."f", $order['sellprice']);

        if(LANG == 'en-us') {
            $order['option_name'] = $order['en_name'];
        } else if(LANG == 'zh-tw') {
            $order['option_name'] = simpleTradition($order['option_name']);
        }

        $this->assign('option', $option);
        $this->assign('info', $info);
        $this->assign('order', $order);
        $this->display();
    }


    /**
     * [setByFollowBalance 根据条件设置返还跟随费用]
     * @author wamg li
     */
    private function setByFollowBalance(array $data, array $order)
    {
        if ($data['order_result'] == 2 && !empty($order['follow_user_id']))    //只有盈利才会返回跟随费用
        {
            //跟随费用 = 订单盈利-过夜费*20%;
            //触发条件：每0.01手盈利大于0.5美元 公式(手数*50)

            $followObj   = M('order_follow');
            $accouontObj = M('accountinfo');
            $flowObj     = M('MoneyFlow');

            $conditionPrice = ($order['onumber'] * 50);

            if ($order['ploss'] > $conditionPrice) {
                $followPrice = round((($order['ploss'] - $order['overnight_fee']) * 20) / 100, 2);    //被跟随者费用

                $accouontObj->startTrans(); //开启事务

                //交易员
                $tradeArr = [
                    'balance'       => [
                        'exp',
                        '`balance`+'.$followPrice.'',
                    ],
                    'trader_profit' => [
                        'exp',
                        '`trader_profit`+'.$followPrice.'',
                    ],
                ];

                $trade_res = $accouontObj->where(['uid' => $order['follow_user_id']])
                                         ->save($tradeArr);

                if ($trade_res) {
                    //用户资金流水表
                    $map['uid']       = $order['follow_user_id'];
                    $map['type']      = 2;
                    $map['oid']       = $order['oid'];
                    $map['note']      = '跟随者对跟随订单'.$order['option_name'].'进行平仓增加跟随费用['.$followPrice.']美元';
                    $map['en_note']   = 'Follower to follower order '.$order['en_name'].' Increase follow-up costs by closing warehouses['.$followPrice.']Dollar';
                    $map['balance']   = $accouontObj->where(['uid' => $order['follow_user_id']])
                                                    ->getField('balance');
                    $map['op_id']     = $order['follow_user_id'];
                    $map['user_type'] = 1;
                    $map['dateline']  = time();
                    $flowObj->add($map);
                }


                //普通用户
                $userArr  = [
                    'balance'       => [
                        'exp',
                        '`balance`-'.$followPrice.'',
                    ],
                    'follow_profit' => [
                        'exp',
                        '`follow_profit`+'.$order['ploss'].'',
                    ],
                ];
                $user_res = $accouontObj->where(['uid' => $order['uid']])
                                        ->save($userArr);

                $follow_res = $followObj->where([
                    'user_id'        => $order['uid'],
                    'follow_user_id' => $order['follow_user_id'],
                ])
                                        ->setInc('follow_profit', $order['ploss']);

                if ($user_res && $follow_res) {
                    //用户资金流水表
                    $map['uid']       = $order['uid'];
                    $map['type']      = 2;
                    $map['oid']       = $order['oid'];
                    $map['note']      = '对跟随订单'.$order['option_name'].'进行平仓扣除跟随费用['.$followPrice.']美元';
                    $map['en_note']   = 'Follow-up orders '.$order['en_name'].'Open the warehouse and deduct follow-up costs['.$followPrice.']Dollar';
                    $map['balance']   = $accouontObj->where(['uid' => $order['uid']])
                                                    ->getField('balance');
                    $map['op_id']     = $order['uid'];
                    $map['user_type'] = 1;
                    $map['dateline']  = time();
                    $flowObj->add($map);
                }

                try {
                    if ($trade_res && $user_res && $follow_res) {
                        $accouontObj->commit();
                    }
                    else {
                        $accouontObj->rollback();
                    }
                } catch (Exception $e) {
                    $accouontObj->rollback();
                }
            }
        }
    }


    /**
     * [followOrder 处理跟随者订单]
     * @author wang li
     */
    private function followOrder(array $order)
    {
        $orderObj  = M('order');
        $followObj = M('order_follow');

        $id = $followObj->where(['follow_user_id' => $order['uid']])
                        ->getField('id');    //只要有数据就一定当过交易员(包括撤销)
        if ($id) {
            $where = [
                'order_type'      => 2,
                'follow_user_id'  => $order['uid'],
                'pid'             => $order['pid'],
                'follow_order_id' => $order['oid'],
                'ostaus'          => 0,
                'type'            => 1,
            ];

            $data = $orderObj->where($where)
                             ->select();

            if ($data) {
                foreach ($data as &$value) {

                    $value['selltime']  = $order['selltime'];
                    $value['sellprice'] = $order['sellprice'];

                    $this->setFollowOrder($value);
                }
            }
        }
    }

    /**
     * [autoOrder 自动晒单]
     * @author wang li
     */
    private function autoOrder(float $ploss, int $user_id, int $order_id)
    {
        if ($ploss > 0) {
            $userObj = M('userinfo');

            $auto = $userObj->where(['uid' => $user_id])
                            ->getField('auto_order');

            if ($auto == 1) {
                $dataArr = [
                    'order_id'    => $order_id,
                    'user_id'     => $user_id,
                    'create_time' => time(),
                ];

                $publishObj = M('publish');
                $publishObj->add($dataArr);
            }
        }
    }


    /**
     * [setFollowOrder 对跟随的订单进行平仓处理]
     * @author wang li
     */
    public function setFollowOrder($order)
    {
        $orderObj   = M('order');
        $accountObj = M('accountinfo');
        $optionObj  = M('option');


        $option = $optionObj->field('wave,capital_dot_length')
                            ->where(['id' => $order['pid']])
                            ->find();

        $wave = round($option['wave'] * $order['onumber'], 2);

        $orderObj->startTrans(); //开启事务

        if ($order['ostyle'] == 0) {

            /*********************禁止爆仓***************************/
            $ploss = (($order['sellprice'] - $order['buyprice']) * $wave) * $option['capital_dot_length'];

            if ($ploss > $order['Bond']) {
                $data['sellprice'] = $order['buyprice'] + (($order['Bond'] / $wave) / $option['capital_dot_length']);
                $data['ploss']     = $order['Bond'];
            }
            elseif ($ploss < -$order['Bond']) {
                $data['sellprice'] = $order['buyprice'] - (($order['Bond'] / $wave) / $option['capital_dot_length']);
                $data['ploss']     = -$order['Bond'];
            }
            else {
                $data['sellprice'] = $order['sellprice'];
                $data['ploss']     = $ploss;
            }
            /*************************************************/

        }
        else {

            /*********************禁止爆仓***************************/
            $ploss = (($order['buyprice'] - $order['sellprice']) * $wave) * $option['capital_dot_length'];

            if ($ploss > $order['Bond']) {
                $data['sellprice'] = $order['buyprice'] - (($order['Bond'] / $wave) / $option['capital_dot_length']);
                $data['ploss']     = $order['Bond'];
            }
            elseif ($ploss < -$order['Bond']) {
                $data['sellprice'] = $order['buyprice'] + (($order['Bond'] / $wave) / $option['capital_dot_length']);
                $data['ploss']     = -$order['Bond'];
            }
            else {
                $data['sellprice'] = $order['sellprice'];
                $data['ploss']     = $ploss;
            }
            /*************************************************/
        }

        $data['selltime'] = $order['selltime'];
        $data['ostaus']   = 1;
        $data['auto']     = 1;

        if ($data['ploss'] == 0) {
            $data['order_result'] = 1;
        }
        elseif ($data['ploss'] > 0) {
            $data['order_result'] = 2;
        }
        else {
            $data['order_result'] = 3;
        }


        $ostaus = $orderObj->where([
            'oid'    => $order['oid'],
            'ostaus' => 0,
            'uid'    => $order['uid'],
        ])
                           ->save($data);

        if ($ostaus) {
            $data['ploss'] = round($data['ploss'], 2);

            $money = ($order['Bond'] + $data['ploss']);  //保证金+盈亏
            if ($order['type'] == 1)    //如果为实盘交易
            {
                //设置运营中心 (盈亏)
                $exchangeId = exchange($order['uid'], 2);

                $yingkui = $data['ploss'] < 0 ? (abs($data['ploss'])) : -$data['ploss'];

                $accountObj->where(['uid' => $exchangeId])
                           ->setInc('balance', $yingkui);                        //修改运营中心金额

                $account        = $accountObj->where(['uid' => $order['uid']])
                                             ->setInc('balance', $money);    //修改用户金额
                $surplusBalance = $accountObj->where(['uid' => $order['uid']])
                                             ->getField('balance');

                if ($surplusBalance) {
                    if ($yingkui < 0) {
                        $accountObj->where(['uid' => $order['uid']])
                                   ->setInc('income_total', abs($yingkui));    //修改用户总盈利
                    }
                    else {
                        $accountObj->where(['uid' => $order['uid']])
                                   ->setInc('loss_total', abs($yingkui));    //修改用户总亏损
                    }
                }

            }
            else {
                $account        = $accountObj->where(['uid' => $order['uid']])
                                             ->setInc('gold', $money);     //修改用户金币
                $surplusBalance = $accountObj->where(['uid' => $order['uid']])
                                             ->getField('gold');
            }

            if ($ostaus) {

                $orderObj->commit();
                if ($order['type'] == 1) {
                    //添加资金流水
                    $this->balanceFlow($order['uid'], $order['oid'], $order['option_name'], $money, $surplusBalance, $exchangeId, $yingkui);

                    //处理交易员以及跟随者
                    /**********************************/
                    $order = $orderObj->where(['oid' => $order['oid']])
                                      ->find();
                    $this->setByFollowBalance($data, $order);
                    $this->autoOrder($data['ploss'], $order['uid'], $order['oid']);
                    /**********************************/
                }
            }
            else {

                $orderObj->rollback();

                return false;
            }

        }
        else {
            return false;
        }
    }


    /**
     * tradeByUser 根据用户显示跟随订单
     * @author wang li
     */
    public function tradeByFloowUser()
    {
        $uid = trim(I('get.uid'));

        $user = M('userinfo')
            ->field('uid,nickname,username')
            ->where(['uid' => $uid])
            ->find();

        $this->assign('user', $user);
        $this->display();
    }

    //设置最小点值
    private function lengthToNumber($num)
    {
        $numberArr    = [];
        $numberArr[0] = $num;
        $numberArr[1] = '0.'.$num;
        $numberArr[2] = '0.0'.$num;
        $numberArr[3] = '0.00'.$num;
        $numberArr[4] = '0.000'.$num;
        $numberArr[5] = '0.0000'.$num;
        $numberArr[6] = '0.00000'.$num;
        $numberArr[7] = '0.000000'.$num;

        return $numberArr;
    }

}