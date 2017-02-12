<?php
$sortArray = [
    'saleup' => '上架时间从早到晚',
    'saledown' => '上架时间从晚到早',
    'refreshup' => '刷新时间从早到晚',
    'refreshdown' => '刷新时间从晚到早'
];
foreach ($fields as $key => $v) {
    $$key = $v;
}
?>
<div class="num-tip">提示：您还可以上架<?=$num?>条房源</div>
<form method="get">
<div class="search-type-container f-cb">
    <div class="blank20"></div>
    <ul class="f-cb search-list">
        <li class="search-item">
            <?php echo CHtml::dropDownList('type',$type,array('title'=>'标题','content'=>'内容'),array('class'=>'j-select','encode'=>false)); ?>
        </li>
        <li class="search-item">
            <?php echo CHtml::textField('value',$value,array('class'=>'u-ipt mod-input')); ?>
            <!-- <input type="text" class="u-ipt mod-input" placeholder="关键词查找"/> -->
        </li>
        <li class="search-item">
            <?= CHtml::dropDownList('time_type', $time_type, ['created' => '添加时间', 'refresh_time' => '刷新时间', 'sale_time' => '上架时间'], ['class' => 'j-select', 'encode' => false]) ?>
            <!-- <select class="j-select"><option value="0">添加时间</option><option value="1">下拉式菜单项</option><option value="2">下拉式菜单项</option><option value="3">下拉式菜单项</option></select> -->
        </li>
        <li class="search-item">
            <span class="time-range">
                <input name="start_time" type="text" value="<?=$start_time?>" id="startDate" placeholder="开始时间" class="u-ipt u-ipt-form u-ipt-time  j-my97" onFocus="WdatePicker({readOnly:true,maxDate:'#F{$dp.$D(\'endDate\')}'})"/> 至 <input name="end_time" placeholder="结束时间" type="text" value="<?=$end_time?>" id="endDate" class="u-ipt u-ipt-form u-ipt-time j-my97" onFocus="WdatePicker({readOnly:true,minDate:'#F{$dp.$D(\'startDate\')}'})"/>
            </span>
        </li>
        <li class="search-item">
            <?php echo CHtml::dropDownList('hid',$hid,$plots,array('class'=>'j-select','encode'=>false,'prompt'=>'--选择小区--')); ?>
        </li>
        <li class="search-item">
            <?php echo CHtml::dropDownList('category',$category,Yii::app()->params['category'],array('class'=>'j-select','encode'=>false,'prompt'=>'--选择类别--')); ?>
        </li>
        <li class="search-item">
            <button type="submit" class="u-btn u-btn-m1">搜索</button>
        </li>
        <li class="search-item">
            <button type="button" onclick="removeOptions()" class="u-btn u-btn-m2">清空</button>
        </li>
        <li class="search-item" style="float:right;margin-right:10px;">
            <select name="sort" class="j-select">
            <?php if(in_array($sort, array_keys($sortArray))):?>
                <option selected="selected" value="0"><?=CHtml::link($sortArray[$sort],Yii::app()->controller->createUrl($action,array_merge($_GET,['sort'=>$sort])))?></option>
                <?php foreach ($sortArray as $key => $v) { if($key!=$sort):?>
                    <option value="<?=$key?>"><?=$v?></option>
                <?php endif;}?>
                <option value="0">----选择排序----</option>
            <?php else:?>
                <option selected="selected" value="0">----选择排序----</option>
                <?php foreach ($sortArray as $key => $v) { if($key!=$sort):?>
                    <option value="<?=$key?>"><?=$v?></option>
                <?php endif;}?>
            <?php endif;?>
            </select>
        </li>
    </ul>
    <div class="blank20"></div>
</div>
</form>