<?php

/**
 * User: fanqi
 * Date: 2016/9/13
 * Time: 13:56
 */
class AjaxStatusBuyAction extends CAction
{
    public function run()
    {
        $model = $this->controller->getResoldBuy();
        $ids = Yii::app()->request->getParam('ids', false);
        $kw = Yii::app()->request->getParam('kw', false);
        if (strpos($ids, ',')) {
            $ids = explode(',', $ids);
        }else{
            $ids = [$ids];
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $data = $model->findAll($criteria);
            foreach ($data as $v) {
                switch ($kw) {
                    case 'open':
                        if($this->controller->getPersonalSalingNum($v->uid) <= 0)
                            $this->controller->setMessage('个人发布配额已满', 'error');
                        else
                            $v->status = 1;
                        break;
                    case 'check':
                        $v->status = 2;
                        break;
                    case 'close':
                        $v->status = 3;
                        break;
                    default:
                        $v->status = 0;
                        break;
                }
                $v->save();
                if ($v->hasErrors()) {
                    throw new Exception(current(current($v->getErrors())));
                }
            }
            $transaction->commit();
            $this->controller->setMessage('操作成功', 'success');
            Yii::app()->end();
        } catch (Exception $e) {
            ;
            $transaction->rollback();
            $this->controller->setMessage($e->getMessage(), 'error');
        }

    }
}