<?php
$artcate = '';
foreach($cates as $v){
    if($v->id == $cid){
        $artcate = $v->name;
    }
}
$this->pageTitle =($artcate ? $artcate : '房产资讯').'_'.SM::urmConfig()->cityName().'房产网_'.'第'.(int)Yii::app()->request->getParam('page',1).'页-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(($artcate ? $artcate : '房产资讯').'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/news.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/swiper.min.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'楼盘资讯','bc'=>true]) ?>

<?php if($hid):?>
<div class="content-box">
    <div class="line-d"></div>

<?php else:?>
<div class="content-box news-list-slider">
    <ul class="news-tabs swiper-wrapper">
        <li class="swiper-slide <?php echo $cid>0?'':'on'; ?>"><a href="<?php echo $this->createUrl("index");?>">全部资讯</a></li>
        <?php foreach ($cates as $key => $cate) { ?>
            <li class="swiper-slide <?php echo $cate['id']==$cid?'on':''; ?>"><a href="" data-url="<?php echo $this->createUrl("AjaxGetNewsList",array('cid'=>$cate->id,'hid'=>$hid));?>"><?=$cate['name']?></a></li>
        <?php }?>
    </ul>

<?php endif;?>
    <div class="news-list dropload" data-url="<?php echo $this->createUrl("AjaxGetNewsList",array('cid'=>$cid,'hid'=>$hid));?>" data-template='newsList'>
        <ul class="list more-list">

        </ul>
    </div>
</div>
<div class="blank20"></div>
<?php $this->renderPartial('/layouts/contact'); ?>
