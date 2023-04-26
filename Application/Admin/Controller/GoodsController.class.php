<?php
/**
 * @author: FrankHong
 * @datetime: 2016-11-15 11:43:53
 * @filename: GoodsController.class.php
 * @description: 商品管理
 * @note:
 *
 */

namespace Admin\Controller;
class GoodsController extends CommonController
{

    /**
     * @functionname: add_goods_time
     * @author: FrankHong
     * @date: 2016-11-15 11:28:45
     * @description: 增加商品的交易时间
     * @note:
     */
    public function add_goods_time()
    {
        $this->display();
    }


    /**
     * @functionname: goods_list
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品分类
     */
    
    public function goods_classify(){
          
          $class = M('OptionClassify')->where('level=1')->select();
          
          foreach ($class as $key => $value) {
              $subclass = M('OptionClassify')->where('pid='.$value['id'])->select();
              foreach ($subclass as $k => $v) {
                  if($value['id'] == $v['pid'])
                  {
                    $class[$key]['data'][] = $v;
                  }
              }
          }

          $this->assign('class',$class);
          $this->display();
    }
  
    /**
     * @functionname: goods_add
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品添加分类
     */
    
    public function goods_add(){
        if(IS_AJAX){
             
            $data = array(); 

            if(I('post.name') == ''){

                $data['status'] = 0;
                $data['msg']    = '栏目名称不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            $map['name']        = I('post.name');
            $map['create_time'] = time();
            $map['level']       = 1;
            $map['pid']         = 0;
            $result = M('OptionClassify')->add($map);
            if($result){
                $data['status'] = 1;
                $data['msg']    = '栏目添加成功';
                $this->ajaxReturn($data,'JSON');
            } else {
                $data['status'] = 0;
                $data['msg']    = '栏目添加失败';
                $this->ajaxReturn($data,'JSON');
            }
        }
       $this->display();
    }


    /**
     * @functionname: classify_edit
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品分类修改
     */
     
     public function classify_edit(){
          
          if(IS_AJAX){
 
              $data     = array();
              $name     = I('post.name');
              $id       = I('post.id');
              $en_name  = I('post.en_name');
              if($name && $id){
                  
                  $result = M('OptionClassify')->where(array('id' => $id))->save(['name' => $name,'en_name' => $en_name]);
                  if($result){
                       $data['status']  = 1;
                       $data['msg']     = '修改成功';
                       $this->ajaxReturn($data,'JSON');
                  } else {
                       $data['status']  = 0;
                       $data['msg']     = '修改失败';
                       $this->ajaxReturn($data,'JSON');
                  }
              } else {
                   $data['status']  = 0;
                   $data['msg']     = '栏目名称不存在';
                   $this->ajaxReturn($data,'JSON');
              }
          }


          $id = I('get.pid');
          $cate = M('OptionClassify')->where(array('id' => $id))->find();
          $this->assign('cate',$cate);
          $this->display();
     }

    /**
     * @functionname: classify_del
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品分类删除
     */
    
     public function  classify_del(){

        $id = I('post.id');

        if($id){
              
              $data   = array();
              $result = M('OptionClassify')->where(array('id' => $id))->delete();
              if(!$result){
                  
                    $data['msg']    = '删除失败';
                    $this->ajaxReturn($data,'JSON');
              } else {

                    $data['msg'] = '删除成功';
                    $this->ajaxReturn($data,'JSON');
              }
        }
     }
    

    /**
     * @functionname: goods_list
     * @author: FrankHong
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品列表
     * @note: 目前只支持修改，不支持增加
     *
     * 跌：#090
     * 涨：#f00
     */
    public function goods_list()
    {  
        $pid = trim(I('get.pid'));
        //产品分类
        if($pid){

            $map['pid'] = $pid;
            $sea['pid'] = $pid;
            $this->assign('posiname',M('OptionClassify')->where(array('id' => I('get.pid')))->find());
        }

        $optionObj  = M('option');

        $count = $optionObj->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end = $page->listRows;

        $optionRs   = $optionObj->where($map)->order('pid,id asc')->limit($start,$end)->select();


        $optionInfoObj  = M('option_info');
        $optionInfoRs   = $optionInfoObj->select();
        foreach($optionInfoRs as $k => $v)
        {
            $optionInfoRs1[$v['option_id']] = $v;
        }

        $optionIdArr    = array();
        $optionRs1      = array();
        $class          = array();  //分类
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]                = $v;
            $optionRs1[$v['id']]['style_color'] = ($v['Open'] - $v['Close'] > 0) ? 'num_red' : 'num_green';


            if($v['global_flag'] == 1)
            {
                $optionRs1[$v['id']]['deal_status_check']   = 'checked="checked"';
                if($v['flag'] == 1)
                {
                    $optionRs1[$v['id']]['deal_status']         = '正常';
                    $optionRs1[$v['id']]['deal_status_style']   = 'num_red';
                }
                else
                {
                    $optionRs1[$v['id']]['deal_status']         = '休市';
                    $optionRs1[$v['id']]['deal_status_style']   = 'num_green';
                }
            }
            else
            {
                $optionRs1[$v['id']]['deal_status']         = '交易关闭';
                $optionRs1[$v['id']]['deal_status_check']   = '';
                $optionRs1[$v['id']]['deal_status_style']   = 'num_green';
            }


            $optionRs1[$v['id']]['fee']             = $optionInfoRs1[$v['id']]['CounterFee'];        //手续费
            $optionRs1[$v['id']]['overnight_fee']   = $optionInfoRs1[$v['id']]['overnight_fee'];     //隔夜费买多
            $optionRs1[$v['id']]['sell_overnight_fee']   = $optionInfoRs1[$v['id']]['sell_overnight_fee'];     //隔夜费卖空
            $optionRs1[$v['id']]['contract_number'] = $optionInfoRs1[$v['id']]['contract_number'];   //合约数量
            $optionRs1[$v['id']]['spread']          = $optionInfoRs1[$v['id']]['spread'];            //点差 买价 卖价
            $optionRs1[$v['id']]['bond']            = $optionInfoRs1[$v['id']]['bond'];              //保证金基数
            $optionRs1[$v['id']]['sort']            = $optionInfoRs1[$v['id']]['sort'];              //排序
            $optionRs1[$v['id']]['capital_length']  = $optionInfoRs1[$v['id']]['capital_length'];    //保留小数点



            $optionRs1[$v['id']]['sell_status'] = $v['sell_flag'] == 1 ? '正常持仓' : '强制平仓';
            if($v['sell_flag'] == 1)
            {
                $optionRs1[$v['id']]['sell_status_style']   = 'num_red';
            }
            else
            {
                $optionRs1[$v['id']]['sell_status_style']   = 'num_green';
            }
           
            array_push($optionIdArr, $v['id']);  //产品id
            array_push($class,$v['pid']);        //分类id
        }

