<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'交通地图_'.$this->plot->title.'周边环境-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'交通地图，'.$this->plot->title.'周边环境','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">周边配套</span>
        </div>
    </div>
</div>
<?php $this->renderPartial('plot_naver')?>
<div class="blank10"></div>
<div class="wapper">
    <div class="map">
        <div class="map-box" data-lng="<?php echo $this->plot->map_lng?>" data-lat="<?php echo $this->plot->map_lat;?>" data-zoom="<?php echo $this->plot->map_zoom?>" data-plot-name="<?php echo $this->plot->title;?>" data-plot-addr="<?php echo $this->plot->address;?>">
            <div id="ui-map-box"></div>
            <div class="assort-distance fixed-side school">
                <div class="close-assort ">
                    显<br>示<br>周<br>边<br>配<br>套
                </div>
                <div class="extend-box">
                    <h4><span class="plot-ico"></span><i id="bmap-keyword">学校</i><i id="result-count"></i></h4>
                    <span class="close plot-ico"></span>
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
        <div class="map-label">
            <ul js="clearSonAttr">
                <li class="label-one">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="school" data-name="<?=SM::urmConfig()->cityName(); ?>学校">学校</i>
                    </a>
                </li>
                <li class="label-two">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="hospital" data-name="<?=SM::urmConfig()->cityName(); ?>医院">医院</i>
                    </a>
                </li>
                <li class="label-three">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="bank" data-name="<?=SM::urmConfig()->cityName(); ?>银行">银行</i>
                    </a>
                </li>
                <li class="label-four">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="repast" data-name="<?=SM::urmConfig()->cityName(); ?>餐饮">餐饮</i>
                    </a>
                </li>
                <li class="label-five">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="shopping" data-name="<?=SM::urmConfig()->cityName(); ?>购物">购物</i>
                    </a>
                </li>
                <li class="label-six">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="bus" data-name="<?=SM::urmConfig()->cityName(); ?>公交">公交</i>
                    </a>
                </li>
                <li class="label-seven">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="park" data-name="<?=SM::urmConfig()->cityName(); ?>公园">公园</i>
                    </a>
                </li>
                <li class="label-eight">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="airport" data-name="<?=SM::urmConfig()->cityName(); ?>机场">机场</i>
                    </a>
                </li>
                <li class="label-nine" style="border-bottom-width: 0px;">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="refuel" data-name="<?=SM::urmConfig()->cityName(); ?>加油站">加油站</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
<div class="blank10"></div>
<?php if(!empty($imglist)): ?>
<div class="wapper">
    <div class="title-box">
        <h2>周边实拍</h2>
    </div>
    <ul class="pic-list photo-list">
        <?php foreach($imglist as $v): ?>
            <li><a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'pid'=>$v->id))?>" target="_blank"><?php echo CHtml::image(ImageTools::fixImage($v->url,'360','270'));?><p><?php echo $v->title;?><span class="fr fs14"><?php echo date('Y-m-d',$v->created)?></span></p></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<?php $this->footer(); ?>
<style type="text/css">
    #ui-map-box{
        height:450px;
    }
</style>
