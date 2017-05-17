<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7, IE=9">
    <title><?php echo $this->pageTitle ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/head.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/common.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/baidu_ad.css"/>
    <script type="text/javascript">
    var basedir = "<?php echo Yii::app()->baseUrl?>/static/home/js/";
    var urmHost = "<?php echo Yii::app()->params['urmHost']?>";
    var csrf = "<?php echo Yii::app()->request->getCsrfToken(); ?>";
    var loginUrl = "<?php echo $this->enableNewLogin() ? $this->createUrl('/api/bbs/newLogin') : $this->createUrl('/api/bbs/login'); ?>";
    var logoutUrl = "<?php echo $this->enableNewLogin() ? $this->createUrl('/api/bbs/logout') : Yii::app()->params['urmHost'].Yii::app()->params['bbsLogoutApi']?>";
    var userinfoUrl = "<?php echo $this->enableNewLogin() ? $this->createUrl('/api/bbs/userInfo') : Yii::app()->params['urmHost'].Yii::app()->params['bbsGetuserinfoApi']; ?>";
    var userCenterUrl = "<?php echo isset($this->siteConfig['commonHeader']['userinfoUrl']) ? $this->siteConfig['commonHeader']['userinfoUrl'] : '' ?>";
    var orderApi = "<?php echo $this->createUrl('/api/order/ajaxSubmit'); ?>";
    var tradeTermsUrl = "<?php echo $this->siteConfig['tradeTermsUrl']; ?>";
    var noPicUrl = "<?php echo ImageTools::fixImage($this->siteConfig['siteNoPic']); ?>";
    window.onload = function(){
        //百度广告代码位没有投放广告，则去掉blank空行
        Do.ready(function(){
            if($(".ad-0").length>0){
                $.each($(".ad-0"),function(i){
                    obj = $(".ad-0")[i]
                    if($(obj).find("iframe").length==0){
                        $(obj).next().remove();
                    }
                });
            }
        });
    }
</script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/home/js/do.js"></script>
</head>
<?php echo $content;?>
<div class="blank20"></div>
 <div class="wapper-out bg-ee">
    <?php echo $this->siteConfig['siteFooter']; ?>
</div>
<div class="float-menu">
    <?php if(isset($this->siteConfig['maiFangQQ'][0]['number'])&&$this->siteConfig['maiFangQQ'][0]['number']): ?>
    <dl class="item">
        <dt><a href="<?php echo $this->createUrl('/home/adviser/index'); ?>" target="_blank" class="online">在线<br/>咨询</a>
        <div class="online-box">
            <span class="right-arrow"><span></span></span>
            <ul>
                <?php foreach($this->siteConfig['maiFangQQ'] as $k=>$v): ?>
                <li <?php if(count($this->siteConfig['maiFangQQ'])==$k+1): ?>class="last"<?php endif; ?>><i class="kanfangicon icon-30"></i><a href="<?php echo $v['link']?$v['link']:'javascript:;'; ?>" target="_blank"><?php echo $v['name']; ?><br><?php echo $v['number']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        </dt>
        <dd><i class="kanfangicon icon-28"></i></dd>
    </dl>
    <?php endif; ?>
    <dl class="item tuangou">
        <a href="<?php echo $this->createUrl('/home/special/tuan'); ?>" target="_blank">
            <dt>团购<br/>楼盘</dt>
            <dd><i class="kanfangicon icon-20"></i></dd>
        </a>
    </dl>
    <dl class="item">
        <a href="<?php echo $this->createUrl('/home/news/index'); ?>" target="_blank">
            <dt>热门<br/>资讯</dt>
            <dd><i class="kanfangicon icon-21"></i></dd>
        </a>
    </dl>
    <dl class="item">
        <a href="<?php echo $this->createUrl('/home/plot/list'); ?>" target="_blank">
            <dt>最新<br/>新房</dt>
            <dd><i class="kanfangicon icon-22"></i></dd>
        </a>
    </dl>

    <?php if($this->siteConfig['enableSchool']): ?>
    <dl class="item">
        <a href="<?php echo $this->createUrl('/home/school/index'); ?>" target="_blank">
            <dt>邻校<br/>楼盘</dt>
            <dd><i class="kanfangicon icon-23"></i></dd>
        </a>
    </dl>
    <?php endif; ?>

    <?php if($this->siteConfig['esfUrl']): ?>
    <dl class="item">
        <a href="<?php echo $this->siteConfig['esfUrl']; ?>" target="_blank">
            <dt>二手<br/>房</dt>
            <dd><i class="kanfangicon icon-24"></i></dd>
        </a>
    </dl>
    <?php endif; ?>
    <?php if($this->siteConfig['weixinQrCode']): ?>
    <dl class="item">
        <dt>关注<br/>微信
            <div class="weixin-box">
                <span class="right-arrow"><span></span></span>
                <div class="weixin-img">
                    <img src="<?php echo ImageTools::fixImage($this->siteConfig['weixinQrCode']); ?>">
                    <p class="c-g6">关注房产微信</p>
                    <p class="c-e">获取更多优惠</p>
                </div>
            </div>

        </dt>
        <dd><i class="kanfangicon icon-29"></i></dd>
    </dl>
    <?php endif; ?>
    <dl class="gotoTop">
        <dd><i class="kanfangicon icon-25"></i></dd>
    </dl>
</div>
<!-- 没备注的按钮加class:k-dialog-type-1，有备注的按钮加class:k-dialog-type-2 -->
<div style="display:none"><?php echo $this->siteConfig['siteStatistic']; ?></div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/home/js/common.js"></script>
</body>
</html>
