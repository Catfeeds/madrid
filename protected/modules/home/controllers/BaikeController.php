<?php
/**
 * 知识库
 * @author steven_allen
 * @date 2015-06-05
 **/
class BaikeController extends HomeController
{
	/**
	 * [actionIndex 知识库首页]
	 */
	public function actionIndex()
	{
		//分类
		$criteria = new CDbCriteria;
		$criteria->addInCondition('pinyin', array_keys(BaikeCateExt::$pcSixPinyin));
		$cates = BaikeCateExt::model()->enabled()->findAll($criteria);

		//文章列表
		$list = [];
		$criteria = new CDbCriteria([
			'with' => ['cate'],
			'limit'=> 3,
		]);
		foreach(BaikeCateExt::getXinfangBelong() as $value=>$name) {
			$criteria->condition = 'cate.belong=:value';
			$criteria->params[':value'] = $value;
			$criteria->order = 't.created desc';
			$list[$name] = BaikeExt::model()->enabled()->findAll($criteria);
		}

		//标签
		$hotTags = BaikeTagExt::model()->recommendatory()->findAll(['limit'=>50]);

		$this->render('index',array(
			'cates' => $cates,
			'list' => $list,
			'hotTags' => $hotTags,
		));
	}

	/**
	 * [actionList 知识库列表页]
	 */
	public function actionList($cid=0, $tag='',$sort='',$kw='',$belong=0)
	{
		if ($belong > 0
			&& $belongCate = BaikeCateExt::model()->enabled()->find('belong=:belong', [':belong' => $belong]
			)
		) {
			//根据归属跳转进来
			$this->redirect(['list', 'cid' => $belongCate->id]);
		}
		$cid = (int)$cid;
		$tag = $this->cleanXss($tag);
		$sort = $this->cleanXss($sort);
		$kw = $this->cleanXss($kw);

		//取左侧分类
		$criteria = new CDbCriteria();
		$belongs = array_keys(BaikeCateExt::getXinfangBelong());
		$criteria->addInCondition('belong', $belongs);
		$cates = BaikeCateExt::model()->enabled()->findAll($criteria);

		//取列表（要用迅搜）
		$xsCriteria = new XsCriteria;
		$xsCriteria->addRange('status', 1, 1);
		$xsCriteria->facetsField = 'status';
		$xsCriteria->order = array('created' => false);
		if ($cid > 0) {
			$xsCriteria->addRange('cid', $cid, $cid);
		}
		if ($sort != '') {
			$xsCriteria->order = array('scan' => false, 'id' => false);
		}
		if ($kw != '') {
			$xsCriteria->query = $kw;
		}
		if ($tag != '') {
			$xsCriteria->query .= ' tag:' . $tag;
		}
		$dataProvider = BaikeExt::model()->getXsList('house_baike', $xsCriteria, 10);
		$data = $dataProvider->data;
		$pager = $dataProvider->pagination;

		$this->render('list', array(
			'data' => $data,
			'pager' => $pager,
			'sort' => $sort,
			'cid' => $cid,
			'kw' => $kw,
			'tag' => $tag,
			'count' => $pager->itemCount,
			'cates' => $cates,//分类
		));
	}

	/**
	 * [actionDetail 知识库详情页]
	 */
	public function actionDetail()
	{
		// $this->layout = '/layouts/body';
		$id = Yii::app()->request->getQuery('id');
		$baike = BaikeExt::model()->enabled()->findByPk($id);
		$baike->addViews();
		// $rel_baikes = $this->getBaikesBySecondCate($baike->cid,0,0,5);
		$this->render('detail',array(
			'baike' => $baike,
			// 'rel_baikes' => $rel_baikes,
			));
	}

	/**
	 * [actionAjaxGetHits ajax获取热点知识文章]
	 */
	public function actionAjaxChange()
	{
		$baikes = BaikeExt::model()->enabled()->findAll(array('order'=>'rand()','limit'=>5));
		$formed = array();
		foreach ($baikes as $key => $value) {
			$tmp = array(
				'url' => $this->createUrl('detail',array('id'=>$value['id'])),
				'title' => Tools::u8_title_substr($value['title'],30),
				'info' => Tools::u8_title_substr($value['description'],52),
				'pic' => ImageTools::fixImage($value['image'])
				);
			$formed[] = $tmp;
		}
		echo CJSON::encode($formed);
	}

}
