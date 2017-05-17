<?php
$this->pageTitle = $this->siteConfig['cityName'].'看房团_'.$this->siteConfig['cityName'].'看房团报名_'.$this->siteConfig['cityName'].'看房团班车-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'看房团，'.$this->siteConfig['cityName'].'看房团报名，'.$this->siteConfig['cityName'].'看房团班车，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['siteName'].'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网定期召集网友组织'.$this->siteConfig['cityName'].'看房团、'.$this->siteConfig['cityName'].'看房团报名等活动，为广大网友精心规划优质看房路线，方便大家省时省力选出最合适自己的房子。','description');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css?t=2');
$this->registerHeadJs(['640resize']);
?>
<body>
    <div class="fangchan g-fangchan">
        <header class="ui-title-bar">
            <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
            <span class="ml10 mr10 c-gc fl fs32">|</span>
            <span class="fl fs32 gc3">看房团</span>
        </header>
        <div class="kanfangtuan-list gw">
            <ul>
            <?php foreach($kan as $v):?>
                <li>
                    <div class="baseinfo">
                        <h3><?php echo Tools::utf8substr($v->title,0,50);?></h3>
                        <p class="time"><i class="icon icon-time v-middle"></i><?php echo date('Y-m-d H:i',$v->gather_time)?></p>
                        <p class="address"><i class="icon icon-map v-middle"></i><?php echo Tools::utf8substr($v->location,0,50)?></p>
                    </div>
                    <ul class="progress">
                    <?php foreach($v->plots as $n):?>
                        <li>
                            <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$n->pinyin))?>">
                                <div class="fang-village">
                                    <div class="pic"><img src="<?php echo ImageTools::fixImage($n->image)?>" alt="" /></div>
                                    <div class="info">
                                        <h3><?php echo Tools::utf8substr($n->title,0,20);?></h3>
                                        <p class="price em-1"><?php echo PlotPriceExt::getPrice($n->price,$n->unit)?></p>
                                        <p class="address"><?php echo (isset($this->siteArea[$n->area])&&!empty($this->siteArea[$n->area])) ? ($this->siteArea[$n->area].((isset($this->siteStreet[$n->area])&&!empty($this->siteStreet[$n->area])) ? ((isset($this->siteStreet[$n->area][$n->street])&&!empty($this->siteStreet[$n->area][$n->street])) ? '/'.$this->siteStreet[$n->area][$n->street] : '') :'' )) : '';?></p>
                                        <p class="yh em-1"><?php echo $n->newDiscount ? Tools::u8_title_substr($n->newDiscount->title,26) : ''?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach;?>
                    </ul>
                    <div class="calnum">
                        <ul class="row">
                          <li class="button normal-button"><?php echo($v->stat + $v->kanNum);?>人已报名</li>
                            <?php if($v->expire > time()):?>
                                <li><a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('看房团',$v), 'title'=>$v->title)); ?>" class="button baoming-button">我要报名</a></li>
                            <?php else: ?>
                                <li><?php echo CHtml::link('活动回顾',$v->url?$v->url:'javascript:;',array('class'=>'button dis-baoming-button', 'target'=>'_blank'));  ?></li>
                            <?php endif;?>

                        </ul>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    </div>
    <!--楼盘资讯 end-->
    <!--分页 begin-->
    <?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
    <!--分页 end-->
