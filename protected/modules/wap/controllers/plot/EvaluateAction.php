<?php
/**
 * 楼盘评测页面
 * @author weibaqiu
 * @version 2016-05-30
 */
class EvaluateAction extends CAction
{
    public function run()
    {
        //控制查看的评测纬度
        // if(!in_array($type, PlotEvaluateExt::$contentFields)) $type = 'huxing';

        $evaluate = $this->controller->plot->evaluate;
        $staff = $evaluate && $evaluate->staff ? $evaluate->staff : null;
        $this->controller->render('evaluate', array(
            'evaluate' => $evaluate,
            'staff' => $staff,
            // 'type' => $type,
        ));

    }
}
