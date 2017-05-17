<!doctype html>
<html class="effect">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta name="keywords" content="里奥哈葡萄酒,进口红酒,西班牙红酒,里奥哈酒庄,进口顶级红酒"/>
    <meta name="description" content="马德里公馆主营西班牙进口红酒,介绍西班牙里奥哈葡萄酒历史、文化和知识。为追求品质吃喝的你带来高价值的红酒及橄榄油科普,提供全国线下产品体验中心。"/>
    <meta name="author" content="UEMO">
    <link type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/bxslider.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/animate.min.css">
    <link type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/css/376m.css">
  <title><?php echo '马德里公馆-'.$this->pageTitle;?></title>
</head>

<body class="<?=$this->banner?>">
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
            <a id="logo" href="<?=$this->createUrl('/')?>"><img src="<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcLogo'))?>" /></a>
        </div>
        <div class="scrollView">
            <?=$content?>
            <div id="footer">
                <p class="plr10"><span>COPYRIGHT (©) 2017  常州马德里公馆.</span>
                    <a class="beian" href="http://www.miitbeian.gov.cn/" style="display:inline; width:auto; color:#8e8e8e" target="_blank"></a>
                </p>
            </div>
            <div id="bgmask" class="iPage hide">
                <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1261416854'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1261416854' type='text/javascript'%3E%3C/script%3E"));</script>
            </div>
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
            <?php $path = trim(Yii::app()->request->getPathInfo(),'/');?>

            <li class="navitem"><a class="nav-a <?=$path=='home/index/index'?'active':''?>" href="<?=$this->createUrl('/wap')?>" target="_self"><span  data-title="首页">首页</span></a></li>
            <li class="navitem"><a class="nav-a <?=$path=='home/product/list'||$path=='home/product/info'?'active':''?>" href="<?=$this->createUrl('/home/product/list')?>" target="_self"><span data-title="酒款">酒款</span></a></li>
            <li class="navitem"><a class="nav-a <?=$path=='home/house/list'||$path=='home/house/info'?'active':''?>" href="<?=$this->createUrl('/home/house/list')?>" target="_self"><span data-title="酒庄">酒庄</span></a></li>
            <li class="navitem"><a class="nav-a <?=$path=='home/news/list'||$path=='home/news/info'?'active':''?>" href="<?=$this->createUrl('/home/news/list')?>" target="_self"><span data-title="资讯">资讯</span></a></li>
            
            <!-- <li class="navitem"><a class="nav-a <?=$path=='home/index/index'?'active':''?>" href="<?=$this->createUrl('index')?>" target="_self"><span data-title="图册">图册</span></a></li> -->
            <li class="navitem"><a class="nav-a <?=$path=='home/serve/list'||$path=='home/serve/info'?'active':''?>" href="<?=$this->createUrl('/home/serve/list')?>" target="_self"><span data-title="服务">服务</span></a></li>
            <li><a href="<?=$this->createUrl('/home/team/list')?>" target="_self"><span data-title="团队">团队</span></a></li>
                    <li><a href="<?=$this->createUrl('/home/contact/index')?>" target="_self"><span data-title="联系">联系</span></a></li>
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
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/wap/js/org.min.js" data-main="<?=$this->banner?'baseMain':'indexMain'?>"></script>
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
$('.lcbody').click(function(){
        if($('body').attr('class') != 'open')
            $('body').attr('class','open');
        else
            $('body').attr('class','');
    });
</script>
</body>

</html>
