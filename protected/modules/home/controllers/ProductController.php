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
	public function actionList($cate='',$area='',$house='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort desc,updated desc';
		$criteria->addCondition('status=1 and deleted=0');
		if($cate){
			$criteria->addCondition('cid=:cid');
			$criteria->params[':cid'] = $cate;
		}
		if($area){
			$criteria->addCondition('area=:cid1');
			$criteria->params[':cid1'] = $area;
		}
		if($house){
			$criteria->addCondition('house=:cid2');
			$criteria->params[':cid2'] = $house;
		}
		$infos = ProductExt::model()->normal()->getList($criteria,12);
		$data = $infos->data;
		$pager = $infos->pagination;
		$areas = [];
		if($data) {
			foreach ($data as $key => $value) {
				$value->area && $areas[] = $value->area;
			}
		}
		array_filter($areas);
		$this->render('list',['infos'=>$data,'pager'=>$pager,'cate'=>$cate,'house'=>$house,'areas'=>$areas,'area'=>$area]);
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

	public function actionAlbum($id='')
	{
		$info = ProductExt::model()->findByPk($id);
		$this->render('album',['images'=>$info->images]);
	}
}