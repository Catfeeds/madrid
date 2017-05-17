<?php
/**
 * 中介经纪人控制器
 * @author steven allen <[<email address>]>
 * @date(2016.11.9)
 */
class StaffController extends ResoldHomeController
{
	public $staff;
	/**
	 * [$sortArr 排序数组]
	 * @var [type]
	 */
	public $sortArr = [
		1=>['price'=>true],
		2=>['price'=>false],
		3=>['ave_price'=>true],
		4=>['ave_price'=>false],
		5=>['size'=>true],
		6=>['size'=>false],
		7=>['refresh_time'=>true],
		8=>['sale_time'=>false],
	];
	public function init()
	{
		parent::init();
		$staff = Yii::app()->request->getQuery('staff',0);
		if($staff && !($this->staff = ResoldStaffExt::model()->findByPk($staff)))
			$this->redirect('/resoldhome/index/index');
	}
	public function actionStaffList($area=0,$street=0,$sort=0,$limit=10,$page=1,$kw='')
	{
		$sortArr = [
			1=>['esf_num'=>true],
			2=>['esf_num'=>false],
			3=>['zf_num'=>true],
			4=>['zf_num'=>false],
		];
		$xs = Yii::app()->search->house_staff;
		$xs->setQuery($kw);
		$xs->setFacets(array('status'), true);//分面统计
		$xs->addRange('status',1,1);
		$xs->addRange('package_expire',time(),null);
		$xs->addRange('deleted',0,0);
		$xs->addRange('id_expire',time(),null);
		$area && $xs->addRange('area',$area,$area);
		$street && $xs->addRange('street',$street,$street);
		$sort ? $xs->setMultiSort($sortArr[$sort]+['package_num'=>false,'package_expire'=>false,'created'=>false,'last_login'=>false,]) : $xs->setMultiSort(['package_num'=>false,'package_expire'=>false,'created'=>false,'last_login'=>false]);
		$staffs = [];
		$count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量

        // 分页
        $pager = new CPagination($count);
        $pager->pageSize = $limit;

        $xs->setLimit($limit, $limit*$pager->currentPage);
		if($docs = $xs->search())
			foreach ($docs as $key => $value) {
				$staffs[] = ResoldStaffExt::model()->findByPk($value->id);
			}
		$seoArr = [
			't'=>''.SM::urmConfig()->cityName().'专业的房地产经纪人网络平台-'.SM::globalConfig()->siteName().'',
			'k'=>''.SM::globalConfig()->siteName().'网络经纪人，房地产经纪人',
			'd'=>''.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'专业的房地产经纪人网络平台，为房地产经纪人提供网络营销工具、房源管理工具，是成为优秀网络经纪人专业的网络平台。',
		];
		$this->render('staffList',['staffCount'=>$count,'staffs'=>$staffs,'area'=>$area,'street'=>$street,'sort'=>$sort,'page'=>$page,'pager'=>$pager,'seoArr'=>$seoArr]);
	}

	public function actionShopList($area=0,$street=0,$sort=0,$limit=10,$page=1,$kw='')
	{
		$sortArr = [
			1=>['esf_num'=>true],
			2=>['esf_num'=>false],
			3=>['zf_num'=>true],
			4=>['zf_num'=>false],
			5=>['staff_num'=>true],
			6=>['staff_num'=>false],
		];
		$xs = Yii::app()->search->house_shop;
		$xs->setQuery($kw);
		$xs->setFacets(array('status'), true);//分面统计
		$xs->addRange('status',1,1);
		$xs->addRange('deleted',0,0);
		$area && $xs->addRange('area',$area,$area);
		$street && $xs->addRange('street',$street,$street);
		$sort ? $xs->setMultiSort($sortArr[$sort]+['staff_num'=>false,'created'=>false,'sort'=>false]) : $xs->setMultiSort(['staff_num'=>false,'created'=>false,'sort'=>false]);
		$shops = [];
		$count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量

        // 分页
        $pager = new CPagination($count);
        $pager->pageSize = $limit;
        $shops = [];
        $xs->setLimit($limit, $limit*$pager->currentPage);
		if($docs = $xs->search())
			foreach ($docs as $key => $value) {
				if(!ResoldShopExt::model()->findByPk($value->id))
					continue;
				$info = ResoldShopExt::model()->findByPk($value->id)->attributes;
				$info = (array)$info;
				$info['esf_num'] = $value->esf_num;
				$info['zf_num'] = $value->zf_num;
				$info['staff_num'] = $value->staff_num;
				$shops[] = $info;
			}
		$seoArr = [
			't'=>''.SM::urmConfig()->cityName().'中介门店-'.SM::globalConfig()->siteName().'',
			'k'=>''.SM::urmConfig()->cityName().'房产中介门店',
			'd'=>''.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'专业的房地产中介门店平台，为房地产经纪人提供网络营销工具、房源管理工具，是成为优秀网络经纪人专业的网络平台。',
		];
		$this->render('shopList',['shopCount'=>$count,'shops'=>$shops,'street'=>$street,'area'=>$area,'sort'=>$sort,'page'=>$page,'pager'=>$pager,'seoArr'=>$seoArr]);
	}

