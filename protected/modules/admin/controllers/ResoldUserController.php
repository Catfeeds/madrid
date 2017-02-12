<?php
class ResoldUserController extends AdminController
{
	public function actionList($type='title',$value='',$time_type='created',$time='')
	{
		$criteria = new CDbCriteria(array(
            'order' => 'sort desc ,created desc',
        ));
        if($value = trim($value))
            if ($type=='id') {
                $criteria->addCondition('id=:id');
                $criteria->params[':id'] = $value;
            }  elseif ($type=='account') {
                $criteria->addCondition('account=:account');
                $criteria->params[':account'] = $value;
            }  elseif ($type=='phone') {
                $criteria->addCondition('phone=:phone');
                $criteria->params[':phone'] = $value;
            } elseif ($type=='name') {
                $criteria->addCondition('name=:name');
                $criteria->params[':name'] = $value;
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
        //销售状态、审核状态、来源筛选
        $criteria->order = 'created desc';
        $dataProvider = ResoldUserExt::model()->getList($criteria);
        // var_dump($dataProvider->data);exit;
        $this->render('list', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
        ));
	}
	
}