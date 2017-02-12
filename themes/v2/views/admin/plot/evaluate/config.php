<?php
	$this->pageTitle = '二手房站点配置';
	$this->breadcrumbs = array($this->pageTitle);
?>
<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
<div class="tabbale">
    <div class="tab-content col-md-12">
        <div class="col-md-10">
			<?php foreach($model->attributes as $name=>$item): ?>
				<div class="form-group">
	                <label class="col-md-3 control-label text-nowrap"><?=$form->label($model, $name); ?></label>
	                <div class="col-md-9">
						<?php $this->widget('SiteSettingItemWidget', [
							'model' => $model,
							'attribute' => $name,
							'form' => $form,
						]); ?>
	                    <span class="help-inline"><?php echo $item->description; ?></span>
	                </div>
	            </div>
			<?php endforeach; ?>
	        <div class="col-md-12 center-block text-center">
	            <div class="btn-group text-center">
	                <button class="btn green-meadow col-md-offset-4">提交</button>
	            </div>
	        </div>
        </div>
    </div>
</div>
<?php $this->endWidget();?>
