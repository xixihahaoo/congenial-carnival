<?php
/**
 * redis 存取k线数据
 */
namespace Home\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;

class DataController extends Controller
{
    public function test(){
        echo "test";
    }

    public function dev()
    {
        global $redis;

        $redis = new Redis();

        do {
            $this->getCurlData();	//远程存取数据
            sleep(10); //延迟 10 描述 usleep(10000000);  延迟2秒
        } while (true);
    }


    //获取k线图数据
    public function getCurlData()
    {
        //global $redis;
        $redis = new \redis();
        $redis->connect('127.0.0.1',6379);

        $optionObj  = M('option');

        $option     = $optionObj->distinct(true)->field('capital_key')->select();
        $interval   = array('1m','5m','15m','30m','1h','1d');
        $rows       = 200;

        foreach ($option as $key => $value) {

            foreach ($interval as $k => $v) {
                $url     = 'http://39.107.99.235:1008/redis.php?code='.$value['capital_key'].'&time='.$v.'&rows='.$rows.'';
                $data 	= $this->http_request($url);

                if( $data ){
                    $redis->set($value['capital_key'].$v,$data,300); //redis存储k线
                }

                //处理小时数据
                if($v == '1h')
                {
                    $this->hourKM($data,$value['capital_key']);
                }
            }
        }
    }



    //处理4小时k线数据
    private function hourKM($data,$capital_key)
    {
        global $redis;

        $data   = json_decode($data,true);

        $count  = count($data);
        $c      = 0;

        $datas  = array();

        for ($i=0; $i <$count ; $i++) {
            $datas[] = array_slice($data,$c,4);
            $c += 4;
        }

        $datas = array_filter($datas);

        $hour = array();

        for ($i=0; $i < count($datas); $i++) {

            $time   =  $datas[$i][3][0];
            $date   =  $datas[$i][3][5];

            $open   = $datas[$i][0][1];
            $close  = $datas[$i][3][4];

            $high = array($datas[$i][0][2],$datas[$i][1][2],$datas[$i][2][2],$datas[$i][3][2]);
            $low  = array($datas[$i][0][3],$datas[$i][1][3],$datas[$i][2][3],$datas[$i][3][3]);

            $hour[$i][]       = $time;
            $hour[$i][]       = $open;
            $hour[$i][]       = max($high);
            $hour[$i][]       = min($low);
            $hour[$i][]       = $close;
            $hour[$i][]       = $date;
        }

        if($hour[count($hour)-1][0] == null)
            unset($hour[count($hour)-1]);

        $dataStr = json_encode($hour);

        //根据当前k线类型存储redis
        $redis = new \redis();
        $redis->connect('127.0.0.1',6379);
        if( $dataStr ){
            $redis->set($capital_key.'4h',$dataStr,120); //redis存储k线
        }
    }


    //从redis中取出数据
    public function getData()
    {
        $code        = trim(I('get.code'));
        $interval    = trim(I('get.interval'));
        $rows        = 40;//trim(I('get.rows'));

        if($interval == '1d') //如果是1日的数据
            $rows = 40;


        if(!empty($code))
        {
//            $redis  = new Redis();
            $redis = new \redis();
            $redis->connect('127.0.0.1',6379);

            $data   = $redis->get($code.$interval);
            $data = json_decode($data, true );
            $length = count($data);

            $start     = $length - $rows;
            $start     = $start <= 0 ? 0 : $start;

            $data = array_slice($data,$start);

            if($data == null || $data == '' || empty($data) || !$data) {
                $url     = 'http://39.107.99.235:1008/redis.php?code='.$code.'&time='.$interval.'&rows='.$rows.'';
                $json_data 	= $this->http_request($url);
                die($json_data);
            }

            echo json_encode($data);
        }

    }


    /**
     * curl 请求
     * @param wang li
     */
    public function http_request($URI, $isHearder = false, $post = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);          //单位 秒，也可以使用
//        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
//        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
        curl_setopt($ch, CURLOPT_HEADER, $isHearder);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/tmp.cookie");
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/tmp.cookie");
        if(strpos($URI, 'https') === 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if($post){
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


}