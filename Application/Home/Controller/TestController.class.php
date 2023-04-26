<?php
/**
 * @author     : FrankHong
 * @datetime   : 2016/11/8 15:07
 * @filename   : TestController.class.php
 * @description: 代码样例
 * @note       :
 * 1.手机验证码使用样例
 *
 */

namespace Home\Controller;

use Think\Controller;
use Org\Util\Log;
use Org\Util\FileCache;
use Org\Util\Work;
use Org\Util\Gateway;
use Think\Cache\Driver\Redis;

use Org\Util\Jpush;

class TestController extends Controller
{
    //银联快捷
    // const APPID         = 201804159397;                                                                 //appid
    // const KEY           = 'c450fc81d139481f027bf1a47127531b2a190885';                                   //商户key

    //人脸快捷
    const APPID = 201805178920;                                                                 //appid
    const KEY   = 'f76182117dd62d7eca1927aae23a369b91bc0303';                                   //商户key

    const PREORDER_URL = 'http://t.pay.platform.api.taidupay.com/api/pay/unifiedOrder';                //预下单接口
    const PAY_URL      = 'http://t.pay.platform.api.taidupay.com/api/pay/UnifiedSubmitQuickPayCode';   //快捷支付接口
    const SMS_URL      = 'http://t.pay.platform.api.taidupay.com/api/pay/UnifiedResQuickPayCode';      //短信重发接口

    //常用简体
    private static $sd = "皑蔼碍爱翱袄奥坝罢摆败颁办绊帮绑镑谤剥饱宝报鲍辈贝钡狈备惫绷笔毕毙币闭边编贬变辩辫标鳖别瘪濒滨宾摈饼并拨钵铂驳卜补财参蚕残惭惨灿苍舱仓沧厕侧册测层诧搀掺蝉馋谗缠铲产阐颤场尝长偿肠厂畅钞车彻尘沉陈衬撑称惩诚骋痴迟驰耻齿炽冲虫宠畴踌筹绸丑橱厨锄雏础储触处传疮闯创锤纯绰辞词赐聪葱囱从丛凑蹿窜错达带贷担单郸掸胆惮诞弹当挡党荡档捣岛祷导盗灯邓敌涤递缔颠点垫电淀钓调迭谍叠钉顶锭订丢东动栋冻斗犊独读赌镀锻断缎兑队对吨顿钝夺堕鹅额讹恶饿儿尔饵贰发罚阀珐矾钒烦范贩饭访纺飞诽废费纷坟奋愤粪丰枫锋风疯冯缝讽凤肤辐抚辅赋复负讣妇缚该钙盖干赶秆赣冈刚钢纲岗皋镐搁鸽阁铬个给龚宫巩贡钩沟构购够蛊顾剐关观馆惯贯广规硅归龟闺轨诡柜贵刽辊滚锅国过骇韩汉号阂鹤贺横轰鸿红后壶护沪户哗华画划话怀坏欢环还缓换唤痪焕涣黄谎挥辉毁贿秽会烩汇讳诲绘荤浑伙获货祸击机积饥讥鸡绩缉极辑级挤几蓟剂济计记际继纪夹荚颊贾钾价驾歼监坚笺间艰缄茧检碱硷拣捡简俭减荐槛鉴践贱见键舰剑饯渐溅涧将浆蒋桨奖讲酱胶浇骄娇搅铰矫侥脚饺缴绞轿较秸阶节茎鲸惊经颈静镜径痉竞净纠厩旧驹举据锯惧剧鹃绢杰洁结诫届紧锦仅谨进晋烬尽劲荆觉决诀绝钧军骏开凯颗壳课垦恳抠库裤夸块侩宽矿旷况亏岿窥馈溃扩阔蜡腊莱来赖蓝栏拦篮阑兰澜谰揽览懒缆烂滥捞劳涝乐镭垒类泪篱离里鲤礼丽厉励砾历沥隶俩联莲连镰怜涟帘敛脸链恋炼练粮凉两辆谅疗辽镣猎临邻鳞凛赁龄铃凌灵岭领馏刘龙聋咙笼垄拢陇楼娄搂篓芦卢颅庐炉掳卤虏鲁赂禄录陆驴吕铝侣屡缕虑滤绿峦挛孪滦乱抡轮伦仑沦纶论萝罗逻锣箩骡骆络妈玛码蚂马骂吗买麦卖迈脉瞒馒蛮满谩猫锚铆贸么霉没镁门闷们锰梦谜弥觅幂绵缅庙灭悯闽鸣铭谬谋亩钠纳难挠脑恼闹馁内拟腻撵捻酿鸟聂啮镊镍柠狞宁拧泞钮纽脓浓农疟诺欧鸥殴呕沤盘庞赔喷鹏骗飘频贫苹凭评泼颇扑铺朴谱栖凄脐齐骑岂启气弃讫牵扦钎铅迁签谦钱钳潜浅谴堑枪呛墙蔷强抢锹桥乔侨翘窍窃钦亲寝轻氢倾顷请庆琼穷趋区躯驱龋颧权劝却鹊确让饶扰绕热韧认纫荣绒软锐闰润洒萨鳃赛叁伞丧骚扫涩杀纱筛晒删闪陕赡缮伤赏烧绍赊摄慑设绅审婶肾渗声绳胜圣师狮湿诗尸时蚀实识驶势适释饰视试寿兽枢输书赎属术树竖数帅双谁税顺说硕烁丝饲耸怂颂讼诵擞苏诉肃虽随绥岁孙损笋缩琐锁獭挞抬态摊贪瘫滩坛谭谈叹汤烫涛绦讨腾誊锑题体屉条贴铁厅听烃铜统头秃图涂团颓蜕脱鸵驮驼椭洼袜弯湾顽万网韦违围为潍维苇伟伪纬谓卫温闻纹稳问瓮挝蜗涡窝卧呜钨乌污诬无芜吴坞雾务误锡牺袭习铣戏细虾辖峡侠狭厦吓锨鲜纤咸贤衔闲显险现献县馅羡宪线厢镶乡详响项萧嚣销晓啸蝎协挟携胁谐写泻谢锌衅兴汹锈绣虚嘘须许叙绪续轩悬选癣绚学勋询寻驯训讯逊压鸦鸭哑亚讶阉烟盐严颜阎艳厌砚彦谚验鸯杨扬疡阳痒养样瑶摇尧遥窑谣药爷页业叶医铱颐遗仪彝蚁艺亿忆义诣议谊译异绎荫阴银饮隐樱婴鹰应缨莹萤营荧蝇赢颖哟拥佣痈踊咏涌优忧邮铀犹游诱舆鱼渔娱与屿语吁御狱誉预驭鸳渊辕园员圆缘远愿约跃钥岳粤悦阅云郧匀陨运蕴酝晕韵杂灾载攒暂赞赃脏凿枣灶责择则泽贼赠扎札轧铡闸栅诈斋债毡盏斩辗崭栈战绽张涨帐账胀赵蛰辙锗这贞针侦诊镇阵挣睁狰争帧郑证织职执纸挚掷帜质滞钟终种肿众诌轴皱昼骤猪诸诛烛瞩嘱贮铸筑驻专砖转赚桩庄装妆壮状锥赘坠缀谆着浊兹资渍踪综总纵邹诅组钻";

