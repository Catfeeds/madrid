<?php
Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/home/style/index.css');
$this->pageTitle = $this->siteConfig['sySEO']['title'] ? $this->siteConfig['sySEO']['title'] : ($this->siteConfig['cityName'].'房地产门户_'.$this->siteConfig['cityName'].'房产网_'.$this->siteConfig['cityName'].'房产信息网-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName']);

 Yii::app()->clientScript->registerMetaTag($this->siteConfig['sySEO']['keyword']?$this->siteConfig['sySEO']['keyword']:($this->siteConfig['cityName'].'房地产门户，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['cityName'].'房地信息网，'.$this->siteConfig['cityName'].'房价，'.$this->siteConfig['cityName'].'房地产网，'.$this->siteConfig['cityName'].'房屋出租，'.$this->siteConfig['siteName'].'房产'),'keywords');

 Yii::app()->clientScript->registerMetaTag($this->siteConfig['sySEO']['description']?$this->siteConfig['sySEO']['description']:($this->siteConfig['siteName'].'房产网是'.$this->siteConfig['cityName'].'最热最专业的网络房产平台，提供全面及时的'.$this->siteConfig['cityName'].'房产楼市资讯，'.$this->siteConfig['cityName'].'房产楼盘信息、最新'.$this->siteConfig['cityName'].'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.$this->siteConfig['cityName'].'房产最新优惠信息就上'.$this->siteConfig['siteName'].'房产网'),'description');
?>
<?php if($this->startCache($this->getCacheId(), ['duration'=>1800], ['home/index/active'])): ?>
<div class="wapperout">
    <div class="banner">
        <div id="slider">
            <ul class="slider">
                <?php foreach ((RecomExt::model()->getByStationId($this->substationId)->getRecom('sytwlh', 4)->findAll()) as $v) : ?>
                    <li><a href="<?php echo $v->url?>" target="_blank" style="background:url(<?php echo ImageTools::fixImage($v->image,1920,330)?>) no-repeat center;"></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php if($kan = PlotKanExt::model()->normal()->recommended()->find()):?>
            <?php if($kan->expire > time()):?>
        <div class="banner-group">
            <div class="p20">
                <a href="<?php echo $this->createUrl('/home/tuan/index')?>" target="_blank" title="<?php echo $kan->title; ?>" class="c-g3 fs18"><?php echo Tools::u8_title_substr($kan->title, 35);?></a>
                <p class="c-g6 mt10"><?php echo date('Y年m月d日', $kan->gather_time); ?>免费看房团</p>
                <div class="path mt25">
                    <ul class="">
                        <?php foreach ($kan->plots as $k=>$v): if($k < 4):?>
                            <li><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin)); ?>" target="_blank"><?php echo $v->title ?></a><span></span></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <div class="blank30"></div>
                <div class="free-box">
                    <?php if($kan->expire > time()):?>
                        <a class="btn-free fs18 k-dialog-type-1"  data-title="[看房团]<?php echo $kan->title; ?>" data-spm="<?php echo OrderExt::generateSpm('看房团',$kan); ?>"><em class="head-icon"></em>免费参团</a>
                    <?php else: ?>
                        <a href="javaScript:" class="btn-free fs18"><em class="head-icon"></em>报名结束</a>
                    <?php endif;?>
                    <span class="ml20"><em class="c-red fs18 font-a"><?php echo($kan->stat + $kan->kanNum)?></em>人已报名</span>
                </div>
            </div>
            <div class="info-box">
                <p><span class="head-icon icon-time"></span><em class="c-g9">集合时间：</em><?php echo date('m月d日 H:i',$kan->gather_time); ?></p>
                <p><span class="head-icon icon-map"></span><em class="c-g9">集合地点：</em><?php echo $kan->location ?></p>
            </div>
        </div>
                <?php endif;?>
        <?php endif; ?>
    </div>
</div>
<div class="s-tag wapper clearfix">
    <dl>
        <dt class="fs16 orgc">区域找房</dt>
        <dd class="clearfix">
                <?php foreach($this->getQyzf() as $k=>$v):?>
                    <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$k))?>" title="<?php echo $v?>" target="_blank"><?php echo $v?></a>
                <?php endforeach;?>
        </dd>
    </dl>
    <dl class="green">
        <dt class="fs16 green">价格找房</dt>
        <dd class="clearfix">
        <?php foreach($this->sitePriceTag as $k=>$v):?>
                <a href="<?php echo $this->createUrl('/home/plot/list',['ext'=>'p'.$v->id]+($this->substationId?['place'=>$this->substationId]:[]))?>" title="<?php echo $v->title;?>" target="_blank"><?php echo $v->title;?></a>
        <?php endforeach;?>
        </dd>
    </dl>
    <dl class="purple">
        <dt class="fs16 purple">物业类型</dt>
        <dd class="clearfix">
            <?php $i = 1;foreach($this->siteTag as $v):if($v->cate == 'wylx' && $i <= 10):$i++;?>
                <a href="<?php echo $this->createUrl('/home/plot/list',['ext'=>'w'.$v->id]+($this->substationId?['place'=>$this->substationId]:[])); ?>" title="<?php echo $v->name?>" target="_blank"><?php echo $v->name?></a>
            <?php endif; endforeach;?>
        </dd>
    </dl>
    <dl class="last">
        <dt class="fs16 blue">需求找房</dt>
        <dd class="clearfix">
            <?php $i = 1;foreach($this->siteTag as $v):if($v->cate == 'xmts' && $i <= 10):$i++;?>
                <a href="<?php echo $this->createUrl('/home/plot/list',['ext'=>'t'.$v->id]+($this->substationId?['place'=>$this->substationId]:[])); ?>" title="<?php echo $v->name?>" target="_blank"><?php echo $v->name?></a>
            <?php endif; endforeach;?>
        </dd>
    </dl>
