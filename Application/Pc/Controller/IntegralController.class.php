<?php
namespace Pc\Controller;
use Think\Controller;

class IntegralController extends CommonController
{

    public function _initialize(){
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }


    /**
     * [index 我的积分]
     * @author wang li
     */
    public function index()
    {
        $accountObj = M('accountinfo');

        //当前积分
        $integral = $accountObj->where(array('uid' => $this->user_id))->getField('integral');

        //积分兑换规则
        $info = M('newsinfo')->where('ncategory=11')->order('nid desc')->find();

        $info['ncontent'] = html_entity_decode($info['ncontent']);

        $this->assign('info',$info);
        $this->assign('integral',$integral);
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
