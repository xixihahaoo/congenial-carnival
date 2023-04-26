<?php
// +----------------------------------------------------------------------
// | 戮颅录脥脠脣驴脴脰脝脝梅
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Admin\Controller;

class AgentController extends CommonController {

    /**
     * 戮颅录脥脠脣脕脨卤铆
     * @author wang <li>
     */
    public function index()
    {
        $row = array();
        if(I('get.phone')){

            $map['a.utel'] = array('like','%'.I('get.phone').'%');
            $this->assign('phone',I('get.phone'));
        }

        if(I('get.username')){

            $map['a.username'] = array('like','%'.I('get.username').'%');
            $this->assign('username',I('get.username'));
        }

        if(I('get.uid')){

            $map['b.parent_user_id'] = I('get.uid');
            $row['uid'] = I('get.uid');
            $this->assign('uid',I('get.uid'));
        }

        $map['a.otype'] = 6;
        $arr = array();

        $count = M("userinfo a")->join('left join wp_userinfo_relationship as b on a.uid = b.user_id')->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row;
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
        $agent = M("userinfo a")->join('left join wp_userinfo_relationship as b on a.uid = b.user_id')->where($map)->limit($page->firstRow,$page->listRows)->order('a.uid desc')->select();


        foreach ($agent as $k => $v) {

            array_push($arr, $v['parent_user_id']);
        }
        $userid = implode(',' ,array_unique($arr));

        $where['uid'] = array('in',$userid);
        $info = M("userinfo")->field('uid,username')->where($where)->select();
        foreach ($info as $key => $value) {

            $dd[$value['uid']]['name'] = $value['username'];
        }

        $this->assign('user',$dd);
        $this->assign('agent',$agent);
        $this->assign('count',$count);
        $this->assign('page',$show);
        $this->assign("extends",M("userinfo")->where(array('otype' => 5))->select());
        $this->display();
    }

    /**
     * 脧煤脢脹脡脤碌录鲁枚
     * @author wang li
     */
    public function daochu(){

        if(I('get.phone')){

            $map['a.utel'] = array('like','%'.I('get.phone').'%');
        }

        if(I('get.username')){

            $map['a.username'] = array('like','%'.I('get.username').'%');
        }

        if(I('get.uid')){
            $map['b.parent_user_id'] = I('get.uid');
        }

        $map['a.otype'] = 6;
        $arr = array();

        $agent = M("userinfo a")->join('left join wp_userinfo_relationship as b on a.uid = b.user_id')->where($map)->order('a.uid desc')->select();


        foreach ($agent as $k => $v) {

            array_push($arr, $v['parent_user_id']);
        }
        $userid = implode(',' ,array_unique($arr));

        $where['uid'] = array('in',$userid);
        $info = M("userinfo")->field('uid,username')->where($where)->select();
        foreach ($info as $key => $value) {

            $dd[$value['uid']]['name'] = $value['username'];
        }

        $data[0] = array('编号','用户名','昵称','手机号','注册时间','注册ip','登录时间','登录ip','所属运营中心');
        foreach($agent as $key=>$val)
        {
            $data[$key+1][] = $val['uid'];
            $data[$key+1][] = $val['username'];
             $data[$key+1][] = $val['nickname'];
            $data[$key+1][] = $val['utel'];
            $data[$key+1][] = date("Y-m-d H:i:s",$val['utime']);
            $data[$key+1][] = $val['reg_ip'];
            $data[$key+1][] = !empty($val['lastlog']) ? date("Y-m-d H:i:s",$val['lastlog']) : '尚未登录';
            $data[$key+1][] = !empty($val['last_login_ip']) ? $val['last_login_ip'] : '尚未登录';
            $data[$key+1][] = $dd[$val['parent_user_id']]['name'];
        }
        $name='销售商列表';
        $this->push($data,$name);
    }




    /**
     * 查看销售商资金统计详情
     * @uid 要查看的销售商心uid
     * return array json
     */
    public function show(){
        if(IS_AJAX){
            $uid = I('post.uid',0);
            if($uid < 1){
                $this->ajaxReturn(array('msg'=>'不存在该销售商','status'=>0));
            }

            $mObj       = M();
            $returnRs   = array();

            $userinfoRelationshipObj    = M('userinfo_relationship');

            //戮颅录脥脠脣脫脙禄搂脨脜脧垄
            $userinfoObj    = M('userinfo');
            $proxyInfoArr   = 'uid='.$uid;
            $proxyInfoRs    = $userinfoObj->where($proxyInfoArr)->find();
            $returnRs['username'] = $proxyInfoRs['username'];

            //脫脙禄搂
            $whereArr   = array(
                'parent_user_id'    => $uid
            );
            $userinfoRelationshipRs = $userinfoRelationshipObj->where($whereArr)->select();

            $userIdArr  = array();
            foreach($userinfoRelationshipRs as $k => $v)
            {
                array_push($userIdArr, $v['user_id']);
            }
            $userIdStr  = implode(',', array_unique($userIdArr));

            $userinfoWhereArr   = 'uid in ('.$userIdStr.')';

            $userinfoRs     = $userinfoObj->where($userinfoWhereArr)->select();
            $userinfoRs1    = array();
            foreach($userinfoRs as $k => $v)
            {
                $userinfoRs1[$v['uid']]    = $v;
            }
            $returnRs['user_total']= count($userinfoRs);

            //脨猫脪陋麓脫脮芒脌茂脤铆录脫脤玫录镁
            $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
            $orderRs            = $mObj->table('view_order')->where($userinfoWhereArr)->select();


            $totalFee   = array();
            $totalMoney = array();
            $totalCount = array();
            foreach($orderRs as $k =>$v)
            {
                $orderRs1[$v['oid']]    = $v;
                array_push($totalFee, $v['fee']);
                array_push($totalMoney, $v['ploss'] );
                array_push($totalCount, $v['Bond']+$v['fee']);
            }

            $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
            $returnRs['total_money']    = number_format(array_sum($totalMoney),2) ;
            $returnRs['total_count']    = number_format(array_sum($totalCount),2);
            $returnRs['order_total']    = count($orderRs);


            $data=array('msg'=>'资金详情','status'=>1,'data'=>$returnRs);

            $this->ajaxReturn($data,'JSON');

        }
        $this->error('您访问的地址不存在','/admin/index/index');
    }

