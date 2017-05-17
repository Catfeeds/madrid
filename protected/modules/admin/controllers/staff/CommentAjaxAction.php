<?php
/**
 * 买房顾问点评ajax操作
 * @author weibaqiu
 * @version 2016-06-02
 */
class CommentAjaxAction extends CAction
{
    public function run()
    {
        if(Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $model = StaffCommentExt::model()->findByPk($id);
            if($model && $model->changeStatus()->save()) {
                $this->controller->setMessage('操作成功！', 'success');
            } else {
                $this->controller->setMessage('操作失败！', 'error');
            }
        }
    }
}
