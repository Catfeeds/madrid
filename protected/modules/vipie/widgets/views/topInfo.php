<div class="formitm">
    <?php if(isset(Yii::app()->params['category'][$category])):?><label class="lab"><span class="re">*</span> <?=Yii::app()->params['category'][$category]?>类型</label><?php endif;?>
    <div class="ipt">
        <ul class="radio-list f-cb">
        <?php if($typeArr) foreach ($typeArr as $key => $value) { ?>
            <li><label><input type="radio" <?=($type==$key)?'checked':''?> name="<?=$modelName=='ResoldEsfExt'?'tagsArr[0][]':($modelName.'['.$infoType.']')?>" value="<?=$key?>"/><?=$value?></label></li>
        <?php }?>
        </ul>
        <?php if($model->id):?>
            <input type="hidden" name="<?=$modelName.'[id]'?>" value="<?=$model->id?>"></input>
        <?php endif;?>
        <?php if($model->category):?>
            <input type="hidden" name="<?=$modelName.'[category]'?>" value="<?=$model->category?>"></input>
        <?php endif;?>
    </div>
</div>
<div class="formitm pt10">
<label class="lab"><span class="re">*</span> 楼盘名称</label>
    <div class="ipt">
    <!--简易单行文本输入框-->
    <input type="text" class="u-ipt u-ipt-form j-plot-search ui-autocomplete-input" autocomplete="off" value="<?=$model->plot_name?>" datatype="*" nullmsg="请输入小区名称" name="<?=$modelName.'[plot_name]'?>">
    <input type="hidden" id="plot_id" name="<?=$modelName.'[hid]'?>" value="<?=$model->hid?>"></input>
    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible">No search results.</span>
     </div>
</div>
<!-- <div class="formitm pt10">
    <label class="lab"><span class="re">*</span> 楼盘名称</label>
    <div class="ipt">
        <input type="text" name="<?=$modelName.'[hid]'?>" class="u-ipt u-ipt-form j-plot-search" style="width:760px"/><span class="errmsg"></span>
    </div>
</div> -->
<div class="formitm">
    <label class="lab"><span class="re"></span> 小区地址</label>
    <div class="ipt">
        <input type="text" id="plot_address" name="<?=$modelName.'[address]'?>" value="<?=$model->address?>" class="u-ipt u-ipt-form" style="width:760px"/>
    </div>
</div>
<div class="formitm">
    <label class="lab"><span class="re">*</span> 所在楼层</label>
    <div class="ipt">
        <?php echo CHtml::textField($modelName.'[floor]',$model->floor?$model->floor:'',array('class'=>'u-ipt u-ipt1','data-name'=>'楼层','datatype'=>'floor','nullmsg'=>'请输入楼层')); ?><span class="unit">层，共</span><?php echo CHtml::textField($modelName.'[total_floor]',$model->total_floor?$model->total_floor:'',array('class'=>'u-ipt u-ipt1','datatype'=>'floor,floors','data-name'=>'总楼层','nullmsg'=>'请输入总层数')); ?><span class="unit">层（地下室楼层在数字前加“-”）</span>
    </div>
</div>
<div class="formitm">
    <label class="lab"><span class="re">*</span> 面<span class="em2"></span>积</label>
    <div class="ipt">
        <?php echo CHtml::textField($modelName.'[size]',$model->size?$model->size:'',array('class'=>'u-ipt u-ipt1','style'=>'width:200px','datatype'=>'size','nullmsg'=>'请输入面积','errormsg'=>'面积要大于1平方米小于10000平方米')); ?><span class="unit">平方米</span>
    </div>
</div>
<div class="formitm">
    <label class="lab"><span class="re">*</span> 总<span class="em2"></span>价</label>
    <div class="ipt">
        <?php echo CHtml::textField($modelName.'[price]',$model->price?(int)$model->price:'',array('class'=>'u-ipt u-ipt1','style'=>'width:200px','datatype'=>'rent','nullmsg'=>'请输入价格','errormsg'=>'价格必须在0到1000000之间')); ?><span class="unit"><?=$modelName=='ResoldEsfExt'?'万元':'元/月'?></span><span class="tip">(若总价为“0”前台显示为面议)</span>
    </div>
</div>
<script type="text/javascript">
<?php Tools::startJs() ?>
    var info_id = 0;
    <?php if($model->id):?>
        info_id = '<?=$model->id?>';
    <?php endif;?>
    var model_name = '<?=$modelName?>';

<?php Tools::endJs('js') ?>
</script>