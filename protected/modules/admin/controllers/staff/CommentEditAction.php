<?php
/**
 * 买房顾问点评编辑页
 * @author weibaqiu
 * @version 2016-06-02
 */
class CommentEditAction extends CAction
{
    public function run($id=0)
    {
        $model = StaffCommentExt::model()->findByPk($id);
        if(!$model){
            $model = new StaffCommentExt;
            $model->enable();
        }
        if(Yii::app()->request->isPostRequest){
            $model->attributes = Yii::app()->request->getPost('StaffCommentExt', array());
            if($model->save()) {
                $this->controller->setMessage('保存成功！', 'success', array('commentList'));
            } else {
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败!';
                $this->controller->setMessage($msg, 'error');
            }
        }
        $staffData = StaffExt::model()->noDeleted()->findAll();
        $staffs = array();
        if($staffData){
            foreach($staffData as $v){
                $staffs[$v->id] = $v->username.'('.$v->name.')';
            }
        } else {
            $model->addError('sid',  CHtml::link('请先添加买房顾问账号',['/admin/staff/edit'],['target'=>'_blank']));
        }

        $this->controller->render('comment_edit', array(
            'model' => $model,
            'staffs' => $staffs,
        ));
    }
}
