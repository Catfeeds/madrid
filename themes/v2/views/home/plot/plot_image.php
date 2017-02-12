<?php
$this->pageTitle = '新房列表';
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
Yii::app()->clientScript->registerCssFile('/static/global/plugins/mediaelement/build/mediaelementplayer.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/mediaelement/build/jquery.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/mediaelement/build/mediaelement-and-player.js',CClientScript::POS_HEAD);
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::GlobalConfig()->siteName()?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">相册</span>
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
                    <?php if(!$video=$pic->getPlotVideo()){
                        echo CHtml::image(ImageTools::fixImage($pic->url));
                    }else{
                    ?>
                    <div style="width: 800px; height: 500px;margin-left: 89px; ">
                    <video width="800" height="500" poster="<?php echo ImageTools::fixImage($video->img)?>" controls="controls" preload="none">
                        <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
                        <source type="video/mp4" src="<?php echo ImageTools::fixImage($video->mp_url);?>" />
                        <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
                        <object width="800" height="500" type="application/x-shockwave-flash" data="/static/global/plugins/mediaelement/build/flashmediaelement.swf">
                            <param name="movie" value="/static/global/plugins/mediaelement/build/flashmediaelement.swf" />
                            <param name="flashvars" value="controls=true&file=<?php echo ImageTools::fixImage($video->flv_url);?>" />
                            <!-- Image as a last resort -->
                            <img src="<?php echo ImageTools::fixImage($video->img)?>" width="800" height="500" title="No video playback capabilities" />
                        </object>
                    </video>
                    </div>
                    <?php }?>
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
                    <a href="<?php echo $this->createUrl('/home/plot/image',array('py'=>$this->plot->pinyin,'offset'=>$offset<=0?$offset+$k:$offset-1+$k,'pid'=>$v->id));?>#imgtop"><?php echo CHtml::image(ImageTools::fixImage($v->url,'180','150'));?>
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
<script>
    $('video,audio').mediaelementplayer({
        // initial volume when the player starts
        startVolume: 0.8,
        // enables Flash and Silverlight to resize to content size
        enableAutosize: true,
        // the order of controls you want on the control bar (and other plugins below)
        features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
        // force iPad's native controls
        iPadUseNativeControls: false,
        // force iPhone's native controls
        iPhoneUseNativeControls: false,
        // force Android's native controls
        AndroidUseNativeControls: false,
        // turns keyboard support on and off for this instance
        enableKeyboard: true,
        // when this player starts, it will pause other players
        pauseOtherPlayers: true,
    });
</script>