</div>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'sysb']); ?>
<div class="wapper">
    <div class="top-news clearfix">
        <ul class="house-tj">
            <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('sytlzc', 4)->findAll() as $v) : ?>
                <li><a href="<?php echo $v->url?>" target="_blank"><?php echo $v->title ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="ad-mid">
            <?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'syztl']); ?>
        </div>
        <ul class="house-tj">
            <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('sytlyc', 4)->findAll() as $v): ?>
                <li><a href="<?php echo $v->url?>" target="_blank"><?php echo $v->title ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if($this->siteConfig['enableSpecialPlot'] && $tejiafang = PlotSpecialExt::model()->normal()->recommend()->noExpire()->findAll()): ?>
    <div class="title-box clearfix">
        <a href="<?php echo $this->createUrl('/home/special/trade')?>" target="_blank" class="fr c-g9 fs14 mt10">更多&gt;</a>
        <h2 class="fl">特价房</h2>
        <p class="fl ml10 mt10 fs14 c-g6"><?php echo $this->siteConfig['siteName']?>特价房频道，汇集<?php echo $this->siteConfig['cityName']?>高性价比楼盘</p>
    </div>
    <div class="special-price-list">
        <ul class="clearfix">
            <?php foreach ($tejiafang as $v): ?>
                <li>
                    <div class="box-a"><span class="group-icon">劲省<br><?php echo round(($v->price_old) - ($v->price_new),2) ?>万</span>
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">
                            <img src="<?php echo ImageTools::fixImage($v->image,270,200) ?>">
                            <div class="layertxt"><?php echo $v->plot->title?></div>
                            <div class="layerbg"></div>
                        </a>
                    </div>
                    <div class="box-b">
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank" class="c-sred fs18"><i class="group-icon icon-hongbao"></i><?php echo Tools::utf8substr($v->title,0,32);?></a>
                        <p class="c-g6 fs14"><span class="mr10"><?php echo $v->bed_room ?> <?php echo $v->size ?>m<sup>2</sup></span><span><?php echo (isset($this->siteArea[$v->plot->area])&&!empty($this->siteArea[$v->plot->area])) ? ($this->siteArea[$v->plot->area].((isset($this->siteStreet[$v->plot->area])&&!empty($this->siteStreet[$v->plot->area])) ? ((isset($this->siteStreet[$v->plot->area][$v->plot->street])&&!empty($this->siteStreet[$v->plot->area][$v->plot->street])) ? '/'.$this->siteStreet[$v->plot->area][$v->plot->street] : '') :'' )) : '';?></span></p>
                    </div>
                    <div class="box-c clearfix pl15 mt15">
                        <?php if($v->getIsSellOut()):?>
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
            <?php endforeach; ?>
        </ul>
    </div>
    <?php else: ?>
    <div class="blank5"></div>
    <?php endif; ?>
    <?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'sythtsb']); ?>
    <?php if($this->siteConfig['enableSpecialTuan']): ?>
    <?php $tuanNum = PlotTuanExt::model()->normal()->noExpire()->recommend()->count(); if(!empty($tuanNum)):?>
    <div class="title-box clearfix">
        <a href="<?php echo $this->createUrl('/home/special/tuan')?>" target="_blank" class="fr c-g9 fs14 mt10">更多&gt;</a>
        <h2 class="fl"><?php echo $this->t('特惠团'); ?></h2>
        <p class="fl ml10 mt10 fs14 c-g6"><?php echo $this->siteConfig['siteName']?>优惠频道，汇聚<?php echo $this->siteConfig['cityName']?>热门楼盘优惠信息</p>
    </div>
    <ul class="pic-list more-pic">
        <?php foreach (PlotTuanExt::model()->normal()->noExpire()->recommend()->findAll(array('limit' => 8, 'order' => 'sort DESC,created DESC')) as $v) : ?>
        <li>
            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">
                <div class="pic-img"><img class="lazy" data-original="<?php echo ImageTools::fixImage($v->pc_img,270,164) ?>" ><?php if($v->hongbao): ?><span class="group-icon icon-hongbao"><?php echo $v->hongbao;?></span><?php endif; ?></div>
                <p><?php echo $v->plot->title ?><span class="fr fs14 c-g9"><?php echo $v->plot->areaInfo->name ?></span></p>
            </a>
            <p class="c-red"><?php echo Tools::u8_title_substr($v->s_title,29,'');?></p>
            <p class="c-g9 fs12"><span class="fs16 font-a mr10"><?php echo ($v->stat+$v->tuanNum);?></span>人已参团</p>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif;?>
