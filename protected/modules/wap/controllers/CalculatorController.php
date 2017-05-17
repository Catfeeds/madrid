<?php
/**
 * wap计算器
 */
class CalculatorController extends WapController
{
	/**
	 * [actionIndex 计算器]
	 */
    public function actionIndex()
    {
        $this->render('index',array());
    }
}
