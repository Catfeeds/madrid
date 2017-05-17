<?php
/**
 * 买房顾问相关
 * @author weibqiu
 * @date 2015-12-15
 */
class ShowController extends HomeController
{
	public function actionIndex($value='')
	{
		$this->layout = '/layouts/none';
		$this->render('index');
	}
}