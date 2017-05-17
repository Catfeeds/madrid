<?php
$this->pageTitle = '编辑商家信息';
$this->breadcrumbs = array($this->pageTitle);
?>
<style type="text/css">
    .right-text{
        text-align: right !important;padding-right: 0;width: 60px;
    }
    .shoppic{
        display: inline-table;height: 200px;width: 200px
    }
 </style>
<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'),'enableAjaxValidation'=>false)) ?>
<div class="tabbale">
    <div class="tab-content col-md-10" style="padding-top:20px;">
	    <div class="col-md-10">
	    <!-- 正片开始 -->
	    	<div class="form-group">
                <label class="col-md-2 control-label text-nowrap">商家名称</label>
                <div class="col-md-8">
                    <?php echo $form->textField($shop,'name',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'name') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">区域</label>
                <div class="col-md-3">
                     <?php echo $form->dropDownList($shop,'area', AreaExt::getAllarea(),array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>

                    <span class="help-block"><?php echo $form->error($shop, 'area'); ?></span>
                </div>
                <label class="col-md-2 right-text control-label text-nowrap">街道</label>
                 <div class="col-md-3">
                     <?php echo $form->dropDownList($shop,'street', [],array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>

                    <span class="help-block"><?php echo $form->error($shop, 'street'); ?></span>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'name') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">电话号码</label>
                <?php 
                $phoneArr = [];
                if(strpos(trim($shop->phone),' '))
                    $phoneArr = explode(' ', trim($shop->phone));
                else
                    $phoneArr = [$shop->phone];
                $phoneArr = array_values(array_filter($phoneArr)); 
                ?>
                <div class="col-md-2">
                    <input type="text" value="<?=isset($phoneArr[0])?$phoneArr[0]:''?>" name="phone_arr[]" class="phone_arr form-control"></input>
                </div>
                <div class="col-md-2">
                    <input type="text" value="<?=isset($phoneArr[1])?$phoneArr[1]:''?>" name="phone_arr[]" class="phone_arr form-control"></input>
                </div>
                <div class="col-md-2">
                    <input type="text" value="<?=isset($phoneArr[2])?$phoneArr[2]:''?>" name="phone_arr[]" class="phone_arr form-control"></input>
                </div>
                </div>
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">腾讯客服</label>
                <div class="col-md-3">
                    <?php echo $form->textField($shop,'qq',array('class'=>'form-control','data-target'=>'pointname')); ?>
                    <div class="col-md-2"><?php echo $form->error($shop, 'qq') ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">工作时间</label>
                <div class="col-md-3">
                    <?php echo $form->dropDownList($shop,'work_time', ResoldShopExt::$workTime,array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>
                </div>
                <label class="col-md-2 right-text control-label">工作日</label>
                <div class="col-md-3">
                    <?php echo $form->dropDownList($shop,'work_day', ResoldShopExt::$workDay,array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>
                 </div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">商家地址</label>
                <div class="col-md-8">
                    <?php echo $form->textField($shop,'address',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'address') ?></div>
            </div>
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">外链地址</label>
                <div class="col-md-8">
                    <?php echo $form->textField($shop,'link',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'link') ?></div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">商家LOGO</label>
                <div class="col-md-8">
                    <?php $this->widget('FileUpload',array('model'=>$shop,'attribute'=>'image','inputName'=>'img','width'=>400,'height'=>300)); ?>
                    <span class="help-block">建议尺寸：150*150</span>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'link') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">商家相册</label>
                <div class="col-md-8">
                    <?php $this->widget('FileUpload',array('multi'=>true,'inputName'=>'img','callback'=>'function(data){callback(data);}')); ?>
                    <span class="help-block">建议尺寸：420*420</span>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'link') ?></div>
                
            </div>
            <div class="form-group">
            <label class="col-md-2 control-label text-nowrap"></label>
                <div class="col-md-8">
                    <div class="album">
                        <?php if($shop->imgs) foreach ($shop->imgs as $key => $value) {?>
                        <div class="shoppic">
                            <img src="<?=ImageTools::fixImage($value->url)?>" style="width: 200px;height: 200px">
                            <a onclick="del_img(this)" class="btn red btn-xs" style="position: absolute;margin-left: -19px;">
                                 <i class="fa fa-trash"></i>
                            </a>
                            <input type="hidden" name="imgs[]" value="<?=$value->url?>"></input>
                       </div>
                       <?php  }?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">商家介绍</label>
                <div class="col-md-8">
                    <?php echo $form->textarea($shop,'description',array('class'=>'form-control','data-target'=>'pointname')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($shop, 'description') ?></div>
            </div>
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">地图坐标</label>
                <div class="col-md-8">
                    <button type="button" class="btn green-meadow show-map" data-toggle="modal" href="#large">地图标识</button>
                    <span id="coordText" style="padding-left:10px;">
                       <?php if($shop->map_lng || $shop->map_lat): ?>
                           经度：<?php echo $shop->map_lng!=0 ? $shop->map_lng : $maps['lng']; ?> &nbsp;
                           纬度：<?php echo $shop->map_lat!=0 ? $shop->map_lat : $maps['lat']; ?>
                       <?php endif;?>
                    </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($shop, 'map_lng'); ?><?php echo $form->error($shop, 'map_lat'); ?></div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label">商家状态</label>
                <div class="col-md-10">
                <div class="radio-list">
                    <?php echo $form->radioButtonList($shop, 'status',  Yii::app()->params['shopStatus'], array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    <span class="help-block"><?php echo $form->error($shop, 'status'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 center-block text-center">
                <div class="btn-group text-center">
                    <button class="btn green-meadow col-md-offset-4">提交</button>
                </div>
            </div>

        </div>
    </div>
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
                    经度：<input id="lng" readonly_="readonly" size="20" name="ResoldShopExt[map_lng]" type="text" value="<?php echo $shop->map_lng!=0 ? $shop->map_lng : $maps['lng']; ?>">                    纬度：<input id="lat" readonly_="readonly" size="20" name="ResoldShopExt[map_lat]" type="text" value="<?php echo $shop->map_lat!=0 ? $shop->map_lat : $maps['lat']; ?>">                    缩放：<input type="text" name="ResoldShopExt[map_zoom]" id="zoom" readonly="readonly" size="2" value="<?php echo $shop->map_zoom!=0 ? $shop->map_zoom : $maps['zoom']; ?>"/>
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
<?php $this->endWidget(); 
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/esf-add-images.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bmap.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/map.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

$js = "
            $(function(){
               $('.select2').select({
                  placeholder: '请选择',
                  allowClear: true
               });

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm-dd',
                     minView: 'month',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });

            });


            ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);
?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    $(document).ready(function(){
        $('#ResoldShopExt_area').val(<?=$shop->area?>);
        <?php foreach (AreaExt::getAllstreet() as $key => $value) {
            ?>
            if($('#ResoldShopExt_area').val()==<?=$key?>)
            {
                html = "";
                <?php foreach ($value as $key => $v) {?>
                   html += "<option value='<?=$key?>'><?=$v?></option>";
                <?php }?>
                $('#ResoldShopExt_street').append(html);
            }
        <?php }?>
        $('#ResoldShopExt_street').val(<?=$shop->street?>);
    });
    $('#ResoldShopExt_area').change(function(){
        $('#ResoldShopExt_street option').remove();
         <?php foreach (AreaExt::getAllstreet() as $key => $value) {
            ?>
            if($('#ResoldShopExt_area').val()==<?=$key?>)
            {
                html = "";
                <?php foreach ($value as $key => $v) {?>
                   html += "<option value='<?=$key?>'><?=$v?></option>";
                <?php }?>
                $('#ResoldShopExt_street').append(html);
            }
        <?php }?>
    });
    var arr = [];
    var i = 0;
    //标签初始化
    <?php if($data_conf = json_decode($shop->data_conf,true)) foreach($data_conf['tags'] as $value){?>
        arr = $("input[value='<?=$value?>']");
        $(arr).attr('checked','checked');
    <?php } ?>
    function callback(data) {
        var html = '';
        html = '<div class="shoppic"><img src="'+data.msg.url+'" style="width:200px;height:200px"><a onclick="del_img(this)" class="btn red btn-xs" style="position: absolute;margin-left: -19px;"><i class="fa fa-trash"></i></a><input type="hidden" name="imgs[]" value="'+data.msg.pic+'"></input><div></div></div>';
        $('.album').append(html);
    }

    function del_img(obj)
    {
        $(obj).parent().remove();
    }
    <?php Tools::endJs('js'); ?>
</script>