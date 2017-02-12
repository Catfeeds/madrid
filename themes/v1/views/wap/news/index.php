<?php
$artcate = '';
foreach($cate as $v){
    if($v->id == $cid){
        $artcate = $v->name;
    }
}
$this->pageTitle =($artcate ? $artcate : '房产资讯').'_'.$this->siteConfig['cityName'].'房产网_'.'第'.(int)Yii::app()->request->getParam('page',1).'页-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag(($artcate ? $artcate : '房产资讯').'，'.$this->siteConfig['siteName'].'房产，'.$this->siteConfig['cityName'].'房产网','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/plot.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>
<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
    <span class="ml10 mr10 c-gc fl fs32">|</span>
    <span class="fl fs32 gc3">资讯</span>
</header>
<div  class="ui-search-box pr">
    <div class="ui-search">
        <form action="<?php echo $this->createUrl('/wap/news/index')?>"  method="GET">
            <div class="ui-search-r">
                <input type="submit" class="ui-search-btn" value="搜索">
            </div>
            <div class="ui-search-l">
                <i class="icon icon-search"></i>
                <input class="ui-search-text" type="search" name="kw" placeholder="输入您要找的资讯内容" value="<?php echo $kw;?>">
            </div>
        </form>
    </div>
</div>
<?php if(!$kw): ?>
<div class="pr clearfix ui-tab">
    <ul class="ui-menu ui-li-two border-top">
        <li>
            <span><?php echo isset($sortArr[$sort]) ? $sortArr[$sort] : '排序'?></span>
            <i></i>
        </li>
        <li>
            <span ><?php echo isset($cate[$cid]) ? $cate[$cid]->name : '分类'; ?></span>
            <i></i>
        </li>
    </ul>
    <div class="ui-submenu">
        <ul class="ui-long">
            <li <?php echo $sort=='zx' ? 'class="current"' : ''?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('sort'=>'zx','page'=>(int)Yii::app()->request->getQuery('page',0)))) ?>">最新排序</a></li>
            <li <?php echo $sort=='rm' ? 'class="current"' : ''?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('sort'=>'rm','page'=>(int)Yii::app()->request->getQuery('page',0)))) ?>">热门排序</a></li>
        </ul>
    </div>
    <div class="ui-submenu">
        <ul class="ui-long">
            <li <?php echo !isset($cid) ? 'class="current"' : ''?>><a href="<?php echo $this->createUrl('index') ?>">全部资讯</a></li>
            <?php foreach($cate as $v){ ?>
            <li <?php echo $v->id == $cid ? 'class="current"' : ''?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('cid'=>$v->id,'page'=>(int)Yii::app()->request->getQuery('page',0)))) ?>"><?php echo $v->name?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php endif; ?>
    <div class="gw">
        <?php if(isset($article) && !empty($article)){?>
        <div class="gcal">共有 <?php echo $pager->getItemCount();?> 条资讯</div>
        <div class="plot-list">
            <ul>
                <?php foreach($article as $v):?>
                     <li <?php echo $v->image ? '':'class="has-no-img"'?>>
                        <a <?php if($v->url): ?>target="_blank"<?php endif; ?> href="<?php echo (isset($v->url)&&!empty($v->url)) ? $v->url : $this->createUrl('/wap/news/detail',array('id'=>$v->id))?>">
                            <?php if($v->image):?>
                                <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image,200,140) ?>" alt="" /></div>
                            <?php endif;?>
                            <div class="info">
                                <h3 class="fs28 pt10 lineh40"><?php echo Tools::u8_title_substr($v->title,40)?></h3>
                                <p class="gc9"><?php echo $v->cate->name?><span class="ml10 mr10">|</span><?php echo date('Y-m-d',$v->show_time)?></p>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php }else{ ?>
            <div class="gcal">未搜索到相关的资讯</div>
        <?php } ?>
    </div>

<?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
