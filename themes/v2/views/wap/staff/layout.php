<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        var basedir = '<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/js/';
    </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
  <title><?php echo $this->pageTitle;?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/common.css" media="all" />
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/gj.css" media="all" />
  <?php
  Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/wap/js/jquery.min.js');
  $this->registerHeadJs(['640rem']);
  ?>
<?php if(Yii::app()->user->hasFlash('info')): ?>
    <div class="errormsg"><?=Yii::app()->user->getFlash('info'); ?></div>
<?php endif; ?>

</head>
<body>
<?=$content; ?>
</body>
</html>
<script type="text/javascript">
        setTimeout(function(){
                $('.errormsg').fadeOut(300);
        },3000);
</script>
