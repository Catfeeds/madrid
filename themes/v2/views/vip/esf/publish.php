<?php
$this->pageTitle = '编辑二手房房源';
$this->breadcrumbs = array($this->pageTitle);
?>
<?php $this->widget('ext.ueditor.UeditorWidget',array('id'=>'content','options'=>"toolbars:[['fullscreen','source','undo','redo','|','customstyle','paragraph','fontfamily','fontsize'],
        ['bold','italic','underline','fontborder','strikethrough','superscript','subscript','removeformat',
        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain','|',
        'forecolor','backcolor','insertorderedlist','insertunorderedlist','|',
        'rowspacingtop','rowspacingbottom', 'lineheight','|',
        'directionalityltr','directionalityrtl','indent','|'],
        ['justifyleft','justifycenter','justifyright','justifyjustify','|','link','unlink','|',
        'map',
        'insertcode','|',
        'horizontal','inserttable','|',
        'print','preview','searchreplace']]")); ?>
<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal','onsubmit'=>'return checkForm();'),'enableAjaxValidation'=>false)) ?>
<style type="text/css">
    .right-text{
        text-align: left !important;padding-left: 0;
    }
    .xqtp{
            border: rgba(160, 160, 160, 0.58);
            border-width: thin;
            /* width: 596px; */
            border-style: groove;
            height: 300px;
            overflow-y: scroll;
    }
</style>
<div class="tabbale">
    <div class="tab-content col-md-12" style="padding-top:20px;">
    <!-- 基本信息 -->
    <!-- <div class="tab-pane col-md-12 active" id="tab_1"> -->
        <!-- 基本信息左侧 -->
        <?php 
            $zzppt = TagExt::model()->getTagByCate('esfzzpt')->normal()->findAll(['order'=>'sort asc']);
            $spppt = TagExt::model()->getTagByCate('esfsppt')->normal()->findAll(['order'=>'sort asc']);
            $xzlppt = TagExt::model()->getTagByCate('esfxzlpt')->normal()->findAll(['order'=>'sort asc']);
            $spkjyxm = TagExt::model()->getTagByCate('esfspkjyxm')->normal()->findAll(['order'=>'sort asc']);
            $esfsplevel = TagExt::model()->getTagByCate('esfsplevel')->normal()->findAll(['order'=>'sort asc']);
            $zfxzllevel = TagExt::model()->getTagByCate('zfxzllevel')->normal()->findAll(['order'=>'sort asc']);
        ?>
        <div class="col-md-10">
        <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>联系人姓名</label>
                <div class="col-md-8">
                    <?php $sourceArr = Yii::app()->params['source']; echo $form->textField($esf,'username',array('class'=>'form-control','data-target'=>'pointname','readonly'=>$esf->id && $sourceArr[$esf->source] != '后台'?'readonly':'')); ?>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>联系电话</label>
                <div class="col-md-8">
                   <?php echo $form->textField($esf,'phone',array('class'=>'form-control','data-target'=>'pointname','readonly'=>$esf->id && $sourceArr[$esf->source] != '后台'?'readonly':'')); ?>
                   <?php echo $form->textField($esf,'source',array('class'=>'form-control hide','value'=>$esf->source?$esf->source:3)); ?>
                </div>
                <div class="col-md-2"></div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房源类型</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($esf, 'category', Yii::app()->params['category'], array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房源子类型</label>
                <div class="col-md-10 zz esf_type" style="display: none">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'tagsArr[0]',  CHtml::listData(TagExt::model()->getTagByCate('esfzfzztype')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"></span>
                </div>
                <div class="col-md-10 sp esf_type" style="display: none">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'tagsArr[1]',  CHtml::listData(TagExt::model()->getTagByCate('esfzfsptype')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"></span>
                </div>
                <div class="col-md-10 xzl esf_type" style="display: none">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'tagsArr[2]',  CHtml::listData(TagExt::model()->getTagByCate('esfzfxzltype')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"></span>
                </div>
            </div>
            
            <div class="form-group sp esf_type"  style="display: none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>商铺可经营性项目</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->checkBoxList($esf, 'esfspkjyxm', CHtml::listData(TagExt::model()->getTagByCate('esfspkjyxm')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group sp esf_type"  style="display: none">
                <label class="col-md-2 control-label text-nowrap">商铺级别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'tagsArr[14]',  CHtml::listData(TagExt::model()->getTagByCate('esfsplevel')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group  xzl esf_type"  style="display: none">
                <label class="col-md-2 control-label text-nowrap">写字楼级别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'tagsArr[15]',  CHtml::listData(TagExt::model()->getTagByCate('zfxzllevel')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"></span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>楼盘名称</label>
                <div class="col-md-8">
                    <?php echo $form->autocomplete($esf, 'hid', array('class'=>'form-control','data-init-text'=>$esf->hid ? $esf->plot_name : '','url'=>$this->createUrl('/vip/common/ajaxGetHouse',['isNew'=>0]))); ?>
                    <span class="help-block">若没有匹配的小区，建议选择“其他小区”</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">小区地址</label>
                <div class="col-md-8">
                    <?php echo $form->textField($esf,'address',array('class'=>'form-control','data-target'=>'pointname')); ?>
                    <span class="help-block"></span>
                </div>
                <div class="col-md-12"></div>
            </div>
            <div class="form-group">
                
                <label class="col-md-2 control-label text-nowrap"><span  style="color: red">*&nbsp;</span>所在楼层</label>
                <div class="col-md-8">
                <div class="col-md-2" style="padding-left: 0">
                    <?php echo $form->textField($esf,'floor',array('class'=>'form-control','value'=>$esf->floor?$esf->floor:'')); ?>
                    <span class="help-block"></span>
                </div>
                <label class="col-md-1 control-label text-nowrap"><?php if($esf->category!=2):?><span style="color: red">*&nbsp;</span><?php endif;?>总楼层</label>
                <div class="col-md-2">
                    <?php echo $form->textField($esf,'total_floor',array('class'=>'form-control','value'=>$esf->total_floor?$esf->total_floor:'')); ?>
                    <span class="help-block"></span>
                </div>
               <!-- <label class="col-md-1 control-label text-nowrap">显示</label>
                <div class="col-md-3">
                    <?php echo $form->dropDownList($esf,'tagsArr[11]',CHtml::listData(TagExt::model()->getTagByCate('esffloorcate')->normal()->findAll(['order'=>'sort asc']),'id','name'),array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'具体楼层',)); ?>
                </div> -->
                </div>
                </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>面积</label>
                <div class="col-md-4">
                    <?php echo $form->textField($esf,'size',array('class'=>'form-control','value'=>(int)$esf->size?$esf->size:'')); ?>
                    <span class="help-block"></span>
                </div>
                <label class="col-md-1 control-label text-nowrap right-text">平方米</label>
                <div class="col-md-12"></div>
            </div>
           <div class="form-group zzpt peizhi"  style="display: none">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房型</label>
                <div class="col-md-10">
                    <?php echo $form->textField($esf, 'bedroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    室
                    <?php echo $form->textField($esf, 'livingroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    厅
                    <?php echo $form->textField($esf, 'bathroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    卫
                    <?php echo $form->textField($esf, 'cookroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    厨 
                    <span
                        class="help-block">
            </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>售价</label>
                <div class="col-md-3">
                    <?php echo $form->textField($esf,'price',array('class'=>'form-control','value'=>(int)$esf->price?$esf->price:0)); ?>
                    <span class="help-block">若售价为“0”则价格为“面议”</span>
                    <span class="help-block"></span>
                </div>
                <label class="col-md-1 control-label right-text">万元 </label>
            </div>
               <div class="form-group wyf" style="display: none">
                <label class="col-md-2 control-label text-nowrap">物业费</label>
                <div class="col-md-3">
                    <?php echo $form->textField($esf,'wuye_fee',array('class'=>'form-control')); ?>
                    <span class="help-block"></span>
                </div>
                <label class="col-md-1 control-label right-text">元/平方·月 </label>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">建造年代</label>
                <div class="col-md-2">
                    <?php echo $form->dropDownList($esf,'age', array_combine(range((int)date('Y'), (int)date('Y')-25),range((int)date('Y'), (int)date('Y')-25)),array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>
                    <span class="help-block"></span>
                </div>
                <label class="col-md-1 control-label right-text">年 </label>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">装修情况</label>
                <div class="col-md-8">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'decoration',  CHtml::listData(TagExt::model()->getTagByCate('resoldzx')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">朝向</label>
                <div class="col-md-8">
                    <div class="radio-list">
                    <?php echo $form->radioButtonList($esf, 'towards',  CHtml::listData(TagExt::model()->getTagByCate('resoldface')->normal()->findAll(['order'=>'sort asc']),'id','name'), array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">配置</label>
                
                <div class="col-md-10 zzpt peizhi" style="display: none">
                    <?php foreach ($zzppt as $key => $value) {?>
                       <input type="checkbox" name="tagsArr[4][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-10 sppt peizhi" style="display: none">
                <?php foreach ($spppt as $key => $value) {?>
                       <input type="checkbox" name="tagsArr[5][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-10 xzlpt peizhi" style="display: none">
                <?php foreach ($xzlppt as $key => $value) {?>
                       <input type="checkbox" name="tagsArr[6][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-12"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">特色</label>
                <?php 
                    $zzpts = TagExt::model()->getTagByCate('esfzzts')->normal()->findAll(['order'=>'sort asc']);
                    $sppts = TagExt::model()->getTagByCate('esfspts')->normal()->findAll(['order'=>'sort asc']);
                    $xzlpts = TagExt::model()->getTagByCate('esfxzlts')->normal()->findAll(['order'=>'sort asc']);
                ?>
                <div class="col-md-10 zzts tese" style="display: none;">
                    <?php foreach ($zzpts as $key => $value) {?>
                       <input onclick="limitTs(this)" type="checkbox" name="tagsArr[7][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-10 spts tese" style="display: none;">
                <?php foreach ($sppts as $key => $value) {?>
                       <input onclick="limitTs(this)" type="checkbox" name="tagsArr[8][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-10 xzlts tese" style="display: none;">
                <?php foreach ($xzlpts as $key => $value) {?>
                       <input onclick="limitTs(this)" type="checkbox" name="tagsArr[9][]" value="<?=$value->id?>"><?=$value->name?></input>
                    <?php }?>
                </div>
                <div class="col-md-12"></div>
            </div>         
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房源标题</label>
                <div class="col-md-8">
                    <?php echo $form->textField($esf,'id',array('class'=>'form-control','style'=>'display:none')); ?>
                    <?php echo $form->textField($esf,'title',array('class'=>'form-control','data-target'=>'pointname')); ?>
                    <span class="help-block"></span>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">房源描述</label>
                <div class="col-md-10">
                    <?php echo $form->textArea($esf,'content',array('id'=>'content')); ?>
                    <span class="help-block"></span>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">下架时间</label>
                <div class="col-md-6">
                    <div class="input-group date form_datetime">
                        <?php //echo $form->textField($esf,'expire_time',array('class'=>'form-control','value'=>($esf->expire_time?date('Y-m-d',$esf->expire_time):date('Y-m-d',time()+30*86400)))); ?>
                        <span class="input-group-btn">
                          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                       </span>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="help-inline"> </span>
                </div>
                <div class="col-md-12"></div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label">添加图片</label>
                <div class="col-md-8">
                    <?php $this->widget('FileUpload',array('inputName'=>'img','multi'=>true,'waterMark'=>true,'callback'=>'function(data){callback(data);}')); ?>
                </div>
            </div>
            <div class="form-group images-place" style="margin-left: 220px">
                <?php if($esf->images) foreach ($esf->images as $key => $value) {?>
                    <div class='image-div' style='width: 150px;display:inline-table;height:180px'><a href='javascript::void(0)' class='btn <?=$value['url']==$esf['image']?'isfm':''?> green btn-xs fm-btn' style='position: absolute;display: <?=$value['url']==$esf['image']?'block':'none'?>'>已设置封面</a><a onclick='del_img(this)' class='btn red btn-xs' style='position: absolute;margin-left: 94px;'><i class='fa fa-trash'></i></a><img src='<?=ImageTools::fixImage($value->url)?>' style='width: 120px;height: 90px'><input name='image_des[]' value="<?=$value->name?>"  type='text' style='width: 80px'></input><a class='btn btn-xs green' onclick='setFm(this)' style='width: 40px;'>封面</a><input type='hidden' class='trans_img' name='images[]' value='<?=$value->url?>'></input><input type='hidden' class='fm'></input></div>
                <?php }?>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">选择小区图片</label>
                <input type="hidden" value="<?=$this->createUrl('/vip/common/AjaxGetImgs')?>" id="getImgs"></input>
                <div class="col-md-10 xqtp">
                </div>
            </div>
            
            <div class="col-md-12 center-block text-center">
                <div class="btn-group text-center">
                    <button class="btn green-meadow col-md-offset-4">提交</button>
                    <?php echo CHtml::link('返回', Yii::app()->createUrl('vip/esf/saleup'), array('class' => 'btn default')) ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); 
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/esf-add-images.js', CClientScript::POS_END);

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
<!-- 通过js初始化已选checkbox的状态 -->

<script type="text/javascript">
    <?php Tools::startJs(); ?>
    var arr = [];
    <?php if($data_conf = json_decode($esf->data_conf,true)); if(isset($data_conf['tags'])&&$data_conf['tags']) foreach($data_conf['tags'] as $value){?>
        arr = $("input[value='<?=$value?>']");
        $(arr).attr('checked','checked');
        arr1 = $("option[value='<?=$value?>']");
        $(arr1).attr('selected','selected');
    <?php } ?>
    <?php if(!$esf->category):?>
        arr = $('#ResoldEsfExt_category').find("input[value='1']");
        $(arr).attr('checked','checked');
    <?php endif;?>    
    function limitTs(obj)
    {
        var num = $(obj).closest('.form-group').find(':checked').length;
        if(num > 5){
            alert('特色最多选择五项');
            $(obj).prop('checked',false);
        }
    }
     
<?php Tools::endJs('js'); ?>
</script>