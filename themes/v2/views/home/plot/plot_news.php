<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'动态_'.$this->plot->title.'新闻-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'动态，'.$this->plot->title.'新闻','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">资讯</span>
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
