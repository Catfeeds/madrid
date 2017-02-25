<?php
/**
 * 中介二手房管理，包括发布、上下架二手房和交互的相应操作
 * @author steven.allen <[<email address>]>
 * @date 2016.09.02
 */
class UserController extends VipController
{
	public function actionList($type='name',$value='',$time_type='created',$time='',$buy='')
	{
		$criteria = new CDbCriteria;
		if($value = trim($value))
            if ($type=='name') {
                $criteria->addSearchCondition('name', $value);
            } elseif ($type=='phone') {
            	$criteria->addSearchCondition('phone', $value);
            }
        //添加时间、刷新时间筛选
        if($time_type!='' && $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
            $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

        }
		$criteria->order = 'updated desc';
		if(is_numeric($buy)) 
			if($buy>0) {
				$criteria->addCondition('pid>0');
			}else{
				$criteria->addCondition('pid=0');
			}
		$dts = GuestExt::model()->getList($criteria);
		$this->render('list',['infos'=>$dts->data,'pager'=>$dts->pagination,'buy'=>$buy,'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type]);
	}
}