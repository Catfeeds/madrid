<?php
$this->pageTitle = SM::urmConfig()->cityName().'看房团_'.SM::urmConfig()->cityName().'看房团报名_'.SM::urmConfig()->cityName().'看房团班车-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'看房团，'.SM::urmConfig()->cityName().'看房团报名，'.SM::urmConfig()->cityName().'看房团班车，'.SM::urmConfig()->cityName().'房产网，'.SM::GlobalConfig()->siteName().'房产','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网定期召集网友组织'.SM::urmConfig()->cityName().'看房团、'.SM::urmConfig()->cityName().'看房团报名等活动，为广大网友精心规划优质看房路线，方便大家省时省力选出最合适自己的房子。','description');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/kanfangtuan.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>$this->t('看房团')]) ?>

<div class="kanfangtuan-list gw g-fangchan dropload" data-url="<?=$this->createUrl('index',['ajax'=>1])?>" data-template='kftList'>
    <ul class="more-list">

    </ul>
</div>
<!--楼盘资讯 end-->
<div class="blank20"></div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    document.body.className = 'bg-fff';
    <?php Tools::endJs('js'); ?>
</script>