<?php endif;?>
</div>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'syrmzxsb']); ?>
<div class="wapper">
    <div class="title-box clearfix">
        <div class="fr right-box fs14">
        <li>
        <?php foreach(ArticleCateExt::model()->normal()->findAll(array('limit'=>8,'order'=>'sort DESC')) as $k=>$v):?>
            <?php if($k < 7){?>
                <a href="<?php echo $this->createUrl('/home/news/index',array('cateid'=>$v->id));?>" target="_blank"><?php echo $v->name;?></a><em>|</em>
            <?php }else{ ?>
                <a href="<?php echo $this->createUrl('/home/news/index',array('cateid'=>$v->id));?>" target="_blank"><?php echo $v->name;?></a>
            <?php } ?>
        <?php endforeach;?>
        </li>
        </div>
        <h2 class="fl">热门资讯</h2>
    </div>
    <div class="l-box">
        <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syrmzxtwlb', 2)->normal()->findAll() as $v): ?>
            <a href="<?php echo $v->url?>" target="_blank" class="c-g6 mb15"><img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image,200,145) ?>"><?php echo $v->title ?></a>
        <?php endforeach; ?>
    </div>
    <div class="m-box">
        <dl class="today-headline clearfix mb10">
            <dt>&nbsp;</dt>
            <dd>
                <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syrmzxtt', 1)->normal()->findAll() as $v) : ?>
                    <h1><a href="<?php echo $v->url ?>" target="_blank" class="c-g3 tac db"><?php echo $v->title ?></a></h1>
                <?php endforeach; ?>
                <ul class="fs12">
                    <?php
                        $syrmzxttx = RecomExt::model()->getByStationId($this->substationId)->getRecom('syrmzxttx',6)->normal()->findAll();
                        foreach($syrmzxttx as $k=>$v):?>
                            <li><a href="<?php echo $v->url?>" target="_blank"><?php echo $v->title; ?></a><?php echo $k+1!=count($syrmzxttx)?'|':''?></li>
                    <?php endforeach;?>
                </ul>
            </dd>
        </dl>
        <ul class="text-list fs16 clearfix">
            <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syrmzxwzlb', 14)->normal()->findAll() as $v) { ?>
                <li><a href="<?php echo $v->url?>" target="_blank" class=<?php echo isset($v->config['markColor'])&&$v->config['markColor'] ? "c-sred" : "";?>><?php echo $v->title ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="r-box">
        <div class="fs18 c-g3">楼盘评测</div>
        <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syrmzxlpcptp', 1)->normal()->findAll() as $v) :?>
            <div class="mb10 mt10"><a href='<?php echo $v->url?>' target="_blank"><img src="<?php echo ImageTools::fixImage($v->image,220,160) ?>"></a></div>
        <?php endforeach; ?>
        <ul class="stext-list fs14">
            <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syrmzxlpcpwzlb', 5)->normal()->findAll() as $v) : ?>
                <li><a href='<?php echo $v->url?>' target="_blank"><?php echo $v->title ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="blank10"></div>
