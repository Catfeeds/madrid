<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '图片相册';
$this->breadcrumbs = array($this->pageTitle);
?>
    <div class="portlet-body">
        <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
        <form role="form" class="form-horizontal" action="<?php echo Yii::app()->createAbsoluteUrl('/plot/imageadd/',array('hid'=>$hid))?>" method="post">

            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <?php $i = 1;?>
                    <?php foreach($ctype as $ck=>$cv):?>
                        <li class="<?php echo $i == 1 ? 'active' : '';?>" data-tid="<?php echo $ck;?>" data-tag-name="<?php echo $cv;?>">
                            <a href="#tab_15_<?php echo $ck?>" data-toggle="tab" aria-expanded="<?php echo $i==1 ? 'true' : 'false'?>"> <?php echo $cv;?> </a>
                        </li>
                        <?php $i++;?>
                    <?php endforeach;?>
                </ul>
                <div class="tab-content">
                    <?php $i = 1;?>
                    <?php foreach($ctype as $ck=>$cv):?>
                        <div class="tab-pane <?php echo $i == 1 ? 'active' : '';?>" id="tab_15_<?php echo $ck?>">
                            <div class="form-actions">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">&nbsp;</label>
                                    <div class="form-container col-md-8">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++;?>
                    <?php endforeach;?>

                </div>
            </div>


            <div class="form-body">
                <div class="form-group">
                    <label class="col-xs-2 control-label">&nbsp;</label>
                    <div class="col-xs-8">
                        <?php $this->widget('FileUpload',array('inputName'=>'img','multi'=>true,'waterMark'=>true,'callback'=>'function(data){callback(data);}')); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="text-center col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">保存</button>
                        <?php echo CHtml::link('返回', $this->createAbsoluteUrl('plot/imagelist',array('hid'=>$hid)),array('class'=>'btn default'));
                        ?>
                    </div>
                </div>

            </div>

        </form>
    </div>
<?php $this->endWidget(); ?>

    </div>

    <div id="thumb-tpl" style="display:none;">
        <div class="upimg-con col-md-4 clearfix" style="border-bottom:1px dashed #ddd;margin-bottom:20px;">
            <div  class="upimg col-xs-5" style="width: 135px;display: inline-block;margin: 0px 10px 20px 0px;text-align: center;position:relative;">
                <div >
                    <img class="uploaded-img" src="" style="width:125px;height:125px">
                </div>
                <?php echo CHtml::hiddenField('url','',array('class'=>'js-imgurl js-input'));?>
                <div style="position: absolute; width: 219px; height: 50px; z-index: 2; top: 0; display: none;" id="shanchu">
                    <a href="javascript:;" class="btn green-meadow" style="padding:6px 10px" id="del_img"><i class="fa fa-times"></i></a>
                </div>
                <div id="fengmian" style="position: absolute; width: 125px; bottom: 0px; color: #FFF; line-height: 25px; padding: 0px 10px;  display: none; background: rgba(0, 0, 0, 0.498039);">
                    <a href="javascript:;" class="uploaded-setcover" style="color:#fff;" onclick="setValue(this,'')"><span class="fm">设为封面</span></a>
                    <?php echo CHtml::hiddenField('is_cover','0',array('class'=>'js-iscover js-input'));?>
                </div>
            </div>

            <div class="formlist col-xs-6">
                <div class="form-group">
                    <label class="col-xs-2 control-label text-nowrap">名称<span class="required" aria-required="true">*</span></label>
                    <div class="col-xs-8">
                        <?php echo CHtml::textField('title','',array('class'=>'form-control js-input'))?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="thumb-tpl-hx" style="display:none;">
        <div class="form-group">
            <label class="col-xs-2 control-label text-nowrap">房型<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-10">
                <?php echo CHtml::textField('room','',array('class'=>'form-control js-input input-mini input-inline'))?>房
            </div>
        </div>

        <!-- <div class="form-group">
            <label class="col-xs-2 control-label text-nowrap">面积<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-10">
                <?php echo CHtml::textField('size','',array('class'=>'form-control js-input input-inline'))?>
                <span class="help-inline"> ㎡ </span>
            </div>
        </div> -->
    </div>

<?php
Yii::app()->clientScript->registerCssFile("/static/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css");
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/jquery-file-upload/js/jquery.fileupload.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/imageadd.js', CClientScript::POS_END);
?>
