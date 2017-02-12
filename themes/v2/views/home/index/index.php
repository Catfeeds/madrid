<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/index.css');
$this->pageTitle = SM::seoConfig()->homeIndexIndex()['title'] ? SM::seoConfig()->homeIndexIndex()['title'] : (SM::urmConfig()->cityName().'房地产门户_'.SM::urmConfig()->cityName().'房产网_'.SM::urmConfig()->cityName().'房产信息网-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName());

 Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['keyword']?SM::seoConfig()->homeIndexIndex()['keyword']:(SM::urmConfig()->cityName().'房地产门户，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房地信息网，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'房地产网，'.SM::urmConfig()->cityName().'房屋出租，'.SM::GlobalConfig()->siteName().'房产'),'keywords');

 Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['desc']?SM::seoConfig()->homeIndexIndex()['desc']:(SM::GlobalConfig()->siteName().'房产网是'.SM::urmConfig()->cityName().'热门专业的网络房产平台，提供全面及时的'.SM::urmConfig()->cityName().'房产楼市资讯，'.SM::urmConfig()->cityName().'房产楼盘信息、近期'.SM::urmConfig()->cityName().'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.SM::urmConfig()->cityName().'房产近期优惠信息就上'.SM::GlobalConfig()->siteName().'房产网'),'description');
?>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'sydbtl']); ?>
<?php if($this->startCache($this->getCacheId(), ['duration'=>1800], ['home/index/active'])): ?>
<?php
    $sytwlh=RecomCateExt::model()->getByPinyin('sytwlh')->find();
    if($sytwlh&&$sytwlh->status==1){
?>
<div class="wapperout">
    <div class="banner">
        <div id="slider">
            <ul class="slider bd">
                <?php foreach ((RecomExt::model()->getByStationId($this->substationId)->getRecom('sytwlh', 4)->findAll()) as $v) : ?>
                    <li>
                        <a href="<?php echo $v->url?>" target="_blank" style="background:url(<?php echo ImageTools::fixImage($v->image,1920,330)?>) no-repeat center;"></a>
                        <?php if($v->isAd): ?><div class="ad-label"><span class="ad-big"></span></div><?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="hd"><ul></ul></div>
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
<?php }?>
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
        <?php $i = 1;foreach($this->siteTag as $v):if($v->cate == 'xinfangjiage' && $i <= 6):$i++;?>
                <a href="<?php echo $this->createUrl('/home/plot/list',['ext'=>'p'.$v->id]+($this->substationId?['place'=>$this->substationId]:[]))?>" title="<?php echo $v->name;?>" target="_blank"><?php echo $v->name;?></a>
        <?php endif;endforeach;?>
        </dd>
    </dl>
    <dl class="purple">
        <dt class="fs16 purple">户型</dt>
        <dd class="clearfix">
            <?php $i = 1;foreach($this->siteTag as $v):if($v->cate == 'xinfanghuxing' && $i <= 6):$i++;?>
                <a href="<?php echo $this->createUrl('/home/plot/list',['ext'=>'h'.$v->id]+($this->substationId?['place'=>$this->substationId]:[])); ?>" title="<?php echo $v->name?>" target="_blank"><?php echo $v->name?></a>
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
    <?php if(SM::specialConfig()->enable() && $tejiafang = PlotSpecialExt::model()->normal()->recommend()->noExpire()->findAll()): ?>
    <div class="title-box clearfix">
        <a href="<?php echo $this->createUrl('/home/special/trade')?>" target="_blank" class="fr c-g9 fs14 mt10">更多&gt;</a>
        <h2 class="fl">特价房</h2>
        <p class="fl ml10 mt10 fs14 c-g6"><?php echo SM::GlobalConfig()->siteName()?>特价房频道，汇集<?php echo SM::urmConfig()->cityName()?>高性价比楼盘</p>
    </div>
    <div class="special-price-list">
        <ul class="clearfix">
            <?php foreach ($tejiafang as $v): ?>
                <li>
                    <div class="box-a"><span class="group-icon">劲省<br><?php echo round(($v->price_old) - ($v->price_new),2) ?>万</span><span class="ad-lab"></span>
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">
                            <img src="<?php echo ImageTools::fixImage($v->image,270,200) ?>">
                            <div class="layertxt"><?php echo $v->plot->title?></div>
                            <div class="layerbg"></div>
                        </a>
                    </div>
                    <div class="box-b">
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank" class="c-sred fs18"><i class="group-icon icon-hongbao"></i><?php echo Tools::utf8substr($v->title,0,32);?></a>
                        <!--<p class="c-g6 fs14"><span class="mr10"><?php echo $v->bed_room ?> <?php echo $v->size ?>m<sup>2</sup></span><span><?php echo (isset($this->siteArea[$v->plot->area])&&!empty($this->siteArea[$v->plot->area])) ? ($this->siteArea[$v->plot->area].((isset($this->siteStreet[$v->plot->area])&&!empty($this->siteStreet[$v->plot->area])) ? ((isset($this->siteStreet[$v->plot->area][$v->plot->street])&&!empty($this->siteStreet[$v->plot->area][$v->plot->street])) ? '/'.$this->siteStreet[$v->plot->area][$v->plot->street] : '') :'' )) : '';?></span></p>-->
                        <p class="c-g6 fs14">
                            <?php if($v->htid):?>
                                <span class="mr10">
                                <?=$v->houseType->bedroom;?>室<?=$v->houseType->livingroom;?>厅<?=$v->houseType->bathroom;?>卫<?php echo $v->houseType->size ?>m<sup>2</sup>
                            </span>
                            <?php endif;?>
                            <span><?php echo (isset($this->siteArea[$v->plot->area])&&!empty($this->siteArea[$v->plot->area])) ? ($this->siteArea[$v->plot->area].((isset($this->siteStreet[$v->plot->area])&&!empty($this->siteStreet[$v->plot->area])) ? ((isset($this->siteStreet[$v->plot->area][$v->plot->street])&&!empty($this->siteStreet[$v->plot->area][$v->plot->street])) ? '/'.$this->siteStreet[$v->plot->area][$v->plot->street] : '') :'' )) : '';?></span>
                        </p>
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
    <?php if(SM::tuanConfig()->enable()): ?>
    <?php $tuanNum = PlotTuanExt::model()->normal()->noExpire()->recommend()->count(); if(!empty($tuanNum)):?>
    <div class="title-box clearfix">
        <a href="<?php echo $this->createUrl('/home/special/tuan')?>" target="_blank" class="fr c-g9 fs14 mt10">更多&gt;</a>
        <h2 class="fl"><?php echo $this->t('特惠团'); ?></h2>
        <p class="fl ml10 mt10 fs14 c-g6"><?php echo SM::GlobalConfig()->siteName()?>优惠频道，汇聚<?php echo SM::urmConfig()->cityName()?>新楼盘优惠</p>
    </div>
    <ul class="pic-list more-pic">
        <?php foreach (PlotTuanExt::model()->normal()->noExpire()->recommend()->findAll(array('limit' => 8, 'order' => 'sort DESC,created DESC')) as $v) : ?>
        <li>
            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">
                <div class="pic-img"><img class="lazy" data-original="<?php echo ImageTools::fixImage($v->pc_img,270,164) ?>" ><?php if($v->hongbao): ?><span class="group-icon icon-hongbao"><?php echo $v->hongbao;?></span><?php endif; ?><span class="ad-lab"></span></div>
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
<?php $this->widget('AdWidget',['position'=>'syyxjfc']); ?>
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
            <a href="<?php echo $v->url?>" target="_blank" class="c-g6 mb15"><?php if($v->isAd): ?><span class="ad-lab"></span><?php endif; ?><img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image,200,145) ?>"><?php echo $v->title ?></a>
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
            <div class="mb10 mt10 ad-box"><a href='<?php echo $v->url?>' target="_blank"><img src="<?php echo ImageTools::fixImage($v->image,220,160) ?>"></a><?php if($v->isAd): ?><span class="ad-lab"></span><?php endif; ?></div>
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
    $activity=RecomExt::model()->getByStationId($this->substationId)->getRecom('syjchd',6)->normal()->findAll();
    if(count($activity)>0):
