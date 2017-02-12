<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/common.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/gj.css?t=2'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/wap/js/jquery-2.1.4.min.js');
$this->registerHeadJs(['640resize']);
?>
<!--头部 begin-->
<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="" class=" "><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?>"></a></div>
    <span class="ml10 mr10 c-gc fl fs32">|</span>
    <span class="fl fs32 gc3"> 购房管家</span>
</header>
<!--头部 end-->
<div class="gj gj-login gj-login-bg">
    <div class="main">
        <h2>管家登录</h2>
        <form class="form" action="" method="post">
            <p class="ele"><input id="" type="text" name="username" placeholder="用户名"/></p>
            <p class="ele"><input id="" type="password" name="password" placeholder="密码"/></p>
            <p class="subbtn"><input type="submit" value="立即登录" /></p>
        </form>
    </div>
</div>
