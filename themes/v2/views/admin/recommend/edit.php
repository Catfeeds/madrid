<?php
$this->pageTitle = $model->id>0 ? '编辑推荐' : '添加推荐';
$this->breadcrumbs = array('推荐管理',$this->pageTitle);
?>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'title') ?><span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'title', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'title') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'s_title') ?>&nbsp;&nbsp;</label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 's_title', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 's_title') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'url') ?>&nbsp;&nbsp;</label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'url', array('class'=>'form-control' ,  'placeholder'=>'输入的网址请以http://开头')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'url') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">楼盘</label>
    <div class="col-md-4">
        <?php echo $form->autocomplete($model, 'hid', array('class'=>'form-control','data-init-text'=>$model->hid ? $model->plot->title : '','url'=>$this->createUrl('plot/ajaxGetHouse'))); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'hid') ?></div>
</div>
<?php $tmp = [];foreach ($this->recomCate as $key => $value) {
    if(in_array($value->pinyin, ["mfgw","xsy","xsy1","rstj","wapsy","xqf","kft","sy","syzxmk2","sytl","syxf","syrmzx","syrmzxlpcp"]))
    {
        $tmp[] = $value->id;
    }
} ?>
<div class="form-group">
    <label class="col-md-2 control-label">推荐位<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
            <?php echo $form->dropDownList($model, 'cid', CHtml::listData(Tools::menuMake($this->recomCate,-1,'id'),'id','name'), array('encode'=>false,'class'=>'form-control','ajax'=>array('url'=>$this->createUrl('ajaxValidConfig'),'type'=>'post','success'=>'function(d){$("#fenzhan,#mark_color").addClass("hide");if(d.code==1){$.each(d.msg,function(i,v){$("#"+v).removeClass("hide")});}}'))); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'cid') ?></div>
</div>
<?php if(SM::globalConfig()->enableSubstation()): ?>
<div class="form-group<?php if(!$model->substation_id): ?> hide<?php endif; ?>" id="fenzhan">
    <label class="col-md-2 control-label">推荐分站&nbsp;&nbsp;</label>
    <div class="col-md-4 radio-list">
        <?php echo $form->radioButtonList($model, 'substation_id', CHtml::listData($this->substations, 'area_id', 'name'), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<span>{input}{label}</span>')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'substation_id') ?></div>
</div>
<?php endif; ?>
<div class="form-group<?php if(!$model->enableMarkColorConfig()): ?> hide<?php endif; ?>" id="mark_color">
    <label class="col-md-2 control-label">标题红色高亮&nbsp;&nbsp;</label>
    <div class="col-md-4 radio-list">
        <?php echo $form->radioButtonList($model, 'config[markColor]', array('0'=>'否','1'=>'是'), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<span>{input}{label}</span>')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'config[markColor]') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">是否广告&nbsp;&nbsp;</label>
    <div class="col-md-4 radio-list">
        <?php echo $form->radioButtonList($model, 'config[isAd]', array('0'=>'否','1'=>'是'), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<span>{input}{label}</span>')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'config[isAd]') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'description') ?>&nbsp;&nbsp;</label>
    <div class="col-md-6">
        <?php echo $form->textArea($model, 'description', array('class'=>'form-control','rows'=>5)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'description') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'image') ?>&nbsp;&nbsp;</label>
    <div class="col-md-4">
        <?php $this->widget('FileUpload',array('model'=>$model,'attribute'=>'image','mode'=>2,'height'=>300,'width'=>300)) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'image') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'author') ?>&nbsp;&nbsp;</label>
    <div class="col-md-4">
        <?php
            echo $form->textField($model, 'author', array('class'=>'form-control','readOnly'=>'readOnly','value'=>Yii::app()->user->username));
            echo $form->hiddenField($model,'author_id',array('value'=>Yii::app()->user->id));
         ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'author') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'status') ?><span class="required" aria-required="true">*</span></label>
    <div class="col-md-4 radio-list">
        <?php echo $form->radioButtonList($model, 'status', ArHelper::listData(RecomExt::$status), array('separator'=>'')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'status') ?></div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回', $this->createUrl('/admin/recommend/list'),array('class'=>'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>


<script type="text/javascript">
<?php Tools::startJs(); ?>
    var RecomExt_cid = $('#RecomExt_cid');
        if(RecomExt_cid.attr('multiple')){
            RecomExt_cid.select2({});
            RecomExt_cid.on('change',function(t){
                // $('.select2-search-choice').each(function(){
                    // $(this).find('div').html(listdata[t.added.id]);
                // });
                $('.select2-search-choice').last().find('div').html(listdata[t.added.id]);
            });
        }
        <?php if($tmp) foreach ($tmp as $key => $value) {?>
           $("#RecomExt_cid option[value='"+<?=$value?>+"']").attr("disabled",true);
        <?php }?>
<?php Tools::endJs('js'); ?>
</script>
