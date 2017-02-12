<?php
$areaInfo = ($selectedArea ? $selectedArea->name : '') . ($selectedStreet ? $selectedStreet->name : '') . (isset($priceTag[$this->urlConstructor->price]) ? $priceTag[$this->urlConstructor->price]->title : '');
$this->pageTitle = $this->siteConfig['cityName'].$areaInfo.'楼盘_'.$this->siteConfig['cityName'].$areaInfo.'新楼盘_'.$this->siteConfig['cityName'].$areaInfo.'新房价格-'.$this->siteConfig['siteName'].'房产手机版-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].$areaInfo.'楼盘,'.$this->siteConfig['cityName'].$areaInfo.'新楼盘,'.$this->siteConfig['cityName'].$areaInfo.'新房价格-'.$this->siteConfig['siteName'].'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网为您提供最新最全的'.$areaInfo.'新房信息，方便广大网友快速找到喜爱的新房楼盘，购买'.$this->siteConfig['cityName'].'新盘就上'.$this->siteConfig['siteName'],'description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/plot.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>

<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>" class=" "><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?>"></a></div>
    <span class="ml10 mr10 c-gc fl fs32">|</span>
    <span class="fl fs32 gc3">找楼盘 </span>
</header>

<div  class="ui-search-box pr">
    <div class="ui-search">
        <form action="<?php echo $this->createUrl('list')?>"  method="GET">
            <div class="ui-search-r"><input type="submit" class="ui-search-btn" value="搜索"></div>
            <div class="ui-search-l"><i class="icon icon-search"></i><input class="ui-search-text" type="search" name="kw" placeholder="输入您要找的楼盘名称" value=""></div>
        </form>
    </div>
</div>

<div class="pr clearfix ui-tab">
    <ul class="ui-menu ui-li-four border-top">
        <li>
            <span>区域</span>
            <i></i>
        </li>
        <li>
            <span>价格</span>
            <i></i>
        </li>
        <li>
            <span >类型</span>
            <i></i>
        </li>
        <li>
            <span>更多</span>
            <i></i>
        </li>
    </ul>
    <div class="ui-submenu">
        <ul class="ui-type-two">
            <li>
                <a href="">全部区域</a>
                <ul class="ui-long">
                    <li <?php echo !$this->urlConstructor->place ? 'class="current"' : ''?>><a href="<?php echo $this->urlConstructor->remove('place');?>">全部区域</a></li>
                </ul>
            </li>
            <?php
            foreach($allArea as $id=>$area):
                if($area->getIsFirstLevel()):
            ?>
                <li >
                    <a href=""><?php echo $area->name; ?></a>
                    <ul class="ui-long">
                        <li <?php echo !$selectedStreet ? 'class="current"' : ''?>><a href="<?php echo $this->urlConstructor->add('place', $area->id);?>">不限</a></li>
                    <?php foreach($area->childArea as $childArea):?>
                        <li <?php echo $selectedStreet&&$selectedStreet->id==$childArea->id ? 'class="current"' : ''?>><a href="<?php echo $this->urlConstructor->add('place',$childArea->id);?>"><?php echo $childArea->name; ?></a></li>
                    <?php endforeach;?>
                    </ul>
                </li>
            <?php endif;endforeach;?>
        </ul>
        <div class="blank30"></div>
    </div>
    <div class="ui-submenu">
        <ul class="ui-long">
        <li <?php echo !$this->urlConstructor->price ? 'class="current"' : ''?>><a href="<?php echo $this->urlConstructor->remove('price');?>">不限</a></li>
        <?php foreach($priceTag as $v):?>
            <li <?php echo $this->urlConstructor->price == $v->id ? 'class="current"' : ''?>><a href="<?php echo $this->urlConstructor->add('price', $v->id);?>"><?php echo $v->title?></a></li>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="ui-submenu">
        <ul class="ui-long">
        <li <?php echo !$this->urlConstructor->wylx ? 'class="current"' : ''?>><a href="<?php echo $this->get_url('w',0);?>">不限</a></li>
        <?php foreach($allTagsIndexByCate['wylx'] as $v):?>
            <li <?php echo $this->urlConstructor->wylx == $v->id ? 'class="current"' : ''?>><a href="<?php echo $this->urlConstructor->add('wylx', $v->id);?>"><?php echo $v->name?></a></li>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="ui-submenu ">
        <ul class="ui-type-two">
            <li>
                <a href="">销售状态</a>
                <ul class="ui-long">
                    <li <?php echo !$this->urlConstructor->xszt ? 'class="current"':''?>><a href="<?php echo $this->urlConstructor->remove('xszt');?>">不限</a></li>
                    <?php foreach($allTagsIndexByCate['xszt'] as $v):?>
                        <li <?php echo $this->urlConstructor->xszt == $v->id ? 'class="current"':''?>><a href="<?php echo $this->urlConstructor->add('xszt', $v->id);?>"><?php echo $v->name?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>

            <li>
                <a href="">装修状态</a>
                <ul class="ui-long">
                <li <?php echo !$this->urlConstructor->zxzt ? 'class="current"':''?>><a href="<?php echo $this->urlConstructor->remove('zxzt');?>">不限</a></li>
                <?php foreach($allTagsIndexByCate['zxzt'] as $v):?>
                    <li <?php echo $this->urlConstructor->zxzt == $v->id ? 'class="current"':''?>><a href="<?php echo $this->urlConstructor->add('zxzt', $v->id);?>"><?php echo $v->name?></a></li>
                <?php endforeach;?>
                </ul>
            </li>
            <li>
                <a href="">项目特色</a>
                <ul class="ui-long">
                <li <?php echo !$this->urlConstructor->xmts ? 'class="current"':''?>><a href="<?php echo $this->urlConstructor->remove('xmts');?>">不限</a></li>
                <?php foreach($allTagsIndexByCate['xmts'] as $v):?>
                    <li <?php echo $this->urlConstructor->xmts == $v->id ? 'class="current"':''?>><a href="<?php echo $this->urlConstructor->add('xmts', $v->id);?>"><?php echo $v->name?></a></li>
                <?php endforeach;?>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="layer-overall"></div>
