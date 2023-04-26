<?php
namespace Home\Controller;
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
