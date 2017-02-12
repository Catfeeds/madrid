<?php
/**
 * ajax修改期数状态
 * @author weibaqiu
 * @version 2016-05-09
 */
class AjaxStatusAction extends CAction
{
    /**
     * ajax改变楼盘期数状态
     */
    public function run()
    {
        $id = Yii::app()->request->getPost('id',0);
        if($id){
            $ids = explode(',',$id);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            $plotPeriod = PlotPeriodExt::model()->findAll($criteria);
            try{
                foreach($plotPeriod as $v){
                    if(!$v->changeStatus()){
                        $msg = $v->hasErrors() ? current(current($v->getErrors())) : '操作失败';
                        throw new Exception($msg);
                    }
                }
                $transaction->commit();
                $this->controller->setMessage('操作成功！','success');
            }catch (Exception $e){
                $transaction->rollback();
            }
        }
        $this->controller->setMessage('操作失败！','error');
    }
}
