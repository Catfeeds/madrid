<?php
$this->pageTitle = $school->name.'_'.$school->name.'邻校房-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($school->name.'_'.$school->name.'邻校房划分','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'为你提供'.$school->name.'邻校房信息，并且根据学校的不同划分出不同学校所属的学校区域楼盘，为你购买'.$school->name.'邻校房提供最准确的邻校房楼盘信息。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/plot.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>
<header class="ui-title-bar">
    <a href="<?php echo Yii::app()->user->returnUrl;?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $school->name?></h1>

    <?php $this->renderPartial('/layouts/nav')?>

</header>
<div class="layer-overall"></div>
    <div class="gw">
        <div class="gcal">共有 <?php echo $pager->getItemCount();?> 个楼盘</div>
        <div class="plot-list">
            <ul>
                <?php foreach($plot as $v):?>
                    <li>
                        <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$v->pinyin))?>">
                            <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image,200,140)?>" alt="" /></div>
                            <div class="info">
                                <h3 class="fs28"><?php echo $v->title?></h3>
                                <p class="right-float c-red"><?php echo PlotPriceExt::getPrice($v->price,$v->unit) ?></p>
                                <p class="gc6"><?php echo (isset($this->siteArea[$v->area])&&!empty($this->siteArea[$v->area])) ? ($this->siteArea[$v->area].((isset($this->siteStreet[$v->area])&&!empty($this->siteStreet[$v->area])) ? ((isset($this->siteStreet[$v->area][$v->street])&&!empty($this->siteStreet[$v->area][$v->street])) ? '/'.$this->siteStreet[$v->area][$v->street] : '') :'' )) : '';?></p>
                                <p class="c-red"><?php echo $v->newDiscount ? Tools::u8_title_substr($v->newDiscount->title,20) : ''?></p>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
