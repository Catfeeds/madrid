<?php

/**
 * User: fanqi
 * Date: 2016/9/6
 * Time: 15:27
 * 刷新、预约刷新弹窗
 */
class VipModalWidget extends CWidget
{
    private $staff;
    public function setStaff($staff)
    {
        $this->staff = $staff;
    }
    public function run()
    {
        $this->render('modal',['staff'=>$this->staff]);
    }
}