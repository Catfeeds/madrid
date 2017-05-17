<?php
$this->pageTitle = '图片相册';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-actions">
            <div class="form-group">
                <label class="col-md-2 control-label">&nbsp;</label>
                <div class="form-container col-md-8">
                    <div class="upimg-con col-md-4 clearfix" style="border-bottom:1px dashed #ddd;margin-bottom:20px;">
                        <div id="js-imgReplace" class="upimg col-xs-5" style="width: 135px;display: inline-block;margin: 0px 10px 20px 0px;text-align: center;position:relative;">
                            <div>
                                <?php echo CHtml::image(ImageTools::fixImage($image->url,'125','125'),'',array('class'=>'uploaded-img','style'=>'width:125px;height:125px'));?>
                            </div>
                            <?php echo $form->hiddenField($image,'url',array('class'=>'js-imgurl js-input'))?>
                            <div id="fengmian" style="position: absolute; width: 125px; bottom: 0px; color: rgb(255, 255, 255); line-height: 25px; padding: 0px 10px; display: none; background: rgba(0, 0, 0, 0.498039); z-index: 999;">
                                <a href="javascript:;" class="uploaded-setcover" style="color:#fff;" onclick="setValue(this,'<?php echo $image->url?>')"><span class="fm"><?php echo $image->is_cover == 1 ? '我是封面' : '设为封面';?></span></a>
                                <?php echo $form->hiddenField($image,'is_cover',array('class'=>'js-iscover js-input'))?>

                            </div>
                        </div>

                        <div class="formlist col-xs-6">
                            <div class="form-group">
                                <label class="col-xs-2 control-label text-nowrap">名称<span class="required" aria-required="true">*</span></label>
                                <div class="col-xs-8">
                                    <?php echo $form->textField($image,'title',array('class'=>'form-control js-input')) ?>
                                </div>
                            </div>
                            <?php if($image->tag->name == '户型图'):?>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label text-nowrap">房型<span class="required" aria-required="true">*</span></label>
                                    <div class="col-xs-10">
                                        <?php echo $form->textField($image,'room',array('class'=>'form-control js-input input-mini input-inline')) ?>房

                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="col-xs-2 control-label text-nowrap">面积<span class="required" aria-required="true">*</span></label>
                                    <div class="col-xs-10">
                                        <?php echo $form->textField($image,'size',array('class'=>'form-control js-input input-inline')) ?>
                                        <span class="help-inline"> ㎡ </span>
                                    </div>
                                </div> -->
                            <?php endif;?>
                        </div>

                    </div></div>
            </div>
        </div>

        <div class="row">
            <div class="text-center col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">保存</button>
                <?php echo CHtml::link('返回', $this->createAbsoluteUrl('plot/imagelist',array('hid'=>$image->hid)),array('class'=>'btn default'));
                ?>
            </div>
        </div>

    </div>

    <!-- </form>-->
</div>
<?php $this->endWidget(); ?>

<style>
    .webuploader-element-invisible{ opacity:0; }
</style>
<?php
Yii::app()->clientScript->registerCssFile("/static/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css");
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/jquery-file-upload/js/jquery.fileupload.js',CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile('/static/global/plugins/jquery-file-upload/js/jquery.fileupload.js',CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile('/static/global/plugins/webuploader/webuploader.js',CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile('/static/global/scripts/qiniu.js',CClientScript::POS_END);//七牛js
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/imageadd.js', CClientScript::POS_END);
?>

