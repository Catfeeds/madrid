<?php
$this->pageTitle = SM::GlobalConfig()->siteName().'地图找房-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['keyword']?SM::seoConfig()->homeIndexIndex()['keyword']:(SM::urmConfig()->cityName().'房地产门户，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房地信息网，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'房地产网，'.SM::urmConfig()->cityName().'房屋出租，'.SM::GlobalConfig()->siteName().'房产'),'keywords');
Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['desc']?SM::seoConfig()->homeIndexIndex()['desc']:(SM::GlobalConfig()->siteName().'房产网是'.SM::urmConfig()->cityName().'最热最专业的网络房产平台，提供全面及时的'.SM::urmConfig()->cityName().'房产楼市资讯，'.SM::urmConfig()->cityName().'房产楼盘信息、最新'.SM::urmConfig()->cityName().'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.SM::urmConfig()->cityName().'房产最新优惠信息就上'.SM::GlobalConfig()->siteName().'房产网'),'description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=415167759dc5861ddbbd14154f760c7e"></script>
<script type="text/javascript">
    var cityName = "<?=SM::urmConfig()->cityName(); ?>";
</script>
<?php if(strpos(Yii::app()->request->getUserAgent(),'MicroMessenger')===false && !$this->getIsInQianFan()):?>
<header class="title-bar title-bar-hasbg">
    <?php $this->widget('BackButton'); ?>
    <div class="search">
        <form id="search_form" data-url="<?php echo $this->createUrl('/wap/map/search'); ?>">
            <div class="search-frame">
                <i class="iconfont">&#x1014;</i>
                <input type="text" id="keywords_input" name="keywords" value="" placeholder="请输入楼盘名称" autocomplete="off">
            </div>
        </form>
    </div>
    <?php $this->renderPartial('/layouts/operate',['search'=>false]); ?>
</header>
<?php else:?>
    <?php $this->renderPartial('/layouts/header',['search'=>false]); ?>
<?php endif?>
<!-- 顶部结束 -->

<!-- 内容开始 -->
<section class="container">
	<div class="map-title">共为您找到 <em>0</em> 个楼盘</div>
    <div id="l-map" data-url="<?php echo $this->createUrl('/wap/plot/ajaxMap')?>" data-childurl="<?php echo $this->createUrl('/wap/plot/ajaxMapChild')?>"  style="width:100%; height: 10rem;"></div>
</section>
<!-- 内容结束 -->
<style>
  .search_result{
    width: 6.4rem;
    height: auto;
    overflow: hidden;
    position: absolute;
    top: .98rem;
    background: #fff;
    z-index: 99999999999;
  }
  .search_result li{
    width: 100%;
    padding: 0 .2rem;
    line-height: .5rem;
    color: #333;
    font-size: .24rem;
  }
  .search_result li a{
    color: #333;
    font-size: .24rem;
  }
</style>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
