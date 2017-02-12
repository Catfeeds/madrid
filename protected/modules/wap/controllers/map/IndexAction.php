<?php
/**
 * 地图找房页
 * @author steven_allen
 * @version 2016-05-31
 */
class IndexAction extends CAction
{
    public function run()
    {
    	$kw = Yii::app()->request->getQuery('kw','');
        $this->controller->render('index',array('kw'=>$kw));
    }
}
