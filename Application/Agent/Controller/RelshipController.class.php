<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/4 10:58
 * @filename: RelshipController.class.php
 * @description: 推广模块
 * @note: 
 * 
 */

namespace Agent\Controller;


class RelshipController extends CommonController
{
    /**
     * @functionname: relship_list
     * @author: wang
     * @date: 2018-4-17 10:59:11
     * @description: 推广用户的佣金流水
     * @note:
     */
    public function relship_commission_list()
    {
        $status     = trim(I('get.status'));
        $starttime  = urldecode(trim(I('get.start_time')));
        $endtime    = urldecode(trim(I('get.end_time')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $id         = trim(I('get.id'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name')); 



        $where      = '';

        $userinfoObj    = M('userinfo');

        //经纪人
        $whereArr   = array(
            'rid'    => NOW_UID
        );

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));

        $where['a.type']    =  1;

        // 开始筛选

        //结算状态筛选
        if($status) {
           $where['a.status'] = $status;
           $this->assign('status',$status);
        }


        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['a.create_time']     = array('between',array($start_time,$end_time));
            $sea['start_time']          = $starttime;
            $sea['end_time']            = $endtime; 
            $this->assign('time',$sea);
        }

        //电子邮箱筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
            $this->assign('email',$email);
        }

        //用户名筛选
        if($username) {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
            $this->assign('username',$username);
        }

        //用户昵称筛选
        if($nickname) {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
            $this->assign('nickname',$nickname);
        }

        //编号筛选
        if($id)
        {
            $where['a.id'] = $id;
            $this->assign('id',$id);
        }

        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['b.pid'] = array('in',$option['id']);

            $this->assign('optin_class_max',$optin_class_max);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['b.pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();

            $this->assign('mindata',$mindata);
            $this->assign('optin_class_min',$optin_class_min);
        }

        //产品名称
        if ($option_name) 
        {
            $where['b.pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();

            $this->assign('option',$option);
            $this->assign('option_name',$option_name);
        }


        //佣金
        $feeObj = M('fee_receive a');
        $where['a.user_id'] = array('in',''.$userIdStr.'');

        $feeWhereArr    = $where;
        $count          = $feeObj->where($feeWhereArr)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $prefix = C('DB_PREFIX');

        $feeRs  = $feeObj
            ->where($feeWhereArr)
            ->join('left join '.$prefix.'order b on a.order_id=b.oid')
            ->order('a.create_time desc, a.order_id desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();


        $feeUserRs      = $userinfoObj->field('uid,email,username,nickname')->where('uid in ('.$userIdStr.')')->select();
        foreach($feeUserRs as $k => $v)
        {
            $feeUserRs1[$v['uid']]  = $v;
        }


        $feeRs1         = array();
        foreach($feeRs as $k => $v)
        {
            $feeRs1[$v['id']]           = $v;
            
            $feeRs1[$v['id']]['email']      = $feeUserRs1[$v['user_id']]['email'];
            $feeRs1[$v['id']]['username']   = $feeUserRs1[$v['user_id']]['username'];
            $feeRs1[$v['id']]['nickname']   = $feeUserRs1[$v['user_id']]['nickname'];

            $feeRs1[$v['id']]['date_c'] = date('Y-m-d H:i:s', $v['create_time']);

            $feeRs1[$v['id']]['status_n']   = $v['status'] == 2 ? '<span class="label label-sm label-warning">未结算</span>' : '<span class="label label-sm label-success">已结算</span>';

        }

        foreach($feeRs1 as $k => $v)
        {
            $feeRs2[$k] = $v;
        }


        //底部统计
        $feeRss  = $feeObj
            ->field('a.status,a.profit')
            ->where($feeWhereArr)
            ->join('left join '.$prefix.'order b on a.order_id=b.oid')
            ->select();
        foreach($feeRss as $k => $v)
        {

            if($v['status'] == 1) {
               $account['settlement']+=$v['profit'];
            } 
            if($v['status'] == 2) {
                $account['unsettled']+=$v['profit'];
            }
        }

        $this->assign('account',$account);

        //产品大类
        $classify   = M('option_classify')->field('id,name')->where(array('level' => 1))->select();

        $this->assign('classify',$classify);


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('feeRs', $feeRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('agentinfoRs',$agentinfoRs);
        $this->display();
    }

    /**
     * @functionname: commission_daochu
     * @author: wang
     * @date: 2018-04-17 12:48:52
     * @description: 佣金流水导出excel
     * @note:
     */
    
     public function commission_daochu()
     {
        $status     = trim(I('get.status'));
        $starttime  = urldecode(trim(I('get.start_time')));
        $endtime    = urldecode(trim(I('get.end_time')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $id         = trim(I('get.id'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name')); 



        $where      = '';

        $userinfoObj    = M('userinfo');

        //经纪人
        $whereArr   = array(
            'rid'    => NOW_UID
        );

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));

        $where['a.type']    =  1;

        // 开始筛选

        //结算状态筛选
        if($status) {
           $where['a.status'] = $status;
        }


        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['a.create_time']     = array('between',array($start_time,$end_time));
        }

        //电子邮箱筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
        }

        //用户名筛选
        if($username) {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
        }

        //用户昵称筛选
        if($nickname) {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
        }

        //编号筛选
        if($id)
        {
            $where['a.id'] = $id;
        }

        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['b.pid'] = array('in',$option['id']);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['b.pid'] = array('in',$option['id']);
        }

        //产品名称
        if ($option_name) 
        {
            $where['b.pid'] = $option_name;
        }


        //佣金
        $feeObj = M('fee_receive a');
        $where['a.user_id'] = array('in',''.$userIdStr.'');

        $feeWhereArr    = $where;

        $prefix = C('DB_PREFIX');

        $feeRs  = $feeObj
            ->where($feeWhereArr)
            ->join('left join '.$prefix.'order b on a.order_id=b.oid')
            ->order('a.create_time desc, a.order_id desc')
            ->select();


        $feeUserRs      = $userinfoObj->field('uid,email,username,nickname')->where('uid in ('.$userIdStr.')')->select();
        foreach($feeUserRs as $k => $v)
        {
            $feeUserRs1[$v['uid']]  = $v;
        }


        $feeRs1         = array();
        foreach($feeRs as $k => $v)
        {
            $feeRs1[$v['id']]           = $v;
            
            $feeRs1[$v['id']]['email']       = $feeUserRs1[$v['user_id']]['email'];
            $feeRs1[$v['id']]['username']   = $feeUserRs1[$v['user_id']]['username'];
            $feeRs1[$v['id']]['nickname']   = $feeUserRs1[$v['user_id']]['nickname'];

            $feeRs1[$v['id']]['date_c'] = date('Y-m-d H:i:s', $v['create_time']);

            $feeRs1[$v['id']]['status_n']   = $v['status'] == 2 ? '未结算' : '已结算';

        }

        foreach($feeRs1 as $k => $v)
        {
            $feeRs2[$k] = $v;
        }


        $data[0] = array('编号id','用户名称','电子邮箱','用户昵称','产品名称','结算状态','获得佣金','操作时间');
        foreach ($feeRs2 as $key => $value) {

            $data[$key+1][] = $value['id'];
            $data[$key+1][] = $value['username'];
            $data[$key+1][] = $value['email'];
            $data[$key+1][] = $value['nickname'];
            $data[$key+1][] = $value['option_name'];
            $data[$key+1][] = $value['status_n'];
            $data[$key+1][] = $value['profit'];
            $data[$key+1][] = $value['date_c'];
        }

        $name = '佣金流水表';
        $this->push($data,$name);
     }

    /**
      * 佣金转入记录
      * @author wang <li>
    */
   public function extension(){

       $start_time  = urldecode(trim(I('get.start_time')));
       $end_time    = urldecode(trim(I('get.end_time')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $id         = trim(I('get.id'));

        $userinfoObj    = M('userinfo');

        //经纪人
        $whereArr   = array(
            'rid'    => NOW_UID
        );

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));


        if($start_time && $end_time) {
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $where .= 'and create_time between '.$starttime.' and '.$endtime.'';
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
        }

        //电子邮箱筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
            $this->assign('email',$email);
        }

        //用户名筛选
        if($username) {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
            $this->assign('username',$username);
        }

        //用户昵称筛选
        if($nickname) {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
            $this->assign('nickname',$nickname);
        }

        //编号筛选
        if($id)
        {
            $where .= ' and id='.$id;
            $this->assign('id',$id);
        }

        $journalObj = M('user_journal');

        $relUserWhereArr= 'user_id in ('.$userIdStr.') and type = 1 '.$where.'';
        $count          = $journalObj->where($relUserWhereArr)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $relUserRs      = $journalObj
            ->where($relUserWhereArr)
            ->order('create_time desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();


        $userIdArr  = array();
        $levelIdArr = array(); 
        foreach ($relUserRs as $key => $value) {
            array_push($userIdArr,$value['user_id']);
        }

        $uidStr     = implode(',',array_unique($userIdArr));

        $userData  = $userinfoObj->where('uid in('.$uidStr.')')->getField('uid,email,username,nickname',true);

        foreach($relUserRs as $k => $v)
        {

            $relUserRs[$k]['date_c']        = date('Y-m-d H:i:s', $v['create_time']);
            $relUserRs[$k]['email']         = $userData[$v['user_id']]['email'];
            $relUserRs[$k]['username']      = $userData[$v['user_id']]['username'];
            $relUserRs[$k]['nickname']      = $userData[$v['user_id']]['nickname'];
        }


        $account      = $journalObj
            ->where($relUserWhereArr)
            ->sum('account');


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('account',$account);

        $this->assign('relUserRs', $relUserRs);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    /**
     * 佣金转入记录导出
     * @author wang li
     */
    public function extension_daochu()
    {
       $start_time  = urldecode(trim(I('get.start_time')));
       $end_time    = urldecode(trim(I('get.end_time')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $id         = trim(I('get.id'));

        $userinfoObj    = M('userinfo');

        //经纪人
        $whereArr   = array(
            'rid'    => NOW_UID
        );

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));


        if($start_time && $end_time) {
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $where .= 'and create_time between '.$starttime.' and '.$endtime.'';
        }

        //电子邮箱筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
        }

        //用户名筛选
        if($username) {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
        }

        //用户昵称筛选
        if($nickname) {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = array('in','4,5');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? '' : $userId; 
            $userIdStr = $userId;
        }

        //编号筛选
        if($id)
        {
            $where .= ' and id='.$id;
        }

        $journalObj = M('user_journal');

        $relUserWhereArr= 'user_id in ('.$userIdStr.') and type = 1 '.$where.'';

        $relUserRs      = $journalObj
            ->where($relUserWhereArr)
            ->order('create_time desc')
            ->select();


        $userIdArr  = array();
        $levelIdArr = array(); 
        foreach ($relUserRs as $key => $value) {
            array_push($userIdArr,$value['user_id']);
        }

        $uidStr     = implode(',',array_unique($userIdArr));

        $userData  = $userinfoObj->where('uid in('.$uidStr.')')->getField('uid,email,username,nickname',true);

        foreach($relUserRs as $k => $v)
        {

            $relUserRs[$k]['date_c']        = date('Y-m-d H:i:s', $v['create_time']);
            $relUserRs[$k]['email']         = $userData[$v['user_id']]['email'];
            $relUserRs[$k]['username']      = $userData[$v['user_id']]['username'];
            $relUserRs[$k]['nickname']      = $userData[$v['user_id']]['nickname'];
        }


        $data[0] = array('编号id','用户名称','电子邮箱','用户昵称','转入时间','转入金额');
        foreach ($relUserRs as $key => $value) {
            $data[$key+1][] = $value['id'];
            $data[$key+1][] = $value['username'];
            $data[$key+1][] = $value['email'];
            $data[$key+1][] = $value['nickname'];
            $data[$key+1][] = $value['date_c'];
            $data[$key+1][] = $value['account'];
        }

        $name = '佣金转入记录列表';
        $this->push($data,$name);
    }



    private function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }


    private function get_username($uid = 0) {

        $personalObj    = M('personal_user_data');
        $userObj        = M('userinfo');

        $persona = $personalObj->field('real_name username,uid')->where(array('uid' => $uid))->find();

        if(!empty($persona)) {
            return  $persona;
        } else {
            $user = $userObj->field('uid,username')->where(array('uid' => $uid))->find();
            return $user;
        }
    }
}