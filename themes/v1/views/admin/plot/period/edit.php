<?php
$this->pageTitle = $model->plot->title.'-期数编辑';
$this->breadcrumbs = array($this->pageTitle);
 ?>

<div class="portlet-body">
     <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
     <div class="form-body">
         <div class="form-group">
             <label class="col-xs-2 control-label">期数</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textField($model, 'period', array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'period') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-2 control-label">沙盘图</span></label>
             <div class="col-xs-5">
                 <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'image','mode'=>2)) ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'unit_total') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-2 control-label">状态</span></label>
             <div class="col-xs-6">
                 <?php echo $form->radioButtonList($model, 'status', PlotPeriodExt::getStatus(), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
             </div>
         </div>

         <div class="form-group">
             <label class="col-xs-3 control-label"></label>
             <div class="col-xs-5">
                 <button type="submit" class="btn green">保存</button>
                 <?php echo CHtml::link('返回', $this->createUrl('periodList',array('hid'=>$hid)),array('class'=>'btn green')); ?>
             </div>
         </div>
     </div>
     <?php $this->endWidget(); ?>
 </div>

 <style type="text/css">
    /*大图要显示横滚动条*/
     html {overflow-x: auto;}
 </style>

<script type="text/javascript">
<?php Tools::startJs(); ?>
    // 循环监听图片宽度以设置滚动条
    $(document).ready(function(){
        setInterval(function(){
            if($("#singlePicyw1 img").width()>800){
                $("body").css("overflow-x","auto");
            }
        },500);
    });
<?php Tools::endJs('js'); ?>
</script>
