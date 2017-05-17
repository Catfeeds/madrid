<?php
$this->pageTitle = '提交结果';
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css');
?>

<?php $this->renderPartial('/layouts/header',['title'=>'提交'.(Yii::app()->user->hasFlash('success')?'成功':'失败')]) ?>

<!-- 顶部结束 -->

<!-- 内容开始 -->
<section class="container">
    <div class="submit-success">
    	<i class="iconfont">&#x2571;</i>
    	<h2><?php echo Yii::app()->user->getFlash('success'); ?></h2>
    	<p><?php if(Yii::app()->user->hasFlash('error')):  echo Yii::app()->user->getFlash('error'); else: echo SM::GlobalConfig()->siteName(); ?>房产顾问将会与您联系<br>请保持手机畅通<?php endif; ?></p>
    </div>
</section>

<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
