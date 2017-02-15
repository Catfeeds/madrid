<?php 
	$this->pageTitle = '酒庄列表';
?>
<div id="sitecontent">
    <div class="npagePage Pageanli" id="mproject">
        <div class="content">
            <div class="header" id="plheader">
                <p class="title">酒庄</p>
                <p class="subtitle">Chateau</p>
            </div>
            <ul id="category">
            <?php $cateArr = $_GET;unset($cateArr['level'])?>
            <li><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$level?'active':''?>">全部等级</a></li>
            <?php if($cates = CHtml::listData(TagExt::model()->getTagByCate('jzdj')->findAll(),'id','name')) foreach ($cates as $key => $value) {?>
            	<li><a href="<?=$this->createUrl('list',$cateArr+['level'=>$key])?>" class="<?=$key==$level?'active':''?>"><?=$value?></a></li>
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
                                        <p class="subtitle "><?=TagExt::getNameByTag($value->level)?></p>
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