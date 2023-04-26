<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/15 11:40
 * @filename: CommonController.class.php
 * @description: 管理后台基类
 * @note: 
 * 
 */

namespace Admin\Controller;

class CommonController extends BaseController
{
    public function _initialize()
    {
        $user   = A('Admin/User');
        $user->checklogin();

        init_common_function();
    }

}


