<?php
namespace Home\Controller;

use Think\Controller;

class MessageController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }

    /**
     * [index 系统消息]
     * @author wang li
     */
    public function index()
    {
        $flowObj    = M('money_flow');
        $stretchObj = M('SiteStretch');

        $dataType = [
            1 => L('api_position'),
            2 => L('api_close_position'),
            3 => L('api_withdrawal'),
            4 => L('api_recharge'),
            5 => L('api_commission'),
            7 => L('api_cancel_order'),
        ];

        $sqlWhere = " YEARWEEK(FROM_UNIXTIME(dateline,'%Y-%m-%d'),1) = YEARWEEK(DATE_FORMAT(now(),'%Y-%m-%d'),1) and uid={$this->user_id}";

        $list = $flowObj->field('id,type,note,en_note,dateline,is_read')
                        ->where($sqlWhere)
                        ->order('dateline desc')
                        ->select();


        foreach ($list as $key => $value) {
            $list[ $key ]['msg']  = $dataType[ $value['type'] ];
            $list[ $key ]['time'] = date('Y/m/d H:i:s', $value['dateline']);

            if(LANG == 'zh-tw') {
                $list[$key]['note'] = simpleTradition($value['note']);
            } else if(LANG == 'en-us') {
                $list[$key]['note'] = $value['en_note'];
            }

        }

        $stretch = $stretchObj->field('dateline,start_time,end_time')
                              ->select();
        $time    = time();
        $status  = 0;

        foreach ($stretch as $key => $value) {
            if ($time >= $value['start_time'] && $time <= $value['end_time']) {
                $status = 1;
            }
        }

        //一次性处理该用户所有未读消息
        if ($this->NoreadCount > 0) {
            $flowObj->where([
                'uid'     => $this->user_id,
                'is_read' => 1,
            ])
                    ->setField('is_read', 2);
        }


        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * [publicMsg 公告信息]
     * @author  wang li
     */
    public function publicMsg()
    {
        $stretchObj = M('SiteStretch');

        $list = $stretchObj->field('id,title,content,dateline,start_time,end_time')
                            ->where(['lang' => LANG_SHOW])
                           ->order('dateline desc')
                           ->select();

        $time   = time();
        $status = 0;

        foreach ($list as $key => $value) {
            $list[ $key ]['time']    = date('Y/m/d H:i:s', $value['dateline']);
            $list[ $key ]['content'] = mb_substr(trim(htmlspecialchars_decode($value['content'])), 0, 80, 'UTF-8').' ...';

            if(LANG == 'zh-tw') {
                $list[ $key ]['title']   = simpleTradition($value['title']);
                $list[ $key ]['content'] = simpleTradition($list[ $key ]['content']);
            }

            if ($time >= $value['start_time'] && $time <= $value['end_time']) {
                $list[ $key ]['class'] = '';
                $status                = 1;
            }
            else {
                $list[ $key ]['class'] = 'isread';
            }
        }

        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * stretchDetails 系统消息详情
     * @author wang li
     */
    public function stretchDetails()
    {
        $id   = trim(I('get.id'));
        $flow = M('money_flow')
            ->where('id='.$id)
            ->find();

        $dataType = [
            1 => L('api_position'),
            2 => L('api_close_position'),
            3 => L('api_withdrawal'),
            4 => L('api_recharge'),
            5 => L('api_commission'),
            7 => L('api_cancel_order'),
        ];

        $flow['msg'] = $dataType[ $flow['type'] ];

        //判断消息类型 如果为持仓或平仓或撤单则显示详情 1持仓,2平仓,7撤单
        if ($flow['type'] == 1 || $flow['type'] == 2 || $flow['type'] == 7) {
            $order           = M('order')
                ->where('oid='.$flow['oid'])
                ->find();
            $order['ostyle'] = $order['ostyle'] == 0 ? L('api_buy') : L('api_sell');
        }

        if(LANG == 'zh-tw') {
            $flow['note']           = simpleTradition($flow['note']);
            $order['option_name']   = simpleTradition($order['option_name']);
        } else if(LANG == 'en-us') {
            $flow['note']           = $flow['en_note'];
            $order['option_name']   = $order['en_name'];
        }


        //如果消息是未读状态,则改变状态
        if ($flow['is_read'] == '1') {
            $data['is_read'] = '2';
            M('money_flow')
                ->where('id='.$id)
                ->save($data);
        }
        $this->assign('order', $order);
        $this->assign('flow', $flow);
        $this->display();
    }


    //判断是否登录
    private function IsLogin()
    {
        if (empty($this->user_id)) {
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
    }
}
