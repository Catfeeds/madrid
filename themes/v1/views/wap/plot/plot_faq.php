<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'问答_'.$this->plot->title.'相关问题-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'问答，'.$this->plot->title.'问题','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
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
<div class="loupanku loupan-wenda gw">
    <div class="simple-button gc6 simple-button-baoming mb30"><p class="text"><span class="gc0d"><?php echo $this->plot->title;?></span> <br><?php echo $this->siteArea[$this->plot->area];?> <?php echo Tools::export($this->plot->streetInfo['name']); ?></p><a href="<?php echo $this->createUrl('/wap/wenda/ask');?>" class="baoming">我要提问</a></div>
    <div class="loupan-wenda-list">
        <?php
            if(!empty($list)):
                foreach($list as $k=>$v):
        ?>
        <dl>
            <a href="<?php echo $this->createUrl('/wap/wenda/detail',array('id'=>$v->id));?>">
                <dt class="wen">问：<?php echo $v->question;?></dt>
                <dd class="da">答：<?php echo $v->answer;?></dd>
                <dd class="timeblock">
                    <?php
                    if(isset($askcate[$v->cid]) && isset($askcate[$askcate[$v->cid]['parent']])){
                        echo $askcate[$askcate[$v->cid]['parent']]['name'].' &gt; ';
                    }
                    ?>
                    <?php echo isset($askcate[$v->cid])?$askcate[$v->cid]['name']:'';?>
                    <span class="time">
                        <?php echo date('Y-m-d G:i',$v->created);?>
                    </span>
                </dd>
            </a>
        </dl>
        <?php
                endforeach;
            endif;
        ?>
    </div>
</div>
<?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
