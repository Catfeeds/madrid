<?php
/**
 * 买房顾问点评列表页
 * @author weibaqiu
 * @version 2016-06-02
 */
class CommentListAction extends CAction
{
    public function run($sid=0)
    {
        $staffsData = StaffExt::model()->noDeleted()->findAll();
        $staffs = array();
        foreach($staffsData as $v){
            $staffs[$v->id] = $v->username.'('.$v->name.')';
        }
        $criteria = new CDbCriteria(array(
            'order' => 'id desc',
        ));
        if($sid>0) {
            $criteria->addCondition('sid=:sid');
            $criteria->params[':sid'] = $sid;
        }
        $dataProvider = StaffCommentExt::model()->getList($criteria, 15);
        $list = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $this->controller->render('comment_list', array(
            'list' => $list,
            'pager' => $pager,
            'staffs' => $staffs,
            'sid' => $sid,
        ));
    }
}