    /**
     * 脤铆录脫戮颅录脥脠脣
     * @author wang <li>
     */
    public function add(){
        if(IS_AJAX){

            $data     = array();
            $parent_user_id  = trim(I('post.parent_user_id'));
            $username = trim(I('post.username'));
            $pwd      = trim(I('post.pwd'));
            $notpwd   = trim(I('post.notpwd'));
            $tel      = trim(I('post.tel'));
            
            if(empty($parent_user_id)){

                $data['status'] = 0;
                $data['msg']    = '请选择运营中心';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($username)){

                $data['status'] = 0;
                $data['msg']    = '用户名不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', $username)){

                $data['status'] = 0;
                $data['msg']    = '用户名不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($pwd)){

                $data['status'] = 0;
                $data['msg']    = '密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', trim($pwd))){

                $data['status'] = 0;
                $data['msg']    = '密码不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }

            if($notpwd != $pwd){

                $data['status'] = 0;
                $data['msg']    = '密码必须一致';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($tel)){

                $data['status'] = 0;
                $data['msg']    = '手机号码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            $userObj     = M('userinfo');

            if(!$userObj->field('uid')->where(array('uid' =>$parent_user_id))->find()){

                $data['status'] = 0;
                $data['msg']    = '运营中心不存在';
                $this->ajaxReturn($data,'JSON');
            }

            if($userObj->field('uid')->where('utel='.$tel.' and ustatus in("0,1") and otype=6')->find()){

                $data['status'] = 0;
                $data['msg']    = '该手机号已经存在';
                $this->ajaxReturn($data,'JSON');
            }
            
            if($userObj->field('uid')->where(array('username' => $username))->find()){

                $data['status'] = 0;
                $data['msg']    = '该用户名已经存在';
                $this->ajaxReturn($data,'JSON');
            }


            $map['username']        = $username;  //登录帐号
            $map['upwd']            = md5($pwd);
            $map['utel']            = $tel;
            $map['utime']           = time();
            $map['update_time']     = time();
            $map['otype']           = 6;
            $map['ustatus']         = 0;
            $map['nickname']        = '销售商'.$username;
            $map['reg_ip']          = get_client_ip();

            $result = $userObj->add($map);

            if($result){

                $acc['uid']     = $result;
                $acc['balance'] = 0.00;
                M('accountinfo')->add($acc);

                $where['user_id']           = $result;
                $where['parent_user_id']    = $parent_user_id;
                $where['all_path']          = $parent_user_id.'-'.$result;
                $res = M('UserinfoRelationship')->add($where);

                if($res){
                    $data['status'] = 1;
                    $data['msg']    = '注册成功';
                    $this->ajaxReturn($data,'JSON');
                } else {
                    $data['status'] = 0;
                    $data['msg']    = '注册失败';
                    $this->ajaxReturn($data,'JSON');
                }

            } else {
                $data['status'] = 0;
                $data['msg']    = '注册失败';
                $this->ajaxReturn($data,'JSON');
            }
        }

        $this->assign("extends",M("userinfo")->field('uid,username')->where(array('otype' => 5,'ustatus' => 0))->select());
        $this->display();
    }




