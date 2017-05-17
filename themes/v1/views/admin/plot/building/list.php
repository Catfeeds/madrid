<?php
$this->pageTitle = $this->action->plot->title.'-楼栋管理';
$this->breadcrumbs = array($this->pageTitle);
 ?>
 <div class="table-toolbar">
     <div class="btn-group pull-right">
         <?php echo CHtml::link('添加楼栋 <i class="fa fa-plus"></i>', $this->createUrl('plot/buildingEdit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
     </div>
 </div>
 <table class="table table-bordered table-striped table-condensed flip-content">
     <thead class="flip-content">
     <tr>
         <th class="text-center" width="40px">id</th>
         <th class="text-center" width="180px">楼栋号（名称）</th>
         <th class="text-center">单元数</th>
         <th class="text-center">规划户数</th>
         <th class="text-center">楼层数</th>
         <th class="text-center">在售房源</th>
         <th class="text-center">关联户型</th>
         <th class="text-center">状态</th>
         <th class="text-center">操作</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($data as $v): ?>
         <tr>
             <td class="text-center"><?php echo $v->id; ?></td>
             <td class="text-center"><?php echo $v->name; ?></td>
             <td class="text-center"><?php echo $v->unit_total; ?></td>
             <td class="text-center"><?php echo $v->household_total; ?></td>
             <td class="text-center"><?php echo $v->floor_total; ?></td>
             <td class="text-center"><?php echo $v->sale_total; ?></td>
             <td class="text-center">
                <?php
                    if($v->houseTypes){
                        foreach($v->houseTypes as $k=>$houseType){
                            echo $k==0 ? $houseType->title : ','.$houseType->title;
                        }
                    } else {
                        echo '-';
                    }
                 ?>
             </td>
             <td class="text-center"><?php echo PlotBuildingExt::getStatus($v->status); ?></td>
             <td class="text-center">
                 <a href="<?php echo $this->createUrl('buildingEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                 <?php
                 echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('buildingDelete'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
