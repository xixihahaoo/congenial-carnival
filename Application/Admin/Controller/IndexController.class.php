<?php

namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index()
    {
        header("Content-type: text/html; charset=utf-8");
        $user= A('Admin/User');
        $user->checklogin();

        $where = [
            'uid' => islogin(),
            'ustatus' => 0,
        ];

        $userinfo = M('userinfo')
            ->where($where)
            ->field("username,lastlog,last_login_ip,is_admin")
            ->find();

        if($userinfo['is_admin'] == 1) {
            $userinfo['lastlog'] = date('Y-m-d H:i:s',$userinfo['lastlog']);
            $this->assign('userinfo',$userinfo);
            $this->display('indexs');

        } else {

            $arr = array();
            //运营中心
            $extend_count = M("userinfo")->where(array('otype' => 5))->count();
            $this->assign("extend_count",$extend_count);

            //经纪人
            $agent_count = M("userinfo")->where(array('otype' => 6))->count();
            $this->assign("agent_count",$agent_count);

            //用户
            $user_count = M("userinfo")->where(array('otype' => 4))->count();
            $this->assign('user_count',$user_count);
            $this->assign('date',date('Y-m-d',time()));

            //最近7天的订单
            $order_count = M("order")->where('DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= FROM_UNIXTIME(buytime,"%Y-%m-%d") and type = 1')->count();
            $this->assign('order_count',$order_count);

            //今天的订单
            $day_count = M("order")->where('TO_DAYS(FROM_UNIXTIME(buytime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and type = 1 ')->count();
            $this->assign('day_count',$day_count);

            //最近30天交易总额
            $order = M("order")->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= FROM_UNIXTIME(buytime,"%Y-%m-%d") and type = 1')->sum('bond');

            $this->assign('sum',number_format(abs($order),2));

            //最近30天提现总额
            $balance = M("withdraw")->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= FROM_UNIXTIME(c_time,"%Y-%m-%d") and status = 1')->sum('amount');
            $this->assign('balance',number_format($balance,2));

            //最近30天充值总额
            $point = M("balance")->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= FROM_UNIXTIME(cltime,"%Y-%m-%d") and status = 1')->sum('bpprice');

            $this->assign('point',number_format($point,2));

            //总交易手数
            $onumber = M('order')->where(array('type' => 1))->count();
            $this->assign('onumber',$onumber);

            //总持仓盈亏
            $holdPloss = M('order')->where(array('type' => 1,'ostaus' => 0))->sum('ploss');
            $this->assign('holdPloss',$holdPloss);

            //总平仓盈亏
            $closePloss = M('order')->where(array('type' => 1,'ostaus' => 1))->sum('ploss');
            $this->assign('closePloss',$closePloss);

            //分页
            $pagecount = 6;
            $page = new \Think\Page($day_count , $pagecount);
            $page->setConfig('first','首页');
            $page->setConfig('prev','&#8249;');
            $page->setConfig('next','&#8250;');
            $page->setConfig('last','尾页');
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
            $show = $page->show();

            $prefix      = C('DB_PREFIX');

            $field = 'a.*,b.username';
            $orders = M("order a")->join('left join '.$prefix.'userinfo as b on a.uid = b.uid')->where('TO_DAYS(FROM_UNIXTIME(a.buytime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and a.type = 1')->order('a.oid desc')->limit($page->firstRow.','.$page->listRows)->select();

            $this->assign("orders",$orders);
            $this->assign('page',$show);
            $this->display();
        }

    }

   public function ws(){
       $return = file_get_contents("http://156.238.111.134:8888/hook?access_key=1vWML440EELUK3VjwTCNxcqYGGfyuiFM7FarUxNKucahMsZp");
       $this->ajaxReturn( json_encode($return),'JSON');
   }
}