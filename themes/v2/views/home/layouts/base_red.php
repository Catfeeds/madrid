<?php $this->beginContent('/layouts/base'); ?>
<body>
<div class="wapperout s-head-bg clearfix">
    <div class="wapper overvisible">
        <div class="s-head">
            <a href="<?php echo $this->createUrl('/home/index/index'); ?>" class="fl s-head-logo"><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->siteLogoRed()); ?>"></a>
            <ul class="s-head-nav">
                <li><a href="<?php echo $this->createUrl('/home/index/index')?>">首页</a></li>
                <?php if(SM::specialConfig()->enable() || SM::tuanConfig()->enable()): ?>
                <li><a href="<?php if(SM::specialConfig()->enable())
                                    {
                                        echo $this->createUrl('/home/special/trade');
                                    }else{
                                        echo $this->createUrl('/home/special/tuan');
                                    } ?>">团购</a></li>
                <?php endif; ?>
                <li <?php if($this->id == 'plot'):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/list')?>" class="pr ">新房</a></li>
                <?php if(SM::kanConfig()->enable()): ?>
                <li <?php if($this->id == 'tuan'):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/tuan/index')?>" class="pr ">看房团</a></li>
                <?php endif; ?>
                <?php if(SM::schoolConfig()->enable()): ?>
                <li><a href="<?php echo $this->createUrl('/home/school/index')?>">邻校房</a></li>
                <?php endif; ?>
                <?php if(SM::baikeConfig()->enable()): ?>
                <li><a href="<?php echo $this->createUrl('/home/baike/index')?>">买房宝典</a></li>
                <?php endif; ?>

                <li><a href="<?php echo $this->createUrl('/home/news/index')?>">资讯</a></li>
                <li <?php if($this->id == 'wenda'):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/wenda/index')?>">问答</a></li>
            </ul>
            <div class="s-search">
                <form action="<?=$this->createUrl('/home/plot/list'); ?>" method="get" target="_blank">
                    <div class="s-search-l">
                        <input type="text" class="s-search-txt"  value="" name="kw"  placeholder="输入楼盘名称" style="color: rgb(153, 153, 153);" data-url="<?php echo $this->createUrl('/api/plot/ajaxGetPlot'); ?>">
                        <ul class="s-search-down">

                        </ul>
                    </div>
                    <input type="submit" class="s-search-btn head-icon" value="">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    if(isset($this->breadcrumbs))
        $this->widget('HomeBreadcrumbs',array('links'=>$this->breadcrumbs));
?>
<?php echo $content;?>
<?php $this->endContent(); ?>
