<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/home/style/plot.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/main.js', CClientScript::POS_END);
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'动态_'.$this->plot->title.'新闻-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'动态，'.$this->plot->title.'新闻','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo $this->siteConfig['cityName'].'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo $this->siteConfig['cityName']?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <span><?php echo $this->plot->title;?></span>
        </div>
    </div>
</div>
<?php $this->renderPartial('plot_naver')?>
<div class="wapper">
<div class="plot-detail-l">
    <ul class="plot-news-list">
        <?php
            if(!empty($list)):
                foreach($list as $v):
        ?>
        <li <?php if(isset($v->image)&&!empty($v->image)){ ?> class="clearfix has-img" <?php }else{ ?> class="clearfix" <?php }?>>
            <div class="news-list-l">
                <h2 class="clearfix">
                    <span class="red-tag"><?php echo $v->cate->name?></span>
                    <a href="<?php if(isset($v->url) && !empty($v->url)){ echo $v->url; }else{ echo $this->createUrl('/home/news/detail',array('articleid'=>$v->id)); }?>" target="_blank"><?php if(isset($v->image)&&!empty($v->image)){ echo Tools::utf8substr($v->title,0,60); }else{ echo Tools::utf8substr($v->title,0,120); } ?></a>
                </h2>
                <p><?php echo ($v->description ? Tools::u8_title_substr($v->description,empty($v->image)?330:250) : Tools::u8_title_substr(strip_tags($v->content),empty($v->image)?330:250)) ?><a href="<?php echo isset($v->url)&&!empty($v->url) ? $v->url : $this->createUrl('/home/news/detail',array('articleid'=>$v->id)); ?>" target="_blank" class="c-sred">[详情]</a></p>
                <p>发布于 <?php echo Tools::friendlyDate($v->show_time)?></p>
            </div>
            <?php if(isset($v->image)&&!empty($v->image)):?>
                <div class="news-list-r">
                    <a href="<?php if(isset($v->url) && !empty($v->url)){ echo $v->url; }else{ echo $this->createUrl('/home/news/detail',array('articleid'=>$v->id)); } ?>" target="_blank"><img src=<?php echo ImageTools::fixImage($v->image,200,150) ?>></a>
                </div>
            <?php endif;?>
        </li>
        <?php
                endforeach;
            endif;
        ?>
    </ul>
    <div class="blank10"></div>
    <div class="page-box fs14 fr text-algin-right">
        <?php $this->widget('HomeLinkPager', array('pages'=>$pager)); ?>
    </div>
    <div class="blank20"></div>
</div>
<div class="plot-detail-r">
    <div class="blank15"></div>
    <div class="gray-bg p10">
        <div class="mod-tuangou ui-mouseenter">
            <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
        </div>
    </div>
</div>
</div>
<?php $this->footer(); ?>
