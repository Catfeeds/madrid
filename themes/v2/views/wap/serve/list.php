<?php 
	$this->pageTitle = '服务列表';
?>
<div class="npagePage">
    <div class="content plr10">
        <div id="servicelist">
            <ul class="wrap">
            <?php if($infos) foreach ($infos as $key => $value) {?>
                <li class="serviceitem wow fadeIn">
                    <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" ><img src="<?=ImageTools::fixImage($value->image,320,120)?>" width="320" height="120" /></a>
                    <div>
                        <p class="title ellipsis" target="_blank"><?=$value->title?></p>
                        <p class="description"><?=Tools::u8_title_substr($value->desc,50)?></p>
                    </div>
                </li>
                <li class="line"></li>
                    <?php }?>
                
            </ul>
            <div class="clear"></div>
        </div>
        <div id="pages"></div>
    </div>
</div>