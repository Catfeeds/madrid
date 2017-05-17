<?php
/**
 * 中介店铺控制器
 * @author steven allen <[<email address>]>
 * @date(2016.11.9)
 */
class ShopController extends ResoldHomeController
{
	/**
	 * [$shop 当前店铺]
	 * @var [type]
	 */
	public $shop;
	/**
	 * [$esfNum 二手房数]
	 * @var [type]
	 */
	public $esfNum;
	/**
	 * [$zfNum 租房数]
	 * @var [type]
	 */
	public $zfNum;
	/**
	 * [$staffNum 经纪人个数]
	 * @var [type]
	 */
	public $staffNum;
	/**
	 * [$sortArr 排序数组]
	 * @var [type]
	 */
	public $sortArr = [
		1=>' price asc, ',
		2=>' price desc, ',
		3=>' ave_price asc, ',
		4=>' ave_price desc, ',
		5=>' size asc, ',
		6=>' size desc, ',
		7=>' refresh_time desc, ',
		8=>' sale_time desc, ',
	];
	public function init()
	{
		parent::init();
		$shop = Yii::app()->request->getQuery('shop',0);
		$this->shop = ResoldShopExt::model()->findByPk($shop);
		if(!$this->shop)
			$this->redirect('/resoldhome/index/index');
		$c_resold = new CDbCriteria;
		$c_resold->addCondition('sid=:sid and expire_time>:time');
		$c_resold->params[':sid'] = $shop;
        $c_resold->params[':time'] = time();

		$this->esfNum = ResoldEsfExt::model()->saling()->count($c_resold);
		$this->zfNum = ResoldZfExt::model()->saling()->count($c_resold);
        $c_staff = new CDbCriteria();
        $c_staff->addCondition('t.deleted=0 and t.sid=:sid and t.status=1 and t.id_expire>:time and staffPackage.expire_time>:time');
        $c_staff->with = 'staffPackage';
        $c_staff->params[':sid'] = $shop;
        $c_staff->params[':time'] = time();
		$this->staffNum = ResoldStaffExt::model()->count($c_staff);
		unset($c_resold);unset($c_staff);
	}
	/**
	 * [actionIndex 店铺首页]
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		$shopModel = $this->shop;
		if(!$shopModel)
			$this->redirect('/resoldhome/index/index');
		//最近发布房源
		$criteria = new CDbCriteria(array(
            'condition'=>'sid=:sid and expire_time>:time',
            'params'=>array(':sid'=>$shopModel->id,':time'=>time()),
            'order'=>'sale_time desc',
            'limit'=>5
        ));
//		$criteria->addCondition('sid=:sid and sale_time>=:time');
		// var_dump($shop);exit;
//		$criteria->params[':time'] = TimeTools::getDayBeginTime() - 15*86400;
		$latestEsfs = ResoldEsfExt::model()->saling()->findAll($criteria);
		$latestZfs = ResoldZfExt::model()->saling()->findAll($criteria);
//		$latestEsfCount = count($latestEsfs);
//		$latestEsfs && $latestEsfs = array_slice($latestEsfs, 0, 5);
		//推荐二手房
/*		$criteria = new CDbCriteria;
		$criteria->addCondition('sid=:sid');
		$criteria->params[':sid'] = $shopModel->id;
		$criteria->order = 'refresh_time desc';

		$recomEsfs = ResoldEsfExt::model()->saling()->findAll($criteria);
		$esfNum = $this->esfNum;
		$recomEsfs && $recomEsfs = array_slice($recomEsfs, 0, 5);*/

		//推荐租房
	/*	$criteria = new CDbCriteria;
		$criteria->addCondition('sid=:sid');
		$criteria->params[':sid'] = $shopModel->id;
		$criteria->order = 'refresh_time desc';

		$recomZfs = ResoldZfExt::model()->saling()->findAll($criteria);
		$zfNum = $this->zfNum;
		$recomZfs && $recomZfs = array_slice($recomZfs, 0, 5);*/

		//金牌经纪人
		$xs = Yii::app()->search->house_staff;
		$xs->setQuery('');
		$xs->addRange('status',1,1);
		$xs->addRange('package_expire',time(),null);
		$xs->addRange('deleted',0,0);
		$xs->addRange('sid',$this->shop->id,$this->shop->id);
		$xs->addRange('id_expire',time(),null);
		$xs->setMultiSort(['package_num'=>false,'package_expire'=>false,'created'=>false,'last_login'=>false]);
		$xs->setLimit(6);
		$staffs = [];
		if($docs = $xs->search())
			foreach ($docs as $key => $value) {
				$staffs[] = ResoldStaffExt::model()->findByPk($value->id);
			}

