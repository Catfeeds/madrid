<?php
$this->pageTitle = '学区房新建/编辑';
$this->breadcrumbs = array('学区房管理' => $_GET['referrer'], '添加学校');
?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label">学校名称</label>
    <div class="col-md-6">
        <?php echo $form->textField($school, 'name', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'name'); ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">拼音</label>
    <div class="col-md-6">
        <?php echo $form->textField($school, 'pinyin', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'pinyin'); ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">类型</label>
    <div class="radio-list col-md-6">
        <?php echo $form->radioButtonList($school, 'type', SchoolExt::$type, array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;')) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'type'); ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">重点</label>
    <div class="radio-list col-md-6">
        <?php echo $form->radioButtonList($school, 'important', SchoolExt::$important, array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;')) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'important'); ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label text-nowrap">所在区域</label>
    <div class="col-md-6">
        <?php echo $form->dropDownList($school, 'area', $area, array('empty' => '请选择区域','class'=>'form-control')); ?>
    </div>
    <div class="col-md-12"><?php echo $form->error($school, 'area'); ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">学校地址</label>
    <div class="col-md-6">
        <?php echo $form->textField($school, 'address', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'address'); ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label text-nowrap">地图坐标</label>
    <div class="col-md-10">
        <button type="button" class="btn green-meadow show-map" data-toggle="modal" href="#large">地图标识</button>
        <span id="coordText" style="padding-left:10px;">
            <?php if ($school->map_lng || $school->map_lat): ?>
                经度：<?php echo $school->map_lng != 0 ? $school->map_lng : $maps['lng']; ?> &nbsp;
                纬度：<?php echo $school->map_lat != 0 ? $school->map_lat : $maps['lat'];?>
            <?php endif; ?>
        </span>
    </div>
    <div class="col-md-12"><?php echo $form->error($school, 'map_lng'); ?><?php echo $form->error($school, 'map_lat'); ?></div>
</div>

<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">标识地图</h4>
            </div>
            <div class="modal-body">
                <p>
                    经度：<input id="lng" readonly_="readonly" size="20" name="SchoolExt[map_lng]" type="text" value="<?php echo $school->map_lng !=0 ? $school->map_lng : $maps['lng']; ?>">
                    纬度：<input id="lat" readonly_="readonly" size="20" name="SchoolExt[map_lat]" type="text" value="<?php echo $school->map_lat !=0 ? $school->map_lat : $maps['lat']; ?>">
                    缩放：<input type="text" name="SchoolExt[map_zoom]" id="zoom" readonly="readonly" size="2" value="<?php echo $school->map_zoom!=0 ? $school->map_zoom : $maps['zoom']; ?>"/>
                    搜索：<input type="text" name="local" id="local" value="" size="15" onkeypress="return false;">
                    <input type="button" onclick="getLatLng($('#local').val());" value="搜索" class="cancel">
                </p>
                <div id="map" style="height:400px; width:100%"></div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="changeCoordText()" class="btn blue" data-dismiss="modal">保存</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="form-group">
    <label class="col-md-2 control-label">联系方式</label>
    <div class="col-md-6">
        <?php echo $form->textField($school, 'phone', array('class' => 'form-control input-small')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'phone'); ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">学校简介</label>
    <div class="col-md-6">
        <?php echo $form->TextArea($school, 'description', array('class' => 'form-control', 'rows' => 3)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'description'); ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">学区范围</label>
    <div class="col-md-6">
        <?php echo $form->TextArea($school, 'scope', array('class' => 'form-control', 'rows' => 3)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'scope'); ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">图片</label>
    <div class="col-md-5">
        <?php $this->widget('FileUpload',array('multi'=>true,'inputName'=>'image', 'width'=>100,'height'=>100,'mode'=>2,'callback'=>'function(data){uploaded(data)}')); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-6">
        <div id="uploader" class="wu-example">
            <div id="fileList" class="uploader-list" data-name-val="SchoolExt[pic][]">
                <?php if(isset($school->pic) && !empty($school->pic)){ ?>
                    <?php foreach($school->pic as $v){ ?>
                        <div class="col-md-3 text-center">
                            <a href=<?php echo ImageTools::fixImage($v) ?> target="_blank" class="thumbnail" style="margin-bottom:5px">
                                <img src=<?php echo ImageTools::fixImage($v) ?>>
                            </a>
                            <a href="javascript:;" class="btn btn-sm  rmfile" data-id="0">删除</a>
                            <a href="javascript:;" class="btn btn-sm setimg" <?php if($school->image == $v) echo "style='color:red'";?> data-url=<?php echo $v?>>设为封面</a>
                            <input value=<?php echo $v?> name="SchoolExt[pic][]" id="SchoolExt_pic" type="hidden">
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<input id='image' name='SchoolExt[image]' type='hidden'/>

<div class="form-group">
    <label class="col-md-2 control-label">状态</label>
    <div class="radio-list col-md-6">
        <?php echo $form->radioButtonList($school, 'status', SchoolExt::$status, array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;')) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($school, 'status'); ?></div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回', Yii::app()->user->returnUrl, array('class' => 'btn default')) ?>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bmap.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/map.js', CClientScript::POS_END);
?>

<?php $this->endWidget(); ?>

<script>
    <?php Tools::startJs();?>
        function uploaded(data){
            var url = data.msg.url;
            var html = '<div class="col-md-3 text-center"><a href="'+url+'" target="_blank" class="thumbnail" style="margin-bottom:5px"><img src="'+url+'"></a><a href="javascript:;" class="btn btn-sm  rmfile" data-id="0">删除</a> <a href="javascript:;" class="btn btn-sm setimg" data-url="'+data.msg.pic+'">设为封面</a><?php echo $form->hiddenField($school, 'pic[]',array('value'=>"'+data.msg.pic+'",'encode'=>false)); ?></div>';
           $('#fileList').append(html);
        }

            //移除图片
        $(".rmfile").live("click",function(){
            $(this).parent().remove();
        });

            //设为封面
        $(".setimg").live("click",function(){
            $(".setimg").attr('style','');
            $("#image").val($(this).data('url'));
            $(this).css('color','red');
        });

    <?php Tools::endJs('js');?>
</script>
