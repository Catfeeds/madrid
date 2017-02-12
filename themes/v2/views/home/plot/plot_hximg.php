<?php
$this->pageTitle = '新房列表';
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
//js
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::GlobalConfig()->siteName()?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <span><?php echo $this->plot->title;?></span></a>
        </div>
    </div>
</div>

<?php $this->renderPartial('plot_naver')?>
<div class="wapper" id="imgtop">
    <ul class="huxing-nav clearfix">
        <li><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin));?>">全部</a></li>
        <?php
        if(!empty($imgcate)):
            foreach($imgcate as $v):
                    if(isset(PlotHouseTypeExt::$room[$v->bedroom]) || $v->bedroom>8):
                    ?>
                    <li<?php if($pic->bedroom==$v->bedroom):?> class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin,'t'=>$v->bedroom));?>"><?php if($v->bedroom>8) $rm = '更多'; else $rm = PlotHouseTypeExt::$room[$v->bedroom];echo $rm;?>(<?php echo $v->count?>)</a></li>
                <?php
                endif;
            endforeach;
        endif;
        ?>
    </ul>
    <div class="sliders">
        <div class="big-img-box">
        <div class="plot-ico tag <?=PlotHouseTypeExt::getSaleStatusPy($pic->sale_status)?>-tag"></div>
            <?php if($offset > 0):?>
            <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'offset'=>$offset <= 0 ? PlotHouseTypeExt::getCount($this->plot->id,$pic->bedroom-1) : $offset-1,'pid'=>$preImg));?>#imgtop" class="pre-btn plot-ico"></a>
            <?php endif;?>
            <?php if($offset < $count):?>
            <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'offset'=>$offset >= $count ? 0 : $offset+1 ,'pid'=>$nextImg));?>#imgtop" class="next-btn plot-ico"></a>
            <?php endif;?>
            <div class="wall820">
                <a href="<?php echo ImageTools::fixImage($pic->image);?>" target="_blank" class="fr fs16 c-g6 see-btn head-icon">查看原图</a>
                <div class="clear"></div>
                <div class="big-img clearfix">
                    <?php echo CHtml::image(ImageTools::fixImage($pic->image));?>
                </div>
            </div>
            <p><?php echo $pic->title;?></p>
        </div>
        <div class="slider-box pr">
            <div class="slider-list">

                <ul>
                    <?php
                    if(!empty($list)):
                        foreach($list as $k=>$v):
                            ?>
                            <li<?php if($v['id'] == $pic->id):?> class="current"<?php endif;?>>
                                <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'offset'=>$v[0],'pid'=>$v['id']));?>#imgtop"><?php echo CHtml::image(ImageTools::fixImage($v['image'],'180','150'));?></a>
                            </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </ul>

                <?php if($offset > 0):?>
                <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'offset'=>$offset <= 0 ? PlotHouseTypeExt::getCount($this->plot->id,$pic->type,$pic->bedroom-1) : $offset-1,'pid'=>$preImg));?>#imgtop" class="pre-btn plot-ico"></a>
            <?php endif;?>
                <?php if($offset < $count):?>
                <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'offset'=>$offset >= $count ? 0 : $offset+1 ,'pid'=>$nextImg));?>#imgtop" class="next-btn plot-ico"></a>
            <?php endif;?>
            </div>
        </div>
    </div>
    <div class="yuyue-box">
        <div class="yuyue-l">
            <ul>
                <li class="li-left"><span class="li-l">居&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室：</span><span class="li-r"><?=$pic['bedroom']?>室<?=$pic['livingroom']?>厅<?=$pic['cookroom']?>厨<?=$pic['bathroom']?>卫</span></li>
                <li>
                    <span class="li-l">参考均价：</span>
                    <span class="li-r">
                    <?=$pic['ave_price']!=0?'<em>'.round($pic['ave_price']).'</em>元/㎡':($this->plot->price!=0?'<em>'.$this->plot->price.'</em>'.PlotPriceExt::$unit[$this->plot->unit]:'待定')?>
                    </span>
                </li>
                <li class="li-left"><span class="li-l">建筑面积：</span><span class="li-r"><em><?=$pic['size']?></em>m²</span></li>
                <li>
                    <span class="li-l">参考总价：</span>
                    <span class="li-r"><?=$pic['price']!=0?'<em>'.$pic['price'].'</em>万元/套':'待定'?></em></span>
                    <a href="" class="calculator-click calculate-loan ui-loan-dialog"><i class="iconfont calculator-ico">&#x3265;</i>房贷计算器</a>
                </li>
                <li class="li-left">
                    <span class="li-l">套内面积：</span>
                    <span class="li-r"><?=$pic['inside_size']!=0?$pic['inside_size']:'-'?> m²</span>
                </li>

            </ul>
        </div>
        <div class="yuyue-r">
            <a href="javascript:;" class="yuyue-btn k-dialog-type-1" data-title="[预约看房]<?=$pic->title; ?>" data-spm="<?=OrderExt::generateSpm('看房团需求', $pic); ?>">预约看房</a>
        </div>
    </div>

</div>
<?php $this->renderPartial('/plot/_calculator', ['id'=>$pic->id]); ?>
<?php $this->footer(); ?>
