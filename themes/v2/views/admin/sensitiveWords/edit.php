<?php
/**
 * User: fanqi
 * Date: 2016/9/20
 * Time: 8:54
 */
$this->pageTitle = '敏感词编辑';
$this->breadcrumbs = array($this->pageTitle);
$form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'), 'enableAjaxValidation' => false)) ?>
    <div class="form-group">
        <h4 style="margin-left: 20px">编辑敏感词（以逗号隔开，如:枪支,弹药）</h4>
        <div class="col-md-12">
            <?php echo CHtml::textArea('words',$words, array('class' => 'form-control', 'rows' => '20')); ?>
        </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-5 col-md-9">
                <button type="submit" class="btn green">保存</button>
            </div>
        </div>
    </div>
<?php $this->endWidget() ?>
