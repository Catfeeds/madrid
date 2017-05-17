<?php
	$this->pageTitle='问答列表';
	?>
	<h2><?=$house->title?></h2>
    <h2><?php echo CHtml::ajaxLink('抓取问答内容',$this->createUrl('moreWds'), array('type'=>'get', 'data'=>array('id'=>$house->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn default')); ?></h2>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <!-- <th width="35px"><input type="checkbox"></th> -->
            <th class="text-center">id</th>
            <th class="text-center">日期</th>
            <!-- <th class="text-center">价格</th> -->
            <th class="text-center">问题</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($infos as $v): ?>
        <tr>
            <td  class="text-center"><?php echo $v->id ?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->time) ?></td>
            <td  class="text-center"><?=Tools::u8_title_substr($v->question,200)?></td>
            <td class="text-center"><?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('delWds'),'type'=>'get','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>