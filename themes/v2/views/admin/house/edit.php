<?php
	$this->pageTitle='楼盘详情';
	?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<?php foreach (PlotExt::$tags as $key => $value) {?>
	<?php if(isset(Yii::app()->params['plotAttr'][$key])):?>
	<div class="form-group">
	    <label class="col-md-2 control-label"><?=Yii::app()->params['plotAttr'][$key]?></label>
	    <div class="col-md-4">
	    <?php if(strpos($key,'time')):?>
	    	<?php echo $form->textField($house,$key,array('class'=>'form-control','value'=>($house->$key?date('Y-m-d',$house->$key):''))); ?>
	    <?php else:?>
	    	<?php echo $form->textField($house, $key, array('class' => 'form-control')); ?>
	    <?php endif;?>
	        
	    </div>
	    <div class="col-md-2"><?php echo $form->error($house, $key) ?></div>
	</div>
<?php endif;}?>
	<div class="form-group">
	    <label class="col-md-2 control-label"><?='交通情况'?></label>
	    <div class="col-md-4">
	    	<?php echo $form->textField($house, 'transit', array('class' => 'form-control')); ?>
	    </div>
	    <div class="col-md-2"><?php echo $form->error($house, 'transit') ?></div>
	</div>
	<div class="form-group">
	    <label class="col-md-2 control-label"><?='周边配套'?></label>
	    <div class="col-md-4">
	    	<?php echo $form->textField($house, 'peripheral', array('class' => 'form-control')); ?>
	    </div>
	    <div class="col-md-2"><?php echo $form->error($house, 'peripheral') ?></div>
	</div>
	<div class="form-group">
	    <label class="col-md-2 control-label"><?='简介'?></label>
	    <div class="col-md-4">
	    	<?php echo $form->textField($house, 'content', array('class' => 'form-control')); ?>
	    </div>
	    <div class="col-md-2"><?php echo $form->error($house, 'content') ?></div>
	</div>
<div class="form-group">
	    <label class="col-md-2 control-label"></label>
	    <div class="col-md-4">
	        <input type="submit" value="保存" class="btn blue">
	        &nbsp;&nbsp;&nbsp;&nbsp;
	        <a href="<?=$this->createUrl('list')?>" class="btn yellow">返回</a>
	    </div>
	</div>
<?php $this->endWidget() ?>
