<?php
$this->pageTitle = $this->siteConfig['cityName'].'楼盘团购_'.$this->siteConfig['cityName'].'房产特惠_'.$this->siteConfig['cityName'].'楼盘优惠-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'楼盘团购，'.$this->siteConfig['cityName'].'房产特惠，'.$this->siteConfig['cityName'].'楼盘优惠，'.$this->siteConfig['cityName'].'房产电商，'.$this->siteConfig['cityName'].'打折楼盘，楼盘团购，热门楼盘，'.$this->siteConfig['siteName'].'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'特惠楼盘由'.$this->siteConfig['siteName'].'房产网联合开发商举行的优惠活动，为广大网友提供'.$this->siteConfig['cityName'].'楼盘团购信息及楼盘团购服务。','description');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/sale.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','validform.min','main']);
?>
<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
    <span class="ml10 mr10 c-gc fl fs32">|</span>
    <span class="fl fs32 gc3"><?php echo $this->t('特惠团'); ?> </span>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<div class="sale-content">
    <div class="blank40"></div>
    <?php foreach($tuan as $v):?>
        <div class="box clearfix">
            <div class="title c-red"><?php echo $v->s_title?></div>
            <div class="pic-img">
                <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$v->plot->pinyin))?>">
                    <img src="<?php echo ImageTools::fixImage($v->wap_img)?>" >
                    <p><?php echo $v->plot->title?><span class="fr"><?php echo PlotPriceExt::getPrice($v->plot->price,$v->plot->unit)?></span></p>
                </a>
            </div>
            <div class="info">
                <p class="gc6 fs28"><i class="icon icon-map fl">&nbsp;</i><?php echo Tools::u8_title_substr($v->plot->address,35);?></p>
                <?php if($v->end_time > time()):?>
                    <p class="gc6 fs28"><i class="icon icon-time fl">&nbsp;</i><?php echo floor(($v->end_time - time())/86400)?> 天 <?php echo floor(($v->end_time - (time() + (floor(($v->end_time - time())/86400))*86400))/3600)?> 小时 <?php echo floor( ($v->end_time - (time() + floor(($v->end_time - time())/86400)*86400 + floor(($v->end_time - (time() + (floor(($v->end_time - time())/86400))*86400))/3600)*3600 ))/60)?> 分钟 后结束 </p>
                <?php else: ?>
                    <p class="gc6 fs28"><i class="icon icon-time fl">&nbsp;</i>报名已结束 </p>
                <?php endif;?>
            </div>
            <div class="bottom-btn">
                <span><?php echo($v->stat + $v->tuanNum);?>人已参团</span>
                <?php if($v->end_time > time()):?>
                    <a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('特惠团', $v),'title'=>($v->plot->title.'--'.$v->s_title))); ?>">我要参团</a>
                <?php else:?>
                    <a href="<?php echo $v->url ? $v->url : 'javascript:;';?>">报团结束</a>
                <?php endif;?>
            </div>
        </div>
    <?php endforeach;?>
    <?php $this->widget('WapLinkPager',array('pages'=>$pager)); ?>
</div>

<div class="layer-overall"></div>
