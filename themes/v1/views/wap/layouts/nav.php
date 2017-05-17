<div class="fr ui-operate layer-sub-btn down"><p class="icon icon-guide"></p><p>导航</p></div>
    <div class="column subnav-layer menuout" >
        <ul class="clearfix">
            <li><a href="<?php echo $this->createUrl('/wap/index/index')?>"><i class="icon icon-nav icon-home">&nbsp;</i>首页</a></li>
            <li><a href="<?php echo $this->createUrl('/wap/plot/list')?>"><i class="icon icon-nav icon-plot">&nbsp;</i>找楼盘</a></li>
            <li><a href="<?php echo $this->createUrl('/wap/purchase/index')?>"><i class="icon icon-nav icon-thfang">&nbsp;</i><?php echo $this->t('特惠团'); ?></a></li>
            <?php if($this->siteConfig['enableSpecialPlot']): ?>
            <li><a href="<?php echo $this->createUrl('/wap/special/index')?>"><i class="icon icon-nav icon-tjfang">&nbsp;</i>特价房</a></li><?php endif; ?>
            <li><a href="<?php echo $this->createUrl('/wap/school/index')?>"><i class="icon icon-nav icon-xqfang">&nbsp;</i>邻校房</a></li>
            <li><a href="<?php echo $this->createUrl('/wap/tuan/index')?>"><i class="icon icon-nav icon-kft">&nbsp;</i>看房团</a></li>
            <li><a href="<?php echo $this->createUrl('/wap/wenda/index')?>"><i class="icon icon-nav icon-answer">&nbsp;</i>问答</a></li>
            <li><a href="<?php echo $this->createUrl('/wap/calculator/index')?>"><i class="icon icon-nav icon-calculator">&nbsp;</i>计算器</a></li>
            <li><a href="<?php echo $this->createUrl('/wap/news/index')?>"><i class="icon icon-nav icon-news">&nbsp;</i>资讯</a></li>
        </ul>
    </div>
<div class="layer-subnav-bg"></div>
