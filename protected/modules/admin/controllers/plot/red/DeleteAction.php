<?php
/**
 * 楼盘红包删除
 * @author  steven.allen
 * @version 2016-05-04
 */
class DeleteAction extends CAction
{
    public function run()
    {
        if(Yii::app()->request->getIsAjaxRequest()){
            $id = Yii::app()->request->getPost('id', 0);
            $model = PlotRedExt::model()->findByPk($id);
            if($model->delete()){
                $this->controller->setMessage('删除成功', 'success');
                Yii::app()->end();
            }
        }
        $this->controller->setMessage('删除失败', 'error');
    }
}
