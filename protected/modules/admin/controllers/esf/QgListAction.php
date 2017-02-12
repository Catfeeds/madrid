<?php

/**
 * 二手房求购列表页
 * @author  steven.allen
 * @date 2016.08.22
 */
class QgListAction extends CAction
{
    public function run($type = 'title', $value = '', $time = '', $category = '', $status = '')
    {
        $criteria = new CDbCriteria(array(
            'order' => 'created desc',
        ));
        if ($value = trim($value))
            if ($type == 'title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type == 'user') {
                $criteria->addSearchCondition('username', $value);
            } elseif ($type == 'xq') {
                $plot = PlotExt::model()->find(['condition' => 'title=:title', 'params' => [':title' => $value]]);
                if ($plot)
                    $criteria->addSearchCondition('hid', (string)$plot->id);
                else
                    $criteria->addSearchCondition('hid', $value);
            } elseif ($type == 'phone') {
                $criteria->addCondition('phone=:phone');
                $criteria->params[':phone'] = $value;
            } elseif ($type == 'uid') {
                $criteria->addCondition('uid=:uid');
                $criteria->params[':uid'] = $value;
            }
        //添加时间、刷新时间筛选
        if ($time != '') {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("created>=:beginTime");
            $criteria->addCondition("created<:endTime");
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;

        }
        //销售状态、审核状态、来源筛选
        if ($category) {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $category;
        }
        if($status||$status=='0') { 
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $status;
        }


        $dataProvider = ResoldQgExt::model()->undeleted()->getList($criteria);
        $adminLastUrl = Yii::app()->request->getUrl();   
        $_SESSION ['adminLastUrl'] = $adminLastUrl;  
        // var_dump($dataProvider->data);exit;
        $this->controller->render('qgList', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'status' => $status,
            'category' => $category,
        ));
    }
}
