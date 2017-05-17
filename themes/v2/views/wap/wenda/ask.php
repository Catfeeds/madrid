<?php
$this->pageTitle = SM::urmConfig()->cityName().'我要提问_'.SM::urmConfig()->cityName().'买房问题-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网，'.SM::GlobalConfig()->siteName().'，'.SM::urmConfig()->cityName(),'keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/qa.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'我要提问']) ?>


<div class="blank20"></div>

<form class="zx-box" id="validform" method="post" data-isajax="false" action="<?=$this->createUrl('wenda/deal')?>">
    <ul>
        <li>
            <div><textarea placeholder="请输入你要咨询的问题，房产顾问团快速帮你解答" datatype="*" name="question" nullmsg="*请输入你要咨询的问题" sucmsg=" "></textarea></div>
            <div class="error-txt Validform_checktip"></div>
        </li>
        <li>
            <div><input type="text" datatype="*" name="name" class="input_txt" nullmsg="*请正确填写姓名" placeholder="请输入姓名" errormsg="*请正确填写姓名" sucmsg=" "></div>
            <div class="error-txt Validform_checktip"></div>
        </li>
        <li>
            <div><input type="phone" datatype="m" name="phone" class="input_txt" nullmsg="*请输入正确的手机号码" placeholder="请输入正确的手机号码" errormsg="*请输入正确的手机号码" sucmsg=" "></div>
            <div class="error-txt Validform_checktip"></div>
        </li>
        <li>
            <input type="hidden" value="<?=isset($hid)?$hid:0?>" name="hid"></input>
            <input type="submit" class="btn" id="btn_sub" value="我要提问">
        </li>
    </ul>
</form>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
            <?php if($msg):?>
                alterPop('提交失败');

            <?php endif;?>
        });

    <?php Tools::endJs('searchbaike'); ?>
</script>