<?php if(isset($plots) && !empty($plots)):?>
    <div class="gw">
        <div class="gcal">共有 <?php echo $pager->getItemCount(); ?> 个楼盘</div>
        <div class="plot-list">
            <ul>
                <?php foreach($plots as $v): ?>
                    <?php
                    $discount = PlotDiscountExt::model()->find(array(
                        'select'=>'id,title',
                        'condition'=>'hid = :hid',
                        'params'=>array(':hid'=>$v->id),
                        'limit'=>1,
                        'order'=>'updated desc,created desc',
                    ));
                    ?>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$v->pinyin))?>">
                        <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image,200,140)?>" width="100%" height="100%" alt="" /></div>
                        <div class="info">
                            <h3 class="fs28"><?php echo Tools::u8_title_substr($v->title,0,20) ?></h3>
                            <p class="right-float c-red"><?php echo PlotPriceExt::getPrice($v->price,$v->unit);?></p>
                            <p class="gc6"><?php echo (isset($this->siteArea[$v->area])&&!empty($this->siteArea[$v->area])) ? ($this->siteArea[$v->area].((isset($this->siteStreet[$v->area])&&!empty($this->siteStreet[$v->area])) ? ((isset($this->siteStreet[$v->area][$v->street])&&!empty($this->siteStreet[$v->area][$v->street])) ? '/'.$this->siteStreet[$v->area][$v->street] : '') :'' )) : '';?></p>
                            <p class="c-red"><?php echo (isset($discount) && !empty($discount)) ? Tools::u8_title_substr($discount->title,20) : ''?></p>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php else: ?>
    <div class="gw">
        <div class="gcal">未搜索到符合条件的楼盘</div>
    </div>
<?php endif; ?>
<?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
<div class="gototop">
    <span class="icon icon-goto-top"></span>
</div>
