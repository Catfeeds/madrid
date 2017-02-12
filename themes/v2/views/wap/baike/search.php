    <?php
$this->pageTitle ='房产百科'.'_'.SM::urmConfig()->cityName().'房产网_'.'第'.(int)Yii::app()->request->getParam('page',1).'页-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('房产百科'.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产百科知识就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'知识搜索']) ?>

<div class="content-box" style="overflow:visible">
    <div class="search pt20 pb20">
        <div class="knowledge-search">
            <form id="search-form" action="<?php echo $this->createUrl('list');?>">
                <input type="text" name="kw" id="knowledge_key" data-url="<?=$this->createUrl('AjaxGetTitles')?>" placeholder="请输入您的问题" autocomplete="off">
                <a href="" onclick="document.getElementById('search-form').submit();return false;" class="iconfont search-btn">&#x1014;</a>
            </form>
        </div>
        <ul class="search-frame-expand top-86">
        </ul>
    </div>
</div>
<div class="content-box bg-content">
    <?php if($tags) : ?>
    <p class="s-title">最近热搜</p>
    <div class="hot-search-list">
    <?php foreach ($tags as $key => $tag) {?>
        <a href="<?php echo $this->createUrl('/wap/baike/list',array('tag'=>$tag->name));?>"><?=$tag['name']?></a>
    <?php }?>
    </div>
    <?php endif; ?>
</div>
<div class="blank20"></div>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
