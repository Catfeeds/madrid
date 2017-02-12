<?php
/**
 * 导航页面
 * @author weibaqiu
 * @version 2016-06-06
 */
class NavAction extends CAction
{
    public function run()
    {
        $this->controller->render('nav');
    }
}
