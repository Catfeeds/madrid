<?php
$this->pageTitle = '编辑套餐信息';
$this->breadcrumbs = array($this->pageTitle);
?>
<style type="text/css">
    .right-text{
        text-align: right !important;padding-right: 0;width: 60px;
    }
 </style>
<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'),'enableAjaxValidation'=>false)) ?>
<div class="tabbale">
    <div class="tab-content col-md-10" style="padding-top:20px;">
	    <div class="col-md-10">
	    <!-- 正片开始 -->
	    	<div class="form-group">
                <label class="col-md-2 control-label text-nowrap">套餐名称</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,'name',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, 'name') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">上架条数</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,"content[total_num]",array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, "content[total_num]") ?></div>
            </div>
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">加急数</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,"content[urgent_num]",array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, "content[urgent_num]") ?></div>
            </div> -->
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">刷新数</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,"content[refresh_num]",array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, "content[refresh_num]") ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">推荐数</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,"content[recommend_num]",array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, "content[recommend_num]") ?></div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">预约数</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,"content[appoint_num]",array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, "content[appoint_num]") ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">套餐描述</label>
                <div class="col-md-8">
                    <?php echo $form->textField($package,'description',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($package, 'description') ?></div>
            </div>
           
            <div class="form-group">
                <label class="col-md-2 control-label">套餐状态</label>
                <div class="col-md-10">
                <div class="radio-list">
                    <?php echo $form->radioButtonList($package, 'status',  Yii::app()->params['shopStatus'], array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    <span class="help-block"><?php echo $form->error($package, 'status'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 center-block text-center">
                <div class="btn-group text-center">
                    <button class="btn green-meadow col-md-offset-4">提交</button>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $this->endWidget(); 