<?php
if($this->plot->data_conf['seo_keywords'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_keywords'],'keywords');
else
    Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'价格，'.$this->plot->title.'户型，'.$this->plot->title.'电话，'.$this->plot->title.'环境，'.$this->plot->title.'图片，'.$this->siteConfig['siteName'].'房产','keywords');
if($this->plot->data_conf['seo_description'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_description'],'description');
else
    Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网提供'.$this->plot->title.'售楼电话（'.$this->plot->sale_tel.')、最新房价、地址、交通和周边配套、开盘动态、户型图、实景图等楼盘信息。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main','TouchSlide.1.1']);
?>
<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('list');?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo Tools::utf8substr($this->plot->title,0,28);?></h1>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<!--头部 end-->
<!--楼盘库首页-->
<div class="loupanku loupanku-index">
    <div class="banner" id="j-banner-slide">
        <div class="imgs">
            <ul class="bd">
                <?php
                if(!empty($faceimg)):
                    foreach($faceimg as $k=>$v):
                        ?>
                        <li>
                            <a href="<?php echo $this->createUrl('/wap/plot/album',array('py'=>$this->plot->pinyin,'cid'=>$v->type))?>">
                                <?php echo CHtml::image(ImageTools::fixImage($v->url,'640','425'));?>
                            </a>
                        </li>
                    <?php
                    endforeach;
                else:
                ?>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/plot/album',array('py'=>$this->plot->pinyin))?>">
                        <?php echo CHtml::image(ImageTools::fixImage($this->plot->image,'640','425'));?>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="icons">
            <ul class="hd">
                <?php
                if(!empty($faceimg)):
                    foreach($faceimg as $k=>$v):
                        ?>
                        <li></li>
                    <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
        <div class="num"><i class="icon icon-pic"></i><?php echo $this->plot->imgcount;?>张</div>
    </div>
    <div class="gw">
        <div class="loupan-name">
            <div class="row row-justify">
                <h1><?php echo Tools::utf8substr($this->plot->title,0,28);?></h1>
                <div class="loupan-state">
                    <?php if($this->plot->xszt): ?>
                    <span class="s1"><?php echo $this->plot->xszt->name;?></span>
                    <?php endif; ?>
                    <?php if($this->plot->tuan_id > 0):?>
                    <span class="s2">团购</span>
                    <?php endif;?>
                    <?php if($this->plot->kan_id > 0):?>
                    <span class="s3">看房</span>
                    <?php endif;?>
                    <?php if($this->plot->is_new > 0):?>
                    <span class="s4">新盘</span>
                    <?php endif;?>
                </div>
            </div>
            <p class="kaipan-time">
                <span class="gc9">开盘时间：</span><span class="gc6"><?php echo $this->plot->open_time?date('Y年m月',$this->plot->open_time):'--';?></span>
            </p>
        </div>
        <!--楼盘价格-->
        <div class="loupan-price">
            <ul class="row">
                <li>
                    <p class="gc6"><?php echo PlotPriceExt::$mark[$this->plot->price_mark]?></p>
                    <p class="em-1 unit"><?php echo PlotPriceExt::getPrice($this->plot->price,$this->plot->unit);?></p>
                </li>
                <li>
                    <p class="gc6">意向用户</p>
                    <p class="em-1"><?php echo $ordercount;?>人</p>
                </li>
                <li>
                    <p class="gc6">楼盘状态</p>
                    <p class="em-1"><?php echo $this->plot->xszt ? $this->plot->xszt->name : '-';?></p>
                </li>
            </ul>
        </div>
        <a class="simple-button gc6 simple-button-arrow mb50 mt20" href="<?php echo $this->createUrl('/wap/plot/detail',array('py'=>$this->plot->pinyin));?>"><p class="text">查看楼盘详情</p><i class="icon icon-sright-arrow"></i></a>
        <?php if($this->plot->newKan):?>
        <h2 class="heading">看房团</h2>
            <?php if($this->plot->newKan->expire > time()):?>
                <div class="simple-button gc6 simple-button-baoming mb50"><p class="text"><?php echo $this->plot->newKan->title?></p><a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('看房团', $this->plot->newKan),'title'=>$this->plot->title.'--'.$this->plot->newKan->title)); ?>" class="baoming">我要报名</a></div>
            <?php else: ?>
                <div class="simple-button gc6 simple-button-baoming mb50"><p class="text">最新看房活动、优惠信息免费通知我</p><a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('看房团需求', $this->plot),'title'=>$this->plot->title.'--最新看房活动、优惠信息免费通知我')); ?>" class="baoming">立即申请</a></div>
            <?php endif;?>
        <?php endif;?>
        <?php if($this->plot->newDiscount && $this->plot->newDiscount['expire'] > time()):?>
        <h2 class="heading">优惠信息</h2>
        <div class="simple-button gc6 simple-button-baoming mb50"><p class="text"><?php echo $this->plot->newDiscount['title'];?></p><a class="baoming" href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('优惠通知', $this->plot),'title'=>$this->plot->newDiscount->title)); ?>">我要参加</a></div>
        <?php endif;?>
        <?php if($this->siteConfig['enableSpecialPlot'] && !empty($tejiafang)):?>
        <h2 class="heading">特价房</h2>
        <div class="tjf-list mb50">
            <div class="tjf-sublist on">
                <ul>
                    <?php foreach($tejiafang as $v):?>
                    <li>
                        <a href="<?php echo $this->createUrl('/wap/special/detail',array('id'=>$v->id));?>">
                            <div class="pic">
                                <?php echo CHtml::image(ImageTools::fixImage($v->image,'180','120'));?>
                            </div>
                            <div class="info">
                                <p><?php echo Tools::u8_title_substr($v->title,20);?></p>
                                <p><?php echo $v->bed_room?>&nbsp;&nbsp;<?php echo $v->size?>m<sup>2</sup></p>
                                <p><strong class="oprice em-1"><small>￥</small><?php echo $v->price_new;?><small>万</small></strong><del>￥<?php echo $v->price_old;?>万</del></p>
                                <i class="goarrow icon icon-right-arrow2"></i>
                            </div>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
                <?php if(count($tejiafang)>3):?>
                <div class="addmore">
                    <a href="">加载更多</a>
                </div>
                <?php endif;?>
            </div>
        </div>
        <?php endif;?>
        <h2 class="heading">楼盘户型<span class="gc6 fs24">（共<?php echo count($huxing);?>个户型）<span></h2>
        <div class="slide-type-1 mb50" id="j-touchslide">
            <div class="prev"></div>
            <div class="next"></div>
            <ul class="bd">
                <?php
                    if(!empty($huxing)):
                        foreach($huxing as $k=>$v):
                ?>
                <li><a target="_blank" href="<?php echo ImageTools::fixImage($v->url);?>">
                        <?php echo CHtml::image(ImageTools::fixImage($v->url,'500','425'));?>
                        <h3 class="gc6">
                            <?php echo $v->title;?>
                        </h3>
                    </a>
                </li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
        </div>
        <h2 class="heading">楼盘资讯<span class="gc6 fs24">（共<?php echo $artcount;?>条动态）<span></h2>

        <div class="loupan-new gw mb50">
            <?php if(!empty($articlePlotRel)):?>
                <a href="<?php echo $this->createUrl('/wap/news/detail',array('id'=>$articlePlotRel->article->id))?>" target="_blank">
                    <h3 class="title gc3">
                            <?php echo Tools::u8_title_substr($articlePlotRel->article->title,30); ?><span class="time gc9"><?php echo date('m月d日',$articlePlotRel->article->created);?></span>
                    </h3>
                    <p class="gc6"><?php echo Tools::u8_title_substr($articlePlotRel->article->description,100);?></p>
                </a>
            <?php endif;?>
            <div class="row gc9 aside">
                <div class="total"><a href="<?php echo $this->createUrl('/wap/plot/price',array('py'=>$this->plot->pinyin))?>">查看楼盘动态</a></div>
                <div class="sp-line">|</div>
                <div class="relate"><a href="<?php echo $this->createUrl('/wap/plot/news',array('py'=>$this->plot->pinyin))?>">相关导购资讯</a></div>
            </div>
        </div>

        <h2 class="heading">地图交通</h2>
        <div class="loupan-map mb50">
            <a href="<?php echo $this->createUrl('/wap/plot/map',array('py'=>$this->plot->pinyin));?>">
                <!--<img src="<?php echo Yii::app()->baseUrl;?>/static/wap/images/loupan-index-map.jpg" alt="" />-->
                <div class="map">
                    <!--使用百度地图静态图API-->
                    <img src="http://api.map.baidu.com/staticimage?ak=415167759dc5861ddbbd14154f760c7e&center=<?php echo $this->plot->map_lng;?>,<?php echo $this->plot->map_lat;?>&width=560&height=352&zoom=14&markers=<?php echo $this->plot->map_lng;?>,<?php echo $this->plot->map_lat;?>&markerStyles=," alt="" />
                </div>
                <div class="simple-button gc6 simple-button-arrow simple-button-map">
                        <p class="text">地址：<?php echo $this->plot->address;?></p>
    <!--                    <i class="icon icon-sright-arrow"></i>-->
                </div>
            </a>
        </div>
        <h2 class="heading">楼盘问答<span class="gc6 fs24">（共<?php echo $faqcount;?>条问答）<span></h2>
        <div class="wenda-list mb50">
            <ul>
                <?php
                    if(!empty($faqlist)):
                        foreach($faqlist as $k=>$v):
                ?>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/wenda/detail',array('id'=>$v->id));?>">
                        <h3 class="gc3">问：<?php echo $v->question;?></h3>
                        <p class="gc6">答：<?php echo Tools::u8_title_substr(strip_tags($v->answer),100);?></p>
                        <div class="info gc9">
                            <?php
                                if(isset($askcate[$v->cid]) && isset($askcate[$askcate[$v->cid]['parent']])){
                                    echo $askcate[$askcate[$v->cid]['parent']]['name'].' &gt; ';
                                }
                            ?>
                            <?php echo isset($askcate[$v->cid])?$askcate[$v->cid]['name']:'';?>
                            <span class="time">
                                <?php echo date('Y-m-d G:i',$v->created);?>
                            </span>
                        </div>
                    </a>
                </li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
            <div class="row gc9 aside">
                <div class="total"><a href="<?php echo $this->createUrl('/wap/plot/faq',array('py'=>$this->plot->pinyin))?>">查看所有楼盘问答</a></div>
                <div class="sp-line">|</div>
                <div class="relate"><a href="<?php echo $this->createUrl('/wap/wenda/ask',array('hid'=>$this->plot->id))?>">我要提问</a></div>
            </div>
        </div>
        <h2 class="heading">对此楼盘感兴趣的人还浏览了</h2>
        <ul class="relate-loupan-list">
            <?php
                if(!empty($wantKan)):
                    foreach($wantKan as $k=>$v):
            ?>
            <li>
                <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$v->pinyin))?>" class="gw">
                    <div class="pic"><?php echo CHtml::image(ImageTools::fixImage($v->image,'200','140'));?></div>
                    <div class="title row row-justify">
                        <h3><?php echo $v->title;?></h3>
                        <div class="unit"> <?php echo PlotPriceExt::getPrice($v->price,$v->unit)?></div>
                    </div>
                    <p class="address"><?php echo Tools::u8_title_substr($v->address,32);?></p>
                    <div class="loupan-state">
                        <?php if(isset($this->tag[$v->sale_status])): ?>
                        <span class="s1"><?php echo $this->tag[$v->sale_status];?></span>
                        <?php endif; ?>
                        <?php if($v->tuan_id > 0):?>
                        <span class="s2">团购</span>
                        <?php endif;?>
                        <?php if($v->kan_id > 0 ):?>
                        <span class="s3">看房</span>
                        <?php endif;?>
                        <?php if($v->is_new):?>
                        <span class="s4">新盘</span>
                        <?php endif;?>
                    </div>
                </a>
            </li>
            <?php
                    endforeach;
                endif;
            ?>
        </ul>
    </div>
</div>
<div class="bottom-box">
    <a href="<?php echo 'tel://'.$this->plot->formatSaleTel; ?>" tel="" class="tel-zx"><i class="icon icon-tel2"></i>电话咨询</a>
    <a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('优惠通知', $this->plot),'title'=>$this->plot->title)); ?>" class="youhui-tell"><i class="icon icon-youhui"></i>优惠通知我</a>
</div>
    <script>
        <?php Tools::startJs(); ?>
        TouchSlide({slideCell:'j-touchslide'});
        TouchSlide({slideCell:'j-banner-slide'});
        <?php Tools::endJs('js'); ?>
    </script>

<?php
$wx = $this->beginWidget('WeChat');
$wx->onMenuShareAppMessage(ImageTools::fixImage($this->siteConfig['wapWxShareImg']?$this->siteConfig['wapWxShareImg']:$shareImgUrl),$this->pageTitle,$this->plot->data_conf['seo_description']?$this->plot->data_conf['seo_description']:$this->plot->data_conf['content']);
$this->endWidget();
?>
