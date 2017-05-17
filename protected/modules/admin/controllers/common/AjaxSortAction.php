<?php

/**
 * User: fanqi
 * Date: 2016/9/13
 * Time: 15:32
 */
class AjaxSortAction extends CAction
{
    public function run()
    {
        $this->controller->ajaxSort($this->controller->getResoldSale());
    }
}