		$seoArr = [
			't'=>''.SM::urmConfig()->cityName().''.$this->shop->name.'-'.SM::globalConfig()->siteName().'',
			'k'=>''.$this->shop->name.','.$this->shop->phone.'',
			'd'=>''.$this->shop->name.'的网上店铺为您提供更多的二手房房源、租房房源信息。找房源、卖二手房、买二手房请致电:'.$this->shop->phone.'，'.$this->shop->name.'为您竭诚服务。',
		];
		$this->render('index',[
				'shop'=>$shopModel,
				'latestEsfs'=>$latestEsfs,
                'latestZfs'=>$latestZfs,
//				'latestZfCount'=>$latestZfCount,
//				'latestEsfCount'=>$latestEsfCount,
//				'esfNum'=>$esfNum,
//				'recomEsfs'=>$recomEsfs,
//				'zfNum'=>$zfNum,
//				'recomZfs'=>$recomZfs,
				'staffs'=>$staffs,
				'seoArr'=>$seoArr
			]);
	}
	/**
	 * [actionEsfList 二手房列表]
	 * @param  integer $saletime [description]
	 * @param  integer $sort     [description]
	 * @return [type]            [description]
	 */
	public function actionEsfList($sort=0)
	{
        $sortArray = [
            1 => 'refresh_time desc',
            2 => 'sale_time desc',
            3 => 'price desc',
            4 => 'price asc',
            5 => 'ave_price desc',
            6 => 'ave_price asc',
            7 => 'size desc',
            8 => 'size asc'
        ];
        if(!isset($sortArray[$sort])){
            $sort = 1;
        }
		$shopModel = $this->shop;
		$criteria = new CDbCriteria;
		$criteria->addCondition('sid=:sid and expire_time>:time');
		$criteria->params[':sid'] = $shopModel->id;
		$criteria->params[':time'] = time();
//		$saletime && $criteria->addCondition('sale_time>=:time') && $criteria->params[':time'] = TimeTools::getDayBeginTime() - $saletime*86400;
//		$defaultSort = 'recommend desc,sort desc,refresh_time desc,sale_time desc';
//		$criteria->order = $sort ? $this->sortArr[$sort].$defaultSort :$defaultSort;
        $criteria->order = $sortArray[$sort];
		$esfs = ResoldEsfExt::model()->saling()->getList($criteria);
		$data = $esfs->data;
		$pagination = $esfs->pagination;
		$this->render('esfList',[
				'shop'=>$this->shop,
				'get'=>['sort'=>$sort,'shop'=>$this->shop->id],
				'esfs'=>$data ,
				'pager'=>$pagination,
				'esfNum'=>$this->esfNum,
				'zfNum'=>$this->zfNum,
				'staffNum'=>$this->staffNum,
			]);
	}
	/**
	 * [actionZfList 租房列表]
	 * @param  integer $saletime [description]
	 * @param  integer $sort     [description]
	 * @return [type]            [description]
	 */
	public function actionZfList($sort=1)
	{
		$sortArray = array(
			1 => 'refresh_time desc',
			2 => 'sale_time desc',
			3 => 'price desc',
			4 => 'price asc',
			5 => 'size desc',
			6 => 'size asc'
		);
        if(!isset($sortArray[$sort])){
            $sort = 1;
        }
		$shopModel = $this->shop;
		$criteria = new CDbCriteria;
		$criteria->addCondition('sid=:sid  and expire_time>:time');
		$criteria->params[':sid'] = $shopModel->id;
        $criteria->params[':time'] = time();
//		$saletime && $criteria->addCondition('sale_time>=:time') && $criteria->params[':time'] = TimeTools::getDayBeginTime() - $saletime*86400;
//		$defaultSort = 'recommend desc,sort desc,refresh_time desc';
		$criteria->order = $sortArray[$sort];

		$zfs = ResoldZfExt::model()->saling()->getList($criteria);
		$this->render('zfList',[
				'shop'=>$this->shop,
				'get'=>['sort'=>$sort,'shop'=>$this->shop->id],
				'zfs'=>$zfs->data,
				'pager'=>$zfs->pagination,
				'esfNum'=>$this->esfNum,
				'zfNum'=>$this->zfNum,
				'staffNum'=>$this->staffNum,
			]);
	}
	/**
	 * [actionStaffList 经纪人列表]
	 * @return [type] [description]
	 */
	public function actionStaffList($limit=15)
	{
		$shopModel = $this->shop;
		//金牌经纪人
		$xs = Yii::app()->search->house_staff;
		$xs->setQuery('');
		$xs->setFacets(array('status'), true);//分面统计
		$xs->addRange('status',1,1);
		$xs->addRange('package_expire',time(),null);
		$xs->addRange('deleted',0,0);
		$xs->addRange('sid',$this->shop->id,$this->shop->id);
		$xs->addRange('id_expire',time(),null);
		// $area && $xs->addRange('area',$area,$area);
		// $street && $xs->addRange('street',$street,$street);
		$xs->setMultiSort(['package_num'=>false,'package_expire'=>false,'created'=>false,'last_login'=>false]);
		$staffs = [];
		$count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量

        // 分页
        $pager = new CPagination($count);
        $pager->pageSize = $limit;
        $staffs = [];
        $xs->setLimit($limit, $limit*$pager->currentPage);
		if($docs = $xs->search())
			foreach ($docs as $key => $value) {
				$staffs[] = ResoldStaffExt::model()->findByPk($value->id);
			}
		$this->render('staffList',[
				'shop'=>$this->shop,
				'staffs'=>$staffs,
				'pager'=>$pager,
				'esfNum'=>$this->esfNum,
				'zfNum'=>$this->zfNum,
				'staffNum'=>$this->staffNum,
				'page'=>isset($_GET['page'])?$_GET['page']:1,
			]);
	}
	/**
	 * [actionInfo 店铺介绍]
	 * @return [type] [description]
	 */
	public function actionInfo()
	{
		$this->render('info',[
			'shop'=>$this->shop,
			'esfNum'=>$this->esfNum,
			'zfNum'=>$this->zfNum,
			'staffNum'=>$this->staffNum,
			]);
	}
}