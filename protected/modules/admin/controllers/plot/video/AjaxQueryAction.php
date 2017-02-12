<?php
use Qiniu\Processing\PersistentFop;

/**
 * 查询七牛持久化处理的状态并更新数据库
 */
class AjaxQueryAction extends CAction
{
    public function run()
    {
        if(Yii::app()->request->getIsAjaxRequest()){
            $id = Yii::app()->request->getPost('id', 0);
            $model = PlotVideoExt::model()->findByPk($id);
            if($model->transcoded==0){
                //已是更新成功状态则跳过
                $this->controller->setMessage('更新成功', 'success');
            }
            $status=PersistentFop::status($model->persistent_id);
            if($model->qiniuPro(current($status))){
                if($model->transcoded==0){
                    $model->setStatusOpen();
                }
                $this->controller->setMessage('更新成功', 'success');
                Yii::app()->end();
            }
        }
        $this->controller->setMessage('更新失败', 'error');
    }
}