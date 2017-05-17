<?php
/**
 * 知识库
 * @author steven_allen
 * @date 2015-05-24
 **/
class BaikeController extends WapController
{
	public function init()
	{
		parent::init();
		$this->layout = '/layouts/nobody';
	}

	/**
	 * [actionIndex 知识库首页]
	 */
	public function actionIndex()
	{
		//一级分类
		$firstCates = BaikeCateExt::model()->enabled()->firstLevel()->findAll();
		//二级分类
		$cate = Yii::app()->request->getQuery('cate','');
		if(!$cate)
		{
			$cateRel = BaikeCateExt::model()->enabled()->firstLevel()->find();
			$cate = $cateRel->id;
		}
		//知识库文章
		$baikeLists = $this->getBaikesByFirstCate($cate);
		//换一换开关
		foreach ($baikeLists as $key => $value) {
			$ct = $this->getBaikesBySecondCate($value['id'],0,0,5);
			$baikeHyh[$value['name']] = count($ct)>3?1:0;
		}
		//标签
		$tags = $this->getTags(0,1);
		$this->render('index',array(
			'firstCates' => $firstCates,
			'baikeLists' => $baikeLists,
			'tags' => $tags,
			'cate'=>$cate,
			'baikeHyh' => $baikeHyh
			));
	}

	/**
	 * [getTags 获取标签]
	 * [@paramter isRand 是否随机]
	 * [@paramter isRecom 是否推荐]
	 */
	public function getTags($isRand = 0,$isRecom = 0,$num = 20)
	{
		$criteria = new CDbCriteria([
			'select' => 'id,name',
			'limit' => $num,
			'order' => $isRand ? 'rand()' : 'sort desc',
		]);
		if($isRecom>0) $criteria->addCondition('recom>0');
		$tags = BaikeTagExt::model()->findAll($criteria);
		return $tags;
	}

	/**
	 * [getBaikesByFirstCate 根据一级分类获取知识库文章]
	 */
	public function getBaikesByFirstCate($cate)
	{
		$secondCates = BaikeCateExt::model()->enabled()->findAll(array('condition'=>'parent=:cate','params'=>array(':cate'=>$cate),'order'=>'sort desc'));
		$baikeLists = array();
		foreach ($secondCates as $key => $SecondCate) {
			$cateid = $SecondCate['id'];
			$SecondCate['baike'] = $this->getBaikesBySecondCate($cateid);
			$baikeLists[] = $SecondCate;
		}
		return $baikeLists;
	}

	/**
	 * [getBaikesBySecondCate 根据二级分类获取知识库文章]
	 * [@paramter isRand 是否随机]
	 */
	public function getBaikesBySecondCate($cate,$isRand = 0,$page = 0,$limit = 3)
	{
		$sort = $isRand ? 'rand()' : 't.sort desc,t.created desc';
		$offset = ($page-1)*10;
		$baikes = BaikeExt::model()->enabled()->with('cate')->findAll(array('condition'=>'cate.id=:cid','params'=>array(':cid'=>$cate),'order'=>$sort,'limit'=>$limit,'offset'=>$offset));
		return $baikes;
	}

	/**
	 * [getBaikesByTag 根据标签/问题获取知识库文章]
	 */
	public function getBaikesByTag($name,$kw,$page)
	{
		$criteria = new CDbCriteria;
		$criteria->addSearchCondition($name,$kw);
		$criteria->limit = 10;
		$criteria->offset = 10*($page-1);
		$criteria->order = 'sort,created desc';
		$baikes = BaikeExt::model()->enabled()->findAll($criteria);
		return $baikes;
	}

