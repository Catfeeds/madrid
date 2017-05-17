<?php
/**
 * 楼盘视频列表页
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
        $dataProvider = PlotVideoExt::model()->getList($criteria);
        $this->controller->render('video/list', array(
            'hid' => $hid,
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }
}