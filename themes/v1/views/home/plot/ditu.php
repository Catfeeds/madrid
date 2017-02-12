<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=7, IE=Edge">
    <title>房产-地图找房</title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/common.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/map.css"/>
</head>
<body>
<div class="wapperout s-head-bg clearfix">
    <div class="s-head ml10">
        <a href="" class="fl s-head-logo"><img src="images/s_logo.png"></a>
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
    <div class="p_current fs14 fl ml10">当前位置：
        <a href="/"><?php echo $this->siteConfig['siteName']?></a>&gt;
        <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo $this->siteConfig['cityName']?>新房</a>&gt;
        <span>新房地图</span>
    </div>
    <div class="search-box fl">
        <div class="head-search">
            <form action="" method="get">
                <div class="head-icon fl c-g3" id="search-select">
                    <span id="action-selected" rel="all">新房</span>
                    <ul class="action-select" id="action-select" rel="">
                        <li rel="" lang="">新房</li>
                        <li rel="" lang="information">资讯</li>
                    </ul>
                </div>
                <input type="text" class="fl bigfs" id="searchtxt" placeholder="宝龙城市广场">
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
                    <a class="search_area search_left_condition" map_lat="31.783563" map_lng="119.948155">钟楼区</a>
                    <a class="search_area search_left_condition" map_lat="31.784167" map_lng="119.983586">天宁区</a>
                    <a class="search_area search_left_condition" map_lat="31.833264" map_lng="119.980136">新北区</a>
                    <a class="search_area search_left_condition" map_lat="31.742394" map_lng="119.962313">武进区</a>
                    <a class="search_area search_left_condition" map_lat="31.775307" map_lng="120.000257">戚墅堰区</a>
                    <a class="search_area search_left_condition" map_lat="31.728582" map_lng="119.589921">金坛</a>
                    <a class="search_area search_left_condition" map_lat="31.418093" map_lng="119.482874">溧阳</a>
                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight">
            <dl>
                <dt>物业类型：</dt>
                <dd>
                    <a class="search_wuye search_left_condition" rel="0">不限</a>
                    <a class="search_wuye search_left_condition" rel="1">普通住宅</a>
                    <a class="search_wuye search_left_condition" rel="2">经济适用房</a>
                    <a class="search_wuye search_left_condition" rel="3">花园洋房</a>
                    <a class="search_wuye search_left_condition" rel="4">写字楼</a>
                    <a class="search_wuye search_left_condition" rel="5">商铺</a>
                    <a class="search_wuye search_left_condition" rel="6">酒店式公寓</a>
                    <a class="search_wuye search_left_condition" rel="7">别墅</a>
                    <a class="search_wuye search_left_condition" rel="8">大平层</a>
                    <a class="search_wuye search_left_condition" rel="9">跃层住宅</a>
                    <a class="search_wuye search_left_condition" rel="10">复式挑高</a>
                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight">
            <dl>
                <dt>价格：</dt>
                <dd>
                    <a rel="0" class="search_price search_left_condition">不限</a>
                    <a rel="1" class="search_price search_left_condition">5000以下</a>
                    <a rel="2" class="search_price search_left_condition">5000-5999</a>
                    <a rel="3" class="search_price search_left_condition">6000-6999</a>
                    <a rel="4" class="search_price search_left_condition">7000-7999</a>
                    <a rel="5" class="search_price search_left_condition">8000-8999</a>
                    <a rel="6" class="search_price search_left_condition">9000-9999</a>
                    <a rel="7" class="search_price search_left_condition">1万以上</a>

                </dd>
            </dl>
            <div class="clear"></div>
        </div>
        <div class="inforight">
            <dl>
                <dt>楼盘特色：</dt>
                <dd><a rel="0" class="search_tese search_left_condition">不限</a>
                    <a rel="1" class="search_tese search_left_condition">小户型</a>
                    <a rel="2" class="search_tese search_left_condition">现房</a>
                    <a rel="3" class="search_tese search_left_condition">品牌地产</a>
                    <a rel="4" class="search_tese search_left_condition">公园地产</a>
                    <a rel="5" class="search_tese search_left_condition">BRT沿线房</a>
                    <a rel="6" class="search_tese search_left_condition">地铁房</a>
                    <a rel="7" class="search_tese search_left_condition">创意地产</a>
                    <a rel="8" class="search_tese search_left_condition">科技住宅</a>
                    <a rel="9" class="search_tese search_left_condition">景观居所</a>
                    <a rel="10" class="search_tese search_left_condition">教育地产</a>
                    <a rel="12" class="search_tese search_left_condition">湖景地产</a>
                    <a rel="13" class="search_tese search_left_condition">养老地产</a>
                    <a rel="14" class="search_tese search_left_condition">精装修</a>
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




<div class="blank30"></div>
<div class="wapper-out bg-ee">
    <?php echo $this->siteConfig['siteFooter']; ?>
</div>
</body>
<script>
    var basedir = "<?php echo Yii::app()->baseUrl?>/static/home/js/";
</script>
<script type="text/javascript" src="js/do.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl?>/static/home/js/map_common.js"></script>
<script src="<?php echo Yii::app()->baseUrl?>/static/home/js/map_plot_search.js"></script>
</html>
