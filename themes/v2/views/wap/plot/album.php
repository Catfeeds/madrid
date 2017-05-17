<?php 
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'相册-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css'); ?>

<div class="photo-box" id="j-photo-box">
    <div class="top">
        <span class="count"><em class="mr10">1</em>/<em>（<?php echo count($list); ?>）</em></span>
    </div>
    <span class="iconfont close"><a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>">&#x2488;</a></span>
    <div class="big-img">
        <ul class="bd">
            <?php foreach($list as $v): ?>
            <li data-title="<?php echo $v->title; ?>">
                <?php if(!$video=$v->getPlotVideo()):?>
                <span style="background-image: url(<?php echo ImageTools::fixImage($v->url,640); ?>);"></span>
                <?php else:?>
                <a href="<?=$this->createUrl('/wap/plot/video',['id'=>$video->id,'py'=>$this->plot->pinyin])?>"><i class="icon-video"></i><span style="background-image: url(<?php echo ImageTools::fixImage($v->url,640); ?>);"></span></a>
                <?php endif;?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="bottom">
        <span class="name">loading...</span>
        <div class="photo-swiper-wrapper swiper-wrapper-nav">
            <ul class="swiper-wrapper">
                <?php foreach($cates as $cate): ?>
                <li class="swiper-slide"><a href="<?php echo $this->createUrl('/wap/plot/album',['py'=>$this->plot->pinyin,'type'=>$cate->id]); ?>" <?php if($type==$cate->id): ?>class="on"<?php endif; ?>><?php echo $cate->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>