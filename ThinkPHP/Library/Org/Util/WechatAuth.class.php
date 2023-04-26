<?php
namespace Org\Util;
use Org\Util\WechatTools;
//微信高级接口
class WechatAuth {
	/* 消息类型常量 */
    const MSG_TYPE_TEXT       = 'text';
    const MSG_TYPE_IMAGE      = 'image';
    const MSG_TYPE_VOICE      = 'voice';
    const MSG_TYPE_VIDEO      = 'video';
    const MSG_TYPE_SHORTVIDEO = 'shortvideo';
    const MSG_TYPE_LOCATION   = 'location';
    const MSG_TYPE_LINK       = 'link';
    const MSG_TYPE_MUSIC      = 'music';
    const MSG_TYPE_NEWS       = 'news';
    const MSG_TYPE_EVENT      = 'event';
    
    /* 二维码类型常量 */
    const QR_SCENE       = 'QR_SCENE';
    const QR_LIMIT_SCENE = 'QR_LIMIT_SCENE';

    /**
     * 微信开发者申请的appID
     * @var string
     */
    private $appid = '';

    /**
     * 微信开发者申请的appSecret
     * @var string
     */
    private $appsecret = '';

    /**
     * 获取到的access_token
     * @var string
     */
    private $accessToken = '';

    /**
     * 微信api根路径
     * @var string
     */
    private $apiURL = 'https://api.weixin.qq.com/cgi-bin';
    private $apiService = 'https://api.weixin.qq.com/customservice';//客服接口

    /**
     * 微信二维码根路径
     * @var string
     */
    private $qrcodeURL = 'https://mp.weixin.qq.com/cgi-bin';

    private $requestCodeURL = 'https://open.weixin.qq.com/connect/oauth2/authorize';

    private $oauthApiURL = 'https://api.weixin.qq.com/sns';

    private $tools;

    /**
     * 构造方法，调用微信高级接口时实例化SDK
     */
    public function __construct($token, $appid, $secret){
    	$this->tools = new WechatTools();
        $this->tools->valid($token);
        if($appid && $secret){
        	$this->appid = $appid;
            $this->appsecret = $secret;
        	$this->accessToken = $this->getAccessToken();
        } else {
        	$this->tools->errcode('缺少参数 APP_ID 和 APP_SECRET!');
        }
    }

    /**
    * 获取微信服务器IP地址
    */
    public function getcallbackip() {
    	$res = $this->api("getcallbackip", 'GET');
        if (isset($res['errcode'])) {
            $this->tools->errcode($res['errcode']);   
        }
        return $res['ip_list'];
    }

    /**
    * 获取access_token
    */
    public function getAccessToken($type = 'client', $code = '') {
    	$param = array(
    		'appid' =>  $this->appid,
    		'secret' => $this->appsecret
    	);
        $token = '';
        switch($type) {
        	case 'client':
        		$param['grant_type'] = 'client_credential';
        		$url = "{$this->apiURL}/token";
        		if (!S("wx_access_token_{$this->appid}")) {
        			$res = $this->api("token", 'GET', $param);
		            if (isset($res['errcode'])) {
		                $this->tools->errcode($res['errcode']);   
		            }
		            //设置缓存过期时间为6000
		            S("wx_access_token_{$this->appid}", $res['access_token'], 3600);
		        }
		        $token = S("wx_access_token_{$this->appid}");
        		break;
        	case 'code':
        		$param['code'] = $code;
        		$param['grant_type'] = 'authorization_code';
        		$url = "{$this->oauthApiURL}/oauth2/access_token";
        		$res = $this->tools->curl_contents($url, 'GET', $param);
	            if (isset($res['errcode'])) {
	                $this->tools->errcode($res['errcode']);   
	            }
	            $token = $res['access_token'];
        		break;
        	default :
        		$this->tools->errcode('不支持的grant_type类型！');
        		break;
        }
        return $token;
    }

    public function getRequestCodeURL($redirect_uri, $state = null, $scope = 'snsapi_userinfo'){
        
        $param = array(
            'appid'         => $this->appid,
            'redirect_uri'  => $redirect_uri,
            'response_type' => 'code',
            'scope'         => $scope,
        );

        if(!is_null($state) && preg_match('/[a-zA-Z0-9]+/', $state)){
            $param['state'] = $state;
        }

        $param = http_build_query($param);
        return "{$this->requestCodeURL}?{$param}#wechat_redirect";
    }

