<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'楼栋信息-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'楼栋信息','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css'); ?>

<?php $this->renderPartial('/layouts/header',['title'=>$this->plot->title]) ?>

<!-- 内容开始 -->
<div class="content-box">
    <!-- 滑动菜单开始 -->
    <div class="menu-slide-loudong" id="menu_slide_loudong_detail">
        <ul class="swiper-wrapper">
        <?php foreach ($periods as $key => $value) {?>
           <li class="swiper-slide"><a id="pid<?=$value->id?>" href="" data-url="<?=$this->createUrl('ajaxGetBuilding',array('id'=>$value['id']))?>" class="on"><?=$value['period']?>期</a></li>
        <?php }?>
        </ul>
    </div>
    <!-- 滑动菜单结束 -->
    <div class="loudong-wapper">
            <div id="draggable">
                <div class="drag-warp">
                    <div class="img"><img src=""></div>
                    <div class="infos"></div>
                </div>
            </div>
        </div>
    <div class="build-detail">
        <div class="info">
            <a href="" class="clearfix">
                <h5></h5>
                <p class="data"><span>最新开盘：<em id="kaipan">-</em></span></p>
                <p class="data"><span>最新交房：<em id="jiaofang">-</em></span></p>
                <i class="goarrow iconfont">&#x1020;</i>
            </a>
            <div class="blank10"></div>
            <ul class="clearfix">
                <li><span>单元：<em id="danyuan">-</em></span></li>
                <li><span>户数：<em id="hushu">-</em></span></li>
                <li><span>层数：<em id="cengshu">-</em></span></li>
                <li><span>在售房源：<em id="fangyuan">-</em></span></li>
            </ul>
        </div>
    </div>
</div>
<div class="blank20"></div>
<script type="text/javascript">
<?php if($pid>0):Tools::startJs(); ?>
Do.ready(function(){
    $(document).ready(function(){
        $("#pid<?=$pid?>").click();
    });
});
<?php Tools::endJs('js');endif; ?>
</script>
