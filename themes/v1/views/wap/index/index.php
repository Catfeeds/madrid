<?php
$this->pageTitle = $this->siteConfig['sySEO']['title'] ? $this->siteConfig['sySEO']['title'] : ($this->siteConfig['cityName'].'房地产门户_'.$this->siteConfig['cityName'].'房产网_'.$this->siteConfig['cityName'].'房产信息网-'.$this->siteConfig['siteName'].'房产手机版-'.$this->siteConfig['siteName']);

Yii::app()->clientScript->registerMetaTag($this->siteConfig['sySEO']['keyword']?$this->siteConfig['sySEO']['keyword']:($this->siteConfig['cityName'].'房地产门户，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['cityName'].'房地信息网，'.$this->siteConfig['cityName'].'房价，'.$this->siteConfig['cityName'].'房地产网，'.$this->siteConfig['cityName'].'房屋出租，'.$this->siteConfig['siteName'].'房产'),'keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['sySEO']['description']?$this->siteConfig['sySEO']['description']:($this->siteConfig['siteName'].'房产网是'.$this->siteConfig['cityName'].'最热最专业的网络房产平台，提供全面及时的'.$this->siteConfig['cityName'].'房产楼市资讯，'.$this->siteConfig['cityName'].'房产楼盘信息、最新'.$this->siteConfig['cityName'].'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.$this->siteConfig['cityName'].'房产最新优惠信息就上'.$this->siteConfig['siteName'].'房产网'),'description');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/index.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['main','swipeSlide.min']);
?>

<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<div class="img-slide clearfix">
    <div class="slide" id="slide">
        <ul>
            <?php foreach($recom as $v):?>
                <li><a href="<?php echo $v->url;?>" target="_blank"><img src="<?php echo ImageTools::fixImage($v->image);?>" alt=""></a></li>
            <?php endforeach;?>
        </ul>
        <div class="dot">
        <?php foreach($recom as $v):?>
            <span></span>
        <?php endforeach;?>
        </div>
    </div>
</div>
<div class="blank20"></div>
<div class="search">
    <form action="<?php echo $this->createUrl('/wap/plot/list')?>" method="GET">
        <div class="search-r"><input type="submit" class="search-btn" value="搜索"></div>
        <div class="search-l"><input class="search-text" type="search" name="keyword" placeholder="输入您要找的楼盘名称" value=""></div>
    </form>
</div>
<div class="blank20"></div>
<div class="column">
    <ul class="clearfix">
        <li><a href="<?php echo $this->createUrl('/wap/plot/list')?>"><i class="icon icon-nav icon-plot">&nbsp;</i>找楼盘</a></li>
        <?php if($this->siteConfig['enableSpecialTuan']): ?>
        <li><a href="<?php echo $this->createUrl('/wap/purchase/index')?>"><i class="icon icon-nav icon-thfang">&nbsp;</i><?php echo $this->t('特惠团'); ?></a></li>
        <?php endif; ?>
        <?php if($this->siteConfig['enableSpecialPlot']): ?>
        <li><a href="<?php echo $this->createUrl('/wap/special/index')?>"><i class="icon icon-nav icon-tjfang">&nbsp;</i>特价房</a></li>
        <?php endif; ?>
        <?php if($this->siteConfig['enableSchool']): ?>
        <li><a href="<?php echo $this->createUrl('/wap/school/index')?>"><i class="icon icon-nav icon-xqfang">&nbsp;</i>邻校房</a></li>
        <?php endif; ?>
        <li><a href="<?php echo $this->createUrl('/wap/tuan/index')?>"><i class="icon icon-nav icon-kft">&nbsp;</i>看房团</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/wenda/index')?>"><i class="icon icon-nav icon-answer">&nbsp;</i>问答</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/calculator/index')?>"><i class="icon icon-nav icon-calculator">&nbsp;</i>计算器</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/news/index')?>"><i class="icon icon-nav icon-news">&nbsp;</i>资讯</a></li>
    </ul>
</div>
<div class="blank30"></div>
<div class="gw">
    <?php if($this->siteConfig['enableSpecialPlot'] && $special): ?>
    <div class="title clearfix">
        <a href="<?php echo $this->createUrl('/wap/special/index')?>" class="fr">
            <i class="icon icon-right-arrow">&nbsp;</i>
        </a>
        <h2 class="fs32 gc3 fl">特价房</h2>
        <span class="gc6 fl">精选高性价比楼盘</span>
    </div>
    <div class="blank30"></div>
    <div class="item clearfix">
        <ul>
        <?php foreach($special as $v):?>
            <li>
                <div class="pic-box"><a href="<?php echo $this->createUrl('/wap/special/detail',array('id'=>$v->id))?>"><img data-original="<?php echo ImageTools::fixImage($v->image)?>" class="lazy" ><p><?php echo Tools::utf8substr($v->title, 0,30);?></p></a></div>
                <div class="info">
                    <div class="title clearfix fs24">
                        <span class="fr"><?php echo $v->size?>/m<sup>2</sup></span>
                        <p class="fl"><?php echo $v->room?></p>
                    </div>
                    <p><span class="red fs28"><em class="fs24">￥</em><?php echo $v->price_new?><em class="fs20">万</em></span><del class="ml20 gc9 mt5 fs24">￥<?php echo $v->price_old?>万</del></p>
                </div>
            </li>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="addmore">
        <a href="<?php echo $this->createUrl('/wap/special/index')?>">更多特价房</a>
    </div>
    <div class="blank40"></div>
    <?php endif; ?>
    <?php if($this->siteConfig['enableSpecialTuan'] && !empty($tuan)):?>
    <div class="title clearfix"><a href="<?php echo $this->createUrl('/wap/purchase/index')?>" class="fr"><i class="icon icon-right-arrow">&nbsp;</i></a><h2 class="fs32 gc3 fl"><?php echo $this->t('特惠团'); ?></h2> <span class="gc6 fl">汇聚楼盘最新优惠</span></div>
    <div class="blank30"></div>
    <div class="plot-list">
        <ul>
        <?php foreach($tuan as $v):?>
            <li>
                <a href="<?php echo $this->createUrl('/wap/purchase/index')?>">
                    <div class="pic"><img src="<?php echo ImageTools::fixImage($v->wap_img)?>" alt="" /></div>
                    <div class="info">
                        <h3 class="fs28"><?php echo $v->plot ? Tools::u8_title_substr($v->plot->title,15) : '';?></h3>
                        <p class="right-float gc6"><?php echo $v->plot ? PlotPriceExt::getPrice($v->plot->price,$v->plot->unit) : ''?></p>
                        <p class="c-red"><?php echo $v->s_title;?></p>
                        <p class="gc6"><?php echo $v->plot->areaInfo ? $v->plot->areaInfo->name : ''?>&#160;&#160;<?php echo $v->plot->streetInfo ? $v->plot->streetInfo->name : ''?></p>
                    </div>
                </a>
            </li>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="blank10"></div>
    <div class="addmore">
        <a href="<?php echo $this->createUrl('/wap/purchase/index')?>">更多<?php echo $this->t('特惠团'); ?></a>
    </div>
    <div class="blank40"></div>
    <?php endif;?>
    <?php $this->widget('WapAdWidget', ['position' => 'wapzxfsb'])?>
    <div class="title clearfix"><a href="<?php echo $this->createUrl('/wap/plot/list')?>" class="fr"><i class="icon icon-right-arrow">&nbsp;</i></a><h2 class="fs32 gc3 fl">找新房</h2> <span class="gc6 fl">汇聚最新楼盘信息</span></div>
    <div class="blank30"></div>
    <div class="plot-list">
        <ul>
        <?php foreach($plot as $v):?>
            <li>
                <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$v->pinyin))?>">
                    <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image)?>" alt="" /></div>
                    <div class="info">
                        <h3 class="fs28"><?php echo $v->title?></h3>
                        <p class="right-float gc6"><?php echo $v->areaInfo ? $v->areaInfo->name : '';?></p>
                        <p class="gc6"><?php echo $v->newDiscount ? Tools::utf8substr($v->newDiscount->title,0,34) : '';?></p>
                        <p class="c-red"><?php echo PlotPriceExt::getPrice($v->price,$v->unit);?></p>
                    </div>
                </a>
            </li>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="blank10"></div>
    <div class="addmore">
        <a href="<?php echo $this->createUrl('/wap/plot/list')?>">更多新房</a>
    </div>
</div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
            $('#slide').swipeSlide({
                continuousScroll:true,
                speed : 3000,
                transitionType : 'cubic-bezier(0.22, 0.69, 0.72, 0.88)',
                callback : function(i){
                    $('.dot').children().eq(i).addClass('cur').siblings().removeClass('cur');
                }
            });
    <?php Tools::endJs('js'); ?>
</script>
