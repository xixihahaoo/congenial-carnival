<?php
// +----------------------------------------------------------------------
// | 公告控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Home\Controller;

use Think\Controller;

class StretchController extends CommonController
{


    public function _initialize()
    {
        parent::_initialize();
    }

    //公告列表
    public function stretchList()
    {
        $stretchObj = M('SiteStretch');

        $list = $stretchObj->field('id,title,content,dateline,start_time,end_time')
                           ->where(['lang' => LANG_SHOW])
                           ->order('dateline desc')
                           ->select();

        $time   = time();
        $status = 0;

        foreach ($list as $key => $value) {
            $list[ $key ]['time']    = date('Y/m/d H:i:s', $value['dateline']);
            $list[ $key ]['content'] = mb_substr(trim(htmlspecialchars_decode($value['content'])), 0, 80, 'UTF-8').' ...';

            if ($time >= $value['start_time'] && $time <= $value['end_time']) {
                $list[ $key ]['class'] = '';
                $status                = 1;
            }
            else {
                $list[ $key ]['class'] = 'isread';
            }

            if (LANG == 'zh-tw') {
                $list[ $key ]['title']   = simpleTradition($value['title']);
                $list[ $key ]['content'] = simpleTradition($list[ $key ]['content']);
            }
        }


        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->display();
    }


    /**
     * stretchDetails 滚动公告详情
     * @author wang li
     */
    public function stretchDetails()
    {
        $id = trim(I('get.id'));

        $stretch = M('site_stretch')
            ->where(['id' => $id])
            ->find();

        $stretch['content'] = html_entity_decode($stretch['content']);

        if (LANG == 'zh-tw') {
            $stretch['title']   = simpleTradition($stretch['title']);
            $stretch['content'] = simpleTradition($stretch['content']);
        }


        $this->assign('stretch', $stretch);
        $this->display();
    }

    //弹窗公告详情
    public function details()
    {
        $id = trim(I('get.id'));

        //记录cookie
        setcookie("news_id", $id, time() + (24 * 60 * 60) * 7, '/');

        $stretch = M('site_stretch')
            ->where('id='.$id)
            ->find();

        $stretch['content'] = html_entity_decode($stretch['content']);

        $this->assign('stretch', $stretch);
        $this->display('stretchdetails');
    }


    //存储首页弹框的cookie 默认一星期不显示
    public function setCookie()
    {
        $id = trim(I('get.id'));
        setcookie("news_id", $id, time() + (24 * 60 * 60) * 7, '/');
    }

}