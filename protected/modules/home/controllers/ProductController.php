<?php
class ProductController extends HomeController{
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
}