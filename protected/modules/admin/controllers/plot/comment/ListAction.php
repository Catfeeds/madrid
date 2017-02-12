<?php
/**
 * 楼盘点评列表页
 * @author weibaqiu
 * @version 2016-04-28
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
        $dataProvider = PlotCommentExt::model()->getList($criteria);
        $this->controller->render('comment/list', array(
            'hid' => $hid,
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }
}
