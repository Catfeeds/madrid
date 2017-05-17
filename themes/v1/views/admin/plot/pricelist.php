<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '价格动态管理';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <?php echo CHtml::link('添加价格动态 <i class="fa fa-plus"></i>', $this->createAbsoluteUrl('plot/priceedit',array('hid'=>$hid)),array('class'=>'btn green'));
        ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">类别</th>
        <th class="text-center">价格</th>
        <th class="text-center">说明</th>
        <th class="text-center">添加日期</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td class="text-center"><?php echo $v->jiageleibie ? $v->jiageleibie->name : '-' ;?></td>
            <td class="text-center"><?php echo '['.PlotPriceExt::$mark[$v->mark].']'.$v->price.PlotPriceExt::$unit[$v->unit];?></td>
            <td class="text-center"><?php echo $v->description;?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->created); ?></td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('/admin/plot/priceedit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/plot/pricedel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
