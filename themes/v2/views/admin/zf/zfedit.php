<?php
/**
 * User: fanqi
 * Date: 2016/8/10
 * Time: 11:44
 */
$this->pageTitle = '编辑租房房源';
$this->breadcrumbs = array($this->pageTitle);
?>
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
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'), 'enableAjaxValidation' => false)) ?>
<div class="tabbale">
    <div class="tab-content col-md-12" style="padding-top:20px;">
        <div class="col-md-10">
            <?php echo $form->hiddenField($zf, 'id'); ?>
                <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>联系人姓名</label>
                <div class="col-md-10">
                    <?php $sourceArr = Yii::app()->params['source']; echo $form->textField($zf, 'username', array('class' => 'form-control', 'data-target' => 'pointname','readonly'=>$zf->id && $sourceArr[$zf->source] != '后台'?'readonly':'')); ?>
                   <?php echo $form->textField($zf,'source',array('class'=>'form-control hide','value'=>$zf->source?$zf->source:3)); ?>

                    <div class="col-md-2"><?php echo $form->error($zf, 'username') ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>联系电话</label>
                <div class="col-md-8">
                    <?php echo $form->textField($zf, 'phone', array('class' => 'form-control', 'data-target' => 'pointname','readonly'=>$zf->id && $sourceArr[$zf->source] != '后台'?'readonly':'')); ?>
                    <div class="col-md-2"><?php echo $form->error($zf, 'phone') ?></div>
                
                </div>
                <div class="col-md-2"><a class="btn green check-phone" onclick="checkPhone()">检验号码</a></div>
            </div>
            <div class="form-group" id="category">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房源类型</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'category', Yii::app()->params['category'], array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($zf, 'category'); ?></span>

                </div>
            </div>
            <!-- <div class="form-group" id="esfzfzztype">
                <label class="col-md-2 control-label text-nowrap"> 租房住宅类别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'esfzfzztype', CHtml::listData(TagExt::model()->getTagByCate('esfzfzztype')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($zf, 'esfzfzztype'); ?></span>
                </div>
            </div> -->
            <div class="form-group" id="esfzfsptype">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>租房商铺类别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'esfzfsptype', CHtml::listData(TagExt::model()->getTagByCate('esfzfsptype')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($zf, 'esfzfsptype'); ?></span>
                </div>
            </div>
            <div class="form-group" id="zfspkjyxm">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>租房商铺可经营性项目</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->checkBoxList($zf, 'zfspkjyxm', CHtml::listData(TagExt::model()->getTagByCate('zfspkjyxm')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($zf, 'zfspkjyxm'); ?></span>
                </div>
            </div>
            <div class="form-group" id="esfzfxzltype">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>租房写字楼类别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'esfzfxzltype', CHtml::listData(TagExt::model()->getTagByCate('esfzfxzltype')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($zf, 'esfzfxzltype'); ?></span>
                </div>
            </div>
            <div class="form-group" id="esfsplevel">
                <label class="col-md-2 control-label text-nowrap">租房商铺级别</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'esfsplevel', CHtml::listData(TagExt::model()->getTagByCate('esfsplevel')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                    <span class="help-block"><?php echo $form->error($zf, 'esfsplevel'); ?></span>
                </div>
            </div>
            <div class="form-group" id="zfxzllevel">
                <label class="col-md-2 control-label text-nowrap">租房写字楼等级</label>
                <div class="col-md-2">
                    <?php echo $form->dropDownList($zf,'zfxzllevel', CHtml::listData(TagExt::model()->getTagByCate('zfxzllevel')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'),array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'zfxzllevel'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>楼盘名称</label>
                <div class="col-md-10">
                    <?php echo $form->autocomplete($zf, 'hid', array('class' => 'form-control', 'data-init-text' => $zf->hid ? $zf->plot->title : $zf->plot_name, 'url' => $this->createUrl('/admin/plot/ajaxGetHouse',['isNew'=>0]))); ?>
                    <div class="col-md-2"><?php echo $form->error($zf, 'hid') ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">小区地址</label>
                <div class="col-md-10">
                    <?php echo $form->textField($zf, 'address', array('class' => 'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>所在楼层</label>
                <div class="col-md-8">
                <div class="col-md-2" style="padding-left: 0">
                    <?php echo $form->textField($zf,'floor',array('class'=>'form-control','value'=>$zf->floor?$zf->floor:'')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'floor'); ?></span>
                </div>
                <label class="col-md-1 control-label text-nowrap"><span style="color: red">*&nbsp;</span>总楼层</label>
                <div class="col-md-2">
                    <?php echo $form->textField($zf,'total_floor',array('class'=>'form-control','value'=>$zf->total_floor?$zf->total_floor:'')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'total_floor'); ?></span>
                </div>
               <!-- <label class="col-md-1 control-label text-nowrap">显示</label>
                <div class="col-md-3">
                    <?php echo $form->dropDownList($zf,'esffloorcate',CHtml::listData(TagExt::model()->getTagByCate('esffloorcate')->normal()->findAll(['order'=>'sort asc']),'id','name'),array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'具体楼层',)); ?>
                </div> -->
                <!-- <div class="col-md-12"></div> -->
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>面积</label>
                <div class="col-md-10">
                    <?php echo $form->textField($zf, 'size', array('class' => 'form-control input-inline')); ?>
                    <span class="help-inline">m<sup>2</sup></span>
                    <span class="help-block"><?php echo $form->error($zf, 'size'); ?></span>
                </div>
            </div>
            <div class="form-group" id="zzfx">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>房型</label>
                <div class="col-md-10">
                    <?php echo $form->textField($zf, 'bedroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    室
                    <?php echo $form->textField($zf, 'livingroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    厅
                    <?php echo $form->textField($zf, 'bathroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    卫
                    <?php echo $form->textField($zf, 'cookroom', array('class' => 'form-control input-inline','style'=>'width:100px')); ?>
                    厨
                    <span
                        class="help-block">
            <?php echo $form->error($zf, 'bedroom') . $form->error($zf, 'livingroom') . $form->error($zf, 'bathroom') . $form->error($zf, 'cookroom'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>租金</label>
                <div class="col-md-10">
                    <?php echo $form->textField($zf, 'price', array('class' => 'form-control input-inline')); ?>
                    <span class="help-inline">元/月或 <input type="checkbox" class="checkbox-inline" id="mianyi"> 面议</span>
                    <span class="help-block"><?php echo $form->error($zf, 'price'); ?></span>
                </div>
            </div>
            <div class="form-group wuye_fee">
                <label class="col-md-2 control-label text-nowrap">物业费</label>
                <div class="col-md-10">
                    <?php echo $form->textField($zf, 'wuye_fee', array('class' => 'form-control input-inline')); ?>
                    <span class="help-inline">元/平方米·月
                    <span class="help-block"><?php echo $form->error($zf, 'wuye_fee'); ?></span>
                </div>
            </div>
            <div class="form-group" id="zzczfs">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>出租方式</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($zf, 'rent_type', CHtml::listData(TagExt::model()->getTagByCate('zfmode')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'form-control', 'prompt'=>'--请选择出租方式--')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'rent_type'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">交付方式</label>
                <div class="col-md-10">
                    <label class="control-label text-nowrap">交</label>
                    <?php echo $form->textField($zf, 'pay_jiao', array('class' => 'form-control input-inline')); ?>
                    <label class="control-label text-nowrap">押</label>
                    <?php echo $form->textField($zf, 'pay_ya', array('class' => 'form-control input-inline')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">房龄</label>
                <div class="col-md-2">
                    <?php echo $form->dropDownList($zf,'age', array_combine(range((int)date('Y'), (int)date('Y')-25),range((int)date('Y'), (int)date('Y')-25)),array('empty'=>array(0=>'--请选择--'),'class'=>'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'age'); ?></span>
                </div>
                <label class="col-md-1 control-label right-text">年 </label>
            </div>
            
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">装修情况</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'decoration', CHtml::listData(TagExt::model()->getTagByCate('resoldzx')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($zf, 'decoration'); ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">朝向</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($zf, 'towards', CHtml::listData(TagExt::model()->getTagByCate('resoldface')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($zf, 'towards'); ?></div>
            </div>
            <div class="form-group" id="zfzzpt">
                <label class="col-md-2 control-label text-nowrap">租房住宅配套</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($zf, 'zfzzpt', CHtml::listData(TagExt::model()->getTagByCate('zfzzpt')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfzzts">
                <label class="col-md-2 control-label text-nowrap">租房住宅特色</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($zf, 'zfzzts', CHtml::listData(TagExt::model()->getTagByCate('zfzzts')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfsppt">
                <label class="col-md-2 control-label text-nowrap">租房商铺配套</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($zf, 'zfsppt', CHtml::listData(TagExt::model()->getTagByCate('zfsppt')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfspts">
                <label class="col-md-2 control-label text-nowrap">租房商铺特色</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($zf, 'zfspts', CHtml::listData(TagExt::model()->getTagByCate('zfspts')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfxzlts">
                <label class="col-md-2 control-label text-nowrap">租房写字楼特色</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($zf, 'zfxzlts', CHtml::listData(TagExt::model()->getTagByCate('zfxzlts')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group" id="zfxzlpt">
                <label class="col-md-2 control-label text-nowrap">租房写字楼配套</label>
                <div class="col-md-10">
                    <?php echo $form->checkBoxList($zf, 'zfxzlpt', CHtml::listData(TagExt::model()->getTagByCate('zfxzlpt')->normal()->findAll(['order'=>'sort asc']), 'id', 'name'), array('class' => 'checkbox-inline', 'separator' => '&nbsp;&nbsp;', 'template' => '<label>{input} {label}</label>')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap"><span style="color: red">*&nbsp;</span>租房标题</label>
                <div class="col-md-10">
                    <?php echo $form->textField($zf, 'title', array('class' => 'form-control', 'data-target' => 'pointname')); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'title'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">房源描述</label>
                <div class="col-md-10">
                    <?php echo $form->textArea($zf, 'content', ['id'=>'content']); ?>
                    <span class="help-block"><?php echo $form->error($zf, 'content'); ?></span>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">下架时间</label>
                <div class="col-md-6">
                    <div class="input-group date form_datetime">
                        <?php //echo $form->textField($zf, 'expire_time', array('class' => 'form-control', 'value' => ($zf->expire_time ? date('Y-m-d', $zf->expire_time) : ''))); ?>
                        <span class="input-group-btn">
                                      <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                   </span>
                    </div>
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-md-2 control-label">添加图片</label>
                <div class="col-md-8">
                    <?php $this->widget('FileUpload', array('inputName' => 'img', 'multi' => true, 'waterMark' => true, 'callback' => 'function(data){callback(data);}')); ?>
                </div>
            </div>
            <div class="form-group images-place" style="margin-left: 220px">

                <?php if ($zf->images) foreach ($zf->images as $key => $value) { ?>
                    <div class='image-div' style='width: 150px;display:inline-table;height:180px'><a
                            href='javascript::void(0)' class='btn green btn-xs fm-btn <?=$value['url']==$zf['image']?'isfm':''?>'
                            style='position: absolute;display: <?= $value['url'] == $zf['image'] ? 'block' : 'none' ?>'>已设置封面</a><a
                            onclick='del_img(this)' class='btn red btn-xs'
                            style='position: absolute;margin-left: 94px;'><i class='fa fa-trash'></i></a><img
                            src='<?= ImageTools::fixImage($value->url) ?>' style='width: 120px;height: 90px'><input
                            name='image_des[]' value="<?= $value->name ?>" type='text' style='width: 80px'/><a
                            class='btn btn-xs green' onclick='setFm(this)' style='width: 40px;'>封面</a><input
                            type='hidden' class='trans_img' name='images[]' value='<?= $value->url ?>'/><input
                            type='hidden' class='fm'/></div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">选择小区图片</label>
                <input type="hidden" value="<?= $this->createUrl('/admin/plot/AjaxGetImgs') ?>" id="getImgs"/>
                <div class="col-md-10 xqtp">
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <input type="submit" class="btn green" value="保存">
                        <?php echo CHtml::link('返回', Yii::app()->createUrl('admin/zf/zfList'), array('class' => 'btn default')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>

<?php
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/linkage-zf.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/add-images.js', CClientScript::POS_END);
//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset' => 'utf-8'));
$js = "
            $(function(){
               $('.select2').select2({
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
            })
            ";

Yii::app()->clientScript->registerScript('add', $js, CClientScript::POS_END);

?>
<script>
    <?php Tools::startJs(); ?>
    jQuery(function ($) {
        $("#category").linkage_zf([
            {
                "_id": "esfzfzztype",
                "_parent_value": 1
            }
            ,
            {
                "_id": "zzczfs",
                "_parent_value": 1
            }
            ,
            {
                "_id": "zzfx",
                "_parent_value": 1
            }
            ,
            {
                "_id": "esfzfsptype",
                "_parent_value": 2
            }
            ,
            {
                "_id": "esfzfxzltype",
                "_parent_value": 3
            }
            ,
            {
                "_id": "zfspkjyxm",
                "_parent_value": 2
            }
            ,
            {
                "_id": "zfzzpt",
                "_parent_value": 1
            }
            ,
            {
                "_id": "zfzzts",
                "_parent_value": 1
            }
            ,
            {
                "_id": "zfsppt",
                "_parent_value": 2
            }
            ,
            {
                "_id": "zfspts",
                "_parent_value": 2
            }
            ,
            {
                "_id": "zfxzlpt",
                "_parent_value": 3
            }
            ,
            {
                "_id": "zfxzlts",
                "_parent_value": 3
            }
            ,
            {
                "_id": "zfxzllevel",
                "_parent_value": 3
            }
            ,
            {
                "_id": "esfsplevel",
                "_parent_value": 2
            }
        ]);
        function mianyi_check() {
            if ($("#uniform-mianyi").find("span").attr("class") == "checked") {
                $("#ResoldZfExt_price").val(0).attr("readonly", true);
            } else {
                $("#ResoldZfExt_price").removeAttr("readonly");
            }
        }
        $("#mianyi").bind("change", function () {

            mianyi_check();
        });
    });
    function checkPhone() {
       $('.phone-status').remove();
       $.ajax({
            type:'get',
            url:'<?=$this->createUrl('/admin/esf/checkPhone')?>',
            data:{phone:$('#ResoldZfExt_phone').val(),type:'2'},
            dataType:'json',
            success:function(data){
                if(data.data=="1")
                    $('.check-phone').after('<span class="phone-status" style="color:red">该号码已存在,请另选房源<span>');
                else
                    $('.check-phone').after('<span class="phone-status" style="color:red">该号码可以使用<span>');
            }
        });
    }
    <?php Tools::endJs('js');?>
</script>
