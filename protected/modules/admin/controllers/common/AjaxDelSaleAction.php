<?php

/**
 * User: fanqi
 * Date: 2016/9/13
 * Time: 13:00
 */
class AjaxDelSaleAction extends CAction
{
    public function run()
    {
        $this->controller->ajaxDel($this->controller->getResoldSale());
    }
}