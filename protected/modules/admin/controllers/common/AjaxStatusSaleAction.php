<?php

/**
 * User: fanqi
 * Date: 2016/9/13
 * Time: 13:56
 */
class AjaxStatusSaleAction extends CAction
{
    public function run()
    {
        $model = $this->controller->getResoldSale();
        $ids = Yii::app()->request->getParam('ids', false);
        $kw = Yii::app()->request->getParam('kw', false);
        $sourceArr = Yii::app()->params['source'];//房源来源

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
                        $v->status = 1;
                        if($sourceArr[$v->source] == '个人' && $this->controller->getPersonalSalingNum($v->uid) <= 0)
                        {
                            $this->controller->setMessage('个人发布配额已满', 'error');
                            // exit;
                        }elseif($sourceArr[$v->source] == '个人') {
                            $v->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
                        }
                        break;
                    case 'check':
                        $v->status = 2;
                        break;
                    case 'close':
                        $v->status = 3;
                        break;
                    case 'shangjia':
                        if($v->status != 1)
                        {
                            $this->controller->setMessage('房源在审核中,请在审核通过后上架！', 'error');
                            // exit;
                        }
                        if($sourceArr[$v->source] == '个人' && $this->controller->getPersonalSalingNum($v->uid) <= 0)
                        {
                            $this->controller->setMessage('个人发布配额已满', 'error');
                            // exit;
                        }
                        $v->sale_status = 1;
                        if(!$v->sale_time && $sourceArr[$v->source] == '个人')
                            $v->sale_time = time();
                        if(!$v->refresh_time && $sourceArr[$v->source] == '个人')
                            $v->refresh_time = time();
                        // $v->sale_time = $v->refresh_time = time();
                        // $v->expire_time = time() + 30*86400;
                        break;
                    case 'xiajia':
                        $v->sale_status = 2;
                        break;
                    case 'huishou':
                        $v->sale_status = 3;
                        break;
                    default:
                        $v->status = 0;
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
