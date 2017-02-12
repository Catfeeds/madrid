<?php
/**
 * 楼栋信息页
 * @author steven_allen
 * @version 2016-05-31
 */
class BuildingAction extends CAction
{
	public $plot;

    public function run($pid=0)
    {
    	$this->plot = $this->controller->plot;
        $periods = PlotPeriodExt::model()->with('plot')->findAll(array('condition'=>'hid=:hid','params'=>array(':hid'=>$this->plot->id),'order'=>'t.period asc'));
        // var_dump($periods);exit;
        $this->controller->render('building', array('periods'=>$periods,'pid'=>$pid));
    }
}
