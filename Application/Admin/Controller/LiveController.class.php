<?php
// +----------------------------------------------------------------------
// | 直播管理控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Think\Controller;

class LiveController extends CommonController
{

    /**
     * 房间列表
     * @author wang <li>
     */
    public function room()
    {
        $roomObj   = M('room');
        $anchorObj = M('anchor');
        $prefix    = C('DB_PREFIX');


        $count           = $roomObj->count();
        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $row;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $room = $roomObj->limit($page->firstRow.','.$page->listRows)
                        ->order('id desc')
                        ->select();

        foreach ($room as $key => $value) {
            $room[ $key ]['count'] = $anchorObj->where('room_id='.$value['id'])
                                               ->count();
        }

        $this->assign('room', $room);
        $this->assign('page', $show);
        $this->display();
    }

    //添加主播
    public function addAnchor()
    {
        $this->assign('info', M('userinfo')
            ->field('uid,username')
            ->where(["otype" => 5])
            ->select());
        $this->assign('id', trim(I('get.id')));
        $this->display();
    }

    public function add()
    {
        $id      = trim(I('post.id'));
        $user_id = trim(I('post.user_id'));

        if (empty($id) || empty($user_id)) {
            outjson([
                'code' => 400,
                'msg'  => '参数不能为空',
            ]);
        }

        $room = M('room')
            ->field('id')
            ->where(['id' => $id])
            ->find();

        if (!$room) {
            outjson([
                'code' => 400,
                'msg'  => '房间不存在',
            ]);
        }

        $data = M('anchor')
            ->field('uid')
            ->where([
                'uid'     => $user_id,
                'room_id' => $id,
            ])
            ->find();

        if ($data) {
            outjson([
                'code' => 400,
                'msg'  => '你已经是主播了',
            ]);
        }

        $dataArr = [
            'uid'         => $user_id,
            'room_id'     => $id,
            'create_time' => time(),
        ];

        $res = M('anchor')->add($dataArr);

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => '添加成功',
            ]);
        } else {
            outjson([
                'code' => 400,
                'msg'  => '添加失败',
            ]);
        }
    }

    //主播列表
    public function anchor()
    {
        $anchorObj = M('anchor a');
        $prefix    = C('DB_PREFIX');


        $count           = $anchorObj->count();
        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $anchor = $anchorObj->field('a.*,b.nickname,b.email,b.username,c.name')
                            ->join('left join '.$prefix.'userinfo b on a.uid=b.uid')
                            ->join('left join '.$prefix.'room c on a.room_id=c.id')
                            ->limit($page->firstRow.','.$page->listRows)
                            ->order('a.id desc')
                            ->select();



        $this->assign('anchor', $anchor);
        $this->assign('page', $show);
        $this->display();
    }

    //删除主播
    public function del()
    {
        $id = trim(I('post.id'));

        if (empty($id)) {
            outjson([
                'code' => 400,
                'msg'  => '编号不能为空',
            ]);
        }

        $anchorObj = M('anchor');

        $res = $anchorObj->where(['id' => $id])
                         ->delete();

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => '删除成功',
            ]);
        } else {
            outjson([
                'code' => 400,
                'msg'  => '删除失败',
            ]);
        }
    }

    //历史消息
    public function message()
    {
        $email 		= trim(I('get.email'));
        $username 	= trim(I('get.username'));
        $nickname 	= trim(I('get.nickname'));
        $msg 	    = trim(I('get.msg'));
        $userType   = trim(I('get.userType'));
        $starttime 	= urldecode(trim(I('get.starttime')));	//开始时间
        $endtime 	= urldecode(trim(I('get.endtime')));	//结束时间

        if($email)
        {
            $where['b.email'] 	= array('like','%'.$email.'%');
            $sea['email'] 		= $email;
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

        $anchorObj = M('chat_msg a');
        $prefix    = C('DB_PREFIX');

        $count = $anchorObj->join('left join '.$prefix.'userinfo b on a.uid=b.uid')
                            ->where($where)
                            ->count();

        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $anchor = $anchorObj->field('a.*,b.nickname,b.email,b.username')
                            ->join('left join '.$prefix.'userinfo b on a.uid=b.uid')
                            ->limit($page->firstRow.','.$page->listRows)
                            ->where($where)
                            ->order('a.id desc')
                            ->select();

        $userType = array(1 => '普通会员',2 => '主播');
        foreach ($anchor as $key => $value) {
            $anchor[$key]['user_type'] = $userType[$value['type']];
        }

        $this->assign('sea',$sea);
        $this->assign('anchor', $anchor);
        $this->assign('page', $show);
        $this->display();
    }

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
                $this->success("成功删除{$result}条！", U("Live/message"));
            } else {
                $this->error('删除失败！');
            }
        } else {
            $result = $news->where('id='.$nid)
                           ->delete();
            if ($result !== false) {
                $this->success("成功删除！", U("Live/message"));
            } else {
                $this->error('删除失败！');
            }
        }

    }

    public function roomImg()
    {


        if (IS_POST) {
            $Id = (I('post.id'));

            if (!$Id) {
                $this->error('未获取到ID');
            }
            $upload          = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts    = [
                'jpg',
                'gif',
                'png',
                'jpeg',
            ];
            // 设置附件上传类型
            $upload->rootPath = './Uploads/'; // 设置附件上传根目录
            // 上传文件
            $info = $upload->upload();
            if (!$info) {
                // 上传错误提示错误信息
                $this->error($upload->getError());
            } else {
                // 上传成功
                foreach ($info as $file) {
                    $name = $file['savepath'].$file['savename'];
                }
            }

            $image = new \Think\Image();
            $image->open('./Uploads/'.$name);

            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
            $image->thumb(750, 400, \Think\Image::IMAGE_THUMB_FIXED)
                  ->save('./Uploads/'.$name);
            $model          = M('room');
            $data['imgurl'] = $name;
            $res            = $model->where('id='.$Id)
                                    ->save($data);
            if (!$res) {
                $this->error('上传图片失败');
            }
            $this->success('上传图片成功');

        } else {
            $id = trim(I('get.id'));

            if (!$id) {
                $this->error('未获取到房间号');
            }
            $this->assign('id', $id);

            $this->display();


        }

    }


}