    /**
     * 获取授权用户信息
     * @param  string $openid 用户的OpenID
     * @param  string $lang   指定的语言
     * @return array          用户信息数据，具体参见微信文档
     */
    public function getUserInfo($openid, $lang = 'zh_CN'){
        $param = array(
            'access_token' => $this->accessToken,
            'openid'       => $openid,
            'lang'         => $lang,
        );
        $res = $this->tools->curl_contents("{$this->oauthApiURL}/userinfo", 'GET', $param);
        return $res;
    }

    /**
     * 获取指定用户的详细信息
     * @param  string $openid 用户的openid
     * @param  string $lang   需要获取数据的语言
     */
    public function userInfo($openid, $lang = 'zh_CN'){
        $param = array('openid' => $openid, 'lang' => $lang);
        return $this->api("user/info", 'GET', $param);
    }

    /**
     * 批量获取用户基本信息
     */
    public function userBatchget($openid = array(), $lang = 'zh_CN'){
        $param = array();
        foreach($openid as $key => $id) {
        	$param[] = array( 'openid' => $id, 'lang' => $lang );
        	if ($key >= 99) break;//一次最多拉取100个用户信息
        }
        $param = array('user_list' => $param);
        return $this->api("user/info/batchget", 'POST', $param);
    }

    /**
     * 获取关注者列表
     * @param  string $next_openid 下一个openid，在用户数大于10000时有效
     * @return array               用户列表
     */
    public function userGet($next_openid = ''){
        $param = array('next_openid' => $next_openid);
        return $this->api("user/get", 'GET', $param);
    }

    /**
     * 设置用户备注
     */
    public function userUpdateRemark($openid, $remark){
        $param = array(
        	'openid' => $openid,
        	'remark' => $remark
        );
        return $this->api("user/info/updateremark", 'POST', $param);
    }

    /**
     * 查询用户分组
     */
    public function groupsGet() {
    	return $this->api("groups/get", 'GET');
    }

    /**
     * 查询用户所在分组
     */
    public function groupsGetid($openid) {
    	$param = array( 'openid' => $openid );
    	return $this->api("groups/getid", 'POST', $param);
    }

    /**
     * 创建分组
     */
    public function groupsCreate($name) {
    	$param = array( 'group' => array( 'name' => $name ) );
    	return $this->api("groups/create", 'POST', $param);
    }

    /**
     * 修改分组
     */
    public function groupsUpdate($id, $name) {
    	$param = array( 'group' => array( 'id' => $id, 'name' => $name ) );
    	return $this->api("groups/update", 'POST', $param);
    }

    /**
     * 移动分组
     */
    public function groupsMove($openid, $to_groupid) {
    	$param = array( 'openid' => $openid, 'to_groupid' => $to_groupid );
    	return $this->api("groups/members/update", 'POST', $param);
    }

    /**
     * 批量移动分组
     */
    public function groupsMovebatch($openid_list, $to_groupid) {
    	$param = array( 'openid_list' => $openid_list, 'to_groupid' => $to_groupid );
    	return $this->api("groups/members/batchupdate", 'POST', $param);
    }

    /**
     * 删除分组
     */
    public function groupsDelete($id) {
    	$param = array( 'group' => array( 'id' => $id ) );
    	return $this->api("groups/delete", 'POST', $param);
    }

    /**
    * 创建微信菜单
    */
    public function menuCreate($button) {
        return $this->api("menu/create", 'POST', $button);
    }

    /**
     * 获取所有的自定义菜单
     * @return array  自定义菜单数组
     */
    public function menuGet(){
        return $this->api("menu/get", 'GET');
    }

    /**
     * 删除自定义菜单
     */
    public function menuDelete(){
    	return $this->api("menu/delete", 'GET');
    }

    /*
	 * 客服管理
	 * $type 操作类型，添加、修改、删除
	 * $kf_account 账号前缀@公众号微信号
	 * $nickname 最长6个汉字或12个英文字符
	 * $password 客服账号登录密码，格式为密码明文的32位加密MD5值
    */
    private function kfaccount($type, $kf_account, $nickname, $password) {
    	$param = array(
    		'kf_account' => $kf_account,	//客服账号
    		'nickname' => $nickname,		//客服名称
    		'password' => md5($password)	//客服密码
    	);
    	return $this->apiKF("kfaccount/{$type}", 'POST', $param);
    }

