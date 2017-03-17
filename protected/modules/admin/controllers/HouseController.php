<?php
/**
 * 楼盘控制器
 * @author tivon <[<email address>]>
 * @date(2017.03.17)
 */
class HouseController extends AdminController{
	/**
	 * [actionImport 抓取页面]
	 * @return [type] [description]
	 */
	public function actionImport()
	{
		$urls = Yii::app()->request->getQuery('urls','');
		if(trim($urls)) {
			$urlArr = explode(' ', $urls);
			$urlArr = array_filter($urlArr);
			if($urlArr)
				foreach ($urlArr as $key => $value) {
					$this->fetchHouse($value);
				}
		}
		$this->render('import');
	}

	/**
	 * [fetchHouse 抓取流程]
	 * @param  string $url [description]
	 * @return [type]      [description]
	 */
	public function fetchHouse($url='')
	{
		// 地图数据
		// ditu.fang.com/?c=channel&a=xiaoquNew&newcode=1821031186&city=cz
		$plot = New PlotExt;
		$urlarr = explode('.', $url);
		$plot->pinyin = str_replace('http://', '', $urlarr[0]);
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		// 截取body
		preg_match_all('/<body>[.|\s|\S]+body>/', $totalHtml, $results);
		// 去除script标签
		$result = str_replace('script', '', $results[0]);
		var_dump($result);exit;
		
	}

	/**
	 * [fetchHx 抓取户型图]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function fetchHx($value='')
	{
		# code...
	}

	/**
	 * [fetchImage 抓取相册]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function fetchImage($value='')
	{
		# code...
	}

	/**
	 * [actionList 楼盘列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionList($title='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		if($title)
			$criteria->addSearchCondition('title',$title);
		$houses = PlotExt::model()->undeleted->getList($criteria,20);
		$this->render('list',['infos'=>$houses->data,'pager'=>$houses->pagination]);
	}

	/**
	 * [actionEdit 楼盘编辑页]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function actionEdit($id='')
	{
		$house = PlotExt::model()->findByPk($id);
		if(!$house){
			$this->redirect('/admin');
		}
		if(Yii::app()->request->getIsPostRequest()) {
			$values = Yii::app()->request->getPost('PlotExt',[]);
			$house->attributes = $values;
			if($house->save()) {
				$this->setMessage('保存成功','success');
				$this->redirect('/admin/house/list');
			} else {
				$this->setMessage('保存失败','error');
			}
		}
		$this->render('edit',['house'=>$house]);
	}

	/**
	 * [actionExport 导出固定格式接口]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function actionExport($page='')
	{
		// is_new=>1 status=>1 is_coop=>1
		# code...
	}
}