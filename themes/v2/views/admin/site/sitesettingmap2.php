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
<div class="portlet">
	<!-- <div class="portlet-title">
		<div class="caption"><i class="fa fa-gift"></i>配置导览</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title=""></a>
		</div>
	</div> -->
	<div class="portlet-body">
        <?php foreach($map as $model): ?>
		<a href="<?=$this->createUrl('/admin/site/siteSetting', ['type'=>$model->getClassName(true)]); ?>" class="icon-btn">
    		<i class="fa <?=$model->icon; ?>"></i>
    		<div><?=$model->getName(); ?></div>
    		<!-- <span class="badge badge-danger"></span> -->
		</a>
        <?php endforeach; ?>
	</div>
</div>
