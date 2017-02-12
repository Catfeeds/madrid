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
            $model = PlotHouseTypeExt::model()->findByPk($id,'hid=:hid',[':hid'=>$hid]);
            if(!$model){
                $this->setMessage('户型不存在', 'error', true);
            }
        } else {
            $model = new PlotHouseTypeExt;
        }
        $model->hid = $hid;

        if(Yii::app()->request->getIsPostRequest()){
            $model->attributes = Yii::app()->request->getPost('PlotHouseTypeExt', array());

            //涉及多表关联保存，启用事务
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model->save();
                if($model->hasErrors()){
                    throw new Exception(current(current($model->getErrors())));
                }
                $transaction->commit();
                $this->controller->setMessage('保存成功！', 'success', array('houseTypeList','hid'=>$hid));
            } catch (Exception $e) {
                $transaction->rollback();
                $this->controller->setMessage($e->getMessage(), 'error');
            }
        }

        //该楼盘所有已添加楼栋
        $buildings = CHtml::listData(PlotBuildingExt::model()->findAllByHid($hid),'id', 'name');

        $this->controller->render('houseType/edit', array(
            'model' => $model,
            'hid' => $hid,
            'buildings' => $buildings,
        ));
    }
}