	/**
	 * actionList 知识库列表页
	 */
	public function actionList($cid,$ajax=0,$kw='',$tag='')
	{
		$tag = $this->cleanXss($tag);
		$kw = $this->cleanXss($kw);
		$cates = BaikeCateExt::model()->enabled()->firstLevel()->with('childCate')->findAll(['index'=>'id']);
		if(!$cates) throw new CHttpException(404, '无启用分类');
		$childCates = [];
		foreach($cates as $cate) {
			foreach($cate->childCate as $childCate) {
				$childCates[$childCate->id] = $childCate;
			}
		}
		$selectedCate = isset($childCates[$cid]) ? $childCates[$cid] : current($childCates);

		//ajax获取数据
		if($tag=='' && $kw==''){
			$criteria = new CDbCriteria([
				'condition' => 'cid=:cid',
				'params' => [':cid'=>$cid]
			]);
			$dataProvider = BaikeExt::model()->enabled()->getList($criteria, 15);
		} else {
			$xsCriteria = new XsCriteria;
			$xsCriteria->addRange('status',1,1);
			$xsCriteria->facetsField = 'status';
			$xsCriteria->order = array('created'=>false);
			if($kw!='') {
				$xsCriteria->query = $kw;
			}
			if($tag!='') {
				$xsCriteria->query = ' tag:'.$tag;
			}
			$dataProvider = BaikeExt::model()->getXsList('house_baike', $xsCriteria, 15);
		}
		$lists = array();
		foreach($dataProvider->data as $v) {
			$tags = [];
			foreach($v->getTags() as $t) {
				$tags[] = [
					'name' => $t,
					'link' => $this->createUrl('/wap/baike/list',['tag'=>$t]),
				];
			}
			$lists[] = array(
				'pic' => ImageTools::fixImage($v->image, 168, 118),
				'link' => $this->createUrl('detail', ['id'=>$v->id]),
				'title' => $kw?str_replace($kw, '<font class="c-red">'.$kw.'</font>', $v->title):$v->title,
				'detail' => $v->description,
				'tags' => $tags
			);
		}
		$pager = $dataProvider->pagination;


		if($ajax==1){
			echo CJSON::encode(['totalPage'=>$pager->pageCount, 'lists'=>$lists]);
			Yii::app()->end();
		}

		//ajax请求链接
		if($kw) {
			$params = ['kw'=>$kw];
		} elseif($tag) {
			$params = ['tag'=>$tag];
		} else {
			$params = ['cid'=>$cid];
		}
		$params['ajax'] = 1;
		$ajaxUrl = $this->createUrl('/wap/baike/list', $params);

		$this->render('list',array(
			'cates' => $cates,
			'cid' => $cid,
			'selectedCate' => $selectedCate,
			'tag' => $tag,
			'kw' => $kw,
			'ajaxUrl' => $ajaxUrl,
			'pager' => $pager
		));
	}

	/**
	 * [actionDetail 知识库详情页]
	 */
	public function actionDetail()
	{
		$this->layout = '/layouts/body';
		$id = Yii::app()->request->getQuery('id');
		$baike = BaikeExt::model()->enabled()->findByPk($id);
		$baike->addViews();
		$rel_baikes = $this->getBaikesBySecondCate($baike->cid,0,0,5);
		$praiseStatus = isset($_COOKIE['baike_praise'.$id])?$_COOKIE['baike_praise'.$id]:'';
		$shareImgUrl = $baike->image ? $baike->image : SM::globalConfig()->siteLogo();
		$this->render('detail',array(
			'baike' => $baike,
			'rel_baikes' => $rel_baikes,
			'praiseStatus' => $praiseStatus,
			'shareImgUrl' =>$shareImgUrl,
			));
	}

	/**
	 * [actionSearch 知识库搜索页]
	 */
	public function actionSearch()
	{
		$tags = $this->getTags(0,1,10);
		$this->render('search',array(
			'tags' => $tags,
			));
	}

	/**
	 * [actionAjaxChangeTags ajax获取标签]
	 */
	public function actionAjaxChangeTags()
	{
		$tags = $this->getTags(1,1);
		$formed = array();
		foreach ($tags as $key => $value) {
			$tmp["link"] = $this->createUrl('list',array('type'=>'tag','value'=>$value['name']));
			$tmp["title"] = $value['name'];
			$formed[] = $tmp;
		}
		echo CJSON::encode(array('lists'=>$formed));
	}

