<?php
/**
 * ajax修改视频状态
 */
class AjaxStatusAction extends CAction
{
    public function run()
    {
        $id = Yii::app()->request->getPost('id',0);
        if($id){
            $plotVideo = PlotVideoExt::model()->findByPk($id);
            if($plotVideo->changeStatus())  {
                $this->controller->setMessage('操作成功！','success');
            }
        }
        $this->controller->setMessage('操作失败！','error');
    }
}