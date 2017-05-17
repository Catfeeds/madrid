<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-album-detail.css');
?>
<?php $this->renderPartial('plot_search')?>
<div class="wapper xiaoqu-head ovisible">
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title=>$this->createUrl('index',array('py'=>$this->plot->pinyin)),'相册']));?>
    <div class="line"></div>
    <!--  小区名字  -->
    <?php $this->renderPartial('plot_naver')?>
</div>
<div class="main">
    <!--选项-->
    <div class="select">
        <ul class="select-ul">
            <li><a href="<?=$this->createUrl('album',['py'=>$this->plot->pinyin])?>">全部</a></li>
            <?php
            if(!empty($imgcate)):
                foreach($imgcate as $v):
                    if(isset($cate[$v->type])):
            ?>
            <li <?php if($pic->type==$v->type):?> class="active"<?php endif;?>><a href="<?php echo $this->createUrl('/resoldhome/plot/album',array('py'=>$this->plot->pinyin,'t'=>$v->type));?>"><?php echo $cate[$v->type];?>(<?php echo $v->count;?>)</a></li>
            <?php
                    endif;
                endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>

<div class="picFocus">
    <div class="pic-box">
            <div class="prev"><a href="<?php echo $this->createUrl('/resoldhome/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset<=0 ? 0 : $offset-1,'pid'=>PlotImgExt::getPrev($list,$pic)));?>#imgtop"></a></div>
            <ul class="bd">
                <li><a target="_blank" href="#"><?php echo CHtml::image(ImageTools::fixImage($pic->url));?></a></li>

            </ul>
            <div class="next"><a href="<?php echo $this->createUrl('/resoldhome/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset+1>=$count ? $count : $offset+1,'pid'=>PlotImgExt::getNext($list,$pic)));?>#imgtop"></a></a></div>
        </div>

    <div class="title"><?=$pic->title?></div>
    <div class="hd">
            <div class="list-prev"><a href="<?php echo $this->createUrl('/resoldhome/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset<=0 ? 0 : $offset-1,'pid'=>PlotImgExt::getPrev($list,$pic)));?>#imgtop"></a></div>
            <div class="small-img">
                <ul>
                    <?php
                        if(!empty($list)):
                            foreach($list as $k=>$v):
                    ?>
                    <li><a href="<?=$this->createUrl('/resoldhome/plot/image',['py'=>$this->plot->pinyin,'pid'=>$v->id])?>#imgtop"><img src="<?=ImageTools::fixImage($v->url,180,150)?>"/></a></li>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </ul>
            </div>
            <div class="list-next"><a href="<?php echo $this->createUrl('/resoldhome/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset+1>=$count ? $count : $offset+1,'pid'=>PlotImgExt::getNext($list,$pic)));?>#imgtop"></a></div>
        </div>

</div>
<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/resoldhome/js/xiaoqu-album-detail.js');
?>
