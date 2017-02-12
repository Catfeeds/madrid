<?php
/**
 * 楼盘评测页面
 * @author steven_allen
 * @version 2016-06-17
 */
class EvaluateAction extends CAction
{
    public function run()
    {
        $evaluate = $this->controller->plot->evaluate;
        $staff = $evaluate && $evaluate->staff ? $evaluate->staff : null;
        $this->controller->render('evaluate/index', array(
            'evaluate' => $evaluate,
            'staff' => $staff,
        ));
    }
}