<?php
$syxf = RecomCateExt::model()->find(array('select'=>'id,status','condition'=>'pinyin = :pinyin','params'=>array(':pinyin'=>'syxf')));
if($syxf->status == 1){
?>
<div class="wapper">
    <div class="title-box clearfix">
        <a href="<?php echo $this->createUrl('/home/plot/list');?>" target="_blank"><p class="fr c-g6 fs14 mt10"><?php echo $this->siteConfig['siteName']?>新房频道，汇集最新<?php echo $this->siteConfig['cityName']?>楼盘信息</p></a>
        <div class="fl">
            <h2 class="fl">新房</h2>
            <ul class="s-tab fl ml20 fs14">
                <?php
                    $syxfs = RecomCateExt::model()->findAll(array('condition'=>'parent = :parent','params'=>array(':parent'=>$syxf->id)));
                    foreach($syxfs as $v){
                        if($v->pinyin == 'syxfrmlp' && $v->whetherStatus()){
                        ?>
                            <li class="active">热门楼盘</li>
                        <?php
                        }
                        if($v->pinyin == 'syxfzxkp' && $v->whetherStatus()){
                        ?>
                           <li>最新开盘</li>
                        <?php
                        }
                        if($v->pinyin == 'syxfgxlp' && $v->whetherStatus()){
                        ?>
                            <li>刚需楼盘</li>
                        <?php
                        }
                        if($v->pinyin == 'syxfhftj' && $v->whetherStatus()) {
                        ?>
                            <li>婚房推荐</li>
                        <?php
                        }
                        if($v->pinyin == 'syxfxqf' && $v->whetherStatus()) {
                        ?>
                            <li>邻校房</li>
                        <?php
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="l-content">
        <?php
        foreach($syxfs as $v){
            if($v->pinyin == 'syxfrmlp' && $v->whetherStatus()){
                ?>
                <ul class="tab-content clearfix" style="display: block;">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfrmlp', 8)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank"><img  class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,200,145) ?>"><p class="fs16"><?php echo Tools::u8_title_substr($n->plot->title, 15) ?><span class="fr fs14 c-g9"><?php echo Tools::u8_title_substr($n->plot->areaInfo->name, 15) ?></span></p><p class="c-g9 fs14"><?php echo Tools::u8_title_substr($n->title, 15) ?></p><p class="c-red fs14"><?php if($n->plot->price): ?><span class="mt5 c-g9"><?php echo PlotPriceExt::$mark[$n->plot->price_mark]; ?>：</span><?php endif;echo PlotPriceExt::getPrice($n->plot->price,$n->plot->unit)?></p></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfzxkp' && $v->whetherStatus()){
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfzxkp', 8)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank"><img class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,200,145) ?>"><p class="fs16"><?php echo Tools::u8_title_substr($n->plot->title, 15) ?><span class="fr fs14 c-g9"><?php echo Tools::u8_title_substr($n->plot->areaInfo->name, 15) ?></span></p><p class="c-g9 fs14"><?php echo Tools::u8_title_substr($n->title, 15) ?></p></p><p class="c-red fs14"><?php if($n->plot->price): ?><span class="mt5 c-g9"><?php echo PlotPriceExt::$mark[$n->plot->price_mark]; ?>：</span><?php endif;echo PlotPriceExt::getPrice($n->plot->price,$n->plot->unit)?></p></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfgxlp' && $v->whetherStatus()){
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfgxlp', 8)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank"><img class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,200,145) ?>"><p class="fs16"><?php echo Tools::u8_title_substr($n->plot->title, 15) ?><span class="fr fs14 c-g9"><?php echo Tools::u8_title_substr($n->plot->areaInfo->name, 15) ?></span></p><p class="c-g9 fs14"><?php echo Tools::u8_title_substr($n->title, 15) ?></p></p><p class="c-red fs14"><?php if($n->plot->price): ?><span class="mt5 c-g9"><?php echo PlotPriceExt::$mark[$n->plot->price_mark]; ?>：</span><?php endif;echo PlotPriceExt::getPrice($n->plot->price,$n->plot->unit)?></p></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfhftj' && $v->whetherStatus()) {
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfhftj', 8)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank"><img  class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,200,145) ?>"><p class="fs16"><?php echo Tools::u8_title_substr($n->plot->title, 15) ?><span class="fr fs14 c-g9"><?php echo Tools::u8_title_substr($n->plot->areaInfo->name, 15) ?></span></p><p class="c-g9 fs14"><?php echo Tools::u8_title_substr($n->title, 15) ?></p></p><p class="c-red fs14"><?php if($n->plot->price): ?><span class="mt5 c-g9"><?php echo PlotPriceExt::$mark[$n->plot->price_mark]; ?>：</span><?php endif;echo PlotPriceExt::getPrice($n->plot->price,$n->plot->unit)?></p></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfxqf' && $v->whetherStatus()) {
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach(RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfxqf', 8)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank"><img  class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,200,145) ?>"><p class="fs16"><?php echo Tools::u8_title_substr($n->plot->title, 15) ?><span class="fr fs14 c-g9"><?php echo Tools::u8_title_substr($n->plot->areaInfo->name, 15) ?></span></p><p class="c-g9 fs14"><?php echo Tools::u8_title_substr($n->title, 15) ?></p></p><p class="c-red fs14"><?php if($n->plot->price): ?><span class="mt5 c-g9"><?php echo PlotPriceExt::$mark[$n->plot->price_mark]; ?>：</span><?php endif;echo PlotPriceExt::getPrice($n->plot->price,$n->plot->unit)?></p></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
        }
        ?>
    </div>
    <div class="r-box">
        <div class="fs18 c-g3">最新开盘</div>
        <ul class="fs14 mt5 news-list clearfix">
            <?php foreach(PlotExt::model()->normal()->isNew()->findAll(array('condition'=>'open_time <= :open_time','params'=>array(':open_time'=>time()),'limit'=>10,'order'=>'open_time DESC')) as $v):?>
                <li><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin));?>" target="_blank" class="c-g6"><span class="fr c-g9 fs12"><?php echo PlotPriceExt::getPrice($v->price,$v->unit)?></span><?php echo $v->title?></a></li>
            <?php endforeach;?>
        </ul>
        <div class="right-ad mt5">
            <?php foreach(RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxkpggw', 1)->findAll() as $v): ?>
            <a href="<?php echo $v->url; ?>" target="_blank"><img src="<?php echo ImageTools::fixImage($v->image, 220, 90); ?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php }?>
<div class="blank10"></div>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'syesfsb']); ?>

<?php
$esfZf = $this->getEsfZf();
if($esfZf['esf']||$esfZf['zf']):
 ?>
<div class="wapper">
    <div class="title-box clearfix">
        <a href="<?php echo $this->siteConfig["esfUrl"];?>" target="_blank"><p class="fr c-g6 fs14 mt10"><?php echo $this->siteConfig['siteName']?>二手房频道，汇集最新<?php echo $this->siteConfig['cityName']?>楼盘信息</p></a>
        <div class="fl">
            <h2 class="fl">二手房&nbsp;|&nbsp;租房</h2>
        </div>
    </div>
    <div class="l-content">
        <div class="w425 mr20">
            <div class="border">
                <div class="title_ershou"><a href="<?php echo $this->siteConfig['esfUrl']; ?>" target="_blank" class="fr gc6">更多&gt;&gt;</a><span class="bigfs c-red fs14">二手房</span></div>
                <ul class="se_house_list">
                    <?php foreach($esfZf['esf'] as $v): ?>
                    <li><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['plotName']; ?></a><span class="huxing"><?php echo $v['bedRoom']; ?>室<?php echo $v['livingRoom']; ?>厅</span><span class="price"><?php echo $v['price']; ?>万元</span><span class="area"><?php echo $v['size']; ?>㎡</span></li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
        <div class="w425">

            <div class="border">
                <div class="title_ershou"><a href="<?php echo $this->siteConfig['zfUrl']; ?>" target="_blank" class="fr gc6">更多&gt;&gt;</a><span class="bigfs red_link fs14">租房</span></div>
                <ul class="se_house_list">
                    <?php foreach($esfZf['zf'] as $v): ?>
                    <li><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['plotName']; ?></a><span class="huxing"><?php echo $v['bedRoom']; ?>室<?php echo $v['livingRoom']; ?>厅</span><span class="price"><?php echo $v['price'] ? $v['price'] : '面议'; ?>元/月</span><span class="area"><?php echo $v['size']; ?>㎡</span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="r-box">
        <div class="fs18 c-g3">最新二手房</div>
        <ul class="fs14 mt5 news-list clearfix">
            <?php foreach($this->getNewEsf() as $v): ?>
                <li><a href="<?php echo $v['url']; ?>" target="_blank" class="c-g6"><span class="fr c-g9 fs12"><?php echo $v['price']; ?>万/<?php echo $v['size']; ?>㎡</span><?php echo $v['plot']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="right-ad mt5">
            <?php foreach(RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxesfggw', 1)->findAll() as $v): ?>
            <a href="<?php echo $v->url; ?>" target="_blank"><img  class="lazy" data-original="<?php echo ImageTools::fixImage($v->image, 226, 90); ?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="blank10"></div>
<?php
    endif;
    $zcwzlb = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2zcwzlb', 8)->normal()->findAll();
    $zjtwlb = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2zjtwlb', 3)->normal()->findAll();
    $ycdtw = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2ycdtw', 1)->normal()->find();
    if($zcwzlb || $zjtwlb || $ycdtw):
?>
<div class="wapper">
    <div class="l-content">
        <div class="w350 mr40">
            <div class="title-box clearfix">
                <h2 class="fl"><?php $syzxmk2zcwzlb = RecomCateExt::model()->getByPinyin('syzxmk2zcwzlb')->find(); echo $syzxmk2zcwzlb?$syzxmk2zcwzlb->name:'';?></h2>
            </div>
            <ul class="loushi-list fs16 clearfix">
                <?php foreach($zcwzlb as $v):?>
                    <li><a href="<?php echo $v->url;?>" target="_blank"><?php echo $v->title;?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="w475">
            <div class="title-box clearfix">
                <h2 class="fl"><?php $syzxmk2zjtwlb = RecomCateExt::model()->getByPinyin('syzxmk2zjtwlb')->find(); echo $syzxmk2zjtwlb?$syzxmk2zjtwlb->name:'';?></h2>
            </div>
            <div class="daogou-list">
                <?php foreach($zjtwlb as $v):?>
                    <dl class="clearfix">
                        <dt><a href="<?php echo $v->url ? $v->url : 'javascript:'?>" target="_blank"><img src="<?php echo ImageTools::fixImage($v->image, 200, 145); ?>"></a></dt>
                        <dd><a href="<?php echo $v->url ? $v->url : 'javascript:'?>" target="_blank" class="fs18 c-g3"><?php echo Tools::u8_title_substr($v->title,30);?></a>
                            <p class="fs14 c-g6"><?php echo Tools::u8_title_substr($v->description,75);?><a href="<?php echo $v->url ? $v->url : 'javascript:';?>" target="_blank" class="c-red">[详情]</a></p>
                        </dd>
                    </dl>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="r-box h322">
        <div class="fs18 c-g3">
            <?php $syzxmk2ycdtw = RecomCateExt::model()->getByPinyin('syzxmk2ycdtw')->find(); echo $syzxmk2ycdtw?$syzxmk2ycdtw->name:'';?>
        </div>
        <?php if($ycdtw):?>
            <div class="mb10 mt10">
                <img src="<?php echo ImageTools::fixImage($ycdtw->image, 220, 145); ?>">
            </div>
            <p class="c-g9 fs14"><?php echo Tools::utf8substr($ycdtw->description,0,290);?><a href="<?php echo $ycdtw->url;?>" target="_blank" class="c-red">[详情]</a></p>
        <?php endif;?>
    </div>
</div>
<div class="blank10"></div>
<?php
    endif;
    $yzxq = RecomExt::model()->getByStationId($this->substationId)->getRecom('syyzxq', 30)->normal()->findAll();
    if($yzxq):
 ?>
<div class="wapper">
    <div class="title-box clearfix">
        <a href="<?php echo $this->siteConfig['bbsPlotPageUrl']; ?>" target="_black" class="fr c-g9 fs14 mt10">更多业主小区&gt;&gt;</a>
        <h2 class="fl">业主小区</h2>
    </div>
    <div class="yezhuxiaoqu fs14">
        <?php foreach($yzxq as $v):?>
            <ul>
                <li>
                    <a href="<?php echo $v->url;?>" target="_blank" title="<?php echo $v->plot->areaInfo->name;?>">[<?php echo $v->plot->areaInfo->name;?>]<?php echo $v->plot->title;?></a>
                </li>
            </ul>
        <?php endforeach;?>
    </div>
</div>
<div class="blank10"></div>
<?php endif; ?>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'syhzsjsb']); ?>
<div class="wapper">
    <div class="title-box clearfix">
        <a href="javascript:;" class="fr c-g9 fs14 mt10">合作商家广告投放热线：<?php echo $this->siteConfig['sitePhone']; ?></a>
        <h2 class="fl">合作商家</h2>
    </div>

    <ul class="cooperate clearfix">
        <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syhzsj', 50)->normal()->findAll(array('order'=>'sort desc')) as $v):?>
            <li>
                <a href="<?php echo $v->url?>" target="_blank">
                    <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image,150,60)?>">
                </a>
            </li>
        <?php endforeach;?>

    </ul>
    <div class="blank10"></div>
    <div class="title-box clearfix">
        <h2 class="fl">友情链接</h2>
    </div>
    <div class="partner clearfix fs12">
        <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syyqlj')->normal()->findAll(array('order'=>'sort desc','limit'=>100)) as $v):?>
            <a href="<?php echo $v->url?>" title="<?php echo $v->title?>" target="_blank"><?php echo $v->title?></a>
        <?php endforeach;?>
    </div>
</div>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'sydl']); ?>
<?php $this->endCache();endif; ?>
