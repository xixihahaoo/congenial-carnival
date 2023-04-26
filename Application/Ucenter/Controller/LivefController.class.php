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

class livefController extends CommonController
{

    public function roomlist()
    {
        $roomObj    = M('room');
        $anchorObj  = M('anchor');

        $count      = $roomObj->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $room = $roomObj
            ->order('id desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        foreach ($room as $key => $value) {
            $room[$key]['count'] = $anchorObj->where('room_id='.$value['id'])->count();
        }

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('room', $room);
        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    public function anchor()
    {
        $anchorObj  = M('anchor a');
        $prefix     = C('DB_PREFIX');

        $count      = $anchorObj->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $anchor = $anchorObj->field('a.*,b.nickname,b.utel,b.username,c.name')->join('left join '.$prefix.'userinfo b on a.uid=b.uid')->join('left join '.$prefix.'room c on a.room_id=c.id')->limit($pageObj->firstRow, $pageObj->listRows)->order('a.id desc')->select();

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('anchor', $anchor);
        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    //添加主播
    public function anchorAdd()
    {
        if(IS_AJAX)
        {
            $id       = trim(I('post.id'));
            $user_id  = trim(I('post.user_id'));

            if(empty($id) || empty($user_id))
                outjson(array('code' => 400,'msg' => '参数不能为空'));

            $room = M('room')->field('id')->where(array('id' => $id))->find();

            if(!$room)
                outjson(array('code' => 400,'msg' => '房间不存在'));

            $data = M('anchor')->field('uid')->where(array('uid' => $user_id,'room_id' => $id))->find();

            if($data)
                outjson(array('code' => 400,'msg' => '您已经是主播了'));

            $dataArr = array(
                'uid'           => $user_id,
                'room_id'       => $id,
                'create_time'   => time()
            );

            $res = M('anchor')->add($dataArr);

            if($res)
                outjson(array('code' => 200,'msg' => '添加成功'));
            else
                outjson(array('code' => 400,'msg' => '添加失败'));

        } else {
          $this->assign('info',M('userinfo')->field('uid,username')->where(array("otype" => 6))->select());
          $this->assign('id',trim(I('get.id')));
          $this->display();
        }
    }


    //主播删除
    public function delete()
    {   
        $id = trim(I('post.id'));

        if(empty($id))
            outjson(array('status' => 0,'ret_msg' => '非法传参'));

        $anchorObj = M('anchor');

        if($anchorObj->where('id='.$id)->delete())
            outjson(array('status' => 1,'ret_msg' => '删除成功'));
        else
            outjson(array('status' => 0,'ret_msg' => '删除失败'));
    }


    //历史消息
    public function chatmsg()
    {
        $utel 		= trim(I('get.utel'));
        $username 	= trim(I('get.username'));
        $nickname 	= trim(I('get.nickname'));
        $msg 	    = trim(I('get.msg'));
        $userType   = trim(I('get.userType'));
        $starttime 	= urldecode(trim(I('get.starttime')));	//开始时间
        $endtime 	= urldecode(trim(I('get.endtime')));	    //结束时间

        if($utel)
        {
            $where['b.utel'] 	= array('like','%'.$utel.'%');
            $sea['utel'] 		= $utel;
        }

        if($username)
        {
            $where['b.username'] 	= array('like','%'.$username.'%');
            $sea['username'] 		= $username;
        }

        if($nickname)
        {
            $where['b.nickname'] 	= array('like','%'.$nickname.'%');
            $sea['nickname'] 		= $nickname;
        }

        if($msg)
        {
            $where['a.msg'] 	= array('like','%'.$msg.'%');
            $sea['msg'] 		= $msg;
        }

        if($userType)
        {
            $where['a.type'] 	= $userType;
            $sea['userType'] 	= $userType;
        }

        if($starttime && $endtime) {
            $start_time  	  = strtotime($starttime);
            $end_time 		  = strtotime($endtime);
            $where['a.dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        } else {
            $start_time = strtotime(date('Y-m-d')." 06:00:00");
            $end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['a.dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = date('Y-m-d H:i:s',$start_time);
            $sea['endtime']   = date('Y-m-d H:i:s',$end_time);
        }


        $anchorObj  = M('chat_msg a');
        $prefix     = C('DB_PREFIX');

        $count = $anchorObj->join('left join '.$prefix.'userinfo b on a.uid=b.uid')->where($where)->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $anchor = $anchorObj->field('a.*,b.username,b.nickname,b.utel')->join('left join '.$prefix.'userinfo b on a.uid=b.uid')->where($where)->limit($pageObj->firstRow, $pageObj->listRows)->order('a.id desc')->select();

        $userType = array(1 => '普通会员',2 => '主播');
        foreach ($anchor as $key => $value) {
            $anchor[$key]['user_type'] = $userType[$value['type']];
        }

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('sea',$sea);
        $this->assign('anchor', $anchor);
        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }
//删除消息
    public function delectmessage()
    {


        $news = M('chat_msg');
        //批量删除id
        $arrnid = I('post.nid');

        //单个删除
        $nid = I('get.nid');

        if (IS_POST) {
            $result = $news->where('id in('.implode(',', $arrnid).')')
                           ->delete();
            if ($result !== false) {
                $this->success("成功删除{$result}条！", U("Livef/chatmsg"));
            } else {
                $this->error('删除失败！');
            }
        } else {
            $result = $news->where('id='.$nid)
                           ->delete();
            if ($result !== false) {
                $this->success("成功删除！", U("Livef/chatmsg"));
            } else {
                $this->error('删除失败！');
            }
        }



    }
}