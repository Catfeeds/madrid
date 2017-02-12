<?php
/**
 * 二手房控制器
 * @author steven allen <[<email address>]>
 * @date(2016.10.31)
 */
class EsfController extends ResoldHomeController
{

	/**
	 * [$viewRecordor 房源浏览记录器]
	 * @var [type]
	 */
	public $viewRecordor;
	/**
	 * [$get Query]
	 * @return [type] [description]
	 */
	public $get;
 	public $plot;
	public $pager;
	public $moreGet;
	public $esf;
	public $staff;

	public function init()
    {
        parent::init();
        $this->viewRecordor = new ResoldViewRecordor;
    }
	/**
	 * [actionList 二手房列表页]
	 * @return [type] [description]
	 */
	public function actionList()
	{
		$recom = Yii::app()->request->getQuery('recom',0);
		$limit = Yii::app()->request->getQuery('limit',10);
		$kw = Yii::app()->request->getQuery('kw','');
		$price = Yii::app()->request->getQuery('price',0);
		$sort = (int)Yii::app()->request->getQuery('sort',7);
		$minprice = Yii::app()->request->getQuery('minprice',0);
		$minsize = Yii::app()->request->getQuery('minsize',0);
		$maxsize = Yii::app()->request->getQuery('maxsize',0);
		$area = Yii::app()->request->getQuery('area',0);
		$street = Yii::app()->request->getQuery('street',0);
		$source = Yii::app()->request->getQuery('source',0);
		$bedroom = Yii::app()->request->getQuery('bedroom',0);
		$ts = Yii::app()->request->getQuery('ts',0);
		$maxprice = Yii::app()->request->getQuery('maxprice',0);
		$size = Yii::app()->request->getQuery('size',0);
		$school = Yii::app()->request->getQuery('school',0);
		$type = Yii::app()->request->getQuery('type',1);
		$page = Yii::app()->request->getQuery('page',1);
		$age = Yii::app()->request->getQuery('age',0);
		$hurry = Yii::app()->request->getQuery('hurry',0);
		$hid = Yii::app()->request->getQuery('hid',0);
		$floor = Yii::app()->request->getQuery('floor',0);
		$towards = Yii::app()->request->getQuery('towards',0);
		$decoration = Yii::app()->request->getQuery('decoration',0);
		$subtype = Yii::app()->request->getQuery('subtype',0);
		$saletime = Yii::app()->request->getQuery('saletime',0);
		$pt = Yii::app()->request->getQuery('pt',0);
		$saletime = Yii::app()->request->getQuery('saletime',0);
		$cate = Yii::app()->request->getQuery('cate',0);
		$level = Yii::app()->request->getQuery('level',0);
		$moreimg = Yii::app()->request->getQuery('moreimg',0);
		// $uid = Yii::app()->user->uid;
		$tagBetween = ['price'=>$price,'size'=>$size,'age'=>$age,'floor'=>$floor,'saletime'=>$saletime];
		$tagDirect = ['area'=>$area,'towards'=>$towards,'decoration'=>$decoration,'street'=>$street,'source'=>$source,'area'=>$area,'hid'=>$hid,'hurry'=>$hurry];
		$esf = [];
		//有没有筛选条件
		$needFilter = 1;
		$pathInfo = Yii::app()->request->getPathInfo();

		$typeName = $type==1?'zz':($type==2?'sp':'xzl');
		$sortArr = ['1'=>['price'=>true],'2'=>['price'=>false],'3'=>['ave_price'=>true],'4'=>['ave_price'=>false],'5'=>['size'=>true],'6'=>['size'=>false],'7'=>['refresh_time'=>false],'8'=>['sale_time'=>false]];
		$multiQuery = ['ts'=>$ts,'subtype'=>$subtype,'pt'=>$pt,'cate'=>$cate,'level'=>$level];
		// 如果recom为1 则只从推荐表中找
		// 根据请求的地址确定推荐位位置
		if($recom)
		{
			$needFilter = 0;
			$recomesfs = [];
			$recomPlace = ['resoldWapApi/esf/list'=>'wapsyjpesf'];
			$recoms = ResoldRecomExt::model()->getRecom($recomPlace[$pathInfo])->findAll(['limit'=>$limit,'order'=>'t.sort desc,t.created desc']);
			if($recoms)
				foreach ($recoms as $key => $value) {
					$recomesfs[] = ResoldEsfExt::model()->findByPk($value->fid);
				}
			if($recomesfs)
				foreach ($recomesfs as $key => $value) {
					$farea = AreaExt::model()->findByPk($value->area);
					$esf[] = ['id'=>$value->id,'title'=>$value->title,'image'=>$value->image,'bedroom'=>$value->bedroom,'livingroom'=>$value->livingroom,'bathroom'=>$value->bathroom,'area'=>$farea->name,'price'=>$value->price];
				}
		}
		else
		{
			// 如果recom不为1且无排序 则先将所有房源找出 后把推荐的房源排在前面
			// 若有排序 按照排序规则
			// 若有学校 从学校模型中找楼盘
			$ids = [];
			$xs = Yii::app()->search->house_esf;
			// 查询关键词先走plot再走school
			$plot = $schoolkw = [];
			if($kw)
			{
				$xs->setQuery('');
				$xs->addQueryString('title:'.$kw,XS_CMD_QUERY_OP_OR);
				$plot = PlotExt::model()->find(['condition'=>'title=:title','params'=>[':title'=>$kw]]);
				if($plot)
				{
					$hid = $plot->id;
					$xs->addQueryString('hid:'.$hid,XS_CMD_QUERY_OP_OR);
				}
				elseif(!$plot && !$school)
				{
					$schoolkw = SchoolExt::model()->normal()->find(['condition'=>'name=:title','params'=>[':title'=>$kw]]);
					$school = $schoolkw?$schoolkw->id:0;
				}
			}
			else
				$xs->setQuery($kw);

			$xs->setFacets(array('status'), true);//分面统计

	        foreach ($multiQuery as $key => $tag) {
	        	if($tag)
	        	{
	        		$q = 'tag:'.$tag;
	        		$xs->addQueryString($q, XS_CMD_QUERY_OP_AND);
	        	}
	        }
	        $xs->addRange('status', 1, 1);
	        $xs->addRange('expire_time', time(), null);
	        $xs->addRange('deleted', 0, 0);
	        $xs->addRange('category', $type, $type);

	        $xs->addRange('sale_status', 1, 1);
	        // 特色标签筛选

	        // 区间
	        foreach ($tagBetween as $key => $tag) {
	        	if($key=='age' && $tag)
	        	{
	        		$model = TagExt::model()->findByPk($tag);
		        	$xs->addRange($key, date('Y')-$model->max,date('Y')-$model->min);
	        	}
	        	elseif($key=='saletime' && $tag)
	        	{
		        	$xs->addRange('sale_time', time()-$tag*86400,time());
	        	}
	        	elseif($key=='floor' && $tag)
	        	{
		        	$xs->addQueryString('tag:'.$tag, XS_CMD_QUERY_OP_AND);
	        	}
	        	elseif($tag)
		        {
		        	$model = TagExt::model()->findByPk($tag);
		        	$xs->addRange($key, $model->min, $model->max?$model->max:null);
		        }
	        }
	        foreach ($tagDirect as $key => $tag) {
	        	if($key=='hurry' && $tag)
	        	{
	        		$xs->addRange($key, time()-SM::resoldConfig()->resoldHurryTime->value*3600, time());
	        	}
	        	elseif($key=='hid' && $tag)
	        	{
	        		$plot = PlotExt::model()->findByPk($hid);
	        		if($kw)
						$xs->addQueryString('hid:'.$hid, XS_CMD_QUERY_OP_OR);
					else
						$xs->addQueryString('hid:'.$hid, XS_CMD_QUERY_OP_AND);
	        	}
	        	else
	        	{
	        		$tag and $xs->addRange($key, $tag, $tag);
	        	}

	        }

	        $minprice and $xs->addRange('price', $minprice, null);
	        $maxprice and $xs->addRange('price', null, $maxprice);
	        $minsize and $xs->addRange('size', $minsize, null);
	        $maxsize and $xs->addRange('size', null, $maxsize);
	        $moreimg and $xs->addRange('image_count', $moreimg, null);
	        // 各种判断
	        // $area and $xs->addRange('area', $area, $area);
	        // $towards and $xs->addRange('towards', $towards, $towards);
	        // $decoration and $xs->addRange('decoration', $decoration, $decoration);
	        // $street and $xs->addRange('street', $street, $street);
	        // $source and $xs->addRange('source', $source, $source);
	        // $area and $xs->addRange('area', $area, $area);
	        // $hid and $xs->addRange('hid', $hid, $hid);
	        // $hurry and $xs->addRange('hurry', 0, null);
	        // $uid and $xs->addRange('uid', $uid, $uid);

	        $bedroomTag = TagExt::model()->findByPk($bedroom);

	        $bedroom && ( $bedroomTag->min>5 ? $xs->addRange('bedroom', $bedroomTag->min, null) : $xs->addRange('bedroom', $bedroomTag->min, $bedroomTag->min) );
	        // 学区筛选
	        if($school)
			{
				$schoolres = SchoolExt::model()->normal()->findByPk($school);
				$schoolkw = $schoolres;
				if($kw)
					$xs->addQueryString('school:'.$school, XS_CMD_QUERY_OP_OR);
				else
					$xs->addQueryString('school:'.$school, XS_CMD_QUERY_OP_AND);
			}


			// 排序,规则：@self::sortArr>hurry>sort>refresh_time>sale_time>id
			$defaultSort = $hurry?['hurry'=>false,'sort'=>false,'refresh_time'=>false,'sale_time'=>false,'id'=>false]:['sort'=>false,'refresh_time'=>false,'sale_time'=>false,'id'=>false];

	        if($sort)
	        	$xs->setMultiSort(array_merge($sortArr[$sort],$defaultSort));
	        else
	        	$xs->setMultiSort($defaultSort);

			// 增加排序条件需要放在Count统计完数量之后
	        $count = 0;
	        $xs->search();//count放在search之后才能应用排序条件
	        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量

	        // 分页
	        $pager = new CPagination($count);
	        $pager->pageSize = $limit;

	        $xs->setLimit($limit, $limit*$pager->currentPage);
	        $docs = $xs->search();
	        if($docs)
		        foreach ($docs as $key => $value) {
		        	$ids[] = $value->id;
		        }

		    $criteria = new CDbCriteria();
            $criteriaSort = $hurry?'hurry desc,sort desc,refresh_time desc,sale_time desc':'sort desc,refresh_time desc,sale_time desc';

            if($sort)
                $criteriaSort = array_keys($sortArr[$sort])[0].(array_values($sortArr[$sort])[0]?' asc,':' desc,').$criteriaSort;
            $criteria->order = $criteriaSort;
	        $criteria->addInCondition('id', $ids);
	        $esfs = ResoldEsfExt::model()->getList($criteria,20);
		}
		$esfData = [];
		if($esfs) {
			$esfData = $esfs->data;
		}
		$seoArr = [
			'1'=>[
				't'=>''.SM::urmConfig()->cityName().'二手房网|'.SM::urmConfig()->cityName().'二手房出售|'.SM::urmConfig()->cityName().'二手房买卖信息- '.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'二手房网,'.SM::urmConfig()->cityName().'二手房买卖信息',
				'd'=>''.SM::urmConfig()->cityName().'二手房网,为您提供最新、最真实的'.SM::urmConfig()->cityName().'二手房信息,免费发布'.SM::urmConfig()->cityName().'二手房买卖、二手房出售信息，找'.SM::urmConfig()->cityName().'二手房经纪人、个人房源信息，欢迎您来到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'二手房网。',
			],
			'2'=>[
				't'=>''.SM::urmConfig()->cityName().'商铺出售|'.SM::urmConfig()->cityName().'店铺出售信息-'.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'商铺出售',
				'd'=>''.SM::urmConfig()->cityName().'商铺出售频道为您提供'.SM::urmConfig()->cityName().'商铺出售信息，在这里有大量的'.SM::urmConfig()->cityName().'商铺出售信息供您查询。查找'.SM::urmConfig()->cityName().'商铺出售信息，请到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'商铺出售频道。',
			],
			'3'=>[
				't'=>''.SM::urmConfig()->cityName().'写字楼出售|'.SM::urmConfig()->cityName().'店铺出售信息-'.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'写字楼出售',
				'd'=>''.SM::urmConfig()->cityName().'写字楼出售频道为您提供'.SM::urmConfig()->cityName().'写字楼出售信息，在这里有大量的'.SM::urmConfig()->cityName().'写字楼出售信息供您查询。查找'.SM::urmConfig()->cityName().'写字楼出售信息，请到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'写字楼出售频道。',
			]

		];
		$this->get = ['bedroom'=>$bedroom,'sort'=>$sort,'type'=>$type,'page'=>$page,'kw'=>$kw]+$multiQuery+$tagDirect+$tagBetween;
		$this->plot = $plot;
		$this->pager = $pager;
		$this->moreGet = ['school'=>$school,'esfNum'=>$count];
		$this->render('list',['esfs'=>$esfs->data,'pager'=>$pager,'plot'=>$plot,'school'=>$schoolkw,'esfNum'=>$count,'page'=>$page,'get'=>$this->get,'seoArr'=>$seoArr[$type]]);

	}

