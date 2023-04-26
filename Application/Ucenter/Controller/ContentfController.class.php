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

class ContentfController extends CommonController
{

    public function contentList()
    {
        $starttime         = urldecode(trim(I('get.start_time')));
        $endtime           = urldecode(trim(I('get.end_time')));
        $title              = trim(I('get.title'));


        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['ntime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }

        //手机号码筛选
        if($title) {
            $agentArr2 = array();
            $where['ntitle'] = array('like','%'.$title.'%');
            $this->assign('title',$title);
        }


        $newsObj    = M('newsinfo');

        $count      = $newsObj->where($where)->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $newsinfo = $newsObj
            ->where($where)
            ->order('nid desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $newsClassObj = M('newsclass');

        $classData = $newsClassObj->getField('fid,fclass',true);

        foreach ($newsinfo as $key => $value) {
            $newsinfo[$key]['class'] = $classData[$value['ncategory']];
        }


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('newsinfo', $newsinfo);

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    //添加文章
    public function contentadd()
    {   
        if(IS_POST) {

            $UploadVMKImagePath = $_FILES['ncover'];
            $ntitle             = trim(I('post.ntitle'));
            $ncategory          = trim(I('post.ncategory'));
            $ncontent           = trim(I('post.ncontent'));

            if(empty($ntitle))
                outjson(array('status' => 0,'info' => '标题不能为空'));

            if(empty($ncategory))
                outjson(array('status' => 0,'info' => '请选择栏目'));

            if(empty($ncontent))
                outjson(array('status' => 0,'info' => '请填写内容'));

            if(empty($UploadVMKImagePath))
                outjson(array('status' => 0,'info' => '图片还没上传'));


            $news = D('newsinfo');
            $configUpload   = array('rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH);
            $upload = new \Think\Upload($configUpload);// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息    
                $this->error($upload->getError());
            }else{
                // 上传成功 获取上传文件信息 
                $data = array();
                foreach($info as $key => $file){      
                    $idcover = $file['savepath'].$file['savename'];
                    $data[$file['key']] = $idcover;
                }

                $data['ntitle'] = $ntitle;
                $data['ncontent'] = $ncontent;
                $data['ncategory'] = $ncategory;
                $data['ntime'] = time();

                if(M('newsinfo')->add($data))
                    outjson(array('status' => 1,'info' => '提交成功'));
                else
                    outjson(array('status' => 0,'info' => '提交失败'));
            }

        } else {
            $classObj   = M('newsclass');
            $classData  = $classObj->select();

            $this->assign('classData',$classData);
            $this->display();
        }
    }

    public function newsedit()
    {
        if(IS_POST) {

            $UploadVMKImagePath = $_FILES['ncover'];
            $nid                = trim(I('post.nid'));
            $ntitle             = trim(I('post.ntitle'));
            $ncategory          = trim(I('post.ncategory'));
            $ncontent           = trim(I('post.ncontent'));

            if(empty($nid))
                outjson(array('status' => 0,'info' => '非法提交'));

            if(empty($ntitle))
                outjson(array('status' => 0,'info' => '标题不能为空'));

            if(empty($ncategory))
                outjson(array('status' => 0,'info' => '请选择栏目'));

            if(empty($ncontent))
                outjson(array('status' => 0,'info' => '请填写内容'));

            if($UploadVMKImagePath)
            {
                $configUpload   = array('rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH);
                $upload = new \Think\Upload($configUpload);// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息    
                    $this->error($upload->getError());
                }else{
                    // 上传成功 获取上传文件信息 
                    $data = array();
                    foreach($info as $key => $file){      
                        $idcover = $file['savepath'].$file['savename'];
                        $data[$file['key']] = $idcover;
                    }
                }
            }

            $data['ntitle'] = $ntitle;
            $data['ncontent'] = $ncontent;
            $data['ncategory'] = $ncategory;
            $data['ntime'] = time();

            if(M('newsinfo')->where('nid='.$nid)->save($data))
                outjson(array('status' => 1,'info' => '提交成功'));
            else
                outjson(array('status' => 0,'info' => '提交失败'));
            
        } else {
            $classObj   = M('newsclass');
            $classData  = $classObj->select();

            $nid = trim(I('get.nid'));
            $info = M('newsinfo')->where('nid='.$nid)->find();

            $this->assign('info',$info);
            $this->assign('classData',$classData);
            $this->display();
        }
    }


    //文章删除
    public function delete()
    {   
        $nid = trim(I('post.nid'));

        if(empty($nid))
            outjson(array('status' => 0,'ret_msg' => '非法传参'));

        $newsObj = M('newsinfo');

        if($newsObj->where('nid='.$nid)->delete())
            outjson(array('status' => 1,'ret_msg' => '删除成功'));
        else
            outjson(array('status' => 0,'ret_msg' => '删除失败'));
    }

        /**
     * @functionname: upload
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 编辑器初始化
     * @note:
     */ 
     public function upload() {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();

        $url = './Uploads/'.$info['file']['savepath'] . $info['file']['savename'];
        $img = 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$info['file']['savepath'] . $info['file']['savename'];

        $image = new \Think\Image();//实例化图片处理类
        $image->open($url);//打开图片
        $image->thumb(400, 400)->save($url);//生成50X50的缩略图,并保存

            if ($info) {
                $result = array(
                    'code' => 0,
                    'msg'  => '上传成功',
                    'data' => array(
                        'src'   => $img,
                        'title' => '图片'
                    )
                );
            } else {
                $result = array(
                    'code' => -1,
                    'msg'  => '上传失败'
                );
            }

            $this->ajaxReturn($result,'JSON');
        }



    //栏目管理
    public function column()
    {
        $classObj    = M('newsclass');

        $count      = $classObj->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $newsinfo = $classObj
            ->order('fid desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('newsinfo', $newsinfo);

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    public function columnadd()
    {
        if(IS_POST)
        {
            $class = trim(I('post.class'));
            if(empty($class))
                outjson(array('status' => 0,'info' => '请填写名称'));

            $data['fclass'] = $class;
            $data['is_show'] = 1;
            $data['type'] = 0;
            if(M('newsclass')->add($data))
                outjson(array('status' => 1,'info' => '添加成功'));
            else
                outjson(array('status' => 0,'info' => '添加失败'));

        } else {
            $this->display();
        }
    }

    //栏目修改
    public function columnedit()
    {
        if(IS_POST)
        {
            $class  = trim(I('post.class'));
            $fid    = trim(I('post.fid'));

            if(empty($fid))
                outjson(array('status' => 0,'info' => '非法提交'));

            if(empty($class))
                outjson(array('status' => 0,'info' => '请填写名称'));

            $data['fclass'] = $class;
            if(M('newsclass')->where('fid='.$fid)->save($data))
                outjson(array('status' => 1,'info' => '修改成功'));
            else
                outjson(array('status' => 0,'info' => '修改失败'));

        } else {

            $fid    = trim(I('get.fid'));
            $info   = M('newsclass')->where('fid='.$fid)->find();
            $this->assign('info',$info);
            $this->display();
        }
    }

}