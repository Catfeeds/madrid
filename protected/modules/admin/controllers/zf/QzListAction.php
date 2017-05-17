<?php

/**
 * User: fanqi
 * Date: 2016/8/9
 * Time: 16:11
 */
class QzListAction extends CAction
{
    public function run($type='title',$value='',$time_type = 'created',$time='',$category='',$status='')
    {
        $criteria = new CDbCriteria(array(
            'order' => 'created desc',
        ));
        if($value)
            if ($type=='title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type=='user') {
                $criteria->addSearchCondition('username',$value);
            } elseif ($type=='xq') {
                $plot = PlotExt::model()->find(['condition'=>'title=:title','params'=>[':title'=>$value]]);
                if($plot)
                    $criteria->addSearchCondition('hid',$plot->id);
            } elseif ($type=='phone') {
                $criteria->addCondition('phone=:phone');
                $criteria->params[':phone'] = $value;
            } elseif ($type=='uid') {
                $criteria->addCondition('uid=:uid');
                $criteria->params[':uid'] = $value;
            }
        if($time_type!='' && $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;

        }
        //销售状态、审核状态、来源筛选
        if($category)
        {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $category;
        }
        if($status||$status=='0')
        {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $status;
        }

        $dataProvider = ResoldQzExt::model()->undeleted()->getList($criteria);
        $adminLastUrl = Yii::app()->request->getUrl();   
        $_SESSION ['adminLastUrl'] = $adminLastUrl;  
        $this->controller->render('qzlist', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'status' => $status,
            'time' => $time,
            'time_type'=>$time_type,
            'category'=>$category
        ));
    }
}