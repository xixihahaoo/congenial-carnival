<?php
namespace Home\Controller;
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
