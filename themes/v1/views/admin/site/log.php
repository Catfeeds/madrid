<?php
$this->pageTitle = '后台数据操作日志';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('action',empty($_GET['action'])?'':$_GET['action'],array('CREATE'=>'CREATE','CHANGE'=>'CHANGE','DELETE'=>'DELETE'),array('class'=>'form-control','encode'=>false,'empty'=>'--类型--','submit'=>'')); ?>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <th class="text-center">用户id</th>
            <th class="text-center">用户名</th>
            <th class="text-center">类型</th>
            <th class="text-center">model</th>
            <th class="text-center">数据id</th>
            <th class="text-center">字段</th>
            <th class="text-center">其他信息</th>
            <th class="text-center">ip</th>
            <th class="text-center">时间</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->uid ?></td>
            <td class="text-center"><?php echo $v->username ?></td>
            <td class="text-center"><?php echo $v->action ?></td>
            <td class="text-center"><?php echo $v->model ?></td>
            <td class="text-center"><?php echo $v->mid ?></td>
            <td class="text-center"><?php echo $v->field ?></td>
            <td class="text-center"><?php echo $v->info ?></td>
            <td class="text-center"><?php echo $v->ip ?></td>
            <td class="text-center"><?php echo date("Y-m-d H:i:s", $v->created) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
