<?php
/**
 * 邻校房详情右侧挂件
 * @author steven allen <[<email address>]>
 * @date(2016.11.8)
 */
class SchoolRightWidget extends CWidget
{
	/**
	 * [$type 1为二手房 2为租房]
	 * @var integer
	 */
	public $type = 1;
	/**
	 * [$relatedid 关联id e.g. 邻校房传学校id]
	 * @var integer
	 */
	public $relatedid = 0;
	/**
	 * [$limit 个数]
	 * @var integer
	 */
	public $limit = 4;
	/**
	 * 更多链接
	 * @var string
	 */
	public $moreUrl;
	/**
	 * 标题
	 * @var string
	 */
	public $title;

	public $xs;

	public function init(){
		if($this->type != 1 && $this->type !=2){
			Yii::app()->end();
		}
		if($this->type == 1){
			$this->title = '二手房';
			$this->xs = Yii::app()->search->house_esf;
			$this->moreUrl = Yii::app()->createUrl('/resoldhome/esf/list',array('school'=>$this->relatedid));
		}elseif ($this->type == 2){
			$this->title = '租房';
			$this->xs = Yii::app()->search->house_zf;
			$this->moreUrl = Yii::app()->createUrl('/resoldhome/zf/list',array('school'=>$this->relatedid));
		}
	}

	public function run()
	{
		$this->xs->setQuery('');
		$this->xs->addRange('deleted',0,0); //是否删除
		$this->xs->addQueryString('status:1',XS_CMD_QUERY_OP_AND); //是否审核通过
		$this->xs->addQueryString('sale_status:1',XS_CMD_QUERY_OP_AND);
		$this->xs->addQueryString('category:1',XS_CMD_QUERY_OP_AND); //住宅
		$this->xs->addQueryString('source:2',XS_CMD_QUERY_OP_AND);
		$this->xs->addQueryString('school:'.$this->relatedid, XS_CMD_QUERY_OP_AND); //学校
		$this->xs->setMultiSort(array('sale_time','refresh_time'));
		$this->xs->setLimit($this->limit);
		$data = $this->xs->search();
		$this->render('school_right',array('data'=>$data));
	}
}