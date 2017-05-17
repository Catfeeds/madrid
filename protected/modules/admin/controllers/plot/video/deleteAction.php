<?php
/**
 * 楼盘视频删除
 */
class DeleteAction extends CAction
{
    public function run()
    {
        if(Yii::app()->request->getIsAjaxRequest()){
            $id = Yii::app()->request->getPost('id', 0);
            $model = PlotVideoExt::model()->findByPk($id);
            if($model->img_id){
                $image = PlotImgExt::model()->findByPk($model->img_id);
            }
            $transaction=Yii::app()->db->beginTransaction();
            try{
                if(isset($image)){
                    if(!$image->delete())
                        throw new Exception('关联图片删除失败');
                }
                if($model->delete()){
                    $transaction->commit();
                    $this->controller->setMessage('删除成功', 'success');
                }

            }catch (Exception $e){
                $transaction->rollback();
            }
        }
        $this->controller->setMessage('删除失败', 'error');
    }
}