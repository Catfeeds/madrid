<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/qa.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
 ?>

<header class="ui-title-bar">
    <a href="<?php echo Yii::app()->user->returnUrl; ?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1>我要咨询</h1>
    <div class="fr ui-operate layer-sub-btn down"><p class="icon icon-guide"></p><p>导航</p></div>
<?php $this->renderPartial('/layouts/nav')?>
    <div class="layer-subnav-bg"></div>
</header>
<div class="blank20"></div>
<div class="gw">
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class' => 'bg-fff zx-box'
        )
    ));
    ?>
    <?php
        echo $form->textArea($ask,'question',array('placeholder'=>'请输入你要咨询的问题，房产顾问团快速帮你解答'));
        echo $form->textField($ask,'name',array(
            'class' => 'input_txt',
            'placeholder' => '输入您的姓名',
            'datatype' => '*',
            'nullmsg' => '请填写姓名'
        ));
        echo $form->textField($ask,'phone',array(
            'class' => 'input_txt',
            'placeholder' => '输入您的电话',
            'datatype' => 'p',
            'nullmsg' => '请填写手机号码',
            'errormsg' => '手机号码格式不正确'
        ));
        echo $form->hiddenField($ask,'hid',array('value'=>$hid));
    ?>
    <button type="submit" class="btn">我要咨询</button>
    <?php
        $this->endwidget()
    ?>
</div>
<div class="blank80"></div>
