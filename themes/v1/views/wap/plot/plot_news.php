<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'动态_'.$this->plot->title.'新闻-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'动态，'.$this->plot->title.'新闻','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/wap/js/TouchSlide.1.1.js', CClientScript::POS_END);
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>

<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$this->plot->pinyin));?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $this->plot->title;?></h1>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<!--头部 end-->
<div class="blank20"></div>
<!--楼盘资讯 begin-->
<div class="gw">
    <div class="plot-list">
        <ul>
            <?php
                if(!empty($list)):
                    foreach($list as $v):
            ?>
            <li>
                <a href="<?php echo $this->createUrl('/wap/news/detail',array('id'=>$v->article->id))?>">
                    <div class="pic"><?php echo CHtml::image(ImageTools::fixImage($v->article->image,'200','140'));?></div>
                    <div class="info">
                        <h3 class="fs28 pt10 lineh40"><?php echo Tools::u8_title_substr($v->article->title,40);?></h3>
                        <p class="gc9"><?php echo isset($artcate[$v->article->cid])?$artcate[$v->article->cid]['name']:''?><span class="ml10 mr10">|</span><?php echo date('Y-m-d',$v->article->show_time);?></p>
                    </div>
                </a>
            </li>
            <?php endforeach; else:?>
                    <li>暂无此楼盘的相关导购资讯！</li>
            <?php endif;?>
        </ul>
    </div>
</div>
<!--楼盘资讯 end-->
<!--分页 begin-->
<?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
<!--分页 end-->
