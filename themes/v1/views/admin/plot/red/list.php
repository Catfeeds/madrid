<?php
$this->pageTitle = '楼盘红包';
$this->breadcrumbs = array($this->pageTitle);
 ?>
 <div class="table-toolbar">
     <div class="btn-group pull-right">
         <?php echo CHtml::link('添加红包 <i class="fa fa-plus"></i>', $this->createUrl('plot/redEdit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
     </div>
 </div>
 <table class="table table-bordered table-striped table-condensed flip-content">
     <thead class="flip-content">
     <tr>
         <th class="text-center" width="40px">id</th>
         <th class="text-center" width="180px">标题</th>
         <th class="text-center">红包额度</th>
         <th class="text-center" >领取时间</th>
         <th class="text-center" >红包已领人数</th>
         <th class="text-center" >默认红包人数</th>
         <th class="text-center" width="120px">状态</th>
         <th class="text-center" width="120px">操作</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($data as $v): ?>
         <tr>
             <td class="text-center"><?php echo $v->id; ?></td>
             <td class="text-center"><?php echo $v->title; ?></td>
             <td class="text-center"><?php echo $v->amount; ?></td>
             <td class="text-center"><?php echo $v->getFormatStartDate(); ?> ~ <?php echo $v->getFormatEndDate(); ?></td>
             <td class="text-center"><?php echo $v->got_num; ?></td>
             <td class="text-center"><?php echo $v->total_num; ?></td>

             <td class="text-center"><?php echo CHtml::ajaxLink(PlotRedExt::$status[$v->status],$this->createUrl('redStatus'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-xs '.PlotRedExt::$statusStyle[$v->status])); ?></td>
             <td class="text-center">
                 <a href="<?php echo $this->createUrl('redEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                 <?php
                 echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('redDelete'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
