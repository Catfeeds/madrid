<?php
$this->pageTitle = $this->action->plot->title.'-期数管理';
$this->breadcrumbs = array($this->pageTitle);
 ?>
 <div class="table-toolbar">
     <div class="btn-group pull-right">
         <?php echo CHtml::link('添加期数 <i class="fa fa-plus"></i>', $this->createUrl('plot/periodEdit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
     </div>
 </div>
 <table class="table table-bordered table-striped table-condensed flip-content">
     <thead class="flip-content">
     <tr>
         <th class="text-center" width="40px">id</th>
         <th class="text-center" width="180px">沙盘图</th>
         <th class="text-center">期数</th>
         <th class="text-center">关联楼栋</th>
         <th class="text-center">状态</th>
         <th class="text-center">操作</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($data as $v): ?>
         <tr>
             <td class="text-center" style="vertical-align: middle"><?php echo $v->id; ?></td>
             <td class="text-center" style="vertical-align: middle"><?php echo $v->image?CHtml::image(ImageTools::fixImage($v->image,80,60)):'未上传'; ?></td>
             <td class="text-center" style="vertical-align: middle"><?php echo $v->period; ?></td>
             <td class="text-center" style="vertical-align: middle">
                <?php
                    if($v->buildings){
                        foreach($v->buildings as $k=>$building){
                            echo $k==0 ? $building->name : ','.$building->name;
                        }
                    } else {
                        echo '-';
                    }
                 ?>
             </td>
             <td class="text-center" style="vertical-align: middle"><?php echo CHtml::ajaxLink(PlotPeriodExt::getStatus($v->status),$this->createUrl('periodStatus'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-xs '.PlotPeriodExt::$statusStyle[$v->status])); ?></td>
             <td class="text-center" style="vertical-align: middle">
                 <a href="<?php echo $this->createUrl('periodEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                 <?php
                 echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('periodDelete'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
