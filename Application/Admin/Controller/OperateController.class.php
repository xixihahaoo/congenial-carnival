<?php
// +----------------------------------------------------------------------
// | 运营中心控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
class OperateController extends CommonController {

    /**
     * 运营中心列表
     * @author wang <li>
     */
    public function index()
    {
        if(I('get.phone')){

            $map['a.utel'] = array('like','%'.I('get.phone').'%');
            $this->assign('phone',I('get.phone'));
        }

        if(I('get.username')){

            $map['a.username'] = array('like','%'.I('get.username').'%');
            $this->assign('username',I('get.username'));
        }

        $map['a.otype'] = 5;
        
        $userObj = M('userinfo a');
        $prefix  = C('DB_PREFIX');


        $count = $userObj->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row;
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $user = $userObj->field('a.*,b.balance,b.gold_threshold,b.frozen_threshold')->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')->where($map)->order('a.uid desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('user',$user);
        $this->assign('count',$count);
        $this->assign('page',$show);
        $this->display();
    }

    /**
     * 查看运营中心资金统计详情
     * @uid 要查看的运营中心uid
     */
    public function show(){
        if(IS_AJAX){
            $uid = I('post.uid',0);
            if($uid <1) $this->ajaxReturn(array('msg'=>'不存在该运营中心','status'=>0));
            $mObj       = M();
            $returnRs   = array();

            $userinfoRelationshipObj    = M('userinfo_relationship');

            //运营中心用户信息
            $userinfoObj    = M('userinfo');
            $proxyInfoArr   = 'uid='.$uid;
            $proxyInfoRs    = $userinfoObj->where($proxyInfoArr)->find();
            $returnRs['username'] = $proxyInfoRs['username'];

            //经纪人
            $whereArr   = array(
                'parent_user_id'    => $uid
            );
            $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

            $agentIdArr = array();
            foreach($agentinfoRelationshipRs as $k => $v)
            {
                array_push($agentIdArr, $v['user_id']);
            }
            $agentIdStr  = implode(',', array_unique($agentIdArr));

            $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

            $agentinfoRs    = $userinfoObj->where($agentinfoWhereArr)->select();
            $agentinfoRs1   = array();
            foreach($agentinfoRs as $k => $v)
            {
                $agentinfoRs1[$v['uid']]    = $v;
            }
            $returnRs['agent_total']= count($agentinfoRs);

            //用户
            $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();
            $returnRs['user_total'] = count($userinfoRelationshipRs);

            $userIdArr      = array();
            $userRelArr     = array();
            foreach($userinfoRelationshipRs as $k => $v)
            {
                array_push($userIdArr, $v['user_id']);
                $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
            }
            $userIdStr      = implode(',', array_unique($userIdArr));

            //vD($userIdStr);


            //需要从这里添加条件
            $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
            $orderRs            = $mObj->table('view_order')->where($userinfoWhereArr)->select();

            $totalMoney = array();

            foreach($orderRs as $k =>$v)
            {
                array_push($totalMoney, $v['ploss'] );

            }

            $returnRs['total_money']    = number_format(array_sum($totalMoney),2);
            

            //总金额  手续费  订单个数
            $orderFee            = $mObj->table('view_order')->where($userinfoWhereArr)->select();

            $totalFee   = array();
            $totalCount = array();

            foreach ($orderFee as $key => $v) {
                array_push($totalFee, $v['fee']);
                array_push($totalCount, $v['Bond']+$v['fee']);
            }

            $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
            $returnRs['total_count']    = number_format(array_sum($totalCount),2);
            $returnRs['order_total']    = count($orderFee);


            //保证金
            $accountinfoObj = M('accountinfo');
            $accountinfoRs  = $accountinfoObj->where('uid='.$uid)->find();

            $returnRs['account']        = number_format($accountinfoRs['balance'],2);

        
            $data=array('msg'=>'资金详情','status'=>1,'data'=>$returnRs);
            $this->ajaxReturn($data,'JSON');
        }
        $this->error('您访问的地址不存在','/admin/');
    }

