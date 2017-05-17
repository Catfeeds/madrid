<?php
/**
 * 地图找房页
 * @author steven_allen
 * @version 2016-05-31
 */
class AroundAction extends CAction
{
    public function run($index=0)
    {
        $this->controller->render('around',array('hid'=>$this->controller->plot->id,'index'=>$index));
    }
}
