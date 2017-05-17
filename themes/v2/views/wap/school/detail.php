<?php
$this->pageTitle = $school->name.'_'.$school->name.'邻校房-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($school->name.'_'.$school->name.'邻校房划分','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'为你提供'.$school->name.'邻校房信息，并且根据学校的不同划分出不同学校所属的学校区域楼盘，为你购买'.$school->name.'邻校房提供最准确的邻校房楼盘信息。','description');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/school.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />
 <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=415167759dc5861ddbbd14154f760c7e"></script>


<?php $this->renderPartial('/layouts/header',['title'=>'邻校房','bc'=>true]) ?>

<div class="content-box">
    <div class="pt20 pb20">
        <div class="knowledge-search">
        <form id="search-school" action="<?=$this->createUrl('index')?>">
            <input type="text" name="kw" placeholder="请输入学校关键字">
            <a href="" onclick="document.getElementById('search-school').submit();return false;" class="iconfont search-btn">&#x1014;</a>
        </form>
        </div>
    </div>
</div>
<div class="gw"><div class="gcal">共有 <?=$count?> 个楼盘</div> </div>
<!-- <div class="plot-list dropload" data-url='json/school-house-more.json' data-template='schoolList'> -->
<div class="new-house dropload" data-url='<?=$this->createUrl('AjaxGetSchoolPlot',array('id'=>$id))?>' data-defurl='<?=$this->createUrl('AjaxGetSchoolPlot',array('id'=>$id))?>' data-template='houseList'>
    <ul class="house-list more-list">

    </ul>
</div>

<div id="location_map" style="width:0; height: 0;"></div>
<div id="location_map" style="width:0; height: 0;"></div>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('body').addClass('bg-fff');
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
