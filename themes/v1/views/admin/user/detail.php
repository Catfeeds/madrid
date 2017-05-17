<?php
$this->pageTitle = '用户信息';
?>

<ul class="nav nav-tabs">
    <li class="active">
      <a href="#tab_1" data-toggle="tab"> 流水信息 </a>
   </li>
   <li>
      <a href="#tab_2" data-toggle="tab"> 用户信息 </a>
   </li>
</ul>


<!-- begin tab -->
<div class="tab-content">
    <!-- begin 流水信息 -->
    <div class="tab-pane active col-md-12" id="tab_1">
        <table class="table table-bordered table-hover">
            <tr>
                <td><?php echo $user->name.'('.$user->phone.')'; ?></td>
                <td>回访状态：<?php echo UserExt::$visitStatus[$user->visit_status]; ?></td>
                <td>
                买房顾问：<?php echo $user->staff?$user->staff->username:'(未分配)'; ?>
                </td>
            </tr>
            <tr>
                <td>购房进度：<?php echo UserExt::$progress[$user->progress]; ?></td>
                <td>看房状态：<?php echo UserExt::$staffStatus[$user->staff_status]; ?></td>
                <td>看房邀请：<?php echo UserExt::$takeNotice[$user->take_notice]; ?></td>
            </tr>
        </table>
        <?php $form = $this->beginWidget('HouseForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
        <?php echo CHtml::htmlButton('添加流水', array('class'=>'btn btn-info', 'onclick'=>'js:$(this).hide().next().slideDown(function(){window.parent.resizeModal();});')); ?>
            <div style="display: none">
                <?php
                    echo $form->dropDownList($userLog, 'visit_status', UserExt::$visitStatus,array('class'=>'form-control input-inline','onchange'=>'js:if($(this).find("option:selected").text()=="已分配"){$(this).next().removeClass("hide").attr("disabled",false);}else{$(this).next().addClass("hide").attr("disabled",true)}'));

                    echo CHtml::dropDownList('staff_id', $user->staff_id, CHtml::listData(StaffExt::model()->normal()->findAll(),'id','username'), array('empty'=>array(0=>'--请选择买房顾问--'), 'disabled'=>true,'class'=>'form-control input-inline hide'));

                    echo $form->textArea($userLog, 'content', array('class'=>'form-control','rows'=>3,'style'=>'margin:10px 0'));
                    echo $form->hiddenField($userLog, 'phone', array('value'=>$user->phone));
                    echo CHtml::ajaxSubmitButton('保存', $this->createUrl('/admin/user/ajaxLog'),array('success'=>'function(d){if(d.code){toastr.success("提交成功");$("textarea").val("");load_log_list();}else{toastr.error(d.msg)}}'),array('class'=>'btn btn-success'));
                ?>
            </div>
        <?php $this->endWidget(); ?>

        <!-- START 用户订单 -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bell-o"></i>用户订单
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="order_list">
                </div>
            </div>
        </div>
        <!-- end 用户订单 -->

        <!-- START 楼盘登记 -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bell-o"></i>楼盘登记
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-condensed flip-content" style="margin-bottom:0" id="order_list">
                        <thead class="flip-content">
                            <tr>
                                <th class="text-center" width="10%">登记人</th>
                                <th class="text-center" width="10%">登记楼盘(合作星级)</th>
                                <th class="text-center" width="10%">内容</th>
                                <th class="text-center" width="10%">登记状态</th>
                                <th class="text-center" width="10%">登记时间</th>
                                <th class="text-center" width="20%">截止时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($user->check as $v): ?>
                                <tr>
                                    <td class="text-center"><?php echo $v->staff->username; ?></td>
                                    <td class="text-center"><?php echo $v->plot->title.'('.PlotExt::$star[$v->plot->star].')'; ?></td>
                                    <td class="text-center"><?php echo $v->note ? $v->note : '-'; ?></td>
                                    <td class="text-center"><?php echo StaffCheckExt::$status[$v->status]; ?></td>
                                    <td class="text-center"><?php echo date('Y-m-d H:i', $v->created); ?></td>
                                    <td class="text-center"><?php echo $v->end_time ? date('Y-m-d', $v->end_time) : '无'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(!$user->check): ?>
                                <tr class="text-center"><td colspan="6">暂无</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end 楼盘登记 -->

        <!-- START 用户流水-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bell-o"></i>用户流水
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="log_list">
                </div>
            </div>
        </div>
        <!-- END 用户流水-->
    </div>
    <!-- end 流水信息 -->

    <!-- begin 用户信息 -->
    <div class="tab-pane col-md-12" id="tab_2">
        <?php $form = $this->beginWidget('HouseForm', array('action'=>$this->createUrl('edit'),'htmlOptions'=>array('class'=>'form-horizontal'))); ?>
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
                        <?php echo $form->textField($user, 'phone', array('disabled'=>true,'class'=>'form-control')); ?>
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
                        <?php echo $form->multiAutocomplete($user, 'yxlp',CJSON::encode($yxlpArr),$this->createUrl('/admin/plot/ajaxGetHouse'), array('onchange'=>'window.parent.resizeModal()','class'=>'form-control'));  ?>
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
                    <?php echo CHtml::hiddenField('id', $user->id); ?>
                    <?php echo CHtml::submitButton('保存',array('class'=>'btn green')); ?>
                    <?php //echo CHtml::ajaxSubmitButton('保存', $this->createUrl('/admin/user/ajaxEdit'),array('success'=>'function(d){if(d.code){toastr.success(d.msg)}else{toastr.error(d.msg)}}'),array('class'=>'btn green')); ?>
                </div>
            </div>

        <?php $this->endWidget(); ?>
    </div>
    <!-- end 用户信息 -->
</div>


<script type="text/javascript">
    <?php Tools::startJs() ?>
        //ajax加载订单列表
        function load_order_list(){
            $("#order_list").load('<?php echo $this->createUrl("/admin/user/ajaxOrderList",array("phone"=>$user->phone,"page"=>1)); ?>',function(){
                window.parent.resizeModal();
            });
        }
        //ajax加载流水列表
        function load_log_list(){
            $("#log_list").load('<?php echo $this->createUrl("/admin/user/ajaxLogList", array("phone"=>$user->phone,"page"=>1)); ?>',function(){
                window.parent.resizeModal();
            });
        }
        $(document).ready(function() {
            load_order_list();
            load_log_list();
        });
        //监听tab按钮
        $('a[data-toggle]').live('click', function(){
            window.parent.resizeModal();
        });
    <?php Tools::endJs('js'); ?>
</script>
