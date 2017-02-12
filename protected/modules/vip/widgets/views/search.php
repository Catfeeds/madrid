<?php
$sortArray = [
    'saleup' => '上架时间从早到晚',
    'saledown' => '上架时间从晚到早',
    'refreshup' => '刷新时间从早到晚',
    'refreshdown' => '刷新时间从晚到早'
];
?>

<div class="note note-danger">
    <p>
         提示: 您还可以上架<?=$staff->getCanSaleNum().'条房源。'?>
    </p>
</div>
    <div class="table-toolbar">
        <div class="btn-group pull-left">
            <form class="form-inline">
                <div class="form-group">
                    <?php echo CHtml::dropDownList('type', $type, array('title' => '标题', 'content' => '内容'), array('class' => 'form-control', 'encode' => false)); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::textField('value', $value, array('class' => 'form-control chose_text')); ?>
                </div>
                <!--            时间脚本 begin-->
                <div class="form-group">
                    <?= CHtml::dropDownList('time_type', $time_type, ['created' => '添加时间', 'refresh_time' => '刷新时间', 'sale_time' => '上架时间'], ['class' => 'form-control', 'encode' => false]) ?>
                </div>
                <?php Yii::app()->controller->widget("DaterangepickerWidget",['time'=>$time]);?>
                <!--            时间脚本 end-->
                <?php echo CHtml::dropDownList('hid', $hid, $plots, ['class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--选择小区--']); ?>
                <?php echo CHtml::dropDownList('category', $category, Yii::app()->params['category'], ['class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--选择类别--']); ?>
                <button type="submit" class="btn blue">搜索</button>
                <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
            </form>
        </div>
        <div class="pull-right sort-arr">
            <div class="btn-group">
                <button type="button" class="btn btn-primary"><?= $sort ? $sortArray[$sort] : '----选择排序----' ?></button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="true"><i
                        class="fa fa-angle-down"></i></button>
                <ul class="dropdown-menu" role="menu">
                    <li><?= CHtml::link('默认排序', Yii::app()->controller->createUrl('saleUp', array_merge($_GET, ['sort' => '']))) ?></li>
                    <?php foreach ($sortArray as $key => $v) { ?>
                        <li>
                            <?= CHtml::link($v, Yii::app()->controller->createUrl('saleUp', array_merge($_GET, ['sort' => $key]))) ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>