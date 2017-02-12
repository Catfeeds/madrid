<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title>房产标签小首页</title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/static/home/style/shouse_buy.css"/>
</head>

<body>
<div class="blank10"></div>
<div class=" w750 hot_activ bor_blue">
    <p class="bbs_activ_title icon_tit_bg">本月房产团购</p>
    <ul class="fs14 bbs">
        <?php foreach($content as $v): ?>
        <li class="icon_tit_bg"><a href="<?php echo $v->url; ?>" target="_blank"><?php echo $v->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>
</body>
</html>
