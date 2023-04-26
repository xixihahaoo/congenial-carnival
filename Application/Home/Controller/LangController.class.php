<?php
// +----------------------------------------------------------------------
// | 语言切换控制器
// +----------------------------------------------------------------------
// | Author wang <li>
// +----------------------------------------------------------------------
namespace Home\Controller;

class LangController extends CommonController
{
    public function index()
    {
        $this->assign('lang',LANG);
        $this->display();
    }
}