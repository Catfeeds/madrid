<?php
/**
 * Project: sample
 * User: chenzhidong
 * Date: 14-6-11
 * Time: 20:20
 */
class HangjiaController extends Controller{
	public $layout = 'urm.views.layouts.main';

	public function init()
	{
		parent::init();
		$sign = Yii::app()->request->getQuery('sign', '');
		if($sign!=md5('hangjia')) {
			throw new Exception("Error Processing Request", 1);
		}
	}

}
