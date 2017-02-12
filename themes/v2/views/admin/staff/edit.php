<?php
$this->pageTitle = '编辑资料';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">登录帐号<span class="required" aria-required="true">*</span></label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'username',array('class'=>'form-control','disabled'=>$staff->scenario!='insert')) ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff, 'username') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">登录密码</label>
                <div class="col-md-4">
                    <?php echo $form->passwordField($staff,$staff->id?'newPwd':'password',array('class'=>'form-control','value'=>'')) ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,$staff->id?'newPwd':'password') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">用户名</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'name',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'name') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">职位</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'job',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'job') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">电话</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'phone',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'phone') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">微信号</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'wx_name',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'wx_name') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">微信二维码</label>
                <div class="col-md-4">
                    <?php $this->widget('FileUpload',array('model'=>$staff,'attribute'=>'wx_image','inputName'=>'wx_image','width'=>300)); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'wx_image') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">QQ号</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'qq',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'qq') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">点赞数</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'praise',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'praise') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">工作年限</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <?php echo $form->textField($staff,'work_time',array('class'=>'form-control','value'=>$staff->work_time>0?$staff->work_time:'')); ?>
                        <span class="input-group-addon">年</span>
                    </div>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'work_time') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">服务理念</label>
                <div class="col-md-4">
                    <?php echo $form->textField($staff,'idea',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'idea') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">自我介绍</label>
                <div class="col-md-4">
                    <?php echo $form->textArea($staff,'introduction',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'introduction') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">头像</label>
                <div class="col-md-4">
                    <?php $this->widget('FileUpload',array('model'=>$staff,'attribute'=>'avatar','inputName'=>'avatar','width'=>300)); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($staff,'avatar') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">状态<span class="required" aria-required="true">*</span></label>
                <div class="col-md-4 radio-list">
                    <?php echo $form->radioButtonList($staff,'status',AdminExt::$status,array('separator'=>'','template'=>'<label>{input} {label}</label>')) ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-2 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回',$this->createUrl('list'),array('class'=>'btn default')) ?>
                </div>
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>
