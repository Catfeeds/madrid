<?php
/**
 * 服务控制器
 */
class ServeController extends HomeController{
	/**
	 * [actionList 资讯列表]
	 * @param  string $cate  [description]
	 * @param  string $ptpz  [description]
	 * @param  string $house [description]
	 * @return [type]        [description]
	 */
	public function actionList()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort desc,updated desc';
		$infos = ArticleExt::model()->getServe()->normal()->getList($criteria);
		$data = $infos->data;
		$pager = $infos->pagination;
		$this->render('list',['infos'=>$data,'pager'=>$pager]);
	}
	/**
	 * [actionInfo 资讯详情]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function actionInfo($id='')
	{
		$info = ArticleExt::model()->findByPk($id);
		if(!$info) {
			$this->redirect('list');
		}
		$this->render('info',['info'=>$info]);
	}
}