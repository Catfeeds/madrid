<?php

/**
 * User: fanqi
 * Date: 2016/8/30
 * Time: 10:24
 */
class ZfSaleDownAction extends CAction
{
    /**
     *
     */
    public function run($type='title',$value='',$time_type = 'created', $time = '',$hid=0,$sort='',$category=0)
    {
        $saleStatus_arr = array_flip(Yii::app()->params['saleStatus']);
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc ,updated desc,created desc',
        ));
        // 排序+筛选
        if($sort)
        {
            $st = strpos($sort,'up')?' asc':' desc';
            $fields = strpos($sort,'sale')?' sale_time':' refresh_time';
            $criteria->order = $fields.$st;
        }
        $criteria->addCondition('uid=:uid');
        $criteria->addCondition('sale_status=2');
        $criteria->params[':uid'] = isset(Yii::app()->user->uid)?Yii::app()->user->uid:0;
        //小区筛选
        if($hid)
        {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        if($category)
        {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $category;
        }
        //标题或内容筛选
        if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type=='content') {
                $criteria->addSearchCondition('content',$value);
            }
        //根据时间查询类型判断（$time[created,refresh_time,sale_time]）
        if ($time_type != '' && $time != '') {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;
        }
        $dataProvider = ResoldZfExt::model()->undeleted()->getList($criteria,20);
        $list = $dataProvider->data;
        $pager = $dataProvider->pagination;

        //筛选上架房源中出现过的房源
        $plots = [];
        if ($zfs = ResoldZfExt::model()->undeleted()->findAll(
            [
                'condition' => 'uid = :uid and sale_status=' . $saleStatus_arr["下架"],
                'params' => [
                    ':uid' => isset(Yii::app()->user->uid) ? Yii::app()->user->uid : 0
                ]
            ]
        )
        ) {
            foreach ($zfs as $zf) {
                $plots[$zf->hid] = $zf->plot_name;
            }
        }
        $plots = array_flip(array_flip($plots));
        $this->controller->render('saleDown', array(
            'list' => $list,
            'pager' => $pager,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
            'hid'=>$hid,
            'plots'=>$plots,
            'category'=>$category,
            'sort'=>$sort,
        ));
    }
}