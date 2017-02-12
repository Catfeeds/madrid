<?php
$this->pageTitle = '调查反馈';
$this->registerHeadJs(['jquery.min','validform.min','cal']);
?>
<link rel="stylesheet" href="<?=Yii::app()->theme->baseUrl.'/static/wap/style/calculator.css'?>" media="screen" title="no title" charset="utf-8">
<!-- <header class="title-bar title-bar-hasbg">
        <a href="javascript:void(0)" class="back iconfont" onclick="$('.calc-main').show();$('.calc-result').hide();$('body').removeClass('result-show')">&#x2568;</a>
         <h1>计算结果</h1>
        <div class="operate"></div>
    </header> -->
    <form onsubmit="return checkInfo()">
<div class="ui-form bg-fff">
    <ul class="ui-list ui-list-arrows mt20 bb0 ">
        <li class="ui-list-item no-arrows total-calc">
            <div class="ui-form-field">选择区域</div>
            <div class="ui-form-controls"><?=CHtml::dropDownList('area','',$areaList,['style'=>'width:100%;height:60%;font-size:14px;border:0;border:none;','prompt'=>'请选择区域'])?></div>
            <!-- <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div> -->
        </li>
        <li class="ui-list-item no-arrows total-calc">
            <div class="ui-form-field">选择商区</div>
            <div class="ui-form-controls"><?=CHtml::dropDownList('place','',$placeList,['style'=>'width:100%;height:60%;font-size:14px;border:0;border:none;','prompt'=>'请选择商区'])?></div>
            <!-- <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div> -->
        </li>
        <li class="ui-list-item no-arrows total-calc" style="height: 200px">
            <div class="ui-form-field">您的留言</div>
            <div class="ui-form-controls"><?=CHtml::textarea('msg','',['style'=>'width:100%;height:200px'])?></div>
        </li>
        <li class="ui-list-item no-arrows total-calc">
            <div class="ui-form-field">联系方式</div>
            <div class="ui-form-controls"><input type="text" name="phone" style="width:100%;height:60%;font-size:14px;border:0;border:none;" placeholder="建议填写，后台会随机抽取小礼品赠送"></input></div>
            <!-- <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div> -->
        </li>
        <li class="ui-list-item no-arrows total-calc">
            <button style="width: 50px;height: 30px;border: 0;color: white;background-color: #00BCD4" type="submit" value="提交">提交</button>
            &nbsp;
            <button style="width: 50px;height: 30px;border: 0" type="button" value="提交" onclick="empty()">清空</button>
        </li>
    </ul>
        
</div></form>
<script type="text/javascript">
    function checkInfo() {
        if($('#area').val()=='') {
            alert('区域不能为空');
            return false;
        } else if($('#place').val()=='') {
            alert('商区不能为空');
            return false;
        } else if($('#msg').val()=='') {
            alert('留言不能为空');
            return false;
        } 
        alert('您已提交成功，谢谢您的参与！');
    }
    function empty() {
        $('#area').val('');
        $('#place').val('');
        $('#msg').val('');
    }
</script>