<?php
/**
 * 提问页
 * @author steven_allen
 * @version 2016-07-06
 */
class AskAction extends CAction
{
    public function run($hid=0,$msg=0)
    {
        $hid=$this->controller->cleanXss($hid);
        $this->controller->render('ask',['hid'=>$hid,'msg'=>$msg]);
    }
}
