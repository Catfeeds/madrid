<?php
$this->pageTitle = '房源预约列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="col-md-8">
	<a href="<?=$this->createUrl('saleup')?>" class="btn blue">预约其他房源</a>
	
	<h4>
	房源标题：<?=$esf->title?>
	</h4>
	<div class="table-scrollable">
		<table class="table table-hover">
		<thead>
		<tr>
			<th>
				刷新日期
			</th>
			<th>
				 刷新时间
			</th>
			<th>
				 类型
			</th>
		</tr>
		</thead>
		<tbody>
		<?php if($appoints) foreach ($appoints as $key => $value) {?>
		<tr>
			<td>
				 <?=date('Y-m-d',$value->appoint_time)?>
			</td>
			<td>
				 <?=date('H:i',$value->appoint_time)?>
			</td>
			<td>
				<?=$value->appoint_time<time()?'自动':'<a href="'.$this->createUrl('delSingleAppoint',['id'=>$value->id,'fid'=>$value->fid]).'">取消</a>'?>
			</td>
		</tr>
		<?php }?>
		
		
		</tbody>
		</table>
	</div>
</div>