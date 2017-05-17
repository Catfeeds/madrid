<?php
/**
 * 楼盘评点评删除
 * @author weibaqiu
 * @version 2016-04-28
 */
class DeleteAction extends CAction
{
    public function run()
    {
        if(Yii::app()->request->getIsAjaxRequest()){
            $id = Yii::app()->request->getPost('id', 0);
            $model = PlotCommentExt::model()->findByPk($id);
            if($model->delete()){
                $this->controller->setMessage('删除成功', 'success');
                Yii::app()->end();
            }
        }
        $this->controller->setMessage('删除失败', 'error');
    }
}
