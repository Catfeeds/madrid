<?php
/**
 * 产品前台控制器
 */
class ProductController extends WapController{
	/**
	 * [actionList 产品列表]
	 * @param  string $cate  [description]
	 * @param  string $ptpz  [description]
	 * @param  string $house [description]
	 * @return [type]        [description]
	 */
	public function actionList($cate='',$ptpz='',$house='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort desc,updated desc';
		$criteria->addCondition('status=1 and deleted=0');
		if($cate){
			$criteria->addCondition('cid=:cid');
			$criteria->params[':cid'] = $cate;
		}
		if($ptpz){
			$criteria->addCondition('ptpz=:cid1');
			$criteria->params[':cid1'] = $ptpz;
		}
		if($house){
			$criteria->addCondition('house=:cid2');
			$criteria->params[':cid2'] = $house;
		}
		$infos = ProductExt::model()->normal()->getList($criteria,20);
		$data = $infos->data;
		$pager = $infos->pagination;
		$this->render('list',['infos'=>$data,'pager'=>$pager,'cate'=>$cate,'ptpz'=>$ptpz,'house'=>$house]);
	}
	/**
	 * [actionInfo 产品详情]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function actionInfo($id='')
	{
		if(Yii::app()->request->getIsPostRequest()) {
    		$guest = new GuestExt;
    		$data['name'] = Yii::app()->request->getPost('name','');
    		$data['mail'] = Yii::app()->request->getPost('email','');
    		$data['phone'] = Yii::app()->request->getPost('tel','');
    		$data['msg'] = Yii::app()->request->getPost('content','');
    		$data['pid'] = Yii::app()->request->getPost('pid',0);

    		$guest->attributes = $data;
    		if($guest->save()) {
    			$this->redirect('info');
    		}
    	} 
		$info = ProductExt::model()->findByPk($id);
		if(!$info) {
			$this->redirect('list');
		}
		$this->render('info',['info'=>$info]);
	}

	public function actionAlbum($id='')
	{
		$info = ProductExt::model()->findByPk($id);
		$this->render('album',['images'=>$info->images]);
	}
}