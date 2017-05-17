<?php
$this->pageTitle = SM::urmConfig()->cityName().'房产特价房_一房一价_'.SM::urmConfig()->cityName().'特价房-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
<div class="content-box">
    <div class=" top-mark"></div>
    <?php $this->renderPartial('/layouts/header',['search'=>false]); ?>
    <img src="<?php echo ImageTools::fixImage($image); ?>">
    <div class=" bottom-mark"></div>
</div>
<div class="content-box">
    <?php if($special->htid==0):?>
    <div class="info-box">
        <p class="type"><?php echo $special->room; ?>&#160;&#160;</p>
        <p class="price"><strong class="oprice">¥<?php echo $special->price_new; ?>万元/套</strong><del>￥<?php echo $special->price_old; ?>万</del></p>
    </div>
    <ul class="house-detail-info">
        <li>居室：<span><?php echo $special->room; ?></span></li>
        <li>户型：</li>
        <li>面积：</li>
        <li>地址：<span><?php echo $special->plot->address; ?></span></li>
    </ul>
    <?php else:?>
    <div class="info-box">
        <p class="type"><?php echo $special->room;?>&#160;&#160;<?php echo $special->houseType->bedroom;?>室<?php echo $special->houseType->livingroom;?>厅<?php echo $special->houseType->bathroom;?>卫&#160;&#160;<?php echo $special->houseType->size;?>㎡</p>
        <p class="price"><strong class="oprice">¥<?php echo $special->price_new; ?>万元/套</strong><del>￥<?php echo $special->price_old; ?>万</del></p>
    </div>
    <ul class="house-detail-info">
        <li>居室：<span><?php echo $special->room;?></span></li>
        <li>户型：<span><?php echo $special->houseType->bedroom.'室'.$special->houseType->livingroom.'厅'.$special->houseType->bathroom.'卫';?></span></li>
        <li>面积：<span><?php echo $special->houseType->size;?>㎡</span></li>
        <li>地址：<span><?php echo $special->plot->address;?></span></li>
    </ul>
    <?php endif;?>
    <div class="loupan"><a href="<?php echo $this->createUrl('/wap/plot/index',['py'=>$special->plot->pinyin]); ?>">所属楼盘：<span><?php echo $special->plot->title; ?></span><?php echo PlotPriceExt::$mark[$special->plot->price_mark].$special->plot->price.PlotPriceExt::$unit[$special->plot->unit]; ?><i class="goarrow iconfont">&#x1020;</i></a></div>

</div>
<div class="blank20"></div>


<?php $this->widget('BottomOperate',['style'=>'ul','plot'=>$special->plot,'url3'=>$this->createUrl('/wap/order/form',['spm'=>OrderExt::generateSpm('特价房', $special),'title'=>$special->room.' '.$special->bed_room.' '.$special->size])]); ?>

<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('footer').remove();
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>