    //常用繁体
    private static $td = "皚藹礙愛翺襖奧壩罷擺敗頒辦絆幫綁鎊謗剝飽寶報鮑輩貝鋇狽備憊繃筆畢斃幣閉邊編貶變辯辮標鼈別癟瀕濱賓擯餅並撥缽鉑駁蔔補財參蠶殘慚慘燦蒼艙倉滄廁側冊測層詫攙摻蟬饞讒纏鏟産闡顫場嘗長償腸廠暢鈔車徹塵沈陳襯撐稱懲誠騁癡遲馳恥齒熾沖蟲寵疇躊籌綢醜櫥廚鋤雛礎儲觸處傳瘡闖創錘純綽辭詞賜聰蔥囪從叢湊躥竄錯達帶貸擔單鄲撣膽憚誕彈當擋黨蕩檔搗島禱導盜燈鄧敵滌遞締顛點墊電澱釣調叠諜疊釘頂錠訂丟東動棟凍鬥犢獨讀賭鍍鍛斷緞兌隊對噸頓鈍奪墮鵝額訛惡餓兒爾餌貳發罰閥琺礬釩煩範販飯訪紡飛誹廢費紛墳奮憤糞豐楓鋒風瘋馮縫諷鳳膚輻撫輔賦複負訃婦縛該鈣蓋幹趕稈贛岡剛鋼綱崗臯鎬擱鴿閣鉻個給龔宮鞏貢鈎溝構購夠蠱顧剮關觀館慣貫廣規矽歸龜閨軌詭櫃貴劊輥滾鍋國過駭韓漢號閡鶴賀橫轟鴻紅後壺護滬戶嘩華畫劃話懷壞歡環還緩換喚瘓煥渙黃謊揮輝毀賄穢會燴彙諱誨繪葷渾夥獲貨禍擊機積饑譏雞績緝極輯級擠幾薊劑濟計記際繼紀夾莢頰賈鉀價駕殲監堅箋間艱緘繭檢堿鹼揀撿簡儉減薦檻鑒踐賤見鍵艦劍餞漸濺澗將漿蔣槳獎講醬膠澆驕嬌攪鉸矯僥腳餃繳絞轎較稭階節莖鯨驚經頸靜鏡徑痙競淨糾廄舊駒舉據鋸懼劇鵑絹傑潔結誡屆緊錦僅謹進晉燼盡勁荊覺決訣絕鈞軍駿開凱顆殼課墾懇摳庫褲誇塊儈寬礦曠況虧巋窺饋潰擴闊蠟臘萊來賴藍欄攔籃闌蘭瀾讕攬覽懶纜爛濫撈勞澇樂鐳壘類淚籬離裏鯉禮麗厲勵礫曆瀝隸倆聯蓮連鐮憐漣簾斂臉鏈戀煉練糧涼兩輛諒療遼鐐獵臨鄰鱗凜賃齡鈴淩靈嶺領餾劉龍聾嚨籠壟攏隴樓婁摟簍蘆盧顱廬爐擄鹵虜魯賂祿錄陸驢呂鋁侶屢縷慮濾綠巒攣孿灤亂掄輪倫侖淪綸論蘿羅邏鑼籮騾駱絡媽瑪碼螞馬罵嗎買麥賣邁脈瞞饅蠻滿謾貓錨鉚貿麽黴沒鎂門悶們錳夢謎彌覓冪綿緬廟滅憫閩鳴銘謬謀畝鈉納難撓腦惱鬧餒內擬膩攆撚釀鳥聶齧鑷鎳檸獰甯擰濘鈕紐膿濃農瘧諾歐鷗毆嘔漚盤龐賠噴鵬騙飄頻貧蘋憑評潑頗撲鋪樸譜棲淒臍齊騎豈啓氣棄訖牽扡釺鉛遷簽謙錢鉗潛淺譴塹槍嗆牆薔強搶鍬橋喬僑翹竅竊欽親寢輕氫傾頃請慶瓊窮趨區軀驅齲顴權勸卻鵲確讓饒擾繞熱韌認紉榮絨軟銳閏潤灑薩鰓賽三傘喪騷掃澀殺紗篩曬刪閃陝贍繕傷賞燒紹賒攝懾設紳審嬸腎滲聲繩勝聖師獅濕詩屍時蝕實識駛勢適釋飾視試壽獸樞輸書贖屬術樹豎數帥雙誰稅順說碩爍絲飼聳慫頌訟誦擻蘇訴肅雖隨綏歲孫損筍縮瑣鎖獺撻擡態攤貪癱灘壇譚談歎湯燙濤縧討騰謄銻題體屜條貼鐵廳聽烴銅統頭禿圖塗團頹蛻脫鴕馱駝橢窪襪彎灣頑萬網韋違圍爲濰維葦偉僞緯謂衛溫聞紋穩問甕撾蝸渦窩臥嗚鎢烏汙誣無蕪吳塢霧務誤錫犧襲習銑戲細蝦轄峽俠狹廈嚇鍁鮮纖鹹賢銜閑顯險現獻縣餡羨憲線廂鑲鄉詳響項蕭囂銷曉嘯蠍協挾攜脅諧寫瀉謝鋅釁興洶鏽繡虛噓須許敘緒續軒懸選癬絢學勳詢尋馴訓訊遜壓鴉鴨啞亞訝閹煙鹽嚴顔閻豔厭硯彥諺驗鴦楊揚瘍陽癢養樣瑤搖堯遙窯謠藥爺頁業葉醫銥頤遺儀彜蟻藝億憶義詣議誼譯異繹蔭陰銀飲隱櫻嬰鷹應纓瑩螢營熒蠅贏穎喲擁傭癰踴詠湧優憂郵鈾猶遊誘輿魚漁娛與嶼語籲禦獄譽預馭鴛淵轅園員圓緣遠願約躍鑰嶽粵悅閱雲鄖勻隕運蘊醞暈韻雜災載攢暫贊贓髒鑿棗竈責擇則澤賊贈紮劄軋鍘閘柵詐齋債氈盞斬輾嶄棧戰綻張漲帳賬脹趙蟄轍鍺這貞針偵診鎮陣掙睜猙爭幀鄭證織職執紙摯擲幟質滯鍾終種腫衆謅軸皺晝驟豬諸誅燭矚囑貯鑄築駐專磚轉賺樁莊裝妝壯狀錐贅墜綴諄著濁茲資漬蹤綜總縱鄒詛組鑽";


