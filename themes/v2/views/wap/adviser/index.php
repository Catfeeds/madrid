<?php
$this->pageTitle = SM::GlobalConfig()->siteName().'买房顾问-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('买房顾问，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag('特色买房顾问整装待发为您提供专业贴心的房产服务','description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />

<header class="buy-banner">
    <div class=" top-mark"></div>
    <?php $this->renderPartial('/layouts/header',['search'=>false]); ?>
    <img src="<?php echo SM::adviserConfig()->wapMascot() ? ImageTools::fixImage(SM::adviserConfig()->wapMascot()):Yii::app()->theme->baseUrl.'/static/wap/images/buy_banner.jpg'; ?>" class="banner-img">
    <img src="<?php echo Yii::app()->theme->baseUrl.'/static/wap/images/process.png';?>" class="process-img">
    <div class=" bottom-mark"></div>
</header>
<div class="free-see-house content-box">
    <p class="buy-title">预约免费看房</p>
    <div class="blank30"></div>
    <form id="yzform" action="<?=$this->createUrl('/wap/order/kanDeal'); ?>">
        <ul class="gw">
            <li class="clearfix">
                <div class="fl">
                    <label class="name"><i class="iconfont">&#x3000;</i><input type="text" placeholder="您的姓名" class="short-txt" datatype="*" nullmsg="*请正确填写姓名" name="name"></label>
                    <p class="error-txt"></p>
                </div>
                <div class="fr">
                    <label class="tel"><i class="iconfont">&#x3001;</i><input type="phone" placeholder="您的手机号" class="short-txt" datatype="m" nullmsg="*输入您的手机号码" errormsg="*请正确填写手机号码" name="phone"></p>
                    <p class="error-txt"></label>
                </div>
            </li>
            <?php echo CHtml::hiddenField('spm', $spm); ?>
            <li>
                <label class="plot"><i class="iconfont">&#x3004;</i><input type="text" placeholder="输入购房区域或楼盘名称，可填多个" class="long-txt"  value="<?=$plot; ?>" datatype="*" nullmsg="*请输入楼盘名" name="loupan"></label>
                <p class="error-txt"></p>
            </li>
            <li class="clearfix">
                <label class="price"><i class="iconfont">&#x3002;</i><input type="nub" name="jiage" placeholder="请输入预算价格" datatype="n" nullmsg="*请填写预算价格" class="long-txt"><span class="fr">万</span></label>
                <p class="error-txt"></p>
            </li>
            <li class="clearfix">
                <label class="ui-form-label" for="one_room">
                    <input type="checkbox" name="huxing[]" value="一居" id="one_room" class="ui-input-checkbox" />
                    一居</label>
                <label class="ui-form-label" for="two_room">
                    <input type="checkbox" name="huxing[]" value="二居" id="two_room" class="ui-input-checkbox"/>
                    二居</label>
                <label class="ui-form-label" for="three_room">
                    <input type="checkbox" name="huxing[]" value="三居" id="three_room" class="ui-input-checkbox" />
                    三居</label>
                <label class="ui-form-label" for="four_room">
                    <input type="checkbox" name="huxing[]" value="四居" id="four_room" class="ui-input-checkbox"/>
                    四居</label>
                <label class="ui-form-label" for="five_oom">
                    <input type="checkbox" name="huxing[]" value="五居以上" id="five_oom" class="ui-input-checkbox"/>
                    五居以上</label>
                <p class="error-txt"></p>
            </li>
            <li><label class="desc"><i class="iconfont">&#x3003;</i><input type="text" placeholder="请输入备注" class="long-txt" name="note"></label></li>
            <li> <input type="submit" class="free-see-btn" value="免费预约看房"></li>
        </ul>
        <!-- <p class="error-txt" id="form-result" style="text-align:center"></p> -->
    </div>
</form>
<div class="blank20"></div>
<?php if(SM::adviserConfig()->enable()&&$comments):?>
<div class="evaluate-box content-box">
    <p class="buy-title">对<?=$this->t('房大白')?>的评价</p>
    <ul>
    <?php foreach ($comments as $key => $comment) {?>
        <li>
            <p><?=$comment['content']?></p>
            <P><span>游客</span><span>发表于<?=date('Y-m-d H:i:s',$comment['created'])?></span></P>
        </li>
    <?php }?>
    </ul>
</div>
<?php endif;?>
<?php if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && SM::globalConfig()->weixinQrCode()): ?>
<div class="erweima-box">
    <p class="buy-title"><?=$this->t('房大白')?>微信</p>
    <img src="<?=ImageTools::fixImage(SM::globalConfig()->weixinQrCode())?>">
    <p class="promite">关注<?=SM::GlobalConfig()->siteName()?>房产微信，获取更多优惠信息</p>
</div>
<?php endif; ?>
<div class="blank20"></div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    Do('validform',function(){
            $('#yzform').Validform({
                tipSweep:true,
                ajaxPost:true,
                tiptype:function(msg,o,cssctl){
                    var $errormsg=o.obj.parent().siblings('.error-txt');
                        if(o.type === 3){

                           $errormsg.text(msg);

                        }else if (o.type === 2){
                            $errormsg.text('');
                        }
                },
                callback:function(d){
                    alertPop(d.msg);
                }
            });
    });



    <?php Tools::endJs('js'); ?>
</script>
