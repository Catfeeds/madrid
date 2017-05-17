<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-12
 * Time: 上午11:55
 */
$this->pageTitle = '编辑房源';
$this->breadcrumbs = array($this->pageTitle);
?>
<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'),'enableAjaxValidation'=>false)) ?>

<div class="tabbale">
    <ul class="nav nav-tabs nav-tabs-lg">
        <li class="active">
            <a href="#tab_1" data-toggle="tab"> 基本信息 </a>
        </li>
        <li>
            <a href="#tab_2" data-toggle="tab"> 楼盘详情 </a>
        </li>
        <li>
            <a href="#tab_3" data-toggle="tab"> SEO设置</a>
        </li>
    </ul>
    <div class="tab-content col-md-12" style="padding-top:20px;">
    <!-- 基本信息 -->
    <div class="tab-pane col-md-12 active" id="tab_1">
        <!-- 基本信息左侧 -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">楼盘名称</label>
                <div class="col-md-10">
                    <!--<input type="text" class="form-control" placeholder="">-->
                    <?php echo $form->textField($plot,'title',array('class'=>'form-control','data-target'=>'pointname')); ?>
                    <span class="help-block"><?php echo $form->error($plot, 'title'); ?></span>
                </div>
                <div class="col-md-12"></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">销售状态</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($plot, 'sale_status', CHtml::listData(TagExt::model()->getTagByCate('xszt')->normal()->findAll(),'id','name'), array('class'=>'form-control', 'empty'=>array($plot->sale_status=>'请选择销售状态'))); ?>
                    <span class="help-block"><?php echo $form->error($plot, 'sale_status'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">物业类型</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($plot, 'wylx',  CHtml::listData(TagExt::model()->getTagByCate('wylx')->normal()->findAll(),'id','name'), array('class'=>'form-control select2','multiple'=>'multiple')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'wylx'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">建筑类型</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($plot, 'jzlb',  CHtml::listData(TagExt::model()->getTagByCate('jzlb')->normal()->findAll(),'id','name'), array('class'=>'form-control select2','multiple'=>'multiple')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'jzlb'); ?></div>
            </div>
            
            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">地铁线路</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($plot, 'ditie',  CHtml::listData(TagExt::model()->getTagByCate('ditie')->normal()->findAll(),'id','name'), array('class'=>'form-control select2','multiple'=>'multiple')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'ditie'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">所在区域</label>
                <div class="col-md-10">
                    <?php
                        echo $form->dropDownList($plot , 'area' ,CHtml::listData($parentArea,'id','name') , array(
                                'class'=>'form-control input-inline',
                                'ajax' =>array(
                                    'url' => Yii::app()->createUrl('admin/area/ajaxGetArea'),
                                    'update' => '#PlotExt_street',
                                    'data'=>array('area'=>'js:this.value'),
                                )
                            )
                        );
                    ?>
                    <?php
                    echo $form->dropDownList($plot , 'street' ,$childArea ? CHtml::listData($childArea,'id','name'):array(0=>'--无子分类--') , array('class'=>'form-control input-inline'));
                    ?>
                <span class="help-block"><?php echo $form->error($plot, 'area').$form->error($plot, 'street'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">开盘时间</label>
                <div class="col-md-6">
                    <div class="input-group date form_datetime" >
                        <?php echo $form->textField($plot,'open_time',array('class'=>'form-control','value'=>($plot->open_time?date('Y-m-d',$plot->open_time):''))); ?>
                        <span class="input-group-btn">
                          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                       </span>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="help-inline"> </span>
                </div>
                <div class="col-md-12"></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">建筑面积</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[buildsize]',array('class'=>'form-control input-inline')); ?>
                    <span class="help-inline"> ㎡ </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[buildsize]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">容积率</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[capacity]',array('class'=>'form-control input-inline')); ?>
                    <span class="help-inline">  </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[capacity]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">物业费</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[manage_fee]',array('class'=>'form-control input-inline')); ?>
                    <span class="help-inline"> 元/m²•月 </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[manage_fee]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">开发商</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[developer]',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[developer]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">是否新盘</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($plot,'is_new', PlotExt::$isNew,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')) ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'is_new'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">是否分销</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($plot,'is_coop', PlotExt::$isCoop,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')) ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'is_coop'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">楼盘状态</label>
                <div class="col-md-10">
                    <div class="radio-list">
                        <?php echo $form->radioButtonList($plot,'status', PlotExt::$status,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input} {label}</label>')) ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'status'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">楼盘封面</label>
                <div class="col-md-10">
                    <div id="uploader" class="wu-example">
                        <div class="btns">
                            <!--<div id="cover_img">选择文件</div>-->
                            <?php $this->widget('FileUpload',array('model'=>$plot,'attribute'=>'image','inputName'=>'image','width'=>'300','removeCallback'=>"$('#image').html('')")); ?>
                        </div>
                    </div>
                    <div id="singlePicyw1"></div>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'image'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">合作星级</label>
                <div class="col-md-4">
                    <div class="radio-list">
                        <?php echo $form->dropDownList($plot, 'star', PlotExt::$star, array('class'=>'form-control',)); ?>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'status'); ?></div>
            </div>

        </div>
        <!-- 基本信息右侧 -->
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-group">
                    <label class="col-md-2 control-label text-nowrap">楼盘拼音</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($plot,'pinyin',array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($plot, 'pinyin'); ?></span>
                    </div>
                    <label class="col-md-2 control-label text-nowrap">首字母</label>
                    <div class="col-md-3">
                        <?php echo $form->textField($plot,'fcode',array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($plot, 'fcode'); ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label class="col-md-2 control-label text-nowrap">楼盘排序</label>
                    <div class="col-md-5">
                        <?php echo $form->textField($plot,'sort',array('class'=>'form-control')); ?>
                    </div>
                    <label class="col-md-2 control-label text-nowrap">点击量</label>
                    <div class="col-md-3">
                        <?php echo $form->textField($plot,'views',array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-12"><?php echo $form->error($plot, 'sort'); ?><?php echo $form->error($plot, 'views'); ?></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">项目特色</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($plot, 'xmts',  CHtml::listData(TagExt::model()->getTagByCate('xmts')->normal()->findAll(),'id','name'), array('class'=>'form-control select2','multiple'=>'multiple')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'xmts'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">装修状态</label>
                <div class="col-md-10">
                    <?php echo $form->dropDownList($plot, 'zxzt',  CHtml::listData(TagExt::model()->getTagByCate('zxzt')->normal()->findAll(),'id','name'), array('class'=>'form-control select2','multiple'=>'multiple')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'zxzt'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">地图坐标</label>
                <div class="col-md-10">
                    <button type="button" class="btn green-meadow show-map" data-toggle="modal" href="#large">地图标识</button>
                    <span id="coordText" style="padding-left:10px;">
                       <?php if($plot->map_lng || $plot->map_lat): ?>
                           经度：<?php echo $plot->map_lng!=0 ? $plot->map_lng : $maps['lng']; ?> &nbsp;
                           纬度：<?php echo $plot->map_lat!=0 ? $plot->map_lat : $maps['lat']; ?>
                       <?php endif;?>
                    </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'map_lng'); ?><?php echo $form->error($plot, 'map_lat'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">交付时间</label>
                <div class="col-md-6">
                    <div class="input-group date form_datetime">
                        <?php echo $form->textField($plot,'delivery_time',array('class'=>'form-control','value'=>($plot->delivery_time?date('Y-m-d',$plot->delivery_time):''))); ?>
                        <span class="input-group-btn">
                          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                       </span>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="help-inline"> </span>
                </div>
                <div class="col-md-12"></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">占地面积</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[size]',array('class'=>'form-control input-inline')); ?>
                    <span class="help-inline"> ㎡ </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[size]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">绿化率</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[green]',array('class'=>'form-control input-inline')); ?>
                    <span class="help-inline"> % </span>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[green]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">物业公司</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[manage_company]',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[manage_company]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">代理公司</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[agent]',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[agent]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">许可证</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[license]',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[license]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">楼盘电话</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'sale_tel',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'sale_tel'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">楼盘地址</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'address',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'address'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">售楼地址</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'sale_addr',array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'sale_addr'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">二手房页URL</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[esfUrl]',array('class'=>'form-control' ,  'placeholder'=>'输入的网址请以http://开头')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[esfUrl]'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">租房页URL</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'data_conf[zfUrl]',array('class'=>'form-control' ,  'placeholder'=>'输入的网址请以http://开头')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[zfUrl]'); ?></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->dropDownList($plot,'price_mark',PlotPriceExt::$mark,array('class'=>'form-control input-inline','style'=>'width:auto;')); ?>
                    <?php echo $form->textField($plot,'price',array('class'=>'form-control input-inline')); ?>
                    <?php echo $form->dropDownList($plot,'unit',PlotPriceExt::$unit,array('class'=>'form-control input-small input-inline')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'price') ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">关联标签id</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'tag_id',array('class'=>'form-control input-inline')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'tag_id'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">团购id</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'tuan_id',array('class'=>'form-control input-inline')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'tuan_id'); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label text-nowrap">看房团id</label>
                <div class="col-md-10">
                    <?php echo $form->textField($plot,'kan_id',array('class'=>'form-control input-inline')); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'kan_id'); ?></div>
            </div>

        </div>
    </div>

    <!-- 楼盘详情 -->
    <div class="tab-pane col-md-12" id="tab_2">
        <div class="form-group">
            <div class="col-md-12">
                <label class="col-md-2 control-label text-nowrap">项目配套</label>
                <div class="col-md-8">
                    <?php echo $form->TextArea($plot, 'data_conf[peripheral]', array('class'=>'form-control','rows'=>5)); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[peripheral]'); ?></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <label class="col-md-2 control-label text-nowrap">交通状况</label>
                <div class="col-md-8">
                    <?php echo $form->TextArea($plot, 'data_conf[transit]', array('class'=>'form-control','rows'=>5)); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[transit]'); ?></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <label class="col-md-2 control-label text-nowrap">项目介绍</label>
                <div class="col-md-8">
                    <?php echo $form->textArea($plot, 'data_conf[content]', array('id'=>'content','class'=>'form-control','rows'=>5)); ?>
                </div>
                <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[content]'); ?></div>
            </div>
        </div>
    </div>
    <!-- 楼盘详情 -->
    <div class="tab-pane col-md-12" id="tab_3">
        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">META Title（栏目标题）</label>
            <div class="col-md-10">
                <?php echo $form->textField($plot,'data_conf[seo_title]',array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[seo_title]'); ?></div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">META Keywords（栏目关键词）</label>
            <div class="col-md-10">
                <?php echo $form->textField($plot,'data_conf[seo_keywords]',array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[seo_keywords]'); ?></div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label text-nowrap">META Description（栏目描述）</label>
            <div class="col-md-10">
                <?php echo $form->TextArea($plot, 'data_conf[seo_description]', array('class'=>'form-control','rows'=>5)); ?>
            </div>
            <div class="col-md-12"><?php echo $form->error($plot, 'data_conf[seo_description]'); ?></div>
        </div>
    </div>
    <div class="col-md-12 center-block text-center">
        <div class="btn-group text-center">
            <button class="btn green-meadow col-md-offset-4">提交</button>
            <a href = "<?php echo $this->createUrl('/admin/plot/list')?>" class="btn default col-md-offset-4">返回</a>
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
                    经度：<input id="lng" readonly_="readonly" size="20" name="PlotExt[map_lng]" type="text" value="<?php echo $plot->map_lng!=0 ? $plot->map_lng : $maps['lng']; ?>">                    纬度：<input id="lat" readonly_="readonly" size="20" name="PlotExt[map_lat]" type="text" value="<?php echo $plot->map_lat!=0 ? $plot->map_lat : $maps['lat']; ?>">                    缩放：<input type="text" name="PlotExt[map_zoom]" id="zoom" readonly="readonly" size="2" value="<?php echo $plot->map_zoom!=0 ? $plot->map_zoom : $maps['zoom']; ?>"/>
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
<?php
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bmap.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/map.js', CClientScript::POS_END);
?>

<?php $this->endWidget(); ?>

<?php
//Select2
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
Yii::app()->clientScript->registerCssFile('/static/admin/pages/css/select2_custom.css');

//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

// Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

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

            });


            ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);
?>
<?php
//Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/union-select.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/union-select.js', CClientScript::POS_END);
?>
