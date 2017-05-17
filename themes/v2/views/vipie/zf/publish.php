<?php
$this->pageTitle = '租房发布页';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="esf-fabu-container">
    <!--多行式面包屑导航-->
    <?php $this->widget('VipieBreadCrumbsWidget',['fields'=>[['name'=>'管理租房',],['name'=>'发布租房']]])?>
    <div class="blank20"></div>
    <div class="fabu-container">
        <!--简易表单-->
        <div class="m-form">
            <?php $form = $this->beginWidget('vipie.widgets.EzForm',['action'=>'/vipie/zf/save']); ?>
                <fieldset>
                    <div class="category">
                        <div class="inner">
                            <div class="blank20"></div>
                            <!--标题文本-->
                            <h2 class="u-tt u-tt-md">发布方式（<span class="re">*</span>为必填）</h2>
                            <!--多行式面包屑导航-->
                            <div class="blank20"></div>
                            <?= $form->radioBoxList($model,'category',Yii::app()->params['category'],['class'=>'radio-list f-cb','type'=>'radio']);?>
                            <div class="blank20"></div>
                        </div>
                    </div>
                    <div class="base-info">
                        <div class="inner">
                            <div class="blank20"></div>
                            <!--标题文本-->
                            <h2 class="u-tt u-tt-md">基本信息（<span class="re">*</span>为必填）</h2>

                            <div class="formitm">
                                <label class="lab"><span class="re">*</span> 楼盘名称</label>
                                <div class="ipt">
                                    <input type="text" class="u-ipt u-ipt-form j-plot-search" style="width: 760px;" datatype="*" nullmsg="请输入小区名称" value="<?php echo $model->plot?$model->plot->title:'';?>" />
                                    <?= $form->hiddenField($model,'hid',['id'=>'plot_id']);?>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re"></span> 小区地址</label>
                                <div class="ipt">
                                    <?= $form->textField($model,'address',['class'=>'u-ipt u-ipt-form','id'=>'plot_address','style'=>'width:760px','datatype'=>'*','nullmsg'=>'请输入小区地址']); ?>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re">*</span> 所在楼层</label>
                                <div class="ipt">
                                    <?= $form->textField($model,'floor',['class'=>'u-ipt u-ipt1','data-name'=>'楼层','datatype'=>'floor','nullmsg'=>'请输入楼层']); ?><span class="unit">层，共</span>
                                    <?= $form->textField($model,'total_floor',['class'=>'u-ipt u-ipt1','data-name'=>'总楼层','datatype'=>'floor,floors','nullmsg'=>'请输入总层数']); ?><span class="unit">层（地下室楼层在数字前加“-”）</span>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re">*</span> 面<span class="em2"></span>积</label>
                                <div class="ipt">
                                    <?= $form->textField($model,'size',['class'=>'u-ipt u-ipt1','style'=>'width:200px','datatype'=>'size','nullmsg'=>'请输入面积','errormsg'=>'面积要大于1平方米小于10000平方米']); ?><span class="unit">平方米</span>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re">*</span> 户<span class="em2"></span>型</label>
                                <div class="ipt huxing-ipt">
                                    <?= $form->textField($model,'bedroom',['class'=>'u-ipt','datatype'=>'hx','nullmsg'=>'请输入几室','data-name'=>'卧室']); ?><span>室</span>
                                    <?= $form->textField($model,'livingroom',['class'=>'u-ipt','datatype'=>'hx','nullmsg'=>'请输入几厅','data-name'=>'客厅']); ?><span>厅</span>
                                    <?= $form->textField($model,'bathroom',['class'=>'u-ipt','datatype'=>'hx','nullmsg'=>'请输入几卫','data-name'=>'卫生间']); ?><span>卫</span>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re">*</span> 租<span class="em2"></span>金</label>
                                <div class="ipt">
                                    <?= $form->textField($model,'price',['class'=>'u-ipt u-ipt1','style'=>'width:200px','datatype'=>'rent','nullmsg'=>'请输入租金','errormsg'=>'租金必须在0到1000000之间']); ?><span class="unit">元/月</span><span class="tip">(若租金为“0”前台显示为面议)</span>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re">*</span> 出租方式</label>
                                <div class="ipt">
                                    <?= $form->dropDownList($model,'rent_type',CHtml::listData($allTag['zfmode'],'id','name'),['class'=>'j-select','data-class'=>'large']);?>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re"></span> 交付方式</label>
                                <div class="ipt">
                                    <span class="unit ml0">交</span><?= $form->textField($model,'pay_jiao',['class'=>'u-ipt','style'=>'width:58px']); ?>
                                    <span class="unit">押</span><?= $form->textField($model,'pay_ya',['class'=>'u-ipt','style'=>'width:58px']); ?>
                                </div>
                            </div>
                            <div class="formitm">
                                <label class="lab"><span class="re"></span> 朝向/装修</label>
                                <!--这里解决select压线问题-->
                                <div class="ipt" style="position:relative;z-index:2;">
                                    <?= $form->dropDownList($model,'towards',array_merge(['不限'],CHtml::listData($allTag['resoldface'],'id','name')),['class'=>'j-select','data-class'=>'large']);?>
                                    <?= $form->dropDownList($model,'decoration',array_merge(['不限'],CHtml::listData($allTag['resoldzx'],'id','name')),['class'=>'j-select','data-class'=>'large']);?>
                                </div>
                            </div>

                            <!-- 住宅 -->
                            <div id="zz">
                                <div class="formitm">
                                    <label class="lab"><span class="re"></span> 住宅配套</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfzzpt',CHtml::listData($allTag['zfzzpt'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                                <div class="formitm pt0">
                                    <label class="lab"><span class="re"></span> 住宅特色</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfzzts',CHtml::listData($allTag['zfzzts'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                            </div>
                            <!-- 住宅end -->

                            <!-- 商铺 -->
                            <div id="sp" style="display: none">
                                <div class="formitm">
                                    <label class="lab"><span class="re">*</span>商铺类别</label>
                                    <div class="ipt">
                                         <?= $form->radioBoxList($model,'esfzfsptype',CHtml::listData($allTag['esfzfsptype'],'id','name'),['class'=>'radio-list f-cb','type'=>'radio']);?>
                                    </div>
                                </div>
                                <div class="formitm">
                                    <label class="lab"><span class="re">*</span>经营项目</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfspkjyxm',CHtml::listData($allTag['zfspkjyxm'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                                <div class="formitm">
                                    <label class="lab"><span class="re">*</span>商铺级别</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'esfsplevel',CHtml::listData($allTag['esfsplevel'],'id','name'),['class'=>'radio-list f-cb','type'=>'radio']);?>
                                    </div>
                                </div>
                                <div class="formitm">
                                    <label class="lab"><span class="re">*</span> 物业费</label>
                                    <div class="ipt">
                                        <?= $form->textField($model,'wuye_fee',['class'=>'u-ipt u-ipt1','style'=>'width:200px']); ?><span class="unit">元/平方·月</span>
                                    </div>
                                </div>
                                <div class="formitm">
                                    <label class="lab"><span class="re"></span> 商铺配套</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfsppt',CHtml::listData($allTag['zfsppt'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                                <div class="formitm pt0">
                                    <label class="lab"><span class="re"></span> 商铺特色</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfspts',CHtml::listData($allTag['zfspts'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                            </div>
                            <!-- 商铺end -->

                            <!-- 写字楼 -->
                            <div id="xzl" style="display: none">
                                <div class="formitm">
                                    <label class="lab"><span class="re">*</span>写字楼类别</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'esfzfxzltype',CHtml::listData($allTag['esfzfxzltype'],'id','name'),['class'=>'radio-list f-cb','type'=>'radio']);?>
                                    </div>
                                </div>
                                <div class="formitm">
                                    <label class="lab"><span class="re">*</span>写字楼等级</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfxzllevel',CHtml::listData($allTag['zfxzllevel'],'id','name'),['class'=>'radio-list f-cb','type'=>'radio']);?>
                                    </div>
                                </div>
                                <div class="formitm">
                                    <label class="lab"><span class="re"></span> 写字楼配套</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfxzlpt',CHtml::listData($allTag['zfxzlpt'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                                <div class="formitm pt0">
                                    <label class="lab"><span class="re"></span> 写字楼特色</label>
                                    <div class="ipt">
                                        <?= $form->radioBoxList($model,'zfxzlts',CHtml::listData($allTag['zfxzlts'],'id','name'),['class'=>'checkbox-list f-cb','type'=>'checkbox']);?>
                                    </div>
                                </div>
                            </div>
                            <!-- 写字楼end -->

                            <div class="blank20"></div>
                        </div>
                    </div>
                    <div class="fangyuan-detail">
                        <div class="blank20"></div>
                        <h2 class="u-tt u-tt-md">房源详情（<span class="re">*</span>为必填）</h2>
                        <div class="formitm">
                            <label class="lab"><span class="re">*</span> 房源标题</label>
                            <div class="ipt limit-num j-limit-num">
                                <?= $form->textField($model,'title',['class'=>'u-ipt u-ipt-form','style'=>'width:760px','datatype'=>'*1-40','errormsg'=>'最多输入40个字','nullmsg'=>'请输入标题']); ?>
                                <span class="tip">您可以输入<span class="num">40</span>个字</span>
                            </div>
                        </div>
                        <div class="formitm">
                            <label class="lab"><span class="re">*</span> 房源描述</label>
                            <div class="ipt">
                                <?= $form->textArea($model, 'content', ['id'=>'content','class'=>'j-ueditor']); ?>
