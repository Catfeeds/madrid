<?php
  $this->pageTitle = '酒庄详情';
?>
<style type="text/css">
    a{
        height: 0;
        width: 100%;
        line-height: 0;
        text-align: center;
        color: #fff;
        /*background-color: #5A5A5A;*/
        display: block;
        bottom: 0;
        left: 0;
    }
    .bt{
        height: 40px;width: 100%;line-height: 40px;text-align: center;color: #fff;background-color: #5A5A5A;display: block;bottom: 0;left: 0;
    }
</style>

<div class="npagePage">
    <div class="content">
        <div id="projectpost">
            <div class="header">
                <p class="title"><?=$info->name?></p>
                <p class="subtitle"><?=$info->eng?></p>
            </div>
            <ul id="projectimages" class="plr5">
                <li><img src="<?=ImageTools::fixImage($info->image)?>" class="imgcw" /></li>
            </ul>
            <div class="clear"></div>
            <div class="postbody plr10">
                <p>地区: <?=TagExt::getNameByTag($info->place)?></p>
                <p>等级: <?=TagExt::getNameByTag($info->level)?></p>
                <p>酒款数量: <?=count($info->products)?> 款</p>
                <p>
                    <br />
                </p>
                <p><?=str_replace('<a', '<span', str_replace('</a', '</span', $info->content))?></p>

            <?php if($info->products):?>
                <p><a class="bt" href="<?=$this->createUrl('/home/product/list',['house'=>$info->id])?>">查看全部酒款</a></p>
            <?php endif;?>
            </div>
        </div>
        <div id="pages"></div>
    </div>
</div>