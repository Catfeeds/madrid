<?php
 Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js', CClientScript::POS_END);
 Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js', CClientScript::POS_END);
 Yii::app()->clientScript->registerCssFile('/static/home/style/group.css');
 $this->pageTitle = $this->siteConfig['cityName'].'楼盘团购_'.$this->siteConfig['cityName'].'房产特惠_'.$this->siteConfig['cityName'].'楼盘优惠-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
 Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'楼盘团购，'.$this->siteConfig['cityName'].'房产特惠，'.$this->siteConfig['cityName'].'楼盘优惠，'.$this->siteConfig['cityName'].'房产电商，'.$this->siteConfig['cityName'].'打折楼盘，楼盘团购，热门楼盘，'.$this->siteConfig['siteName'].'房产','keywords');
 Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'特惠楼盘由'.$this->siteConfig['siteName'].'房产网联合开发商举行的优惠活动，为广大网友提供'.$this->siteConfig['cityName'].'楼盘团购信息及楼盘团购服务。','description');
$this->breadcrumbs = array($this->siteConfig['cityName'].$this->t('特惠团'));
?>
<div class="wapper">
    <?php if($this->siteConfig['enableSpecialTuan']): ?>
    <div class="tab-content clearfix">
    <?php if($this->siteConfig['enableSpecialPlot']): ?>
        <a href="<?php echo $this->createUrl('trade')?>" >特价房</a>
        <?php endif; ?>
        <a href="<?php echo $this->createUrl('tuan')?>" class="current"><?php echo $this->t('特惠团'); ?></a>
    </div>
    <?php endif; ?>
    <div class="group-list">
        <?php foreach($tuan as $key=>$v){ ?>
        <dl class="clearfix">
            <dt><a href="<?php echo $v->url ? $v->url : $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin))?>" target="_blank"><img class="lazy" data-original="<?php echo ImageTools::fixImage($v->pc_img,580,346)?>"> </a></dt>
            <dd>
                <div class="fs22 c-g3 ml20 mt20 mb20 db"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin))?>" target="_blank"><?php echo $v->title?></a></div>
                <div class="txt-box1 clearfix"><span class="group-icon left">&nbsp;</span><span class="mid"><em class="ml20"><?php echo $v->s_title;?></em><a href="" class="group-icon btn k-dialog-type-1" data-title="[<?php echo $this->t('特惠团'); ?>]<?php echo $v->title; ?>" data-spm="<?php echo OrderExt::generateSpm('特惠团',$v); ?>">抢优惠</a></span><span class="group-icon right">&nbsp;</span></div>
                <div class="txt-box2 clearfix"><span class="fr fs16 c-g6"><?php echo $v->plot->price ? PlotPriceExt::$mark[$v->plot->price_mark].'：':''; ?><em class="c-g3"><?php echo PlotPriceExt::getPrice($v->plot->price,$v->plot->unit)?></em></span><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin))?>" target="_blank" class="fs20 c-g3"><?php echo $v->plot ? $v->plot->title : ''?></a></div>
                <ul class="fs16 mt10">
                    <li class="clearfix"><span class="fr c-g6"><em><?php echo($v->stat + $v->tuanNum);?></em>人已抢到优惠</span><span class="c-g6 mp"  data-lastdate="<?php echo $v->end_time-time() ?>"><i class="head-icon icon-time"></i><?php echo floor(($v->end_time - time())/86400)?>天 <?php echo floor(($v->end_time - (time() + (floor(($v->end_time - time())/86400))*86400))/3600)?>小时 <?php echo floor( ($v->end_time - (time() + floor(($v->end_time - time())/86400)*86400 + floor(($v->end_time - (time() + (floor(($v->end_time - time())/86400))*86400))/3600)*3600 ))/60)?>分钟 后结束</span></li>
                    <li><span class="c-g6 mr10">楼盘地址:</span><span class="c-g3"><?php echo $v->plot->address?></span></li>
                    <li class="fs22 c-pinkred"><i class="head-icon icon-tel"></i><?php echo $v->plot->sale_tel?></li>
                </ul>
            </dd>
        </dl>
        <?php } ?>
        <div class="page-box fs14 fr">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
        </div>
        <div class="blank20"></div>
    </div>
</div>
