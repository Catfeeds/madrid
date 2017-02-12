<?php
/**
 * 预约看房页面
 * @author steven_allen
 * @version 2016-05-27
 */
class RecordAction extends CAction
{
    public function run()
    {
    	$sid = Yii::app()->request->getQuery('sid');
    	$record = StaffCheckExt::model()->findAll(array('condition'=>'sid=:sid','params'=>array(':sid'=>$sid),'order'=>'t.created desc','with'=>array('plot','user')));
        $this->controller->render('record', array(
            'record' => $record
        ));
    }
}
