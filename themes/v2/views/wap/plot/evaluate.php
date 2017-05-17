<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'楼盘评测-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'楼盘评测','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/common.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css'); ?>
<div class="p-fixed">
    <div class="huxing-banner">
        <div class=" top-mark"></div>
        <div class="title-bar">
            <?php $this->widget('BackButton',['backUrl'=>$this->createUrl('/wap/plot/index',['py'=>$this->plot->pinyin])]); ?>
            <h1><?php echo $this->plot->title; ?></h1>
            <?php $this->renderPartial('/layouts/operate',['search'=>false]); ?>
        </div>
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/images/huxing_banner.jpg" class="banner-img">
        <dl class="people gw">
            <dt><a href="<?=$evaluate&&$evaluate->staff?$this->createUrl('adviser/staff',['id'=>$evaluate->staff->id]):''?>"><img src="<?php echo $evaluate&&$evaluate->staff?ImageTools::fixImage($evaluate->staff->avatar):Yii::app()->theme->baseUrl.'/static/wap/images/erweima.jpg'; ?>"></a></dt>
            <dd><span class="mr10"><?php echo $evaluate?$evaluate->staff->name:'未添加'; ?></span><?php echo $evaluate?$evaluate->staff->job:''; ?></dd>
        </dl>
        <div class=" bottom-mark"></div>
    </div>
    <div class="content-box border-b1">
        <ul class="huxing-nav clearfix">
            <?php foreach(PlotEvaluateExt::$contentFields as $name=>$pinyin):if(isset($evaluate->{$pinyin})&&!$evaluate->{$pinyin}->getIsEmpty()):?>
            <li><a><?php echo $name; ?></a></li>
            <?php endif;endforeach; ?>
        </ul>
    </div>
</div>
<div class="content-slider mg-20">
        <div class="swiper-wrapper">

        <?php $iconfont = ['huxing'=>'&#x1010;','wuye'=>'&#x1009;','peitao'=>'&#x1015;','shequpinzhi'=>'&#x1010;'];
         if($evaluate) 
            foreach (PlotEvaluateExt::$contentFields as $name=>$pinyin) { 
                if(isset($evaluate->{$pinyin})&&!$evaluate->{$pinyin}->getIsEmpty()):
            ?>
            <div class="swiper-slide">
                <div class="content-box border-b">
                    <div class="big-title"><i class="iconfont"><?=$iconfont[$pinyin]?></i><?php echo $name ?></div>
                    <?php foreach ($evaluate[$pinyin]->getContent() as $key => $item) { ?>
                       <div class="gw">
                        <?php if($item->isTitle): ?>
                        <p class="erji-title"><span><?php echo $item->text; ?></span></p>
                        <?php else: ?>
                        <div class="word-content">
                            <?php echo $item->text; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>
        <?php endif; }?>
           
        </div>
    </div>
<div class="blank20"></div>
<?php $this->renderPartial('/layouts/contact'); ?>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('body').addClass('bg-fff');
            $('.huxing-nav li:first-child').addClass('current');
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
