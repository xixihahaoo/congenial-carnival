<?php
namespace Home\Controller;

use Think\Controller;

class BroadcastController extends CommonController
{

    /**
     * [index 直播]
     * @author li
     */
    public function index()
    {

        $header = [
            'AppKey'  => 'db7f50d587ab9499595ae4505b8117e8',
            'Nonce'   => rand(),
            'CurTime' => time(),
        ];

        $header['CheckSum'] = sha1('009d7beea99c'.$header['Nonce'].$header['CurTime'], false);

        $data['cid'] = 'd6e42b3edac041d1ae804c414452d99d';

        $url = 'https://vcloud.163.com/app/channelstats';

        $res = $this->creatTokenPost($header, json_encode($data), $url);  //获取当前直播间状态

        //获取当前聊天室
        $room = M('room')->find();
        $this->assign('room', $room);

        //获取6小时之内历史消息
        $prefix = C('DB_PREFIX');
        $chat   = M('ChatMsg a')
            ->field('a.uid,a.msg,a.type,b.face,b.nickname')
            ->where('FROM_UNIXTIME(a.dateline,"%Y-%m-%d %H:%i:%s") > NOW()-INTERVAL 6 HOUR')
            ->join('left join '.$prefix.'userinfo b on a.uid=b.uid')
            ->select();


        $model = M('room');
        $img   = $model->where('id=1')
                       ->getField('imgurl');

        //直播课程表
        $liveFid    = M('newsclass')->where(['fid' => 23])->getField('fid');
        $leveInfo   = M('newsinfo')->field('nid,ntitle,ncontent,ncover')->where(['ncategory' => $liveFid,'lang' => LANG_SHOW])->select();

        foreach ($leveInfo as $key => $value) {
            $leveInfo[$key]['ncontent'] = html_entity_decode($value['ncontent']);

            if(LANG == 'zh-tw') {
                $leveInfo[$key]['ntitle']   = simpleTradition($value['ntitle']);
                $leveInfo[$key]['ncontent'] = simpleTradition($leveInfo[$key]['ncontent']);
            }

        }

        $this->assign('leveinfo',$leveInfo);
        $this->assign('imgurl', $img);
        $this->assign('chat', $chat);
        $this->assign('code', $res['code']);
        $this->assign('status', $res['ret']['status']);
        $this->assign('user_id', $this->user_id);    //当前用户编号
        $this->display();
    }


    public function creatTokenPost($header, $data, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'AppKey: '.$header['AppKey'],
                'Nonce: '.$header['Nonce'],
                'CurTime: '.$header['CurTime'],
                'CheckSum: '.$header['CheckSum'],
            ]);
        $info    = curl_exec($ch);
        $infoArr = json_decode($info, true);
        curl_close($ch);

        return $infoArr;
    }

}
