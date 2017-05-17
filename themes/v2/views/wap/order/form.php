<?php
$this->pageTitle = $title ? $title : '请填写信息';
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>

<?php $this->renderPartial('/layouts/header',['title'=>'提交订单']) ?>

<!-- 顶部结束 -->

<!-- 内容开始 -->
<section class="container">
    <div class="order-submit">
        <div class="title"><?php echo Tools::u8_title_substr($plotName ,25); ?></div>
        <?php $form = $this->beginWidget('CActiveForm', array('action'=>$this->createUrl('/wap/order/deal'),'id'=>'yuyueform')); ?>
        <div class="form">
            <dl>
                <?php if($title): ?>
                <dt class="s-title"><span>标&nbsp;&nbsp;题：</span><em><?=$title; ?></em></dt>
                <?php endif; ?>
                <dt class="s-title"><span>类&nbsp;&nbsp;型：</span><em><?php echo $model->spm_b; ?></em></dt>
                <dd>
                    <?php echo $form->textField($model, 'name', ['datatype'=>'*','nullmsg'=>'*请填写正确姓名','placeholder'=>'请输入姓名','errormsg'=>'*请正确填写姓名', 'sucmsg'=>'']); ?>
                    <div class="error-msg Validform_checktip"></div>
                </dd>
                <dd>
                    <?php echo $form->numberField($model, 'phone', ['datatype'=>'m','nullmsg'=>'*请输入正确的手机号码','placeholder'=>'请输入正确的手机号码','errormsg'=>'*请输入正确的手机号码','sucmsg'=>'']); ?>
                    <div class="error-msg Validform_checktip"></div>
                </dd>
                <?php if(SM::pageUrlConfig()->tradeTermsUrl()): ?>
                <dd>
                    <div class="check-content clearfix">
                        <input type="checkbox"  class="checkbox" name="check" datatype="*" nullmsg="请选择阅读并同意" errormsg="请阅读协议后选择同意" sucmsg="">
                        <div class="error-msg Validform_checktip"></div>
                        <div class="tst"><span>我已阅读并同意</span><a href="<?=SM::pageUrlConfig()->tradeTermsUrl(); ?>" target="_blank">《<?=SM::GlobalConfig()->siteName()?>新房委托服务协议》</a></div>
                    </div>
                </dd>
                <?php endif; ?>
                <dd>
                    <?php echo $form->hiddenField($model, 'spm'); ?>
                    <?php echo CHtml::hiddenField('url', Yii::app()->request->getUrlReferrer()?Yii::app()->request->getUrlReferrer():$this->createUrl('/wap/index/index')); ?>
                    <input type="submit" class="btn" id="btn_sub" value="立即报名">
                    <!-- <div class="error-msg tac" id="error-result"><?=Yii::app()->user->hasFlash('error')?Yii::app()->user->getFlash('error'):'';?></div> -->
                </dd>
            </dl>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</section>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
        });
    <?php Tools::endJs('searchbaike'); ?>
    document.body.className += ' bg-f7';

</script>
