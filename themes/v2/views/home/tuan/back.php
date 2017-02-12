<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/kanfangtuan.css');
$this->pageTitle = SM::urmConfig()->cityName().'看房团_'.SM::urmConfig()->cityName().'看房团报名_'.SM::urmConfig()->cityName().'看房团班车-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'看房团，'.SM::urmConfig()->cityName().'看房团报名，'.SM::urmConfig()->cityName().'看房团班车，'.SM::urmConfig()->cityName().'房产网，'.SM::GlobalConfig()->siteName().'房产','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网定期召集网友组织'.SM::urmConfig()->cityName().'看房团、'.SM::urmConfig()->cityName().'看房团报名等活动，为广大网友精心规划优质看房路线，方便大家省时省力选出最合适自己的房子。','description');
$this->breadcrumbs = array(SM::urmConfig()->cityName().'看房团'=>$this->createUrl('index'),'往期回顾');
?>
<div class="kanfangtuan">
    <?php foreach($kan as $v):?>
        <div class="section">
            <div class="tuan clearfix">
                <div class="fl">
                    <h1><?php echo $v->title;?></h1>
                    <p class="sub"><span class="label time">时间：</span><?php echo date('m-d h:i',$v->gather_time)?><span class="label address">地点：</span><?php echo $v->location?></p>
                </div>
                <div class="fr baomingbtn">
                    <a href="<?php echo $v->url ? $v->url : 'javascript:';?>" target="_blank"  class="k-btn-1 k-inline-block " >查看详情</a>
                    <p class="baominginfo">
                         报名已截止&#160;&#160;已有<span class="k-em-2"><?php echo ($v->stat)+($v->kanNum)?></span>人报名
                    </p>
                </div>
            </div>
            <div class="liucheng clearfix">
                <ul>
                    <li class="start"><i class="icon-4 kanfangicon"></i></li>
                    <?php foreach($v->plots as $n): ?>
                        <li class="m" style="width:<?php echo 1100/count($v->plots);?>px">
                            <i class="f-line-1"></i>
                            <i class="icon-5 kanfangicon"></i>
                            <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_blank"><span class="name"><?php echo $n->title?></span></a>
                            <div class="popinfo clearfix">
                                <i class="down-arrow"></i>
                                <div class="fl pic"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_black"><img class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,150,110)?>" alt="<?php echo $n->title; ?>"/></a></div>
                                <div class="fl info">
                                    <div class="title"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_blank"><?php echo $n->title?></a></div>
                                    <p><span class="label">编辑推荐：</span><?php echo $n->newDiscount ? $n->newDiscount->title : ''?></p>
                                    <p><span class="label">开盘时间：</span><?php echo date('Y',$n->open_time)?>年<?php echo date('m',$n->open_time)?>月</p>
                                    <p><span class="label">楼盘价格：</span><?php echo PlotPriceExt::getPrice($n->price,$n->unit)  ?></p>
                                    <p><span class="label">楼盘地址：</span><?php echo $n->address?></p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                    <li class="m end"><i class="f-line-1"></i><i class="f-line-arrow kanfangicon icon-6 "></i><i class="f-line-arrow"></i></li>
                </ul>
            </div>
            <div class="loupan hj-picScroll-left" style="height: auto">
                <div class="prev dir"></div>
                <div class="next dir"></div>
                <div class="bd">
                    <ul>
                        <?php foreach($v->pics as $n):?>
                            <li class="item">
                                <a href="<?php echo $v->url ? $v->url : 'javascript:';?>" target="_blank">
                                    <div class="pic">
                                        <img class="lazy" data-original="<?php echo ImageTools::fixImage($n->img,270,200)?>"  />
                                    </div>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach;?>

    <div class="blank15"></div>
    <div class="page-box fs14">
        <?php $this->widget('HomeLinkPager', array('pages'=>$pager,'maxButtonCount'=>5)) ?>
    </div>
</div>