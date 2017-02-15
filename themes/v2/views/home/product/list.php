<?php 
	$this->pageTitle = '红酒列表';
?>
<div id="sitecontent">
    <div class="npagePage Pageanli" id="mproject">
        <div class="content">
            <!-- <div class="header" id="plheader">
                <p class="title">菜品</p>
                <p class="subtitle">PRODUCTS</p>
            </div> -->
            <ul id="category"  style="height: 20px;margin-bottom: 10px;margin-top: 10px;padding: 0">
            <?php $cateArr = $_GET;unset($cateArr['cate'])?>
            <li><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$cate?'active':''?>">全部类型</a></li>
            <?php if($cates = CHtml::listData(TagExt::model()->getTagByCate('hjlx')->findAll(),'id','name')) foreach ($cates as $key => $value) {?>
            	<li><a href="<?=$this->createUrl('list',$cateArr+['cate'=>$key])?>" class="<?=$key==$cate?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            <ul id="category"  style="height: 20px;margin-bottom: 10px;padding: 0">
            <?php $cateArr = $_GET;unset($cateArr['ptpz'])?>
            <li><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$ptpz?'active':''?>">全部品种</a></li>
            <?php if($cates = CHtml::listData(TagExt::model()->getTagByCate('ptpz')->findAll(),'id','name')) foreach ($cates as $key => $value) {?>
            	<li><a href="<?=$this->createUrl('list',$cateArr+['ptpz'=>$key])?>" class="<?=$key==$ptpz?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            <ul id="category">
            <?php $cateArr = $_GET;unset($cateArr['house'])?>
            <li><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$house?'active':''?>">全部酒庄</a></li>
            <?php if($cates = CHtml::listData(HouseExt::model()->findAll(),'id','name')) foreach ($cates as $key => $value) {?>
            	<li><a href="<?=$this->createUrl('list',$cateArr+['house'=>$key])?>" class="<?=$key==$house?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
            
            <div id="projectlist" class="module-content">
                <div class="wrapper">
                    <ul class="content_list">
                    <?php if($infos) foreach ($infos as $key => $value) {?>
                    	<li class="projectitem">
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank">
                                <div class="project_img"><img src="<?=ImageTools::fixImage($value->image,500,320)?>" width="500" height="320" /></div>
                                <div class="project_info">
                                    <div>
                                        <p class="title"><?=$value->name?></p>
                                        <p class="subtitle"><?=$value->eng?></p>
                                        <p class="subtitle ">￥<?=$value->price?></p>
                                    </div>
                                </div>
                            </a>
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
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