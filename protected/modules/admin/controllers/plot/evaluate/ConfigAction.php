<?php
class ConfigAction extends CAction
{
    public function run($type)
    {
        $model = SM::{$type}();

        if(Yii::app()->request->getIsPostRequest() && $postData = Yii::app()->requet->getPost(get_class($model), null)) {
            $model->attributes = $postData;
            if($model->save()) {
                $this->controller->setMessage('success', '保存成功');
            } else {
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败！';
                $this->controller->setMessage('error', $msg);
            }
        }

        $this->render('evaluate/config', ['model'=>$model]);
    }
}
