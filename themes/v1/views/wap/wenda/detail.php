<?php
$this->pageTitle = $ask->question.'_'.$this->siteConfig['cityName'].'房产问答-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag(($ask->cate ? $ask->cate->name : '').'，'.$this->siteConfig['cityName'].'房产问答，'.$this->siteConfig['cityName'].'买房问题','keywords');
Yii::app()->clientScript->registerMetaTag(Tools::u8_title_substr($ask->answer,200),'description');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/qa.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>
<header class="ui-title-bar">

    <a href="<?php echo Yii::app()->request->getUrlReferrer();?>" class="back"><i class="icon icon-black-arrow"></i></a>

    <h1>问答</h1>
    <div class="fr ui-operate layer-sub-btn down"><p class="icon icon-guide"></p><p>导航</p></div>
<?php $this->renderPartial('/layouts/nav')?>
    <div class="layer-subnav-bg"></div>
</header>
<div  class="ui-search-box pr">
    <div class="ui-search">
        <form action="<?php echo $this->createUrl('index')?>"  method="post">
            <div class="ui-search-r"><input type="submit" class="ui-search-btn" value="搜索"></div>
            <div class="ui-search-l"><i class="icon icon-search"></i><input class="ui-search-text" type="search" name="kw" placeholder="输入您要找的问题" value=""></div>
        </form>
    </div>
</div>

<div class="gw">
    <div class="loupan-wenda-list">
        <dl>
            <dt class="wen">问：<?php echo $ask->question?></dt>
            <?php if($ask->cate): ?>
            <dd class="timeblock"><?php if(isset($ask->cate->parent) && $ask->cate->parent != 0){ $parentcate = AskCateExt::model()->find(array('condition'=>'id = :id','params'=>array(':id'=>$ask->cate->parent)))?> <?php echo $parentcate->name?> &gt; <?php echo $ask->cate->name?> <?php }else{?> <?php echo $ask->cate->name?> <?php }?><?php endif; ?> <span class="time"><?php echo date('Y-m-d H:i',$ask->created)?></span></dd>
            <dd class="da">答：<?php echo strip_tags($ask->answer); ?></dd>
        </dl>

    </div>
</div>

<div class="fc-guwen">
<span>房产顾问团快速帮你解答</span>
<a href="<?php echo $this->createUrl('ask')?>" class="fr">我要咨询</a>
</div>
<div class="gototop">
    <span class="icon icon-goto-top"></span>
</div>
