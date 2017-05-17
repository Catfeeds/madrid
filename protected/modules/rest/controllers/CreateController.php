<?php
/**
 * @author: weibaqiu
 * @date:   2015-08-28
 */
class CreateController extends RestController
{
    /**
     * 验证模型
     * @param CActiveRecord $model 要验证的模型
     * @return mixed 验证模型并输出错误，如果模型属性通过验证，则返回
     */
    public function validate(CActiveRecord $model)
    {
        if($model->validate())
            return;
        throw new Exception(current(current($model->getErrors())));
    }

    /**
     * 提交订单
     */
    public function actionOrder()
    {
        //需要返回的字段
        $attributes = array('name','phone','note');
        $order = new OrderExt();
        if(Yii::app()->request->isPostRequest)
        {
            $data = $_POST;
            if(!empty($data))
            {
                $data['spm_a'] = '接口提交';
                if(isset($data['type'])){
                    $data['spm_b'] = $data['type'];
                }else{
                    throw new Exception('type不能为空');
                }
                $order->attributes = $data;
                $this->validate($order);
                if($order->repeatSubmit()){
                    throw new Exception('您今天已提交过，换个地方看看吧^_^');
                }
                if($order->save())
                {
                    $attributes = $this->_filterAttribute($order, $attributes);
                    $attributes['type'] = $order->spm_b;
                    $this->renderResult($attributes);
                }
            }
        }
    }

    /**
     * 渲染json
     * @param  array $data 提示数据
     */
    public function renderResult($data)
    {
        echo CJSON::encode($data);
        Yii::app()->end();
    }
}
