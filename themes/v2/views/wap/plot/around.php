<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'周边配套-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'周边配套','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=415167759dc5861ddbbd14154f760c7e"></script>

<?php if(strpos(Yii::app()->request->getUserAgent(),'MicroMessenger')===false && !$this->getIsInQianFan()): ?>
<div class="top-mark"></div>
<?php endif;?>

<?php $this->renderPartial('/layouts/header',['title'=>$this->plot->title.'周边配套','search'=>false]); ?>

<!-- 顶部结束 -->

<!-- 内容开始 -->
<section class="container">
    <div id="a-map" data-url="<?=$this->createUrl('AjaxAround',array('hid'=>$hid))?>" style="width:100%; height: 10rem;"></div>
    <ul class="map-around-bar">
        <li><a href="" data-name="公交" data-class="jiaotong"><i class="iconfont">&#x1012;</i>交通</a></li>
        <li><a href="" data-name="学校" data-class="jiaoyu"><i class="iconfont">&#x2985;</i>教育</a></li>
        <li><a href="" data-name="美食" data-class="meishi"><i class="iconfont">&#x1004;</i>美食</a></li>
        <li><a href="" data-name="医院" data-class="jiankang"><i class="iconfont">&#x1006;</i>健康</a></li>
        <li><a href="" data-name="超市" data-class="shenghuo"><i class="iconfont">&#x1025;</i>生活</a></li>
    </ul>
</section>
<!-- 内容结束 -->
<script type="text/javascript">
    var is_plot_around_index = <?=$index; ?>
</script>
