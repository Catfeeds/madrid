<?php
$this->pageTitle = '添加意向楼盘';
$form = $this->beginWidget('CActiveForm');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/wap/js/main.js',CClientScript::POS_END);

?>
<div class="gj gj-detail gj-add">
    <?php $this->renderPartial('_header'); ?>
    <div class="main">
        <div class="ui-datetime ui-datetime-time">
            <label class="ui-datetime-label">选择楼盘</label><input class="ui-datetime-input" type="text" id="search-box" placeholder="请输入关键词查询" data-url="<?php echo $this->createUrl('ajaxSearchPlot'); ?>" value="<?php echo $model->plot ? $model->plot->title : ''; ?>">
        </div>
        <?php echo $form->hiddenField($model, 'hid'); ?>
        <ul class="area-search-list"></ul>
        <div class="other-item">
            <?php echo CHtml::submitButton('保存', array('class'=>'button em-1 save-btn')); ?>
        </div>
        <?php foreach(AreaExt::model()->parent()->normal()->findAll() as $k=>$area): ?>
            <dl class="area-block">
                <dt><?php echo $area->name; ?><i class="iconfont arrow <?php if(!$k) echo 'on'; ?>"></i></dt>
                <?php $this->actionAjaxGetAreaPlot($area->id); ?>
                <dd class="area-block-item more-btn"><a href="javascript:;" data-url="<?php echo $this->createUrl('/wap/staff/ajaxGetAreaPlot'); ?>" data-area="<?php echo $area->id; ?>"><i class="more-btn-add-icon"></i>更多楼盘</a></dd>
            </dl>
        <?php endforeach; ?>
    </div>
    <?php $this->endWidget(); ?>

