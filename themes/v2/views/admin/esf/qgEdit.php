<?php
$this->pageTitle = '编辑二手房求购信息';
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
	    	<div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>发布人姓名</label>
                <div class="col-md-8">
                    <?php echo $form->textField($qg,'username',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($qg, 'username') ?></div>
            </div>
	    	<div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>发布人联系电话</label>
                <div class="col-md-8">
                   <?php echo $form->textField($qg,'phone',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($qg, 'phone') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>求购类型</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'category',  Yii::app()->params['category'], array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>','disabled'=>$qg->id?'disabled':'')); ?>
                    <?php if($qg->id):
                        echo $form->textField($qg,'category',['style'=>'display:none']);
                     endif;?>
                    <span class="help-block"><?php echo $form->error($qg, 'category'); ?></span>
                    </div>
                </div>
            </div>
            <div class="form-group sp xzl" style="display: none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>求购子类型</label>
                <div class="col-md-10 zz esf_type" style="display: none">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'tags[1]',  CHtml::listData(TagExt::model()->getTagByCate('esfzfzztype')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qg, 'tags[]'); ?></span>
                </div>
                <div class="col-md-10 sp esf_type" style="display: none">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'tags[2]',  CHtml::listData(TagExt::model()->getTagByCate('esfzfsptype')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qg, 'tags[]'); ?></span>
                </div>
                <div class="col-md-10 xzl esf_type" style="display: none">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'tags[3]',  CHtml::listData(TagExt::model()->getTagByCate('esfzfxzltype')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qg, 'tags[]'); ?></span>
                </div>
            </div>
            <div class="form-group sp"  style="display: none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>商铺可经营项目</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->checkBoxList($qg, 'tags[4]',  CHtml::listData(TagExt::model()->getTagByCate('esfspkjyxm')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($qg, 'tags[]'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望区域</label>
                <div class="col-md-3">
                     <?php echo $form->dropDownList($qg,'area', AreaExt::getAllarea(),array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>

                    <span class="help-block"><?php echo $form->error($qg, 'area'); ?></span>
                </div>
                <label class="col-md-2 control-label text-nowrap">期望街道</label>
                 <div class="col-md-3">
                     <?php echo $form->dropDownList($qg,'street', [],array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>

                    <span class="help-block"><?php echo $form->error($qg, 'street'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望小区</label>
                <div class="col-md-2">
                    <?php $plots = $qg->getPlots(); echo $form->autocomplete($qg, 'hid[0]', array('class'=>'form-control','data-init-text'=>isset($plots[0]) ? $plots[0]['plot_name'] : '','url'=>$this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'hid'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">
                或
                </label>
                <div class="col-md-2">
                    <?php echo $form->autocomplete($qg, 'hid[1]', array('class'=>'form-control','data-init-text'=>isset($plots[1]) ? $plots[1]['plot_name'] : '','url'=>$this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'hid'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">
                或
                </label>
                <div class="col-md-2">
                    <?php echo $form->autocomplete($qg, 'hid[2]', array('class'=>'form-control','data-init-text'=>isset($plots[2]) ? $plots[2]['plot_name'] : '','url'=>$this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'hid'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望面积</label>
                <div class="col-md-4">
                    <?php echo $form->textField($qg,'size',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'size'); ?></span>
                </div>
                <label class="col-md-1 control-label text-nowrap right-text">平方米及以上</label>
                <div class="col-md-12"></div>
            </div>
            <div class="form-group zz esf_type"  style="display: none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望房型</label>
                <div class="col-md-2">
                    <?php echo $form->textField($qg,'bedroom',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'bedroom'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">室 </label>
                <div class="col-md-2">
                    <?php echo $form->textField($qg,'livingroom',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'livingroom'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">厅 </label>
                <div class="col-md-2">
                    <?php echo $form->textField($qg,'bathroom',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'bathroom'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">卫 </label>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>期望价格</label>
                <div class="col-md-2">
                    <?php echo $form->textField($qg,'price',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'price'); ?></span>
                </div>
                <label class="col-md-1 control-label text-nowrap right-text">万及以下 </label>
            </div>
            <div class="form-group zz esf_type" style="display: none">
                <label class="col-md-2 control-label text-nowrap">期望房龄</label>
                <div class="col-md-10">
                <div class="radio-list">
                <?php echo $form->radioButtonList($qg, 'tags[20][]',  CHtml::listData(TagExt::model()->getTagByCate('qgzzqwfl')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                </div>
                </div>
                <!-- <label class="col-md-2 control-label" style="text-align: left !important;padding-left: 0;">年以后 </label> -->
            </div>
            <div class="form-group zz esf_type" style="display: none">
                <label class="col-md-2 control-label text-nowrap">期望楼层</label>
                <div class="col-md-10">
                <div class="radio-list">
                <?php echo $form->radioButtonList($qg, 'tags[21][]',  CHtml::listData(TagExt::model()->getTagByCate('qgzzqwlc')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                </div>
                </div>
                <!-- <label class="col-md-2 control-label" style="text-align: left !important;padding-left: 0;">年以后 </label> -->
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">装修情况</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'decoration',  CHtml::listData(TagExt::model()->getTagByCate('resoldzx')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($qg, 'decoration'); ?></div>
            </div>
            <div class="form-group zz esf_type" style="display: none">
                <label class="col-md-2 control-label text-nowrap">期望朝向</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'towards',  CHtml::listData(TagExt::model()->getTagByCate('resoldface')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($qg, 'towards'); ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">配套设施</label>
                <?php 
                    $zzppt = TagExt::model()->getTagByCate('esfzzpt')->normal()->findAll(['order'=>'sort asc']);
                    $spppt = TagExt::model()->getTagByCate('esfsppt')->normal()->findAll(['order'=>'sort asc']);
                    $xzlppt = TagExt::model()->getTagByCate('esfxzlpt')->normal()->findAll(['order'=>'sort asc']);
                ?>
                <div class="col-md-10 zzpt peizhi" style="display: none">
                    <?php foreach ($zzppt as $key => $value) {?>
                       <input type="checkbox" name="tags[5][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-10 sppt peizhi" style="display: none">
                <?php foreach ($spppt as $key => $value) {?>
                       <input type="checkbox" name="tags[6][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-10 xzlpt peizhi" style="display: none">
                <?php foreach ($xzlppt as $key => $value) {?>
                       <input type="checkbox" name="tags[7][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-12"><?php echo $form->error($qg, 'tags[]'); ?></div>
            </div>
             <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房源标题</label>
                <div class="col-md-8">
                    <?php echo $form->textField($qg,'id',array('class'=>'form-control','style'=>'display:none')); ?>
                    <?php echo $form->textField($qg,'title',array('class'=>'form-control','data-target'=>'pointname')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'title'); ?></span>
                </div>
                <div class="col-md-2"><?php echo $form->error($qg, 'title') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">房源描述</label>
                <div class="col-md-8">
                    <?php echo $form->textarea($qg,'content',array('class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'content'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">房源状态</label>
                <div class="col-md-10">
                <div class="radio-list">
                    <?php echo $form->radioButtonList($qg, 'status',  Yii::app()->params['qgStatus'], array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    <span class="help-block"><?php echo $form->error($qg, 'status'); ?></span>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">

                    <button class="btn green-meadow col-md-offset-4">提交</button>
                        <?php echo CHtml::link('返回', Yii::app()->createUrl($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'admin/zf/qgList'), array('class' => 'btn default')) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $this->endWidget(); 
	Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/esf-add-images.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    $(document).ready(function(){
        $('#ResoldQgExt_area').val(<?=$qg->area?>);
        <?php foreach (AreaExt::getAllstreet() as $key => $value) {
            ?>
            if($('#ResoldQgExt_area').val()==<?=$key?>)
            {
                html = "";
                <?php foreach ($value as $key => $v) {?>
                   html += "<option value='<?=$key?>'><?=$v?></option>";
                <?php }?>
                $('#ResoldQgExt_street').append(html);
            }
        <?php }?>
        $('#ResoldQgExt_street').val(<?=$qg->street?>);
    });
    $('#ResoldQgExt_area').change(function(){
        $('#ResoldQgExt_street option').remove();
         <?php foreach (AreaExt::getAllstreet() as $key => $value) {
            ?>
            if($('#ResoldQgExt_area').val()==<?=$key?>)
            {
                html = "";
                <?php foreach ($value as $key => $v) {?>
                   html += "<option value='<?=$key?>'><?=$v?></option>";
                <?php }?>
                $('#ResoldQgExt_street').append(html);
            }
        <?php }?>
    });
    var arr = [];
    var i = 0;
    //标签初始化
    <?php if($data_conf = json_decode($qg->data_conf,true)); if(isset($data_conf['tags'])&&$data_conf['tags']) foreach($data_conf['tags'] as $value){?>
        arr = $("input[value='<?=$value?>']");
        $(arr).attr('checked','checked');
    <?php } ?>
     //楼盘初始化
    <?php foreach ($plots as $key => $value) {?>
    	$('#ResoldQgExt_hid_'+i).val(<?=$value['id']?>);
    	i++;
    <?php }?>
    <?php Tools::endJs('js'); ?>
</script>