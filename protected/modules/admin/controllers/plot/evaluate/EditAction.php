<?php
/**
 * 楼盘评测编辑页
 * @author weibaqiu
 * @version 2016-04-28
 */
class EditAction extends CAction
{
    public function run($hid)
    {
        $this->controller->layout = '/layouts/modal_base';
        $hid = (int)$hid;
        $model = PlotEvaluateExt::model()->findByHid($hid);
        if(!$model){
            $model = new PlotEvaluateExt;
        }
        $model->hid = $hid;
        if(Yii::app()->request->getIsPostRequest()){
            $model->attributes = Yii::app()->request->getPost('PlotEvaluateExt', array());
            if($model->save()){
                $this->controller->setMessage('保存成功！','success');
            } else {
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败';
                $this->controller->setMessage($msg, 'error');
            }
        }

        $staffs = array();
        foreach(StaffExt::model()->normal()->findAll() as $staff){
            $staffs[$staff->id] = $staff->username.'('.$staff->name.')';
        }

        $this->controller->render('evaluate/edit', array(
            'model' => $model,
            'staffs' => $staffs,
            'hid' => $hid,
        ));
    }
}
