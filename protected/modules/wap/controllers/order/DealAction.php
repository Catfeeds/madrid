<?php
/**
 * 处理订单逻辑
 * @author weibaqiu
 * @version 2016-06-07
 */
class DealAction extends CAction
{
    public function run()
    {
        $model = new OrderExt;
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('OrderExt', array());
            if($model->repeatSubmit())
                $this->controller->setMessage('您今天已提交过，换个地方看看吧^_^', 'error',Yii::app()->request->getUrlReferrer());
            elseif($model->save()){
                $this->controller->setMessage('提交成功！', 'success');
            }else
                $this->controller->setMessage($model->hasErrors()?current(current($model->getErrors())):'提交失败！', 'error');
        }
        $returnUrl = Yii::app()->request->getParam('url', $this->controller->createUrl('/wap/index/index'));

        $this->controller->render('deal', [
            'returnUrl' => $returnUrl
        ]);
    }
}
