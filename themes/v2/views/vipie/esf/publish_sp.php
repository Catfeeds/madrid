<?php
$this->pageTitle = '二手房编辑页';
//引入排序+筛选头部
// include('filterbase/base.php');
?>
<div class="esf-fabu-container">
<?php $this->widget('VipieBreadCrumbsWidget',['fields'=>[['name'=>'管理二手房',],['name'=>'编辑二手房']]])?>

<div class="fabu-container">
<!--简易表单-->
<div class="m-form">
    <form name="" action="#" method="post">
        <fieldset>
            <div class="category">
            
                <div class="inner">
                    <div class="blank20"></div>
                    <!--标题文本-->
                    <h2 class="u-tt u-tt-md">发布方式（<span class="re">*</span>为必填）</h2>
                    <!--多行式面包屑导航-->
                    <div class="blank20"></div>
                    <?php if(!$esf->id):?>
                    <ul class="radio-list f-cb">
                        <li><label><input <?=isset($esf->category)&&$esf->category==1?'checked':''?> type="radio" onclick="setCategory(this)" name="f1" value="1"/>住宅</label></li>
                        <li><label><input <?=isset($esf->category)&&$esf->category==2?'checked':''?> type="radio" onclick="setCategory(this)" name="f1" value="2"/>商铺</label></li>
                        <li><label><input <?=isset($esf->category)&&$esf->category==3?'checked':''?> type="radio" onclick="setCategory(this)" name="f1" value="3"/>写字楼</label></li>
                    </ul>
                    <?php else:?>
                    <span style="font-size: 16px"><?=Yii::app()->params['category'][$esf->category]?></span>
                    <?php endif;?>
                	
                    <div class="blank20"></div>
                </div>

            </div>
            <div class="base-info">
                <div class="inner">
                    <div class="blank20"></div>
                    <!--标题文本-->
                    <h2 class="u-tt u-tt-md">基本信息（<span class="re">*</span>为必填）</h2>
                    <?php $this->widget('CommonInfoWidget',['model'=>$esf])?>
                    <!-- 商铺可经营项目 -->
                    <div class="formitm">
                        <label class="lab"><span class="re"></span> 可经营性项目</label>
                        <div class="ipt">
                            <ul class="checkbox-list f-cb">
                                <?php if($tsArr = TagExt::model()->getTagByCate('esfspkjyxm')->normal()->findAll()) foreach ($tsArr as $key => $value) {?>
                                    <li><label><input type="checkbox" <?=$esf->esfspkjyxm&&in_array($value->id, $esf->esfspkjyxm)?'checked':''?> name="ResoldEsfExt[esfspkjyxm][]" value="<?=$value->id?>"/><?=$value->name?></label></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                    <!-- 商铺级别 -->
                    <div class="formitm">
                        <label class="lab"><span class="re"></span> 商铺级别</label>
                        <div class="ipt">
                        <?php $splevel = $esf->getEsfTag('splevel');?>
                            <ul class="radio-list f-cb">
                            <?php if($typeArr = CHtml::listData(TagExt::model()->getTagByCate('esfsplevel')->normal()->findAll(),'id','name')) foreach ($typeArr as $key => $value) { ?>
                                <li><label><input type="radio" <?=$splevel&&$key==$splevel['id']?'checked':''?> name="tagsArr[3][]" value="<?=$key?>"/><?=$value?></label></li>
                            <?php }?>
                            </ul>
                        </div>
                    </div>
                    <!-- 物业费 -->
                    <div class="formitm">
                        <label class="lab"><span class="re"></span> 物业费</label>
                        <div class="ipt">
                            <input type="text" name="<?='ResoldEsfExt[wuye_fee]'?>" value="<?=$esf->wuye_fee?>" style="width: 200px" class="u-ipt u-ipt1" style="width:760px"/> 元/平方·月 
                        </div>
                    </div>
                    <?php $this->widget('CommonInfoWidget',['model'=>$esf,'place'=>'bottom'])?>
                    
                </div>
            </div>
            
        </fieldset>
    </form>
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
    <?php Tools::startJs()?>
    function setCategory(obj) {
        category = $(obj).val();
        url = '<?=$this->createUrl('/vipie'.(get_class($esf)=='ResoldEsfExt'?'/esf':'/zf').'/publish?category=')?>' + category;
        window.location.href = url;
    }
    <?php Tools::endJs('js')?>
</script>