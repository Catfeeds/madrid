<?php
/**
 * User: fanqi
 * Date: 2016/8/26
 * Time: 11:22
 */
$this->pageTitle = '黑名单手机号添加';
$this->breadcrumbs = array($this->pageTitle);
?>
<style type="text/css">
    .error_phone{
        border-color: red;
    }
</style>
<div class="table-toolbar">
    <div class="pull-right">
        <button type="button" id="add_phone" class="btn blue">
            添加列 <i class="fa fa-plus"></i>
        </button>
    </div>
</div>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'), 'enableAjaxValidation' => false)) ?>
<div class="tabbale">
    <div class="tab-content col-md-12" style="padding-top:20px;">
        <div class="col-md-10">
           <div class="form-group">
               <label class="col-md-2 control-label text-nowrap">1.</label>
                <div class="col-md-8 col-md-offset-2">
                    <div class="col-md-6">
                        <input id="black_0" type="text" class="form-control black_phone" name="phones[]" >
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button type="submit" class="btn green">保存</button>
                        <?php echo CHtml::link('返回', Yii::app()->createUrl('admin/black/list'), array('class' => 'btn default')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>
<script>
    <?php Tools::startJs(); ?>
    function phone_error($_this){
        if (!$_this.val().match(/^1[34578]{1}\d{9}$/)) {
            $_this.addClass("error_phone").after("<div id='msg_"+$_this.attr("id")+"' class='black_error_msg' style='color: red;'>手机号格式不正确</div>");
        }else{
            $_this.removeClass("error_phone");
            $("#msg_"+$_this.attr("id")).remove();
        }
    }
    jQuery(function($){

        var flag_id=1;
        $("#add_phone").on("click",function(){
            $(".form-group").last().after(
                "<div class=\"form-group\"><label class=\"col-md-2 control-label text-nowrap\">"+(flag_id+1)+".</label><div class=\"col-md-8 col-md-offset-2\"><div class=\"col-md-6\"><input id=\"black_"+(flag_id++)+"\" type=\"text\" class=\"form-control black_phone\" onchange='phone_error($(this))' name=\"phones[]\" ></div></div></div>"
            );
        });
        $(".black_phone").on("change",function(){
                phone_error($(this));
            });
    });
    <?php Tools::endJs('js');?>
</script
