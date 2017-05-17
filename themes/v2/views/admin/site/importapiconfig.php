<?php
$this->pageTitle = '导数据接口';
$this->breadcrumbs = array('站点设置',$this->pageTitle);
?>
<div class="note note-success">
    <p>填写完整的超链接地址，带协议http(s)，无后缀参数如问号(?)等，例如http://www.abc.com/get_album/，所有接口参数请见文档</p>
</div>



<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
<div class="form-group">
    <label class="col-md-2 control-label">token</label>
    <div class="col-md-4">
        <?php echo CHtml::textField('token', md5(SM::urmConfig()->siteID()),array('readOnly'=>true,'class'=>'form-control')); ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importAreaApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importAreaApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importAreaApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotDeliveryApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotDeliveryApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotDeliveryApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotDiscountApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotDiscountApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotDiscountApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotImgApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotImgApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotImgApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotPriceApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotPriceApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotPriceApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotSpecialApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotSpecialApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotSpecialApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotTuanApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotTuanApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotTuanApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importAskCateApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importAskCateApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importAskCateApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importAskApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importAskApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importAskApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importArticleCateApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importArticleCateApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importArticleCateApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importArticleApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importArticleApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importArticleApi') ?></div>
</div>



<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importOrderApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importOrderApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importOrderApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importUserApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importUserApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importUserApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importAdminLogApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importAdminLogApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importAdminLogApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importSchoolApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importSchoolApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importSchoolApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importSchoolPlotRelApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importSchoolPlotRelApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importSchoolPlotRelApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotKanApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotKanApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotKanApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importPlotHouseType') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importPlotHouseType', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importPlotHouseType') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importShopApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importShopApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importShopApi') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'importEsfApi') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'importEsfApi', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'importEsfApi') ?></div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('/admin/common/index'),array('class'=>'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>