	/**
	 * [actionAjaxChangeBaike ajax获取知识库文章]
	 */
	public function actionAjaxChangeBaike($cate)
	{
		$baikes = $this->getBaikesBySecondCate($cate,1);
		$formed = array();
		foreach ($baikes as $key => $value) {
			$tmp["link"] = $this->createUrl('detail',array('id'=>$value['id']));
			$tmp["title"] = $value['title'];
			$tmp["pic"] = ImageTools::fixImage($value['image']);
			$tmp["detail"] = $value['description'];
			$formed[] = $tmp;
		}
		echo CJSON::encode(array('lists'=>$formed));
	}

	/**
	 * [actionAjaxChangeBaike ajax获取文章列表]
	 */
	public function actionAjaxList()
	{
		$page = Yii::app()->request->getQuery('page',10);
		if(Yii::app()->request->getQuery('cate'))
		{
			$cate = Yii::app()->request->getQuery('cate','');
			$baikes = $this->getBaikesBySecondCate($cate,0,$page,10);
			(int)$count = BaikeExt::model()->enabled()->with('cate')->count(array('condition'=>'cate.id=:cid','params'=>array(':cid'=>$cate)));
		}
		elseif(Yii::app()->request->getQuery('tag'))
		{
			$tag = Yii::app()->request->getQuery('tag','');
			$baikes = $this->getBaikesByTag('tag',$tag,$page);
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('tag',$tag);
			$count = BaikeExt::model()->count($criteria);
		}
		elseif(Yii::app()->request->getQuery('question'))
		{
			$question = Yii::app()->request->getQuery('question','');
			$baikes = $this->getBaikesByTag('title',$question,$page);
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('title',$question);
			$count = BaikeExt::model()->count($criteria);
		}
		$formed = array();
		foreach ($baikes as $key => $value) {
			$tmp["link"] = $this->createUrl('detail',array('id'=>$value->id));
			$tmp["title"] = $value['title'];
			$tmp["pic"] = ImageTools::fixImage($value['image']);
			$tmp["detail"] = $value['description'];
			$formed[] = $tmp;
		}
		echo CJSON::encode(array('lists' => $formed,'totalPage' => ceil($count/10)));
	}

	/**
	 * [actionAjaxSetPraise ajax点赞]
	 */
	public function actionAjaxSetPraise()
	{
		$id = Yii::app()->request->getQuery('id',0);
		$type = Yii::app()->request->getQuery('type');
		$baike = BaikeExt::model()->findByPk($id);
		$cookie = Yii::app()->request->getCookies();
        if(!isset($cookie['baike_praise'.$id])&&$baike) {
        	$baike->$type += 1;
        	$baike->save();
            $cookie = new CHttpCookie('baike_praise'.$id, $type, ['expire'=>time()+7200]);
            Yii::app()->request->cookies['baike_praise'] = $cookie;
            $this->response(1, $baike->$type);
        }
        $this->response(0,'您之前已点赞/反对！');
	}
	/**
	 * [actionAjaxGetTitles ajax获取百科标题]
	 */
	public function actionAjaxGetTitles()
	{
		$kw = Yii::app()->request->getQuery('keywords','');
		$data = array();
		$xsCriteria = new XsCriteria;
		$xsCriteria->addRange('status',1,1);
		$xsCriteria->facetsField = 'status';
		$xsCriteria->order = array('id'=>false);
		if($kw!='') {
			$xsCriteria->query = $kw;
		}
		$dataProvider = BaikeExt::model()->getXsList('house_baike', $xsCriteria, 15);
		if($baikes = $dataProvider->data)
		{
			foreach ($baikes as $key => $value) {
				$tmp['link'] = $this->createUrl('detail',['id'=>$value->id]);
				$tmp['title'] = str_replace($kw, '<em class="c-red">'.$kw.'</em>', $value->title);
				$data[] = $tmp;
			}
		}
		echo CJSON::encode(array('lists'=>$data));
	}

}
