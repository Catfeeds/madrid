<?php
/**
 * 楼盘楼栋编辑页
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
            $model = PlotBuildingExt::model()->findByPk($id,'hid=:hid',[':hid'=>$hid]);
            if(!$model){
                $this->setMessage('楼栋不存在', 'error', true);
            }
        } else {
            $model = new PlotBuildingExt;
        }
        $model->hid = $hid;

        if(Yii::app()->request->getIsPostRequest()){
            $model->attributes = Yii::app()->request->getPost('PlotBuildingExt', array());

            //涉及多表关联保存，启用事务
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model->save();
                
                //保存关联楼盘开盘时间/交付时间
                if(Yii::app()->request->getPost('setBOpen', ''))
                {
                    $plot = $model->plot;
                    if($plot && $model->open_time)
                    {
                        $plot->open_time = $model->open_time;
                        $plot->save();
                    }
                }
                if(Yii::app()->request->getPost('setBDelivery', ''))
                {
                    $plot = $model->plot;
                    if($plot && $model->delivery_time)
                    {
                        $plot->delivery_time = $model->delivery_time;
                        $plot->save();
                    }
                }
                if($model->hasErrors()){
                    throw new Exception(current(current($model->getErrors())));
                }
                $transaction->commit();
                $this->controller->setMessage('保存成功！', 'success', array('buildingList','hid'=>$hid));
            } catch (Exception $e) {
                $transaction->rollback();
                $this->controller->setMessage($e->getMessage(), 'error');
            }
        }

        //该楼盘所有启用的户型
        // $houseTypes = PlotHouseTypeExt::model()->enabled()->findAllByHid($hid);
        // $houseTypes = $houseTypes ? CHtml::listData($houseTypes, 'id', 'title') : array();
        //刚哥协定2016.07.07，调用已经关联的并且启用的户型显示
        $houseTypes = PlotHouseTypeExt::model()->enabled()->findAll([
            'with' => [
                'houseTypeBuildings' => [
                    'condition' => 'houseTypeBuildings.bid=:bid',
                    'params' => [':bid'=>$id]
                ]
            ]
        ]);
        //该楼盘所有期数
        $periods = CHtml::listData(PlotPeriodExt::model()->enabled()->findAllByHid($hid),'id', 'period');

        $this->controller->render('building/edit', array(
            'model' => $model,
            'hid' => $hid,
            'houseTypes' => $houseTypes,
            'periods' => $periods,
        ));
    }
}
