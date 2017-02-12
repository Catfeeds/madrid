<?php
/**
 * 每日价格统计
 * @author steven.allen <[<email address>]>
 * @date 2016.09.20
 */
class ResoldDailyController extends AdminController
{
	public function actionList($time='')
	{
		$criteria = new CDbCriteria(['order'=>'date desc']);
		if($time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition('date>=:beginTime');
            $criteria->addCondition('date<:endTime');
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;
        }
		$lists = ResoldDailyExt::model()->getList($criteria);

		$this->render('list',['list'=>$lists->data,'page'=>$lists->pagination,'time'=>$time]);
	}

	public function actionArea($id)
	{
		$criteria = new CDbCriteria(['condition'=>'id=:id','params'=>[':id'=>$id]]);
		$lists = ResoldDailyExt::model()->getList($criteria);

		$daily = $lists->data;
		// var_dump($daily[]);exit;
		$areas = json_decode($daily[0]['areainfo'],true);
		$this->layout = '/layouts/modal_base';
		$this->render('area',['list'=>$areas,'date'=>$daily[0]['date'],'page'=>$lists->pagination]);
	}
}