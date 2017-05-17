<?php
/**
 * URM表单要用的接口，详见urm项目中wiki文档
 */
class PlotController extends UrmController
{
    public function actionPlot($kw='',$limit=10)
    {
        $criteria = new CDbCriteria(array(
            'limit' => $limit,
            'order' => 'id asc',
        ));
        $criteria->addSearchCondition('title', $kw);
        $plots = PlotExt::model()->normal()->isNew()->findAll($criteria);
        $data = array();
        if($plots){
            $data = CHtml::listData($plots, 'id', 'title');
        }
        echo CJSON::encode($data);
    }
}
