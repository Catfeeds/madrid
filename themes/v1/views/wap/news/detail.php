<?php
$this->pageTitle = $article->title.'_'.$article->cate->name.'_'.$this->siteConfig['cityName'].'房产资讯-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($article->cate->name.'，'.$this->siteConfig['siteName'].'房产，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['cityName'].'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag($article->description ? $article->description : Tools::u8_title_substr(strip_tags($article->content),200),'description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/plot.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['zepto.min','main']);
?>
<header class="ui-title-bar">
    <a href="<?php echo Yii::app()->user->returnUrl;?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1>资讯详情</h1>

    <?php $this->renderPartial('/layouts/nav')?>

</header>
<div class="detail-box">
    <div class="detail-title">
        <h3><?php echo $article->title?></h3>
        <p><?php echo $article->cate->name?> |  <?php echo date('Y-m-d',$article->show_time)?><?php echo $article->source?' |  来源：'.$article->source:''?></p>
    </div>
    <div class="detail-content">
<!--        <p><img src="--><?php //echo ImageTools::fixImage($article->image) ?><!--"></p>-->
        <p><?php echo $article->content?></p>
    </div>
</div>
<div class="gototop">
    <span class="icon icon-goto-top"></span>
</div>
<?php
$wx = $this->beginWidget('WeChat');
$wx->onMenuShareTimeline(ImageTools::fixImage($this->siteConfig['wapWxShareImg']?$this->siteConfig['wapWxShareImg']:$shareImgUrl));
$this->endWidget();
?>
