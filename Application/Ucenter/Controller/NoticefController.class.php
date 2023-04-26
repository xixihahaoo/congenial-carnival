<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/2 20:36
 * @filename: OrderfController.class.php
 * @description: 运营中心出入金模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;

use Think\Controller;
use Org\Util\Jpush;

class NoticefController extends CommonController
{

    public function noticelist()
    {
        $title              = trim(I('get.title'));

        if($title) {
            $agentArr2 = array();
            $where['title'] = array('like','%'.$title.'%');
            $this->assign('title',$title);
        }


        $siteObj    = M('site_stretch');

        $count      = $siteObj->where($where)->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $stretch = $siteObj
            ->where($where)
            ->order('id desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $time = time();
        foreach ($stretch as $key => $value) {
               if($time >= $value['start_time'] && $time <= $value['end_time']) {
                  $stretch[$key]['note'] = '<span class="label label-sm label-success">活动进行中</span>';
               } 
               if($time < $value['start_time']) {
                  $stretch[$key]['note'] = '<span class="label label-sm label-success">活动未开始</span>';
               } 
               if($time > $value['end_time']) {
                  $stretch[$key]['note'] = '<span class="label label-sm label-warning">活动已结束</span>';
               } 
        }



        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('stretch', $stretch);

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    //添加公告
    public function noticeadd()
    {
        if(IS_POST) {

            $ntitle             = trim(I('post.ntitle'));
            $start_time          = trim(I('post.start_time'));
            $end_time          = trim(I('post.end_time'));
            $ncontent           = trim(I('post.ncontent'));

            if(empty($ntitle))
                outjson(array('status' => 0,'info' => '标题不能为空'));

            if(empty($start_time) || empty($end_time))
                outjson(array('status' => 0,'info' => '请选择时间'));

            if(empty($ncontent))
                outjson(array('status' => 0,'info' => '请填写内容'));

            $data['title'] = $ntitle;
            $data['content'] = $ncontent;
            $data['start_time'] = strtotime($start_time);
            $data['end_time'] = strtotime($end_time);
            $data['dateline'] = time();

            if(M('site_stretch')->add($data))
                outjson(array('status' => 1,'info' => '提交成功'));
            else
                outjson(array('status' => 0,'info' => '提交失败'));

        } else {
            $this->display();
        }
    }


    public function edit()
    {
        if(IS_POST) {

            $id                = trim(I('post.id'));
            $ntitle             = trim(I('post.ntitle'));
            $ncontent           = trim(I('post.ncontent'));
            $start_time          = trim(I('post.start_time'));
            $end_time          = trim(I('post.end_time'));

            if(empty($id))
                outjson(array('status' => 0,'info' => '非法提交'));

            if(empty($ntitle))
                outjson(array('status' => 0,'info' => '标题不能为空'));

            if(empty($start_time) || empty($end_time))
                outjson(array('status' => 0,'info' => '请选择时间'));

            if(empty($ncontent))
                outjson(array('status' => 0,'info' => '请填写内容'));

            $data['title'] = $ntitle;
            $data['content'] = $ncontent;
            $data['start_time'] = strtotime($start_time);
            $data['end_time'] = strtotime($end_time);
            $data['dateline'] = time();

            if(M('site_stretch')->where('id='.$id)->save($data))
                outjson(array('status' => 1,'info' => '提交成功'));
            else
                outjson(array('status' => 0,'info' => '提交失败'));
            
        } else {

            $id = trim(I('get.id'));
            $info = M('site_stretch')->where('id='.$id)->find();

            $this->assign('info',$info);
            $this->display();
        }
    }


    //公告删除
    public function delete()
    {   
        $id = trim(I('post.id'));

        if(empty($id))
            outjson(array('status' => 0,'ret_msg' => '非法传参'));

        $siteObj = M('site_stretch');

        if($siteObj->where('id='.$id)->delete())
            outjson(array('status' => 1,'ret_msg' => '删除成功'));
        else
            outjson(array('status' => 0,'ret_msg' => '删除失败'));
    }



    //极光推送
    public function jpush()
    {
        if(IS_AJAX)
        {
            $title      = trim(I('post.title'));
            $content    = trim(I('post.content'));

            if(empty($content) || empty($title))
                outjson(array('code' => 400,'msg' => '非法提交'));

            $fetion = new Jpush();

            $receive = 'all';//全部 
            //$receive = array('tag'=>array('中国'));//标签 
            //$receive = array('alias'=>array('2'),'alias'=>array('1'));//别名 
            
            $html = html_entity_decode($content);

            $title      = $title; 
            $content    = $html; 
            $m_type     = '消息类型'; 
            $m_txt      = '自定义内容'; 
            $m_time     = '86400';        //离线保留时间  默认一天
            $res=$fetion->send_pub($receive, $content ,$m_type, $m_txt ,$m_time,$title);

            if($res['code'] == 200)
            {
                M('push_notice')->add(array('title' => $title,'message' => $content,'create_time' => time()));
            }

            outjson(array('code' => $res['code'],'msg' => $res['msg']));
        } else {
            $this->display();
        }
    }

    //历史推送
    public function jpushmsg()
    {
        $noticeObj    = M('push_notice');

        $count      = $noticeObj->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $notice = $noticeObj
            ->order('id desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('notice', $notice);

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

}