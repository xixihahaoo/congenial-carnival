<?php

namespace Agent\Controller;

class CapitalController extends CommonController
{

    /**
     * @functionname: lists
     * @author: wang
     * @date: 2018-04-26 10:16:30
     * @description: 出入金列表
     * @note:
     */
    public function lists()
    {   
        $start_time     = urldecode(trim(I('get.start_time')));
        $end_time       = urldecode(trim(I('get.end_time')));
        $utel       = trim(I('get.utel'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $uid        = trim(I('get.uid'));
        $level      = trim(I('get.level')); 

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


        if($start_time && $end_time){

            $agentArr1 = array();
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['utime'] = array('between',''.$starttime.','.$endtime.'');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
       
            foreach ($userinfo as $key => $value) {
                array_push($agentArr1,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr1));
            $userIdStr = $userId;
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
        }

         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $map['utel'] = array('like','%'.$utel.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
            $this->assign('utel',$utel);
         }

         //用户类型筛选
        if($level) 
        {   
            $agentArr2 = array();
            $map['extension_level'] = $level;
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $agentId = implode(',',array_unique($agentArr2));
        
            if(!empty($agentId))
            {
                $userArr = array();
                $where['rid']   = array('in',$agentId);
                $where['otype'] = 4;
                $users = $userinfoObj->where($where)->select();
                foreach ($users as $key => $value) {
                    array_push($userArr,$value['uid']);
                }
                $userId     = implode(',',array_unique($userArr));
                if(!empty($userId)) 
                    $userIdStr = $userId.','.$agentId;
                else
                    $userIdStr = $agentId;
            } else {
                $userIdStr  = 1-1;
            }

            $this->assign('levels',$level);
        }

        //用户名称
        if($username)
        {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
            $this->assign('username',$username);
        }

        //用户昵称
        if($nickname)
        {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
            $this->assign('nickname',$nickname);
        }

        //用户编号
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


        $prefix = C('DB_PREFIX');

        //需要从这里添加条件
        $userinfoWhereArr   = 'a.uid in ('.$userIdStr.') and ustatus=0';


        $count      = M('userinfo a')->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')->where($userinfoWhereArr)->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $field = 'a.*,b.recharge_total,b.money_total,b.balance';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();


        foreach($userinfoRs as $k => $v)
        {
             $userinfoRs[$k]['net_gold'] = number_format($v['recharge_total'] - $v['money_total'],2);
        }


        //底部统计
        $statistics = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->select();

        foreach ($statistics as $key => $value) {
            $statistics[$key]['net_gold'] = number_format($value['recharge_total'] - $value['money_total'],2);
        }

        foreach ($statistics as $key => $value) {
            $data['recharge_total'] += $value['recharge_total'];
            $data['money_total']    += $value['money_total'];
           // $data['net_gold']       += $value['net_gold'];
            $data['balance']        += $value['balance'];
        }

        $data['net_gold'] = number_format($data['recharge_total'] - $data['money_total'],2);

        //用户级别
        $level = M('userinfo_rate')->field('id,name')->select();
        $this->assign('level',$level);


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('data',$data);
        $this->assign('userInfo', $userinfoRs);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }



    public function lists_daochu()
    {   
        $start_time     = urldecode(trim(I('get.start_time')));
        $end_time       = urldecode(trim(I('get.end_time')));
        $utel       = trim(I('get.utel'));
        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $uid        = trim(I('get.uid'));
        $level      = trim(I('get.level')); 

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


        if($start_time && $end_time){

            $agentArr1 = array();
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['utime'] = array('between',''.$starttime.','.$endtime.'');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
       
            foreach ($userinfo as $key => $value) {
                array_push($agentArr1,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr1));
            $userIdStr = $userId;
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
        }
         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $map['utel'] = array('like','%'.$utel.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
         }

         //用户类型筛选
        if($level) 
        {   
            $agentArr2 = array();
            $map['extension_level'] = $level;
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $agentId = implode(',',array_unique($agentArr2));
        
            if(!empty($agentId))
            {
                $userArr = array();
                $where['rid']   = array('in',$agentId);
                $where['otype'] = 4;
                $users = $userinfoObj->where($where)->select();
                foreach ($users as $key => $value) {
                    array_push($userArr,$value['uid']);
                }
                $userId     = implode(',',array_unique($userArr));
                if(!empty($userId)) 
                    $userIdStr = $userId.','.$agentId;
                else
                    $userIdStr = $agentId;
            } else {
                $userIdStr  = 1-1;
            }
        }

        //用户名称
        if($username)
        {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
        }

        //用户昵称
        if($nickname)
        {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
        }

        //用户编号
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


        $prefix = C('DB_PREFIX');

        //需要从这里添加条件
        $userinfoWhereArr   = 'a.uid in ('.$userIdStr.') and ustatus=0';

        
        $field = 'a.*,b.recharge_total,b.money_total,b.balance';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->select();


        foreach($userinfoRs as $k => $v)
        {
             $userinfoRs[$k]['net_gold'] = number_format($v['recharge_total'] - $v['money_total'],2);
        }

        $data[0] = array('编号id','用户名称','手机号码','用户昵称','注册时间','总入金','总出金','净入金','当前资金');
        foreach ($userinfoRs as $key => $value) {
            $data[$key+1][] = $value['uid'];
            $data[$key+1][] = $value['username'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['nickname'];
            $data[$key+1][] = date('Y-m-d H:i:s',$value['utime']);
            $data[$key+1][] = $value['recharge_total'];
            $data[$key+1][] = $value['money_total'];
            $data[$key+1][] = $value['net_gold'];
            $data[$key+1][] = $value['balance'];
        }

        $name = '出入金统计';
        $this->push($data,$name);

    }


    private function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }
}