
<div class="note note-danger">
    <p>
         提示: 您还可以上架<?=$this->staff->getCanSaleNum().'条房源。'?>
    </p>
</div>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',$type,array('title'=>'标题','content'=>'内容'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',$value,array('class'=>'form-control chose_text')); ?>
            </div>
            <!--            时间脚本 begin-->
                <div class="form-group">
                    <?= CHtml::dropDownList('time_type', $time_type, ['created' => '添加时间', 'refresh_time' => '刷新时间', 'sale_time' => '上架时间'], ['class' => 'form-control', 'encode' => false]) ?>
                </div>
                <div class="form-group">
                    <div class="input-group" id="defaultrange">
                        <?php echo CHtml::textField('time', $time, array('class' => 'form-control chose_text', 'readOnly' => true)); ?>
                        <span class="input-group-btn">
                            <button class="btn default date-range-toggle" type="button"><i
                                    class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div>
                <!--            时间脚本 end-->
             <div class="form-group">
                <?php echo CHtml::dropDownList('hid',$hid,$plots,array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--选择小区--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('category',$category,Yii::app()->params['category'],array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--选择类别--')); ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
        </form>
    </div>
    <div class="pull-right sort-arr">
        <div class="btn-group">
            <button type="button" class="btn btn-primary"><?=$sort?$sortArray[$sort]:'----选择排序----'?></button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-angle-down"></i></button>
            <ul class="dropdown-menu" role="menu">
            <li><?=CHtml::link('默认排序',$this->createUrl($action,array_merge($_GET,['sort'=>''])))?></li>
            <?php foreach($sortArray as $key=>$v){?>
                <li>
                    <?=CHtml::link($v,$this->createUrl($action,array_merge($_GET,['sort'=>$key])))?>
                </li>
              <?php  }?>
            </ul>
        </div>
    </div>
</div> 
<?php
//时间脚本
Yii::app()->clientScript->registerScriptFile('/static/global/scripts/daterangepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
?>