<?php
// +----------------------------------------------------------------------
// | 数据推送绑定 控制器
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
namespace Pc\Controller;
use Think\Controller;
use Org\Util\Gateway;

class BindController extends Controller{

	public function _initialize()
	{    
        $this->user_id = session('user_id');
	}


    public function bindUid()
    {
        if(!$this->user_id) return false;

        $client_id = trim(I('post.client_id'));

        Gateway::$registerAddress = '127.0.0.1:1240';

        Gateway::bindUid($client_id, $this->user_id);

        $clientObj = M('user_client');

        $data = $clientObj->where(array('user_id' => $this->user_id))->find();

        if($data)
        {
            $clientObj->where(array('user_id' => $this->user_id))->setField(array('client_id' => $client_id,'dateline' => time()));

        } else {
            $clientObj->add(array('user_id' =>$this->user_id,'client_id' => $client_id,'dateline' => time()));
        }

        //$message = 'hello';
        //Gateway::sendToUid($this->user_id, $message);
        
        var_export(Gateway::getClientIdByUid($this->user_id));
    }


    public function binding()
    {
        Gateway::$registerAddress = '127.0.0.1:1240';
        
        $uid    = trim(I('post.client_id'));

        $group  = explode(',',trim(I('post.group')));

        $option_key    = trim(I('post.option_key'));

        //file_put_contents('/tmp/my-workerman.log', $option_key."\n", FILE_APPEND | LOCK_EX);

        foreach ($group as $key => $value) {

            Gateway::joinGroup($uid,$value);
        }

        //$message = 'hello';
        //Gateway::sendToGroup('group', $message);  //发送信息

        //var_export(Gateway::getClientCountByGroup($group));  //获取分组当前在线成员数
        
        var_export(Gateway::getAllClientCount());   //获取当前在线连接总数（多少client_id在线）。
    }


    //群组聊天
    public function groupChatBind()
    {
        Gateway::$registerAddress = '127.0.0.1:1240';
        
        $client_id      = trim(I('post.client_id'));
        $group          = trim(I('post.group'));

        Gateway::joinGroup($client_id,$group);

        $people_count = Gateway::getClientCountByGroup($group);

        //更新当前房间人数
        M('room')->where(array('group' => $group))->setField('people_count',$people_count);

        outjson(array('count' => $people_count));
    }

    // 接受用户的信息 并且发送
    public function sendChat()
    {
        $this->isLogin();   //检测是否登录

        //检测账户是否大于10美金
        $accountObj = M('accountinfo');
        $balance = $accountObj->where()->getField('balance');

        if($balance < 10)
            outjson(array('code' => 400,'msg' => L('api_less')));


        Gateway::$registerAddress = '127.0.0.1:1240';

        $message    = trim(I('post.message'));
        $group      = trim(I('post.group'));

        if(empty($message))
            outjson(array('code' => 400,'msg' => L('api_input_msg')));

        if(empty($group))
            outjson(array('code' => 400,'msg' => L('api_fail')));

        //根据房间唯一标识获取当前房间编号
        $room_id    = M('room')->where(array('group' => $group))->getField('id');

        if(!$room_id)
            outjson(array('code' => 400,'msg' => L('api_get_room')));
        
        //根据房间编号获取对应主播状态
        $anchor     = M('anchor')->field('group_concat( distinct uid) anchorUid')->where('room_id='.$room_id)->find();

        $anchorArr = explode(',',$anchor['anchorUid']);

        $user_id    = $this->user_id;

        if(in_array($user_id,$anchorArr))
            $type = 2;  //主播
        else
            $type = 1;  //普通会员

        //对发送的消息进行记录
        $chat = array(
            'uid'       => $user_id,
            'msg'       => $message,
            'type'      => $type,
            'dateline'  => time()
        );

        $res = M('ChatMsg')->add($chat);

        if($res)
        {
            $user = M('userinfo')->field('face,nickname')->where(array('uid' => $user_id))->find();

            $dataArr=json_encode(array(
                'user_id'   => $user_id,
                'face'      => $user['face'],
                'nickname'  => $user['nickname'],
                'message'   => $message,
                'type'      => $type
            ));

            Gateway::sendToGroup($group,$dataArr);

            outjson(array('code' => 200,'msg' => L('get_send_success')));
        } else {
            outjson(array('code' => 400,'msg' => L('get_send_success')));
        }
    }

    /**
     * [isLogin 检测是否登录]
     * @return boolean [description]
     */
    private function isLogin()
    {
        if(!$this->user_id)
            outjson(array('code' => 400,'msg' => L('no_login')));
    }
}