    /*
	 * 客服管理 - 添加客服
    */
    public function kfaccountAdd($kf_account, $nickname, $password) {
    	return $this->kfaccount('add', $kf_account, $nickname, $password);
    }

    /*
	 * 客服管理 - 修改客服
    */
    public function kfaccountUpdate($kf_account, $nickname, $password) {
    	return $this->kfaccount('update', $kf_account, $nickname, $password);
    }

    /*
	 * 客服管理 - 删除客服
    */
    public function kfaccountDel($kf_account, $nickname, $password) {
    	return $this->kfaccount('del', $kf_account, $nickname, $password);
    }

    /**
     * 设置客服账号头像
     */
    public function kfaccountUploadheadimg($filename, $kf_account) {
    	$filename = realpath($filename);
        if(!$filename) $this->tools->errcode('资源路径错误！');
        $param  = array(
        	'kf_account' => $kf_account,
            'media' => "@{$filename}"
        );
        return $this->apiKF("kfaccount/uploadheadimg?kf_account={$kf_account}", 'POST', $param);
    }

    /*
	 * 获取所有客服账号
	 *	kf_account	完整客服账号，格式为：账号前缀@公众号微信号
	 *	kf_nick	客服昵称
	 *	kf_id	客服工号
    */
    public function kfaccountGet() {
    	return $this->api('customservice/getkflist', 'GET');
    }

    /*
	 * 创建客服会话
	 * openid	是	客户openid
	 *	kf_account	是	完整客服账号，格式为：账号前缀@公众号微信号
	 *	text	否	附加信息，文本会展示在客服人员的多客服客户端
    */
    public function kfsessionCreate($openid, $kf_account, $text = '') {
    	$param = array(
    		'openid' => $openid,
    		'kf_account' => $kf_account,
    		'text' => $text
    	);
    	return $this->apiKF('kfsession/create', 'POST', $param);
    }

    /*
	 * 关闭会话
	 * openid	是	客户openid
	 *	kf_account	是	完整客服账号，格式为：账号前缀@公众号微信号
	 *	text	否	附加信息，文本会展示在客服人员的多客服客户端
    */
    public function kfsessionClose($openid, $kf_account, $text = '') {
    	$param = array(
    		'openid' => $openid,
    		'kf_account' => $kf_account,
    		'text' => $text
    	);
    	return $this->apiKF('kfsession/close', 'POST', $param);
    }

    /*
	 * 获取客户会话状态
	 * openid	是	客户openid
    */
    public function kfsessionGetsession($openid) {
    	$param = array( 'openid' => $openid );
    	return $this->apiKF('kfsession/getsession', 'GET', $param);
    }

    /*
	 * 获取客服的会话列表
	 * kf_account	完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符。
    */
    public function kfsessionGetsessionlist($kf_account) {
    	$param = array( 'kf_account' => $kf_account );
    	return $this->apiKF('kfsession/getsessionlist', 'GET', $param);
    }

    /*
	 * 获取未接入会话列表
	 * return
	 * count	未接入会话数量
	 *	waitcaselist	未接入会话列表，最多返回100条数据
	 *	waitcaselist.openid	客户openid
	 *	waitcaselist.kf_account	指定接待的客服，为空表示未指定客服
	 *	waitcaselist.createtime	用户来访时间，UNIX时间戳
    */
    public function kfsessionGetwaitcase() {
    	return $this->apiKF('kfsession/getwaitcase', 'GET');
    }

    /**
	 * 获取客服聊天记录接口
	 *  access_token	是	调用接口凭证
	 *	starttime	是	查询开始时间，UNIX时间戳
	 *	endtime	是	查询结束时间，UNIX时间戳，每次查询不能跨日查询
	 *	pagesize	是	每页大小，每页最多拉取50条
	 *	pageindex	是	查询第几页，从1开始
     */
    public function kfGetrecord($starttime, $endtime, $pagesize = 50, $pageindex = 1) {
    	$param = array(
    		'starttime' => $starttime,
    		'endtime' => $endtime,
    		'pagesize' => $pagesize,
    		'pageindex' => $pageindex
    	);
    	return $this->apiKF('msgrecord/getrecord', 'POST', $param);
    }

