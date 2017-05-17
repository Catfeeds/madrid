
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
<script type="text/template" id="upload-tpl">
        {{each list as v k}}
        <li class="img-ele {{if k == current}}on{{/if}}" data-index="{{k}}" style="width:{{w}}px;">
            <div class="pic" style="height:{{h}}px;width:{{w-2}}px">
                <span class="cover"></span>
                <a href="javascript:void(0)" class="close"></a>
                <p>
                    <img src="{{v.pic}}?imageView2/2/w/120/h/90/interlace/1" alt="" class="hidden"/>
                    <img src="{{v.pic}}?imageView2/2/w/120/h/90/interlace/1" alt="" />
                </p>
            </div>
            <div class="describe"><input type="text" class="text" placeholder="描述" value="{{v.text}}"/></div>
        </li>
        {{/each}}
    </script>
<script type="text/template" id="upload2-tpl">
    {{each list as v k}}
    <li class="img-ele {{if k == current}}on{{/if}}" data-index="{{k}}">
        <div class="pic" style="width:{{w}}px;height:{{h}}px;">
            <a href="javascript:void(0)" class="close"></a>
            <p>
            <img src="{{v.pic}}?imageView2/2/w/{{w}}/h/{{h}}/interlace/1" alt="" class="hidden"/>
            <img src="{{v.pic}}?imageView2/2/w/{{w}}/h/{{h}}/interlace/1" alt="" />
            </p>
        </div>
    </li>
    {{/each}}
</script>
<script type="text/template" id="modselect-tpl">
    <span class="u-btns">
        <span class="u-btn u-btn-c4 select-name">{{now.name}}</span>
        <span type="button" class="u-btn u-btn-c4 select-arrow"><span class="btnsel"></span></span>
        <ul class="u-menu u-menu-min">
            {{each datalist as v k}}
                <li><a href="#" data-value="{{v.value}}">{{v.name}}</a></li>
            {{/each}}
        </ul>
    </span>
</script>

<script type="text/javascript">
<?php Tools::startJs() ?>
    var info_id = 0;
    <?php if($model->id):?>
        info_id = '<?=$model->id?>';
    <?php endif;?>
    var model_name = '<?=$modelName?>';

<?php Tools::endJs('js') ?>
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