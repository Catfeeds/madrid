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
                    <div class="form-group images-place" style="margin-left: 220px">
                  <?php if($model->pcIndexImages) foreach ($model->pcIndexImages as $key => $v) {?>
                      <div class='image-div' style='width: 150px;display:inline-table;height:180px'><a onclick='del_img(this)' class='btn red btn-xs' style='position: absolute;'><i class='fa fa-trash'></i></a><img src='<?=ImageTools::fixImage($v)?>' style='width: 150px;height: 120px'><input type='hidden' class='trans_img' name='SiteExt[pcIndexImages][]' value='<?=$v?>'></input></div>
                  <?php }?>
                </div>
        <?php elseif($value['type'] == 'text'):?>
            <?php echo $form->textField($model, $key, array('class' => 'form-control')); ?>

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
    function callback(data){
        if($('.image-div').length >= 4) {
            alert('最多选择4张图片');
        } else {
            // 指定区域出现图片
            var html = "";
            image_html = "<div class='image-div' style='width: 150px;display:inline-table;height:180px'><a onclick='del_img(this)' class='btn red btn-xs' style='position: absolute;margin-left: 94px;'><i class='fa fa-trash'></i></a><img src='"+data.msg.url+"' style='width: 150px;height: 120px'><input type='hidden' class='trans_img' name='SiteExt[pcIndexImages][]' value='"+data.msg.pic+"'></input></div>";
            $('.images-place').append(image_html);
        }
    }
    //删除图片
    function del_img(obj)
    {
        //将已选择的图片重设为可以选择
        img = $(obj).parent().find('img').attr('src');
        $('.xqtp').find('img[src="'+img+'"]').parent().find('.ch_img').html('<a onclick="ch_img(this)" >点击选择</a>');
        $(obj).parent().remove();

    }
    <?php Tools::endJs('js')?>
</script>
