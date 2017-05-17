<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=7, IE=9">
    <title><?php echo $this->pageTitle;?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/static/home/style/head.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/static/home/style/common.css"/>
</head>
<body>
<div class="wapperout s-head-bg clearfix">
    <div class="wapper overvisible">
        <div class="s-head">
            <a href="" class="fl s-head-logo"><img src="<?php echo ImageTools::fixImage($this->siteConfig['siteLogoRed']); ?>"></a>
            <ul class="s-head-nav">
                <li><a href="<?php echo $this->createUrl('/home/index/index')?>">首页</a></li>
                <li><a href="<?php echo $this->createUrl('/home/specialprice/purchase')?>">团购</a></li>
                <li<?php if($this->id == 'plot'):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/list')?>" class="pr ">新盘</a></li>
                <li<?php if($this->id == 'tuan'):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/tuan/index')?>" class="pr ">看房团</a></li>
                <li><a href="<?php echo $this->createUrl('/home/school/index')?>">邻校房</a></li>
                <li><a href="<?php echo $this->createUrl('/home/news/index')?>">资讯</a></li>
                <li<?php if($this->id == 'wenda'):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/wenda/index')?>">问答</a></li>
            </ul>
            <div class="s-search">
                <div class="s-search-l">
                    <input type="text" class="s-search-txt"  value=""  placeholder="输入楼盘名称" style="color: rgb(153, 153, 153);">
                    <ul class="s-search-down">
                        <li><a href="">宝龙城市</a></li>
                        <li><a href="">宝龙城市</a></li>
                        <li><a href="">宝龙城市</a></li>
                        <li><a href="">宝龙城市</a></li>
                    </ul>
                </div>
                <input type="submit" class="s-search-btn head-icon" value="">
            </div>
        </div>
    </div>
</div>
<div class="blank20"></div>
<?php echo $content;?>
<div class="float-menu">
    <dl class="item tuangou">
        <dt>团购<br/>楼盘</dt>
        <dd><i class="kanfangicon icon-20"></i></dd>
    </dl>
    <dl class="item">
        <dt>热门<br/>资讯</dt>
        <dd><i class="kanfangicon icon-21"></i></dd>
    </dl>
    <dl class="item">
        <dt>最新<br/>新房</dt>
        <dd><i class="kanfangicon icon-22"></i></dd>
    </dl>
    <dl class="item">
        <dt>邻校<br/>楼盘</dt>
        <dd><i class="kanfangicon icon-23"></i></dd>
    </dl>
    <dl class="item">
        <dt>二手<br/>房</dt>
        <dd><i class="kanfangicon icon-24"></i></dd>
    </dl>
    <dl class="gotoTop">
        <dd><i class="kanfangicon icon-25"></i></dd>
    </dl>
</div>

<script type="text/javascript">
    var basedir = "<?php echo Yii::app()->baseUrl;?>/static/home/js/";
</script>
<div class="wapperout fixed_box">
    <div class="wapper guide-box">
        <ul class="fl">
            <li><a href="">楼盘主页</a></li>
            <li class="current"><a href="">详情</a></li>
            <li><a href="">户型</a></li>
            <li><a href="">相册</a></li>
            <li><a href="">地图交通</a></li>
            <li><a href="">价格</a></li>
            <li><a href="">动态</a></li>
            <li><a href="">问答</a></li>
            <li><a href="">二手房</a></li>
            <li><a href="">租房</a></li>
            <li><a href="">论坛</a></li>
        </ul>
        <input type="button" value="报名团购" class="baotuan-btn k-dialog-type-1" data-title="报名团购" data-spm="楼盘首页">
    </div>
</div>
</body>
</html>
