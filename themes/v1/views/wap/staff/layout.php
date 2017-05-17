<?php
$this->beginContent('/layouts/base');
$this->registerHeadJs(['640resize','jquery-2.1.4.min']);
 ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/gj.css'); ?>
<div class="gj <?php echo $this->action->id=='detail' ? 'gj-detail' : 'gj-index '; ?>">
    <div class="header">
        <?php if($this->action->id!='index'): ?>
        <a href="<?php echo $this->backUrl; ?>" class="back"><i class="icon icon-black-arrow"></i></a>
        <?php endif; ?>
        <h1><?php echo $this->pageTitle; ?></h1>
        <a href="<?php echo $this->createUrl('/wap/staff/logout'); ?>" class="quit"><i class="icon icon-exit"></i>退出</a>
    </div>
    <?php echo $content; ?>
</div>

<?php $this->endContent(); ?>
