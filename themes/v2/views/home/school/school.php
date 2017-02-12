<?php
 Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/xuequ.css');
 $this->pageTitle = $school->name.'_'.$school->name.'邻校房-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
 Yii::app()->clientScript->registerMetaTag($school->name.'_'.$school->name.'邻校房划分','keywords');
 Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'为你提供'.$school->name.'邻校房信息，并且根据学校的不同划分出不同学校所属的学校区域楼盘，为你购买'.$school->name.'邻校房提供最准确的邻校房楼盘信息。','description');
 $this->breadcrumbs = array(SM::urmConfig()->cityName().'邻校房'=>$this->createUrl('index'),$school->areaInfo->name.'邻校房'=>$this->createUrl('area',array('id'=>$school->areaInfo->id)), $school->name.'邻校房');
?>
<div class="blank15"></div>
 <?php $this->renderPartial('_nav'); ?>
<div class="blank15"></div>
<div class="wapper">
    <div class="school-info">
        <dl>
            <dt><a href=""><img data-original="<?php echo ImageTools::fixImage($school->image,240,180) ?>" > </a></dt>
            <dd>
                <span class="fr fs14 c-g6">共有<em class="fs20 c-red"><?php echo $school->plotNum ?></em>个邻校房</span>
                <h3 class="fs20"><?php echo $school->name ?><?php if ($school->important): ?><span class="fs14 ml10">重点</span><?php endif; ?></h3>
                <ul class="fs14">
                    <li><span>区域</span><?php echo $school->areaInfo->name ?></li>
                    <li><span>地址</span><?php echo $school->address ?></li>
                    <li><span>电话</span><?php echo $school->phone ?></li>
                    <li><span>范围</span><?php echo $school->scope ?></li>
                </ul>
            </dd>
        </dl>
        <div class="blank10"></div>
        <div class="detail fs14 limit">
            <p><?php echo $school->description ?></p>
        </div>
        <span class="more fr c-g6 mr10 mt10">更多</span>
        <div class="blank20"></div>
        <p class="fs20">校园风采</p>
        <div class="blank20"></div>
        <ul class="fengcai clearfix">
            <?php foreach ($school->pic as $key => $v):
                if ($key < 3):
            ?>
                <li><img data-original="<?php echo ImageTools::fixImage($v,240,180) ?>"></li>
            <?php
                    endif;
                endforeach;
            ?>
        </ul>
    </div>
    <div class="school-map"><iframe src="<?php echo $this->createUrl('/home/map/mapSchool',array('id'=>$school->id))?>" width="305" height="215" frameborder="0"></iframe></div>
</div>
<div class="blank20"></div>
<div class="wapper">
    <div class="plot-list">
        <p class="fs20 mb10">邻校楼盘</p>
        <?php foreach($plots as $distance=>$v):
                if(empty($v)) continue;
                    foreach($v as $k=>$plotRel):
                        if(isset($plotRel->plot) && !empty($plotRel->plot)):
                        if($k==0):
        ?>
        <div class="juli clearfix fs14"><span class="left-arrow"></span><span class="long"><?php echo $distance;?></span></div>
        <?php endif; ?>
        <div class="clear"></div>
        <ul class="item-list">
            <li class="item clearfix">
                <div class="pic fl">
                    <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plotRel->plot->pinyin))?>" target="_blank"><img data-original="<?php echo ImageTools::fixImage($plotRel->plot->image,240,180) ?>" alt="" ></a>
                </div>
                <div class="content fl">
                    <div class="title">
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plotRel->plot->pinyin))?>" target="_blank" class="c-g3"><?php echo $plotRel->plot->title ?></a>
                        <?php if($plotRel->plot->xszt): ?>
                        <span class="lpstate">
                            <i class="state state-<?php echo $plotRel->plot->xszt->id;?>"></i><?php echo $plotRel->plot->xszt->name; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="price">
                        <p class="r1">
                            <span class="k-em-2"><?php echo PlotPriceExt::getPrice($plotRel->plot->price,$plotRel->plot->unit)?></span>
                        </p>
                        <p class="r2">距此<span class="k-em-2"><?php echo $plotRel->distance ?>米</span></p>
                    </div>
                    <?php if($plotRel->plot->newDiscount):?>
                        <p class="short-tips"><?php echo Tools::u8_title_substr($plotRel->plot->newDiscount->title,55);?></p>
                    <?php endif;?>
                    <?php if($plotRel->plot->address):?>
                        <p class="address"><?php echo $plotRel->plot->address;?></p>
                    <?php endif;?>
                    <p class="area"><?php echo $plotRel->plot->areaInfo ? $plotRel->plot->areaInfo->name.'/' : '' ?><?php echo $plotRel->plot->streetInfo ? $plotRel->plot->streetInfo->name : '' ?><!--<a class="jjmap">街景</a>--></p>
                    <?php if($plotRel->plot->sale_tel):?>
                        <p class="phone"><?php echo $plotRel->plot->sale_tel;?></p>
                    <?php endif;?>
                    <p class="tags">
                        <?php foreach ($plotRel->plot->xmts as $v): ?>
                            <a href="<?php echo $this->createUrl('/home/plot/list',array('ext'=>'t'.$v->id))?>"><?php echo $v->name ?></a>
                        <?php endforeach; ?>
                    </p>
                </div>
            </li>
        </ul>
        <div class="blank15"></div>
        <?php
                endif;
                endforeach;
            endforeach;
        ?>
    </div>
    <div class="tuangou">
        <div class="gray-bg p10">
            <div class="mod-tuangou ui-mouseenter">
                <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
            </div>
        </div>
    </div>
</div>
