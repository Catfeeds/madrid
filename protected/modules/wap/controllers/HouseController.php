<?php
/**
 * 酒庄前台控制器
 */
class HouseController extends WapController{
	/**
	 * [actionList 酒庄列表]
	 * @param  string $cate  [description]
	 * @param  string $ptpz  [description]
	 * @param  string $house [description]
	 * @return [type]        [description]
	 */
	public function actionList($cate='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort desc,updated desc';
		if($cate){
			$criteria->addCondition('level=:cid');
			$criteria->params[':cid'] = $cate;
		}
		$infos = HouseExt::model()->getList($criteria,20);
		$data = $infos->data;
		$pager = $infos->pagination;
		$this->render('list',['infos'=>$data,'pager'=>$pager,'cate'=>$cate]);
	}
	/**
	 * [actionInfo 产品详情]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function actionInfo($id='')
	{
		$info = HouseExt::model()->findByPk($id);
		if(!$info) {
			$this->redirect('list');
		}
		$this->render('info',['info'=>$info]);
	}
}