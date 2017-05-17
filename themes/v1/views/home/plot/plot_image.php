<?php
$this->pageTitle = '新房列表';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/home/style/plot.css');
//js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/main.js', CClientScript::POS_END);
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo $this->siteConfig['siteName']?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo $this->siteConfig['cityName']?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <span><?php echo $this->plot->title;?></span>
        </div>
    </div>
</div>

<?php $this->renderPartial('plot_naver')?>
<div class="wapper" id="imgtop">
    <ul class="huxing-nav clearfix">
        <li><a href="<?php echo $this->createUrl('/home/plot/album',array('py'=>$this->plot->pinyin));?>">全部</a></li>
        <?php
        if(!empty($imgcate)):
            foreach($imgcate as $v):
                if(isset($cate[$v->type])):
                    ?>
                    <li<?php if($pic->type==$v->type):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/album',array('py'=>$this->plot->pinyin,'t'=>$v->type));?>"><?php echo $cate[$v->type];?>(<?php echo $v->count;?>)</a></li>
                <?php
                endif;
            endforeach;
        endif;
        ?>
    </ul>
    <div class="sliders">
        <div class="big-img-box">
            <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset<=0 ? 0 : $offset-1,'pid'=>PlotImgExt::getPrev($list,$pic)));?>#imgtop" class="pre-btn plot-ico"></a>
            <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset+1>=$count ? $count : $offset+1,'pid'=>PlotImgExt::getNext($list,$pic)));?>#imgtop" class="next-btn plot-ico"></a>
            <div class="wall820">
                <a href="<?php echo ImageTools::fixImage($pic->url);?>" target="_blank" class="fr fs16 c-g6 see-btn head-icon">查看原图</a>
                <div class="clear"></div>
                <div class="big-img clearfix">
                    <?php echo CHtml::image(ImageTools::fixImage($pic->url));?>
                </div>
            </div>
            <p><?php echo $pic->title;?></p>
        </div>
        <div class="slider-list pr">
            <ul>
                <?php
                    if(!empty($list)):
                        foreach($list as $k=>$v):
                ?>
                <li<?php if($v->id == $pic->id):?> class="current"<?php endif;?>>
                    <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset-1+$k,'pid'=>$v->id));?>#imgtop"><?php echo CHtml::image(ImageTools::fixImage($v->url,'180','150'));?>
                </li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
            <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset<=0 ? 0 : $offset-1,'pid'=>PlotImgExt::getPrev($list,$pic)));?>#imgtop" class="pre-btn plot-ico"></a>
            <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset+1>=$count ? $count : $offset+1,'pid'=>PlotImgExt::getNext($list,$pic)));?>#imgtop" class="next-btn plot-ico"></a>
        </div>
    </div>


</div>
<?php $this->footer(); ?>
