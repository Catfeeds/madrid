<?php 
	$this->pageTitle = '马德里公馆-资讯列表';
    $this->keyword = '西班牙进口红酒，红酒资讯，红酒文化，红酒知识';
    $this->description = '马德里公馆介绍西班牙里奥哈葡萄酒历史、文化和知识';
?>
<div id="sitecontent">
        <div id="newsPage" class="npagePage Pagenews">
            <div id="banner">
                <div style="background-image:url(<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcNewsTop'),1200,400)?>);"></div>
            </div>
            <div class="content">
                <div class="header">
                    <p class="title">资讯</p>
                    <p class="subtitle">News</p>
                </div>
                <div id="category">
                <a href="<?=$this->createUrl('list')?>" class="<?=!$cate?'active':''?>">全部</a>
                <?php foreach (TagExt::model()->getTagByCate('wzlm')->normal()->sorted()->findAll() as $key => $value) {?>
                	<?php if($value->id != 19 && $value->id != 20):?>
                	<a href="<?=$this->createUrl('list',['cate'=>$value->id])?>" class="<?=$value->id==$cate?'active':''?>"><?=$value->name?></a>
                <?php endif;?>
                <?php }?>
                </div>
                <div id="newslist">
                    <div class="wrapper">
                    <?php if($infos) foreach ($infos as $key => $value) {?>
                    	<div id="newsitem_<?=$key?>" class="wow newstitem <?=$key%2==0?'left':'right'?>">
                            <a class="newscontent" target="_blank" href="<?=$this->createUrl('info',['id'=>$value->id])?>">
                                <div class="news_wrapper">
                                    <div class="newsbody">
                                        <p class="date"><span class="md"><?=date('Y',$value['created'])?><span>-</span></span><span class="year"><?=date('m',$value['created'])?>-<?=date('d',$value['created'])?></span></p>
                                        <p class="title"><?=$value['title']?></p>
                                        <div class="separator"></div>
                                        <p class="description"><?=Tools::u8_title_substr($value['desc'],30)?></p>
                                    </div>
                                </div>
                                <div class="newsimg" style="background-image:url(<?=ImageTools::fixImage($value->image,600,400)?>)"></div>
                            </a>
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="clear"></div>
                <?php $this->widget('HomeLinkPager',['pages'=>$pager])?>
            </div>
        </div>
    </div>