    /**
     * [rtmp 使用rtmp协议进行视频拉流]
     * @author [wang] <[li]>
     */
    public function rtmp()
    {
        $this->display();
    }


    public function live()
    {
        $this->display();
    }

    //获取网易云直播接口状态
    public function wyInterface()
    {
        $header = [
            'AppKey'  => '925af2e33f7fedbca5c806b56f1753c3',
            'Nonce'   => rand(),
            'CurTime' => time(),
        ];

        $header['CheckSum'] = sha1('a10546f17bb7'.$header['Nonce'].$header['CurTime'], false);

        $data['cid'] = 'd1060d97aa2f4772be4b3f25ec04d556';

        $url = 'https://vcloud.163.com/app/channelstats';

        $res = $this->creatTokenPost($header, json_encode($data), $url);

        print_r($res);
    }

    public function creatTokenPost($header, $data, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
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

    //app极光推送
    public function jpush()
    {
        $fetion = new Jpush();

        $receive = 'all';//全部 
        // $receive = array('tag'=>array('中国'));//标签 
        //$receive = array('alias'=>array('2'),'alias'=>array('1'));//别名 

        $html = "【外汇消息】推送的内容，这个应该显示吧";

        $html = html_entity_decode($html);

        $content = $html;
        $m_type  = '消息类型';
        $m_txt   = '自定义内容';
        $m_time  = '600';        //离线保留时间
        $res     = $fetion->send_pub($receive, $content, $m_type, $m_txt, $m_time);

        vD($res);
    }

    //获取当前星期
    private function get_week($date)
    {
        //强制转换日期格式
        $date_str = date('Y-m-d', strtotime($date));
        //封装成数组
        $arr = explode("-", $date_str);
        //参数赋值
        //年
        $year = $arr[0];
        //月，输出2位整型，不够2位右对齐
        $month = sprintf('%02d', $arr[1]);
        //日，输出2位整型，不够2位右对齐
        $day = sprintf('%02d', $arr[2]);
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;
        //转换成时间戳
        $strap = mktime($hour, $minute, $second, $month, $day, $year);
        //获取数字型星期几
        $number_wk = date("w", $strap);
        //自定义星期数组
        $weekArr = [
            "星期日",
            "星期一",
            "星期二",
            "星期三",
            "星期四",
            "星期五",
            "星期六",
        ];
        //$weekArr = array("0","1","2","3","4","5","6");
        //获取数字对应的星期
        return $weekArr[ $number_wk ];
    }

    //获取echarts数据 禁止外部访问
    public function getData()
    {
        $url = 'http://echarts.baidu.com/examples/data/asset/data/aqi-beijing.json';

        $res = file_get_contents($url);

        echo $_GET['callback'].'('.$res.')';

    }

    //清空cookie
    public function clearCookie()
    {
        setcookie('news_id', '', time() - 1, '/');
    }

    //获取cookie
    public function setCookie()
    {
        $id = trim(I('get.id'));
        setcookie("news_id", $id, time() + (24 * 60 * 60) * 7, '/');
    }


    //易宝支付 预下单接口
    public function yibaoPay()
    {
        $dataArr = [
            'appId'             => self::APPID,
            //商户应用标识
            'timestamp'         => time(),
            //请求时间戳
            'nonce'             => generate_code(12),
            //请求随机数
            'service'           => 'quick.facepay',
            //商户请求服务    API快捷：quick.depositCard 刷脸快捷：quick.facepay
            'orderNo'           => time().mt_rand(),
            //商户请求流水号
            'totalAmount'       => 501 * 100,
            //金额
            'clientIp'          => get_client_ip(),
            //客户端IP
            'callbackUrl'       => U('Home/Index/index', '', true, true),
            //支付成功跳转地址
            'notifyUrl'         => U('Home/Test/notifyUrl', '', true, true),
            //回调地址
            'body'              => urlencode('在线支付'),
            //商品描述
            'cardType'          => 0,
            //银行卡类型 0 储蓄卡
            'quickCustomerName' => '王海东',
            //持卡人姓名
            'quickAcctNo'       => 6236682340008433764,
            //银行卡号
            'quickPhoneNumber'  => 18765412746,
            //银行卡绑定手机号
            // 'payeeBankName'     => '建设银行',                  //支付银行
            'quickCerdId'       => 372901199612042810,
            //持卡人身份证号
        ];

        $dataArr['sign'] = $this->signMd5($dataArr);

        $res = $this->curlPost(json_encode($dataArr), self::PREORDER_URL);

        echo $res;
    }

    /**
     * 快捷支付接口
     * @param  string $platformOrderNo 商户唯一订单号
     * @author wang li
     */
    public function pay($platformOrderNo = '2018051820112400000000004581', $checkCode = 300590)
    {
        $dataArr = [
            'appId'           => self::APPID,
            //商户应用标识
            'timestamp'       => time(),
            //请求时间戳
            'nonce'           => generate_code(12),
            //随机数
            'platformOrderNo' => $platformOrderNo,
            //订单号
            'checkCode'       => $checkCode,
            //短信验证码
            'mobileNo'        => 18765412746,
            //手机号码
            'action'          => 'confirm_order',
        ];

        $dataArr['sign'] = $this->signMd5($dataArr);

        $res = $this->curlPost(json_encode($dataArr), self::PAY_URL);

        echo $res;
    }

    public function facePay($platformOrderNo = '2018051819462600000000004579', $checkCode = '1526644007,4c14a20f-b7aa-44bb-a236-e2d940657136')
    {
        $dataArr = [
            'appId'           => self::APPID,
            //商户应用标识
            'timestamp'       => time(),
            //请求时间戳
            'nonce'           => generate_code(12),
            //随机数
            'platformOrderNo' => $platformOrderNo,
            //订单号
            'checkCode'       => $checkCode,
            //短信验证码
            'mobileNo'        => 18765412746,
            //手机号码
            'action'          => 'confirm_face',
        ];

        $dataArr['sign'] = $this->signMd5($dataArr);

        $res = $this->curlPost(json_encode($dataArr), self::PAY_URL);

        echo $res;
    }


    public function url()
    {

        S(123, 'authKey1', 600);

        echo S(123);
    }


    //短信重发接口
    public function sms()
    {
        $dataArr = [
            'appId'           => self::APPID,
            //商户应用标识
            'timestamp'       => time(),
            //请求时间戳
            'nonce'           => generate_code(12),
            //随机数
            'platformOrderNo' => $platformOrderNo,
            //订单号
        ];

        $dataArr['sign'] = $this->signMd5($dataArr);

        $res = $this->curlPost(json_encode($dataArr), self::SMS_URL);

        vD($res);
    }

    //异步通知接口
    public function notifyUrl()
    {
        $data = file_get_contents('php://input', 'r');

        $data = json_decode($data, true);

        Log::debugArr($data, '11111111');

        $sign = $data['sign'];

        unset($data['sign']);
        unset($data['outBankTradeOrderNo']);
        unset($data['bankType']);

        $md5 = $this->signMd5($data);

        Log::debugArr($md5, '2222222222');

        if ($sign == $md5 && $data['status'] == 3) {
            Log::debugArr($md5, '333333');
            die('success');
        }
        else {

            die('fail');
        }
    }


    //md5签名运算
    private function signMd5($dataArr)
    {
        ksort($dataArr);

        $str = '';

        foreach ($dataArr as $key => $value) {
            $str .= $key.'='.$value.'&';
        }

        $str = $str.'key='.self::KEY;

        return strtoupper(md5($str));
    }

    public function randomFloat()
    {
        echo mt_rand(0, 9);
    }


    //请求头使用json post方式发送数据
    private function curlPost($data, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($oCurl, CURLINFO_HEADER_OUT, TRUE); //显示header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept-Charset: utf-8',
            'Content-Type: application/json',
        ]);

