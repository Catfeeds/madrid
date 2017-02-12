<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7, IE=9">
    <title><?php echo $this->pageTitle ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl?>/static/home/style/head.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl?>/static/home/style/common.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/baidu_ad.css"/>
    <script>
        var urmHost = "<?php echo Yii::app()->params['urmHost']?>";
        var basedir = "<?php echo Yii::app()->theme->baseUrl?>/static/home/js/";
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/static/home/js/do.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/static/home/js/common.js"></script>
</head>
<?php echo $content;?>
<div class="blank20"></div>
 <div class="wapper-out bg-ee">
    <?php echo SM::globalConfig()->siteFooter(); ?>
</div>
<?php
if($this->showFloatMenu):
$siteQq = SM::globalConfig()->siteQq();
 ?>
<div class="float-menu">
    <?php if($siteQq['number'][0]): ?>
    <dl class="item">
        <dt><a href="<?php echo $this->createUrl('/home/adviser/index'); ?>" target="_blank" class="online">在线<br/>咨询</a>
        <div class="online-box">
            <span class="right-arrow"><span></span></span>
            <ul>
                <?php foreach($siteQq['number'] as $k=>$v): ?>
                <li <?php if(count($siteQq)==$k+1): ?>class="last"<?php endif; ?>><i class="kanfangicon icon-30"></i><a href="<?php echo $siteQq['url'][$k]?$siteQq['url'][$k]:'javascript:;'; ?>" target="_blank"><?php echo $siteQq['name'][$k]; ?><br><?php echo $siteQq['number'][$k]; ?></a></li>
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
            <dt>新房<br/>一览</dt>
            <dd><i class="kanfangicon icon-22"></i></dd>
        </a>
    </dl>

    <?php if(SM::schoolConfig()->enable()): ?>
    <dl class="item">
        <a href="<?php echo $this->createUrl('/home/school/index'); ?>" target="_blank">
            <dt>邻校<br/>楼盘</dt>
            <dd><i class="kanfangicon icon-23"></i></dd>
        </a>
    </dl>
    <?php endif; ?>

    <?php if(SM::pageUrlConfig()->esfListUrl()): ?>
    <dl class="item">
        <a href="<?php echo SM::pageUrlConfig()->esfListUrl(); ?>" target="_blank">
            <dt>二手<br/>房</dt>
            <dd><i class="kanfangicon icon-24"></i></dd>
        </a>
    </dl>
    <?php endif; ?>
    <?php if(SM::globalConfig()->weixinQrCode()): ?>
    <dl class="item">
        <dt>关注<br/>微信
            <div class="weixin-box">
                <span class="right-arrow"><span></span></span>
                <div class="weixin-img">
                    <img src="<?php echo ImageTools::fixImage(SM::globalConfig()->weixinQrCode()); ?>">
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
<?php endif; ?>
<!-- 没备注的按钮加class:k-dialog-type-1，有备注的按钮加class:k-dialog-type-2 -->
<script type="text/javascript">
    var csrf = "<?php echo Yii::app()->request->getCsrfToken(); ?>";
    var loginUrl = "<?=$this->createUrl('/api/bbs/newLogin'); ?>";
    var logoutUrl = "<?=Yii::app()->uc->logoutPageUrl; ?>";
    var userinfoUrl = "<?=$this->createUrl('/api/bbs/userInfo'); ?>";
    var userCenterUrl = "<?php $commonHeader = SM::urmConfig()->commonHeader();echo isset($commonHeader['userinfoUrl']) ? $commonHeader['userinfoUrl'] : ''; ?>";
    var orderApi = "<?php echo $this->createUrl('/api/order/ajaxSubmit'); ?>";
    var tradeTermsUrl = "<?php echo SM::pageUrlConfig()->tradeTermsUrl(); ?>";
    var noPicUrl = "<?php echo ImageTools::fixImage(SM::globalConfig()->siteNoPic()); ?>";
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
            $('#searchtxt').focus(function(){
            var kw =$('#searchtxt').val();
            // alert(kw);
            if(kw.length >= 1 && $('#action-selected').html()=="新房")
            {
                 $('.search-about').find('ul').css('display','block');
                 $.ajax({
                    'url' : '<?=$this->createUrl('/api/plot/AjaxGetPlot')?>',
                    'type' : 'get',
                    'data' : {'kw':kw},
                    'dataType' : 'json',
                    'success' : function( data ) {
                        if( data.length > 0 ){
                            $('.search-about').find('li').remove();
                            for( var i=0; i<data.length; i++ ){
                                $('.search-about').find('ul').append("<li><p><a href='"+data[i]['url']+"' target='_blank'>"+data[i]['name']+"<span>["+data[i]['area']+"]</span></a></p></li>");
                            }
                        }
                    }

                });
            }
        });
        //键入文本时进行ajax请求
        $('#searchtxt').keyup(function(){
            var kw =$('#searchtxt').val();
            // alert(kw);
            if(kw.length >= 1 && $('#action-selected').html()=="新房")
            {
                 $('.search-about').find('ul').css('display','block');
                 $.ajax({
                    'url' : '<?=$this->createUrl('/api/plot/AjaxGetPlot')?>',
                    'type' : 'get',
                    'data' : {'kw':kw},
                    'dataType' : 'json',
                    'success' : function( data ) {
                        if( data.length > 0 ){
                            $('.search-about').find('li').remove();
                            for( var i=0; i<data.length; i++ ){
                                if(data[i]['recordname']){
                                    $('.search-about').find('ul').append("<li><p><a href='"+data[i]['url']+"' target='_blank'>"+data[i]['name']+"("+data[i]['recordname']+")<span>["+data[i]['area']+"]</span></a></p></li>");
                                }
                                else
                                    $('.search-about').find('ul').append("<li><p><a href='"+data[i]['url']+"' target='_blank'>"+data[i]['name']+"<span>["+data[i]['area']+"]</span></a></p></li>");
                            }
                        }
                    }

                });
            }
            else
            {
                //文本长度为空点列表消失
                $('.search-about').find('ul').css('display','none');
                $('.search-about').find('li').remove();
            }

        });
        //搜索区域失去焦点列表消失
        $(document).not($(".search-about")).click(function(){
            $('.search-about').find('ul').css('display','none');
            $('.search-about').find('li').remove();
        });
        });
    }
</script>
<div style="display:none"><?php echo SM::globalConfig()->pcStatistic(); ?></div>
<?php if(!in_array($this->route,['home/plot/comment'])): ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/static/home/js/modernizr.custom.js"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/static/home/js/main.js"></script>
</body>
</html>
