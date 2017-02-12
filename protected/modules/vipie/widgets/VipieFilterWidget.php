<?php 
/**
 * ie版中介后台列表筛选
 * @author steven.allen <[<email address>]>
 * @date(2017.1.17)
 */
class VipieFilterWidget extends CWidget{
	/**
	 * [$num description]
	 * @var integer
	 */
	public $num = 0;

	public $initPlots = [0=>'--选择小区--'];

	public $fields = [
		'type'=>'',
		'value'=>'',
		'time_type'=>'',
		'start_time'=>'',
		'end_time'=>'',
		'hid'=>'',
		'category'=>'',
		'sort'=>'',
		'action'=>'',
	];

	public function run()
	{
		$this->render('filter',['num'=>$this->num,'plots'=>$this->initPlots,'fields'=>$this->fields]);
        // echo $html;
	}
}