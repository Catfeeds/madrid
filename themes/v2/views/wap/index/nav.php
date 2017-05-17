<?php
$this->pageTitle = SM::seoConfig()->homeIndexIndex()['title'] ? SM::seoConfig()->homeIndexIndex()['title'] : (SM::urmConfig()->cityName().'房地产门户_'.SM::urmConfig()->cityName().'房产网_'.SM::urmConfig()->cityName().'房产信息网-'.SM::GlobalConfig()->siteName().'房产手机版-'.SM::GlobalConfig()->siteName());

Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['keyword']?SM::seoConfig()->homeIndexIndex()['keyword']:(SM::urmConfig()->cityName().'房地产门户，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房地信息网，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'房地产网，'.SM::urmConfig()->cityName().'房屋出租，'.SM::GlobalConfig()->siteName().'房产'),'keywords');
Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['desc']?SM::seoConfig()->homeIndexIndex()['desc']:(SM::GlobalConfig()->siteName().'房产网是'.SM::urmConfig()->cityName().'最热最专业的网络房产平台，提供全面及时的'.SM::urmConfig()->cityName().'房产楼市资讯，'.SM::urmConfig()->cityName().'房产楼盘信息、最新'.SM::urmConfig()->cityName().'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.SM::urmConfig()->cityName().'房产最新优惠信息就上'.SM::GlobalConfig()->siteName().'房产网'),'description');?>

<?php $this->renderPartial('/layouts/header',['title'=>'导航','bc'=>true]) ?>

<div class="content-box">
    <ul class="nav-box clearfix">
        <li><a href="<?php echo $this->createUrl('/wap/plot/list'); ?>"><i class="iconfont icon01">&#x1047;</i>找新房</a></li>
        <?php if(SM::adviserConfig()->showAdviserPage()): ?>
        <li><a href="<?php echo $this->createUrl('/wap/adviser/index'); ?>"><i class="iconfont icon02">&#x1038;</i>带看新房</a></li>
        <?php endif; ?>
        <li><a href="<?php echo $this->createUrl('/wap/baike/index'); ?>"><i class="iconfont icon03">&#x1046;</i>买房宝典</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/news/index'); ?>"><i class="iconfont icon04">&#x1041;</i>楼盘资讯</a></li>
        <?php if(SM::specialConfig()->enable()): ?>
        <li><a href="<?php echo $this->createUrl('/wap/special/index'); ?>"><i class="iconfont icon05">&#x2034;</i>特价房</a></li>
        <?php endif; ?>
        <?php if(SM::tuanConfig()->enable()): ?>
        <li><a href="<?php echo $this->createUrl('/wap/purchase/index'); ?>"><i class="iconfont icon06">&#x1048;</i><?php echo $this->t('特惠团'); ?></a></li>
        <?php endif; ?>
        <?php if(SM::schoolConfig()->enable()): ?>
        <li><a href="<?php echo $this->createUrl('/wap/school/index'); ?>"><i class="iconfont icon07">&#x1043;</i>邻校房</a></li>
        <?php endif; ?>
        <li><a href="<?php echo $this->createUrl('/wap/index/index'); ?>"><i class="iconfont icon08">&#x1049;</i>首页</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/wenda/index'); ?>"><i class="iconfont icon09">&#x2037;</i>房产问答</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/calculator/index'); ?>"><i class="iconfont icon10">&#x1045;</i>房贷计算器</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/map/index'); ?>"><i class="iconfont icon11">&#x3598;</i>地图找房</a></li>
        <?php if(SM::kanConfig()->enable()): ?>
        <li><a href="<?php echo $this->createUrl('/wap/tuan/index'); ?>"><i class="iconfont icon12">&#x1042;</i>看房团</a></li>
        <?php endif; ?>
        <!-- <li><a href=""><i class="iconfont icon13">&#x1029;</i>二手房</a></li>
        <li><a href=""><i class="iconfont icon14">&#x1050;</i>租房</a></li>
        <li><a href=""><i class="iconfont icon15">&#x1025;</i>商铺</a></li>
        <li><a href=""><i class="iconfont icon16">&#x1023;</i>写字楼</a></li> -->
    </ul>
</div>
<div class="blank20"></div>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
