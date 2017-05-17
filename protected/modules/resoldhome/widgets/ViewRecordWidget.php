<?php
/**
 * 二手房PC最近浏览/感兴趣房源小物件
 * 感兴趣房源先从浏览记录走 再从最新房源走
 * 调用方式e.g.
 * $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>1,'type'=>1,'category'=>1])
 * @author steven allen <[<email address>]>
 * @date(2016.11.07)
 */
class ViewRecordWidget extends CWidget
{
	/**
	 * [$cssType 样式分类 4、5为感兴趣房源]
	 * @var integer
	 */
	public $cssType = 1;
	/**
	 * [$type 1二手房 2租房 3求购 4求租]
	 * @var integer
	 */
	public $type = 1;
	/**
	 * [$category 1住宅 2商铺 3写字楼]
	 * @var integer
	 */
	public $category = 1;
	/**
	 * [$url 跳转相对路径，e.g. /resoldhome/esf/info]
	 * @var string
	 */
	public $url = '';
	/**
	 * [$limit 个数]
	 * @var integer
	 */
	public $limit = 4;
	/**
	 * [$infoId 房源ID]
	 * @var integer
	 */
	public $infoId = 0;

	/**
	 * [$uid 用户id]
	 * @var integer
	 */
	public $uid = 0;

	public $categoryArr = [
        1=>'ResoldEsfExt',
        2=>'ResoldZfExt',
        3=>'ResoldQgExt',
        4=>'ResoldQzExt'
    ];
    public $urlArr = [
        1=>'/resoldhome/esf/info',
        2=>'/resoldhome/zf/info',
        3=>'/resoldhome/qg/detail',
        4=>'/resoldhome/qz/detail'
    ];


