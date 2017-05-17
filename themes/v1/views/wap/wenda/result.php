<?php
$this->pageTitle = $rs=='success'?'提交成功':'提交失败';
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
 ?>
<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('/wap/wenda/ask',array('hid'=>$hid))?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1>我要咨询</h1>
    <div class="fr ui-operate layer-sub-btn down"><p class="icon icon-guide"></p><p>导航</p></div>
<?php $this->renderPartial('/layouts/nav')?>
    <div class="layer-subnav-bg"></div>
</header>
<?php
if($rs == 'success'):
    ?>
    <div class="tips-box">
        <i class="icon icon-ok">&nbsp;</i>
        <p class="tac">恭喜您，提交成功！<br>
            我们的买房顾问会尽快回复您的疑问</p>
        <a href="<?php echo Yii::app()->user->getReturnUrl(Yii::app()->request->getUrlReferrer());?>" class="btn-success">知道了</a>
    </div>
    <div class="blank40"></div>
<?php
elseif($rs == 'warnning'):
?>
<div class="tips-box">
    <i class="icon icon-warning">&nbsp;</i>
    <p class="tac">请不要重复提交</p>
    <a href="<?php echo $this->createUrl('/wap/wenda/ask',array('hid'=>$hid))?>" class="btn-success">知道了</a>
</div>
<div class="blank40"></div>
<?php
else:
?>
<div class="tips-box">
    <i class="icon icon-error">&nbsp;</i>
    <p class="tac">
        出错啦 <br>
        您提交的信息有误！<br />
        <?php echo $msg;?>
    </p>
    <a href="<?php echo $this->createUrl('/wap/wenda/ask',array('hid'=>$hid))?>" class="btn-success">知道了</a>
</div>
<?php
    endif;
?>
