<?php
/**
 * 特惠团列表页
 * @author weibaqiu
 * @version 2016-06-07
 */
class IndexAction extends CAction
{
    public function run()
    {
    	Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'order' => 'sort DESC,created DESC',
        ));
        $dataProvider = PlotTuanExt::model()->normal()->noExpire()->getList($criteria,10);
        $tuan = $dataProvider->data;
        $pager = $dataProvider->pagination;

        $this->controller->render('index',array(
            'tuan'=>$tuan,
            'pager'=>$pager,
            ));
    }
}
