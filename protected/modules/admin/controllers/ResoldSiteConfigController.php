<?php
/**
 * 二手房/租房站点配置
 */
class ResoldSiteConfigController extends AdminController
{

	public $model;

	public function init()
	{
		$type = Yii::app()->request->getQuery('type', 'resoldConfig');
		$this->model = SM::{$type}();
		return parent::init();
	}

	public function actionIndex()
	{
		if(Yii::app()->request->getIsPostRequest())
		{
			$className = get_class($this->model);
			$postData = Yii::app()->request->getPost($className,[]);
			$this->model->attributes = $postData;

			if($this->model->save())
				$this->setMessage('提交成功！','success');
			else {
				var_dump($this->model->errors,$this->model->resoldExtraSaleNum->value );die;
				if($errors = $this->model->errors) {
					$error = current(current($errors));
				} else {
					$error = '保存失败！';
				}
				$this->setMessage($error,'error');
			}
		}
		$this->render('index');
	}
}
