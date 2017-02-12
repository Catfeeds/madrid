<?php
$this->pageTitle = '推荐位列表';
$this->breadcrumbs = array('推荐管理',$this->pageTitle);
?>
<div class="table-toolbar">
    <div class="alert alert-info alert-dismissable">
        <strong>注：</strong>推荐位分类由于是系统内置分类，不可删除，也不建议随意添加推荐位分类。右侧“添加分类”按钮的作用是为了方便在站外灵活使用推荐系统，您可以添加一个推荐位后，通过开放接口根据推荐位拼音获取该推荐位的推荐内容，该用法需要技术人员使用。
    </div>
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
            <td style="text-align:center;vertical-align: middle"><?php echo ResoldRecomCateExt::$status[$v['status']]; ?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/resoldRecommend/cateedit',array('id'=>$v['id'])) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
