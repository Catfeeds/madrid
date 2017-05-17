<?php 
	$this->pageTitle = '马德里公馆-服务列表';
?>
<div id="sitecontent">
        <div class="npagePage Pageservice">
            <div id="banner">
                <div style="background-image:url(<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcServeTop'))?>);"></div>
            </div>
            <div class="content">
                <div class="header">
                    <p class="title">服务</p>
                    <p class="subtitle">SERVICE</p>
                </div>
                <div id="servicelist">
                    <ul class="wrap">
                    <?php if($infos) foreach ($infos as $key => $value) {?>
                    	<li class="serviceitem">
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank">
                                <p class="service_img"><img src="<?=ImageTools::fixImage($value->image,320,120)?>" width="320" height="120" /></p>
                                <div class="service_info">
                                    <p class="title"><?=$value->title?></p>
                                    <p class="description"><?=Tools::u8_title_substr($value->desc,30)?></p>
                                </div>
                            </a>
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                        </li>
                    <?php }?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div id="pages"></div>
            </div>
        </div>
    </div>