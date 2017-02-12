<!DOCTYPE html>
<html lang="en" ng-app="myApp" ng-controller="adController">
<head>
    <script>
        var basedir = '<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/js/';
    </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
  <title><?php echo $this->pageTitle;?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/common.css" media="all" />
  <?php if(SM::globalConfig()->appleTouchIcon()): ?>
  <link rel="apple-touch-icon" sizes="72x72" href="<?=ImageTools::fixImage(SM::GlobalConfig()->appleTouchIcon(),72,72); ?>" />
  <link rel="apple-touch-icon" sizes="114x114" href="<?=ImageTools::fixImage(SM::GlobalConfig()->appleTouchIcon(),114,114); ?>" />
  <?php endif; ?>
  <?php $this->registerHeadJs(['640rem']); ?>
</head>
    <!-- body标签在另两个布局 -->
    <?php echo $content; ?>
    <?php if(strpos(Yii::app()->request->getUserAgent(),'MicroMessenger')===false && !$this->getIsInQianFan()): ?>
    <div class="gototop"></div>
    <?php endif?>
    <script>
    var noPicUrl = "<?=ImageTools::fixImage(SM::globalConfig()->siteNoPic()); ?>"
    </script>
    <?php if((($this->id=='plot'&&$this->action->id=='list')||($this->id=='index'&&$this->action->id=='index'))&&SM::EsfLinkConfig()->enableEsfLink()): ?>
        <div class="blank120"></div>
        <footer>
            <ul class="clearfix">
                <li>
                    <a href="<?php echo $this->createUrl('/wap');?>"><span class="icon-i-home <?php if($this->id=='index') echo 'on';?>"></span>首页</a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/plot/list');?>"><span class="icon-i-new <?php if($this->id=='plot') echo 'on';?>"></span>新房</a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('/resoldwap')?>"><span class="icon-i-resold"></span>二手房</a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('/resoldhome/my/index')?>"><span class="icon-i-user"></span>我的</a>
                </li>
            </ul>
        </footer>
    <?php endif; ?>
    <script>
        var urmHost = "<?php echo Yii::app()->params['urmHost']?>";
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl.'/static/wap/js/do.js'; ?>" ></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl.'/static/wap/js/layout.js'; ?>"></script>
    <?php
        $this->beginWeChat();
        $this->onMenuShareTimeline($this->getWxShareImg(), $this->getWxShareTitle());
        $this->onMenuShareAppMessage($this->getWxShareImg(), $this->getWxShareTitle(), $this->pageDescription);
        $this->endWeChat();
     ?>
    <div style="display: none">
        <?php echo SM::globalConfig()->wapStatistic(); ?>
    </div>
</body>
</html>
