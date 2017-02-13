<?php
$this->pageTitle = SiteExt::$cateName[$cate];
$this->breadcrumbs = array('站点配置', $this->pageTitle);
?>
<?php $this->widget('ext.ueditor.UeditorWidget',array('id'=>'ArticleExt_content','options'=>"toolbars:[['fullscreen','source','undo','redo','|','customstyle','paragraph','fontfamily','fontsize'],
        ['bold','italic','underline','fontborder','strikethrough','superscript','subscript','removeformat',
        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain','|',
        'forecolor','backcolor','insertorderedlist','insertunorderedlist','|',
        'rowspacingtop','rowspacingbottom', 'lineheight','|',
        'directionalityltr','directionalityrtl','indent','|'],
        ['justifyleft','justifycenter','justifyright','justifyjustify','|','link','unlink','|',
        'insertimage','emotion','scrawl','insertvideo','music','attachment','map',
        'insertcode','|',
        'horizontal','inserttable','|',
        'print','preview','searchreplace']]")); ?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<?php foreach (SiteExt::$cateTag[$cate] as $key => $value) {?>
    <div class="form-group">
        <label class="col-md-2 control-label text-nowrap"><?=$value['name']?></label>
        <div class="col-md-8">
        <?php if($value['type'] == 'image'):?>
            <?php $this->widget('FileUpload',array('model'=>$model,'attribute'=>$key,'inputName'=>'img','width'=>400,'height'=>300)); ?>
        <?php elseif($value['type'] == 'multiImage'):?>
                    <?php $this->widget('FileUpload',array('inputName'=>'img','multi'=>true,'callback'=>'function(data){callback(data);}')); ?>
                    <div id="lbt" style="isplay: inline-flex;height: 200px"></div>
        <?php endif;?>
        </div>
    </div>
<?php } ?>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('list'), array('class' => 'btn default')) ?>
        </div>
    </div>
</div>

<?php $this->endWidget() ?>
<script type="text/javascript">
    <?php Tools::startJs()?>
    function callback(data) {
        var pic = data.msg.pic;
        $('#lbt').append('<img src="'+data.msg.url+'" width="200px" height="150px">');
        $('form').append('<input type="hidden" name="SiteExt[pcIndexImages][] value="'+pic+'">');
    }
    <?php Tools::endJs('js')?>
</script>
