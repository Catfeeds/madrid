<?php
$this->pageTitle = '用户列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',$type,array('name'=>'姓名','id'=>'ID','account'=>'论坛账号','phone'=>'电话'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',$value,array('class'=>'form-control chose_text')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('time_type',$time_type,array('created'=>'添加时间','updated'=>'刷新时间'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <?php Yii::app()->controller->widget("DaterangepickerWidget",['time'=>$time,'params'=>['class'=>'form-control chose_text']]);?>

            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
        </form>
    </div>
</div>
   <table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">ID</th>
        <th class="text-center">用户名</th>
        <th class="text-center">论坛账号</th>
        <th class="text-center">电话</th>
        <th class="text-center">添加时间</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $k=>$v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>" class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="text-center"><?=$v->name?></td>
            <td class="text-center"><?=$v->account?></td>
            <td class="text-center"><?=$v->phone?></td>
            <td class="text-center"><?=date('Y-m-d',$v->created)?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)); ?>
<script>
<?php Tools::startJs(); ?>
    function removeOptions()
    {
        // alert($('.chose_select').val());
        $('.chose_text').val('');
        $('.chose_select').val('');
    }
<?php Tools::endJs('js') ?>
</script>
