<?php
$this->pageTitle = '楼盘视频';
$this->breadcrumbs = array($this->pageTitle);
 ?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <?php echo CHtml::link('添加视频 <i class="fa fa-plus"></i>', $this->createUrl('plot/videoEdit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content" style="table-layout: fixed;">
    <thead class="flip-content">
    <tr>
        <th class="text-center" width="40px">id</th>
        <th class="text-center">标题</th>
        <th class="text-center">视频地址</th>
        <th class="text-center" width="100px">上传时间</th>
        <th class="text-center" width="80px">状态</th>
        <th class="text-center" width="200px">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center" style="vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="text-center" style="vertical-align: middle"><?php echo $v->title; ?></td>
            <td class="text-center" width="100px" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;">
                <?php if($v->mp_url):?>
                mp4:<a href="<?php echo ImageTools::fixImage($v->mp_url); ?>" target="_blank"><?php echo ImageTools::fixImage($v->mp_url); ?></a>
                <?php endif;?>
                <?php if($v->flv_url):?>
                <br>flv:<a href="<?php echo ImageTools::fixImage($v->flv_url); ?>" target="_blank"><?php echo ImageTools::fixImage($v->flv_url); ?></a>
                <?php endif;?>
            </td>
            <td class="text-center" style="vertical-align: middle"><?php echo date('Y-m-d',$v->created); ?></td>
            <td class="text-center" style="vertical-align: middle">
            <?php
                if($v->transcoded==0||$v->transcoded==4){
                    echo CHtml::ajaxLink(PlotVideoExt::$status[$v->status],$this->createUrl('videoStatus'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-xs '.PlotVideoExt::$statusStyle[$v->status]));
                }
                else
                    echo PlotVideoExt::$transStatus[$v->transcoded];
            ?>
            </td>
            <td class="text-center" style="vertical-align: middle">
                <a href="<?php echo $this->createUrl('videoEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('videoDelete'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                echo CHtml::button('转码刷新',array('class'=>'btn btn-xs green','ajax'=>array('url'=>$this->createUrl('videoQuery'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
