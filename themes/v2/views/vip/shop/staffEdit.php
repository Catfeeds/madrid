<?php
$this->pageTitle = '编辑商家职员信息';
$this->breadcrumbs = array($this->pageTitle);
?>
<style type="text/css">
    .right-text{
        text-align: left !important;padding-left: 0;width: 20px;
    }
 </style>
<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'),'enableAjaxValidation'=>false)) ?>
<div class="tabbale">
    <div class="tab-content col-md-12" style="padding-top:20px;">
	    <div class="col-md-10">
	    <!-- 正片开始 -->
        <?php $thisStaff = ResoldStaffExt::model()->findStaffByUid(Yii::app()->user->uid)?>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">真实姓名</label>
                <div class="col-md-8">
                    <?php echo $form->textField($staff,'id',array('class'=>'form-control','style'=>'display:none')); ?>
                    <?php echo $form->textField($staff,'name',array('class'=>'form-control','data-target'=>'pointname')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">论坛账号</label>
                <div class="col-md-3">
                    <?php echo $form->textField($staff,'account',array('readonly'=>'readonly','class'=>'form-control','data-target'=>'pointname')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'account'); ?></span>
                </div>
                <div class="col-md-3">
                    <em style="color:red" id="ckUid"></em>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">性别</label>
                <div class="col-md-4">
                <div class="radio-list">
                    <?php echo $form->radioButtonList($staff,'sex',ResoldStaffExt::$sexArray, array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'sex'); ?></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">电话</label>
                <div class="col-md-8">
                    <?php echo $form->textField($staff,'phone',array('class'=>'form-control','readonly'=>$thisStaff->is_manager?'':'readonly')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'phone'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">qq</label>
                <div class="col-md-8">
                    <?php echo $form->textField($staff,'qq',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'qq'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">照片</label>
                <div class="col-md-8">
                <?php if($thisStaff->is_manager):?>
                    <?php $this->widget('FileUpload',array('model'=>$staff,'attribute'=>'image','inputName'=>'img','width'=>400,'height'=>300)); ?>
                    <span class="help-block">建议尺寸：240*300</span>
                <?php elseif($staff->image):?>
                    <img src="<?=ImageTools::fixImage($staff->image,400,300)?>">
                    <input type="hidden" value="<?=$staff->image?>" name="ResoldStaffExt[image]"></input>
                <?php endif;?>  
                </div>
            </div>
            <div class="form-group" style="display: none">
                <label class="col-md-2 control-label">选择套餐</label>
                <div class="col-md-8">
                <?php echo $form->dropDownList($staff,'package', ResoldTariffPackageExt::getPackages() ,array('prompt'=>'--请选择--','class'=>'form-control')); ?>                    
                <span class="help-block"><?php echo $form->error($staff, 'package'); ?></span>
                    </div>
            </div>
            <div class="form-group" style="display: none">
                <label class="col-md-2 control-label">套餐到期时间</label>
                <div class="col-md-8">
                <div class="input-group date form_datetime">
                        <?php echo $form->textField($staff,'expireTime',array('class'=>'form-control','value'=>($staff->expireTime?date('Y-m-d',$staff->expireTime):''))); ?>
                        <span class="input-group-btn">
                          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                       </span>
                    </div>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">身份证</label>
                <div class="col-md-8">
                    <?php $this->widget('FileUpload',array('model'=>$staff,'attribute'=>'id_card','inputName'=>'img','width'=>400,'height'=>300)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">认证执照</label>
                <div class="col-md-8">
                    <?php $this->widget('FileUpload',array('model'=>$staff,'attribute'=>'licence','inputName'=>'img','width'=>400,'height'=>300)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">备注</label>
                <div class="col-md-8">
                    <?php echo $form->textarea($staff,'note',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'note'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">职员状态</label>
                <div class="col-md-10">
                <div class="radio-list">
                    <?php echo $form->radioButtonList($staff, 'status',  Yii::app()->params['shopStatus'], array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    <span class="help-block"><?php echo $form->error($staff, 'status'); ?></span>
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
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/esf-add-images.js', CClientScript::POS_END);Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));
$js = "
            $(function(){
               $('.select2').select({
                  placeholder: '请选择',
                  allowClear: true
               });

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm-dd',
                     minView: 'month',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });

            });


            ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);
?>