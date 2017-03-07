<?php 
	$this->pageTitle = '马德里公馆-红酒列表';
    $this->keyword = '西班牙进口红酒，红酒列表，里奥哈酒庄，进口红酒列表';
    $this->description = '马德里公馆提供优质西班牙进口红酒，主营里奥哈地区品质酒庄酒款。';
?>
<div id="sitecontent">
    <div class="npagePage Pageanli" id="mproject" style="margin-left: 20px;width: 1500px">
        <div class="content" style="margin:0 auto">
            <!-- <div class="header" id="plheader">
                <p class="title">菜品</p>
                <p class="subtitle">PRODUCTS</p>
            </div> -->
            <ul id="category1"  style="height: 20px;margin-bottom: 10px;padding: 0;margin-top: 10px">
            <?php $cateArr = $_GET;unset($cateArr['area'])?>
            <li style="margin-left: 10px;    display: inline-block;float: left"><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$area?'active':''?>">全部区域</a></li>
            <?php if($areas = CHtml::listData(TagExt::model()->getTagByCate('hjdq')->normal()->findAll(),'id','name')) foreach ($areas as $key => $value) {?>
                <li style="float:left"><a href="<?=$this->createUrl('list',$cateArr+['area'=>$key])?>" class="<?=$key==$area?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            <ul id="category"  style="height: 20px;margin-bottom: 10px;margin-top: 10px;padding: 0;">
            <?php $cateArr = $_GET;unset($cateArr['price'])?>
            <li style="margin-left: 10px;float: left;"><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$price?'active':''?>">全部价格</a></li>
            <?php if($prices = CHtml::listData(TagExt::model()->getTagByCate('hjjg')->normal()->findAll(),'id','name')) foreach ($prices as $key => $value) { ?>
            	<li style="float:left"><a href="<?=$this->createUrl('list',$cateArr+['price'=>$key])?>" class="<?=$key==$price?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            <ul id="category1"  style="height: 20px;margin-bottom: 10px;padding: 0">
            <?php $cateArr = $_GET;unset($cateArr['cate'])?>
            <li style="margin-left: 10px;    display: inline-block;float: left"><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$cate?'active':''?>">全部类型</a></li>
            <?php if($areas = CHtml::listData(TagExt::model()->getTagByCate('hjlx')->normal()->findAll(),'id','name')) foreach ($areas as $key => $value) {?>
                <li style="float:left"><a href="<?=$this->createUrl('list',$cateArr+['cate'=>$key])?>" class="<?=$value==$cate?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            <ul id="category2" >
            <?php $cateArr = $_GET;unset($cateArr['house'])?>
            <li style="margin-left: 10px;    display: inline-block;float: left"><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$house?'active':''?>">全部酒庄</a></li>
            <?php if($cates = CHtml::listData(HouseExt::model()->findAll(),'id','name')) foreach ($cates as $key => $value) {?>
            	<li style="float:left"><a href="<?=$this->createUrl('list',$cateArr+['house'=>$key])?>" class="<?=$key==$house?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            
            <div id="projectlist" class="module-content">
                <div class="wrapper">
                    <ul class="content_list">
                    <?php if($infos) foreach ($infos as $key => $value) {?>
                    	<li class="projectitem" style="display:inline;height:300px;word-break:break-all;word-wrap : break-word ;margin-right:20px;width: 200px;margin-top: 20px">
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank">
                                <div class="project_img"><img src="<?=ImageTools::fixImage($value->image,200,250)?>" width="200" height="250" /></div>
                                <div class="project_info" style="height:60px">
                                    <div style="">
                                        <p class="title" style="padding-top:5px;margin-left: 0;margin-right: 0"><?=$value->name?></p>
                                        <p class="subtitle" style="padding-left:0px;margin-left: 0;margin-right: 0;font-size: 8px;padding-right: 0"><?=Tools::u8_title_substr($value->eng,20)?><span style="float: right;">￥<?=$value->price?></span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
            <?php $this->widget('HomeLinkPager',['pages'=>$pager])?>
        </div>
    </div>
</div>