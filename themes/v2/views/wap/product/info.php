<?php
  $this->pageTitle = '红酒详情';
?>
<?php $tags = $info->getTagName();?>

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
                <p>类型: <?=$tags['cid']?></p>
                <p>葡萄品种: <?=$tags['ptpz']?></p>
                <p>系列: <?=$tags['xl']?></p>
                <p>酒庄: <?=$info->houseInfo?$info->houseInfo->name:'-'?></p>
                <p>等级: <?=$info->houseInfo?TagExt::getNameByTag($info->houseInfo->level):'-'?></p>
                <p>价格：￥<?=$info->price?></p>
                <p>
                    <br />
                </p>
                
                <?php if($images = $info->images): ?>
                	<p><center><h3>相册</h3></center></p>
                <br>
                <ul>
                	<?php foreach ($images as $key => $value) {?>
                	<li><img src="<?=ImageTools::fixImage($value->url)?>" class="imgcw" />
                	<hr></li>
                <?php } endif;?></ul>
                <p><a href="tencent://message/?uin=<?=SiteExt::getAttr('qjpz','qq')?>&Site=uelike&Menu=yes">在线预定</a></p>
            </div>
        </div>
        <div id="pages"></div>
    </div>
</div>