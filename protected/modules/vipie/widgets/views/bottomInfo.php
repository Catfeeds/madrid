<div class="formitm">
    <label class="lab"><span class="re"></span> 建造年代</label>
    <div class="ipt">
        <?php echo CHtml::dropDownList($modelName.'[age]', $model->age,array_combine(range((int)date('Y'), (int)date('Y')-25),range((int)date('Y'), (int)date('Y')-25)),array('empty'=>array(0=>'--请选择--'),'class'=>'j-select','data-class'=>'large min-height','size'=>'25')); ?>
        <!-- <select class="j-select" data-class="large"><option value="0">2016</option><option value="1">下拉式菜单项</option><option value="2">下拉式菜单项</option><option value="3">下拉式菜单项</option></select> -->
    </div>
</div>
<div class="formitm">
    <label class="lab"><span class="re"></span> 朝向/装修</label>
    <!--这里解决select压线问题-->
    <div class="ipt" style="position:relative;z-index:2;">
        <?php echo CHtml::dropDownList($modelName.'[towards]', $model->towards,CHtml::listData(TagExt::model()->getTagByCate('resoldface')->normal()->findAll(),'id','name'),array('empty'=>array(0=>'--请选择--'),'class'=>'j-select','data-class'=>'large')); ?>
        <?php echo CHtml::dropDownList($modelName.'[decoration]', $model->decoration,CHtml::listData(TagExt::model()->getTagByCate('resoldzx')->normal()->findAll(),'id','name'),array('empty'=>array(0=>'--请选择--'),'class'=>'j-select','data-class'=>'large')); ?>
    </div>
</div>
<div class="formitm pt10">
    <label class="lab"><span class="re"></span> 配套设施</label>
    <div class="ipt">
        <ul class="checkbox-list f-cb">
            <?php if($ptArr) foreach ($ptArr as $key => $value) {?>
                <li><label><input type="checkbox" <?=in_array($key, $pt)?'checked':''?> name="tagsArr[1][]" value="<?=$key?>"/><?=$value?></label></li>
            <?php }?>
        </ul>
        <span class="errmsg">最多选择5个</span>
    </div>
</div>
<div class="formitm pt0">
    <label class="lab"><span class="re"></span> 房屋特色</label>
    <div class="ipt">
        <ul class="checkbox-list f-cb">
            <?php if($tsArr) foreach ($tsArr as $key => $value) {?>
                <li><label><input type="checkbox" <?=in_array($key, $ts)?'checked':''?> name="tagsArr[2][]" value="<?=$key?>"/><?=$value?></label></li>
            <?php }?>
        </ul>
        <span class="errmsg">最多选择5个</span>
    </div>
</div>
<div class="blank20"></div>
</div>
</div>
<div class="fangyuan-detail">
<div class="blank20"></div>
<h2 class="u-tt u-tt-md">房源详情（<span class="re">*</span>为必填）</h2>
<div class="formitm">
<label class="lab"><span class="re">*</span> 房源标题</label>
<div class="ipt limit-num j-limit-num">
    <input type="text" class="u-ipt u-ipt-form" name="<?=$modelName.'[title]'?>" style="width:750px" value="<?=$model->title?>"/>
</div>
</div>
<div class="formitm">
<label class="lab"><span class="re">*</span> 房源描述</label>
<div class="ipt">
    <?php echo CHtml::textArea($modelName.'[content]',$model->content,array('id'=>'container','class'=>'j-ueditor')); ?>
    <!-- <script id="container" value="" name="<?=$modelName.'[content]'?>" type="text/plain" class="j-ueditor"></script> -->
</div>
</div>

<div class="formitm">
<label class="lab"><span class="re">*</span> 图片上传</label>
<div class="img-upload j-upload-1">
    <div class="img-upload-file f-cb">
        <div class="file"></div>
        <div class="u-upload f-cb u-upload-btn1">
            <button type="button">浏览文件</button>
            <!--<input type="file"/>-->
        </div>
    </div>
    <div class="upload-list">
        <div class="upload-empty">
            <p>选择文件后，点击上传按钮，上传图片</p>
            <p><span class="note">上传真实的照片 有利于你的成交</span>，支持jpg、bmp、gif、png格式，每张最大2M</p>
            <!-- <a class="u-btn u-btn-3" id="j-test-upload">测试读取上传数据</a> -->
        </div>
        <div class="upload-img-list f-cb">
            <ul>
            </ul>
        </div>
    </div>
</div>
</div>
<div class="formitm">
<label class="lab"><span class="re"></span> 选择小区图片</label>
<div class="ipt">
    <div class="u-area-list">
        <ul class="u-area-list-inner f-cb">
        </ul>
        <script type="text/template" id="u-area-list-tpl">
            {{each pics as v k}}
            <li {{if v.status}} class="on" {{/if}} data-key="{{v.key}}">
                <div class="pic"><img src="{{v.pic}}" alt="" /></div>
                <a href="javascript:void(0)" class="link">{{if v.status}}已选择{{else}}点击选择{{/if}}</a>
            </li>
            {{/each}}
        </script>
    </div>
</div>
</div>
<div class="formitm-btn">
<!--通用自定义按钮-->
<input type="submit" id="sub-btn" value="确认发布" class="u-btn"/>
</div>
<script type="text/javascript">
    var origin_data = {'list':[]};
    var origin_hid = '';
    var model_name = '<?=$modelName?>'; 
    <?php
    $origin_list = ['list'=>[]];
    $pics = [];
    foreach ($model->images as $key => $value) {
        $origin_list['list'][] = ['key'=>$value->url,'pic'=>ImageTools::fixImage($value->url),'text'=>$value->name];
        $pics[] = $value->url;
    }
    if(in_array($model->image, $pics)) {
        $origin_list['current'] = array_search($model->image, $pics);
    }
    $originData = json_encode($origin_list);
    ?>
    <?php if($originData):?>
       var origin_data = <?=$originData?>;
    <?php endif;?>
    origin_hid = '<?=$model->hid?>';
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/vipie/js/validate.js',CClientScript::POS_END);
?>