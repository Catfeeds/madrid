<?php
/**
 * 楼盘楼栋列表页
 * @author weibaqiu
 * @version 2016-04-28
 */
class ListAction extends CAction
{
    public $plot;

    public function run($hid)
    {
        $this->plot = PlotExt::model()->findByPk($hid);
        $this->controller->layout = '/layouts/modal_base';
        $criteria = new CDbCriteria(array(
            'alias' => 't',
            'condition' => 't.hid=:hid',
            'params' => array(':hid'=>$hid),
            'with' => array(
                'houseTypes' => array(
                    'alias' => 'ht'
                )
            ),
            'order' => 'created desc'
        ));
        $dataProvider = PlotBuildingExt::model()->getList($criteria);
        $this->controller->render('building/list', array(
            'hid' => $hid,
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }
}
