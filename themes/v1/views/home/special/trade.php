<?php
 Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js',CClientScript::POS_END);
 Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js',  CClientScript::POS_END);
 Yii::app()->clientScript->registerCssFile('/static/home/style/group.css');
Yii::app()->clientScript->registerCssFile('/static/home/style/index.css');
 $this->pageTitle = $this->siteConfig['cityName'].'房产特价房_一房一价_'.$this->siteConfig['cityName'].'特价房-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
 Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'特价房，'.$this->siteConfig['cityName'].'房产特价房，'.$this->siteConfig['siteName'].'房产，一房一价，'.$this->siteConfig['cityName'].'打折楼盘，热门楼盘，'.$this->siteConfig['siteName'].'房产','keywords');
 Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'房产特价房由'.$this->siteConfig['siteName'].'房产网联合开发商举行的优惠活动，为广大网友提供'.$this->siteConfig['cityName'].'特价房、刚需房、低总价房等优质性价比房源。','description');
$this->breadcrumbs = array($this->siteConfig['cityName'].'特价房');
?>
<div class="wapper">
    <?php if($this->siteConfig['enableSpecialPlot']): ?>
    <div class="tab-content clearfix">
        <a href="<?php echo $this->createUrl('trade')?>" class="current">特价房</a>
        <?php if($this->siteConfig['enableSpecialTuan']):?>
        <a href="<?php echo $this->createUrl('tuan')?>" ><?php echo $this->t('特惠团'); ?></a>
        <?php endif;?>
    </div>
    <?php endif; ?>
    <div class="special-price-list">
        <ul class="clearfix">
            <?php foreach ($special as $v) {?>
                <li>
                    <div class="box-a"><span class="group-icon">劲省<br><?php echo round(($v->price_old) - ($v->price_new),2) ?>万</span>
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">
                            <?php foreach($v->housetype_img as $k=>$n): if($k == 0):?>
                                <img src="<?php echo ImageTools::fixImage($n,270,200); ?>">
                            <?php endif; endforeach;?>
                            <div class="layertxt"><?php echo $v->plot->title?></div>
                            <div class="layerbg"></div>
                        </a>
                    </div>
                    <div class="box-b">
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank" class="c-sred fs18"><i class="group-icon icon-hongbao"></i><?php echo Tools::utf8substr($v->title,0,32);?></a>
                        <p class="c-g6 fs14"><span class="mr10"><?php echo $v->bed_room ?> <?php echo $v->size ?>m<sup>2</sup></span><span><?php echo (isset($this->siteArea[$v->plot->area])&&!empty($this->siteArea[$v->plot->area])) ? ($this->siteArea[$v->plot->area].((isset($this->siteStreet[$v->plot->area])&&!empty($this->siteStreet[$v->plot->area])) ? ((isset($this->siteStreet[$v->plot->area][$v->plot->street])&&!empty($this->siteStreet[$v->plot->area][$v->plot->street])) ? '/'.$this->siteStreet[$v->plot->area][$v->plot->street] : '') :'' )) : '';?></span></p>
                    </div>
                    <div class="box-c clearfix pl15 mt15">
                        <?php if($v->status == 5):?>
                            <a href="javascript:;" class="fr btn-order disabled">已售罄</a>
                        <?php else: ?>
                            <a href="javascript:;" class="fr btn-order k-dialog-type-1" data-title="<?php echo '[特价房]'.$v->title; ?>" data-spm="<?php echo OrderExt::generateSpm('特价房',$v); ?>">抢先预定</a>
                        <?php endif;?>

                        <p class="fl">
                            <span class="fs20 db c-g3">¥<span class="fs20 font-a"><?php echo $v->price_new ?></span>万</span>
                            <span class="db fs14 c-g9 mt5 text-through">¥<span class="font-a"><?php echo $v->price_old ?></span>万</span>
                        </p>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div class="blank20"></div>
        <div class="page-box fs14 fr">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
        </div>
        <div class="blank20"></div>
    </div>

</div>
