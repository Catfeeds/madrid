<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'交通地图_'.$this->plot->title.'周边环境-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'交通地图，'.$this->plot->title.'周边环境','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main','TouchSlide.1.1']);
?>

<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$this->plot->pinyin));?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $this->plot->title;?>-地图</h1>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<!--头部 end-->
<!--楼盘库首页-->
<div class="loupanku loupan-map-block gw">
    <div class="simple-button gc6 simple-button-baoming mb30">
        <p class="text">
            <span class="gc0d"><?php echo $this->plot->title;?></span>
            <br><?php echo ($this->plot->area && $this->siteArea[$this->plot->area]) ? $this->siteArea[$this->plot->area]:'';?> <?php echo ($this->plot->street && $this->siteStreet[$this->plot->area][$this->plot->street]) ? $this->siteStreet[$this->plot->area][$this->plot->street] :'';?>
        </p>
        <a href="<?php echo $this->createUrl('/wap/wenda/ask',['hid'=>$this->plot->id]); ?>" class="baoming">我要咨询</a>
    </div>
    <div class="loupan-map-detail">
        <iframe src="<?php echo $this->createUrl('/wap/map/index',array('id'=>$this->plot->id))?>" width="560" height="587" frameborder="0"></iframe>
    </div>
</div>
