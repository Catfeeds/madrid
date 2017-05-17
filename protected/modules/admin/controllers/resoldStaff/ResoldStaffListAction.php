<?php
/**
 * 商家职员列表
 * @author  steven.allen
 * @date 2016.08.24
  */
class ResoldStaffListAction extends CAction
{
    public function run($type='title',$value='',$time_type='created',$time='',$checkStatus='',$isPackage='',$sort=0)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created desc,t.updated desc',
        ));
        if($value = trim($value))
            if ($type=='name') {
                $criteria->addSearchCondition('t.name', $value);
            } elseif ($type=='uid') {
                $criteria->addCondition('t.uid=:uid');
                $criteria->params[':uid'] = $value;
            } elseif ($type=='phone') {
                $criteria->addCondition('t.phone=:phone');
                $criteria->params[':phone'] = $value;
            } elseif ($type=='account') {
                $criteria->addCondition('t.account=:account');
                $criteria->params[':account'] = $value;
            } elseif ($type=='sid') {
                $criteriaShop = new CDbCriteria;
                $criteriaShop->addSearchCondition('t.name',$value);
                $shop = ResoldShopExt::model()->undeleted()->findAll($criteriaShop);
                $sids = [];
                if($shop)
                    foreach ($shop as $key => $v) {
                        $sids[] = $v->id;
                    }
                $criteria->addInCondition('sid',$sids);
                // $criteria->params[':sid'] = $shop? $shop->id : '';
            } 
        //添加时间、刷新时间筛选
        if($time_type!='' && $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            if($time_type=='expire') {
                $criteria->with = 'staffPackage';
                $criteria->addCondition("staffPackage.expire_time>=:beginTime");
                $criteria->addCondition("staffPackage.expire_time<=:endTime");
            }else {
                $criteria->addCondition("t.{$time_type}>=:beginTime");
                $criteria->addCondition("t.{$time_type}<=:endTime");
            }
            
            $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
            $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

        }
        //销售状态、审核状态、来源筛选
        if($checkStatus||$checkStatus=='0')
        {
            $criteria->addCondition('t.status=:status');
            $criteria->params[':status'] = $checkStatus;
        }
        if($isPackage=='0') {
            $criteria->addCondition('t.hurry_num>0');
            $criteria->with = 'staffPackage';
            $criteria->addCondition("staffPackage.expire_time>=:time");
            $criteria->params[':time'] = time();
        } elseif($isPackage=='1') {
            $criteria->addCondition('t.hurry_num=0');
        }
        $sortArray = [
            '1' => '按添加时间排序',
            '2' => '按刷新时间排序',
        ];
        if($sort) {
            switch ($sort) {
                case '1':
                    $criteria->order = 't.created desc';
                    break;
                case '2':
                    $criteria->order = 't.updated desc';
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        $dataProvider = ResoldStaffExt::model()->undeleted()->getList($criteria);
        // var_dump($dataProvider->data);exit;
        $this->controller->render('staffList', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'isPackage' => $isPackage,
            'time' => $time,
            'time_type' => $time_type,
            'checkStatus'=>$checkStatus,
            'action'=>'resoldStaffList',
            'sort'=>$sort,
            'sortArray'=>$sortArray
        ));
    }
}
