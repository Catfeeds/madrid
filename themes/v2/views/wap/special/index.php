<?php
$this->pageTitle = SM::urmConfig()->cityName().'房产特价房_一房一价_'.SM::urmConfig()->cityName().'特价房-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'特价房，'.SM::urmConfig()->cityName().'房产特价房，'.SM::GlobalConfig()->siteName().'房产，一房一价，'.SM::urmConfig()->cityName().'打折楼盘，热门楼盘，'.SM::GlobalConfig()->siteName().'房产','keywords');
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'房产特价房由'.SM::GlobalConfig()->siteName().'房产网联合开发商举行的优惠活动，为广大网友提供'.SM::urmConfig()->cityName().'特价房、刚需房、低总价房等优质性价比房源。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>

<?php $this->renderPartial('/layouts/header',['title'=>$this->t('特价房')]) ?>


<div class="content-box">
    <!-- <div class="title01"><i class="iconfont te">&#x1007;</i><h3><?php echo $this->t('特价房'); ?></h3></div> -->
    <div class="tjf-list-content dropload" data-url='<?php echo $this->createUrl('/wap/special/index',['ajax'=>'1']); ?>' data-template='tjfList'>
       <ul class="lists more-list">

       </ul>
    </div>
</div>

<div class="blank20"></div>

<?php $this->renderPartial('/layouts/contact'); ?>
