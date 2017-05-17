<!DOCTYPE html>
<html lang="en" ng-app="myApp" ng-controller="adController">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/static/wap/style/common.css" >
  <title><?php echo $this->pageTitle;?></title>
</head>
<script>
    var urmHost = "<?php echo Yii::app()->params['urmHost']?>";
</script>
<?php $this->registerHeadJs(['jquery-2.1.4.min','jquery.lazyload.min']); ?>
<body>
<?php if(Yii::app()->user->hasFlash('info')): ?>
    <div class="errormsg"><?php echo Yii::app()->user->getFlash('info'); ?></div>
    <script type="text/javascript">
    <?php Tools::startJs(); ?>
        setTimeout(function(){
                $('.errormsg').slideUp();
        },3000);
        $('.errormsg').click(function(){
            $(this).slideUp();
        });
    <?php Tools::endJs('js'); ?>
    </script>
<?php endif;?>
<?php echo $content; ?>
<div class="gototop icon icon-goto-top"></div>
<div class="blank30"></div>
<footer>
    <ul class="clearfix">
        <li><a href="/wap" class="active">触屏版</a></li>
        <li><a href="<?php echo $this->createUrl('/wap/index/redirectPc'); ?>">电脑版</a></li>
        <li><a href="<?php echo $this->siteConfig['appDownload']; ?>" target="_blank">客户端</a></li>
    </ul>
    <p>©2015 <?php echo $this->siteConfig['siteName']; ?> 版权所有</p>
</footer>
<script type="text/javascript">
    var basedir = "<?php echo Yii::app()->baseUrl?>/static/wap/js/";
    var noPicUrl = "<?php echo ImageTools::fixImage($this->siteConfig['siteNoPic']); ?>";
</script>
</body>
</html>

<div style="display: none">
    <?php echo $this->siteConfig['wapStatistic']; ?>
</div>
