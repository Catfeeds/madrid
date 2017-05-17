<?php
Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js',  CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/home/style/xuequ.css');
$this->pageTitle = $this->siteConfig['cityName'].date('Y').'邻校房_'.$this->siteConfig['cityName'].'学校区域划分_邻校房购买指南-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'邻校房，'.$this->siteConfig['cityName'].'邻校房划分，'.date('Y').$this->siteConfig['cityName'].'邻校房','keywords');
$areas = '';
$i = 0;
foreach($this->siteArea as $v)
{
    $i++;
    if($i < count($this->siteArea)){
        $areas .= $v.'、';
    }else{
        $areas .= $v;
    }
}
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'为你提供'.date('Y').$this->siteConfig['cityName'].'邻校房划分信息，以及最全面的'.$this->siteConfig['cityName'].'邻校房信息，还有'.$areas.'等各城区的学区信息。','description');
$this->breadcrumbs = array($this->siteConfig['cityName'].'邻校房');
?>
<div class="blank15"></div>
<?php $this->renderPartial('_nav'); ?>
<?php foreach ($this->area as $v){?>
<div class="blank15"></div>
<div class="wapper">
    <div class="title-box">
        <h2><?php echo $v->areaInfo->name?></h2>
    </div>
    <div class="line"></div>
    <div class="blank15"></div>
    <div class="list-left fl">
        <div class="school-list">
            <div class="tit-t clearfix">
                <a target="_blank" href="<?php echo $this->createUrl('/home/school/area',array('id'=>$v->area))?>" class="fr c-g3">更多</a>
                <span class="fl fs18 c-g3"><?php echo $v->areaInfo->name?>小学</span>
            </div>
            <div class="blank15"></div>
            <ul class="fs14">
                <?php foreach ($v->areaInfo->xxschool as $n){ ?>
                <li><a target="_blank" href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$n->pinyin))?>" class="c-g3"><?php echo $n->name?></a><span class="fr">共<?php echo $n->plotNum?>个楼盘</span></li>
                <?php } ?>
            </ul>
        </div>
        <div class="school-list">
            <div class="tit-t clearfix">
                <a target="_blank" href="<?php echo $this->createUrl('/home/school/area',array('id'=>$v->area))?>" class="fr c-g3">更多</a>
                <span class="fl fs18 c-g3"><?php echo $v->areaInfo->name?>中学</span>
            </div>
            <div class="blank15"></div>
            <ul class="fs14">
                <?php foreach($v->areaInfo->zxschool as $n){ ?>
                    <li><a target="_blank" href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$n->pinyin))?>" class="c-g3"><?php echo $n->name?></a><span class="fr">共<?php echo $n->plotNum?>个楼盘</span></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="list-right">
        <div class="tit-t clearfix">
            <a target="_blank" href="<?php echo $this->createUrl('/home/school/area',array('id'=>$v->area))?>" class="fr c-g3">更多</a>
            <span class="fl fs18 c-g3"><?php echo $v->areaInfo->name?>重点学校</span>
        </div>
        <div class="blank15"></div>
        <ul class="clearfix fs14">
            <?php foreach($v->areaInfo->zdschool as $n){ ?>
                <li><a target="_blank" href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$n->pinyin))?>" class="c-g3"><img data-original="<?php echo ImageTools::fixImage($n->image,160,120) ?>" ><?php echo Tools::u8_title_substr($n->name,15);?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="blank15"></div>
    <div class="tuijian">
        <p class="fs18"><?php echo $v->areaInfo->name?>邻校房推荐</p>
        <div class="blank15"></div>
        <ul class="pic-list more-pic">
            <?php foreach(RecomExt::model()->getRecom('xqftj')->getByPlotArea($v->area)->findAll(['limit'=>4]) as $vv): ?>
                <li><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$vv->plot->pinyin));?>" target="_blank"><img data-original="<?php echo $vv->image ? ImageTools::fixImage($vv->image,270,200) : ImageTools::fixImage($vv->plot->image,270,200); ?>" ><p><?php echo $vv->plot->title?><span class="fr fs14 c-g6"><?php echo PlotPriceExt::getPrice($vv->plot->price,$vv->plot->unit) ?></span></p><p class="c-red"><?php echo $vv->plot->newDiscount ? $vv->plot->newDiscount->title : ''?></p></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php } ?>
