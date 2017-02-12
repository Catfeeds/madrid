<?php
$this->pageTitle = '楼盘登记';
$this->registerEndJs(['zepto.min','main']);
$form = $this->beginWidget('CActiveForm');
 ?>
<div class="gj gj-detail gj-add">
    <div class="main">
        <div class="ui-datetime ui-datetime-time">
            <label class="ui-datetime-label">选择楼盘</label><input class="ui-datetime-input" type="text" id="search-box" placeholder="请输入关键词查询" data-url="<?php echo $this->createUrl('ajaxSearchPlot'); ?>" value="<?php echo $model->plot ? $model->plot->title : ''; ?>">
        </div>
        <?php echo $form->hiddenField($model, 'hid'); ?>
        <ul class="area-search-list"></ul>
        <div class="other-item">
            <div class="ui-datetime ui-datetime-time">
                <label class="ui-datetime-label">登记状态</label>
                <?php echo $form->radioButtonList($model, 'status', StaffCheckExt::$status, array('separator'=>'','template'=>'<label class="checklabel ml50">{input}{label}</label>','class'=>'ui-input-radio')); ?>
            </div>
            <div class="ui-datetime ui-datetime-time">
                <label class="ui-datetime-label">截止时间</label>
                <?php echo $form->dateField($model, 'end_time', array('placeholder'=>'请选选择截止时间', 'class'=>'ui-datetime-input','value'=>$model->end_time?date('Y-m-d',$model->end_time):'')); ?>
            </div>
            <h2>备忘记录（非必填）</h2>
            <div class="textarea">
                <?php echo $form->textArea($model, 'note', array('cols'=>30, 'row'=>10, 'placeholder'=>'255字以内，描述购房需求点')); ?>
            </div>
            <?php echo CHtml::submitButton('保存', array('class'=>'button em-1 save-btn')); ?>
            <?php if($id): ?>
                <?php echo CHtml::submitButton('删除', array('class'=>'button save-btn','style'=>'font-size:32px','confirm'=>'确认删除？','ajax'=>array('url'=>$this->createUrl('/wap/staff/ajaxDelCheck'),'data'=>array('id'=>$id),'type'=>'post','success'=>'function(d){if(d.code){location.href="'.$this->createUrl('/wap/staff/detail',['phone'=>$model->phone]).'"}else{location.reload()}}'))); ?>
            <?php endif; ?>
        </div>
        <?php foreach(AreaExt::model()->parent()->normal()->findAll() as $k=>$area): ?>
        <dl class="area-block">
            <dt><?php echo $area->name; ?><i class="arrow <?php if(!$k) echo 'on'; ?>"></i></dt>
            <?php $this->actionAjaxGetAreaPlot($area->id); ?>
            <dd class="area-block-item more-btn"><a href="javascript:;" data-url="<?php echo $this->createUrl('/wap/staff/ajaxGetAreaPlot'); ?>" data-area="<?php echo $area->id; ?>"><i class="more-btn-add-icon"></i>更多楼盘</a></dd>
        </dl>
        <?php endforeach; ?>
</div>
<?php $this->endWidget(); ?>