	public function run()
	{
		$resoldView = new ResoldViewRecordor;
		$infos = !$this->uid?$resoldView->getViewedInfos(0,$this->category,$this->limit):$resoldView->getViewedInfos(0,$this->category,$this->limit);
		$infos = array_filter($infos);
		$hids = [];
		$html = '';
		$disLimit = $this->limit;
		if($infos)
		{
			switch ($this->cssType) {
				// 二手房详情样式
				case '1':
					$html = '<ul class="right-list">';
					foreach ($infos as $key => $value) {
						$nowClass = get_class($value);
						$arr = array_flip($this->categoryArr);
						$arrKey = $arr[$nowClass];
						$nowUrl = $this->urlArr[$arrKey];
						$catetac = $value->category==1?$value->bedroom.'室'.$value->livingroom.'厅':($value->category==2?'商铺':'写字楼');
						$html .= '<li><a href="'.Yii::app()->controller->createUrl($nowUrl,['id'=>$value->id]).'" target="_blank"><span class="name">'.$value->title.' </span><span class="cate tac">'.$catetac.' </span><span class="price">'.Tools::FormatPrice($value->price,$arrKey%2?'万':'元/月').'</span></a></li>';
					}
					$html .= '</ul>';
					echo $html;
					break;
				// 用户中心样式
				case '2':
					$html = '<ul>';
					foreach ($infos as $key => $value) {
						$nowClass = get_class($value);
						$arr = array_flip($this->categoryArr);
						$arrKey = $arr[$nowClass];
						$nowUrl = $this->urlArr[$arrKey];
						$html .='<li>
                            <a href="'.Yii::app()->controller->createUrl($nowUrl,['id'=>$value->id]).'" target="_blank">
                                <div class="pic">
                                    <img src="'.ImageTools::fixImage($value->image,200,150).'" alt="">
                                </div>
                                <div class="info">
                                    <div class="h-title">'.($value->areaInfo?$value->areaInfo->name:'').'   '.$value->title.'</div>
                                    <div class="aside">
                                        <div class="area">'.$value->size.'m²</div>
                                        <div class="price">'.Tools::FormatPrice($value->price,$arrKey%2?'万':'元/月').'</div>
                                    </div>
                                </div>
                            </a>
                        </li>';
					}
					$html .= '</ul>';
					echo $html;
					break;
				// 二手房列表样式
				case '3':
					$html = '<ul class="browse-list">';
					foreach ($infos as $key => $value) {
						$nowClass = get_class($value);
						$arr = array_flip($this->categoryArr);
						$arrKey = $arr[$nowClass];
						$nowUrl = $this->urlArr[$arrKey];
						$catetac = $value->category==1?$value->bedroom.'室'.$value->livingroom.'厅':($value->category==2?'商铺':'写字楼');
						$html .= '<li><a href="'.Yii::app()->controller->createUrl($nowUrl,['id'=>$value->id]).'" target="_blank"><span class="name">'.$value->title.' </span><span class="cate tac">'.$catetac.' </span><span class="price">'.Tools::FormatPrice($value->price,$arrKey%2?'万':'元/月').'</span></a></li>';
					}
					$html .= '</ul>';
					echo $html;
					break;
				// 感兴趣房源 详细页采用以下规则
				// ①同小区下
				// ②同街道的
				// ③同区域的
				default:
					$html = '';
					$model = $this->categoryArr[$this->type];
					$nowInfo = $model::model()->findByPk($this->infoId);
					if($nowInfo) {
						// $table = $this->type==1 ? 'resold_esf' : 'resold_zf';
						// $sql = "select * from $table where sale_status=1 and image<>'' and deleted=0 and category=".$this->category." and hid=".$nowInfo->hid." and id<>".$this->infoId." union ";
						// $sql .= "select * from $table where sale_status=1 and image<>'' and deleted=0 and category=".$this->category." and street=".$nowInfo->street." and id<>".$this->infoId." union ";
						// $sql .= "select * from $table where sale_status=1 and image<>'' and deleted=0 and category=".$this->category." and area=".$nowInfo->area." and id<>".$this->infoId." limit ".$this->limit*3;
						$ids = array();
						$xs = $this->type==1?Yii::app()->search->house_esf:Yii::app()->search->house_zf;
						foreach(['hid','street','area'] as $v){
							$xs->setQuery('');
							$xs->setFacets(array('status'), true);//分面统计
							$xs->addRange('deleted',0,0);
							$xs->addQueryString('category:'.$this->category,XS_CMD_QUERY_OP_AND);
							$xs->addQueryString('status:1',XS_CMD_QUERY_OP_AND);
							$xs->addQueryString('sale_status:1',XS_CMD_QUERY_OP_AND);
							$xs->setSort('sale_time');
							$xs->addRange($v,$nowInfo->$v,$nowInfo->$v);
							$docs = $xs->search();
							if(array_sum($xs->getFacets('status'))) {
								foreach ($docs as $d) {
									if($d->id != $nowInfo->id)
										$ids[] = $d->id;
								}
							}
							if(count($ids) >= $this->limit )
								break;
						}
						$criteria = new CDbCriteria(array(
							'limit'=>$this->limit,
							'order'=>'sale_time desc'
						));
						$criteria->addInCondition('id',$ids);
						$criteria->select = 'id,bedroom,livingroom,image,area,title,size,price';
						$fangs = $model::model()->findAll($criteria);
						if($fangs) {
							$fangs = array_slice($fangs, 0, $this->limit);
							foreach ($fangs as $key => $value) {
								$arr = array_flip($this->categoryArr);
								$arrKey = $arr[$model];
								$nowUrl = $this->urlArr[$arrKey];
								$cate_type = $this->category==1?$value['bedroom'].'室'.$value['livingroom'].'厅':($this->category==2?'商铺':'写字楼');
								$html .= '<li>
							            	<a href="'.Yii::app()->controller->createUrl($nowUrl,['id'=>$value['id']]).'" target="_blank">
							                    <div class="pic">
							                        <img src="'.ImageTools::fixImage($value['image'],200,150).'" alt="">
							                    </div>
							                    <div class="info">
							                        <div class="h-title"><span>'.($value->area?$value->areaInfo->name:'').'</span><span>'.$value['title'].'</span></div>
							                        <div class="aside">
							                            <div class="cate">'.$cate_type.'</div>
							                            <div class="area">'.round($value['size']).'m²</div>
							                            <div class="price">'.Tools::FormatPrice($value['price'],$arrKey%2?'万':'元/月').'</div>
							                        </div>
							                    </div>
							                </a>
							            </li>';
								}
							}
						}
					echo '<ul>'.$html.'</ul>';
					break;
			}

		}
	}
}
