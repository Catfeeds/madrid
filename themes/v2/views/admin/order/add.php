<?php
$this->pageTitle = '录入订单';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
    <div class="tab-pane col-md-12">
        <?php $form = $this->beginWidget('HouseForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">姓名</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($order, 'name', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $form->error($order, 'name', array('class'=>'help-block')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">电话</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($order, 'phone', array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($order, 'phone');  ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">来源类型</label>
                    <div class="col-md-3">
                        <?php echo $form->textField($order, 'spm_b', array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($order, 'spm_b');  ?></span>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" onchange="$('#OrderExt_spm_b').val($(this).val())" name="type" id="type">
                        <option value="">--从已有类型选择--</option>
                        <?php foreach($typeArr as $v): ?>
                            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">备注信息</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($order, 'note', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-5"><?php echo $form->error($order, 'note'); ?></div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">分配用户</label>
                    <div class="col-md-5">
                        <?php $radioOption = ['暂不选择','平均分配','指定给买房顾问']; echo CHtml::radioButtonList('fpstate','checked',$radioOption)?>
                        <div class="mfgw" style="display: none;">
                            <?php echo CHtml::dropDownList('staff_id', 0, CHtml::listData(StaffExt::model()->normal()->staffIsWork()->findAll(),'id','username'), array('empty'=>array(0=>'--请选择买房顾问--'),'class'=>'form-control input-inline'));?>
                       </div>
                    </div>
                </div>
                
                <div class="col-md-offset-2 col-md-8">
                    <?php echo $form->hiddenField($order,'spm_a',array('value'=>'后台录入')); ?>
                    <?php echo CHtml::submitButton('保存',array('class'=>'btn green')); ?>
                    <?php echo CHtml::link('返回', $this->createUrl('/admin/order/list'),array('class'=>'btn default')); ?>
                </div>
            </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
<?php Tools::startJs(); ?>
    var width = $('.page-content').width();
    <?php if(!SM::jikeConfig()->mode()):?>
        $('#fpstate_1').attr('disabled',true);
        // $('#fpstate_1').after('&nbsp;请在站点配置中开启平均分单模式');
    <?php endif;?>
     $('#fpstate').click(function(){

        if($('#uniform-fpstate_2 span').attr('class')=="checked")
        {
            $('.mfgw').css('display','block');
        }
        else
        {
            $('.mfgw').css('display','none');
        }
    });
<?php
    Tools::endJs('js');
 ?>
</script>
