<?php
/**
 * 楼盘期数列表页
 * @author weibaqiu
 * @version 2016-05-05
 */
class ListAction extends CAction
{
    public $plot;

    public function run($hid)
    {
        $this->plot = PlotExt::model()->findByPk($hid);
        $this->controller->layout = '/layouts/modal_base';
        $criteria = new CDbCriteria(array(
            'condition' => 't.hid=:hid',
            'params' => array(':hid'=>$hid),
            'order' => 'created desc'
        ));
        $dataProvider = PlotPeriodExt::model()->getList($criteria);
        $this->controller->render('period/list', array(
            'hid' => $hid,
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }
}
