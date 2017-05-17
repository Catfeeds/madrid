<?php

/**
 * User: fanqi
 * Date: 2016/9/13
 * Time: 13:43
 */
class PhoneCheckAction extends CAction
{
    public function run()
    {
       $this->controller->phoneCheck($this->controller->getResoldSale(),'fid');
    }
}