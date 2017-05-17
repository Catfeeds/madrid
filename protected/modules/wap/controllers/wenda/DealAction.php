<?php
/**
 * wap提问接口
 * @author weibaqiu
 * @version 2016-06-13
 */
class DealAction extends CAction
{
    public function run()
    {
        $hid = Yii::app()->request->getPost('hid',0);
        if($question = Yii::app()->request->getPost('question'))
        {
            $ask = new AskExt();
            $ask->question = $this->controller->cleanXss($question);
            $plot = PlotExt::model()->findByPk($hid);
            $ask->name = Yii::app()->request->getPost('name','');
            $ask->phone = Yii::app()->request->getPost('phone','');
            $ask->hid = $hid;
            if($ask->save())
            {
                $this->controller->setMessage('提交成功，待审核后显示', 'success');
            }
        }
        else
        {
            $this->controller->redirect($this->controller->createUrl('/wap/wenda/ask',['hid'=>$hid,'msg'=>1]));
        }
        $returnUrl = Yii::app()->request->getParam('url', $plot?'/wap/plot/index?py='.$plot->pinyin:'/wap/wenda/index');
        $this->controller->render('deal',['returnUrl'=>$returnUrl]);
    }
}