    /**
     * 请求 apiKF
     */
    public function apiKF($url, $method = 'GET', $param = array(), $json = true) {
    	if ($method == 'POST' && $json && !empty($param)) {
    		//如果是POST数据，则转化成JSON格式发送
    		$param = json_encode($param, JSON_UNESCAPED_UNICODE);
    	}
    	$url = "{$this->apiService}/{$url}";
    	$url .= stristr($url, '?') ? ("&access_token={$this->accessToken}") : ("?access_token={$this->accessToken}");
    	return $this->tools->curl_contents($url, $method, $param);
    }

    /**
	 * 获取在线客服接待信息
	 * return 
	 *  kf_account	完整客服账号，格式为：账号前缀@公众号微信号
	 *	status	客服在线状态 1：pc在线，2：手机在线。若pc和手机同时在线则为 1+2=3
	 *	kf_id	客服工号
	 *	auto_accept	客服设置的最大自动接入数
	 *	accepted_case	客服当前正在接待的会话数
     */
    public function kfaccountGetonlineflist() {
    	return $this->api('customservice/getonlinekflist', 'GET');
    }

    /**
     * 长链接转短链接
     * @param  string $long_url 长链接
     * @return string           短链接
     */
    public function shorturl($long_url){
        $param = array(
            'action'   => 'long2short',
            'long_url' => $long_url
        );
        $res = $this->api("shorturl", 'POST', $param);
        if ($res['errcode'] != 0) {
            $this->tools->errcode($res['errcode']);   
        }
        return $res['short_url'];
    }

    /**
     * 创建二维码，可创建指定有效期的二维码和永久二维码
     * @param  integer $scene_id       二维码参数
     * @param  integer $expire_seconds 二维码有效期，0-永久有效
     */
    public function qrcodeCreate($scene_id, $expire_seconds = 0, $scene_str = ''){
        $param = array();
        if(is_numeric($expire_seconds) && $expire_seconds > 0){
            $param['expire_seconds'] = $expire_seconds;
            $param['action_name']    = self::QR_SCENE;
        } else {
            $param['action_name']    = self::QR_LIMIT_SCENE;
        }
        if (!empty($scene_str) && is_numeric($scene_str)) {
        	$param['action_info']['scene']['scene_str'] = $scene_str;
        }
        $param['action_info']['scene']['scene_id'] = $scene_id;
        return $this->api("qrcode/create", 'POST', $param);
    }

    /**
     * 根据ticket获取二维码URL
     * @param  string $ticket 通过 qrcodeCreate接口获取到的ticket
     * @return string         二维码URL
     */
    public function showqrcode($ticket){
    	$ticket = urlencode($ticket);
        return "{$this->qrcodeURL}/showqrcode?ticket={$ticket}";
    }

    /**
     * 给指定用户推送信息
     * 注意：微信规则只允许给在48小时内给公众平台发送过消息的用户推送信息
     */
    public function messageCustomSend($openid, $content, $type = self::MSG_TYPE_TEXT, $kf_account = ''){
    	//基础数据
        $param = array(
            'touser'=>$openid,
            'msgtype'=>$type,
        );
        //根据类型附加额外数据
        $param[$type] = $content;
        //如果是客服发送消息，则加入customservice参数
        if (!empty($kf_account)) {
        	$param['customservice'] = $kf_account;
        }
        return $this->api("message/custom/send", 'POST', $param);
    }

    /**
     * 发送文本消息
     */
    public function sendText($openid, $text, $kf_account = ''){
        return $this->messageCustomSend($openid, array('content' => $text), self::MSG_TYPE_TEXT, $kf_account);
    }

    /**
     * 发送图片消息
     */
    public function sendImage($openid, $media_id){
    	$param = array( 'media_id' => $media_id );
        return $this->messageCustomSend($openid, $param, self::MSG_TYPE_IMAGE);
    }

    /**
     * 发送语音消息
     */
    public function sendVoice($openid, $media_id){
    	$param = array( 'media_id' => $media_id );
        return $this->messageCustomSend($openid, $param, self::MSG_TYPE_VOICE);
    }

