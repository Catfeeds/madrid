<?php 
/**
 * ie版中介后台面包屑
 * @author steven.allen <[<email address>]>
 * @date(2017.1.17)
 */
class VipieBreadCrumbsWidget extends CWidget{
	/**
	 * [$fields 传过来的字段数组]
	 * @var array
	 */
	public $fields = [];

	public function run()
	{
		$html = '<div class="m-crumb"><ul class="f-cb"><li><i>&gt;</i><a href="#">当前位置</a></li>';
		if($this->fields) {
			foreach ($this->fields as $key => $value) {
				$html .= '<li><i>&gt;</i><a href="'.((isset($value['url'])&&$value['url'])?$value['url']:'javascript::void(0);').'">'.$value['name'].'</a></li>';
			}
		}
        $html .= '</ul></div>';
        echo $html;
	}
}