?>
<div class="wapper">
        <div class="new-left">
            <div class="title-box">
                <h2>精彩活动</h2>
            </div>
            <ul class="active-list clearfix">
                <?php foreach($activity as $k=>$v):?>
                <li>
                    <a href="<?php echo $v->url?>" target="_blank">
                        <div class="pic"> <img src="<?php echo ImageTools::fixImage($v->image, 225, 160); ?>"></div>
                        <div class="info">
                            <div class="detail">
                                <strong><?php echo $v->title?></strong>
                                <p><?php echo $v->s_title?></p>
                            </div>
                            <div class="join">我要参与</div>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="new-right">
            <?php $monthDayPlots=$this->getMonthDayPlots()?>
            <div class="title-box">
                <h2>开盘日历 • 活动预告</h2>
            </div>
            <div class="date-content">
                <div class="month-tab">
                    <em><?php echo date('Y')?></em>
                    <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
                    <span class="arrow"><a class="prev-month"></a></span>
                    <div class="month-list">
                        <ul class="month" style="margin-left: -192px;">
                            <li class="">1月</li>
                            <li class="">2月</li>
                            <li class="">3月</li>
                            <li class="">4月</li>
                            <li class="">5月</li>
                            <li class="on">6月</li>
                            <li class="">7月</li>
                            <li class="">8月</li>
                            <li class="">9月</li>
                            <li class="">10月</li>
                            <li class="">11月</li>
                            <li class="">12月</li>
                        </ul>
                    </div>
                    <span class="arrow"><a class="next-month"></a></span>
                </div>
                <?php for($i=1;$i<=12;$i++):?>
                <div class="detail-content dn">
                    <?php if(array_key_exists($i,$monthDayPlots)):?>
                    <ul>
                        <?php foreach($monthDayPlots[$i] as $k=>$v):?>
                        <li>
                            <?php
                            //按hid分类
                            $hidPlots=array();
                            foreach($v as $kk=>$vv){
                                if(array_key_exists($vv->hid,$hidPlots)){
                                    $hidPlots[$vv->hid]=$hidPlots[$vv->hid].'、'.$vv->name;
                                }
                                else
                                    $hidPlots[$vv->hid]=$vv->name;
                            }
                            foreach($hidPlots as $key=>$value){
                                $plot=PlotExt::model()->findByPk($key,'deleted=0 and status=1');
                                if(!$plot) continue;
                            ?>
                            <span class="date"><?php echo $i.'月'.$k.'日'?></span>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plot->pinyin));?>" target="_blank"><?php echo $plot->title.$value.'开盘'?>
                                <?php if($plot->discount):?>
                                    <span style="display: inline;font-weight: normal">(<?=$plot->discount->title;?>)</span>
                                <?php endif;?>
                            </a>
                            <?php }?>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                </div>
                <?php endfor;?>
            </div>
        </div>

    </div>
