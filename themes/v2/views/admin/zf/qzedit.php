<?php
/**
 * User: fanqi
 * Date: 2016/8/10
 * Time: 11:44
 */
$this->pageTitle = '求租编辑';
$this->breadcrumbs = array($this->pageTitle);
?><style type="text/css">
    .right-text{
        text-align: left !important;padding-left: 0;width: 20px;
    }
 </style>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'), 'enableAjaxValidation' => false)) ?>
<div class="tabbale">
    <div class="tab-content col-md-12" style="padding-top:20px;">
        <div class="col-md-10">
            <?php echo $form->hiddenField($qz, 'id'); ?>
            
            <?php echo $form->hiddenField($qz, 'hid');?>
            <?php echo $form->hiddenField($qz, 'category',['id'=>'category']);?>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>发布人姓名</label>
                <div class="col-md-8">
                    <?php echo $form->textField($qz,'username',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($qz, 'username') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>发布人联系电话</label>
                <div class="col-md-8">
                   <?php echo $form->textField($qz,'phone',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($qz, 'phone') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>求租类型</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qz, 'category',  ResoldEsfExt::$categories, array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>','disabled'=>$qz->id?'disabled':'')); ?>
                    <span class="help-block"><?php echo $form->error($qz, 'category'); ?></span>
                    </div>
                </div>
                <?php if($qz->id):
                        echo $form->textField($qz,'category',['style'=>'display:none']);
                     endif;?>
            </div>
            <!-- <div class="form-group" id="esfzfzztype" style="display:none">
                <label class="col-md-2 control-label text-nowrap">期望住宅类别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($qz, 'esfzfzztype', CHtml::listData(TagExt::model()->getTagByCate('esfzfzztype')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qz, 'esfzfzztype'); ?></span>
                </div>
            </div> -->
            <div class="form-group" id="esfzfsptype">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望商铺类别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($qz, 'esfzfsptype', CHtml::listData(TagExt::model()->getTagByCate('esfzfsptype')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qz, 'esfzfsptype'); ?></span>
                </div>
            </div>
            <div class="form-group" id="esfzfxzltype">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望写字楼类别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($qz, 'esfzfxzltype', CHtml::listData(TagExt::model()->getTagByCate('esfzfxzltype')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qz, 'esfzfxzltype'); ?></span>
                </div>
            </div>
            <div class="form-group" id="zfspkjyxm">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望商铺可经营性项目</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->checkBoxList($qz, 'zfspkjyxm', CHtml::listData(TagExt::model()->getTagByCate('zfspkjyxm')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qz, 'zfspkjyxm'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望区域</label>
                <div class="col-md-3">
                     <?php echo $form->dropDownList($qz,'area', AreaExt::getAllarea(),array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>

                    <span class="help-block"><?php echo $form->error($qz, 'area'); ?></span>
                </div>
                <label class="col-md-2 control-label text-nowrap">期望街道</label>
                 <div class="col-md-3">
                     <?php echo $form->dropDownList($qz,'street', [],array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>

                    <span class="help-block"><?php echo $form->error($qz, 'street'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望小区</label>
                <div class="col-md-2">
                    <?php $plots = $qz->getPlots(); echo $form->autocomplete($qz, 'hid[0]', array('class'=>'form-control','data-init-text'=>isset($plots[0]) ? $plots[0]['plot_name'] : '','url'=>$this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block"><?php echo $form->error($qz, 'hid'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">
                或
                </label>
                <div class="col-md-2">
                    <?php echo $form->autocomplete($qz, 'hid[1]', array('class'=>'form-control','data-init-text'=>isset($plots[1]) ? $plots[1]['plot_name'] : '','url'=>$this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block"><?php echo $form->error($qz, 'hid'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">
                或
                </label>
                <div class="col-md-2">
                    <?php echo $form->autocomplete($qz, 'hid[2]', array('class'=>'form-control','data-init-text'=>isset($plots[2]) ? $plots[2]['plot_name'] : '','url'=>$this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block"><?php echo $form->error($qz, 'hid'); ?></span>
                </div>
            </div>
            
            <div class="form-group" id="qzchamber" style="display:none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望户型</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->checkBoxList($qz, 'resoldhuxing', CHtml::listData(TagExt::model()->getTagByCate('resoldhuxing')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qz, 'resoldhuxing'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望租金</label>
                <div class="col-md-10">
                    <span class="help-inline">不超过</span>
                    <?php echo $form->textField($qz, 'price', array('class' => 'form-control input-inline')); ?>
                    <span class="help-inline">元/月</span>
                    <span class="help-block">
                <?php echo $form->error($qz, 'price'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望面积</label>
                <div class="col-md-10">
                    <span class="help-inline">不小于</span>
                    <?php echo $form->textField($qz, 'size', array('class' => 'form-control input-inline')); ?>
                    <span class="help-inline">m<sup>2</sup></span>
                    <span class="help-block">
            <?php echo $form->error($qz, 'size'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">期望装修情况</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($qz, 'decoration', CHtml::listData(TagExt::model()->getTagByCate('resoldzx')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <div class="col-md-12"><?php echo $form->error($qz, 'decoration'); ?></div>
                </div>
            </div>
            <div class="form-group" id="rent_type" style="display:none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望租房方式</label>
                <div class="col-md-10">
                    <?php echo $form->radioButtonList($qz, 'rent_type',CHtml::listData(TagExt::model()->getTagByCate('zfmode')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    <span class="help-block">
                        <?php echo $form->error($qz, 'rent_type'); ?></span>
                </div>
            </div>
            <div class="form-group" id="zfzzpt" style="display:none">
                <label class="col-md-2 control-label text-nowrap">配套设施</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($qz, 'zfzzpt', CHtml::listData(TagExt::model()->getTagByCate('zfzzpt')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfsppt" style="display:none">
                <label class="col-md-2 control-label text-nowrap">配套设施</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($qz, 'zfsppt', CHtml::listData(TagExt::model()->getTagByCate('zfsppt')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfxzlpt" style="display:none">
                <label class="col-md-2 control-label text-nowrap">配套设施</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($qz, 'zfxzlpt', CHtml::listData(TagExt::model()->getTagByCate('zfxzlpt')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>求租标题</label>
                <div class="col-md-10">
                    <?php echo $form->textField($qz, 'title', array('class' => 'form-control', 'data-target' => 'pointname')); ?>
                    <span class="help-block"><?php echo $form->error($qz, 'title'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">求租描述</label>
                <div class="col-md-10">
                    <?php echo $form->textArea($qz, 'content', array('class' => 'form-control', 'rows' => '6')); ?>
                    <span class="help-block">
            <?php echo $form->error($qz, 'content'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">房源状态</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($qz, 'status',  Yii::app()->params['qzStatus'], array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                        <span class="help-block"><?php echo $form->error($qz, 'status'); ?></span>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">

                    <button class="btn green-meadow col-md-offset-4">提交</button>
                        <?php echo CHtml::link('返回', Yii::app()->createUrl($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'admin/zf/qzList'), array('class' => 'btn default')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>

<?php
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/linkage-zf.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/add-images.js', CClientScript::POS_END);
//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset' => 'utf-8'));
$js = "
            $(function(){

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm-dd',
                     minView: 'month',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });
            })
            ";

Yii::app()->clientScript->registerScript('add', $js, CClientScript::POS_END);

?>
<script>
    <?php Tools::startJs(); ?>
    jQuery(function ($) {
        $('#category').linkage_zf([
            {
                '_id': 'qzchamber',
                '_parent_value': 1
            },
            {
                '_id': 'price-zz',
                '_parent_value': 1
            },
            {
                '_id':'floor',
                '_parent_value':1
            },

            {
                '_id': 'rent_type',
                '_parent_value': 1
            },
            {
                '_id': 'zfzzpt',
                '_parent_value': 1
            },
            {
                '_id': 'esfzfsptype',
                '_parent_value': 2
            },
            {
                '_id': 'zfspkjyxm',
                '_parent_value': 2
            },
            {
                '_id': 'price-other',
                '_parent_value': [2, 3]
            },
            {
                '_id': 'zfsppt',
                '_parent_value': 2
            },
            {
                '_id': 'esfzfxzltype',
                '_parent_value': 3
            },
            {
                '_id': 'zfxzlpt',
                '_parent_value': 3
            },
        ]);
        <?php if($qz->category==1):?>
            $('#hid,#qzchamber,#rent_type,#zfzzpt,#esfzfzztype').css('display','block');
        <?php endif;?>
        <?php if($qz->category==2):?>
            $('#hid,#zfsppt,#esfzfsptype,#zfspkjyxm').css('display','block');
        <?php endif;?>
        <?php if($qz->category==3):?>
            $('#hid,#zfxzlpt,#esfzfxzltype').css('display','block');
        <?php endif;?>
         //楼盘初始化
         i = 0;
        <?php foreach ($plots as $key => $value) {?>
            $('#ResoldQzExt_hid_'+i).val(<?=$value['id']?>);
            i++;
        <?php }?>
    });
    function mianyi_check() {
        if ($("#uniform-mianyi").find("span").attr("class") == "checked") {
            $("#ResoldQzExt_price").val(0).attr("readonly", true);
        } else {
            $("#ResoldQzExt_price").removeAttr("readonly");
        }
    }
    $("#mianyi").bind("change", function () {
        mianyi_check();
    });
    $(document).ready(function(){
        $('#ResoldQzExt_area').val(<?=$qz->area?>);
        <?php foreach (AreaExt::getAllstreet() as $key => $value) {
            ?>
            if($('#ResoldQzExt_area').val()==<?=$key?>)
            {
                html = "";
                <?php foreach ($value as $key => $v) {?>
                   html += "<option value='<?=$key?>'><?=$v?></option>";
                <?php }?>
                $('#ResoldQzExt_street').append(html);
            }
        <?php }?>
        $('#ResoldQzExt_street').val(<?=$qz->street?>);
    });
    $('#ResoldQzExt_area').change(function(){
        $('#ResoldQzExt_street option').remove();
         <?php foreach (AreaExt::getAllstreet() as $key => $value) {
            ?>
            if($('#ResoldQzExt_area').val()==<?=$key?>)
            {
                html = "";
                <?php foreach ($value as $key => $v) {?>
                   html += "<option value='<?=$key?>'><?=$v?></option>";
                <?php }?>
                $('#ResoldQzExt_street').append(html);
            }
        <?php }?>
    });
    

    <?php Tools::endJs('js');?>
</script>
