<?php
/**
 * 产品前台控制器
 */
class ProductController extends HomeController{
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
		if($cate){
			$criteria->addCondition('cid=:cid');
			$criteria->params[':cid'] = $cate;
		}
		if($ptpz){
			$criteria->addCondition('ptpz=:cid');
			$criteria->params[':cid'] = $ptpz;
		}
		if($house){
			$criteria->addCondition('house=:cid');
			$criteria->params[':cid'] = $house;
		}
		$infos = ProductExt::model()->normal()->getList($criteria,12);
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
		$info = ProductExt::model()->findByPk($id);
		if(!$info) {
			$this->redirect('list');
		}
		$this->render('info',['info'=>$info]);
	}
}