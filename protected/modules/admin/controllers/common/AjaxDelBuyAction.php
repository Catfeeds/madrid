<?php

/**
 * User: fanqi
 * Date: 2016/9/13
 * Time: 11:52
 */
class AjaxDelBuyAction extends CAction
{
    public function run()
    {
        $this->controller->ajaxDel($this->controller->getResoldBuy());
    }
}