	public function actionEsfList($kw='',$sort=1,$hid=0)
	{
		$sortArray = [
			1 => ['db'=>'refresh_time desc','xs'=>['refresh_time'=>false]],
			2 => ['db'=>'sale_time desc','xs'=>['sale_time'=>false]],
			3 => ['db'=>'price desc','xs'=>['price'=>false]],
			4 => ['db'=>'price asc','xs'=>['price'=>true]],
			5 => ['db'=>'ave_price desc','xs'=>['ave_price'=>false]],
			6 => ['db'=>'ave_price asc','xs'=>['ave_price'=>true]],
			7 => ['db'=>'size desc','xs'=>['size'=>false]],
			8 => ['db'=>'size asc','xs'=>['size'=>true]]
		];
		if(!isset($sortArray[$sort])){
			$sort = 1;
		}
		$staffModel = $this->staff;
		$xs = Yii::app()->search->house_esf;
		$xs->setQuery('');
		$xs->setFacets(array('status'), true);
		$xs->addRange('deleted',0,0);
		$hid && $xs->addRange('hid',$hid,$hid);
		$xs->addRange('expire_time', time(), null);
		$xs->addQueryString('status:1',XS_CMD_QUERY_OP_AND);
		$xs->addQueryString('sale_status:1',XS_CMD_QUERY_OP_AND);
		$xs->addQueryString('uid:'.$staffModel->uid,XS_CMD_QUERY_OP_AND);
		$xs->setMultiSort($sortArray[$sort]['xs']);
		$count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量

		$criteria = new CDbCriteria();
        // 分页
        $pager = new CPagination($count);
        $pager->pageSize = $limit = 10;
        $xs->setLimit($limit, $limit*$pager->currentPage);
		$ids = array();
        if($docs = $xs->search()){
        	foreach ($docs as $key => $value) {
        		$ids[] = $value->id;
			}
		}
		$criteria->addInCondition('id',$ids);
		$criteria->order = $sortArray[$sort]['db'];
		$dataProvider = ResoldEsfExt::model()->getList($criteria);
		$seoArr = [
			't'=>''.$this->staff->name.'的网上店铺,致电'.$this->staff->phone.'-'.SM::urmConfig()->cityName().'经纪人-'.SM::globalConfig()->siteName().'',
			'k'=>''.($this->staff->shop?$this->staff->shop->name:'').','.$this->staff->phone.'',
			'd'=>''.($this->staff->shop?$this->staff->shop->name:'').'的网上店铺为您提供更多的二手房房源、租房房源信息。找房源、卖二手房、买二手房请致电:'.$this->staff->phone.'，'.$this->staff->name.'为您竭诚服务。',
		];
		$plot = $hid ? PlotExt::model()->findByPk($hid) : [];

		$this->render('esfList',[
				'esfs'=>$dataProvider->data,
				'staff'=>$this->staff,
				'count'=>$count,
				'get'=>['sort'=>$sort,'staff'=>$this->staff->id],
				'pager'=>$pager,
				'seoArr'=>$seoArr,
				'plot'=>$plot

			]);
	}

	public function actionZfList($sort=1,$hid=0)
	{
		$sortArray = [
			1 => ['db'=>'refresh_time desc','xs'=>['refresh_time'=>false]],
			2 => ['db'=>'sale_time desc','xs'=>['sale_time'=>false]],
			3 => ['db'=>'price desc','xs'=>['price'=>false]],
			4 => ['db'=>'price asc','xs'=>['price'=>true]],
			5 => ['db'=>'size desc','xs'=>['size'=>false]],
			6 => ['db'=>'size asc','xs'=>['size'=>true]]
		];
		if(!isset($sortArray[$sort])){
			$sort = 1;
		}
		$staffModel = $this->staff;
		$xs = Yii::app()->search->house_zf;
		$xs->setQuery('');
		$xs->setFacets(array('status'), true);
		$xs->addRange('deleted',0,0);
		$hid && $xs->addRange('hid',$hid,$hid);
		$xs->addRange('expire_time', time(), null);
		$xs->addRange('uid',$staffModel->uid,$staffModel->uid);
		$xs->addQueryString('status:1',XS_CMD_QUERY_OP_AND);
		$xs->addQueryString('sale_status:1',XS_CMD_QUERY_OP_AND);
		$xs->setMultiSort($sortArray[$sort]['xs']);
//        $xs->addRange('sid',$staffModel->shop->id,$staffModel->shop->id);
//        $saletime && $xs->addRange('sale_time',TimeTools::getDayBeginTime() - $saletime*86400,null);
//        $sort ? $xs->setMultiSort($this->sortArr[$sort]+['sort'=>false,'refresh_time'=>false,'created'=>false]) : $xs->setMultiSort(['sort'=>false,'refresh_time'=>false,'created'=>false]);
//        $shops = [];
		$count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量
		$criteria = new CDbCriteria();
        // 分页
        $pager = new CPagination($count);
        $pager->pageSize = $limit = 10;
        $xs->setLimit($limit, $limit*$pager->currentPage);
		$ids = array();
		if($docs = $xs->search()){
			foreach ($docs as $key => $value) {
				$ids[] = $value->id;
			}
		}
		$criteria->addInCondition('id',$ids);
		$criteria->order = $sortArray[$sort]['db'];
		$plot = $hid ? PlotExt::model()->findByPk($hid) : [];
		$dataProvider = ResoldZfExt::model()->getList($criteria);
		$this->render('zfList',[
				'zfs'=>$dataProvider->data,
				'staff'=>$this->staff,
				'count'=>$pager->itemCount,
				'get'=>['sort'=>$sort,'staff'=>$this->staff->id],
				'pager'=>$pager,
				'plot'=>$plot
			]);
	}
}