    /**
     * 删除
     * @author wang <li>
     */
    public function agent_del(){

        $uid    = I('post.uid'); //userid
        $data   = array();

        $user = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $uid))->find();

        if($user)
        {
            $data['status'] = 0;
            $data['msg']    = '该销售商下还有用户';
            $this->ajaxReturn($data,'JSON');
        }


        $result = M('userinfo')->where(array('uid' => $uid,'otype' => 6))->delete();  //脝脮脥篓禄谩脭卤
        $del    = M("UserinfoRelationship")->where(array('user_id' => $uid))->delete();

        if($result && $del){

            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data,'JSON');
        } else{

            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data,'JSON');
        }
    }


    /*
     * 销售商出入金统计
     */
    public function tongji() {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $yunying   = trim(I('get.yunying')); //运营中心
        $jingjiren = trim(I('get.jingjiren')); //经纪人

        $utel     = trim(I('get.utel')); //手机号码
        $username = trim(I('get.username')); //用户名
        $nickname = trim(I('get.nickname')); //昵称
        $uid      = trim(I('get.uid')); //编号

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

        if ($yunying) {
            $relation     = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();

            $relationArr  = array();
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $userId = implode(',', array_unique($relationArr));

            $map['a.uid']   = array('in', $userId);

            $sea['yunying'] = $yunying;
            $this->assign('yunying', $yunying);
        }

        //销售商
        if ($jingjiren) {
            $map['a.uid']     = $jingjiren;
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren', self::get_username($jingjiren));
        }


        if ($utel) {
            $map['a.utel'] = $utel;
            $sea['utel']   = $utel;
            $this->assign('utel', $utel);
        }

        if ($username) {
            $map['a.username'] = $username;
            $sea['username']   = $username;
            $this->assign('username', $username);
        }

        if ($nickname) {
            $map['a.nickname'] = $nickname;
            $sea['nickname']   = $nickname;
            $this->assign('nickname', $nickname);
        }

        if ($uid) {
            $map['a.uid'] = $uid;
            $sea['uid']   = $uid;
            $this->assign('uid', $uid);
        }

        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['a.utime']   = array('between', '' . $start_time .
                                     ',' . $end_time . '');
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        $map['otype'] = 6;

        $prefix = C('DB_PREFIX');

        $count = M('userinfo a')
            ->join('left join ' . $prefix .
                'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->count();


        //分页
        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme',
            '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');

        $show = $page->show();

        $field      = 'a.*,b.recharge_total,b.money_total,b.balance';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join ' . $prefix .
                'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('utime desc')
            ->select();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[$k]['net_gold'] = number_format($v['recharge_total'] - $v['money_total'], 2);
        }

        //底部出入金统计
        $tongji = M('userinfo a')
            ->field($field)
            ->join('left join ' . $prefix .
                'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->select();
        foreach ($tongji as $key => $value)
        {
            $data['recharge_total'] += $value['recharge_total'];
            $data['money_total'] += $value['money_total'];
            $data['balance'] += $value['balance'];
        }

        $data['net_gold'] = number_format($data['recharge_total'] - $data['money_total'],2);


        $this->assign('data',$data);
        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('page', $show);
        $this->assign('sea', $sea);
        $this->assign('info', M('userinfo')->where(array('otype' => 5))->select());
        $this->display();
    }


    //资金统计导出
    public function tongji_daochu()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $yunying   = trim(I('get.yunying')); //运营中心
        $jingjiren = trim(I('get.jingjiren')); //经纪人

        $utel     = trim(I('get.utel')); //手机号码
        $username = trim(I('get.username')); //用户名
        $nickname = trim(I('get.nickname')); //昵称
        $uid      = trim(I('get.uid')); //编号

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

        if ($yunying) {
            $relation     = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();

            $relationArr  = array();
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $userId = implode(',', array_unique($relationArr));

            $map['a.uid']   = array('in', $userId);
        }

        //销售商
        if ($jingjiren) {
            $map['a.uid']     = $jingjiren;
        }


        if ($utel) {
            $map['a.utel'] = $utel;
        }

        if ($username) {
            $map['a.username'] = $username;
        }

        if ($nickname) {
            $map['a.nickname'] = $nickname;
        }

        if ($uid) {
            $map['a.uid'] = $uid;
        }

        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['a.utime']   = array('between', '' . $start_time . ',' . $end_time . '');
        }

        $map['otype'] = 6;

        $prefix = C('DB_PREFIX');


        $field      = 'a.*,b.recharge_total,b.money_total,b.balance';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join ' . $prefix .
                'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->order('utime desc')
            ->select();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[$k]['net_gold'] = number_format($v['recharge_total'] - $v['money_total'], 2);
        }

        $data[0] = array('编号ID', '销售商名称', '手机号码','销售商昵称', '注册时间', '总入金', '总出金', '净入金','累计佣金','当前资金');
        foreach ($userinfoRs as $k => $v) {
            $data[$k + 1][] = $v['uid'];
            $data[$k + 1][] = $v['username'];
            $data[$k + 1][] = $v['utel'];
            $data[$k + 1][] = $v['nickname'];
            $data[$k + 1][] = date("Y-m-d H:i:s", $v['utime']);
            $data[$k + 1][] = number_format($v['recharge_total'], 2);
            $data[$k + 1][] = number_format($v['money_total'], 2);
            $data[$k + 1][] = number_format($v['net_gold'], 2);
            $data[$k + 1][] = number_format($v['fee_profit'], 2);
            $data[$k + 1][] = number_format($v['balance'], 2);
        }
        $name = '销售商出入金统计'; //生成的Excel文件文件名
        $this->push($data, $name);
    }





    private function get_username($uid = 0) {
        $info = M("userinfo")->field('uid,username')->where(array('uid'
                                                                  => $uid))->find();
        return $info ? $info : null;
    }

    private function push($data,$name){

        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }

}