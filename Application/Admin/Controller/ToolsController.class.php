<?php

namespace Admin\Controller;


class ToolsController extends CommonController
{

    /**
     * @functionname: setting_opt
     * @author: FrankHong
     * @date: 2016-11-14 15:07:02
     * @description: 系统当前交易币种及汇率设置
     * @note:
     * 定义新的常量 SYSTEM_CURRENCY_TYPE
     */
    public function setting_opt()
    {
        if (IS_AJAX)
        {

            $moneyName  = I('post.money_name');
            $moneyCode  = I('post.money_code');
            $moneyRate  = I('post.money_rate');

            $moneyRs      = array();
            foreach($moneyCode as $k => $v)
            {
                if(!empty($v))
                {
                    $moneyRs[$v]['name']    = trim($moneyName[$v]);
                    $moneyRs[$v]['code']    = trim($v);
                    $moneyRs[$v]['rate']    = trim($moneyRate[$v]);
                }
            }

           // vD($moneyRs);
           // die();

            $datas      = serialize($moneyRs);

            if (set_setting_config('SYSTEM_CURRENCY_TYPE', $datas))
            {
                $this->clear_cache();
                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }


    /**
     * @functionname: setting_list
     * @author: FrankHong
     * @date: 2016-11-14 15:35:56
     * @description: 系统配置列表
     * @note:
     */
    public function setting_list()
    {

        $systemCurrency = M('currency')->select();

        $currencyRs = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');

        $this->assign('currencyRs', $currencyRs['datas']);

        $this->assign('systemCurrency', $systemCurrency);


        $this->display();
    }


    /**
     * @functionname: clear_cache
     * @author: FrankHong
     * @date: 2016-11-14 16:56:10
     * @description: 当前配置项，全部在父类中进行初始化，加载到系统中，做了修改后，这里需要清空缓存，重新读取
     * @note:
     */
    private function clear_cache()
    {
        S('DB_CONFIG_DATA', null);
    }
  

    /**
     * @functionname: basic
     * @author: FrankHong
     * @date: 2016-11-14 15:35:56
     * @description: 系统基本设置
     * @note:
     */
    public function basic(){
          
          $config = M("webconfig")->find();
          $this->assign('conf',$config);
          $this->display();
    }


    /**
     * @functionname: product_sell_time
     * @author: FrankHong
     * @date: 2016-12-09 15:21:37
     * @description: 系统商品强制平仓时间设置
     * @note:
     */
    public function product_sell_time()
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_TIME');

        $this->assign('sys_date',$sysDate['datas']['sys_date']);
        $this->display();
    }


    /**
     * @functionname: product_sell_time_opt
     * @author: FrankHong
     * @date: 2016-12-09 15:31:35
     * @description: 系统平仓时间
     * @note: SYSTEM_OPTION_TIME
     */
    public function product_sell_time_opt()
    {
        if (IS_AJAX)
        {

            $sys_date   = I('post.sys_date');


            $systemDate = array('sys_date' => $sys_date);

            $datas      = serialize($systemDate);

            if (set_setting_config('SYSTEM_OPTION_TIME', $datas))
            {
                $this->clear_cache();
                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }

    /**
     * @functionname: commission_rate
     * @author: wang
     * @date: 2016-12-09 15:31:35
     * @description: 佣金比率
     */
    public function commission_rate()
    {
        $classObj       = M('OptionClassify');

        $class          = $classObj->where('level=1')->getField('id,name,en_name,id',true);

        if(!F('data'))
        {
            foreach ($class as $key => $value) {
                $class[$key]['level'] = C('COMM.RATE');
            }

            F('data',$class);

            $Data = $class;
        } else {
            $Data = F('data');
        }


        $this->assign('systemCurrency', $Data);
        $this->display();
    }

    /**
     * @functionname: commission_add
     * @author: wang
     * @date: 2016-12-09 15:31:35
     * @description: 佣金修改
     */
    public function commission_add()
    {
        if (IS_AJAX)
        {            
            $classObj       = M('OptionClassify');

            $class          = $classObj->where('level=1')->getField('id,name,en_name,id',true);

            foreach ($class as $key => $value) {
                $desc   = I('post.money_desc_'.$value['id'].'');
                $level  = I('post.money_level_'.$value['id'].'');
                $price  = I('post.money_price_'.$value['id'].'');
                
                $class[$key]['level'] = array(1 => array('desc' => $desc[0],'level' =>$level[0],'price' => $price[0]),2 => array('desc' => $desc[1],'level' => $level[1],'price' => $price[1]),3 => array('desc' => $desc[2],'level' => $level[2],'price' => $price[2]));
            }

            if(!empty($value))
            {
                F('data',$class);
                $this->success('保存成功！');
            } else {
                $this->error('保存失败');
            }
        }
    }

    /**
     * @functionname: product_number
     * @author: wang
     * @date: 2016-12-09 15:21:37
     * @description: 用户交易手数限制
     * @note:SYSTEM_OPTION_NUMBER
     */
    public function product_number()
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_NUMBER');
        $this->assign('sys_date',$sysDate['datas']['sys_date']);
        $this->display();
    }


    /**
     * @functionname: product_number_opt
     * @author: wang
     * @date: 2016-12-09 15:31:35
     * @description: 用户交易手数限制
     * @note: SYSTEM_OPTION_NUMBER
     */
    public function product_number_opt()
    {
        if (IS_AJAX)
        {

            $sys_date   = I('post.sys_date');


            $systemDate = array('sys_date' => $sys_date);

            $datas      = serialize($systemDate);

            if (set_setting_config('SYSTEM_OPTION_NUMBER', $datas))
            {
                $this->clear_cache();
                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }

    /**
     * [commission_time 佣金返还时间设置]
     * @author wang li
     */
    public function commission_time()
    {
        // $data['data'] = array(
        //     array('name' => '下单返','type' => 1,'checked' => 1),
        //     array('name' => '次日返','type' => 2,'checked' => 0,'time' => '0800'),
        //     array('name' => '次周返','type' => 3,'checked' => 0,'time' => '0800'),
        // );

        // echo serialize($data);

        $sysData    = get_setting_config('find', 'SYSTEM_COMMISSION_TIME');

        $this->assign('data',$sysData['datas']['data']);

        $this->display();
    }

    /**
     * [commission_time_add 佣金时间设置]
     * @author wang li
     */
    public function commission_time_add()
    {

        $name       = I('post.name');
        $checked    = I('post.checked');
        $type       = I('post.type');


        $moneyRs      = array();
        foreach($name as $k => $v)
        {
            if(!empty($v))
            {
                $moneyRs[$k]['name']        = trim($name[$k]);
                $moneyRs[$k]['type']        = trim($type[$k]);
                
                if($type[$k] == $checked)   $moneyRs[$k]['checked'] = '1';
                else $moneyRs[$k]['checked'] = '0';
            }
        }

        $systemDate = array('data' => $moneyRs);

        $datas      = serialize($systemDate);

        if (set_setting_config('SYSTEM_COMMISSION_TIME', $datas))
        {
            $this->clear_cache();
            $this->success('保存成功！');
        }
        else
        {
            $this->error('保存失败！');
        }

    }


    //美元汇率出入金设置
    public function setting_dollar()
    {
        //设置美元汇率

        // $data['data'] = array(
        //     array('id' => 1,'name' => '入金利率','value' => 6.37),
        //     array('id' => 2,'name' => '出金利率','value' => 6.37)
        // );

        // echo serialize($data);


        $sysData    = get_setting_config('find', 'SYSTEM_DOLLAR_SETTING');

        // vD($sysData['datas']['data']);

        $this->assign('data',$sysData['datas']['data']);

        $this->display();
    }


    //汇率提交
    public function dollar_opt()
    {
        $name     = I('post.name');
        $value    = I('post.value');
        $id       = I('post.id');


        $moneyRs      = array();
        foreach($name as $k => $v)
        {
            if(!empty($v))
            {
                $moneyRs[$k]['name']        = trim($name[$k]);
                $moneyRs[$k]['value']       = trim(round($value[$k],2));
                $moneyRs[$k]['id']          = trim($id[$k]);
            }
        }

        $systemDate = array('data' => $moneyRs);

        $datas      = serialize($systemDate);

        if (set_setting_config('SYSTEM_DOLLAR_SETTING', $datas))
        {
            $this->clear_cache();
            $this->success('保存成功！');
        }
        else
        {
            $this->error('保存失败！');
        }
    }
}