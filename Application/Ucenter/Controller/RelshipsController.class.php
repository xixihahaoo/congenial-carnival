<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/4 10:58
 * @filename: RelshipController.class.php
 * @description: 推广模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class RelshipsController extends CommonController
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


        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');

        $userIdStr = $userIdStr.','.NOW_UID;

        $where['a.type']    =  1;     //1表示用户


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


        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');

        $userIdStr = $userIdStr.','.NOW_UID;

        $where['a.type']    =  1;     //1表示用户


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

        //手机号码筛选
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

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();
        }

        //产品名称
        if ($option_name) 
        {
            $where['b.pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();
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

            $feeRs1[$v['id']]['email']      = $feeUserRs1[$v['user_id']]['email'];
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
     * @functionname: relship_list
     * @author: wang li
     * @date: 2018-04-17 12:48:52
     * @description: 推广员列表
     * @note:
     */
    public function relship_list()
    {
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));

        $email       = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $uid        = trim(I('get.uid'));


        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');

         //电子邮箱筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = array(array('eq',4),array('eq',5),'or');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
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
        if($uid)
        {
            $agentArr2 = array();
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            
            if(in_array($uid, $agentArr2)) $userId = empty($uid) ? 1-1 : $uid;

            $userIdStr = $userId;
            $this->assign('uid',$uid);
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and utime between '.$start_time.' and '.$end_time.'';
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }


        $relUserWhereArr= 'uid in ('.$userIdStr.') and `code` is not null and code != "" '.$where.'';
        $count          = $userinfoObj->where($relUserWhereArr)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $relUserRs      = $userinfoObj
            ->where($relUserWhereArr)
            ->order('utime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $userIdArr  = array();
        $levelIdArr = array(); 
        foreach ($relUserRs as $key => $value) {
            array_push($userIdArr,$value['uid']);
        }

        $uidStr     = implode(',',array_unique($userIdArr));


        $extensionData  = M('extension')->where('user_id in('.$uidStr.')')->getField('user_id,money',true);

        $rateData       = M('userinfo_rate')->getField('id,name',true); 

        foreach($relUserRs as $k => $v)
        {

            $relUserRs[$k]['date_c']  = date('Y-m-d H:i:s', $v['utime']);
            
            $relUserRs[$k]['money'] = $extensionData[$v['uid']];
            $relUserRs[$k]['level'] = $rateData[$v['extension_level']];
        }



        $relUserRss      = $userinfoObj
            ->field('uid')
            ->where($relUserWhereArr)
            ->select();
        foreach($relUserRss as $k => $v)
        {
            $profit_rmb += M('extension')->where(array('user_id' => $v['uid']))->sum('money');
        }

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('relUserRs', $relUserRs);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('agentinfoRs',$agentinfoRs);
        $this->assign('profit_rmb',$profit_rmb);
        $this->display();
    }

        /**
     * @functionname: relship_list
     * @author: FrankHong
     * @date: 2016-12-04 12:48:52
     * @description: 推广员列表导出excel
     * @note:
     */
    
    public function relship_list_daochu() 
    {
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $uid        = trim(I('get.uid'));


        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');

         //代理商筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = array(array('eq',4),array('eq',5),'or');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
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
        if($uid)
        {
            $agentArr2 = array();
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            
            if(in_array($uid, $agentArr2)) $userId = empty($uid) ? 1-1 : $uid;

            $userIdStr = $userId;
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and utime between '.$start_time.' and '.$end_time.'';
        }


        $relUserWhereArr= 'uid in ('.$userIdStr.') and `code` is not null and code != "" '.$where.'';

        $relUserRs      = $userinfoObj
            ->where($relUserWhereArr)
            ->order('utime desc')
            ->select();

        $userIdArr  = array();
        $levelIdArr = array(); 
        foreach ($relUserRs as $key => $value) {
            array_push($userIdArr,$value['uid']);
        }

        $uidStr     = implode(',',array_unique($userIdArr));


        $extensionData  = M('extension')->where('user_id in('.$uidStr.')')->getField('user_id,money',true);

        $rateData       = M('userinfo_rate')->getField('id,name',true); 

        foreach($relUserRs as $k => $v)
        {

            $relUserRs[$k]['date_c']  = date('Y-m-d H:i:s', $v['utime']);
            
            $relUserRs[$k]['money'] = $extensionData[$v['uid']];
            $relUserRs[$k]['level'] = $rateData[$v['extension_level']];
        }



        $data[0] = array('代理商ID','代理商名称','电子邮箱','代理商昵称','推广码','注册日期','上级','当前佣金','推广星级');
        foreach ($relUserRs as $key => $value) {
            $data[$key+1][] = $value['uid'];
            $data[$key+1][] = $value['username'];
            $data[$key+1][] = $value['email'];
            $data[$key+1][] = $value['nickname'];
            $data[$key+1][] = $value['code'];
            $data[$key+1][] = $value['date_c'];
            $data[$key+1][] = change($value['rid']);
            $data[$key+1][] = $value['money'];
            $data[$key+1][] = $value['level'];
        }

        $name = '推广员列表';
        $this->push($data,$name);
    }

  
  /**
  * 推广员下级流水
  * @author wang <li>
  */
   public function subordinate(){

        $user_id    = trim(I('get.user_id'));
        $status     = trim(I('get.status'));
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));

        $sea['user_id'] = $user_id;

        if($status)
        {
            $map['a.status']    = $status;
            $sea['status']      = $status;
        }


        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['a.create_time'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }


        $receiveObj         = M('fee_receive a');
        $prefix             = C('DB_PREFIX');

        $map['a.user_id']   = $user_id;

        $count = $receiveObj->where($map)->count();   //总数量

        $pagecount = 10;   //每页显示的数量
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '<<');
        $page->setConfig('next', '>>');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $receive = $receiveObj->
                    field('a.*,b.option_name,b.onumber')->
                    join('left join '.$prefix.'order b on a.order_id = b.oid')->
                    where($map)->
                    limit($page->firstRow, $page->listRows)->
                    order('a.id desc')->
                    select();

        foreach ($receive as $key => $value) {
            $receive[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        }


        $data = $receiveObj->field('sum(profit) profit,sum(fee) fee')->where($map)->find();

        $data['nowEnd'] = ceil($count/$pagecount);
        $data['count']  = $count;
        $p      = I('get.p');
        if(empty($p)) 
            $data['nowStart'] = 1;
        else
            $data['nowStart'] = $p;
        

        $this->assign('sea',$sea);
        $this->assign('data',$data);
        $this->assign('page',$show);
        $this->assign('user_id',$user_id);
        $this->assign('user',$receive);
        $this->display();
   }


    /**
      * 推广员下级
      * @author wang <li>
    */
   public function lowerlevel() {
        $user_id    = trim(I('get.user_id'));

        $sea['user_id'] = $user_id;

        $email      = trim(I('get.email'));
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));


        if($email)
        {
            $map['a.email']  = $email;
            $sea['email']    = $email;
        }


        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['a.utime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }


        $userObj        = M('userinfo a');
        $prefix         = C('DB_PREFIX');

        $map['a.rid']   = $user_id;

        $count = $userObj->where($map)->count();   //总数量

        $pagecount = 10;   //每页显示的数量
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '<<');
        $page->setConfig('next', '>>');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();


        $receive = $userObj->
                    field('a.*,c.balance')->
                    join('left join '.$prefix.'accountinfo c on a.uid = c.uid')->
                    where($map)->
                    limit($page->firstRow, $page->listRows)->
                    order('a.uid desc')->
                    select();

        foreach ($receive as $key => $value) {
            $receive[$key]['utime'] = date('Y-m-d H:i:s',$value['utime']);
            $receive[$key]['lastlog'] = !empty($value['lastlog']) ? date('Y-m-d H:i:s',$value['lastlog']) : '未登录过';

            $receive[$key]['last_login_ip'] = !empty($value['last_login_ip']) ? $value['last_login_ip'] : '未登录过';
        }


        $data['nowEnd'] = ceil($count/$pagecount);
        $data['count']  = $count;
        $p      = I('get.p');
        if(empty($p)) 
            $data['nowStart'] = 1;
        else
            $data['nowStart'] = $p;
        
        unset($map['b.type']);

        if($receive[0]['uid'])    $this->assign('user',$receive);

        $this->assign('count',$userObj->where($map)->count());
        $this->assign('sea',$sea);
        $this->assign('data',$data);
        $this->assign('page',$show);
        $this->assign('user_id',$user_id);
        $this->display();
   }
   


    /**
      * 佣金转入记录
      * @author wang <li>
    */
   public function extension(){

        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $id         = trim(I('get.id'));

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');

         //手机号码筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
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
            $where .= 'and id ='.$id.'';
            $this->assign('id',$id);
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and create_time between '.$start_time.' and '.$end_time.'';
            $sea['starttime']   = $starttime;
            $sea['endtime']     = $endtime;
            $this->assign('sea',$sea);
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

        $userData  = $userinfoObj->where('uid in('.$uidStr.')')->getField('uid,email,rid,username,nickname',true);

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
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));

        $email      = trim(I('get.email'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $id         = trim(I('get.id'));

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');

         //电子邮箱筛选
        if($email) {
            $agentArr2 = array();
            $map['email'] = array('like','%'.$email.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
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
            $where .= 'and id ='.$id.'';
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and create_time between '.$start_time.' and '.$end_time.'';
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

        $userData  = $userinfoObj->where('uid in('.$uidStr.')')->getField('uid,email,rid,username,nickname',true);

        foreach($relUserRs as $k => $v)
        {

            $relUserRs[$k]['date_c']        = date('Y-m-d H:i:s', $v['create_time']);
            $relUserRs[$k]['email']         = $userData[$v['user_id']]['email'];
            $relUserRs[$k]['username']      = $userData[$v['user_id']]['username'];
            $relUserRs[$k]['nickname']      = $userData[$v['user_id']]['nickname'];
        }

        $data[0] = array('编号id','用户名称','电子邮箱','用户昵称','转入时间','金额');
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
         
        $info = M("userinfo")->field('uid,username')->where(array('uid'=> $uid))->find();
        return $info ? $info : null;
    }
}