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


class TraderController extends CommonController
{
    
    /**
     * 交易员列表
     * @author wang  li
     */
    public function lists()
    {
        $email      = trim(I('get.email'));
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));

        $username       = trim(I('get.username'));
        $nickname       = trim(I('get.nickname'));
        $uid            = trim(I('get.uid'));

        $userinfoObj    = M('userinfo');

        //用户
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

         //电子邮箱筛选
        if($email) {
            $agentArr2      = array();
            $map['email']   = array('like','%'.$email.'%');
            $map['otype']   = array(array('eq',4),array('eq',5),'or');
            $map['uid']     = array('in',$userIdStr);
            $userinfo       = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
            $this->assign('email',$email);
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

        //用户名称
        if($username)
        {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = array(array('eq',4),array('eq',5),'or');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username',$username);
        }

        //用户昵称
        if($nickname)
        {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = array(array('eq',4),array('eq',5),'or');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname',$nickname);
        }

        //编号
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

        $relUserWhereArr= 'uid in ('.$userIdStr.') and `is_trader` = 1 '.$where.'';
        $count          = $userinfoObj->where($relUserWhereArr)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $relUserRs      = $userinfoObj
            ->where($relUserWhereArr)
            ->order('utime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $userIdArr  = array();
        foreach ($relUserRs as $key => $value) {
            array_push($userIdArr,$value['uid']);
        }

        if($userIdArr)
        {   

            $followObj  = M('order_follow');
            $accountObj = M('accountinfo');

            $uidStr     = implode(',',array_unique($userIdArr));

            //统计跟随人数
            $follow = $followObj->field('count(*) count ,count(case when status = 1 then status end) nowCount,follow_user_id')->where('follow_user_id in ('.$uidStr.')')->group('follow_user_id')->select();

            $followData = array();

            foreach ($follow as $key => $value) {
                $followData[$value['follow_user_id']] = $value;
            }

            //统计累计收益
            $account = $accountObj->where('uid in('.$uidStr.')')->getField('uid,trader_profit',true);

            //底部总收益
            $sumProfit = $accountObj->where('uid in('.$uidStr.')')->sum('trader_profit');
        }

        foreach ($relUserRs as $key => $value) {
            $relUserRs[$key]['count']    = $followData[$value['uid']]['count'];
            $relUserRs[$key]['nowCount'] = $followData[$value['uid']]['nowCount'];

            $relUserRs[$key]['trader_profit'] = $account[$value['uid']];

            $relUserRs[$key]['lastlog'] = empty($value['lastlog']) ? '未登陆过' : date('Y-m-d H:i:s',$value['lastlog']);
        }

    

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('sumProfit',$sumProfit);

        $this->assign('relUserRs', $relUserRs);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    /**
     * 交易员列表导出
     * @author wang li
     */
    public function lists_daochu()
    {
        $email          = trim(I('get.email'));
        $starttime      = urldecode(trim(I('get.starttime')));
        $endtime        = urldecode(trim(I('get.endtime')));

        $username       = trim(I('get.username'));
        $nickname       = trim(I('get.nickname'));
        $uid            = trim(I('get.uid'));

        $userinfoObj    = M('userinfo');

        //用户
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
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and utime between '.$start_time.' and '.$end_time.'';
        }

                //用户名称
        if($username)
        {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
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

        //用户昵称
        if($nickname)
        {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
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

        //编号
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


        $relUserWhereArr= 'uid in ('.$userIdStr.') and `is_trader` = 1 '.$where.'';

        $relUserRs      = $userinfoObj
            ->where($relUserWhereArr)
            ->order('utime desc')
            ->select();

        $userIdArr  = array();
        foreach ($relUserRs as $key => $value) {
            array_push($userIdArr,$value['uid']);
        }

        if($userIdArr)
        {   

            $followObj  = M('order_follow');
            $accountObj = M('accountinfo');

            $uidStr     = implode(',',array_unique($userIdArr));

            //统计跟随人数
            $follow = $followObj->field('count(*) count ,count(case when status = 1 then status end) nowCount,follow_user_id')->where('follow_user_id in ('.$uidStr.')')->group('follow_user_id')->select();

            $followData = array();

            foreach ($follow as $key => $value) {
                $followData[$value['follow_user_id']] = $value;
            }
        }

        foreach ($relUserRs as $key => $value) {
            $relUserRs[$key]['count']    = $followData[$value['uid']]['count'];
            $relUserRs[$key]['nowCount'] = $followData[$value['uid']]['nowCount'];

            $relUserRs[$key]['trader_profit'] = $account[$value['uid']];

            $relUserRs[$key]['lastlog'] = empty($value['lastlog']) ? '未登陆过' : date('Y-m-d H:i:s',$value['lastlog']);
        }



        $data[0] = array('编号','用户名称','电子邮箱','用户昵称','累计跟随人数','当前跟随人数','累计收益','注册日期','最后登录');
        foreach($relUserRs as $k => $v){

            $data[$k+1][] = $v['uid'];
            $data[$k+1][] = $v['username'];
            $data[$k+1][] = $v['email'];
            $data[$k+1][] = $v['nickname'];
            $data[$k+1][] = empty($v['count']) ? 0 : $v['count'];
            $data[$k+1][] = empty($v['nowCount']) ? 0 : $v['nowCount'];
            $data[$k+1][] = $v['trader_profit'];
            $data[$k+1][] = date('Y-m-d H:i:s',$v['utime']);
            $data[$k+1][] = $v['lastlog'];
        }
        $name='交易员列表记录';      //生成的Excel文件文件名
        $res=$this->push($data,$name);
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


    /**
     * 追随者列表
     * @author wang  li
     */
    public function followList()
    {
        $email          = trim(I('get.email'));
        $username       = trim(I('get.username'));
        $nickname       = trim(I('get.nickname'));
        $fu_email       = trim(I('get.fu_email'));

        $userinfoObj = M('userinfo');

        //用户
        $extension = fiance([NOW_UID], 1);

        $whereArr['uid'] = [
            'in',
            array_unique(array_column($extension, 'uid')),
        ];

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));


        //手机号码筛选
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

        //用户名称
        if($username)
        {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
            $map['otype'] = array(array('eq',4),array('eq',5),'or');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username',$username);
        }

        //用户昵称
        if($nickname)
        {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
            $map['otype'] = array(array('eq',4),array('eq',5),'or');
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname',$nickname);
        }

        //交易员邮箱
        if($fu_email)
        {
            $where = 'and fu.email like "%'.$fu_email.'%"';
            $this->assign('fu_email',$fu_email);
        }

        $followObj 	= M('order_follow as o');

        $where .= 'and o.status = 1';
        $relUserWhereArr= 'o.user_id in ('.$userIdStr.') '.$where.'';

        $count = $followObj
            ->where($relUserWhereArr)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->count();

        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $relUserRs = $followObj
            ->field('u.uid,u.email,u.username,u.nickname,u.utime,u.lastlog,o.follow_type,o.follow_number,o.follow_profit,fu.email as fu_email')
            ->where($relUserWhereArr)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->order('o.follow_profit desc,u.utime asc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        //总收益
        $sumProfit = $followObj
            ->where($relUserWhereArr)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->sum('o.follow_profit');


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('sumProfit',$sumProfit);
        $this->assign('relUserRs', $relUserRs);
        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    /**
     * 追随者列表导出
     * @author wang  li
     */
    public function followList_daochu()
    {
        $email          = trim(I('get.email'));
        $username       = trim(I('get.username'));
        $nickname       = trim(I('get.nickname'));
        $fu_email       = trim(I('get.fu_email'));

        $userinfoObj = M('userinfo');

        //用户
        $extension = fiance([NOW_UID], 1);

        $whereArr['uid'] = [
            'in',
            array_unique(array_column($extension, 'uid')),
        ];

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));

        //手机号码筛选
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

        //用户名称
        if($username)
        {
            $agentArr2 = array();
            $map['username'] = array('like','%'.$username.'%');
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

        //用户昵称
        if($nickname)
        {
            $agentArr2 = array();
            $map['nickname'] = array('like','%'.$nickname.'%');
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

        //交易员邮箱
        if($fu_email)
        {
            $where = 'and fu.email like "%'.$fu_email.'%"';
        }

        $followObj 	= M('order_follow as o');

        $where .= 'and o.status = 1';
        $relUserWhereArr= 'o.user_id in ('.$userIdStr.') '.$where.'';

        $relUserRs = $followObj
            ->field('u.uid,u.email,u.username,u.nickname,u.utime,u.lastlog,o.follow_type,o.follow_number,o.follow_profit,fu.email as fu_email')
            ->where($relUserWhereArr)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->order('o.follow_profit desc,u.utime asc')
            ->select();


        foreach ($relUserRs as $key => $value) {
            $relUserRs[$key]['follow_type']  = $value['follow_type'] == 1 ? "固定比例" : "固定手数";
            $relUserRs[$key]['utime']        = date('Y-m-d H:i:s',$value['utime']);
            $relUserRs[$key]['lastlog']      = date('Y-m-d H:i:s',$value['lastlog']);
        }

        $data[0] = array('编号','用户名称','用户昵称','电子邮箱','交易员邮箱','跟随方式','跟随数量','跟随收益','注册日期','最后登录');
        foreach($relUserRs as $k => $v){
            $data[$k+1][] = $v['uid'];
            $data[$k+1][] = $v['username'];
            $data[$k+1][] = $v['nickname'];
            $data[$k+1][] = $v['email'];
            $data[$k+1][] = $v['fu_email'];
            $data[$k+1][] = $v['follow_type'];
            $data[$k+1][] = $v['follow_number'];
            $data[$k+1][] = $v['follow_profit'];
            $data[$k+1][] = $v['utime'];
            $data[$k+1][] = $v['lastlog'];
        }
        $name='追随者列表记录';      //生成的Excel文件文件名
        $this->push($data,$name);
    }
}