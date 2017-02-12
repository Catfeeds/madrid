<?php
/**
 * 二手房右侧挂件
 * @author steven allen <[<email address>]>
 * @date(2016.11.8)
 */
class RightWidget extends CWidget
{
	/**
	 * [$type 分类 见@link::$typeArr]
	 * @var string
	 */
	public $type = 'news';
	/**
	 * [$typeArr 分类数组]
	 * 目前支持二手房列表和邻校列表右侧挂件0
	 * @var [type]
	 */
	public $typeArr = ['news'=>1,'pricetrend'=>2,'hotplot'=>3,'school'=>4,'plotesf'=>5,'plotzf'=>6];
	/**
	 * [$limit 个数]
	 * @var integer
	 */
	public $limit = 5;
	/**
	 * [$relatedid 关联id e.g. 邻校房传学校id]
	 * @var integer
	 */
	public $relatedid = 0;

	/**
	 * [$infoType 1为二手房 2为租房 hotplot排序用]
	 * @var integer
	 */
	public $infoType = 1;

	public function run()
	{
		switch ($this->typeArr[$this->type]) {
			case '1':
				$infos = ResoldRecomCateExt::getAllRecomByCate('pcsyzx',$this->limit);
				$html = '<ul class="esf-news-list">';
				if(isset($infos['pcsyzx'])&&$infos['pcsyzx'])
					foreach ($infos['pcsyzx'] as $key => $value) {
						$html .= '<li><a href="'.$value->url.'">'.$value->title.'</a></li>';
					}
				$html .= '</ul>';
				break;
			case '2':
				$infos = ResoldPricetrendExt::model()->findAll(['order'=>'time desc','limit'=>$this->limit]);
				$html = '<ul class="esf-price-qushi">';
				if($infos)
					foreach ($infos as $key => $value) {
						$html .= '<li>'.$value->month.'月均价：'.$value->data[0].' 元/m²</li>';
					}
				$html .= '</ul><p class="from">数据来源：'.SM::globalConfig()->siteName().'二手房</p>';
				break;
			case '3':
				$num = ($this->infoType==1?'esf':'zf').'_num';
				$price = ($this->infoType==1?'esf':'zf').'_price';
				$unit = ($this->infoType==1?'元/平':'元/月');
				$url = ($this->infoType==1?'/resoldhome/plot/pesflist':'/resoldhome/plot/pzflist');
				$xs = Yii::app()->search->house_plot;
				$xs->setQuery('');
		        $xs->addRange('sale_status',2,2);
				$xs->addRange('status',1,1);
				$xs->addRange('deleted',0,0);
				$xs->setMultiSort([$num=>false,'recommend'=>false,'sort'=>false]);
				$xs->setLimit($this->limit,0);
				$html = '<ul class="hot-xiaoqu-list hot-plot-list clearfix">';
				if($docs = $xs->search())
					foreach ($docs as $key => $value) {
						$html .= '<li><a href="'.Yii::app()->controller->createUrl($url,['py'=>$value->pinyin]).'" target="_blank"><span class="name">'.$value->title.' </span><span class="price">'.Tools::FormatPrice(PlotResoldDailyExt::getLastInfoByHid($value->id)[$price],$unit).'</span></a></li>';
					}
				$html .= '</ul>';
				break;
			case '4':
				$infos = [];
				$school = schoolExt::model()->findByPk($this->relatedid);
				if($school->plot)
					foreach ($school->plot as $key => $value) {
						if($value->salingEsfs)
							foreach ($value->salingEsfs as $key => $v) {
								if(count($infos) < $this->limit)
									$infos[] = $v;
							}
					}
				if($infos)
				{
					$html = '<ul class="browse-list">';
					foreach ($infos as $key => $value) {
						$html .= '<li><a href="'.Yii::app()->controller->createUrl('/resoldhome/esf/info',['id'=>$value->id]).'" target="_blank"><span class="name">'.$value->title.' </span><span class="cate tac">'.$value->bedroom.'室'.$value->livingroom.'厅 </span><span class="price">'.Tools::FormatPrice($value->price,'万').'</span></a></li>';
					}
					$html .= '</ul>';
				}
				break;
			case '5':
				$html = '<ul class="browse-list">';
                $infos = ResoldEsfExt::model()->saling()->findAll(['condition'=>'hid=:hid and category=1','params'=>[':hid'=>$this->relatedid],'order'=>'recommend desc,refresh_time desc,created desc','limit'=>$this->limit]);
                if($infos)
                	foreach ($infos as $key => $value) {
                		$html .= '<li><a href="'.Yii::app()->controller->createUrl('/resoldhome/esf/info',['id'=>$value->id]).'" target="_blank"><span class="name">'.$value->title.' </span><span class="cate tac">'.$value->bedroom.'室'.$value->livingroom.'厅 </span><span class="price">'.Tools::FormatPrice($value->price,'万').'</span></a></li>';
                	}
                $html .= '</ul>';
				break;
			case '6':
				$html = '<ul class="browse-list">';
                $infos = ResoldZfExt::model()->saling()->findAll(['condition'=>'hid=:hid and category=1','params'=>[':hid'=>$this->relatedid],'order'=>'recommend desc,refresh_time desc,created desc','limit'=>$this->limit]);
                if($infos)
                	foreach ($infos as $key => $value) {
                		$html .= '<li><a href="'.Yii::app()->controller->createUrl('/resoldhome/zf/info',['id'=>$value->id]).'" target="_blank"><span class="name">'.$value->title.' </span><span class="cate tac">'.$value->bedroom.'室'.$value->livingroom.'厅 </span><span class="price">'.Tools::FormatPrice($value->price,'元/月').'</span></a></li>';
                	}
                $html .= '</ul>';
				break;
			default:
				# code...
				break;
		}
		echo $html;
	}

}
