<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'相册-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">相册</span>
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
                    <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'pid'=>$v->id,'offset'=>PlotImgExt::calculateLb($v->id,$v->hid,$v->type)))?>" target="_blank">
                        <div class="pic">
                            <img data-original="<?php echo ImageTools::fixImage($v->url,'360','270'); ?>">
                            <?php if($v->type==SM::VideoConfig()->videoTag):?>
                                <i class="video-ico"></i>
                            <?php endif;?>
                        </div>
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
