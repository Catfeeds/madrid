<?php
/**
 * 楼盘基本详情页
 * @author weibaqiu
 * @version 2016-05-30
 */
class DetailAction extends CAction
{
    public $plot;

    public function run()
    {
        $this->plot = $this->controller->plot;
        $this->controller->render('detail');
    }
}
