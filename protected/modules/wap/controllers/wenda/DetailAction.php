<?php
/**
 * 问答详情页
 * @author steven_allen
 * @version 2016-06-07
 */
class DetailAction extends CAction
{
    public function run()
    {
    	$id = Yii::app()->request->getQuery('id',0);
        $ask = AskExt::model()->normal()->findByPk($id);
        $this->controller->render('detail',array('ask'=>$ask));
    }
}