	public function actionInfo($id=0,$type=0)
	{
		if(!$id)
			$this->redirect('list');
		$this->viewRecordor->add($id,1);
		$esf = ResoldEsfExt::model()->saling()->findByPk($id);
		if(!$esf)
			$this->redirect('/resoldhome');
		if($esf->category != 1 && !$type)
			$this->redirect("/resoldhome/esf/info?id=$id&type=".$esf->category);
		$esf->hits += 1;
		$esf->save();
		$user = $staff = $plotOtherEsfs = $staffOtherEsfs =  [];
		$esf->getIsStaff() && $staff = $esf->getIsStaff();
		// $esf->getSamePlotEsf() && $plotOtherEsfs = $esf->getSamePlotEsf(5);

		!$staff && $user = Yii::app()->uc->getUser(2,2) && $user = $user?$user[2]:[];
		$this->esf = $esf;
		$this->staff = $staff;
		$this->moreGet = ['user'=>$user,'plotOtherEsfs'=>$plotOtherEsfs,'staffOtherEsfs'=>$staffOtherEsfs];
		$seoArr = [
			'1'=>[
				't'=>''.$esf->title.'-'.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'二手房,'.($esf->areaInfo?$esf->areaInfo->name:'').'二手房,'.($esf->streetInfo?$esf->streetInfo->name:'').'二手房,'.($esf->plot?$esf->plot->title:'').'二手房 ',
				'd'=>''.SM::urmConfig()->cityName().'二手房-'.SM::globalConfig()->siteName().'提供'.SM::urmConfig()->cityName().''.($esf->plot?$esf->plot->title:'').'二手房出售信息，'.($esf->plot?$esf->plot->title:'').''.($esf->bedroom?($esf->bedroom.'室'):'').''.($esf->size?($esf->size.'平方'):'').'出售信息， 找更多'.SM::urmConfig()->cityName().''.($esf->plot?$esf->plot->title:'').'二手房信息就到'.SM::urmConfig()->cityName().'二手房-'.SM::globalConfig()->siteName().'。',
			],
			'2'=>[
				't'=>''.$esf->title.'- '.($esf->streetInfo?$esf->streetInfo->name:'').'商铺出售- '.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'商铺出售',
				'd'=>''.$esf->title.'，'.Tools::u8_title_substr(htmlspecialchars($esf->content), 20).'',
			],
			'3'=>[
				't'=>''.$esf->title.'- '.($esf->streetInfo?$esf->streetInfo->name:'').'写字楼出售- '.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'写字楼出售',
				'd'=>''.$esf->title.'，'.Tools::u8_title_substr(htmlspecialchars($esf->content), 20).'',
			]

		];
		$this->render('info',[
			'esf'=>$esf,
			'plot'=>$esf->plot?$esf->plot:[],
			'staff'=>$staff,'plotOtherEsfs'=>$plotOtherEsfs,
			'user'=>$user,'seoArr'=>$seoArr,
			'streetInfo'=>isset($esf->streetInfo) && $esf->streetInfo?$esf->streetInfo:[],
			'areaInfo'=>isset($esf->areaInfo) && $esf->areaInfo?$esf->areaInfo:[],
			]);
	}
}
