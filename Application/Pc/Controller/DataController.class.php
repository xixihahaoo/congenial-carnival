<?php
/**
 * redis 存取k线数据
 */
namespace Pc\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;

class DataController extends Controller
{

    //从redis中取出数据
    public function getData()
      {
        $this->getDataV2();exit;

        $code        = trim(I('get.code'));
        $interval    = trim(I('get.interval'));
        $rows        = 90;//trim(I('get.rows'));


        if(!empty($code))
        {
          $redis  = new Redis();

          $data   = $redis->get($code.$interval);

          $length = count($data);

          $rows   = $rows <= $length ? $rows : $length;

          $start  = $length - $rows;

          $data = array_slice($data,$start);

          echo json_encode($data);
        }

      }

    public function getDataV2()
    {
        $code        = trim(I('get.code'));
        $interval    = trim(I('get.interval'));
        $rows        = 90;//trim(I('get.rows'));


        if(!empty($code))
        {
            $redis  = new Redis();
            if( is_numeric($interval)){
                $interval = $interval.'m';
            }
            $data   = $redis->get($code.$interval);

            $length = count($data);

            $start     = $length - $rows;
            $start     = $start <= 0 ? 0 : $start;

            $data = array_slice($data,$start);

            if($data == null || $data == '' || empty($data)) {
                $url     = 'http://39.107.99.235:1008/redis.php?code='.$code.'&time='.$interval.'&rows='.$rows.'';
                $json_data 	= $this->http_request($url);
                die($json_data);
            }

            echo json_encode($data);
        }

    }

    //从redis中取出数据
    public function getDataBak()
    {
        $code        = trim(I('get.code'));
        $interval    = trim(I('get.interval'));
        $rows        = 90;//trim(I('get.rows'));


        if(!empty($code))
        {
            $redis  = new Redis();

            $data   = $redis->get($code.$interval);

            $length = count($data);

            $rows   = $rows <= $length ? $rows : $length;

            $start  = $length - $rows;

            $data = array_slice($data,$start);

            echo json_encode($data);
        }

    }

    public function http_request($URI, $isHearder = false, $post = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 2);          //单位 秒，也可以使用
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
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