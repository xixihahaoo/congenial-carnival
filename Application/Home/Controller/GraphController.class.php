<?php
/**
 * redis 1周 1月 的k线数据
 */
namespace Home\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;

class GraphController extends Controller
{

    public function dev()
    {
        global $redis;

        $redis = new Redis();

        $pres  = 0;

        do {
            $nows     = date('i',time());

            if($pres != $nows) {

                $this->handalKM();	//远程存取数据

                $pres = $nows;

            } else {
                sleep(1);
            }
        } while (true);
    }


    //处理周k以及月k
    private function handalKM()
    {
        global $redis;

        $dateFromat = array('u','m');   //1w周线 1m月线

        $optionObj = M('option');

        $goods = $optionObj->field('capital_key')->select();

        foreach ($goods as $key => $val) {

            foreach ($dateFromat as $k => $v) {
                //获取每周的k线数据
                $option = M('k_data')->
                field("count(*) count,group_concat(id) idStr,DATE_FORMAT(create_time,'%Y%{$v}') weeks")->
                where(array('capital_key' => $val['capital_key']))->
                group('weeks')->order('create_time asc')->
                select();

                $data = array();
                foreach ($option as $key => $value) {

                    $lastData   = M('k_data')->field('timestamp,close,create_time,open')->where("id in({$value['idStr']})")->select();
                    $Hl         = M('k_data')->field('max(high) max,min(low) min')->where("id in ({$value['idStr']})")->find();

                    $timestamp      = $lastData[$value['count']-1]['timestamp'];
                    $close          = $lastData[$value['count']-1]['close'];
                    $create_time    = $lastData[$value['count']-1]['create_time'];
                    $open           = $lastData[0]['open'];

                    $data[$key][] = (int) $timestamp;
                    $data[$key][] = (float) $open;
                    $data[$key][] = (float) $Hl['max'];
                    $data[$key][] = (float) $Hl['min'];
                    $data[$key][] = (float) $close;
                    $data[$key][] = $create_time;
                }

                $dataStr = json_encode($data);

                //根据当前k线类型存储redis
                $interval = array('u' => '1w','m' => '1m');
                $redis->set($val['capital_key'].$interval[$v],$dataStr,3600); //redis存储k线
            }

        }
    }




}