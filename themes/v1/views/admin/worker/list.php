<?php 
$this->pageTitle = '人员列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
        	<div class="form-group">
        		用户名<?php echo CHtml::textField('username', $username, array('class'=>'form-control')); ?>
        	</div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('group',$group,CHtml::listData(AuthItemExt::model()->findAll('type=2'),'name','chinese'),array('class'=>'form-control','encode'=>false,'submit'=>'','empty'=>'--用户组--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('status',$status,AdminExt::$status,array('class'=>'form-control','encode'=>false,'submit'=>'','empty'=>'--状态--')); ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

<div class="portlet-body flip-scroll">
	<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
			<tr>
				<th width="20%" class="text-center">id</th>
				<th width="" class="text-center">用户名</th>
				<th width="" class="text-center">用户组</th>
				<th width="" class="text-center">状态</th>
				<th width="20%" class="text-center">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data as $v): ?>
				<tr>
					<td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
					<td style="text-align:center;vertical-align: middle"><?php echo $v->username; ?></td>
					<td style="text-align:center;vertical-align: middle"><?php echo empty($v->role)?'(用户组不存在)':$v->role->item->chinese ?></td>
					<td style="text-align:center;vertical-align: middle"><?php echo CHtml::ajaxLink(AdminExt::$status[$v->status], $this->createUrl('ajaxStatus'), array('data'=>array('id'=>$v->id),'type'=>'post','success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>AdminExt::$statusStyle[$v->status])); ?></td>
					<td style="text-align:center;vertical-align: middle">
						<a href="<?php echo $this->createUrl('/admin/worker/edit',array('id'=>$v['id'])) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>