    /**
     * 运营中心删除
     * @author wang <li>
     */
    public function del(){

        $uid    = I('post.uid'); //userid
        $data   = array();
        $agent = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $uid))->find();
        if($agent)
        {
            $data['status'] = 0;
            $data['msg']    = '该运营中心下还有销售商,你不能删除';
            $this->ajaxReturn($data,'JSON');
        }

        $user = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $agent['user_id']))->find();

        if($agent)
        {
            $data['status'] = 0;
            $data['msg']    = '该运营中心下还有用户,你不能删除';
            $this->ajaxReturn($data,'JSON');
        }

        $result = M('userinfo')->where(array('uid' => $uid,'otype' => 5))->delete();
        $account= M('accountinfo')->where(array('uid' => $uid))->delete();
        $del    = M("UserinfoRelationship")->where(array('user_id' => $uid))->delete();

        if($result && $account && $del){

            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data,'JSON');
        } else{

            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data,'JSON');
        }

    }


    /**
     * 添加运营中心
     * @author wang <li>
     */
    public function add(){
        if(IS_AJAX){

            $data        = array();
            $username    = trim(I('post.username'));
            $pwd         = trim(I('post.pwd'));
            $notpwd      = trim(I('post.notpwd'));
            $tel         = trim(I('post.tel'));

            $agent_name  = trim(I('post.agent_name'));  //销售商用户名
            $is_default  = trim(I('post.is_default'));  //是否为默认运营中心  1默认，0普通

            $userObj     = M('userinfo');

            if(empty($username)){

                $data['status'] = 0;
                $data['msg']    = '运营中心用户名不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', $username)){

                $data['status'] = 0;
                $data['msg']    = '运营中心用户名不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }

            if($userObj->where(array('username' => $username))->find()){

                $data['status'] = 0;
                $data['msg']    = '运营中心用户名已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($pwd) == ''){

                $data['status'] = 0;
                $data['msg']    = '密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', trim($pwd))){

                $data['status'] = 0;
                $data['msg']    = '密码不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($notpwd) != $pwd){

                $data['status'] = 0;
                $data['msg']    = '密码必须一致';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($tel) == ''){

                $data['status'] = 0;
                $data['msg']    = '手机号码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^1\d{10}$/',$tel)){

                $data['status'] = 0;
                $data['msg']    = '手机号填写错误';
                $this->ajaxReturn($data,'JSON');
            }


            if($userObj->where('utel='.$tel.' and ustatus in("0,1") and otype=5')->find()){

                $data['status'] = 0;
                $data['msg']    = '该手机号已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            //如果选择默认运营中心
            if($is_default == 1)
            {

              if(empty($agent_name))
              {
                $data['status'] = 0;
                $data['msg']    = '销售商用户名不能为空';
                $this->ajaxReturn($data,'JSON');
              }

              if(!preg_match('/^[A-Za-z0-9]+$/', $agent_name)){

                $data['status'] = 0;
                $data['msg']    = '销售商用户名不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
              }

              if($username == $agent_name){

                $data['status'] = 0;
                $data['msg']    = '销售商用户名不能和运营中心相同';
                $this->ajaxReturn($data,'JSON');
              }

              if($userObj->where(array('username' => $agent_name))->find()){

                $data['status'] = 0;
                $data['msg']    = '销售商用户名已经存在';
                $this->ajaxReturn($data,'JSON');
              }


              //查看系统是否已经有默认运营中心
              if($userObj->field('uid')->where(array('is_default' => 1,'otype' => 5))->find())
              {
                $data['status'] = 0;
                $data['msg']    = '系统已经存在默认运营中心';
                $this->ajaxReturn($data,'JSON');
              }

              //查看默认销售商是否已经存在
              if($userObj->field('uid')->where(array('is_default' => 1,'otype' => 6))->find())
              {
                $data['status'] = 0;
                $data['msg']    = '系统已经存在默认销售商';
                $this->ajaxReturn($data,'JSON');
              }


              $map['is_default'] = 1;

              $agent['username']    = $agent_name;
              $agent['upwd']        = md5($pwd);
              $agent['utel']        = $tel;
              $agent['utime']       = time();
              $agent['update_time'] = time();
              $agent['otype']       = 6;
              $agent['ustatus']     = 0;
              $agent['nickname']    = '销售商'.$agent_name;
              $agent['reg_ip']      = get_client_ip();
              $agent['is_default']  = 1;
            }


            $map['username']        = $username;  //登录帐号
            $map['upwd']            = md5($pwd);
            $map['utel']            = $tel;
            $map['utime']           = time();
            $map['update_time']     = time();
            $map['otype']           = 5;
            $map['ustatus']         = 0;
            $map['nickname']        = '运营中心'.$username;
            $map['reg_ip']          = get_client_ip();

            $result = $userObj->add($map);

            if($result){
                
                $account['uid'] = $result;
                M('accountinfo')->add($account);  //添加运营账户

                $where['user_id']           = $result;
                $where['parent_user_id']    = 0;  //运营中心
                $where['all_path']          = $result;
                $res = M('UserinfoRelationship')->add($where);

                if($is_default == 1)
                {
                  if($res)
                  {
                    $agent_resutl = M('userinfo')->add($agent);
                    if($agent_resutl)
                    {
                      $agent_account['uid'] = $agent_resutl;
                      M('accountinfo')->add($agent_account);

                      $agent_where['user_id']           = $agent_resutl;
                      $agent_where['parent_user_id']    = $result;  //运营中心
                      $agent_where['all_path']          = $result.'_'.$agent_resutl;
                      $agent_res = M('UserinfoRelationship')->add($agent_where);

                      if($agent_resutl && $agent_res)
                      {
                        $data['status'] = 1;
                        $data['msg']    = '注册成功';
                        $this->ajaxReturn($data,'JSON');
                      } else {
                        $data['status'] = 0;
                        $data['msg']    = '注册失败';
                        $this->ajaxReturn($data,'JSON');
                      }
                    }
                  }
                } else {
                    if($result && $res)
                    {
                      $data['status'] = 1;
                      $data['msg']    = '注册成功';
                      $this->ajaxReturn($data,'JSON');
                    } else {
                      $data['status'] = 0;
                      $data['msg']    = '注册失败';
                      $this->ajaxReturn($data,'JSON');
                    }
                }
            } else {
                $data['status'] = 0;
                $data['msg']    = '注册失败';
                $this->ajaxReturn($data,'JSON');
            }
        }

      //查看系统是否已经存在默认运营中心
      $user = M('userinfo')->field('uid,is_default')->where(array('otype' => 5,'is_default' => 1))->find();
      $this->assign('user',$user);
      $this->display();
    }

    /**
     * 运营中心金额修改
     * @author wang <li>
     */

    public function balance(){

        $data    = array();
        $uid     = trim(I('post.uid'));
        $value   = trim(I('post.value'));
        $field   = trim(I('post.field'));

        if(!isset($uid) || !isset($field))
        {
            $data['status'] = 0;
            $data['msg']    = 'id不存在';
            $this->ajaxReturn($data,'JSON');
        }

        if($field == 's_domain' || $field == 'utel')
        {
        	if(M('userinfo')->where(array('uid' => $uid))->setField($field,$value))
        	{
	            $data['status'] = 1;
	            $data['msg']    = '修改成功';
	            $this->ajaxReturn($data,'JSON');
        	} else {
	            $data['status'] = 0;
            	$data['msg']    = '修改失败';
            	$this->ajaxReturn($data,'JSON');
        	}
        }


        $account = M("accountinfo")->where(array('uid' => $uid))->find();
        if($account){

            $result = M('accountinfo')->where(array('uid' => $uid))->setInc($field,$value);

        } else {

            $map['uid']     = $uid;
            $map[$field]    = $value;
            $result = M('accountinfo')->add($map);
        }

        if($result && $field == 'balance'){

            $shibpprice = M('accountinfo')->where('uid='.$uid)->sum('balance');

            //运营中心资金流水表
            if($value > 0) {

            $where['bptime']    = time();
            $where['bpprice']   = $value;
            $where['uid']       = $uid;
            $where['cltime']    = time();
            $where['balanceno'] = time().mt_rand();
            $where['shibpprice'] = $shibpprice;
            $where['status']    = 1;
            $where['pay_type']  = 25;
            M("balance")->add($where);

                $msg    = '资金变动增加['.$value.']美元';
                $en_msg = 'Increased capital movements['.$value.']Dollar';
            } else {
                $msg    = '资金变动扣除['.$value.']美元';
                $en_msg = 'Capital change deduction['.$value.']Dollar';
            }
            $operat_flow['uid']      = $uid;
            $operat_flow['type']     = 4;
            $operat_flow['note']     = $msg;
            $operat_flow['en_note']   = $en_msg;
            $operat_flow['balance']  = $shibpprice;
            $operat_flow['op_id']    = session('userid');
            $operat_flow['user_type']= 2;
            $operat_flow['dateline'] = time();
            M("MoneyFlow")->add($operat_flow);

        }
        if($result)
        {
            $data['status'] = 1;
            $data['msg']    = '修改成功';
            $this->ajaxReturn($data,'JSON');
        }
        else {
            $data['status'] = 0;
            $data['msg']    = '修改失败';
            $this->ajaxReturn($data,'JSON');
        }
    }

    /**
     * @author [wang] <[li]>
     */
    
    public function flow()
    {
       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $starttime = urldecode(trim(I('get.starttime')));
       $endtime   = urldecode(trim(I('get.endtime')));
       $operator  = trim(I('get.operator'));  //操作人


       if($utel) {
          $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
          $info = $userinfo->field('uid')->where($where)->select();
          foreach ($info as $key => $value) {
              array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
          $sea['utel'] = $utel;
       }

       if($type) {
            $map['type'] = $type;
            $sea['type'] = $type;
       }

       if($operator) {
            $map['op_id'] = $operator;
            $this->assign('op_id',$operator);
            $sea['operator'] = $operator;
       }

        if($yunying) {

            $map['uid'] = array('in',$yunying);
            $sea['yunying'] = $yunying;
        }


        if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

       $map['user_type'] = array('eq',2);

       $count = $MoneyFlow->where($map)->count();   //总数量
       $pagecount = 15;   //每页显示的数量
       $page = new \Think\Page($count, $pagecount);
       $page->parameter = $sea; //此处的row是数组，为了传递查询条件
       $page->setConfig('first', '首页');
       $page->setConfig('prev', '&#8249;');
       $page->setConfig('next', '&#8250;');
       $page->setConfig('last', '尾页');
       $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
       $show = $page->show();
       $Flow = $MoneyFlow->where($map)->order('dateline  desc')->limit($page->firstRow, $page->listRows)->select();

       $Flow_money = $MoneyFlow->field('note')->where($map)->select();
       $flowArr     = array();
       $flowArr2    = array();
       foreach ($Flow as $key => $value) {
          array_push($flowArr,$value['uid']);
          array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));
       
       $info = $userinfo->field('uid,utel,username,nickname')->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
          $infoArr[$value['uid']] = $value;
       }
       

       foreach ($Flow as $key => $value) {

           $Flow[$key]['utel']              = $infoArr[$value['uid']]['utel'];
           $Flow[$key]['username']          = $infoArr[$value['uid']]['username'];
           $Flow[$key]['nickname']          = $infoArr[$value['uid']]['nickname'];

           $Flow[$key]['account']       = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow[$key]['account']       = preg_replace("/]/", "",$Flow[$key]['account']);
       }

       //无分页
       foreach ($Flow_money as $key => $value) {
           $Flow_money[$key]['account']  = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow_money[$key]['account']  = preg_replace("/]/", "",$Flow_money[$key]['account']);
           $money += $Flow_money[$key]['account'];
       }

       $this->assign('flow',$Flow);
       $this->assign('page',$show);
       $this->assign('sea',$sea);
       $this->assign('yunying',$userinfo->field('uid,username,utel')->where('otype=5')->select());
       $this->assign('money',$money);
       $this->assign('info',M('userinfo')->field('uid,username')->where(array('otype' =>3))->select());
       $this->display();
    }

    public function daochu_moneyFlow() 
    {

       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $starttime = urldecode(trim(I('get.starttime')));
       $endtime   = urldecode(trim(I('get.endtime')));
       $operator  = trim(I('get.operator'));  //操作人


       if($utel) {
          $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
          $info = $userinfo->field('uid')->where($where)->select();
          foreach ($info as $key => $value) {
              array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
       }

       if($type) {
            $map['type'] = $type;
       }

       if($operator) {
            $map['op_id'] = $operator;
       }

        if($yunying) {

            $map['uid'] = array('in',$yunying);
        }


        if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
        }

       $map['user_type'] = array('eq',2);


       $Flow = $MoneyFlow->where($map)->order('dateline  desc')->select();

       $Flow_money = $MoneyFlow->field('note')->where($map)->select();
       $flowArr     = array();
       $flowArr2    = array();
       foreach ($Flow as $key => $value) {
          array_push($flowArr,$value['uid']);
          array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));
       
       $info = $userinfo->field('uid,utel,username,utel,nickname')->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
          $infoArr[$value['uid']] = $value;
       }

       foreach ($Flow as $key => $value) {

           $Flow[$key]['utel']              = $infoArr[$value['uid']]['utel'];
           $Flow[$key]['username']          = $infoArr[$value['uid']]['username'];
           $Flow[$key]['nickname']          = $infoArr[$value['uid']]['nickname'];

           $Flow[$key]['account']       = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow[$key]['account']       = preg_replace("/]元/", "",$Flow[$key]['account']);
       }


        $data[0] = array('编号','用户名','昵称','手机号码','资金变动描述','变动金额','用户余额','操作人','操作时间');
        foreach($Flow as $k => $v){
            $data[$k+1][] = $v['id'];
            $data[$k+1][] = $v['username'];
            $data[$k+1][] = $v['nickname'];
            $data[$k+1][] = $v['utel'];
            $data[$k+1][] = $v['note'];
            $data[$k+1][] = number_format($v['account'],2);
            $data[$k+1][] = number_format($v['balance'],2);
            $data[$k+1][] = change($v['op_id']);;
            $data[$k+1][] = date('Y-m-d H:i:s',$v['dateline']);
        }
        $name='资金流水记录';      //生成的Excel文件文件名
        $res=$this->push($data,$name);
   }


    private function push($data,$name){

        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }



    public function commission_save()
    {
        $id  = trim(I('get.id'));
        $val = trim(I('get.val'));
        $uid = trim(I('get.uid'));
        
        $userSpecial = M('OptionUserSpecial');

        $data = array();

        if(empty($val))
        {
           $data['msg'] = '输入的内容不能为空';
           $this->ajaxReturn($data,'JSON');
        }

        if(isset($id) || isset($uid))
        {
           $is_save = $userSpecial->where(array('user_id' => $uid,'id' => $id))->setField('commission',$val);
           if($is_save)
           {
               $data['msg'] = '修改成功';
               $this->ajaxReturn($data,'JSON');
           } else {
                $data['msg'] = '修改失败';
                $this->ajaxReturn($data,'JSON');
           }

        } else {
           $data['msg'] = '用户编号或者商品编号不存在';
           $this->ajaxReturn($data,'JSON');
        }
    }

}