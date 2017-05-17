<?php
$this->pageTitle = '分站列表';
$this->breadcrumbs = array('分站配置',$this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">

    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createAbsoluteUrl('edit')?>" class="btn green">
            添加分站信息 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">id</th>
        <th class="text-center">分站名</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td class="text-center"><?php echo $v->name; ?></td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('edit',['id'=>$v->id]) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
                    echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'该操作会删除对应分站的推荐位内容以及广告，是否确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'关闭', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('ajaxDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
