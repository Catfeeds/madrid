<?php
/**
 * 产品控制器
 * @author steven.allen <[<email address>]>
 * @date(2017.2.12)
 */
class ProductController extends VipController{
	// 红酒类型
	public $cates = [];
	// 红酒系列
	public $xls = [];
	// 葡萄品种
	public $ptpzs = [];
	// 酒庄
	public $houses = [];

	public function init()
	{
		parent::init();
		foreach (['cates'=>'hjlx','xls'=>'hjxl','ptpzs'=>'ptpz','houses'=>'jzdq'] as $key => $value) {
			$this->$key = CHtml::listData(TagExt::model()->getTagByCate($value)->normal()->findAll(),'id','name');
		}
	}

}