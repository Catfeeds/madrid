<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title>房产小首页</title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/static/home/style/house_label.css"/>
</head>

<body>
<div class="wapper">
    <div class="label_box">
        <div class="label_title bigfs">
            <div>
                <span class="icon_guess mr20">你喜欢看</span><span class="z_bg fs18"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plot->pinyin)); ?>" target="_blank" class="<?php echo $class[array_rand($class)] ?>"><?php echo $plot->title; ?></a></span><span class="c-g3 mr20 fs14">售楼处免费咨询电话</span><span class="tel_bg fs18"><?php echo $plot->sale_tel; ?></span>
            </div>
        </div>
        <div class="loupan_detail">
            <dl>
                <dt><a href="<?php echo $this->createUrl('/home/plot/index', array('py'=>$plot->pinyin)); ?>" target="_blank"><img src="<?php echo ImageTools::fixImage($plot->image); ?>"> </a></dt>
                <dd>
                    <p><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plot->pinyin)); ?>" target="_blank" class="fs22 bigfs c-g3"><?php echo $plot->title; ?></a><span class="fs14 ml15"><a href="<?php echo $this->createUrl('/home/plot/detail', array('py'=>$plot->pinyin)); ?>" target="_blank" class="c_link mr5">详情</a>|<a href="<?php echo $this->createUrl('/home/plot/huxing', array('py'=>$plot->pinyin)); ?>" target="_blank" class="c_link ml5 mr5">户型</a><?php if($plot->old_id&&$this->siteConfig['plotEsfUrl']||$plot->data_conf['esfUrl']): ?>|<a href="<?php echo $plot->data_conf['esfUrl']?$plot->data_conf['esfUrl']:str_replace('{id}',$plot->old_id,$this->siteConfig['plotEsfUrl']); ?>" target="_blank" class="c_link ml5 mr5">二手房</a><?php endif; ?><?php if($plot->old_id&&$this->siteConfig['plotEsfUrl']||$plot->data_conf['zfUrl']): ?>|<a href="<?php echo $plot->data_conf['zfUrl']?$plot->data_conf['zfUrl']:str_replace('{id}',$plot->old_id,$this->siteConfig['plotZfUrl']); ?>" target="_blank" class="c_link ml5">租房</a></span><?php endif; ?></p>
                    <p class="fs14 mb10"><span class="c-g6 mr15"><?php echo PlotPriceExt::$mark[$plot->price_mark]; ?>：<em class="fs20 fw c_g mr5"><?php echo $plot->price; ?></em><em><?php echo PlotPriceExt::$unit[$plot->unit]; ?></em></span><a href="<?php echo $this->createUrl('/home/plot/price',array('py'=>$plot->pinyin)); ?>" class="c-g6" target="_blank">查看历史价格</a></p>
                </dd>
            </dl>
            <ul class="clearfix fs14">
                <?php foreach($articleRel as $v): ?>
                <li><a href="<?php echo $this->createUrl('/home/news/detail',array('articleid'=>$v->article->id)); ?>" target="_blank" class="c_link w380 fl"><?php echo $v->article->title; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>
</body>
</html>
