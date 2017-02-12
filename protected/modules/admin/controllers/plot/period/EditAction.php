<?php
/**
 * 楼盘期数编辑页
 * @author weibaqiu
 * @version 2016-04-28
 */
class EditAction extends CAction
{
    public function run($hid,$id=0)
    {
        $this->controller->layout = '/layouts/modal_base';
        $hid = (int)$hid;
        $id = (int)$id;

        if($id){
            $model = PlotPeriodExt::model()->findByPk($id,'hid=:hid',[':hid'=>$hid]);
            if(!$model){
                $this->setMessage('期数不存在', 'error', true);
            }
        } else {
            $model = new PlotPeriodExt;
        }
        $model->hid = $hid; 

        if(Yii::app()->request->getIsPostRequest()){
            
            $model->attributes = Yii::app()->request->getPost('PlotPeriodExt', array());
            //涉及多表关联保存，启用事务
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model->saveSand()->save();
                if($model->hasErrors()){
                    throw new Exception(current(current($model->getErrors())));
                }
                $transaction->commit();
                $this->controller->setMessage('保存成功！', 'success', array('periodList','hid'=>$hid));
                
            } catch (Exception $e) {
                $transaction->rollback();
                $this->controller->setMessage($e->getMessage(), 'error');
            }
        }

        $this->controller->render('period/edit', array(
            'model' => $model,
            'hid' => $hid,
        ));
    }
}
