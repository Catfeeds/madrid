<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-album.css');
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
?>
<div class="wrap">
    <?php $this->renderPartial('plot_search')?>
    <div class="wapper xiaoqu-head ovisible">
        <?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title=>$this->createUrl('index',array('py'=>$this->plot->pinyin)),'相册']));?>
        <div class="line"></div>
        <!--  小区名字  -->
        <!--  tab选项卡  -->
        <?php $this->renderPartial('plot_naver')?>
    </div>
    <div class="wrap">
        <div class="wapper">
        <!--选项-->
        <div class="select">
            <ul class="select-ul">
                <li <?php if($t==0):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('/resoldhome/plot/album',array('py'=>$this->plot->pinyin))?>">全部</a></li>
                <?php
                    if($imgcate):
                        foreach($imgcate as $key=>$value):
                            if(isset($cate[$value->type]) && $value->tag->status!=0):
                ?>
                <li <?php if($t==$value->type):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('/resoldhome/plot/album',array('py'=>$this->plot->pinyin,'t'=>$value->type))?>"><?php echo $cate[$value->type]?>(<?=$value->count?>)</a></li>
                <?php
                            endif;
                        endforeach;
                    endif;
                ?>
            </ul>
        </div>

        <!--  小区图册  -->
        <div class="house-list house-img">
            <?php
                if($list):
                    foreach($list as $k=>$v):
            ?>
            <?php if($v->tag && $v->tag->status!=0):?>
            <div class="list-box <?php if(($k+1)%3==0):?>last-list-box<?php endif;?>">

                <a href="<?=$this->createUrl('image',['py'=>$this->plot->pinyin,'pid'=>$v->id])?>">
                    <img src="<?=ImageTools::fixImage($v->url,'360','270')?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="图片">
                </a>
                <p><?php echo $v->title!=''?$v->title:$this->plot->title.$cate[$v->type];?></p>
            </div>
        <?php endif;?>
            <?php
                    endforeach;
                endif;
            ?>

        </div>
    </div>
</div>
<div class="blank20"></div>
<div class="page-box">
    <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
</div>
