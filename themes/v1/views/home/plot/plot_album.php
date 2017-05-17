<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/home/style/plot.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/main.js', CClientScript::POS_END);
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'相册-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
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
    <ul class="huxing-nav clearfix">
        <li<?php if($t == 0):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/album',array('py'=>$this->plot->pinyin));?>">全部</a></li>
        <?php
        if(!empty($imgcate)):
            foreach($imgcate as $v):
                if(isset($cate[$v->type])):
                    ?>
                    <li<?php if($t==$v->type):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/album',array('py'=>$this->plot->pinyin,'t'=>$v->type));?>"><?php echo $cate[$v->type];?>(<?php echo $v->count;?>)</a></li>
                <?php
                endif;
            endforeach;
        endif;
        ?>
    </ul>
    <ul class="pic-list photo-list">
        <?php
        if(!empty($list)):
            foreach($list as $k=>$v):
                ?>
                <li>
                    <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'pid'=>$v->id,'offset'=>$k))?>" target="_blank">
                        <img data-original="<?php echo ImageTools::fixImage($v->url,'360','270'); ?>">
                        <p><?php echo $v->title!=''?$v->title:$this->plot->title.$cate[$v->type];?></p>
                    </a>
                </li>
            <?php
            endforeach;
        endif;
        ?>
    </ul>
    <div class="page-box fs14 fr text-algin-right">
        <?php $this->widget('HomeLinkPager', array('pages'=>$pager)); ?>
    </div>

</div>
<?php $this->footer(); ?>
