<?php
$this->pageTitle = SM::GlobalConfig()->siteName().'楼盘点评-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('楼盘点评，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag('特色买房顾问整装待发为您提供专业贴心的房产服务','description');
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/search.css'); ?>
<?php $this->renderPartial('/layouts/header',['title'=>'楼盘点评']) ?>
<!-- <div class="plot-reviews plot-reviews-detail dropload" data-url='json/dianping.json' data-template='dianpingList'> -->
<div class="plot-reviews plot-reviews-detail dropload" data-url='<?php echo $this->createUrl('/wap/adviser/plotComment', ['ajax'=>1,'sid'=>$sid]); ?>' data-template='dianpingList'>
    <ul class="reviews-list-ul more-list">

    </ul>

</div>
