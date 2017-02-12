<?php
 Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js', CClientScript::POS_END);
 Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js', CClientScript::POS_END);
 Yii::app()->clientScript->registerCssFile('/static/home/style/plot.css');
$artcate = '';
foreach($cate as $v){
    if($v->id == $id){
        $artcate = $v->name;
    }
}
$this->pageTitle =($artcate ? $artcate : '房产资讯').'_'.$this->siteConfig['cityName'].'房产网_'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag(($artcate ? $artcate : '房产资讯').'，'.$this->siteConfig['siteName'].'房产，'.$this->siteConfig['cityName'].'房产网','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');
if(isset($id) && !empty($id)){
    foreach($cate as $v){
        if($v->id == $id){
            $this->breadcrumbs = array($this->siteConfig['cityName'].'房产资讯'=>$this->createUrl('index'),$v->name);
        }
    }
}else{
    $this->breadcrumbs = array($this->siteConfig['cityName'].'房产资讯');
}

?>
<div class="blank5"></div>
<?php $this->widget('AdWidget',['position'=>'zxsb']); ?>
<div class="wapper">
    <div class="plot-nav">
        <ul>
            <li <?php if(!isset($id) || empty($id)) { ?> class="current" <?php } ?> ><a href="<?php echo $this->createUrl('index') ?>">全部资讯</a></li>
            <?php foreach($cate as $v){ ?>
            <li <?php if($v->id == $id){ ?> class="current" <?php } ?>><a href="<?php echo $this->createUrl('index',array('cateid'=>$v->id)) ?>"><?php echo $v->name?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="wapper">
    <div class="plot-detail-l">
       <ul class="plot-news-list">
           <?php foreach($article as $v):?>
           <li <?php if(isset($v->image)&&!empty($v->image)){ ?> class="clearfix has-img" <?php }else{ ?> class="clearfix" <?php }?> >
               <div class="news-list-l">
                   <h2 class="clearfix">
                       <a href="<?php if(isset($v->url) && !empty($v->url)){ echo $v->url; }else{ echo $this->createUrl('detail',array('articleid'=>$v->id)); }?>" target="_blank" title="<?php echo $v->title; ?>"><?php if(isset($v->image)&&!empty($v->image)){ echo Tools::u8_title_substr($v->title,40); }else{ echo Tools::u8_title_substr($v->title,120); } ?></a>
                   </h2>
                   <p><?php $desc = ($v->description ? Tools::u8_title_substr($v->description,empty($v->image)?330:250) : Tools::u8_title_substr(strip_tags($v->content),empty($v->image)?330:250));echo strip_tags(html_entity_decode($desc)); ?><a href="<?php echo isset($v->url)&&!empty($v->url) ? $v->url : $this->createUrl('detail',array('articleid'=>$v->id)); ?>" target="_blank" class="c-sred">[详情]</a>
                   </p>
                   <p>发布于 <?php echo Tools::friendlyDate($v->show_time)?></p>
               </div>
               <?php if(isset($v->image)&&!empty($v->image)):?>
                <div class="news-list-r">
                    <a href="<?php if(isset($v->url) && !empty($v->url)){ echo $v->url; }else{ echo $this->createUrl('detail',array('articleid'=>$v->id)); } ?>" target="_blank"><img data-original="<?php echo ImageTools::fixImage($v->image,200,150) ?>"></a>
                </div>
               <?php endif;?>
           </li>
           <?php endforeach; ?>
       </ul>
        <div class="blank10"></div>
        <div class="page-box fs14 fr text-algin-right">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
        </div>
        <div class="blank20"></div>
    </div>
    <div class="plot-detail-r">
        <div class="blank15"></div>
        <?php $this->widget('AdWidget',['position'=>'zxycbanner']); ?>
        <div class="gray-bg p10">
            <div class="mod-tuangou ui-mouseenter">
                <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
            </div>
        </div>
    </div>
</div>
