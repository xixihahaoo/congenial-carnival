<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

class CountryController extends CommonController
{

    public function lists()
    {
        $user = A('Admin/User');
        $user->checklogin();

        $countryObj = M('country');

        $count     = $countryObj->count();
        $pagecount = 10;
        $page      = new \Think\Page($count, $pagecount);
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');

        $show = $page->show();

        $newlist = $countryObj->order('id desc')
                              ->limit($page->firstRow.','.$page->listRows)
                              ->select();

        $this->assign('page', $show);
        $this->assign('newlist', $newlist);
        $this->display();
    }


    public function add()
    {

        if (IS_POST) {

            $country = M('country');

            $idcover = '';

            header("Content-type: text/html; charset=utf-8");
            $configUpload    = ['rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH];
            $upload          = new \Think\Upload($configUpload);// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts    = [
                'jpg',
                'gif',
                'png',
                'jpeg',
            ];// 设置附件上传类型

            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }
            else {
                // 上传成功 获取上传文件信息
                foreach ($info as $file) {
                    $idcover = $file['savepath'].$file['savename'];
                }
            }

            if ($country->create()) {
                $country->update_time = time();
                $country->logo        = $idcover;

                $result = $country->add();
                if ($result) {
                    $this->success("添加成功", U('Country/lists'));
                }
                else {
                    $this->error("添加失败");
                }
            }
            else {
                $this->error($country->getError());
            }

        }
        else {
            $this->display();
        }
    }


    public function edit()
    {
        if (IS_POST) {

            $country = M('country');
            $idcover = '';


            header("Content-type: text/html; charset=utf-8");
            $upload           = new \Think\Upload();// 实例化上传类
            $upload->maxSize  = 3145728;// 设置附件上传大小
            $upload->exts     = [
                'jpg',
                'gif',
                'png',
                'jpeg',
            ];// 设置附件上传类型
            $upload->rootPath = 'Public/Uploads'; // 设置附件上传根目录
            $info             = $upload->upload();

            if ($info == "") {
                $idcover = I('post.logo');
            }
            else {
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }
                else {
                    // 上传成功 获取上传文件信息
                    foreach ($info as $file) {
                        $idcover = $file['savepath'].$file['savename'];
                    }
                }
            }


            $id = I('post.id');

            $data['name']        = I('post.name');
            $data['content']     = I('post.content');
            $data['logo']        = $idcover;
            $data['update_time'] = time();

            $result = $country->where('id='.$id)->save($data);
            if ($result === false) {
                $this->error("修改失败！");
            }
            else {
                $this->success("修改成功", U('lists'));
            }
        } else {

            $id         = I('get.id');
            $conutryObj = M('country');

            $data = $conutryObj->where(['id' => $id])
                               ->find();

            $data['content'] = html_entity_decode($data['content']);

            $this->assign('data', $data);
            $this->display();
        }
    }

    //删除文章
    public function del()
    {
        $country    = D('country');
        $arrnid     = I('post.id');
        $nid        = I('get.id');

        if (IS_POST) {
            $result = $country->where('id in('.implode(',', $arrnid).')')
                           ->delete();
            if ($result !== false) {
                $this->success("成功删除{$result}条！", U("lists"));
            }
            else {
                $this->error('删除失败！');
            }
        }
        else {
            $result = $country->where('id='.$nid)
                           ->delete();
            if ($result !== false) {
                $this->success("成功删除！", U("lists"));
            }
            else {
                $this->error('删除失败！');
            }
        }
    }

}