<?php endif;?>
<?php
$syxf = RecomCateExt::model()->find(array('select'=>'id,status','condition'=>'pinyin = :pinyin','params'=>array(':pinyin'=>'syxf')));
if($syxf->status == 1){
?>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'syxfsb']); ?>
<div class="wapper">
    <div class="title-box clearfix">
        <a href="<?php echo $this->createUrl('/home/plot/list');?>" target="_blank"><p class="fr c-g6 fs14 mt10"><?php echo SM::GlobalConfig()->siteName()?>新房频道，汇集近期<?php echo SM::urmConfig()->cityName()?>楼盘信息</p></a>
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
                           <li>近期开盘</li>
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
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfrmlp', 6)->findAll() as $n): ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank">
                                <div class="pic">
                                    <?php if($n->isAd): ?><span class="ad-lab"></span><?php endif; ?>
                                    <img src="" class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,275,200) ?>">
                                    <div class="layerbg"></div>
                                    <div class="layertxt"><?=$n->plot->title.($n->plot->areaInfo?'['.$n->plot->areaInfo->name.']':''); ?></div>
                                </div>
                            </a>
                            <p class="fs14 price"><span class="fs18 fw c-red mr5"><?=($n->plot->price?$n->plot->price:'暂无'); ?></span><?php echo $n->plot->price?PlotPriceExt::$unit[$n->plot->unit]:''; if($n->plot&&$n->plot->red): ?><span class="fr c-red"><?= $n->plot->red->title; ?></span><?php endif; ?></p>
                            <p class="address"><?=$n->title; ?></p>
                            <?php if($n->plot->xmts): ?>
                            <p class="label">
                                <?php
                                    foreach($n->plot->xmts as $kxmts=>$xmts):
                                        if($kxmts<3):
                                ?>
                                <span><?=$xmts->name; ?></span>
                                <?php endif;endforeach; ?>
                            </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfzxkp' && $v->whetherStatus()){
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfzxkp', 6)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank">
                                <div class="pic">
                                    <?php if($n->isAd): ?><span class="ad-lab"></span><?php endif; ?>
                                    <img src="" class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,275,200) ?>">
                                    <div class="layerbg"></div>
                                    <div class="layertxt"><?=$n->plot->title.($n->plot->areaInfo?'['.$n->plot->areaInfo->name.']':''); ?></div>
                                </div>
                            </a>
                            <p class="fs14 price"><span class="fs18 fw c-red mr5"><?=($n->plot->price?$n->plot->price:'暂无'); ?></span><?php echo $n->plot->price?PlotPriceExt::$unit[$n->plot->unit]:''; if($n->plot&&$n->plot->red): ?><span class="fr c-red"><?= $n->plot->red->title; ?></span><?php endif; ?></p>
                            <p class="address"><?=$n->title; ?></p>
                            <?php if($n->plot->xmts): ?>
                            <p class="label">
                                <?php
                                    foreach($n->plot->xmts as $kxmts=>$xmts):
                                        if($kxmts<3):
                                ?>
                                <span><?=$xmts->name; ?></span>
                                <?php endif;endforeach; ?>
                            </p>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfgxlp' && $v->whetherStatus()){
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfgxlp', 6)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank">
                                <div class="pic">
                                    <?php if($n->isAd): ?><span class="ad-lab"></span><?php endif; ?>
                                    <img src="" class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,275,200) ?>">
                                    <div class="layerbg"></div>
                                    <div class="layertxt"><?=$n->plot->title.($n->plot->areaInfo?'['.$n->plot->areaInfo->name.']':''); ?></div>
                                </div>
                            </a>
                            <p class="fs14 price"><span class="fs18 fw c-red mr5"><?=($n->plot->price?$n->plot->price:'暂无'); ?></span><?php echo $n->plot->price?PlotPriceExt::$unit[$n->plot->unit]:''; if($n->plot&&$n->plot->red): ?><span class="fr c-red"><?= $n->plot->red->title; ?></span><?php endif; ?></p>
                            <p class="address"><?=$n->title; ?></p>
                            <?php if($n->plot->xmts): ?>
                            <p class="label">
                                <?php
                                    foreach($n->plot->xmts as $kxmts=>$xmts):
                                        if($kxmts<3):
                                ?>
                                <span><?=$xmts->name; ?></span>
                                <?php endif;endforeach; ?>
                            </p>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfhftj' && $v->whetherStatus()) {
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach (RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfhftj', 6)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank">
                                <div class="pic">
                                    <?php if($n->isAd): ?><span class="ad-lab"></span><?php endif; ?>
                                    <img src="" class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,275,200) ?>">
                                    <div class="layerbg"></div>
                                    <div class="layertxt"><?=$n->plot->title.($n->plot->areaInfo?'['.$n->plot->areaInfo->name.']':''); ?></div>
                                </div>
                            </a>
                            <p class="fs14 price"><span class="fs18 fw c-red mr5"><?=($n->plot->price?$n->plot->price:'暂无'); ?></span><?php echo $n->plot->price?PlotPriceExt::$unit[$n->plot->unit]:''; if($n->plot&&$n->plot->red): ?><span class="fr c-red"><?= $n->plot->red->title; ?></span><?php endif; ?></p>
                            <p class="address"><?=$n->title; ?></p>
                            <?php if($n->plot->xmts): ?>
                            <p class="label">
                                <?php
                                    foreach($n->plot->xmts as $kxmts=>$xmts):
                                        if($kxmts<3):
                                ?>
                                <span><?=$xmts->name; ?></span>
                                <?php endif;endforeach; ?>
                            </p>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
            if($v->pinyin == 'syxfxqf' && $v->whetherStatus()) {
                ?>
                <ul class="tab-content clearfix">
                    <?php foreach(RecomExt::model()->getByStationId($this->substationId)->getRecom('syxfxqf', 6)->findAll() as $n) { ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->plot->pinyin));?>" target="_blank">
                                <div class="pic">
                                    <?php if($n->isAd): ?><span class="ad-lab"></span><?php endif; ?>
                                    <img src="" class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,275,200) ?>">
                                    <div class="layerbg"></div>
                                    <div class="layertxt"><?=$n->plot->title.($n->plot->areaInfo?'['.$n->plot->areaInfo->name.']':''); ?></div>
                                </div>
                            </a>
                            <p class="fs14 price"><span class="fs18 fw c-red mr5"><?=($n->plot->price?$n->plot->price:'暂无'); ?></span><?php echo $n->plot->price?PlotPriceExt::$unit[$n->plot->unit]:''; if($n->plot&&$n->plot->red): ?><span class="fr c-red"><?= $n->plot->red->title; ?></span><?php endif; ?></p>
                            <p class="address"><?=$n->title; ?></p>
                            <?php if($n->plot->xmts): ?>
                            <p class="label">
                                <?php
                                    foreach($n->plot->xmts as $kxmts=>$xmts):
                                        if($kxmts<3):
                                ?>
                                <span><?=$xmts->name; ?></span>
                                <?php endif;endforeach; ?>
                            </p>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php
            }
        }
        ?>
    </div>
    <div class="r-box">
        <div class="fs18 c-g3">近期开盘</div>
        <ul class="fs14 mt5 news-list clearfix">
            <?php foreach(PlotExt::model()->normal()->isNew()->findAll(array('condition'=>'open_time <= :open_time','params'=>array(':open_time'=>time()),'limit'=>12,'order'=>'open_time DESC')) as $v):?>
                <li><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin));?>" target="_blank" class="c-g6"><span class="fr c-g9 fs12"><?php echo PlotPriceExt::getPrice($v->price,$v->unit)?></span><?php echo $v->title?></a></li>
            <?php endforeach;?>
        </ul>
        <div class="ad-box mt25">

            <?php foreach(RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxkpggw', 1)->findAll() as $v): ?>
            <?php if($v->isAd): ?><span class="ad-lab"></span><?php endif; ?>
            <a href="<?php echo $v->url; ?>" target="_blank"><img src="<?php echo ImageTools::fixImage($v->image, 220, 90); ?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php }?>
<div class="blank10"></div>
<?php if(SM::adviserConfig()->enable()&&$jpfxs = StaffExt::model()->recommend()->normal()->findAll(['limit'=>2])): ?>
<!-- 金牌分析师begin -->
<div class="wapper">
    <div class="title-box clearfix">
        <div class="fl">
            <h2 class="fl">金牌分析师</h2>
        </div>
    </div>
    <?php
        foreach($jpfxs as $k=>$staff):
            if($k<2):
    ?>
        <div class="analyst-box <?=$k==0?'mr50':''; ?>">
            <div class="teacher-box clearfix">
                <div class="pic"><img src="<?=ImageTools::fixImage($staff->avatar,100,100); ?>"></div>
                <div class="detail-r">
                    <p class="fl"><span class="name"><?=$staff->name; ?></span><span class="items"><?php if($staff->job): ?><i class="iconfont v-ico">&#x5364;</i><?=$staff->job; ?></span><?php endif; ?></p>
                    <div class="fr">
                        <?php if($staff->qq): ?>
                        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$staff->qq; ?>&site=qq&menu=yes" class="items fl" target="_blank"><i class="iconfont qq-ico">&#x1568;</i>在线咨询</a>
                        <?php endif; ?>
                        <?php if($staff->wx_image): ?>
                        <a href="javascript:void(0);" class="items weixinex fr"><i class="iconfont weixin-ico">&#x1444;</i>微信联系
                            <div class="weixin-box">
                                <div class="pr">
                                    <span class="top-arrow"><span></span></span>
                                    <div class="weixin-pop-box">
                                        <p>微信联系，更便捷哦</p>
                                        <img src="<?=ImageTools::fixImage($staff->wx_image); ?>">
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                    </div>
                    <div class="clear"></div>
                    <p class="info"><?=$staff->introduction; ?></p>
                </div>
            </div>
            <div class="dianping">
                <p class="fs12">他点评的楼盘</p>
                <ul>
                    <?php foreach(PlotCommentExt::model()->findAllBySid($staff->id, ['order'=>'t.created desc','limit'=>3,'with'=>['plot']]) as $v): ?>
                    <li>
                        <a href="<?=$this->createUrl('/home/plot/index',['py'=>$v->plot->pinyin]); ?>" target="_blank">
                            <div class="picimg">
                                <span class="ad-lab"></span>
                                <img src="<?=ImageTools::fixImage($v->plot->image,275,200); ?>">
                                <div class="layerbg"></div>
                                <div class="layertxt"><?=$v->plot->title.($v->plot->areaInfo?' ['.$v->plot->areaInfo->name.']':''); ?></div>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif;endforeach; ?>
</div>
<!-- 金牌分析师end -->
<?php endif ?>
<?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'syesfsb']); ?>
<?php
if(SM::plotConfig()->enableHomeIndexIndexRank()&&$topPlots=$this->getTopList()):
?>
<div class="wapper">
        <div class="title-box">
            <h2>房地产排行榜</h2>
        </div>
        <div class="rank-content mr25">
            <div class="ss-title">
                <span><?php echo SM::urmConfig()->cityName();?>热门楼盘</span>
            </div>
            <ul>
                <?php foreach($topPlots['topHot'] as $k=>$v):?>
                <li>
                    <span class="num <?php if($k<3) echo 'top3'?>"><?php echo $k+1?></span>
                    <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin));?>" target="_blank"><?php echo $v->title?></a></span>
                    <span class="price"><?php echo $v->price>0 ? $v->price.PlotPriceExt::$unit[$v->unit] : '待定';?></span>
                    <span class="rt"><?php echo $v->views;?></span>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="rank-content mr25">
            <div class="ss-title">
                <span><?php echo SM::urmConfig()->cityName();?>最新楼盘</span>
            </div>
            <ul>
                <?php foreach($topPlots['topNew'] as $k=>$v):?>
                <li>
                    <span class="num <?php if($k<3) echo 'top3'?>"><?php echo $k+1?></span>
                    <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin));?>" target="_blank"><?php echo $v->title?></a></span>
                    <span class="price"><?php echo $v->price>0 ? $v->price.PlotPriceExt::$unit[$v->unit] : '待定'; ?></span>
                    <span class="rt"><?php echo $v->views;?></span>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="rank-content">
            <div class="ss-title">
                <span>热门团购楼盘</span>
            </div>
            <ul>
                <?php foreach($topPlots['topTuan'] as $k=>$v):?>
                    <li>
                        <span class="num <?php if($k<3) echo 'top3'?>"><?php echo $k+1?></span>
                        <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin));?>" target="_blank"><?php echo $v->plot->title;?></a></span>
                        <span class="price"><?php echo $v->plot->price>0?$v->plot->price.PlotPriceExt::$unit[$v->plot->unit]:'待定';?></span>
                        <span class="rt"><?php echo $v->plot->views;?></span>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php endif;?>
