<?php
/**
 * 站点配置
 * @author steven.allen
 * @date 2017.2.13
 */
class SiteController extends VipController
{
	public function actionList()
	{
		
		// 页面初始化
		$sites = [];
		foreach (SiteExt::$cateTag as $key => $value) {
			$sites[$key] = SiteExt::$cateName[$key];
		}

		$this->render('list',['sites'=>$sites]);
	}

	public function actionEdit($type='')
	{
		// post请求
		if(Yii::app()->request->getIsPostRequest()) {
			$values = Yii::app()->request->getPost('SiteExt',[]);
			$model = new SiteExt;
			var_dump($values);exit;
			$model->attributes = $values;
			if($model->save()) {
				$this->setMessage('操作成功！','success');
				$this->redirect('index');
				Yii::app()->end();
			}
		}

		if($type) {
			$model = SiteExt::model()->find(['condition'=>'name=:name','params'=>[':name'=>$type]]) ? SiteExt::model()->find(['condition'=>'name=:name','params'=>[':name'=>$type]]) : new SiteExt;
			$model->name = $type;

			$this->render('edit',['cate'=>$type,'model'=>$model]);
		} else {
			$this->redirect('list');
		}
	}
}