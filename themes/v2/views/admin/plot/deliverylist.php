<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '交房时间管理';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <?php echo CHtml::link('添加交房时间 <i class="fa fa-plus"></i>', $this->createUrl('plot/deliveryedit',array('hid'=>$hid)),array('class'=>'btn green'));
        ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">交房时间</th>
        <th class="text-center">标题</th>
        <th class="text-center">交房详情</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td><input type="checkbox" name="item[]" value="<?php echo $v->id ?>"></td>
            <td style="text-align:left;vertical-align: middle"><?php echo date('Y-m-d',$v->delivery_time); ?></td>
            <td style="text-align:left;vertical-align: middle"><?php echo $v->title; ?></td>
            <td style="text-align:left;vertical-align: middle"><?php echo $v->content; ?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/plot/deliveryedit',array('id'=>$v->id,'hid'=>$v->hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('plot/deliverydel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
<?php
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
