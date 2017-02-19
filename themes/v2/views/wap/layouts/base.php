<!doctype html>
<html class="effect">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta name="keywords" content="网站模板,自定义模板,餐饮网站,西餐网站,美食网站,美食模板">
    <meta name="description" content="模板网站生成">
    <meta name="author" content="UEMO">
    <link type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/bxslider.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/animate.min.css">
    <link type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/376m.css">
    <title>关于 - mo004_376 - 食品餐饮类网站</title>
</head>

<body>
    <div id="sitecontent" class="transform">
        <div id="header">
            <div id="openlc" class="fl btn">
                <div class="lcbody">
                    <div class="lcitem top">
                        <div class="rect top"></div>
                    </div>
                    <div class="lcitem bottom">
                        <div class="rect bottom"></div>
                    </div>
                </div>
            </div>
            <a id="logo" href="http://mo004_376.mo4.line1.jsmo.xin/"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468932780156.png" /></a>
        </div>
        <div class="scrollView">
            <?=$content?>
            <div id="footer">
                <p class="plr10"><span>(©) 2017 mo004_376 - 食品餐饮类网站.</span>
                    <a class="beian" href="http://www.miitbeian.gov.cn/" style="display:inline; width:auto; color:#8e8e8e" target="_blank"></a>
                </p>
            </div>
            <div id="bgmask" class="iPage hide"></div>
        </div>
    </div>
    <div id="leftcontrol">
        <ul id="nav">
            <li>
                <div id="closelc" class="fr btn hide">
                    <div class="lcbody">
                        <div class="lcitem top">
                            <div class="rect top"></div>
                        </div>
                        <div class="lcitem bottom">
                            <div class="rect bottom"></div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navitem"><a class="transform" href="http://mo004_376.mo4.line1.jsmo.xin/"><span class="circle transform"></span>首页</a></li>
            <li class="navitem"><a class="transform" href="http://mo004_376.mo4.line1.jsmo.xin/project/"><span class="circle transform"></span>菜品</a></li>
            <li class="navitem active"><a href="javascript:;" class="hassub"><span class="circle transform"></span>关于<span class="more"><span class="h"></span><span class="h v transform"></span></span></a>
                <ul class="subnav transform" data-height="150" style="height:150px">
                    <li class="active"><a href="http://mo004_376.mo4.line1.jsmo.xin/page/about/"><i class="fa fa-angle-right"></i>关于</a></li>
                    <li><a href="http://mo004_376.mo4.line1.jsmo.xin/team/"><i class="fa fa-angle-right"></i>团队</a></li>
                    <li><a href="http://mo004_376.mo4.line1.jsmo.xin/news/"><i class="fa fa-angle-right"></i>新闻</a></li>
                </ul>
            </li>
            <li class="navitem"><a class="transform" href="http://mo004_376.mo4.line1.jsmo.xin/page/5739/"><span class="circle transform"></span>图册</a></li>
            <li class="navitem"><a class="transform" href="http://mo004_376.mo4.line1.jsmo.xin/service/"><span class="circle transform"></span>服务</a></li>
            <li class="navitem"><a class="transform" href="http://mo004_376.mo4.line1.jsmo.xin/page/5740/"><span class="circle transform"></span>联系</a></li>
        </ul>
    </div>
    <script type="text/javascript">
    var YYConfig = {};
    </script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/js/zepto.min.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/js/zepto.bxslider.min.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/js/wow.min.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/js/masonry_4.min.js"></script>
    <script type="text/javascript">
    $(function() {
        new WOW({
            scrollContainer: ".scrollView"
        }).init();
    })
    </script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/js/org.min.js" data-main="IndexMain"></script>
    <div class="hide"></div>

<script type="text/javascript">
$(document).ready(function(e) {
    var img = $(".slider_img img")[0];

    function sliderChulaiba() {
        $('#t-slider').bxSlider({
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
            auto: 0,
            infiniteLoop: true,
            hideControlOnEnd: true,
        });
    }
    if (img.complete) sliderChulaiba();
    else $(".slider_img img")[0].onload = function(e) {
        sliderChulaiba();
    };
});
</script>
</body>

</html>
