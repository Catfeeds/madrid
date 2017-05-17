<?php
$this->pageTitle = $this->siteConfig['cityName'].'房产问答_'.$this->siteConfig['cityName'].'买房问题-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['cityName'].'房产信息网，'.$this->siteConfig['siteName'].'，'.$this->siteConfig['cityName'],'keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/qa.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/wap/js/jquery-2.1.4.min.js', CClientScript::POS_END);
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>
<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
    <span class="ml10 mr10 c-gc fl fs32">|</span>
    <span class="fl fs32 gc3">问答</span>
</header>
<div  class="ui-search-box pr">
    <div class="ui-search">
        <form action="<?php echo $this->createUrl('index')?>"  method="GET">
            <div class="ui-search-r"><input type="submit" class="ui-search-btn" value="搜索"></div>
            <div class="ui-search-l"><i class="icon icon-search"></i><input class="ui-search-text" type="search" name="kw" placeholder="输入您要找的问题" value=""></div>
        </form>
    </div>
</div>

<div class="pr clearfix ui-tab">
    <ul class="ui-menu ui-li-two border-top">
        <li>
            <span>排序</span>
            <i></i>
        </li>
        <li>
            <span >分类</span>
            <i></i>
        </li>
    </ul>
    <div class="ui-submenu">
        <ul class="ui-long">
            <li <?php echo isset($px) && $px=='zx' ? 'class="current"' : '' ?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('px'=>'zx')))?>">最新排序</a></li>
            <li <?php echo isset($px) && $px=='rm' ? 'class="current"' : '' ?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('px'=>'rm')))?>">热门排序</a></li>
        </ul>
    </div>
    <div class="ui-submenu">
        <ul class="ui-type-two">
            <li class="current">
                <a href="">全部分类</a>
                <ul class="ui-long">
                    <li><a href="<?php echo $this->createUrl('index')?>">全部分类</a></li>
                </ul>
            </li>
            <?php foreach($cate as $v):?>
                <li>
                    <a href=""><?php echo $v['name']?></a>
                    <ul class="ui-long">
                        <li <?php echo isset($id) && $id == $v['id'] ? 'class="current"' : '' ?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('id'=>$v['id'])))?>">不限</a></li>
                    <?php foreach($v['childs'] as $n):?>
                        <li <?php echo isset($id) && $id == $n['id'] ? 'class="current"' : '' ?>><a href="<?php echo $this->createUrl('index',array_merge($_GET,array('id'=>$n['id'])))?>"><?php echo $n['name']?></a></li>
                    <?php endforeach;?>
                    </ul>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="blank20"></div>
<div class="gw">
    <div class="loupan-wenda-list">
        <?php if(isset($ask) && !empty($ask)): foreach($ask as $v):?>
        <dl>
            <dt class="wen">问：<a href='<?php echo $this->createUrl("detail",array('id'=>$v->id))?>'><?php echo $v->question;?></a></dt>
            <dd class="timeblock">
            <?php if(isset($v->cate->parent) && $v->cate->parent != 0):
                    $parent = AskCateExt::model()->find(array('condition'=>'id=:id','params'=>array(':id'=>$v->cate->parent)));
                ?>
                <?php echo $parent->name?> &gt; <?php echo $v->cate->name?>
            <?php else: ?>
                <?php echo $v->cate ? $v->cate->name : ''?>
            <?php endif;?>
                <span class="time"><?php echo date('Y-m-d H:i',$v->created)?></span>
            </dd>
        </dl>
        <?php endforeach; else: ?>
            未搜索到相关的问题
        <?php endif;?>
    </div>
</div>
<?php $this->widget('WapLinkPager', array('pages'=>$pager));?>
<div class="fc-guwen">
<span>房产顾问团快速帮你解答</span>
<a href="<?php echo $this->createUrl('ask')?>" class="fr">我要咨询</a>
</div>
<div class="gototop">
    <span class="icon icon-goto-top"></span>
</div>
