<?php
/**
 * 商家职员列表
 * @author  steven.allen
 * @date 2016.08.24
  */
class StaffListAction extends CAction
{
    public function run($type='title',$value='',$time_type='created',$time='',$checkStatus='')
    {
        $criteria = new CDbCriteria(array(
            'order' => 'updated desc,created desc',
        ));
        $criteria->addCondition('sid=:sid');
        $criteria->params[':sid'] = Yii::app()->user->sid;
        
        if($value = trim($value))
            if ($type=='name') {
                $criteria->addSearchCondition('name', $value);
            } elseif ($type=='phone') {
                $criteria->addCondition('phone=:phone');
                $criteria->params[':phone'] = $value;
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
        if($checkStatus!='')
        {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $checkStatus;
        }
        $dataProvider = ResoldStaffExt::model()->undeleted()->getList($criteria);
        // var_dump($dataProvider->data);exit;
        $this->controller->render('staffList', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
            'checkStatus'=>$checkStatus,
        ));
    }
}
