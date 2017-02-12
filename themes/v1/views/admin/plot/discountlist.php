<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '优惠信息管理';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <?php echo CHtml::link('添加优惠信息 <i class="fa fa-plus"></i>', $this->createAbsoluteUrl('plot/discountedit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">起始时间</th>
        <th class="text-center">标题</th>
        <th class="text-center">跳转链接</th>
        <th class="text-center">记录时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td style="text-align:left;vertical-align: middle"><?php echo date('Y-m-d',$v->start)?> - <?php echo date('Y-m-d',$v->expire)?></td>
            <td style="text-align:left;vertical-align: middle"><?php echo $v->title; ?></td>
            <td style="text-align:left;vertical-align: middle"><?php echo CHtml::link($v->url,$v->url,array('target'=>'_blank')); ?></td>
            <td style="text-align:left;vertical-align: middle"><?php echo date('Y-m-d',$v->created)?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createAbsoluteUrl('/admin/plot/discountedit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createAbsoluteUrl('discountdel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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