        $errorno = curl_errno($ch);
        $info    = curl_exec($ch);
        //$infoArr    = json_decode($info,true);
        //vD(curl_getinfo($ch));
        curl_close($ch);

        return $info;
    }


    //php生成器
    public function yields()
    {
        echo round(memory_get_usage() / 1024 / 1024, 2).' MB'.PHP_EOL;

        $flow = M('money_flow')
            ->limit(5000)
            ->select();

        foreach ($flow as $key => $val) {
            yield $key => $val;

            // 做性能分析，因此可测量内存使用率
            if (($key % 200000) == 0) {
                // 内存使用以 MB 为单位
                echo round(memory_get_usage() / 1024 / 1024, 2).' MB'.PHP_EOL;
            }
        }

    }

    public function printYield()
    {
        $data = self::yields();
        //必须使用foreach输出
        foreach ($data as $key => $val) {
            //var_dump($val).PHP_EOL;
        }
    }


    //聚合网关支付
    public function juheGateway()
    {


        //接口编码	apiCode	10	M	YL-PAY
        //字符集	inputCharset	10	M	UTF-8
        //签名方式	signType	10	M	MD5
        //商户编号	partner	100	M	聚合支付商户编号
        //商户订单号	outOrderId	100	M	商户订单号
        //
        //商品名称	product	100	O	参数为空时，展示商户简称
        //订单金额	amount	9,2	M	精确到分 0.00
        //业务拓展参数	extParam	100	O
        //回传参数	returnParam	200	O	商户自定义返回参数
        //支付类型	payType	50	M	ALL 所有支付方式都会在收银台展示，不支持INTERFACE 接入方式
        //B2C 个人网银
        //支付接口编号	interfaceCode	50	O	见6银行编码
        //订单提交时间	submitTime	50	M	格式：YYYYMMDDHHmmss。例：20170124165521
        //订单超时时间	timeout	50	O	1D
        //银行卡号	bankCardNo	50	O	支付类型为 3、认证支付 选输；其他支付类型无效
        //页面回调地址	redirectUrl	256	O	商户页面通知地址（暂不支持带参数回调，payType为AUTHPAY可不传，其他方式必传）
        //http/https://test.com/front
        //用户交易完成后的取货地址
        //
        //通知地址	notifyUrl	256	M	商户通知地址
        //http/https://test.com/notify
        //接入方式	accMode	10	M	GATEWAY 展示聚合支付收银台
        //INTERFACE 直接跳转到银行或银联
        //签名摘要	sign	100	M
        //用户ip	clientIP	30	O	INTERFACE 接入方式，payType为B2C时必传

        $dataArr = [
            'apiCode'       => 'YL-PAY',
            'inputCharset'  => 'UTF-8',
            'signType'      => 'MD5',
            'partner'       => 'C100009',
            'outOrderId'    => time().rand(),
            'product'       => '',
            'amount'        => 100,
            'extParam'      => '',
            'returnParam'   => '',
            'payType'       => 'ALL',
            'interfaceCode' => '',
            'submitTime'    => date('YmdHis', time()),
            'timeout'       => '',
            'bankCardNo'    => '',
            'redirectUrl'   => '127.0.0.1/notify',
            'notifyUrl'     => '127.0.0.1/notify',
            'accMode'       => 'GATEWAY',
            'clientIP'      => '',
            'sign'          => '',
        ];

        $key = '9c6ed2f7f9e2d01c6c557f44b4edba6a';

        $sign = $this->sign($dataArr, $key);

        $dataArr['sign'] = $sign;


        $payUrl = 'http://pay.hanmi9.com/gateway/pay.htm';

        $res = $this->create($dataArr, $payUrl);

        echo $res;
    }

    //聚合京东h5
    public function JdH5()
    {
        //        接口编码	apiCode	10	M	YL-PAY
        //        字符集	inputCharset	10	M	UTF-8
        //        签名方式	signType	10	M	MD5
        //        商户编号	partner	100	M	聚合商户编号
        //        商户订单号	outOrderId	100	M	商户订单号
        //        商品名称	product	100	O	参数为空时，展示商户简称
        //        订单金额	amount	9,2	M	精确到分 0.00
        //        业务拓展参数	extParam	100	O
        //        回传参数	returnParam	200	O	商户自定义返回参数
        //        接口交易编号	interfaceCode	50	O
        //        支付类型	payType	50	M	1、支付宝扫码 ALIPAY
        //        2、微信扫码 WXNATIVE
        //        3、认证支付 AUTHPAY
        //        4、微信刷卡WXMICROPAY
        //        5、支付宝刷卡ALIPAYMICROPAY
        //        6、QQ扫码 QQNATIVE
        //        7、银联扫码 UNIONPAYNATIVE
        //
        //        8、QQH5支付 QQH5
        //        9、JDH5支付 JDH5
        //        10、ALIPAYJSAPI 支付宝服务窗
        //        授权码	authCode	50	O	扫码支付授权码， 设备读取用户展示的条码或者二维码信息（当支付类型为支付宝刷卡、和微信刷卡时必填。支付宝服务窗时传userId: OAuth 2.0认证）
        //        银行卡号	bankCardNo	50	O	支付类型为 3、认证支付 选输；其他支付类型无效
        //        通知地址	notifyUrl	256	M	商户通知地址
        //        http/https://test.com/notify
        //        签名摘要	sign	100	M
        $dataArr = [
            'apiCode'       => 'YL-PAY',
            'inputCharset'  => 'UTF-8',
            'signType'      => 'MD5',
            'partner'       => 'C100009',
            'outOrderId'    => time().rand(),
            'product'       => '',
            'amount'        => 1000,
            'extParam'      => '',
            'returnParam'   => '',
            'interfaceCode' => '',
            'payType'       => 'ALIPAYJSAPI',
            'authCode'      => '2088012044464986',
            'bankCardNo'    => '',
            'notifyUrl'     => '127.0.0.1/notify',
            'sign'          => '',
        ];


        $key = '9c6ed2f7f9e2d01c6c557f44b4edba6a';

        $sign = $this->sign($dataArr, $key);

        $dataArr['sign'] = $sign;

        vD($dataArr);

        $url = 'http://pay.hanmi9.com/gateway/interface/pay.htm';

        $res = $this->curl($url, $dataArr);

        $data = json_decode($res, true);

        vD($data);


        //        if(!empty($data['qrCodeUrl'])){
        //            header('Location:'.$data['qrCodeUrl'].'');
        //        }
        //        else{
        //            var_dump($data);
        //            return false;
        //        }
    }


    /**
     * 验签
     *
     * @author  AnLin
     * @version V1.0.0
     * @since   2018/6/4
     */
    private function sign($dataArr, $keys)
    {
        ksort($dataArr);
        $str = '';
        foreach ($dataArr as $key => $value) {
            if (!empty($value)) {
                $str .= $key.'='.$value.'&';
            }
        }

        $str = rtrim($str, '&').$keys;

        return strtoupper(md5($str));
    }


    //post提交
    private function create($data, $submitUrl)
    {
        $inputstr = "";
        foreach ($data as $key => $v) {
            $inputstr .= '<input type="hidden"  id="'.$key.'" name="'.$key.'" value="'.$v.'"/>';
        }
        $form = '<form action="'.$submitUrl.'" name="pay" id="pay" method="POST">';
        $form .= $inputstr;
        $form .= '</form>';
        $html = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>请不要关闭页面,支付跳转中.....</title>
        </head><body>
        ';
        $html .= $form;
        $html .= '
        <script type="text/javascript">
           document.getElementById("pay").submit();
        </script>';
        $html .= '</body></html>';
        header("Content-Type:text/html;charset={$type}");
        echo $html;

        exit;

    }


    //远程抓取数据
    private function curl($url, $data = [])
    {
        //使用crul模拟
        $ch = curl_init();
        //禁用https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //允许请求以文件流的形式返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch); //执行发送
        curl_close($ch);

        return $result;
    }


    /**
     * 聚合回调通知
     *
     * @author  AnLin
     * @version V1.0.0
     * @since   2018/6/4
     */
    public function notify()
    {
        $data = file_get_contents('php://input', 'r');

        $data = json_decode($data, true);

        $sign = $data['sign'];

        unset($data['returnParam']);
        unset($data['sign']);


        $md5 = $this->sign($data);

        if ($sign == $md5) {
            if ($data['partnerOrderStatus'] == 'SUCCESS') {
                echo 'SUCCESS';
                //支付成功，填写业务逻辑......
            }

        }
        else {
            return '签名不正确';
        }
    }


    //系统爆仓
    public function baocang()
    {
        //设置爆仓条件
        //先检查当前资金是否小于某个比例
        //如果小于某个比例，查询止盈止损高出逾期止盈止损的订单
        //对这些订单金额最重的进行平仓

        //平仓两者写法同时进行，先执行爆仓条件 在执行

        //获取保证金比例 持仓保证金，挂单保证金
        $uid = 4;

        $account = M('accountinfo')
            ->field('balance,gold')
            ->where(['uid' => $uid])
            ->find();

        $order = M('order')
            ->field('sum(Bond) bond,sum(ploss) ploss')
            ->where([
                'uid'    => $uid,
                'ostaus' => 0,
            ])
            ->find();

        $restingBond = M('guadan_order')
            ->where([
                'user_id' => $uid,
                'status'  => 1,
            ])
            ->sum('bond');

        $usedBond = round($order['bond'] + $restingBond, 2);   //占用保证金

        $worth = round(($account['balance'] + $usedBond) + $order['ploss'], 2); //账户净值

        //保证金比例
        $bondProportion = round(($worth / $usedBond) * 100, 2);

        if ($bondProportion < 50) {
            echo 123;
        }

        //取出当前保证金亏损最大的一仓
        $maxPloss = M('order')
            ->field('oid,min(ploss) ploss')
            ->where([
                'uid'    => $uid,
                'ostaus' => 0,
            ])
            ->find();

        vD($maxPloss);
    }

    //支付宝网页授权
    public function aliAuth()
    {
        $appid        = '2018061460360364';
        $redirect_uri = urlencode('http://qts.21jrd.com/Home/test/getCode');
        $url          = "https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$appid}&scope=auth_userinfo&redirect_uri={$redirect_uri}";

        header("Location:".$url);
    }

    //支付宝手机端授权
    public function ali()
    {
        $appid        = '2018061460360364';
        $redirect_uri = 'http://qts.21jrd.com/Home/test/getCode';

        $url = "https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$appid}&scope=auth_userinfo&redirect_uri={$redirect_uri}";
        $url = urlencode($url);

        $deeplink = "alipays://platformapi/startapp?appId=20000067&url={$url}";

        $this->assign('url', $deeplink);
        $this->display();
    }

    //支付宝授权回调
    public function getCode()
    {

        //引入的SDK
        require(VENDOR_PATH.'alipay/AopSdk.php');
        require(VENDOR_PATH.'alipay/aop/AopClient.php');
        require(VENDOR_PATH.'alipay/aop/request/AlipaySystemOauthTokenRequest.php');
        require(VENDOR_PATH.'alipay/aop/request/AlipayUserUserinfoShareRequest.php');

        $code = $_GET['auth_code'];

        //APPID
        $appid = '2018061460360364';


        //私钥  文件名（rsa_private_key.pem）
        $rsaPrivateKey = "MIIEowIBAAKCAQEAyKXb1qrEzPRGiO/AMvgKr7pkkaJeiorAfUcKJIlXEBqcDpPrZ00Ex9tFWHjA678Htun19K57io+xjsxlTl7aOgXxDq+/I/i45cv24+EieKT25cdjFAw6m6TP/XoJbLTiwE800s31mu8fIivyB95GFGXnhOe1L66HfXQl05xkag/qPfV7nHvZhfPwl08PQV4q+rUKuuELqtq4/5YXjbuR9782U0VRdJPT9PWS5ZpqjjQrADj7YUd0440iNBAzBAsgSwkphG0Q7l/Qejkqa4vmAy5NlW6zGU1rnrdmhk+Azvw/Kqk1iVJ2XGCADLMD7nNcURcXn8qpjoXJOKQsYkHR3QIDAQABAoIBAHqE3JJeQEGuP4vKaiA1WcEoHdTXwsbyJsvYnxbkTidlODmmlS3E19B50gRN5++L/Ffy0N8R1Bot2AwMPyf1v2eCzUlcg2ihrbWUMDPB+1yTzrdMYvGQ7hCwONjctfiNE5C+TNEUNo7eyLIDB41Kapx2BUMggYCWH+G5FIf8jUw9SmXsKM7ORPoENJG0LYtwb/A2HtyxN9fH2jaSyxbFc9oJZjXtvrrUuF0N+kK7H1LfnLSabtYZVVvEMzXYwsqEGxcnKIZmDabpcc5kqihT11WgrC1vFtVRzaMIpB4AXjOYqQCbrO3io2YNtzfqJEoP4fLWpSp2Wh4oEm8N7lCrQrkCgYEA72rHFyMnU86VmaHYcjQVIyxSgb86ygO8J9UbVotC3M0VpRTGeDbAvjLqnZ3fGtshfMxqe1ZBxjmx8Ate65RB5oeXx+vq4W2Z53/iT9gcwuJ5cJNlQpVLOzc94u9OWPkDghZAaY+0p/t5IvRSSBRlq/n9dAbo9Xl9pnJqRwPs2i8CgYEA1oulIZRYPzFNiX8mcxbXuomg1hAoeQulTaKcavIQ2lMLuSQQGPC63uKJulUk3Qzh7+ZA4mBOumOHc4zOwL5WQlPZlGEA37L7xOy8aTZrhMOXB0RDuna5W66IOFR78M7aPv9E2RD+iQQ6Wg10pzNX6H1TV0+S39kW7BWjP2+lLbMCgYBorImAzyjJll+HvN/yBl1bdGxaN65PVlS0IZMDQn2oJa4Z77xaIK4iOgajhLtfdYDtnD3N0MePD/iA16fXXYl2bb/pc3bMumt4cEwU1oq0lem8U2UJOFac/Cj9h9z8P1rOTEY7IM4+R08N/j3fL7PH/dNXIBJICKbr18gpZkjulwKBgCJVhr+w9c5nHXl7l7OjXDLGA68+NrvoWTPragzTYE8QKzgdxVW4cK9qoY/oQFX/0ciKmKehsfeyJeMgDZZa34MN2Cweuf0Sr6f8GsrboqlEg87t5cjZZyB89d/N5WfMMrESOPpj9dgHjS8MKDb5yH+0TroSSfb4zupJLC7itxRxAoGBALrUtegVMzXCMFxK89tc8A4bOpsC3V+XPsZ172DYK+vHkKclht168vYvxmT3aR+gfF6JIw1wL4x0aA0BES9TU8M0XbYFwL34zAZLLAthLlAOB/975aY0r/5MHuEIYXU3v0CcOPWFzdBlXIy9ExsEXbbkNBMc+G8b/sa0ZliRaqk2";

        //公钥  文件名 （rsa_public_key.pem）
        $alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxmkFgJMKf337rsWlQT8zbIkuTfigolv+vyQ5+fyoZD+UV/1KKOtmb/AGVRZpPvdPGRGcjbt0lGFbgJyiaq0f4XDo3Tlm6wsBEiFe4HxaKs69sBkEMdZc1ro18ZKOnVLhpnzNQ2Ck1SRutjktFdEqmyCZD2FJDLkK5kY2UKIZLhr9qGpLDqQQ82tdd9PbvHKW/PyT7QL09HSxBc29affDglEUXRYy5ODp7JV4qI2pDGm/3wcttZukWv/fT8lZF7GV+ssfoRhEpMqam6wMLChi6CAhX55oayAvblcQtddh3dnHtjk5QS0QLHUWF+RBfvuSmkC0kKMEesFSf074P+E/SwIDAQAB";


        //初始化
        $aop                     = new \AopClient();
        $aop->gatewayUrl         = "https://openapi.alipay.com/gateway.do";
        $aop->appId              = $appid;
        $aop->rsaPrivateKey      = $rsaPrivateKey;
        $aop->alipayrsaPublicKey = $alipayrsaPublicKey;
        $aop->apiVersion         = '1.0';
        $aop->signType           = 'RSA2';
        $aop->postCharset        = 'utf-8';
        $aop->format             = 'json';


        //获取access_token
        $request = new \AlipaySystemOauthTokenRequest ();
        $request->setGrantType("authorization_code");
        $request->setCode($code);
        $result = $aop->execute($request);

        $access_token = $result->alipay_system_oauth_token_response->access_token;
        $user_id      = $result->alipay_system_oauth_token_response->user_id;

        vD($result);


        //获取用户信息
        //        $request_a = new \AlipayUserUserinfoShareRequest ();
        //        $result_a = $aop->execute ($request_a,$access_token); //这里传入获取的access_token
        //        $responseNode_a = str_replace(".", "_", $request_a->getApiMethodName()) . "_response";

        //        $user_id = $result_a->$responseNode_a->user_id;   //用户唯一id
        //        $headimgurl = $result_a->$responseNode_a->avatar;   //用户头像
        //        $nick_name = $result_a->$responseNode_a->nick_name;    //用户昵称
        //
        //        var_dump($user_id);
        //        var_dump($headimgurl);
        //        var_dump($nick_name);
        //        die;

    }

    //支付宝拉起支付
    public function laqi()
    {
        $redirect_uri = 'http://baidu.com';

        $deeplink = "alipays://platformapi/startapp?appId=20000067&url={$redirect_uri}";

        $this->assign('url', $deeplink);

        $this->assign('trade_no', 2018061521001004980594594598);

        $this->display('ali');
    }


    /***************开联通回调******************/

    /**
     * 开联通回调
     */
    public function passpayNotify()
    {
        $data = 'payDatetime=20180621201722&signType=1&version=v1.0&issuerId=&orderNo=pay_180621201658789&payResult=1&mchtOrderId=201806212016586016&ext1=&ext2=&orderAmount=20&signMsg=PFPp2j2IWRKi7OS9lsPkDyAGVd9mKBvkx5A67kKqRNFAlIWn4wr2cBMJi6a3zhez0VEXgbKpLh5p2Bgdw5KbLX6YN6iw2wSNkoW9sR3ljPTy0snC8Yo8BhRHmOtYsOD1huLUPn1%2Fdqb0HcvbPFqdvR4IvIaGOYFfeq6pyXceSmyk%2FAZxVjN4Ig0wyCkQM%2BeCe7ylb0bxYr0f5WPzBsxy%2BiIPYyZ1l0WJ8KMb%2BMCf%2BAkCLyzuuzLtk8IbjUL2LpdTQsZR2DTp0AA%2Bc5e7IknSd2wLO%2FuLIypGGm3amHIvlAdHzfZiH%2FleOSwogaIVpNLk3h5y6v41EONl9tvwM0nCyg%3D%3D&payType=0&merchantId=105840180510003&language=1&orderDatetime=20180621201658';

        $arr = explode('&', $data);

        $Arrr1 = [];
        foreach ($arr as $v) {
            $tem              = explode("=", $v);
            $Arrr1[ $tem[0] ] = $tem[1];
        }

        vD($Arrr1);
        die;

        $sign = $this->getNotifyData($Arrr1, 'T02ousqV');

        echo $sign;

    }


    //回调时验签
    public function getNotifyData($arr, $key)
    {
        //验证签名
        $arra = [
            'merchantId',
            'version',
            'language',
            'signType',
            'payType',
            'issuerId',
            'mchtOrderId',
            'orderNo',
            'orderDatetime',
            'orderAmount',
            'payDatetime',
            'ext1',
            'ext2',
            'payResult',
            'signMsg',
        ];

        //拼接获取信息
        $zifu = '';
        foreach ($arra as $v) {
            if ($arr[ $v ] !== '' && $v !== 'signMsg') {
                $zifu .= "$v=$arr[$v]&";
            }
        }
        $zifu .= 'key='.$key.'';

        $signa = strtoupper(md5($zifu));

        return $signa;
    }


    /***************时间验证******************/


    public function testTime()
    {
        $tm = 30786.2308;

        $res = self::secsToStr($tm);

        echo $res;
    }


    /*
     * 秒数转换日期
     */
    public function secsToStr($secs)
    {
        if ($secs >= 86400) {
            $days = floor($secs / 86400);
            $secs = $secs % 86400;
            $r    = $days.'日';
            //            if($days<>1){$r.='s';}
            if ($secs > 0) {
                $r .= ', ';
            }
        }
        if ($secs >= 3600) {
            $hours = floor($secs / 3600);
            $secs  = $secs % 3600;
            $r     .= $hours.'时';
            //            if($hours<>1){$r.='s';}
            if ($secs > 0) {
                $r .= ', ';
            }
        }
        if ($secs >= 60) {
            $minutes = floor($secs / 60);
            $secs    = $secs % 60;
            $r       .= $minutes.'分';
            //            if($minutes<>1){$r.='s';}
            if ($secs > 0) {
                $r .= ', ';
            }
        }
        $r .= $secs.'秒';
        //        if($secs<>1){$r.='s';
        //        }
        return $r;
    }


    //推广员自动升级
    public function auto_upgrade()
    {
        $userObj  = M('userinfo');
        $orderObj = M('order');

        $levelData = [
            1 => 0,
            2 => 500,
            3 => 1000,
        ];  //升级手数

        $user = $userObj->field('uid,extension_level')
                        ->where('code is not null and otype = 4')
                        ->select();

        foreach ($user as $key => $val) {
            $subordinate = $userObj->field('group_concat(distinct uid) user_id,rid')
                                   ->where(['rid' => $val['uid']])
                                   ->find();

            if (!empty($subordinate['user_id']) && !empty($subordinate['rid'])) {
                $onumber = $orderObj->where("uid in ({$subordinate['user_id']}) and type = 1")
                                    ->sum('onumber');

                if ($onumber >= 0 && $onumber < 500) {
                    $extension_lenvel = 1;
                }
                elseif ($onumber >= 500 && $onumber < 1000) {
                    $extension_lenvel = 2;
                }
                elseif ($onumber >= 1000) {
                    $extension_lenvel = 3;
                }
                else {
                    $extension_lenvel = 1;
                }

                $userObj->where(['uid' => $subordinate['rid']])
                        ->setField('extension_level', $extension_lenvel);
            }
        }
    }


    /**
     * 简体转化繁体
     *
     * @param string $sContent 要转化的字符串
     * @return string 转化之后得到的字符串
     */
    public function simpleTradition($sContent)
    {
        $traditionalCN = '';
        $iContent      = mb_strlen($sContent, 'UTF-8');

        for ($i = 0; $i < $iContent; $i++) {
            $str           = mb_substr($sContent, $i, 1, 'UTF-8');
            $match         = mb_strpos(self::$sd, $str, null, 'UTF-8');
            $traditionalCN .= ($match !== false) ? mb_substr(self::$td, $match, 1, 'UTF-8') : $str;
        }

        return $traditionalCN;
    }

    public function myr()
    {
        $pay_memberid    = "10061";   //商户ID
        $pay_orderid     = 'E'.date("YmdHis").rand(100000, 999999);    //订单号
        $pay_amount      = 1000;    //交易金额
        $pay_applydate   = date("Y-m-d H:i:s");                     //订单时间
        $pay_bankcode    = "907";                                           //银行编码
        $pay_notifyurl   = "http://www.yourdomain.com/demo/server.php";     //服务端返回地址
        $pay_callbackurl = "http://www.yourdomain.com/demo/page.php";       //页面跳转返回地址
        $Md5key          = "1k887oqh67okdeg0g6j8jrrayhvoesl1";              //密钥
        $tjurl           = "http://pay.apay8.com/Pay_Index.html";           //提交地址

        //扫码
        $native = [
            "pay_memberid"    => $pay_memberid,
            "pay_orderid"     => $pay_orderid,
            "pay_amount"      => $pay_amount,
            "pay_applydate"   => $pay_applydate,
            "pay_bankcode"    => $pay_bankcode,
            "pay_notifyurl"   => $pay_notifyurl,
            "pay_callbackurl" => $pay_callbackurl,
        ];
        ksort($native);
        $md5str = "";
        foreach ($native as $key => $val) {
            $md5str = $md5str.$key."=".$val."&";
        }
        $sign                  = strtoupper(md5($md5str."key=".$Md5key));
        $native["pay_md5sign"] = $sign;

        $ret = $this->create($native, $tjurl);

        print_r($ret);
    }

    public function myrNotify()
    {
        $returnArray = [
             "memberid"       => $_REQUEST["memberid"],
             // 商户ID
             "orderid"        => $_REQUEST["orderid"],
             // 订单号
             "amount"         => $_REQUEST["amount"],
             // 交易金额
             "datetime"       => $_REQUEST["datetime"],
             // 交易时间
             "transaction_id" => $_REQUEST["transaction_id"],
             // 支付流水号
             "returncode"     => $_REQUEST["returncode"],
        ];

        $md5key = "1k887oqh67okdeg0g6j8jrrayhvoesl1";
        ksort($returnArray);
        reset($returnArray);

        $md5str = "";
        foreach ($returnArray as $key => $val) {
            $md5str = $md5str.$key."=".$val."&";
        }

        $sign = strtoupper(md5($md5str."key=".$md5key));

        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {
                echo '支付成功';
            }
        }
    }

    function googleTran($text)
    {
        $param = [
            'from' => 'en',
            'to' => 'zh',
            'query' => '你好',
            'transtype' => 'hash',
            'simple_means_flag' => '3',
            'sign'  => '232427.485594',
            'token' => 'b825e9aa526cf331dbde9d6a4cbf562d'
        ];

        $url = 'https://fanyi.baidu.com/v2transapi';

        $ret = get_curl_contents($url,'POST',$param);

        print_r($ret);
    }

    function testen()
    {
        $this->googleTran('公司经理公司');

    }

}