<?php
if(SM::GlobalConfig()->enableIndexEsfList()):
$esfZf = $this->getEsfZf();
if($esfZf['esf']||$esfZf['zf']):
 ?>
<div class="wapper">
    <div class="title-box clearfix">
        <a href="<?php echo SM::pageUrlConfig()->esfListUrl();?>" target="_blank"><p class="fr c-g6 fs14 mt10"><?php echo SM::GlobalConfig()->siteName()?>二手房频道，汇集新近<?php echo SM::urmConfig()->cityName()?>楼盘信息</p></a>
        <div class="fl">
            <h2 class="fl">二手房&nbsp;|&nbsp;租房</h2>
        </div>
    </div>
    <div class="l-content">
        <div class="w425 mr20">
            <div class="border">
                <div class="title_ershou"><a href="<?php echo SM::pageUrlConfig()->esfListUrl(); ?>" target="_blank" class="fr gc6">更多&gt;&gt;</a><span class="bigfs c-red fs14">二手房</span></div>
                <ul class="se_house_list">
                    <?php foreach($esfZf['esf'] as $v): ?>
                    <li><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['plotName']; ?></a><span class="huxing"><?=$v['room']; ?></span><span class="price"><?php echo $v['price'] ? $v['price'].'万元' : '面议'; ?></span><span class="area"><?php echo $v['size']; ?>㎡</span></li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
        <div class="w425">

            <div class="border">
                <div class="title_ershou"><a href="<?php echo SM::pageUrlConfig()->zfListUrl(); ?>" target="_blank" class="fr gc6">更多&gt;&gt;</a><span class="bigfs red_link fs14">租房</span></div>
                <ul class="se_house_list">
                    <?php foreach($esfZf['zf'] as $v): ?>
                    <li><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['plotName']; ?></a><span class="huxing"><?=$v['room']; ?></span><span class="price"><?php echo $v['price'] ? $v['price'].'元/月' : '面议'; ?></span><span class="area"><?php echo $v['size']; ?>㎡</span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="r-box">
        <div class="fs18 c-g3">新近二手房</div>
        <ul class="fs14 mt5 news-list clearfix">
            <?php foreach($this->getNewEsf() as $v): ?>
                <li><a href="<?php echo $v['url']; ?>" target="_blank" class="c-g6"><span class="fr c-g9 fs12"><?php echo $v['price']>0?((int)$v['price'].'万'):'面议'; ?>/<?php echo $v['size']; ?>㎡</span><?php echo $v['plot']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="ad-box mt5">
            <?php foreach(RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxesfggw', 1)->findAll() as $v): ?>
            <a href="<?php echo $v->url; ?>" target="_blank"><img  class="lazy" data-original="<?php echo ImageTools::fixImage($v->image, 226, 90); ?>"></a>
            <?php if($v->isAd): ?><span class="ad-lab"></span><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="blank10"></div>
<?php
    endif;endif;
    $zcwzlb = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2zcwzlb', 8)->normal()->findAll();
    $zjtwlb = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2zjtwlb', 3)->normal()->findAll();
    $ycdtw = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2ycdtw', 1)->normal()->find();
    if($zcwzlb || $zjtwlb || $ycdtw):
?>
<div class="wapper">
    <div class="l-content">
        <div class="w350 mr40">
            <div class="title-box clearfix">
                <?php if($more = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2zcwzlbmore',1)->normal()->find()): ?>
                <a href="<?=$more->url; ?>" target="_blank" class="fr c-g9 fs14 mt10">更多</a>
                <?php endif; ?>
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
                <?php if($more = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2zjtwlbmore',1)->normal()->find()): ?>
                <a href="<?=$more->url; ?>" target="_blank" class="fr c-g9 fs14 mt10">更多</a>
                <?php endif; ?>
                <h2 class="fl"><?php $syzxmk2zjtwlb = RecomCateExt::model()->getByPinyin('syzxmk2zjtwlb')->find(); echo $syzxmk2zjtwlb?$syzxmk2zjtwlb->name:'';?></h2>
            </div>
            <div class="daogou-list">
                <?php foreach($zjtwlb as $v):?>
                    <dl class="clearfix">
                        <dt>
                            <a href="<?php echo $v->url ? $v->url : 'javascript:'?>" target="_blank"><img src="<?php echo ImageTools::fixImage($v->image, 200, 145); ?>"></a>
                            <?php if($v->isAd): ?><span class="ad-lab"></span><?php endif; ?>
                        </dt>
                        <dd><a href="<?php echo $v->url ? $v->url : 'javascript:'?>" target="_blank" class="fs18 c-g3"><?php echo Tools::u8_title_substr($v->title,30);?></a>
                            <p class="fs14 c-g6"><?php echo Tools::u8_title_substr($v->description,75);?><a href="<?php echo $v->url ? $v->url : 'javascript:';?>" target="_blank" class="c-red">[详情]</a></p>
                        </dd>
                    </dl>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="r-box h322">
        <div class="s-title clearfix">
            <?php if($syzxmk2ycdtw = RecomCateExt::model()->getByPinyin('syzxmk2ycdtw')->find()): ?>
            <span class="fl fs18 c-g3"><?=$syzxmk2ycdtw->name; ?></span>
            <?php endif; ?>
            <?php if($more = RecomExt::model()->getByStationId($this->substationId)->getRecom('syzxmk2ycdtwmore',1)->normal()->find()): ?>
            <a href="<?=$more->url; ?>" target="_blank" class="fs14">更多&gt;&gt;</a>
            <?php endif; ?>
        </div>

        <?php if($ycdtw):?>
            <div class="mb10 mt10 ad-box">
                <img src="<?php echo ImageTools::fixImage($ycdtw->image, 220, 145); ?>">
                <?php if($ycdtw->isAd): ?><span class="ad-lab"></span><?php endif; ?>
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
        <a href="<?php echo SM::pageUrlConfig()->bbsPlotPageUrl(); ?>" target="_black" class="fr c-g9 fs14 mt10">更多业主小区&gt;&gt;</a>
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
        <a href="javascript:;" class="fr c-g9 fs14 mt10">合作商家广告投放热线：<?php echo SM::GlobalConfig()->sitePhone(); ?></a>
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
