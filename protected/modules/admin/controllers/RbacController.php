<?php
/**
 * 后台集客用户控制器
 * @author weibaqiu
 * @date 2015-09-11
 */
class RbacController extends AdminController
{
    /**
     * 权限控制
     */
    public function RBACRules()
    {
        return array(
            array('allow',
                'roles'=>array('gongzuorenyuan'),
            ),
            array('deny',
                'users'=>array('*')
            )
        );
    }

    /**
     * 用户组列表
     * @return [type] [description]
     */
    public function actionList()
    {
        $auth = Yii::app()->authManager;
        $roles = $auth->getRoles();

        $this->render('list', array(
            'roles' => $roles
        ));
    }

    /**
     * 用户组编辑
     * @param  string $item 授权项标识名
     */
    public function actionEdit($group='')
    {
        $auth = Yii::app()->authManager;
        $role = $auth->getAuthItem($group);
        $tasks = $auth->getTasks();//获得任务

        $r = Yii::app()->request->getPost('Role','');
        if(Yii::app()->request->isPostRequest && !empty($r['chinese']))
        {

            try
            {
                if($group==='')
                {
                    $pinyin = Pinyin::get($r['chinese']);
                    $role = $auth->createRole($pinyin,$r['chinese'],Yii::app()->user->id,$r['description']);
                }
                else
                {
                    $role = $auth->getAuthItem($group);
                    $role->description = $r['description'];
                }

                if(!empty($role))
                {
                    $operations = Yii::app()->request->getPost('operations', array());
                    // var_dump($operations);die;
                    if(is_array($operations))
                    {
                        AuthItemChild::model()->deleteAll(array(
                            'condition' => 'parent=:parent',
                            'params' => array(':parent'=>$role->name)
                        ));
                        foreach($operations as $o)
                        {
                            $role->addChild($o);
                        }
                    }
                    $this->setMessage('保存成功！', 'success');
                }
            }
            catch(Exception $e)
            {
                $this->setMessage('保存失败！', 'error');
            }
        }
        //有该角色$role时，获取其下面已选的子操作项目
        $selected = empty($role) ? array() : $role->getChildren();

        $this->render('edit', array(
            'tasks' => $tasks,
            'role' => $role,
            'selected' => $selected,
        ));
    }

    /**
     * 删除角色
     */
    public function actionDelete()
    {
        if(Yii::app()->request->getIsPostRequest())
        {
            $name = Yii::app()->request->getPost('name', '');
            $transaction = Yii::app()->db->beginTransaction();
            if( AuthAssignment::model()->exists('item_name=:name', array(':name'=>$name)) )
            {
                $this->response(false, '该用户组不为空，请将该用户组内用户分配到其他用户组再删除');
                Yii::app()->end();
            }
            try
            {
                AuthItemChild::model()->deleteAll('parent=:name1 OR child=:name2', array(
                    ':name1'=>$name,
                    ':name2'=>$name
                ));
                AuthAssignment::model()->deleteAll('item_name=:name', array(':name'=>$name));
                AuthItem::model()->deleteAll('name=:name', array(':name'=>$name));
                $transaction->commit();
                $this->setMessage('删除成功', 'success');
                $this->response(true, '删除成功');
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                $this->response(false, '删除失败');
            }
        }
    }

    /**
     * 判断用户组是否存在
     * @param  string  $chinese 用户组名
     * @return boolean
     */
    private function isRoleExist($chinese)
    {
        $roles = Yii::app()->authManager->getRoles();
        foreach($roles as $v)
        {
            if($v->chinese==$chinese)
                return true;
        }
        return false;
    }
}

?>
