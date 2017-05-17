<?php
/**
 * 地图找房地图租房
 * @author steven allen <[<email address>]>
 * @date(2016.11.15)
 */
class MapController extends ResoldHomeController
{
	public function actionIndex($type=1)
	{
		$tags = [];
		$tags['来源'] = [['name'=>'不限','id'=>0,'cate'=>'source'],['name'=>'个人','id'=>1],['name'=>'中介','id'=>2]];
		$esfTagArr = ['esfzzprice'=>'总价','resoldhuxing'=>'户型','esfzzsize'=>'面积','esfzzts'=>'特色','esfzfzztype'=>'住宅类型','resoldage'=>'房龄','resoldface'=>'朝向','resoldfloor'=>'楼层','esfzzpt'=>'配套设施','resoldzx'=>'装修'];
		$zfTagArr = ['zfzzprice'=>'总价','resoldhuxing'=>'户型','zfzzsize'=>'面积','zfzzts'=>'特色','esfzfzztype'=>'住宅类型','resoldage'=>'房龄','resoldface'=>'朝向','resoldfloor'=>'楼层','zfzzpt'=>'配套设施','resoldzx'=>'装修'];
		if($type==1)
		{
			foreach ($esfTagArr as $key => $value) {
				$tags[$value] = TagExt::model()->getTagByCate($key)->normal()->findAll();
				array_unshift($tags[$value], ['name'=>'不限','id'=>0,'cate'=>$key]);
			}
		}
		if($type==2)
		{
			foreach ($zfTagArr as $key => $value) {
				$tags[$value] = TagExt::model()->getTagByCate($key)->normal()->findAll();
				array_unshift($tags[$value], ['name'=>'不限','id'=>0,'cate'=>$key]);
			}
		}

		$seoArr = [
			1=>[
				't'=>''.SM::urmConfig()->cityName().'二手房网|'.SM::urmConfig()->cityName().'二手房出售|'.SM::urmConfig()->cityName().'二手房买卖信息- '.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'二手房网,'.SM::urmConfig()->cityName().'二手房买卖信息',
				'd'=>''.SM::urmConfig()->cityName().'二手房网,为您提供最新、最真实的'.SM::urmConfig()->cityName().'二手房信息,免费发布'.SM::urmConfig()->cityName().'二手房买卖、二手房出售信息，找'.SM::urmConfig()->cityName().'二手房经纪人、个人房源信息，欢迎您来到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'二手房网。',
			],
			2=>[
				't'=>''.SM::urmConfig()->cityName().'房屋出租|'.SM::urmConfig()->cityName().'租房子|'.SM::urmConfig()->cityName().'出租房信息- '.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'出租房,'.SM::urmConfig()->cityName().'租房子',
				'd'=>''.SM::urmConfig()->cityName().'出租房网为您提供最新、最真实的'.SM::urmConfig()->cityName().'出租房个人信息、'.SM::urmConfig()->cityName().'出租房经纪人信息，欢迎您来到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'出租房网。',
			],
			3=>[
				't'=>''.SM::urmConfig()->cityName().'二手房网|'.SM::urmConfig()->cityName().'二手房出售|'.SM::urmConfig()->cityName().'二手房买卖信息- '.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'二手房网,'.SM::urmConfig()->cityName().'二手房买卖信息',
				'd'=>''.SM::urmConfig()->cityName().'二手房网,为您提供最新、最真实的'.SM::urmConfig()->cityName().'二手房信息,免费发布'.SM::urmConfig()->cityName().'二手房买卖、二手房出售信息，找'.SM::urmConfig()->cityName().'二手房经纪人、个人房源信息，欢迎您来到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'二手房网。',
			],
			4=>[
				't'=>''.SM::urmConfig()->cityName().'房屋出租|'.SM::urmConfig()->cityName().'租房子|'.SM::urmConfig()->cityName().'出租房信息- '.SM::urmConfig()->cityName().''.SM::globalConfig()->siteName().'',
				'k'=>''.SM::urmConfig()->cityName().'出租房,'.SM::urmConfig()->cityName().'租房子',
				'd'=>''.SM::urmConfig()->cityName().'出租房网为您提供最新、最真实的'.SM::urmConfig()->cityName().'出租房个人信息、'.SM::urmConfig()->cityName().'出租房经纪人信息，欢迎您来到'.SM::globalConfig()->siteName().''.SM::urmConfig()->cityName().'出租房网。',
			],
				
		];
		// if(!SM::resoldConfig()->resoldIsOpenStreet()) {
		// 	$type += 2;
		// }	
		
		if($type > 2)
			$this->render('index2',['ftags'=>array_slice($tags, 0, 5),'ltags'=>array_slice($tags, 5, 6),'type'=>$type,'seoArr'=>$seoArr]);
		else
			$this->render('index',['ftags'=>array_slice($tags, 0, 5),'ltags'=>array_slice($tags, 5, 6),'type'=>$type,'seoArr'=>$seoArr]);
	}
}