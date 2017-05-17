<?php
/**
 * wap统一提交表单页面
 * @author weibaqiu
 * @version 2016-05-26
 */
class FormAction extends CAction
{
    public function run($spm, $title='', $plotName='')
    {
        $model = new OrderExt;
        $model->spm = $spm;
        if(!$model->validSpm()){
            echo "无效的请求，请点击链接进入，不要直接打开链接";
            Yii::app()->end();
        }
        if($plotName = $model->getFormTitle()) {
            if($plotName==$title) $title = '';
        }
        $this->controller->render('form', array(
            'model' => $model,
            'title' => $title,
            'plotName' => $plotName,
        ));
    }
}
