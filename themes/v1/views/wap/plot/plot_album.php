<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'相册-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['iscroll-lite','jquery-2.1.4.min','scroll','TouchSlide.1.1','main','swipeSlide.min']);
?>
<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$this->plot->pinyin));?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $this->plot->title;?></h1>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<!--头部 end-->
<div class="loupanku loupan-pic-block gw">
    <div id="wrapper">
        <div class="nav" id="scroller">
            <ul>
                <?php
                    if(!empty($imgcate)):
                        foreach($imgcate as $v):
                ?>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/plot/album',array('py'=>$this->plot->pinyin,'type'=>$v->type))?>" <?php if($type == $v->type):?>class='on'<?php endif;?>>
                        <?php echo $cate[$v->type];?>
                    </a>
                </li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
        </div>
    </div>
    <div class="img-list" id="j-touchslide">
        <ul class="bd">
            <?php
                if(!empty($list)):
                    foreach($list as $v):
            ?>
            <li>
                <div class="pic">
                    <?php echo CHtml::image(ImageTools::fixImage($v->url,'600'));?>
                </div>
                <div class="title">
                    <?php echo $v->title;?>
                    <?php if($v->size>0):?>
                        <?php echo $v->size;?>m<sup>2</sup>
                    <?php endif;?>
                </div>
            </li>
            <?php
                    endforeach;
                endif;
            ?>
        </ul>
    </div>
    <div class="calnum" id="j-calnum"></div>
</div>
<!--回到顶部 end-->
<div class="blank80"></div>
<script>
    <?php Tools::startJs(); ?>
    TouchSlide({slideCell:'j-touchslide',startFun:function(i,c){
        $('#j-calnum').text('<?php echo $cate[$type];?>'+ (i+1) +'/' + c);
    }});
    <?php Tools::endJs('js'); ?>
</script>