        $optionIdStr    = implode(',', array_unique($optionIdArr));
        $class          = implode(',', array_unique($class));   //分类

        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->where('option_id in ('.$optionIdStr.')')->select();


        //vD($dealTimeRs);

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            $start_time = substr($v['deal_time_start'], 0, 2).':'.substr($v['deal_time_start'], -2, 2);
            $end_time   = substr($v['deal_time_end'], 0, 2).':'.substr($v['deal_time_end'], -2, 2);

            $dealTimeRs1[$v['option_id']]['deal_time']  .= $start_time.'-'.$end_time.'<br>';
        }
        

          //所属分类
         $aa = array();
         $classify = M('OptionClassify')->where(array('id in ('.$class.')'))->select();
        foreach ($classify as $key => $value) {
            $aa[$value['id']]['name'] = $value['name'];
        }


        $this->assign('page',$page->show());
        $this->assign('class',$aa);  //所属分类
        $this->assign('dealTimeRs1', $dealTimeRs1);
        $this->assign('optionRs', $optionRs1);
        $this->display();
    }


    /**
     * @functionname: good_fee
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 设置每个商品属性
     * @note:
     */
    public function good_fee(){
          
          $data      = array();
          $option_id = I('post.option_id'); 
          $pass      = trim(I('post.pass'));   //每手的金额
          $field     = I('post.field');   //修改的字段

          if($field == 'capital_dot_length' || $field == 'wave' || $field == 'option_key' || $field == 'capital_name'){
                if($field == 'wave')
                {
                   $prefix  = C('DB_PREFIX');
                   $sql     = "UPDATE `{$prefix}option` SET `{$field}`={$pass} WHERE ( `id` = {$option_id} )";
                   $result  = M()->execute($sql);
               } else {

                    if($field == 'option_key') {
                        M("option")->where(array('id' => $option_id))->setField('en_name',$pass);
                    }

                   $result = M("option")->where(array('id' => $option_id))->setField($field,$pass);
               }
          } else{

              $info = M('OptionInfo')->where(array('option_id' => $option_id))->find();
              if(!$info){
                    
                    $map['option_id']   = $option_id;
                    $map[$field]        = $pass;
                    $result = M('OptionInfo')->add($map);
              } else {
                    if($field == 'spread')
                    {
                        $prefix  = C('DB_PREFIX');
                        $sql     = "UPDATE `{$prefix}option_info` SET `{$field}`={$pass} WHERE ( `option_id` = {$option_id} )";
                        $result  = M()->execute($sql);
                    } else {
                        $result = M('OptionInfo')->where(array('option_id' => $option_id))->setField($field,$pass);
                    }
              }
          }

          if($result){

                $data['status'] = 1;
                $data['msg']    = '修改成功';
                $this->ajaxReturn($data,'JSON');

            } else {

                $data['status'] = 0;
                $data['msg']    = '修改失败';
                $this->ajaxReturn($data,'JSON');
            }

    }



    /**
     * @functionname: take
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 商品玩法
     * @note:
     */ 
    public function take(){

        if(IS_AJAX){

              $text         = I('post.text');
              $option_id    = I('post.option_id');
              $lang         = I('post.lang');

              $data = array();
              if(trim($text) == ''){

                   $data['status'] = 0;
                   $data['msg']    = '内容不能为空';
                   $this->ajaxReturn($data,'JSON');
              }

              $map['content']   = $text;
              $map['option_id'] = $option_id;
              $map['lang']      = $lang;
              $play = M('OptionPlay')->where(array('option_id' => $option_id,'lang' => $lang))->find();
              if(!$play){

                $result = M('OptionPlay')->add($map);

              } else {

                $result = M("OptionPlay")->where(array('option_id' => $option_id,'lang' => $lang))->setField('content',$text);
              }
               
               if($result){

                    $data['status'] = 1;
                    $data['msg'] = '添加成功';
                    $this->ajaxReturn($data,'JSON');
               } else{
                    $data['status'] = 0;
                    $data['msg']    = '添加失败';
                    $this->ajaxReturn($data,'JSON');
               }
               
        }

        $option_id  = I('get.option_id');
        $lang       = I('get.lang');
        $this->assign('option_id',$option_id);
        $this->assign('lang',$lang);
        $this->assign('content',M('OptionPlay')->where(array('option_id' => $option_id,'lang' => $lang))->find());//玩法
        $this->display();
   }
    

    /**
     * @functionname: upload
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 编辑器初始化
     * @note:
     */ 
    public function upload() {
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     6291456 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    // 上传文件 
    $info   =   $upload->upload();

    $url = './Uploads/'.$info['file']['savepath'] . $info['file']['savename'];
    $img = 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$info['file']['savepath'] . $info['file']['savename'];

    // $image = new \Think\Image();//实例化图片处理类
    // $image->open($url);//打开图片
    // $image->thumb(400, 400)->save($url);//生成50X50的缩略图,并保存

        if ($info) {
            $result = array(
                'code' => 0,
                'msg'  => '上传成功',
                'data' => array(
                    'src'   => $img,
                    'title' => '图片'
                )
            );
        } else {
            $result = array(
                'code' => -1,
                'msg'  => '上传失败'
            );
        }

        $this->ajaxReturn($result,'JSON');
    }



    /**
     * @functionname: good_time_edit
     * @author: FrankHong
     * @date: 2016-11-15 15:49:48
     * @description: 设置每个商品的一天中的交易时间
     * @note:
     */
    public function good_time_edit()
    {
        $dealTimeObj    = M('option_deal_time');

        $optionId       = I('get.option_id');
        $goodTimeRs     = $dealTimeObj->where('option_id='.$optionId)->select();

        foreach($goodTimeRs as $k => $v)
        {
            $goodTimeRs[$k]['deal_time_start1'] = substr($v['deal_time_start'], 0, 2) . ':' . substr($v['deal_time_start'], -2, 2);
            $goodTimeRs[$k]['deal_time_end1']   = substr($v['deal_time_end'], 0, 2) . ':' . substr($v['deal_time_end'], -2, 2);

        }

        $this->assign('option_id', $optionId);
        $this->assign('goodTimeRs', $goodTimeRs);
        $this->display();
    }

    /**
     * @functionname: good_time_edit_opt
     * @author: FrankHong
     * @date: 2016-11-15 17:44:34
     * @description: 商品交易时间处理
     * @note: 先删除数据，重新增加数据
     *
     */
    public function good_time_edit_opt()
    {
        $timeCode   = I('post.time_code');
        $optionId   = I('post.option_id', 0);
        $dealType   = I('post.deal_type', 1);


        if(!$optionId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $timeStart  = $timeCode['time_start'];
        $timeEnd    = $timeCode['time_end'];
        $timeType   = $dealType['time_type'];
        $dataAdd    = array();

        if(empty($timeStart) || empty($timeEnd))
            outjson(array('status' => 0, 'ret_msg' => '时间不能为空'));


        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->where('option_id='.$optionId)->select();
        $dealTimeCount  = count($dealTimeRs);

        $dealTimeObj->where('option_id='.$optionId)->limit($dealTimeCount)->delete();

        $count      = count($timeStart);
        $k          = 1;
        for($i = 0; $i < $count; $i++)
        {
            if(!empty($timeStart[$i]))
            {
                $dataAdd[$i]['deal_time_start'] = str_replace(':', '', $timeStart[$i]);
                $dataAdd[$i]['deal_time_end']   = str_replace(':', '', $timeEnd[$i]);
                $dataAdd[$i]['time_order']      = $k;
                $dataAdd[$i]['deal_time_type']  = $timeType[$i];
                $dataAdd[$i]['option_id']       = $optionId;

                $k++;
            }
        }


        $flag  = $dealTimeObj->addAll($dataAdd);
        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '保存成功'));
        
    }


    /**
     * @functionname: opt_deal_time
     * @author: FrankHong
     * @date: 2016-11-17 17:23:26
     * @description: 处理交易转状态
     * @note:
     */
    public function opt_deal_status()
    {
        $optionId   = I('post.option_id', 0);
        $dealStatus = I('post.flag', 1);

        if(!$optionId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $optionObj  = M('option');
        $flag       = $optionObj->where('id='.$optionId)->setField('global_flag', $dealStatus);

        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '操作成功'));
    }

    /**
     * 时间产品交易设置
     * @author 王海东
     * @date
     * @return void
     */
    public function time_list()
    {
        $optionObj  = M('option');

        $count = $optionObj->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end = $page->listRows;

        $optionRs   = $optionObj->order('pid,id asc')->limit($start,$end)->select();


        $optionInfoObj  = M('option_info');
        $optionInfoRs   = $optionInfoObj->select();
        foreach($optionInfoRs as $k => $v)
        {
            $optionInfoRs1[$v['option_id']] = $v;
        }

        $optionRs1      = array();
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]             = $v;
            $optionRs1[$v['id']]['fee_time'] = $optionInfoRs1[$v['id']]['fee_time'];        //手续费
        }


        $this->assign('page',$page->show());
        $this->assign('optionRs', $optionRs1);
        $this->display();
    }


    /**
     * 时间交易玩法设置
     * @author 王海东
     * @date
     * @return void
     */
    public function timeSet()
    {
        $option_id = trim(I('get.option_id'));

        $optionObj      = M('option');
        $parameterObj   = M('option_parameter');

        $option         = $optionObj->field('id,capital_name')->where(array('id' => $option_id))->find();

        $data = $parameterObj->where(array('option_id' => $option_id))->select();

        $this->assign('option',$option);
        $this->assign('data',$data);
        $this->display();
    }


    /**
     * 添加或修改产品规格
     * @author 王海东
     * @date
     * @return void
     */
    public function parameterSave()
    {
        $return     = array();

        $data       = I('post.');

        $option_id  = $data['option_id'];

        if(empty($option_id))
        {
            $return['status'] = 0;
            $return['msg'] = '参数错误';
            $this->ajaxReturn($return,'JSON');
        }

        $rate       = $data['rate'];
        $time       = $data['time'];
        $flag       = $data['flag'];

        foreach ($rate as $key => $value) {
            if(empty($value))
            {
                $rates = 1;
            }

            if($value > 100) {
                $ratesMax = 1;
            }

            if(empty($time[$key]))
            {
                $whens = 1;
            }
        }

        if($rates == 1)
        {
            $return['status'] = 0;
            $return['msg'] = '请填写收益率';
            $this->ajaxReturn($return,'JSON');
        }

        if($ratesMax == 1)
        {
            $return['status'] = 0;
            $return['msg'] = '收益率不能大于100%';
            $this->ajaxReturn($return,'JSON');
        }

        if($whens == 1)
        {
            $return['status'] = 0;
            $return['msg'] = '请填写持单时长';
            $this->ajaxReturn($return,'JSON');
        }

        $parameterObj   = M('option_parameter');

        $parameterObj->where(array('option_id' => $option_id))->delete();

        $dataAdd    = array();
        foreach ($rate as $key => $value) {

            $dataAdd[$key]['option_id']         = $option_id;
            $dataAdd[$key]['rate']              = $rate[$key];
            $dataAdd[$key]['time']              = $time[$key];
            $dataAdd[$key]['flag']              = $flag[$key];
            $dataAdd[$key]['create_time']       = time();
        }

        $flag = $parameterObj->addAll($dataAdd);
        if($flag){

            $return['status'] = 1;
            $return['msg'] = '保存成功';
            $this->ajaxReturn($return,'JSON');
        } else {
            $return['status'] = 0;
            $return['msg'] = '保存失败';
            $this->ajaxReturn($return,'JSON');
        }
    }

    public function gadd(){
        $option_id = trim(I('get.option_id'));
        $optionObj      = M('option');
        $parameterObj   = M('option_parameter');

        $this->display('gaddnew');
    }


}