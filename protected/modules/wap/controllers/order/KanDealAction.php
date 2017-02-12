<?php
/**
 * 预约看房表单提交处理
 * @author weibaqiu
 * @version 2016-06-13
 */
class KanDealAction extends CAction
{
    public function run()
    {
        if(Yii::app()->request->getIsPostRequest()) {
            $note = array();
            if($loupan = Yii::app()->request->getPost('loupan', ''))
                $note[] = '意向楼盘：'.$loupan;
            if($jiage = Yii::app()->request->getPost('jiage', 0))
                $note[] = '价格：'.intval($jiage).'万';
            if($huxing = Yii::app()->request->getPost('huxing', array()))
            {
                $note[] = '户型：'.implode('、', $huxing);
            }
            if($beizhu = Yii::app()->request->getPost('note',''))
            {
                $note[] = $beizhu;
            }

            $model = new OrderExt;
            $model->attributes = $_POST;
            $model->note = implode('；', $note);

            if($model->repeatSubmit())
                $this->controller->response(1,'您今天已提交过，换个地方看看吧^_^');
            elseif($model->save()){
                $this->controller->response(1,'提交成功！');
            }else
                $this->controller->response(1,$model->hasErrors()?current(current($model->getErrors())):'提交失败！');
        }
    }
}
