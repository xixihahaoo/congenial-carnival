<?php
namespace Home\Controller;
use Think\Controller;


class TTController extends CommonController
{

    public function index()
    {
        $countryObj = M('country');

        $country = $countryObj->order('id asc')->select();

        $this->assign('country',$country);
        $this->display('country');
    }

    public function details()
    {
        $id = trim(I('get.id'));

        $countryObj = M('country');

        $country = $countryObj->where(['id' => $id])->find();

        $country['content'] = html_entity_decode($country['content']);

        $this->assign('country',$country);
        $this->display();
    }

}
