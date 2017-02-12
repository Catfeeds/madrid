<?php
/**
 * 买房顾问信息详情页
 * @author weibaqiu
 * @version 2016-06-01
 */
class StaffAction extends CAction
{
    public function run($id)
    {
        $id = (int)$id;
        $staff = StaffExt::model()->findByPk($id);
        //楼盘点评
        $staff->plotComments = PlotCommentExt::model()->findAllBySid($staff->id,[
            'limit'=>3,
            'order' => 'id desc',
        ]);

        //带看记录
        $records = StaffCheckExt::model()->findAll(array(
            'condition' => 'sid=:sid',
            'params' => array(':sid'=>$id),
            'limit' => 5
        ));

        //买房顾问点评
        $commentNum = StaffCommentExt::model()->enabled()->countBySid($id);
        $comments = StaffCommentExt::model()->enabled()->findAll(array(
            'limit' => '5',
            'order' => 'id desc',
        ));

        $this->controller->render('staff', array(
            'staff' => $staff,
            'records' => $records,
            'commentNum' => $commentNum,
            'comments' => $comments,
            'staffCommentHyh' => count(PlotCommentExt::model()->findAllBySid($staff->id))>3?1:0,//换一换开关
            'recordsHyh' => count(StaffCheckExt::model()->findAll(array('condition' => 'sid=:sid','params' => array(':sid'=>$id))))>3?1:0,//换一换开关
        ));
    }
}