    /**
     * 发送视频消息
     */
    public function sendVideo(){
    	$param = func_get_args();
    	$openid = array_shift($param);
        return $this->messageCustomSend($openid, $param, self::MSG_TYPE_VIDEO);
    }

    /**
     * 发送音乐消息
     */
    public function sendMusic(){
    	$param = func_get_args();
    	$openid = array_shift($param);
        return $this->messageCustomSend($openid, $param, self::MSG_TYPE_MUSIC);
    }

    /**
     * 发送图文消息
     */
    public function sendNews(){
    	$param = func_get_args();
    	$openid = array_shift($param);
    	$param = array('articles' => $param);
        return $this->messageCustomSend($openid, $param, self::MSG_TYPE_NEWS);
    }

    /**
     * 上传临时媒体资源
     * @param  string $filename 媒体资源本地路径
     * @param  string $type     媒体资源类型，具体请参考微信开发手册
     */
    public function mediaUpload($filename, $type){
        $filename = realpath($filename);
        if(!$filename) $this->tools->errcode('资源路径错误！');
        $param  = array(
            'type'  => $type,
            'media' => "@{$filename}"
        );
        return $this->api("media/upload?type=$type", 'POST', $param);
    }

    /**
     * 上传永久媒体资源
     * @param string $filename    媒体资源本地路径
     * @param string $type        媒体资源类型，具体请参考微信开发手册
     * @param string $description 资源描述，仅资源类型为 video 时有效
     */
    public function materialAddMaterial($filename, $type, $description = ''){
        $filename = realpath($filename);
        if(!$filename) $this->tools->errcode('资源路径错误！');
        
        $param = array(
            'type'  => $type,
            'media' => "@{$filename}",
        );

        if($type == 'video'){
            if(is_array($description)){
                //保护中文，微信api不支持中文转义的json结构
                array_walk_recursive($description, function(&$value){
                    $value = urlencode($value);
                });
                $description = urldecode(json_encode($description));
            }
            $param['description'] = $description;
        }
        return $this->api("material/add_material?type=$type", 'POST', $param);
    }

    /**
     * 获取媒体资源下载地址
     * 注意：视频资源不允许下载
     * @param  string $media_id 媒体资源id
     * @return string           媒体资源下载地址
     */
    public function mediaGet($media_id){
        $param = array(
            'access_token' => $this->accessToken,
            'media_id'     => $media_id
        );

        $url = "{$this->apiURL}/media/get?";
        return $url . http_build_query($param);
    }

    /*
	 * 模版消息 设置所属行业
    */
    public function templateSetIndustry($industry_id1, $industry_id2) {
    	$param = array(
    		'industry_id1' => $industry_id1,
    		'industry_id2' => $industry_id2
    	);
    	return $this->api('template/api_set_industry', 'POST', $param);
    }

    /*
	 * 模版消息 获取设置的行业信息
	 * return primary_industry	帐号设置的主营行业
	 * return secondary_industry	帐号设置的副营行业
    */
   	public function industryGet() {
   		return $this->api('template/get_industry', 'GET');
   	}

   	/*
	 * 模版消息 获得模板ID
    */
   	public function templateGetid($template_id_short) {
   		return $this->api('template/api_add_template', 'POST', array('template_id_short' => $template_id_short));
   	}

   	/*
	 * 模版消息 获取模板列表
	 * return array
    */
    public function templateGetall() {
    	return $this->api('template/get_all_private_template', 'GET');
    }

    /*
	 * 删除模版消息
    */
    public function templateDelete($template_id) {
    	return $this->api('template/del_private_template', 'POST', array('template_id' => $template_id));
    }

    /*
	 * 发送模版消息
    */
    public function templateSend($param) {
    	return $this->api('message/template/send', 'POST', $param);
    }

    /**
     * 请求api
     */
    public function api($url, $method = 'GET', $param = array(), $json = true) {
    	if ($method == 'POST' && $json && !empty($param)) {
    		//如果是POST数据，则转化成JSON格式发送
    		$param = json_encode($param, JSON_UNESCAPED_UNICODE);
    	}
    	$url = "{$this->apiURL}/{$url}";
    	$url .= stristr($url, '?') ? ("&access_token={$this->accessToken}") : ("?access_token={$this->accessToken}");
    	return $this->tools->curl_contents($url, $method, $param);
    }

}
?>