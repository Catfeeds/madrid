<?php 
$this->pageTitle = '用户组管理';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body flip-scroll">
	<div class="table-toolbar">
		<div class="btn-group pull-right">
		<a href="<?php echo $this->createUrl('edit') ?>" class="btn green">
		添加用户组 <i class="fa fa-plus"></i>
		</a>
	</div>
	</div>
	<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
			<tr>
				<th width="20%">用户组</th>
				<!-- <th class="numeric">标识</th> -->
				<th class="numeric">描述</th>
				<th class="numeric">最后操作人</th>
				<th class="numeric">添加时间</th>
				<th class="numeric">修改时间</th>
				<th class="numeric">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($roles as $v): ?>
				<tr>
					<td><?php echo $v->chinese ?></td>
					<td><?php echo $v->description ?></td>
					<td><?php echo AdminExt::model()->findByPk($v->userid)->username ?></td>
					<td><?php echo date('Y-m-d',$v->created) ?></td>
					<td><?php echo empty($v->updated) ? '暂无' : date('Y-m-d',$v->updated) ?></td>
					<td>
						<a href="<?php echo $this->createUrl('edit',array('group'=>$v->name)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
						<?php 
							if(!in_array($v->name, array('admin','staff')))
							{
								echo CHtml::ajaxLink('<span class="fa fa-times"></span>删除', $this->createUrl('delete'), array('type'=>'post','data'=>array('name'=>$v->name),'success'=>'function(d){if(d.code){location.reload();}else{toastr.error(d.msg)}}'), array('class'=>'btn btn-xs red'));
							}
						 ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>