<!--                                <script id="container" name="content" type="text/plain" class="j-ueditor"></script>-->
                            </div>
                        </div>
                        <div class="formitm">
                            <label class="lab"><span class="re">*</span> 图片上传</label>
                            <div class="img-upload j-upload">
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
                                    </div>
                                    <div class="upload-img-list f-cb">
                                        <ul>
                                            <li class="upload-img-btn u-upload u-upload-btn2">
                                                <button type="button"></button>
                                                <!--<input type="file"/>-->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="formitm-btn">
                            <!--通用自定义按钮-->
                            <input type="submit" value="确认发布" class="u-btn"/>
                        </div>
                    </div>
                </fieldset>
            <?php $this->endWidget(); ?>
        </div>
        <div class="blank30"></div>
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

<?php
$js = <<<EOF
    Do(function(){
        $("input[name='ResoldZfExt[category]']").click(function(){
            var category = $(this).val()-1;
            var arr = ['zz','sp','xzl'];
            $("#"+arr[category]).show();
            arr.splice(category,1);
            for(var item in arr){
                  $("#"+arr[item]).hide();
            }
        })
    });
EOF;
Yii::app()->clientScript->registerScript(__CLASS__.'#js',$js,CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/vipie/js/validate.js',CClientScript::POS_END);
?>
