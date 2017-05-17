<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'相册-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css');
Yii::app()->clientScript->registerCssFile('/static/global/plugins/mediaelement/build/mediaelementplayer.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/mediaelement/build/jquery.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/mediaelement/build/mediaelement-and-player.js',CClientScript::POS_HEAD);
?>

<video width="100%" height="100%" poster="<?php echo ImageTools::fixImage($video->img)?>" controls="controls" preload="none">
    <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
    <source type="video/mp4" src="<?php echo ImageTools::fixImage($video->mp_url);?>" />
    <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
    <object width="100%" height="100%" type="application/x-shockwave-flash" data="/static/global/plugins/mediaelement/build/flashmediaelement.swf">
        <param name="movie" value="/static/global/plugins/mediaelement/build/flashmediaelement.swf" />
        <param name="flashvars" value="controls=true&file=<?php echo ImageTools::fixImage($video->flv_url);?>" />
        <!-- Image as a last resort -->
        <img src="<?php echo ImageTools::fixImage($video->img)?>" width="800" height="500" title="No video playback capabilities" />
    </object>
</video>

<script>
    $('video').mediaelementplayer({
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