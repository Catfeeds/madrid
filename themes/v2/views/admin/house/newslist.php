<?php
	$this->pageTitle='动态列表';
	?>
	<h2><?=$house->title?></h2>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <!-- <th width="35px"><input type="checkbox"></th> -->
            <th class="text-center">id</th>
            <th class="text-center">标题</th>
            <th class="text-center">内容</th>
            <th class="text-center">时间</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($infos as $v): ?>
        <tr>
            <td  class="text-center"><?php echo $v->id ?></td>
            <td  class="text-center"><?php echo $v->title ?></td>
            <td  class="text-center"><?=Tools::u8_title_substr($v->content,200)?></td>
            <td class="text-center"><?php echo date('Y-m-d H:i:s',$v->time) ?></td>
            <td class="text-center"><?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('delNews'),'type'=>'get','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>