<?php
/**
 * 后台员工控制器
 * @author weibaqiu
 * @date 2015-09-14
 */
class WorkerController extends AdminController
{
	/**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
			//集客所有内容的权限设置
			array('allow',
				'roles' => array('gongzuorenyuan'),
			),
			array('allow',
				'expression' => '$user->id=='.Yii::app()->request->getQuery('id',0)
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}
	/**
	 * 后台员工列表
	 */
	public function actionList($username='', $group='',$status='')
	{
		$criteria = new CDbCriteria(array(
			'with' => array(
				'role' => array()
			)
		));
		if($username!='')
			$criteria->addSearchCondition('username', $username);
		if($group!='')
		{
			$criteria->addCondition('role.item_name=:group');
			$criteria->params[':group'] = $group;
		}
		if($status!='')
		{
			$criteria->addCondition('status=:status');
			$criteria->params[':status'] = $status;
		}
		$dataProvidor = AdminExt::model()->getList($criteria);
		$this->render('list', array(
			'data'=>$dataProvidor->data,
			'pager'=>$dataProvidor->pagination,
			'username'=>$username,
			'group'=>$group,
			'status'=>$status
		));
	}

	/**
	 * ajax修改状态
	 */
	public function actionAjaxStatus()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$id = Yii::app()->request->getPost('id', 0);
			$model = AdminExt::model()->findByPk($id);
			if($model && $model->changeStatus())
				$this->setMessage('修改成功！', 'success');
			else
			{
				$this->response(false, '修改失败！');
			}
		}
	}

	/**
	 * 添加员工
	 */
	public function actionAdd()
	{
		$user = new AdminExt();
		$authItems = array();
		$auth = Yii::app()->authManager;
		foreach($auth->getRoles() as $v)
		{
			$authItems[$v->name] = $v->chinese;
		}
		if(Yii::app()->request->isPostRequest)
		{
			$user = new AdminExt;
			$user->attributes = Yii::app()->request->getPost('AdminExt', array());
			if($user->save())
				$this->setMessage('添加成功！', 'success', array('list'));
			else
				$this->setMessage('添加失败！', 'error');
		}
		$this->render('edit', array(
			'user'=>$user,
			'authItems' => $authItems,
		));
	}

	/**
	 * 编辑员工信息
	 * @param  int $id 员工id
	 */
	public function actionEdit($id)
	{
		$transaction=Yii::app()->db->beginTransaction();
		try
		{
			$user = AdminExt::model()->findByPk($id);
			$authItems = array();
			foreach(Yii::app()->authManager->getRoles() as $v)
			{
				$authItems[$v->name] = $v->chinese;
			}
			// var_dump($authItems);die;
			if(Yii::app()->request->isPostRequest)
			{

				$user->attributes = Yii::app()->request->getPost('AdminExt', array());
				if($user->save())
				{
					$transaction->commit();
					Yii::app()->user->setState('avatar',$user->avatar);
					if(Yii::app()->user->checkAccess('gongzuorenyuan'))
						$this->setMessage('修改成功！', 'success', array('list'));
					else
						$this->setMessage('修改成功！', 'success', array('common/index'));
				}
			}
		}
		catch(Exception $e)
		{
			$transaction->rollBack();
			$this->setMessage('修改失败！', 'error');
		}

		$this->render('edit', array(
			'user'=>$user,
			'authItems' => $authItems,
		));
	}

	/**
	 * 修改密码
	 * @param int $id 员工id
	 */
	public function actionPassword()
	{
		$id = Yii::app()->request->getQuery('id', Yii::app()->user->id);
		$user = AdminExt::model()->findByPk($id);
		$user->scenario = 'changePwd';	//使用修改密码场景
		if(Yii::app()->request->isPostRequest && !empty($_POST['AdminExt']))
		{
			if($user->password == md5($_POST['AdminExt']['password']))
			{
				$user->password = $_POST['AdminExt']['pwd1'];
				$user->pwd1 = $_POST['AdminExt']['pwd1'];
				$user->pwd2 = $_POST['AdminExt']['pwd2'];
				if($user->save())
					Yii::app()->user->setFlash('success', '密码修改成功！将在下一次登录时生效。<a href="'.$this->createUrl('/admin/sys/logout').'">点此重新登陆</a>');
			}
			else
				Yii::app()->user->setFlash('error', '原密码错误！');
		}
		$this->render('password', array(
			'user' => $user,
		));
	}
}

?>
