<?php
namespace Org\Util;
class WechatTools {
	/**
    * curl获取请求文本内容
    */
    public function curl_contents($url, $method ='GET', $data = array()) {
        if ($method == 'POST') {
            //使用crul模拟
            $data = is_array($data) ? http_build_query($data) : $data;
            $ch = curl_init();
            //禁用https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //允许请求以文件流的形式返回
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch); //执行发送
            curl_close($ch);
        }else {
            //有参数则拼接发送
            $data = !empty($data) ? http_build_query($data) : '';
            if (!empty($data)) {
                $url .= stristr($url, '?') ? ('&'.$data) : ('?'.$data);
            }
            if (ini_get('allow_fopen_url') == '1') {
                $result = file_get_contents($url);
            }else {
                //使用crul模拟
                $ch = curl_init();
                //允许请求以文件流的形式返回
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                //禁用https
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_URL, $url);
                $result = curl_exec($ch); //执行发送
                curl_close($ch);
            }
        }
        return json_decode($result, true);
    }
	/**
    * 验证判断
    */
    public function valid($token) {
        $echostr = $this->checkSignature($token);
        if($echostr){
            exit($echostr);
        }
    }

    /**
    * 签名验证
    */
    private function checkSignature($token) {
        // you must define WXTOKEN by yourself
        $echostr = isset($_GET['echostr']) ? $_GET['echostr'] : '';
        $signature = isset($_GET['signature']) ? $_GET['signature'] : '';
        $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : '';
        $nonce = isset($_GET['nonce']) ? $_GET['nonce'] : '';
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature && $echostr){
            return $echostr;
        }else{
            return false;
        }
    }
	public function errcode($code) {
        $con = is_numeric($code) ? $this->returnCode($code) : $code;
        exit($con);
        //throw new \Exception($con);
	}
	public function returnCode($code) {
		if (empty($code)) return true;
		$res = '';
		switch($code) {
			case '-1': $res = '系统繁忙'; break;
			case '40001': $res = '获取access_token时AppSecret错误，或者access_token无效'; break;
			case '40002': $res = '不合法的凭证类型'; break;
			case '40003': $res = '不合法的OpenID，请确认OpenID（该用户）是否已关注公众号，或是否是其他公众号的OpenID'; break;
			case '40004': $res = '不合法的媒体文件类型'; break;
			case '40005': $res = '不合法的文件类型'; break;
			case '40006': $res = '不合法的文件大小'; break;
			case '40007': $res = '不合法的媒体文件id'; break;
			case '40008': $res = '不合法的消息类型'; break;
			case '40009': $res = '不合法的图片文件大小'; break;
			case '40010': $res = '不合法的语音文件大小'; break;
			case '40011': $res = '不合法的视频文件大小'; break;
			case '40012': $res = '不合法的缩略图文件大小'; break;
			case '40013': $res = '不合法的AppID，请检查AppID的正确性，避免异常字符，注意大小写'; break;
			case '40014': $res = '不合法的access_token，请认真比对access_token的有效性'; break;
			case '40015': $res = '不合法的菜单类型'; break;
			case '40016': $res = '不合法的按钮个数'; break;
			case '40017': $res = '不合法的按钮个数'; break;
			case '40018': $res = '不合法的按钮名字长度'; break;
			case '40019': $res = '不合法的按钮KEY长度'; break;
			case '40020': $res = '不合法的按钮URL长度'; break;
			case '40021': $res = '不合法的菜单版本号'; break;
			case '40022': $res = '不合法的子菜单级数'; break;
			case '40023': $res = '不合法的子菜单按钮个数'; break;
			case '40024': $res = '不合法的子菜单按钮类型'; break;
			case '40025': $res = '不合法的子菜单按钮名字长度'; break;
			case '40026': $res = '不合法的子菜单按钮KEY长度'; break;
			case '40027': $res = '不合法的子菜单按钮URL长度'; break;
			case '40028': $res = '不合法的自定义菜单使用用户'; break;
			case '40029': $res = '不合法的oauth_code'; break;
			case '40030': $res = '不合法的refresh_token'; break;
			case '40031': $res = '不合法的openid列表'; break;
			case '40032': $res = '不合法的openid列表长度'; break;
			case '40033': $res = '不合法的请求字符，不能包含\uxxxx格式的字符'; break;
			case '40035': $res = '不合法的参数'; break;
			case '40038': $res = '不合法的请求格式'; break;
			case '40039': $res = '不合法的URL长度'; break;
			case '40050': $res = '不合法的分组id'; break;
			case '40051': $res = '分组名字不合法'; break;
			case '40117': $res = '分组名字不合法'; break;
			case '40152': $res = '无效的组ID'; break;
			case '40118': $res = 'media_id大小不合法'; break;
			case '40119': $res = 'button类型错误'; break;
			case '40120': $res = 'button类型错误'; break;
			case '40121': $res = '不合法的media_id类型'; break;
			case '40132': $res = '微信号不合法'; break;
			case '40137': $res = '不支持的图片格式'; break;
			case '41001': $res = '缺少access_token参数'; break;
			case '41002': $res = '缺少appid参数'; break;
			case '41003': $res = '缺少refresh_token参数'; break;
			case '41004': $res = '缺少secret参数'; break;
			case '41005': $res = '缺少多媒体文件数据'; break;
			case '41006': $res = '缺少media_id参数'; break;
			case '41007': $res = '缺少子菜单数据'; break;
			case '41008': $res = '缺少oauth code'; break;
			case '41009': $res = '缺少openid'; break;
			case '42001': $res = 'access_token超时，请检查access_token的有效期'; break;
			case '42002': $res = 'refresh_token超时'; break;
			case '42003': $res = 'oauth_code超时'; break;
			case '43001': $res = '需要GET请求'; break;
			case '43002': $res = '需要POST请求'; break;
			case '43003': $res = '需要HTTPS请求'; break;
			case '43004': $res = '需要接收者关注'; break;
			case '43005': $res = '需要好友关系'; break;
			case '44001': $res = '多媒体文件为空'; break;
			case '44002': $res = 'POST的数据包为空'; break;
			case '44003': $res = '图文消息内容为空'; break;
			case '44004': $res = '文本消息内容为空'; break;
			case '45001': $res = '多媒体文件大小超过限制'; break;
			case '45002': $res = '消息内容超过限制'; break;
			case '45003': $res = '标题字段超过限制'; break;
			case '44004': $res = '文本消息内容为空'; break;
			case '45001': $res = '多媒体文件大小超过限制'; break;
			case '45004': $res = '描述字段超过限制'; break;
			case '45005': $res = '链接字段超过限制'; break;
			case '45007': $res = '语音播放时间超过限制'; break;
			case '45008': $res = '图文消息超过限制'; break;
			case '45009': $res = '接口调用超过限制'; break;
			case '45010': $res = '创建菜单个数超过限制'; break;
			case '45015': $res = '回复时间超过限制'; break;
			case '45016': $res = '系统分组，不允许修改'; break;
			case '45017': $res = '分组名字过长'; break;
			case '45018': $res = '分组数量超过上限'; break;
			case '46001': $res = '不存在媒体数据'; break;
			case '46002': $res = '不存在的菜单版本'; break;
			case '46003': $res = '不存在的菜单数据'; break;
			case '46004': $res = '不存在的用户'; break;
			case '47001': $res = '解析JSON/XML内容错误'; break;
			case '48001': $res = 'api功能未授权，请确认公众号已获得该接口'; break;
			case '50001': $res = '用户未授权该api'; break;
			case '50002': $res = '用户受限，可能是违规后接口被封禁'; break;
			case '61451': $res = '参数错误(invalid parameter)'; break;
			case '61452': $res = '无效客服账号(invalid kf_account)'; break;
			case '61453': $res = '客服帐号已存在(kf_account exsited)'; break;
			case '61454': $res = '客服帐号名长度超过限制(仅允许10个英文字符，不包括@及@后的公众号的微信号)(invalid kf_acount length)'; break;
			case '61455': $res = '客服帐号名包含非法字符(仅允许英文+数字)(illegal character in kf_account)'; break;
			case '61456': $res = '客服帐号个数超过限制(10个客服账号)(kf_account count exceeded)'; break;
			case '61457': $res = '无效头像文件类型(invalid file type)'; break;
			case '61450': $res = '系统错误(system error)'; break;
			case '61500': $res = '日期格式错误'; break;
			case '61501': $res = '日期范围错误'; break;
			case '9001001': $res = 'POST数据参数不合法'; break;
			case '9001002': $res = '远端服务不可用'; break;
			case '9001003': $res = 'Ticket不合法'; break;
			case '9001004': $res = '获取摇周边用户信息失败'; break;
			case '9001005': $res = '获取商户信息失败'; break;
			case '9001006': $res = '获取OpenID失败'; break;
			case '9001007': $res = '上传文件缺失'; break;
			case '9001008': $res = '上传素材的文件类型不合法'; break;
			case '9001009': $res = '上传素材的文件尺寸不合法'; break;
			case '9001010': $res = '上传失败'; break;
			case '9001020': $res = '帐号不合法'; break;
			case '9001021': $res = '已有设备激活率低于50%，不能新增设备'; break;
			case '9001022': $res = '设备申请数不合法，必须为大于0的数字'; break;
			case '9001023': $res = '已存在审核中的设备ID申请'; break;
			case '9001024': $res = '一次查询设备ID数量不能超过50'; break;
			case '9001025': $res = '设备ID不合法'; break;
			case '9001026': $res = '页面ID不合法'; break;
			case '9001027': $res = '页面参数不合法'; break;
			case '9001028': $res = '一次删除页面ID数量不能超过10'; break;
			case '9001029': $res = '页面已应用在设备中，请先解除应用关系再删除'; break;
			case '9001030': $res = '一次查询页面ID数量不能超过50'; break;
			case '9001031': $res = '时间区间不合法'; break;
			case '9001032': $res = '保存设备与页面的绑定关系参数错误'; break;
			case '9001033': $res = '门店ID不合法'; break;
			case '9001034': $res = '设备备注信息过长'; break;
			case '9001035': $res = '设备申请参数不合法'; break;
			case '9001036': $res = '查询起始值begin不合法'; break;
			default: $res = '请求成功'; break;
		}
		return $res;
	}
}
?>