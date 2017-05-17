<?php

/**
 * User: fanqi
 * Date: 2016/8/9
 * Time: 16:11
 */
class ZfListAction extends CAction
{
    public function run($type='title',$value='',$time_type = 'created',$time='',$checkStatus='',$saleStatus='',$source='',$category='',$hid=0,$expire='')
    {
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc ,created desc',
        ));
        if ($type=='title') {
            $criteria->addSearchCondition('title', $value);
        } elseif ($type=='username') {
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
        //添加时间、刷新时间筛选
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
        if($checkStatus != '')
        {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $checkStatus;
        }
        if($saleStatus != '')
        {
            $criteria->addCondition('sale_status=:sale_status');
            $criteria->params[':sale_status'] = $saleStatus;
        }
        if($source)
        {
            $criteria->addCondition('source=:source');
            $criteria->params[':source'] = $source;
        }
        //房源类型筛选
        if($category)
        {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $category;
        }
        if($expire == 1)
        {
            $criteria->addCondition('expire_time>='.time());
        }
        elseif($expire == 2)
        {
            $criteria->addCondition('expire_time<'.time());
        }

        if($hid)
        {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        $dataProvider = ResoldZfExt::model()->undeleted()->getList($criteria);
        $adminLastUrl = Yii::app()->request->getUrl();   
        $_SESSION ['adminLastUrl'] = $adminLastUrl;  
        
        return $this->controller->render('zflist',[
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type'=>$time_type,
            'checkStatus'=>$checkStatus,
            'saleStatus'=>$saleStatus,
            'source'=>$source,
            'category'=>$category,
            'hid'=>$hid,
            'expire'=>$expire,
        ]);
    }
}