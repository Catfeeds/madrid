<?php
$this->pageTitle = '推荐位列表';
$this->breadcrumbs = array('推荐管理',$this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('cateedit') ?>" class="btn blue">
            添加分类 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>


<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">分类名称</th>
        <th class="text-center">推荐位标识</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td style="vertical-align: middle"><?php echo $v['name'] ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v['pinyin'] ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo RecomCateExt::$status[$v['status']]; ?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/recommend/cateedit',array('id'=>$v['id'])) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>