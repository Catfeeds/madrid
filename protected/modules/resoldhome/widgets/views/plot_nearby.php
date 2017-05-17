<?php if($data): ?>
<div class="common-title"><span>您可能感兴趣的新房</span></div>
<div class="fang-list long-list">
    <ul>
        <?php foreach ($data as $key => $value) {?>
            <li>
                <a href="<?=Yii::app()->createUrl('/home/plot/index',['py'=>$value->pinyin])?>" target="_blank">
                    <div class="pic">
                        <img src="<?=ImageTools::fixImage($value->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="">
                    </div>
                    <div class="info">
                        <div class="h-title"><span><?=$value->areaInfo?$value->areaInfo->name:''?></span><span><?=$value->title?></span></div>
                        <div class="price"><?php if($value->price>0):?><span class="price"><?php echo $value->price; ?></span><?php echo PlotPriceExt::$unit[$value->unit];?><?php else:?><span class="price">暂无报价</span><?php endif;?></div>
                    </div>
                </a>
            </li>
        <?php }?>

    </ul>
</div>
<?php endif; ?>