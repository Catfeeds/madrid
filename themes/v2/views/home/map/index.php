<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content="<?php echo SM::urmConfig()->cityName().'地图找房，'.SM::urmConfig()->cityName().'楼盘地图，'.SM::urmConfig()->cityName().'房产地图，'.SM::urmConfig()->cityName().'新房中心，'.SM::urmConfig()->cityName().'房价，'. SM::GlobalConfig()->siteName().'房产';?>"/>
    <meta name="Description" content="<?php echo SM::GlobalConfig()->siteName().'房产网为广大网友提供最新最全的'.SM::urmConfig()->cityName().'楼盘地图、'.SM::urmConfig()->cityName().'房产地图、'.SM::urmConfig()->cityName().'楼盘房价，方便大家更清晰、更准确了解买房信息，'.SM::urmConfig()->cityName().'地图找房就来'.SM::GlobalConfig()->siteName().'房产网';?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7, IE=Edge">
    <title><?php echo SM::urmConfig()->cityName().'地图找房_'.SM::urmConfig()->cityName().'楼盘地图_'.SM::urmConfig()->cityName().'房产地图-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl?>/static/home/style/common.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl?>/static/home/style/map.css"/>
</head>
<body>
<div class="wapperout s-head-bg clearfix">
    <div class="s-head ml10">
        <a href="/" target="_blank" class="fl s-head-logo">
            <?php if(SM::globalConfig()->siteLogoRed()): ?><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->siteLogoRed()); ?>"><?php endif; ?></a>
        <ul class="s-head-nav">
            <li><a href="<?php echo $this->createUrl('/home/index/index'); ?>" target="_blank">首页</a></li>
            <li><a href="<?php echo $this->createUrl('/home/special/tuan');?>" target="_blank">团购</a></li>
            <li><a href="<?php echo $this->createUrl('/home/plot/list'); ?>" target="_blank">新盘</a></li>
            <li><a href="<?php echo $this->createUrl('/home/tuan/index'); ?>" target="_blank">看房团</a></li>
            <li><a href="<?php echo $this->createUrl('/home/school/index'); ?>" target="_blank">邻校房</a></li>
            <!-- <li><a href="">风向标</a></li> -->
            <li><a href="<?php echo $this->createUrl('/home/news/index'); ?>" target="_blank">资讯</a></li>
        </ul>
    </div>
</div>
<div class="wapperout d-pink-bg">
    <div class="p_current fs14 fl ml10">当前位置：<a href="<?php echo $this->createUrl('/home/index/index'); ?>" target="_blank"><?php echo SM::urmConfig()->cityName(); ?>房产</a>&gt;<a href="<?php echo $this->createUrl('/home/plot/list'); ?>" target="_blank"><?php echo SM::urmConfig()->cityName(); ?>新房</a>&gt;<span>地图找房</span></div>
    <div class="search-box fl">
        <div class="head-search">
            <form action="" method="get">
                <div class="head-icon fl c-g3" id="search-select">
                    <span id="action-selected" rel="all">新房</span>
                    <ul class="action-select" id="action-select" rel="">
                        <li rel="" lang="">新房</li>
                        <li rel="" lang="information" data-url="<?php echo $this->createUrl('/home/news/index'); ?>">资讯</li>
                    </ul>
                </div>
                <input type="text" class="fl bigfs searchtxt" name="kw" id="plot_map_search">
                <input type="submit" class="searchbut head-icon" id="searchbut" value="">
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="line"></div>
<div class="blank10"></div>
<div class="wapperout map_body">
    <div class="map_l">
        <div class="inforight">
            <dl>
                <dt>快速定位：</dt>
                <dd>
                    <?php foreach(AreaExt::model()->frontendShow()->parent()->findAll() as $v): ?>
                    <a class="search_area search_left_condition" data-id="<?php echo $v->id; ?>" data-lng="<?php echo $v->map_lng; ?>" data-lat="<?php echo $v->map_lat; ?>"><?php echo $v->name; ?></a>
                    <?php endforeach; ?>
                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight">
            <dl>
                <dt>物业类型：</dt>
                <dd>
                    <a class="search_wuye search_left_condition" rel="0">不限</a>
                    <?php foreach(TagExt::model()->getTagByCate('wylx')->findAll() as $v): ?>
                    <a class="search_wuye search_left_condition" data-id="<?php echo $v->id; ?>"><?php echo $v->name; ?></a>
                    <?php endforeach; ?>
                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight">
            <dl>
                <dt>价格：</dt>
                <dd>
                    <a rel="0" class="search_price search_left_condition">不限</a>
                    <?php foreach(TagExt::model()->getTagByCate('xinfangjiage')->normal()->findAll() as $v): ?>
                    <a class="search_price search_left_condition" data-id="<?php echo $v->id?>"><?php echo $v->name; ?></a>
                    <?php endforeach;?>
                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight">
            <dl>
                <dt>楼盘特色：</dt>
                <dd><a rel="0" class="search_tese search_left_condition">不限</a>
                    <?php foreach(TagExt::model()->getTagByCate('xmts')->normal()->findAll() as $v): ?>
                    <a class="search_tese search_left_condition" data-id="<?php echo $v->id; ?>"><?php echo $v->name; ?></a>
                    <?php endforeach;?>
                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight last">
            <p class="fw blackc mb10">楼盘图例：</p>
            <div>
                <a class="sell_status map_icon sell_now">在售</a>
                <a class=" sell_status map_icon sell_pre">待售</a>
                <a class=" sell_status map_icon sell_out">尾盘</a>
            </div>
        </div>
    </div>
    <div class="map_r pr mr10">
        <div id="map"></div>
        <div class="mapBodyTool open map_icon">关闭</div>
        <div class="mapBodyTool close map_icon">打开</div>
    </div>
    <div class="clear"></div>

</div>




<div class="wapper-out bg-ee">
    <?php echo SM::globalConfig()->siteFooter(); ?>
</div>
</body>
<script>
    var basedir = "<?php echo Yii::app()->theme->baseUrl?>/static/home/js/";
    var cityName = "<?php echo SM::urmConfig()->cityName(); ?>";
    var getPlotInfoUrl = "<?php echo $this->createUrl('/api/plot/ajaxMapPlotInfo'); ?>";
    var getAreaInfoUrl = "<?php echo $this->createUrl('/api/plot/ajaxMapAreaInfo'); ?>";
    var searchPlotInfoUrl = "<?php echo $this->createUrl('/api/plot/ajaxGetPlot'); ?>";
</script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/home/js/do.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/static/home/js/map_common.js?v=2014723"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/static/home/js/map_plot_search.js?v=2014723"></script>
</html>
