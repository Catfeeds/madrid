<?php
$this->pageTitle = '楼盘点评';
$this->breadcrumbs = array($this->pageTitle);
 ?>
 <div class="table-toolbar">
     <div class="btn-group pull-right">
         <?php echo CHtml::link('添加点评 <i class="fa fa-plus"></i>', $this->createUrl('plot/commentEdit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
     </div>
 </div>
 <table class="table table-bordered table-striped table-condensed flip-content">
     <thead class="flip-content">
     <tr>
         <th class="text-center" width="40px">id</th>
         <th class="text-center" width="180px">买房顾问</th>
         <th class="text-center">点评内容</th>
         <th class="text-center" width="110px">添加时间</th>
         <th class="text-center" width="120px">操作</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($data as $v): ?>
         <tr>
             <td class="text-center"><?php echo $v->id; ?></td>
             <td class="text-center"><?php echo $v->staff->username.'('.$v->staff->name.')'; ?></td>
             <td class="text-center"><?php echo $v->content; ?></td>
             <td class="text-center"><?php echo date('Y-m-d',$v->created)?></td>
             <td class="text-center">
                 <a href="<?php echo $this->createUrl('commentEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                 <?php
                 echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('commentDelete'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
