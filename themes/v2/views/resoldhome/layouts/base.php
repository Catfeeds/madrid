<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
  <title><?php echo $this->pageTitle ?></title>
    <meta name="keywords" content="<?php echo $this->keyword; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo $this->staticPath; ?>/style/global.css" media="all" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->staticPath; ?>/style/common.css" media="all" />
  <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/static/home/style/baidu_ad.css"/>
  <script type="text/javascript">
        var urmHost = "<?php echo Yii::app()->params['urmHost']?>";
        var basedir = '<?php echo $this->staticPath; ?>/js/';
    </script>
    <script type="text/javascript" src="<?php echo $this->staticPath; ?>/js/do.js"></script>
    <script type="text/javascript" src="<?php echo $this->staticPath; ?>/js/main.js"></script>
</head>
<body>
<div class="wapper-out nav-bg ovisible">
    <div class="wapper nav clearfix ovisible">
    	<div class="logo"><a href="<?php echo $this->createUrl('/resoldhome');?>"><img src="<?=ImageTools::fixImage(SM::resoldImageConfig()->resoldPCSiteLogo())?>"></a></div>
        <?php
         $this->widget('TopMenu');
        ?>
        <?php if(SM::ucConfig()->enableLogin()): ?>
        <div class="login">
            <?php if(Yii::app()->uc->user->getisGuest()):  ?>
        	<a href="<?php  echo $this->loginUrl; ?>" class="name" target="_blank">登录</a><em>|</em><a href="<?php echo $this->registerUrl; ?>" target="_blank">注册</a>
            <?php else: ?>
            <a href="<?php echo $this->createUrl('/resoldhome/my/index')?>" class="name"><?php echo Yii::app()->uc->user->username; ?></a><em>|</em><a href="<?php echo Yii::app()->uc->getLogoutPageUrl($this->currentUrl) ?>">退出</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?=$content?>
<!-- <div class="wapperout">
    <div class="wapper">
        <div class="p-current">当前位置：<a href="/">常州房产</a>&gt;<span></span><span>常州新房</span></div>
    </div>
    <div class="line"></div>
</div> -->

<?php $this->widget('CommonWidget',['type'=>2])?>
<div class="blank20"></div>
<?php if(!strstr(Yii::app()->request->getPathInfo(),'resoldhome/map/index')):?>
<div class="wapper-out bg-ee">
<?php echo SM::globalConfig()->siteFooter()?SM::globalConfig()->siteFooter():'<div class="wapper">
        <div id="footer">
            <p>
                <span>
                    <a href="http://www.lccz.com" target="_blank">企业官网</a>&nbsp;|&nbsp;
                    <a href="http://about.hualongxiang.com/join.php" target="_blank">诚聘英才</a>&nbsp;|&nbsp;
                    <a href="http://about.hualongxiang.com/link.php" target="_blank">友情链接</a>&nbsp;|&nbsp;
                    <a href="http://about.hualongxiang.com/lawfirm.php" target="_blank">法律声明</a>&nbsp;|&nbsp;
                    <a href="http://about.hualongxiang.com/ad_contact.php" target="_blank">商业合作</a>&nbsp;|&nbsp;
                    <a href="http://about.hualongxiang.com/help.php" target="_blank">帮助中心</a>&nbsp;|&nbsp;
                    <a href="http://house.hualongxiang.com/wap">WAP版</a>
                </span>
                <br>
                <span>广告热线：400 970 0519 转 8888 传真：0519-86601957 投诉受理：400 970 0519 转 9999 法律顾问：江苏正气浩然律师事务所  周建斌律师</span><br>
                <span>
                    版权所有:常州化龙网络科技股份有限公司 &nbsp;信息产业部备案/许可证编号：<a href="http://www.miitbeian.gov.cn" target="_blank">苏ICP备06048007号</a>&nbsp;
                    <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=32041102000005"><img src="http://www.hualongxiang.com/images/beian.png"><em class="mr5">苏公网安备 32041102000005号</em></a>&nbsp;经营性ICP：苏B2-20120430号&nbsp;
                </span>
                <a href="http://www.miitbeian.gov.cn/" target="_blank"></a>
            </p>
        </div>
    </div>'; ?>
    
</div>
<?php endif;?>

    <script type="text/template" id="pop-tpl">
    <div class="pop-box validform">
        <div class="title">
            <span>举报虚假房源</span>
            <a href="javascript:void(0)" class="iconfont close-ico popup-close">&#xe60d;</a>
        </div>
        <form>
            <div class="ui-dialog">
                <p>
                  <label>
                    <input class="post_reason" type="radio" name="post_infoname" value="单选" data-reason="房源不存在/房源已售" checked/>
                    房源不存在/房源已售</label>
                  <label>
                    <input class="post_reason"  type="radio" name="post_infoname" value="单选" data-reason="房源信息不真实"/>
                    房源信息不真实</label>
                </p>
                <p><textarea placeholder="详细举报理由请在此处填写（100个汉字）" name="content" id="post_content" datatype="*" nullmsg="请输入举报理由"></textarea></p>
                <p>您的手机号：<input type="tel" placeholder="请输入您的手机号" class="txt" maxlength="11" datatype="m" nullmsg="请输入手机号" errormsg="请输入正确的手机号" name="phone" id="post_phone"></input></p>
                <p>短信验证码：<input type="number" placeholder="请输入短信验证码" class="txt"></input><input type="button" class="yzm-btn" value="获取"></input></p>
                <input type="submit" value="立即举报" class="tj-btn"></input>
            </div>
        </form>
    </div>
</script>
</body>
<div style="display:none"><?php echo SM::resoldConfig()->resoldPcStatistic(); ?></div>

</html>
