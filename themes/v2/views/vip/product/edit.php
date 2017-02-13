<?php
$this->pageTitle = '产品新建/编辑';
$this->breadcrumbs = array('产品管理', $this->pageTitle);
?>
<?php $this->widget('ext.ueditor.UeditorWidget',array('id'=>'ArticleExt_content','options'=>"toolbars:[['fullscreen','source','undo','redo','|','customstyle','paragraph','fontfamily','fontsize'],
        ['bold','italic','underline','fontborder','strikethrough','superscript','subscript','removeformat',
        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain','|',
        'forecolor','backcolor','insertorderedlist','insertunorderedlist','|',
        'rowspacingtop','rowspacingbottom', 'lineheight','|',
        'directionalityltr','directionalityrtl','indent','|'],
        ['justifyleft','justifycenter','justifyright','justifyjustify','|','link','unlink','|',
        'insertimage','emotion','scrawl','insertvideo','music','attachment','map',
        'insertcode','|',
        'horizontal','inserttable','|',
        'print','preview','searchreplace']]")); ?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label">名称<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'name', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'name') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">外文名<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'eng', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'eng') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">类型</label>
    <div class="col-md-4">
        <?php echo $form->dropDownList($article, 'cid', $cates, array('class' => 'form-control', 'encode' => false)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'cid') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">系列</label>
    <div class="col-md-4">
        <?php echo $form->dropDownList($article, 'xl', $xls, array('class' => 'form-control', 'encode' => false)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'xl') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">葡萄品种</label>
    <div class="col-md-4">
        <?php echo $form->dropDownList($article, 'ptpz', $ptpzs, array('class' => 'form-control', 'encode' => false)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'ptpz') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">选择酒庄</label>
    <div class="col-md-4">
        <?php echo $form->dropDownList($article, 'house', $houses, array('class' => 'form-control', 'encode' => false)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'house') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label text-nowrap">国家</label>
    <div class="col-md-3">
         <?php echo $form->textField($article, 'country', array('class' => 'form-control')); ?>

        <span class="help-block"><?php echo $form->error($article, 'country'); ?></span>
    </div>
    <label class="col-md-2 right-text control-label text-nowrap">区域</label>
     <div class="col-md-3">
         <?php echo $form->textField($article, 'area', array('class' => 'form-control')); ?>

        <span class="help-block"><?php echo $form->error($article, 'area'); ?></span>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">售价<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'price', array('class' => 'form-control')); ?>
        <span class="help-inline">元</span>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'price') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">产品介绍</label>
    <div class="col-md-8">
        <?php echo $form->textArea($article, 'content', array('id'=>'ArticleExt_content')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'content')  ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label text-nowrap">封面图</label>
    <div class="col-md-8">
        <?php $this->widget('FileUpload',array('model'=>$article,'attribute'=>'image','inputName'=>'img','width'=>400,'height'=>300)); ?>
        <!-- <span class="help-block">建议尺寸：240*300</span>  -->
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">相册</label>
    <div class="col-md-8">
        <?php $this->widget('FileUpload',array('inputName'=>'img','multi'=>true,'waterMark'=>false,'callback'=>'function(data){callback(data);}')); ?>
    </div>
</div>
<div class="form-group images-place" style="margin-left: 220px">
  <?php if($article->images) foreach ($article->images as $key => $value) {?>
      <div class='image-div' style='width: 150px;display:inline-table;height:180px'><a onclick='del_img(this)' class='btn red btn-xs' style='position: absolute;margin-left: 94px;'><i class='fa fa-trash'></i></a><img src='<?=ImageTools::fixImage($value->url)?>' style='width: 120px;height: 90px'><input name='image_des[]' value="<?=$value->name?>"  type='text' style='width: 120px'></input><input type='hidden' class='trans_img' name='images[]' value='"+data.msg.pic+"'></input></div>
  <?php }?>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('list'), array('class' => 'btn default')) ?>
        </div>
    </div>
</div>

<?php $this->endWidget() ?>

<?php
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/esf-add-images.js', CClientScript::POS_END);

$js = "

    var getHousesAjax =
     {
        url: '".$this->createUrl('/admin/plot/AjaxGetHouse')."',"."
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                kw:params
            };
        },
        results:function(data){
            var items = [];

             $.each(data.results,function(){
                var tmp = {
                    id : this.id,
                    text : this.name
                }
                items.push(tmp);
            });

            return {
                results: items
            };
        },
        processResults: function (data, page) {
            var items = [];
             $.each(data.msg,function(){
                var tmp = {
                    id : this.id,
                    text : this.title
                }
                items.push(tmp);
            });
            return {
                results: items
            };
        }
    }
        $(function(){

           $('.select2').select2({
              placeholder: '请选择',
              allowClear: true
           });

				var houses_edit = $('#plot');
				var data = {};
				if( houses_edit.length && houses_edit.data('houses') ){
					data = eval(houses_edit.data('houses'));
				}

				$('#plot').select2({
					multiple:true,
					ajax: getHousesAjax,
					language: 'zh-CN',
					initSelection: function(element, callback){
						callback(data);
					}
				});

             $('.form_datetime').datetimepicker({
                 autoclose: true,
                 isRTL: Metronic.isRTL(),
                 format: 'yyyy-mm-dd hh:ii',
                 // minView: 'm',
                 language: 'zh-CN',
                 pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
             });

             $('.form_datetime1').datetimepicker({
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
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2_locale_zh-CN.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
Yii::app()->clientScript->registerCssFile('/static/admin/pages/css/select2_custom.css');

Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/addCustomizeDialog.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);
?>
