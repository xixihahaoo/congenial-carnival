<?php
// +----------------------------------------------------------------------
// | 商品控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Pc\Controller;

use Think\Controller;

class ProductController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();

        $this->user_id = session('user_id');
    }

    /**
     * [list 产品行情展示]
     * @author wang <[li]>
     * @date   2018/03/09 15:10
     */
    public function lists()
    {
        $optionObj   = M('option a');
        $classifyObj = M('OptionClassify');

        $prefix = C('DB_PREFIX');

        //展示所有产品
        $optionClass = $classifyObj->where(['level' => 1])
                                   ->field('id,name,en_name')
                                   ->order('sort asc')
                                   ->select();

        if (LANG == 'zh-tw') {
            foreach ($optionClass as &$val) {
                $val['name'] = simpleTradition($val['name']);
            }
        }
        elseif (LANG == 'en-us') {
            foreach ($optionClass as &$val) {
                $val['name'] = simpleTradition($val['en_name']);
            }
        }


        $field = 'a.id,a.capital_name,a.en_name,a.capital_key,a.option_key,a.pid,a.sp,a.bp,a.erence,b.capital_length';

        $option = $optionObj->field($field)
                            ->join('left join '.$prefix.'option_info b on a.id=b.option_id')
                            ->where(['a.global_flag' => 1])
                            ->order('b.sort asc')
                            ->select();

        foreach ($option as $key => $value) {
            $option[ $key ]['sp'] = sprintf("%.".$value['capital_length']."f", $value['sp']);
            $option[ $key ]['bp'] = sprintf("%.".$value['capital_length']."f", $value['bp']);

            //点差处理
            $option[ $key ]['difference'] = $value['erence'];

            if (LANG == 'zh-tw') {
                $option[ $key ]['capital_name'] = simpleTradition($value['capital_name']);
            }
            elseif (LANG == 'en-us') {
                $option[ $key ]['capital_name'] = $value['en_name'];
            }
        }


        foreach ($option as $key => $value) {
            switch ($value['pid']) {
                case 6: //外汇
                    $data['exchange'][] = $value;
                    break;
                case 7: //大宗商品
                case 8:
                    $data['metal'][] = $value;
                    break;
                case 9: //数字货币
                    $data['currency'][] = $value;
                    break;
                case 10: //指数
                    $data['honkong'][] = $value;
                    break;
                default:
                    # code...
                    break;
            }
        }


        //展示自选产品
        $selfData = $optionObj->field($field)
                              ->where('exists(select b.option_id from '.$prefix.'user_option c where a.id=c.option_id and c.user_id='.$this->user_id.') and a.global_flag=1')
                              ->join('left join '.$prefix.'option_info b on a.id=b.option_id')
                              ->order('b.sort asc')
                              ->select();

        foreach ($selfData as $key => $value) {
            $selfData[ $key ]['sp'] = sprintf("%.".$value['capital_length']."f", $value['sp']);
            $selfData[ $key ]['bp'] = sprintf("%.".$value['capital_length']."f", $value['bp']);

            //点差处理
            $selfData[ $key ]['difference'] = $value['erence'];

            if (LANG == 'zh-tw') {
                $selfData[ $key ]['capital_name'] = simpleTradition($value['capital_name']);
            }
            elseif (LANG == 'en-us') {
                $selfData[ $key ]['capital_name'] = $value['en_name'];
            }
        }

        //展示关注产品
        $this->listOption();


        $index = trim(I('get.index'));  //获得行情列表所属位置
        $index = empty($index) ? 0 : $index;

        $this->assign('index', $index);
        $this->assign('selfData', $selfData);
        $this->assign('data', $data);
        $this->assign('option', $option);
        $this->assign('optionClass', $optionClass);
        $this->display();
    }


    /**
     * [selfOptionDel 删除自选产品]
     * @param  [int] $[option_id] [产品编号]
     * @return [array] [产品状态]
     * @author [wang] <[li]>
     */
    public function selfOptionDel()
    {
        $this->isLogin();

        $option_id = trim(I('post.option_id'));

        if (empty($option_id)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_product_no'),
            ]);
        }

        $userOptionObj = M('UserOption');

        $res = $userOptionObj->where([
            'option_id' => $option_id,
            'user_id'   => $this->user_id,
        ])
                             ->delete();
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
     * [listOption 展示自选产品]
     * @return string [返回自选产品信息]
     * @param int $[pid] [产品分类id]
     * @author wang <[li]>
     * @date   2018/03/10 14:00
     */
    public function listOption()
    {
        //获取二级分类
        $pidStr = M('option_classify')
            ->where('level=2')
            ->getField('group_concat( distinct id)');


        $map['pid']         = [
            'in',
            $pidStr,
        ];
        $map['global_flag'] = 1;

        $optionObj     = M('option a');
        $userOptionObj = M('UserOption');
        $prefix        = C('DB_PREFIX');

        $field = 'a.id,a.capital_name,a.en_name,a.option_key,a.pid,a.sp,a.bp,b.capital_length';

        $selfData = $optionObj->field($field)
                              ->where($map)
                              ->join('left join '.$prefix.'option_info b on a.id=b.option_id')
                              ->order('b.sort asc')
                              ->select();

        $userData = $userOptionObj->where(['user_id' => $this->user_id])
                                  ->getField('option_id,option_id,user_id', true);

        foreach ($selfData as $key => $value) {
            $selfData[ $key ]['sp'] = sprintf("%.".$value['capital_length']."f", $value['sp']);
            $selfData[ $key ]['bp'] = sprintf("%.".$value['capital_length']."f", $value['bp']);

            if ($userData[ $value['id'] ]['option_id'] == $value['id']) {
                $selfData[ $key ]['status'] = 1;
            }

            if (LANG == 'zh-tw') {
                $selfData[ $key ]['capital_name'] = simpleTradition($value['capital_name']);
            }
            elseif (LANG == 'en-us') {
                $selfData[ $key ]['capital_name'] = $value['en_name'];
            }
        }

        $listData = [];

        foreach ($selfData as $key => $value) {
            switch ($value['pid']) {
                case 6: //外汇
                    $listData['exchange'][] = $value;
                    break;
                case 7: //大宗商品
                case 8:
                    $listData['metal'][] = $value;
                    break;
                case 9: //数字货币
                    $listData['currency'][] = $value;
                    break;
                case 10: //指数
                    $listData['honkong'][] = $value;
                    break;
                default:
                    # code...
                    break;
            }
        }

        $this->assign('listData', $listData);
    }

    /**
     * [addUserOption 添加自选产品]
     * @return string [返回响应信息]
     * @param int $[pid] [产品分类id]
     * @param int $[id] [自选产品id]
     * @author wang <[li]>
     * @date   2018/03/10 14:00
     */
    public function addUserOption()
    {
        if (IS_POST) {
            $this->isLogin();

            $id = trim(I('post.id'));

            $userOptionObj = M('UserOption');
            $optionObj     = M('option');

            $userOptionObj->where(['user_id' => $this->user_id])
                          ->delete();

            $option = M('option')
                ->field('id,pid')
                ->where('id in('.$id.')')
                ->select();

            foreach ($option as $key => $value) {
                $data[ $key ]['user_id']     = $this->user_id;
                $data[ $key ]['pid']         = $value['pid'];
                $data[ $key ]['option_id']   = $value['id'];
                $data[ $key ]['create_time'] = time();
            }

            $res = $userOptionObj->addAll($data);

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
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }

    /**
     * [details 产品详信息]
     * @author wang <[li]>
     */
    public function details()
    {
        $optionObj     = M('option');
        $optionInfoObj = M('option_info');
        $accouontObj   = M('accountinfo');
        $userObj       = M('userinfo');

        $id = trim(I('get.id'));

        $option = $optionObj->where(['id' => $id])
                            ->find();
        $info = $optionInfoObj->field('bond,capital_length,contract_number,coefficient,fee_time')
                              ->where(['option_id' => $id])
                              ->find();

        $option['Price'] = sprintf("%.".$info['capital_length']."f", $option['Price']);
        $option['sp']    = sprintf("%.".$info['capital_length']."f", $option['sp']);
        $option['bp']    = sprintf("%.".$info['capital_length']."f", $option['bp']);

        $option['Diff']     = round(($option['Diff'] >= 0 ? '+'.$option['Diff'] : $option['Diff']),2);
        $option['DiffRate'] = $option['DiffRate'] >= 0 ? '+'.$option['DiffRate'] : $option['DiffRate'];

        if (LANG == 'en-us') {
            $option['capital_name'] = $option['en_name'];
        }
        elseif (LANG == 'zh-tw') {
            $option['capital_name'] = simpleTradition($option['capital_name']);
        }


        //点差处理
        $option['difference'] = $option['erence'];

        //设置止盈止损默认50点差
        $option['defaultPoint'] = $info['coefficient'] * 1000;

        //时间盘手续费比例
        $option['fee_time'] = $info['fee_time'];

        $account = $accouontObj->field('balance')
                               ->where(['uid' => $this->user_id])
                               ->find();

        $prefix = C('DB_PREFIX');

        //自选产品
        $optionAll = M('option a')
            ->field('a.capital_name,a.en_name,a.capital_key,a.id,a.Price,c.capital_length')
            ->where('exists(select user_id from '.$prefix.'user_option b where a.id = b.option_id and b.user_id='.$this->user_id.')')
            ->join('left join '.$prefix.'option_info c on a.id=c.option_id')
            ->select();

        foreach ($optionAll as $key => $value) {
            $optionAll[ $key ]['price'] = sprintf("%.".$value['capital_length']."f", $value['Price']);

            if (LANG == 'en-us') {
                $optionAll[ $key ]['capital_name'] = $value['en_name'];
            }
            elseif (LANG == 'zh-tw') {
                $optionAll[ $key ]['capital_name'] = simpleTradition($value['capital_name']);
            }
        }

        //当前交易状态
        $now_trade_status = $userObj->where(['uid' => $this->user_id])
                                    ->getField('now_trade_status');

        //最新订单成交信息
        $orderObj = M('order a');
        $dealMsg  = $orderObj->field('a.option_name,en_name,a.ostyle,a.onumber,a.buytime,b.nickname')
                             ->join('left join '.$prefix.'userinfo b on a.uid=b.uid')
                             ->where([
                                 'type'   => 1,
                                 'ostaus' => 0,
                             ])
                             ->order('oid desc')
                             ->limit(5)
                             ->select();
        foreach ($dealMsg as $key => $value) {
            $dealMsg[ $key ]['time']   = format_date($value['buytime']);
            $dealMsg[ $key ]['ostyle'] = $value['ostyle'] == 0 ? L('buy') : L('sell');
            if (LANG == 'en-us') {
                $dealMsg[ $key ]['option_name'] = $value['en_name'];
            }
            elseif (LANG == 'zh-tw') {
                $dealMsg[ $key ]['option_name'] = simpleTradition($value['option_name']);
            }
        }


        //时间盘交易参数
        $parameter = M('option_parameter')
            ->where([
                'option_id' => $id,
                'flag'      => 0,
            ])
            ->select();
        $this->assign('parameterCount', count($parameter));
        $this->assign('parameter', $parameter);
        $this->assign('index', trim(I('get.index')));
        $this->assign('dealMsg', $dealMsg);
        $this->assign('now_trade_status', $now_trade_status);
        $this->assign('optionAll', $optionAll);
        $this->assign('account', $account);
        $this->assign('option', $option);
        $this->assign('info', $info);
        $this->display();
    }


    /**
     * [playIntroduce 产品玩法介绍]
     * @author wang <[li]>
     */
    public function playIntroduce()
    {
        $pid           = trim(I('get.pid'));
        $optionPlayObj = M('OptionPlay');

        $content = $optionPlayObj->where([
            'option_id' => $pid,
            'lang'      => LANG_SHOW,
        ])
                                 ->getField('content');

        if (LANG == 'zh-tw') {
            $content = simpleTradition($content);
        }

        $content = htmlspecialchars_decode($content);

        $this->assign('content', $content);
        $this->display();
    }


    public function highcharts()
    {

        $data = I('get.');

        $this->assign('code', $data['code']);
        $this->assign('interval', $data['interval']);
        $this->assign('type', $data['type']);
        $this->assign('height', $data['height']);
        $this->assign('length', $data['length']);

        $prefix = C('DB_PREFIX');

        $option = M('OptionClassify a')
            ->where("exists(select b.pid from {$prefix}option b where a.id = b.pid and b.capital_key = '{$data['code']}')")
            ->find();

//        if ($option['id'] == 10) //10为港股美股
//        {
//            $this->display('hsicharts');
//
//            return;
//        }

        if($data['interval'] == 'fenshi') //分时图
        {
            $this->display('hsicharts');
            return;
        }

        $this->display();
    }

    /**
     * [isLogin 检测是否登录]
     * @return boolean [description]
     */
    private function isLogin()
    {
        if (!$this->user_id) {
            outjson([
                'code' => 400,
                'msg'  => L('no_login'),
            ]);
        }
    }

    /**
     * 获取订单信息
     * @author 王海东
     * @date   2019/8/7
     * @return void
     */
    public function order_details()
    {
        $this->isLogin();

        $order_id = trim(I('post.order_id'));

        if (empty($order_id)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        $map['oid']         = $order_id;
        $map['order_scene'] = 2;

        $order = M('order')
            ->field('ostyle,Bond,buyprice,sellprice,ploss,finirm_time,option_name,en_name,ostaus,order_result')
            ->where($map)
            ->find();

        if(!$order) {
            outjson([
                'code' => 400,
                'msg'  => L('api_order_no'),
            ]);
        }

        if($order['ostyle'] == '0') {
            $order['ostyle_name'] = L('buy');
        } else {
            $order['ostyle_name'] = L('sell');
        }

        if(LANG == 'zh-tw') {
            $order['option_name'] = simpleTradition($order['option_name']);
        } else if(LANG == 'en-us') {
            $order['option_name'] = $order['en_name'];
        }

        if($order['ostaus'] == 1) {
            if($order['order_result'] == 1 || $order['order_result'] == 2) {
                $order['ploss'] = $order['Bond'] + $order['ploss'];
            }
        }

        $order['time'] = strtotime($order['finirm_time']) - time();

        outjson([
            'code' => 200,
            'msg'  => L('api_success'),
            'data' => $order,
        ]);
    }
}