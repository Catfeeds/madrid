<?php
$this->pageTitle = '站点配置导览';
$this->breadcrumbs = array('后台管理',$this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::textField('search',$search,array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
</div>
<?php foreach($map as $model): ?>
    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
		<div class="dashboard-stat grey">
			<div class="visual">
				<i class="fa <?=$model->icon; ?>"></i>
			</div>
			<div class="details">
				<div class="number">
					 <?=count($model->attributes); ?>
				</div>
				<div class="desc">
                    <?=$model->getName(); ?>
				</div>
			</div>
			<a class="more" href="<?=$this->createUrl('/admin/site/siteSetting', ['type'=>$model->getClassName(true)]); ?>">点此进行配置<i class="m-icon-swapright"></i>
			</a>
		</div>
	</div>
<?php endforeach; ?>
