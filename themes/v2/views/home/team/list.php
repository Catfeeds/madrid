<?php 
	$this->pageTitle = '马德里公馆-团队列表';
?>
<div id="sitecontent">
        <div class="npagePage Pageteam">
            <div id="banner">
                <div style="background-image:url(<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcTeamTop'))?>);"></div>
            </div>
            <div class="content">
                <div class="header">
                    <p class="title">团队</p>
                    <p class="subtitle">Team</p>
                </div>
                <div id="teamlist">
                    <div class="wrap">
                    <?php if($infos) foreach ($infos as $key => $value) {?>
                    	<div class="teamitem">
                            <a href="#">
                                <div class="teamimg"><img src="<?=ImageTools::fixImage($value->image,320,320)?>" width="320" height="320" /></div>
                                <div class="wrap">
                                    <div><span class="h"></span><span class="v"></span></div>
                                </div>
                            </a>
                            <div class="teaminfo">
                                <p class="title"><a href="#"><?=$value->title?></a></p>
                                <p class="subtitle"><?=$value->sub_title?></p>
                                <p class="description"><?=Tools::u8_title_substr($value['desc'],50)?></p>
                            </div>
                            <a href="#" class="details">more<i class="fa fa-angle-right"></i></a>
                        </div>
                    <?php }?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="pages"></div>
            </div>
        </div>
    </div>