<?php
namespace Pc\Controller;
use Think\Controller;


class FollowController extends CommonController
{

    public function _initialize(){
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }

    /**
     * 跟随管理
     * @author wang <li>
     */
    public function index()
    {
        $accountModel       = M('accountinfo');
        $orderFollowModel   = M('order_follow');

        $follow_profit = $accountModel->where(array('uid' => $this->user_id))->getField('follow_profit');


        $data['follow_profit']  = $follow_profit;
        $data['nowCount']       = $orderFollowModel->where(array('user_id' => $this->user_id,'status' => 1))->count();
        $data['cancelCount']    = $orderFollowModel->where(array('user_id' => $this->user_id,'status' => 2))->count();

        $this->assign('data',$data);


        //用户信息
        $userModel = D('userinfo');
        $user      = $userModel->getDataFind($this->user_id);
        $this->assign('user', $user);

        $accountModel = M('accountinfo');
        $account      = $accountModel->field('balance,gold')
                                     ->where(['uid' => $user['uid']])
                                     ->find();
        $this->assign('account', $account);

        $personalObj = M('personal_user_data');
        $personal    = $personalObj->where(['uid' => $this->user_id])
                                   ->find();
        $this->assign('personal', $personal);

        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        //个人资料
        $personal = $personalModel->field('province,city')
                                  ->where(['uid' => $this->user_id])
                                  ->find();


        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city_id = !empty($personal['province']) ? $personal['province'] : $province[0]['id'];

        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $city_id,
                          ])
                          ->select();

        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);
        $this->assign('user', $user);

        $bankObj     = M('bankinfo');
        $personalObj = M('personal_user_data a');

        $prefix = C('DB_PREFIX');

        $personal = $personalObj->field('a.real_name,a.card,a.status,b.face')
                                ->where(['a.uid' => $this->user_id])
                                ->join('right join '.$prefix.'userinfo b on a.uid=b.uid')
                                ->find();

        $personal['face'] = !empty($personal['face']) ? $personal['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
        $personal['card'] = substr_replace($personal['card'], '**********', 4, 10);

        $map['uid']    = $this->user_id;
        $map['status'] = [
            'in',
            '0,1',
        ];

        $bank = $bankObj->field('bid,bankname,banknumber,busername,status')
                        ->where($map)
                        ->select();

        foreach ($bank as $key => $value) {
            $bank[ $key ]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);


        $this->display();
    }


    /**
     * [getFollowData 获取交易员信息]
     * @author wang li
     */
    public function getFollowData()
    {
        $status = trim(I('post.status',''));

        $orderFollowModel   = M('order_follow');
        $userModel          = M('userinfo');

        $followData = $orderFollowModel->where(array('user_id' => $this->user_id,'status' => $status))->order('create_time desc')->select();

        if($followData)
        {
            $uidArr = array();
            foreach ($followData as $key => $value) {
                array_push($uidArr, $value['follow_user_id']);
            }

            $user_id    = implode(',',$uidArr);
            $userData   = $userModel->where('uid in ('.$user_id.')')->getField('uid,face,nickname');

            foreach ($followData as $key => $value) {
                $followData[$key]['face']       = !empty($userData[$value['follow_user_id']]['face']) ? $userData[$value['follow_user_id']]['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
                $followData[$key]['nickname']   = $userData[$value['follow_user_id']]['nickname'];

                $followData[$key]['desc']       = $value['follow_type'] == 1 ? L('api_fixed_multiple').':'.$value['follow_number'].L('api_multiple') : L('api_fixed_hands').':'.$value['follow_number'].L('api_hands');
            }

            $data = array('data' => $followData);
            outjson($data);
        }
    }

    /**
     * [userTrade 交易员管理]
     * @author wang li
     */
    public function userTrade()
    {
        $accountModel   = M('accountinfo');
        $userModel      = M('userinfo');

        $trader_profit      = $accountModel->where(array('uid' => $this->user_id))->getField('trader_profit');
        $is_trader          = $userModel->where(array('uid' => $this->user_id))->getField('is_trader');

        $this->assign('is_trader',$is_trader);
        $this->assign('trader_profit',$trader_profit);


        //用户信息
        $userModel = D('userinfo');
        $user      = $userModel->getDataFind($this->user_id);
        $this->assign('user', $user);

        $accountModel = M('accountinfo');
        $account      = $accountModel->field('balance,gold')
                                     ->where(['uid' => $user['uid']])
                                     ->find();
        $this->assign('account', $account);

        $personalObj = M('personal_user_data');
        $personal    = $personalObj->where(['uid' => $this->user_id])
                                   ->find();
        $this->assign('personal', $personal);

        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        //个人资料
        $personal = $personalModel->field('province,city')
                                  ->where(['uid' => $this->user_id])
                                  ->find();


        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city_id = !empty($personal['province']) ? $personal['province'] : $province[0]['id'];

        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $city_id,
                          ])
                          ->select();

        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);

        $bankObj     = M('bankinfo');
        $personalObj = M('personal_user_data a');

        $prefix = C('DB_PREFIX');

        $personal = $personalObj->field('a.real_name,a.card,a.status,b.face')
                                ->where(['a.uid' => $this->user_id])
                                ->join('right join '.$prefix.'userinfo b on a.uid=b.uid')
                                ->find();

        $personal['face'] = !empty($personal['face']) ? $personal['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
        $personal['card'] = substr_replace($personal['card'], '**********', 4, 10);

        $map['uid']    = $this->user_id;
        $map['status'] = [
            'in',
            '0,1',
        ];

        $bank = $bankObj->field('bid,bankname,banknumber,busername,status')
                        ->where($map)
                        ->select();

        foreach ($bank as $key => $value) {
            $bank[ $key ]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);


        $this->display();
    }


    /**
     * [getFollowData 获取跟随者信息]
     * @author wang li
     */
    public function getFollow()
    {
        $status = trim(I('post.status',''));

        $orderFollowModel   = M('order_follow');
        $userModel          = M('userinfo');

        $followData = $orderFollowModel->where(array('follow_user_id' => $this->user_id,'status' => $status))->order('create_time desc')->select();

        if($followData)
        {
            $uidArr = array();
            foreach ($followData as $key => $value) {
                array_push($uidArr, $value['user_id']);
            }

            $user_id    = implode(',',$uidArr);
            $userData   = $userModel->where('uid in ('.$user_id.')')->getField('uid,face,nickname');

            foreach ($followData as $key => $value) {
                $followData[$key]['face']       = !empty($userData[$value['user_id']]['face']) ? $userData[$value['user_id']]['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
                $followData[$key]['nickname']   = $userData[$value['user_id']]['nickname'];
                $followData[$key]['desc']       = $value['follow_type'] == 1 ? L('api_fixed_multiple').':'.$value['follow_number'].L('api_multiple') : L('api_fixed_hands').':'.$value['follow_number'].L('api_hands');
            }

            $data = array('data' => $followData);
            outjson($data);
        }
    }



    /**
     * [rule 跟随规则]
     * @author wang li
     */
    public function rule()
    {
        $catagory = M('newsclass')->where('fid=21')->getField('fid');

        $news = M('newsinfo')->field('ntitle,ncontent')->where(['ncategory' => $catagory,'lang' => LANG_SHOW])->find();

        $news['ncontent'] = html_entity_decode($news['ncontent']);

        if(LANG == 'zh-tw') {
            $news['ntitle']     = simpleTradition($news['ntitle']);
            $news['ncontent']   = simpleTradition($news['ncontent']);
        }

        $this->assign('news',$news);
        $this->display();
    }



    //判断是否登录
    private function IsLogin()
    {
        if(empty($this->user_id))
        {
            if(IS_AJAX)
                outjson(array('code' => 400,'msg' => L('no_login')));
            else
                $this->redirect('Login/login');
        }
    }
}
