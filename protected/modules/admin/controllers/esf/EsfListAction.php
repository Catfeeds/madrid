<?php
/**
 * 二手房列表页
 * @author  steven.allen
 * @date 2016.08.19
  */
class EsfListAction extends CAction
{
    public function run($type='title',$value='',$time_type = 'created',$time='',$checkStatus='',$saleStatus='',$source='',$cate='',$hid=0,$expire='')
    {
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc ,created desc',
        ));
        if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type=='username') {
               $criteria->addSearchCondition('username',$value);
            } elseif ($type=='xq') {
                $criteria->addSearchCondition('plot_name',$value);
            } elseif ($type=='uid') {
                $criteria->addCondition('uid=:uid');
                $criteria->params[':uid'] = $value;
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
        if($source != '')
        {
            $criteria->addCondition('source=:source');
            $criteria->params[':source'] = $source;
        }
        if($expire == 1)
        {
            $criteria->addCondition('expire_time>='.time());
        }
        elseif($expire == 2)
        {
            $criteria->addCondition('expire_time<'.time());
        }
        if($cate != '')
        {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $cate;
        }
        if($hid != 0)
        {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }

        // $criteria->order = 'id desc';
        $dataProvider = ResoldEsfExt::model()->undeleted()->getList($criteria,10);
        // var_dump($dataProvider->data);exit;
        $adminLastUrl = Yii::app()->request->getUrl();   
        $_SESSION ['adminLastUrl'] = $adminLastUrl;  

        $this->controller->render('esfList', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' =>$time_type,
            'checkStatus'=>$checkStatus,
            'saleStatus'=>$saleStatus,
            'source'=>$source,
            'cate'=>$cate,
            'hid'=>$hid,
            'expire'=>$expire,
        ));
    }
}
