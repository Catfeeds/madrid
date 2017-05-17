<?php
$this->pageTitle = '提交结果';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/qa.css');
$this->registerHeadJs(['640resize']);
?>
<header class="ui-title-bar">
    <a href="<?php echo $returnUrl;?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1>提交结果</h1>
    <div class="fr ui-operate layer-sub-btn down"><p class="icon icon-guide"></p><p>导航</p></div>
    <?php $this->renderPartial('/layouts/nav')?>
    <div class="layer-subnav-bg"></div>
</header>
<div class="tips-box">
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <i class="icon icon-error">&nbsp;</i>
    <p class="tac"><?php echo Yii::app()->user->getFlash('error'); ?></p>
<?php elseif(Yii::app()->user->hasFlash('success')): ?>
    <i class="icon icon-ok">&nbsp;</i>
    <p class="tac">恭喜您，提交成功！<br>
        工作人员会与您取得联系</p>
<?php endif;?>
    <a href="<?php echo $returnUrl; ?>" class="btn-success">知道了</a>
</div>
<div class="blank40"></div>
<!--
<div class="tips-box">
    <i class="icon icon-warning">&nbsp;</i>
    <p class="tac">请不要重复提交</p>
    <a href="" class="btn-success">知道了</a>
</div>
<div class="blank40"></div>
 -->

<!--
<div class="tips-box">
    <i class="icon icon-ok">&nbsp;</i>
    <p class="tac">恭喜您，报名成功！<br>
        有合适的看房活动，工作人员会与您取得联系</p>
    <a href="" class="btn-success">知道了</a>
</div>

<div class="tips-box">
    <i class="icon icon-ok">&nbsp;</i>
    <p class="tac">提交成功，我们会尽快与您取得联系</p>
    <a href="" class="btn-success">知道了</a>
</div> -->
