<?php
namespace Home\Controller;

use Org\Util\Log;


class UserController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        $this->user_id = session('user_id');
    }

    /**
     * 个人中心
     * @author wang <li>
     */
    public function index()
    {
        $userModel    = D('userinfo');
        $accountModel = M('accountinfo');

        $user = $userModel->getDataFind($this->user_id);

        $levelData = M('user_level')->getField('id,level', true);

        $user['level'] = $levelData[$user['level_id']];
        $account       = $accountModel->field('balance,gold')
                                      ->where(['uid' => $user['uid']])
                                      ->find();

        //查看是否已经完成认证
        $personalObj = M('personal_user_data');
        $personal    = $personalObj->where(['uid' => $this->user_id])
                                   ->find();

        $this->assign('personal', $personal);
        $this->assign('account', $account);
        $this->assign('user', $user);
        $this->display();
    }

    /**
     * 经纪商切换
     * @author wang <li>
     */
    public function BrokersSwitch()
    {
        $this->IsLogin();

        $now_trade_status = trim(I('get.now_trade_status'));
        if ($now_trade_status) {
            M('userinfo')
                ->where(['uid' => $this->user_id])
                ->setField('now_trade_status', $now_trade_status);
            $this->redirect('index');
            exit();
        }

        $userModel = M('PersonalUserData');
        $user      = $userModel->field('card,real_name')
                               ->where([
                                   'uid'    => $this->user_id,
                                   'status' => 1,
                               ])
                               ->find();

        $now_trade_status = M('userinfo')
            ->where(['uid' => $this->user_id])
            ->getField('now_trade_status');

        //获取网站配置
        $webname = M('webconfig')->getField('webname');

        $this->assign('webname', $webname);
        $this->assign('now_trade_status', $now_trade_status);
        $this->assign('user', $user);

        $this->display();

    }


    /**
     * 经纪商开户
     * @author wang <li>
     */
    public function BrokersOpen()
    {
        $this->IsLogin();

        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        $user = $userModel->field('face,nickname')
                          ->where(['uid' => $this->user_id])
                          ->find();

        //个人资料
        $personal = $personalModel->field('province,city,card')
                                  ->where("uid={$this->user_id} and status != 2")
                                  ->find();


        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $province[0]['id'],
                          ])
                          ->select();


        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);
        $this->assign('user', $user);
        $this->display();
    }

    /**
     * 用户银行卡绑定
     * @author wang <li>
     */
    public function UserBindBank()
    {
        $this->IsLogin();

        $real_name  = trim(I('post.real_name'));
        $card       = trim(I('post.card'));
        $banknumber = trim(I('post.banknumber'));
        $bankname   = trim(I('post.bankname'));
        $branch     = trim(I('post.branch'));
        $swiftcode  = trim(I('post.swiftcode'));
        $address    = trim(I('post.address'));
        $tel        = trim(I('post.tel'));
        $bank_img   = trim(I('post.bank_img'));


        $personalModel = M('personal_user_data');
        //个人资料
        $personal = $personalModel->where("uid={$this->user_id} and status != 2")
                                  ->find();

        if (empty($personal['card']) || empty($personal['real_name'])) {
            if (empty($real_name)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_input_name'),
                ]);
            }


            if (empty($card)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_input_id'),
                ]);
            }
        }

        if (empty($banknumber)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_input_bank'),
            ]);
        }

        if (empty($bankname)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_input_bank_name'),
            ]);
        }

        if (empty($branch)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_input_branch'),
            ]);
        }

        if (empty($tel)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_input_tel'),
            ]);
        }

        if (empty($swiftcode)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_input_swiftcode'),
            ]);
        }

        if (empty($address)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_input_address'),
            ]);
        }

        if (empty($bank_img)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_bank_img'),
            ]);
        }

        $bankObj = M('bankinfo');

        $bank = $bankObj->where("uid={$this->user_id} and banknumber={$banknumber} and status != 2")
                        ->find();

        if ($bank) {
            if ($bank['status'] == 0) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_bank_audit'),
                ]);
            } else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_repeat_bind'),
                ]);
            }
        }

        $dataArr = [
            'uid'         => $this->user_id,
            'bankname'    => $bankname,
            'branch'      => $branch,
            'banknumber'  => $banknumber,
            'tel'         => $tel,
            'busername'   => $real_name,
            'card'        => $card,
            'swiftcode'   => $swiftcode,
            'address'     => $address,
            'status'      => 0,
            'bank_img'    => $bank_img,
            'create_time' => time(),
            'user_type'   => 1,
        ];

        $res = $bankObj->add($dataArr);

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        } else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }


    /**
     * standardOpen 标准版开户
     * @author wang li
     */
    public function standardOpen()
    {
        $this->IsLogin();

        //检测是否已经提交
        $personalObj = M('personal_user_data');
        if ($personalObj->field('id')
                        ->where("uid={$this->user_id} and status != 2")
                        ->find()) {
            $this->redirect('examine');

            return false;
        }

        $tempObj = M('temp_personal');

        $info = $tempObj->where('uid='.$this->user_id)
                        ->find();

        $this->assign('info', $info);
        $this->display();
    }


    public function standardBind()
    {
        if (!$this->user_id) {
            outjson([
                'status' => 0,
                'info'   => '请登录',
            ]);
        }

        $real_name = trim(I('real_name'));
        $card      = trim(I('card'));
        $Front     = trim(I('cardPhoneFront'));
        $Verso     = trim(I('cardPhoneVerso'));


        Log::debugArr($real_name);

        if (empty($real_name)) {
            outjson([
                'status' => 0,
                'info'   => '姓名不能为空',
            ]);
        }

        if (is_numeric($real_name) || mb_strlen($real_name) > 15) {
            outjson([
                'status' => 0,
                'info'   => '姓名非法',
            ]);
        }

        if (empty($card)) {
            outjson([
                'status' => 0,
                'info'   => '身份证不能为空',
            ]);
        }

        if (!preg_match("/(^\d{15}$)|(^\d{17}([0-9]|X)$)/", $card)) {
            outjson([
                'status' => 0,
                'info'   => '身份证号码填写不正确',
            ]);
        }

        if (empty($Front)) {
            outjson([
                'status' => 0,
                'info'   => '请上传身份证正面图片',
            ]);
        }

        if (empty($Verso)) {
            outjson([
                'status' => 0,
                'info'   => '请上传身份证反面图片',
            ]);
        }

        $data = [
            'uid'           => $this->user_id,
            'real_name'     => $real_name,
            'card'          => $card,
            'card_positive' => $Front,
            'card_side'     => $Verso,
            'status'        => 0,
            'create_time'   => time(),
        ];

        $tempObj = M('temp_personal');

        if ($tempObj->where('uid='.$this->user_id)
                    ->find()) {
            $res = $tempObj->where('uid='.$this->user_id)
                           ->save($data);
        } else {
            $res = $tempObj->add($data);
        }

        if ($res) {
            outjson([
                'status' => 1,
                'info'   => '操作成功',
            ]);
        } else {
            outjson([
                'status' => 0,
                'info'   => '操作失败',
            ]);
        }
    }

    /**
     * 绑定银行卡
     */
    public function standardBank()
    {
        $this->IsLogin();

        $tempObj = M('temp_personal');

        $info = $tempObj->where('uid='.$this->user_id)
                        ->find();

        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();

        //市
        if (empty($info['bank_province'])) {
            $city = $cityModel->field('id,name')
                              ->where([
                                  'level'     => 2,
                                  'parent_id' => $province[0]['id'],
                              ])
                              ->select();
        } else {
            $city = $cityModel->field('id,name')
                              ->where([
                                  'level'     => 2,
                                  'parent_id' => $info['bank_province'],
                              ])
                              ->select();
        }


        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('info', $info);
        $this->display();
    }


    public function standardBankBind()
    {
        if (!$this->user_id) {
            outjson([
                'status' => 0,
                'info'   => '请登录',
            ]);
        }

        $banknumber = trim(I('post.banknumber'));
        $bankname   = trim(I('post.bankname'));
        $province   = trim(I('post.province'));
        $city       = trim(I('post.city'));
        $branch     = trim(I('post.branch'));
        $tel        = trim(I('post.tel'));
        $bank_img   = trim(I('post.bank_img'));

        if (empty($banknumber)) {
            outjson([
                'status' => 0,
                'info'   => '银行卡号不能为空',
            ]);
        }

        if (!is_numeric($banknumber)) {
            outjson([
                'status' => 0,
                'info'   => '银行卡号填写不正确',
            ]);
        }

        if (empty($bankname)) {
            outjson([
                'status' => 0,
                'info'   => '请选择银行',
            ]);
        }

        if (empty($province) || empty($city)) {
            outjson([
                'status' => 0,
                'info'   => '开户地址不能为空',
            ]);
        }

        if (empty($branch)) {
            outjson([
                'status' => 0,
                'info'   => '开户支行不能为空',
            ]);
        }

        if (!preg_match('/^1\d{10}$/', $tel)) {
            outjson([
                'status' => 0,
                'info'   => '手机号填写错误',
            ]);
        }

        if (empty($bank_img)) {
            outjson([
                'status' => 0,
                'info'   => '请上传银行卡图片',
            ]);
        }

        $bankObj = M('bankinfo');

        $bank = $bankObj->where("uid={$this->user_id} and banknumber={$banknumber} and status != 2")
                        ->find();

        if ($bank) {
            if ($bank['status'] == 0) {
                outjson([
                    'status' => 0,
                    'info'   => '该银行卡审核中',
                ]);
            } else {
                outjson([
                    'status' => 0,
                    'info'   => '该银行卡已经绑定',
                ]);
            }
        }

        $data = [
            'uid'           => $this->user_id,
            'bankname'      => $bankname,
            'banknumber'    => $banknumber,
            'branch'        => $branch,
            'tel'           => $tel,
            'bank_province' => $province,
            'bank_city'     => $city,
            'bank_img'      => $bank_img,
            'status'        => 0,
            'create_time'   => time(),
        ];

        $tempObj = M('temp_personal');

        if ($tempObj->where('uid='.$this->user_id)
                    ->find()) {
            $res = $tempObj->where('uid='.$this->user_id)
                           ->save($data);
        } else {
            $res = $tempObj->add($data);
        }

        if ($res) {
            outjson([
                'status' => 1,
                'info'   => '操作成功',
            ]);
        } else {
            outjson([
                'status' => 0,
                'info'   => '操作失败',
            ]);
        }

    }

    /**
     * 签订协议
     */
    public function agreement()
    {
        $this->IsLogin();

        if (IS_POST) {

            $tempObj     = M('temp_personal');
            $personalObj = M('personal_user_data');
            $bankObj     = M('bankinfo');

            $info = $tempObj->where('uid='.$this->user_id)
                            ->find();

            if (!$info) {
                outjson([
                    'code' => 400,
                    'msg'  => '提交失败了',
                ]);
            }

            if (empty($info['card']) || empty($info['banknumber'])) {
                outjson([
                    'code' => 400,
                    'msg'  => '信息填写不完整',
                ]);
            }

            $personalData = $personalObj->field('id')
                                        ->where("uid={$info['uid']} and status != 2")
                                        ->find();

            if ($personalData) {
                if ($personalData == '0') {
                    outjson([
                        'code' => 400,
                        'msg'  => '信息审核中',
                    ]);
                } else {
                    outjson([
                        'code' => 400,
                        'msg'  => '个人信息请勿重复绑定',
                    ]);
                }
            }

            $bankinfo = $bankObj->field('bid')
                                ->where("uid={$info['uid']} and banknumber={$info['banknumber']} and status != 2")
                                ->find();

            if ($bankinfo) {
                if ($bankinfo['status'] == '0') {
                    outjson([
                        'code' => 400,
                        'msg'  => '银行卡审核中',
                    ]);
                } else {
                    outjson([
                        'code' => 400,
                        'msg'  => '银行卡请勿重复绑定',
                    ]);
                }
            }

            $personal['uid']           = $info['uid'];
            $personal['card']          = $info['card'];
            $personal['real_name']     = $info['real_name'];
            $personal['province']      = $info['bank_province'];
            $personal['city']          = $info['bank_city'];
            $personal['card_positive'] = $info['card_positive'];
            $personal['card_side']     = $info['card_side'];
            $personal['status']        = 0;
            $personal['user_type']     = 1;
            $personal['create_time']   = time();


            $bank['uid']         = $info['uid'];
            $bank['bankname']    = $info['bankname'];
            $bank['province']    = $info['bank_province'];
            $bank['city']        = $info['bank_city'];
            $bank['branch']      = $info['branch'];
            $bank['banknumber']  = $info['banknumber'];
            $bank['busername']   = $info['real_name'];
            $bank['card']        = $info['card'];
            $bank['tel']         = $info['tel'];
            $bank['bank_img']    = $info['bank_img'];
            $bank['status']      = 0;
            $bank['user_type']   = 1;
            $bank['create_time'] = time();

            $personalObj->startTrans(); //开启事务

            if ($personalObj->field('id')
                            ->where("uid={$info['uid']}")
                            ->find()) {
                $persRes = $personalObj->where(['uid' => $info['uid']])
                                       ->save($personal);
            } else {
                $persRes = $personalObj->add($personal);
            }

            $bankRes = $bankObj->add($bank);
            $tempRes = $tempObj->where('id='.$info['id'])
                               ->setField('status', 1);

            try {
                if (($persRes || $bankRes) && $tempRes) {
                    $personalObj->commit();
                    outjson([
                        'code' => 200,
                        'msg'  => '提交成功',
                    ]);
                } else {
                    $personalObj->rollback();
                    outjson([
                        'code' => 400,
                        'msg'  => '提交失败',
                    ]);
                }
            } catch (\Exception $e) {
                $personalObj->rollback();
                outjson([
                    'code' => 400,
                    'msg'  => $e->getMessage(),
                ]);
            }

        } else {

            $catagory = M('newsclass')
                ->where('fid=20')
                ->getField('fid');

            $news = M('newsinfo')
                ->field('ntitle,ncontent')
                ->where('ncategory='.$catagory)
                ->find();

            $news['ncontent'] = html_entity_decode($news['ncontent']);


            $this->assign('news', $news);


            $this->display();
        }
    }

    /**
     * 审核页面
     */
    public function examine()
    {
        $this->IsLogin();

        $personalObj = M('personal_user_data');

        $info = $personalObj->field('status')
                            ->where(['uid' => $this->user_id])
                            ->find();
        if (!$info) {
            $info['status'] = 2;
        }

        $this->assign('status', $info['status']);
        $this->display();
    }


    //处理图片上传
    public function imageUpload()
    {
        $configUpload    = ['rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH];
        $upload          = new \Think\Upload($configUpload);// 实例化上传类
        $upload->maxSize = 52428800;// 设置附件上传大小
        $upload->exts    = [
            'jpg',
            'gif',
            'png',
            'jpeg',
        ];// 设置附件上传类型
        // 上传文件
        $info = $upload->upload();

        if ($info) {

            //            $result = array(
            //                'code' => 1,
            //                'msg'  => json_encode($info)
            //            );
            //            $this->ajaxReturn($result,'JSON');

            $url = $info['file']['savepath'].$info['file']['savename'];
            $img = 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$info['file']['savepath'].$info['file']['savename'];

            $image = new \Think\Image();
            $image->open("./Uploads/{$url}");
            // 按照原图的比例生成一个最大为500*500的缩略图并保存为thumb.jpg
            $image->thumb(600, 600)
                  ->save("./Uploads/{$url}");//直接把缩略图覆盖原图

            $result = [
                'code' => 0,
                'msg'  => L('api_success'),
                'data' => [
                    'url'   => $url,
                    'src'   => $img,
                    'title' => 'img',
                ],
            ];
        } else {
            $result = [
                'code' => 1,
                'msg'  => $upload->getError(),
            ];
        }

        $this->ajaxReturn($result, 'JSON');
    }


    /**
     * [将Base64图片转换为本地图片并保存]
     * @E-mial 990529346@11.com
     * @TIME   2018-04-26
     * @param  [Base64] $base64_image_content [要保存的Base64]
     * @param  [目录] $path [要保存的路径]
     */
    public function base64_image_content($base64_image_content, $path)
    {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type     = $result[2];
            $new_file = $path."/".date('Ymd', time())."/";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file.time().".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                //return '/'.$new_file;
                return time().'.'.$type.'';
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * 个人资料
     * @author wang li
     */
    public function userInfo()
    {
        $this->IsLogin();
        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        $user = $userModel->field('face,nickname')
                          ->where(['uid' => $this->user_id])
                          ->find();

        //个人资料
        $personal = $personalModel->field('province,city')
                                  ->where(['uid' => $this->user_id])
                                  ->find();


        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city_id = !empty($personal['province']) ? $personal['province'] : $province[0]['id'];

        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $city_id,
                          ])
                          ->select();

        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);
        $this->assign('user', $user);
        $this->display();
    }

    /**
     *  个人信息提交
     * @author wang li
     */
    public function ModifyInfo()
    {
        $this->IsLogin();

        $province = trim(I('post.province'));
        $city     = trim(I('post.city'));

        $personalModel = M('personal_user_data');

        $dataArr = [
            'province' => $province,
            'city'     => $city,
        ];

        if ($personalModel->field('uid')
                          ->where(['uid' => $this->user_id])
                          ->find()) {
            $personalModel->where(['uid' => $this->user_id])
                          ->save($dataArr);
        } else {
            $dataArr['uid'] = $this->user_id;
            $personalModel->add($dataArr);
        }
    }


    /**
     * faceUpload 头像上传
     * @author wang li
     */
    public function faceUpload()
    {
        if (!$this->user_id) {
            outjson([
                'status' => 0,
                'info'   => L('no_login'),
            ]);
        }

        $configUpload    = ['rootPath' => SYSTEM_FACE_UPLOAD_PATH];
        $upload          = new \Think\Upload($configUpload);// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts    = [
            'jpg',
            'gif',
            'png',
            'jpeg',
        ];// 设置附件上传类型

        $info = $upload->upload();

        if (!$info) {
            outjson($upload->getError());
        } else {

            $image = new \Think\Image();

            $data = [];
            $url  = 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/face/';
            foreach ($info as $key => $file) {
                $idcover            = $file['savepath'].$file['savename'];
                $data[$file['key']] = $url.$idcover;

                $image->open("./Uploads/face/{$idcover}");
                $image->thumb(400, 400)
                      ->save("./Uploads/face/{$idcover}");//直接把缩略图覆盖原图

            }

            $res = M('userinfo')
                ->where('uid='.$this->user_id)
                ->setField($data);

            if ($res) {
                outjson([
                    'status' => 1,
                    'info'   => L('api_success'),
                ]);
            } else {
                outjson([
                    'status' => 0,
                    'info'   => L('api_fail'),
                ]);
            }
        }
    }


    /**
     * 昵称修改
     * @author wang li
     */
    public function nicknameSave()
    {
        $this->IsLogin();

        if (IS_POST) {
            $nickname = trim(I('post.nickname'));

            if (!$nickname) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_input_nickname'),
                ]);
            }

            $userModel = M('userinfo');

            $res = $userModel->where(['uid' => $this->user_id])
                             ->setField('nickname', $nickname);

            if ($res) {
                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                ]);
            } else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }

        } else {
            $userModel = M('userinfo');
            $user      = $userModel->field('nickname')
                                   ->where(['uid' => $this->user_id])
                                   ->find();
            $this->assign('user', $user);
            $this->display();
        }
    }


    //获取下级城市
    public function getCity()
    {
        $id = trim(I('get.id'));

        $cityModel = M('city');

        $data = $cityModel->field('id,name,joinname')
                          ->where(['parent_id' => $id])
                          ->select();

        outjson($data);
    }


    //判断是否登录
    private function IsLogin()
    {
        if (empty($this->user_id)) {
            if (IS_AJAX) {
                outjson([
                    'code' => 400,
                    'msg'  => L('no_login'),
                ]);
            } else {
                $this->redirect('Login/login');
            }
        }
    }
}
