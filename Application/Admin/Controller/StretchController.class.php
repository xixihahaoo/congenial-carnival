<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Org\Util\Jpush;

class StretchController extends CommonController {
	public function index()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
        $step = I('get.step');
        if($step == "search"){
			$keywords = I('post.keywords');
			$where['title'] = array('like','%'.$keywords.'%');
			$newlist = M("SiteStretch")->where($where)->select();
			$time = time();
			foreach($newlist as $k => $v){
				$newlist[$k]['dateline'] = date("Y-m-d",$newlist[$k]['dateline']);
				$newlist[$k]['start_time'] = date("Y-m-d H:i:s",$newlist[$k]['start_time']);
				$newlist[$k]['end_time'] = date("Y-m-d H:i:s",$newlist[$k]['end_time']);
				if($time >= $v['start_time'] && $time <= $v['end_time']) {
	        	   	$newlist[$k]['note'] = '<font style="color:green;">活动进行中</font>';
	        	} 
	        	if($time < $v['start_time']) {
	                $newlist[$k]['note'] = '<font style="color:red;">活动未开始</font>';
	        	} 
	        	if($time > $v['end_time']) {
	                $newlist[$k]['note'] = '<font style="color:red;">活动已结束</font>';
	        	} 
			}
			if($newlist){
				$this->ajaxReturn($newlist);	
			}else{
				$this->ajaxReturn("null");
			}
		}

		$lang = ['zh-cn' => '中文','en-us' => '英文'];

	    //查询多条记录
	    $count = M('SiteStretch')->count();
	    $pagecount = 10;
	    $page = new \Think\Page($count , $pagecount);
	    //$page->parameter = $row; //此处的row是数组，为了传递查询条件
	    $page->setConfig('first','首页');
	    $page->setConfig('prev','&#8249;');
	    $page->setConfig('next','&#8250;');
	    $page->setConfig('last','尾页');
	    $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
		
		$stretch = M('SiteStretch')->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $time = time();
        foreach ($stretch as $key => $value) {
        	   if($time >= $value['start_time'] && $time <= $value['end_time']) {
        	   	  $stretch[$key]['note'] = '<font style="color:green;">活动进行中</font>';
        	   } 
        	   if($time < $value['start_time']) {
                  $stretch[$key]['note'] = '<font style="color:red;">活动未开始</font>';
        	   } 
        	   if($time > $value['end_time']) {
                  $stretch[$key]['note'] = '<font style="color:red;">活动已结束</font>';
        	   }
        } 
		$this->assign('stretch',$stretch);
		$this->assign('page',$show);
		$this->display();
	}
	
	public function newsdel() {

		$id = I('get.id');
		$site = M("SiteStretch");
		$result = $site->where('id='.$id)->delete();
		if($result!==FALSE) {
				$this->success("成功删除！",U("Stretch/index"));
		} else {
				$this->error('删除失败！');
		}
	}
    
    public function alldel() {

        $arrid = I('post.nid');
        $site    = M("SiteStretch");

        $result = $site->where('id in('.implode(',',$arrid).')')->delete();
		if($result!==FALSE){
				$this->success("成功删除{$result}条！",U("Stretch/index"));
		} else {
				$this->error('删除失败！');
		}
    }
 


    public function newsedit() {

         //根据get接收到的id，获取本条数据并展示
        $tq      = C('DB_PREFIX');
        $site    = M("SiteStretch");
        if(IS_POST) {
            
            $id         = I('post.id');
            $title      = I('post.title');
            $start_time = I('post.start_time');
            $end_time   = I('post.end_time');
            $content    = I('post.content');
            $thumb      = I('post.thumb');
            $lang       = I('post.lang');

            if(empty($title)) {
            	$this->error('请填写你的标题');
            }
            if(empty($start_time) || empty($end_time)) {
            	$this->error('请填写活动开始时间或结束时间');
            }
            if(empty($content)) {
            	$this->error('内容不能为空');
            }

            $configUpload   = array('rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH);
            $upload = new \Think\Upload($configUpload);// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

            $info   =   $upload->upload();

            if($info == '')
            {
              $thumb = $thumb;
            } else {
                if(!$info) {
                  $this->error($upload->getError());
                }else{
                  // 上传成功 获取上传文件信息   
                  foreach($info as $file){      
                      $thumb = $file['savepath'].$file['savename'];
                  }
                }
            }



            $map['title']      = $title;
            $map['start_time'] = strtotime($start_time);
            $map['end_time']   = strtotime($end_time);
            $map['content']    = $content;
            $map['dateline']   = time();
            $map['thumb']      = $thumb;
            $map['lang']       = $lang;
            $result = $site->where(array('id' => $id))->save($map);
            if($result) {
               $this->success("修改成功！",U("Stretch/index"));
            } else {

            	 $this->error('修改失败！');
            }
        } else { 
           
           	$id      = I('get.id');
		    $editnew = $site->where('id='.$id)->find();
		    $this->assign('editnew',$editnew);
		    $this->display();
        }
    }
   
    public function newsadd() {
        
      $site = M("SiteStretch");
      if(IS_POST) {

        $thumb = $_FILES['thumb'];

        if(I('post.title') == '')
          $this->error('请填写你的标题');

        if(I('post.start_time') == '' || I('post.end_time') == '')
          $this->error('请填写活动开始时间或结束时间');

        if(I('post.content') == '')
          $this->error('内容不能为空');

        if(empty($thumb))
          $this->error('请上传缩略图');

        $configUpload   = array('rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH);
        $upload = new \Think\Upload($configUpload);// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息    
            $this->error($upload->getError());
        } else {

            foreach($info as $key => $file){      
              $thumb = $file['savepath'].$file['savename'];
            }

            if($site->create()) {
                $site->dateline   = time();
                $site->start_time = strtotime(I('post.start_time'));
                $site->end_time   = strtotime(I('post.end_time'));
                $site->thumb      = $thumb;
                $result = $site->add();

                if($result) {
                    $this->success("添加成功！",U("Stretch/index"));
                } else {
                    $this->error('添加失败！');
                }
            }
        }

    	 } else {
    	 	 $this->display();
    	 }
    }

    /**
     * 极光推送
     */
    public function jpush()
    {
    	if(IS_AJAX)
    	{
    		$title		= trim(I('post.title'));
    		$content 	= trim(I('post.content'));

    		if(empty($content) || empty($title))
    			outjson(array('code' => 400,'msg' => '非法提交'));

	        $fetion = new Jpush();

	        $receive = 'all';//全部 
	        //$receive = array('tag'=>array('中国'));//标签 
	        //$receive = array('alias'=>array('2'),'alias'=>array('1'));//别名 
	        
	        $html = html_entity_decode($content);

	        $title 		= $title; 
	        $content 	= $html; 
	        $m_type 	= '消息类型'; 
	        $m_txt 		= '自定义内容'; 
	        $m_time 	= '86400';        //离线保留时间  默认一天
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


    public function jpushMsg()
    {
  		$pushObj  	= M('push_notice');
      	$prefix     = C('DB_PREFIX');


  		$count = $pushObj->count();
      	$pagecount = 10;
      	$page = new \Think\Page($count , $pagecount);
      	$page->parameter = $row;
      	$page->setConfig('first','首页');
      	$page->setConfig('prev','&#8249;');
      	$page->setConfig('next','&#8250;');
      	$page->setConfig('last','尾页');
      	$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
      	$show = $page->show();

      	$push = $pushObj->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();


      	$this->assign('push',$push);
      	$this->assign('page',$show);
  		$this->display();
    }

}