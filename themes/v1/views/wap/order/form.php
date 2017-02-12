<?php
$this->pageTitle = $title ? $title : '请填写信息';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['main']);
?>
<!--头部 begin-->
<header class="ui-title-bar">
    <a href="<?php echo Yii::app()->user->returnUrl;?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $this->t($model->spm_b); ?></h1>
    <?php $this->renderPartial('/layouts/nav'); ?>
</header>
<!--头部 end-->
<div class="blank20"></div>
<!--通知表单 begin-->
<div class="gw loupannote">
    <?php if($title): ?>
    <div class="allnotes">
        <h3 class="fs30"><?php echo $title; ?></h3>
    </div>
    <?php endif; ?>
    <div class="blank20"></div>
    <!--表单 begin-->
    <div class="note-form">
        <?php $form = $this->beginWidget('CActiveForm', array('action'=>$this->createUrl('/wap/order/deal'))); ?>
            <p class="ele text">
                <?php echo $form->textField($model, 'name', array('placeholder'=>'输入您的姓名')); ?>
            </p>
            <div class="blank20"></div>
            <p class="ele text">
                <?php echo $form->textField($model, 'phone', array('placeholder'=>'输入您的电话')); ?>
            </p>
            <div class="blank20"></div>
            <p class="ele textarea">
                <?php echo $form->textArea($model, 'note', array('cols'=>30, 'rows'=>10, 'placeholder'=>'特殊需求请在此说明（非必填）')); ?>
            </p>
            <div class="blank20"></div>
            <p class="ele submit">
                <?php echo $form->hiddenField($model, 'spm', array('value'=>$model->spm)); ?>
                <input type="submit" value="提交" />
            </p>
        <?php $this->endWidget(); ?>
    </div>
    <!--表单 end-->
</div>
<!--通知表单 end-->
