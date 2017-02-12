<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '价格动态编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">标签名称</label>
            <div class="col-md-10">
                <?php echo $form->textField($data, 'title', array('class'=>'form-control input-inline')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">价格区间</label>
            <div class="col-md-10">
                <?php echo $form->textField($data,'min',array('class'=>'form-control input-small input-inline')) ?>
                <label> -- </label>
                <?php echo $form->textField($data,'max',array('class'=>'form-control input-small input-inline')) ?>
            </div>
            <div class="col-xs-2"><?php echo $form->error($data, 'min') ?><?php echo $form->error($data, 'max') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">排序</label>
            <div class="col-md-10">
                <?php echo $form->textField($data,'sort',array('class'=>'form-control input-small input-inline')) ?>
            </div>
            <div class="col-xs-2"><?php echo $form->error($data, 'sort') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">是否开启</label>
            <div class="col-md-10">
                <div class="radio-list">
                    <?php echo $form->radioButtonList($data,'status', PlotPricetagExt::$status,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;')) ?>
                </div>
            </div>
            <div class="col-md-12"><?php echo $form->error($data, 'status'); ?></div>
        </div>
        <div class="col-md-12 center-block text-center">
            <div class="btn-group text-center">
                <button class="btn green-meadow col-md-offset-4" type="submit">提交</button>
                <?php echo CHtml::link('返回', $this->createAbsoluteUrl('/admin/plot/pricetaglist'),array('class'=>'btn default col-md-offset-4')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <!-- </form>-->
</div>

