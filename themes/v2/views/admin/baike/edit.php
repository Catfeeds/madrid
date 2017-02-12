<?php
$this->pageTitle = '知识库新建/编辑';
$this->breadcrumbs = array('知识库管理', $this->pageTitle);
?>
<?php $this->widget('ext.ueditor.UeditorWidget',array('id'=>'content','options'=>"toolbars:[['fullscreen','source','undo','redo','|','customstyle','paragraph','fontfamily','fontsize'],
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
    <label class="col-md-2 control-label">标题<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($baike, 'title', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'title') ?></div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">副标题</label>
	<div class="col-md-4">
		<?php echo $form->textField($baike, 'sub_title', array('class'=>'form-control')); ?>
	</div>
	<div class="col-md-2"><?php echo $form->error($baike, 's_title') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">分类</label>
    <div class="col-md-4">
        <?php echo $form->dropDownList($baike, 'cid', CHtml::listData(Tools::menuMake(BaikeCateExt::model()->enabled()->findAll()), 'id', 'name'), array('class' => 'form-control', 'encode' => false)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'cid') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">文章摘要</label>
    <div class="col-md-8">
        <?php echo $form->textArea($baike, 'description', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'description') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">文章内容</label>
    <div class="col-md-8">
        <?php echo $form->textArea($baike, 'content', array('id'=>'content')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'content')  ?></div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">图片</label>
	<div class="col-md-6">
		<div id="uploader1" class="wu-example">
		   <div class="btns">
			  <?php $this->widget('FileUpload',array('model'=>$baike,'attribute'=>'image','height'=>250,'inputName'=>'image','removeCallback'=>"$('#cover_img').html('')")); ?>
		   </div>
		</div>
		<div id="singlePicyw1"></div>
	 </div>
	<div class="col-md-2"><?php echo $form->error($baike, 'image') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">SEO关键词</label>
    <div class="col-md-4">
        <?php echo $form->textField($baike, 'seo_keywords', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'seo_keywords')  ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">标签</label>
    <div class="col-md-4">
        <?php echo $form->textField($baike, 'tag', array('class'=>'form-control',  'placeholder'=>'多个标签用逗号隔开')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'tag')  ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">外链</label>
    <div class="col-md-4">
        <?php echo $form->textField($baike, 'link', array('class' => 'form-control' ,  'placeholder'=>'输入的网址请以http://开头')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'link') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">文章来源</label>
    <div class="col-md-4">
        <?php echo $form->textField($baike, 'origin', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'origin') ?></div>
</div>
<div class="form-group">
        <label class="col-md-2 control-label">浏览次数</label>
        <div class="col-md-4">
        <?php echo $form->textField($baike, 'scan', array('class'=>'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($baike, 'scan') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">状态</label>
    <div class="col-md-4">
        <?php echo $form->radioButtonList($baike, 'status', BaikeExt::$status, array('separator' => '')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($baike, 'status') ?></div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',Yii::app()->user->returnUrl, array('class' => 'btn default')) ?>
        </div>
    </div>
</div>

<?php $this->endWidget() ?>

<?php
$js = "
        $(function(){

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
