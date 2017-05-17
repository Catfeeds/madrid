<?php
$this->pageTitle = $model->plot->title.'-户型编辑';
$this->breadcrumbs = array($this->pageTitle);
 ?>

<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-2 control-label">标题</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model, 'title', array('class'=>'form-control')); ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'title') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">户型</span></label>
            <div class="col-xs-8">
                <?php echo $form->textField($model, 'bedroom', array('class'=>'form-control input-inline')).'室'.$form->textField($model, 'livingroom', array('class'=>'form-control input-inline')).'厅'.$form->textField($model, 'bathroom', array('class'=>'form-control input-inline')).'卫'; ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'bedroom') ?></div>
            <div class="col-xs-4"><?php echo $form->error($model, 'liveingroom') ?></div>
            <div class="col-xs-4"><?php echo $form->error($model, 'bathroom') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">面积</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model, 'size', array('class'=>'form-control input-inline')); ?>㎡
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'size') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">参考价</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model, 'price', array('class'=>'form-control input-inline')); ?>万
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'price') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">排序</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model, 'sort', array('class'=>'form-control')); ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'sort') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">关联楼栋</span></label>
            <div class="col-xs-5">
                <?php echo $buildings ? $form->checkBoxList($model, 'buildingIds', $buildings, array('class'=>'form-control','separator'=>'&nbsp;')) : '<span class="help-inline">'.CHtml::link('【请先添加楼栋】',array('buildingEdit','hid'=>$hid)).'</span>'; ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'title') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">户型图</span></label>
            <div class="col-xs-5">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'image','mode'=>2,'width'=>300)) ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'image') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">户型描述</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model, 'description', array('class'=>'form-control')); ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'description') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">销售状态</span></label>
            <div class="col-xs-6">
                <?php echo $form->radioButtonList($model, 'sale_status', PlotHouseTypeExt::getSaleStatus(), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-2 control-label">状态</span></label>
            <div class="col-xs-6">
                <?php echo $form->radioButtonList($model, 'status', PlotHouseTypeExt::getStatus(), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-3 control-label"></label>
            <div class="col-xs-5">
                <button type="submit" class="btn green">保存</button>
                <?php echo CHtml::link('返回', $this->createUrl('houseTypeList',array('hid'=>$hid)),array('class'=>'btn green')); ?>
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
