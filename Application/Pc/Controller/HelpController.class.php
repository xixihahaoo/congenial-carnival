<?php
namespace Pc\Controller;
use Think\Controller;


class HelpController extends CommonController
{

    //风险提示
    public function Risk()
    {
        $info               = M('newsinfo')->where(['ncategory' => 12,'lang' => LANG_SHOW])->find();
        $info['ncontent']   = html_entity_decode($info['ncontent']);

        if(LANG == 'zh-tw') {
            $info['ntitle']     = simpleTradition($info['ntitle']);
            $info['ncontent']   = simpleTradition($info['ncontent']);
        }

        $this->assign('info',$info);
        $this->display('details');
    }

    //帮助中心
    public function help()
    {
        if(LANG_SHOW == 'en-us') {
            $class  = M('newsclass')->where(array('fid' => 13,'lang' => LANG_SHOW))->getField('en_name');
        } else {
            $class  = M('newsclass')->where(array('fid' => 13,'lang' => LANG_SHOW))->getField('fclass');
        }

        $info   = M('newsinfo')->where(['ncategory' => 13,'lang' => LANG_SHOW])->select();

        foreach ($info as $key => $value) {

            if(LANG == 'zh-tw') {
                $info[$key]['ntitle'] = simpleTradition($value['ntitle']);
            }
        }

        if(LANG == 'zh-tw') {
            $class = simpleTradition($class);
        }

        $this->assign('class',$class);
        $this->assign('info',$info);

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
            $bank[$key]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);


        $this->display();
    }

    //文章详细信息
    public function details()
    {
        $nid    = trim(I('get.nid',''));
        $info   = M('newsinfo')->where(['nid' => $nid,'lang' => LANG_SHOW])->find();

        $info['ncontent'] = html_entity_decode($info['ncontent']);

        if(LANG == 'zh-tw') {
            $info['ntitle']     = simpleTradition($info['ntitle']);
            $info['ncontent']   = simpleTradition($info['ncontent']);
        }

        $this->assign('info',$info);
        $this->display();
    }
}
