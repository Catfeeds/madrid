<?php
$this->pageTitle = SM::urmConfig()->cityName().'楼盘团购_'.SM::urmConfig()->cityName().'房产特惠_'.SM::urmConfig()->cityName().'楼盘优惠-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'楼盘团购，'.SM::urmConfig()->cityName().'房产特惠，'.SM::urmConfig()->cityName().'楼盘优惠，'.SM::urmConfig()->cityName().'房产电商，'.SM::urmConfig()->cityName().'打折楼盘，楼盘团购，热门楼盘，'.SM::GlobalConfig()->siteName().'房产','keywords');
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'特惠楼盘由'.SM::GlobalConfig()->siteName().'房产网联合开发商举行的优惠活动，为广大网友提供'.SM::urmConfig()->cityName().'楼盘团购信息及楼盘团购服务。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/index.css'); ?>

<?php $this->renderPartial('/layouts/header',['title'=>$this->t('特惠团')]) ?>

<div class="content-box">
    <div class="blank30"></div>

    <div class="tjf-list dropload" data-url='<?=$this->createUrl('AjaxGetPurchases')?>' data-template='thfList'>
       <ul class=" more-list">

        </ul>

    </div>
</div>
<div class="blank20"></div>
<?php if(strpos(Yii::app()->request->getUserAgent(),'MicroMessenger')===false && !$this->getIsInQianFan()): ?>
    <div class="gototop"></div>
<?php endif?>
