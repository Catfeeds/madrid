<?php
/**
 * 资讯控制器
 */
class NewsController extends WapController{
	/**
	 * [actionList 资讯列表]
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
			$criteria->addCondition('cid=:cid');
			$criteria->params[':cid'] = $cate;
		}
		$infos = ArticleExt::model()->getNormal()->normal()->getList($criteria,8);
		$data = $infos->data;
		$pager = $infos->pagination;
		$this->render('list',['infos'=>$data,'pager'=>$pager,'cate'=>$cate]);
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