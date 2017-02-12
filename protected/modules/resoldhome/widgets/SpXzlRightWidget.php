<?php
/**
 * 小区 商铺 写字楼 本楼盘/本街道二手房/商铺/写字楼 [本楼盘其他二手房]
 * @author steven allen <[<email address>]>
 * @date(2016.11.8)
 */
class SpXzlRightWidget extends CWidget
{
	/**
	 * [$type 1 本小区 2 本街道]
	 * @var integer
	 */
	public $type = 1;
	/**
	 * [$limit 个数]
	 * @var integer
	 */
	public $limit = 4;
	/**
	 * [$url url]
	 * @var string
	 */
	public $url = '';
	/**
	 * [$model 模型]
	 * @var [type]
	 */
	public $model;
	/**
	 * [$flag true ResoldZf false ResoldEsf]
	 * @return [type] [description]
	 */
	public $flag = true;
	public function run()
	{
		$class = get_class($this->model);

		$criteria = new CDbCriteria;
		$criteria->addCondition('category=:cate');

		$criteria->addCondition('id!=:id');

		if($this->type==1){
			$criteria->addCondition('hid=:hid');
			$criteria->params = [':cate'=>$this->model->category,':hid'=>$this->model->hid,':id'=>$this->model->id];
		}

		if($this->type==2){
			$criteria->addCondition('street=:street');
			$criteria->params = [':cate'=>$this->model->category,':street'=>$this->model->street,':id'=>$this->model->id];
		}

		$criteria->order = 'refresh_time desc,sort desc,sale_time desc';
		$criteria->limit = $this->limit;
		if(!$this->flag){
			$class=$class=="ResoldEsfExt"?"ResoldZfExt":"ResoldEsfExt";
		}
		$infos = $class::model()->saling()->findAll($criteria);
		$html = '<ul class="right-list">';
		if($infos && $this->flag){
			foreach ($infos as $key => $value) {
				$html .= '<li><a href="'.Yii::app()->createUrl($this->url,['id'=>$value->id]).'" target="_blank"><span class="name">'.$value->title.'</span><span class="cate tac">'.$value->size.'m²</span><span class="price">'.Tools::FormatPrice($value->price,(strstr($class, 'z')?'元/月':'万')).'</span></a></li>';
			}
		}
		if($infos && !$this->flag){
			foreach ($infos as $key => $value) {
				$html .= '<li><a href="'.Yii::app()->createUrl($this->url,['id'=>$value->id]).'" target="_blank"><span class="cate">'.$value->bedroom.'室'.$value->livingroom.'厅</span><span class="cate tac">'.$value->size.'m²</span><span class="zprice">'.Tools::FormatPrice($value->price,'元/月').'</span></a></li>';
			}
		}

		$html .= '</ul>';
		echo $html;
	}
}
