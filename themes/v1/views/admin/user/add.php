<?php
$this->pageTitle = '添加用户';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
    <div class="tab-pane col-md-12">
        <?php $form = $this->beginWidget('HouseForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">姓名</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($user, 'name', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $form->error($user, 'name', array('class'=>'help-block')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">性别</label>
                    <div class="col-md-5 radio-list">
                        <?php echo $form->radioButtonList($user, 'gender', UserExt::$gender, array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($user, 'take_notice'); ?></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">电话</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($user, 'phone', array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($user, 'phone');  ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">QQ</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($user, 'qq', array('class'=>'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">住址</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($user, 'address', array('class'=>'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">房源类型</label>
                    <div class="col-md-5 radio-list">
                        <?php echo $form->radioButtonList($user, 'room_type', UserExt::$roomType,array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>'));  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">意向楼盘</label>
                    <div class="col-md-5">
                        <?php echo $form->multiAutocomplete($user, 'yxlp','[]',$this->createUrl('/admin/plot/ajaxGetHouse'), array('class'=>'form-control'));  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">意向区域</label>
                    <div class="col-md-10">
                        <?php
                        echo CHtml::checkBoxList('UserExt[yxqy]', CHtml::listData($user->yxqy,'id','id'),CHtml::listData(AreaExt::model()->parent()->normal()->findAll(),'id','name'),array('separator'=>'','class'=>'form-control'));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">关注点</label>
                    <div class="col-md-10">
                        <?php echo $form->checkBoxList($user, 'concern', UserExt::$concern, array('separator'=>'','class'=>'form-control')); ?>

                    </div>
                    <div class="col-md-4">
                        <label class="col-md-2 control-label text-nowrap">其他</label><?php echo $form->textField($user, 'concern_remark', array('class'=>'form-control input-inline')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">意向购买时间</label>
                    <div class="col-md-5">
                        <?php echo $form->dropDownList($user, 'intent_time', CHtml::listData(TagExt::model()->normal()->getTagByCate('gmsj')->findAll(),'id','name'), array('class'=>'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">户型面积</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <?php echo $form->textField($user, 'size', array('class'=>'form-control', 'value'=>$user->size?$user->size:'')); ?>
                            <span class="input-group-addon">平米</span>
                        </div>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($user, 'size'); ?></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">购房预算</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <?php echo $form->textField($user, 'budget', array('class'=>'form-control', 'value'=>$user->budget?$user->budget:'')); ?>
                            <span class="input-group-addon">万</span>
                        </div>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($user, 'budget'); ?></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">看房邀请</label>
                    <div class="col-md-5 radio-list">
                        <?php echo $form->radioButtonList($user, 'take_notice', UserExt::$takeNotice, array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($user, 'take_notice'); ?></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">备注信息</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($user, 'note', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($user, 'note'); ?></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">购房进度</label>
                    <div class="col-md-5 radio-list">
                        <?php echo $form->radioButtonList($user, 'progress', UserExt::$progress, array('class'=>'form-control','separator'=>'')); ?>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($user, 'progress'); ?></div>
                </div>
                <div class="col-md-offset-2 col-md-8">
                    <?php echo CHtml::submitButton('保存',array('class'=>'btn green')); ?>
                    <?php echo CHtml::link('返回', $this->createUrl('/admin/user/list'),array('class'=>'btn default')); ?>
                </div>
            </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
