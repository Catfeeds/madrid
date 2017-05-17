<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'评测-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>
<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">点评</span>
        </div>
    </div>
</div>
<?php $this->renderPartial('plot_naver')?>
<div class="blank15"></div>
<div class="wapper">
  	<div class="dianping-l">
  		<div class="big-title"><i class="iconfont fangdabai-ico">&#x8962;</i><?=$this->t('房大白'); ?>点评</div>
  		<ul class="dianping-ul">
  		<?php if(!$comments): echo '暂无';?>
  		<?php else:?>
  			<?php foreach ($comments as $key => $value) {?>
  			<li>
  				<div class="teacher-box">
		            <span class="pic"><img src="<?=ImageTools::fixImage($value->staff->avatar,100,100)?>"></span>
		            <div class="detail-r">
		                <p><span class="name"><?=$value->staff->name?></span><span class="items"><i class="iconfont v-ico">&#x5364;</i><?=$value->staff->job?></span></p>
		                <P class="info"><?=$value->content?></P>
						<div class=" mt10 fr">
		                    <?php if($value->staff->qq):?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$value->staff->qq?>&site=qq&menu=yes" class="items fl" target="_blank"><i class="iconfont qq-ico">&#x1568;</i>在线咨询</a><?php endif;?>
		                    <?php if($value->staff->wx_image):?><a href="javascript:void(0);" class="items weixinex fr"><i class="iconfont weixin-ico">&#x1444;</i>微信联系
		                        <div class="weixin-box">
		                            <div class="pr">
		                                <span class="top-arrow"><span></span></span>
		                                <div class="weixin-pop-box">
		                                    <p>微信联系，更便捷哦</p>
		                                    <img src="<?=ImageTools::fixImage($value->staff->wx_image,100,100)?>">

		                                </div>
		                            </div>
		                        </div>
		                    </a><?php endif;?>
		                </div>
	                </div>
	            </div>
  			</li>
  			<?php }?>
  		<?php endif;?>
  		</ul>
  	</div>
  	<div class="plot-detail-r">

        <div class="gray-bg p10">
            <div class="mod-tuangou ui-mouseenter">
            <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
            </div>
        </div>
    </div>
<?php $this->footer(); ?>
