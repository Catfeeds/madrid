<?php
class StaffRightWidget extends CWidget
{
	/**
	 * [$type 1为二手房 2为租房]
	 * @var integer
	 */
	public $type = 1;
	/**
	 * [$category 分类 见@link::$categoryArr]
	 * @var integer
	 */
	public $category = 1;
	/**
	 * [$categoryArr 分类数组]
	 * @var [type]
	 */
	public $categoryArr = [1=>'住宅',2=>'商铺',3=>'写字楼'];
	/**
	 * [$uid uid]
	 * @var [type]
	 */
	public $sid=0;
	/**
	 * [$uid uid]
	 * @var [type]
	 */
	public $uid=0;
	/**
	 * [$limit 个数]
	 * @var integer
	 */
	public $limit = 10;

	public $url;
	
	public function run()
	{
		$model = $this->type==1 ? ResoldEsfExt::model() : ResoldZfExt::model();
		$staff = ResoldStaffExt::findStaffByUid($this->uid);
		$url = $this->type==1?'/resoldhome/staff/esfList':($this->type==2?'/resoldhome/staff/zfList':$this->url);
		if(!$this->sid && !$this->uid)
			return '';
		$criteria = new CDbCriteria;
		$criteria->select = 'count(hid) as image_count,hid';
		if($this->sid)
		{
			
			$criteria->addCondition('sid=:sid');
			$criteria->params[':sid'] = $this->sid;
		}
		if($this->uid)
		{
			$criteria->addCondition('uid=:uid');
			$criteria->params[':uid'] = $this->uid;
		}else{ 
			$url = $this->type==1?'/resoldhome/plot/pesflist':'/resoldhome/plot/pzflist';
		}
		$criteria->addCondition('category=:category and expire_time>:time');
		$criteria->params[':category'] = $this->category;
		$criteria->params[':time'] = time();
		$criteria->group = 'hid';
		$criteria->order = 'image_count desc';
		$criteria->limit = $this->limit;
		$infos = $model->saling()->findAll($criteria);
		$html = '';
		$total_count = 0;
		if($infos) {
			foreach ($infos as $key => $value) {
				$total_count += $value->image_count;
				$plot = PlotExt::model()->findByPk($value->hid);
				if($plot)
					$html .= '<li><a href="'.Yii::app()->controller->createUrl($url,!$this->uid?['py'=>$plot->pinyin]:['hid'=>$plot->id,'staff'=>$staff?$staff->id:0]).'" target="_blank" class="text-overflow">'.$plot->title.'  ('.$value->image_count.')</a></li>';
			}
			$html = '<ul class="esf-plot"><li class="first">热门'.$this->categoryArr[$this->category].'</li>'.$html.'</ul>';
			echo $html;
		}
	}
}	