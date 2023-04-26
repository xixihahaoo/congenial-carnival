<?php
namespace Admin\Controller;

class RoleController extends CommonController
{
    /**
     * 角色列表
     * @date   2020-05-22 10:28
     * @return void
     */
    public function get_list()
    {
        $user = A('Admin/User');
        $user->checklogin();

        $role_name = trim(I('get.role_name'));

        if (!empty($role_name)) {
            $where['role_name'] = [
                'like',
                '%'.$role_name.'%',
            ];
            $sea['role_name']   = $role_name;
        }

        $db = M('role');

        $count = $db->where($where)
                    ->count();

        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;

        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $list = $db->order('created_at desc')
                   ->where($where)
                   ->limit($page->firstRow, $page->listRows)
                   ->select();

        //总权限列表
        $menuObj = M('menus');

        $menu = $menuObj->field('id,title,p_id')
                        ->where(['status' => 1])
                        ->order('sort asc')
                        ->select();

        $menus = $this->menu($menu);

        //角色权限节点
        $role_id   = array_unique(array_column($list, 'id'));
        $role_menu = M('role_menu')
            ->where([
                'role_id' => [
                    'in',
                    $role_id,
                ],
            ])
            ->select();

        foreach ($list as $key => $val) {

            $menu_id = [];
            foreach ($role_menu as $k => $v) {
                if ($val['id'] == $v['role_id']) {
                    array_push($menu_id, (int)$v['menu_id']);
                }
            }

            $list[ $key ]['menu_id'] = json_encode($menu_id);
        }

        $this->assign('sea',$sea);
        $this->assign('menus_all', json_encode($menus));
        $this->assign('page', $page->show());
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 新增
     * @date   2020-05-22 10:28
     * @return void
     */
    public function add()
    {
        $role_name = trim(I('post.role_name'));

        if (empty($role_name)) {
            $data['status'] = 0;
            $data['msg']    = '角色名称不能为空';
            $this->ajaxReturn($data, 'JSON');
        }

        $db = M('role');

        $info = $db->field('id,role_name')
                   ->where(['role_name' => $role_name])
                   ->find();

        if ($info) {
            $data['status'] = 0;
            $data['msg']    = '角色名称已经存在';
            $this->ajaxReturn($data, 'JSON');
        }

        $insert = [
            'role_name'  => $role_name,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $res = $db->add($insert);

        if (!$res) {
            $data['status'] = 0;
            $data['msg']    = '添加失败';
            $this->ajaxReturn($data, 'JSON');
        }

        $data['status'] = 1;
        $data['msg']    = '添加成功';
        $this->ajaxReturn($data, 'JSON');
    }

    /**
     * 修改
     * @date   2020-05-22 10:28
     * @return void
     */
    public function update()
    {
        $role_id   = trim(I('post.role_id'));
        $role_name = trim(I('post.role_name'));

        if (empty($role_id)) {
            $data['status'] = 0;
            $data['msg']    = '角色Id不能为空';
            $this->ajaxReturn($data, 'JSON');
        }

        if (empty($role_name)) {
            $data['status'] = 0;
            $data['msg']    = '角色名称不能为空';
            $this->ajaxReturn($data, 'JSON');
        }

        $db = M('role');

        $info = $db->field('id,role_name')
                   ->where(['id' => $role_id])
                   ->find();

        if (!$info) {
            $data['status'] = 0;
            $data['msg']    = '数据不存在';
            $this->ajaxReturn($data, 'JSON');
        }

        $check_info = $db->field('id,role_name')
                         ->where(['role_name' => $role_name])
                         ->find();

        if ($check_info && $check_info['id'] != $role_id) {
            $data['status'] = 0;
            $data['msg']    = '角色名称已经存在';
            $this->ajaxReturn($data, 'JSON');
        }

        $update = [
            'role_name'  => $role_name,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $res = $db->where(['id' => $role_id])
                  ->save($update);

        if (!$res) {
            $data['status'] = 0;
            $data['msg']    = '修改失败';
            $this->ajaxReturn($data, 'JSON');
        }

        $data['status'] = 1;
        $data['msg']    = '修改成功';
        $this->ajaxReturn($data, 'JSON');
    }

    /**
     * 删除
     * @date   2020-05-22 10:28
     * @return void
     */
    public function delete()
    {
        $role_id = trim(I('post.role_id'));

        if (empty($role_id)) {
            $data['status'] = 0;
            $data['msg']    = '角色Id不能为空';
            $this->ajaxReturn($data, 'JSON');
        }

        $db   = M('role');
        $urDb = M('user_role');
        $rmDb = M('role_menu');


        M()->startTrans();

        $res = $db->where(['id' => $role_id])
                  ->delete();

        if ($res) {

            $urDb->where(['role_id' => $role_id])
                 ->delete();

            $rmDb->where(['role_id' => $role_id])
                 ->delete();

            M()->commit();

            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data, 'JSON');
        }
        else {

            M()->rollback();

            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data, 'JSON');
        }
    }

    /**
     * 权限控制
     * @author 王海东
     * @date   2020-05-22 10:34
     * @return void
     */
    public function auth_menu()
    {
        $role_id = trim(I('post.role_id'));
        $menus   = trim(I('post.menus'));

        if (empty($role_id)) {
            $data['status'] = 0;
            $data['msg']    = '角色Id不能为空';
            $this->ajaxReturn($data, 'JSON');
        }

        $data = stripslashes(html_entity_decode($menus)); //$info是传递过来的json字符串
        $data = json_decode($data, true);

        $menu_id = $this->get_menu_id($data);

        $result = [];
        array_walk_recursive($menu_id, function($value) use (&$result) {
            array_push($result, $value);
        });

        M('role_menu')->where(['role_id' => $role_id])->delete();

        if(!empty($result)) {

            $insert = [];
            foreach ($result as $key => $value) {
                $insert['role_id'] = $role_id;
                $insert['menu_id'] = $value;

                M('role_menu')->add($insert);
            }
        }

        $data['status'] = 1;
        $data['msg']    = '操作成功';
        $this->ajaxReturn($data, 'JSON');
    }

    private function menu($data, $pid = 0)
    {
        $new_arr = [];
        foreach ($data as $k => $v) {
            if ($v['p_id'] == $pid) {
                $child         = $this->menu($data, $v['id']); //加入数组
                $v['children'] = $child ?: [];
                unset($v['p_id']);
                $new_arr[] = $v;//加入数组中
            }
        }

        return $new_arr;
    }

    private function get_menu_id($data)
    {
        $menu_id = [];
        foreach ($data as $key => $val) {

            $children = $val['children'];

            if (!empty($children)) {
                $menu_id[] = $this->get_menu_id($children);
            }
            else {
                array_push($menu_id,$val['id']);
            }
        }

        return $menu_id;
    }
}