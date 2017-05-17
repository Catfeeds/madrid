<?php
/**
 * User: fanqi
 * Date: 2016/9/18
 * Time: 17:32
 */
$this->pageTitle = '二手房价格动态管理';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">价格</th>
        <th class="text-center">添加日期</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td class="text-center"><?php echo $v->getPrice($v->price);?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->new_time); ?></td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('/admin/resoldPlot/priceEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/resoldPlot/priceDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>

<?php
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
