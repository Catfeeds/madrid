<?php
/**
 * 楼盘红包列表页
 * @author steven.allen
 * @version 2016-05-04
 */
class ListAction extends CAction
{
    public function run($hid)
    {
        $this->controller->layout = '/layouts/modal_base';
        $criteria = new CDbCriteria(array(
            'condition' => 'hid=:hid',
            'params' => array(':hid'=>$hid),
            'order' => 'created desc'
        ));
        $dataProvider = PlotRedExt::model()->getList($criteria);
        $this->controller->render('red/list', array(
            'hid' => $hid,
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }
}
