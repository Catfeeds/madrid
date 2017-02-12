<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'价格_'.$this->plot->title.'价格走势-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'价格，'.$this->plot->title.'价格走势','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main','highcharts/highcharts.min','chart']);
?>

<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$this->plot->pinyin));?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $this->plot->title;?></h1>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<!--头部 end-->
<!--楼盘库首页-->
<div class="loupanku loupan-dongtai gw">
    <div class="loupan-dongtai-map price-box"
        data-plot-name="<?php echo $this->plot->title?>"
        data-area-name="<?php echo $this->siteArea[$this->plot->area];?>"
        data-city-name="<?php echo $this->siteConfig['cityName'];?>"
        data-month="<?php echo implode(',', $priceTrend->date); ?>"
        data-plot="<?php echo implode(',', $priceTrend->plotPriceList); ?>"
        data-area="<?php echo implode(',', $priceTrend->areaPriceList); ?>"
        data-city="<?php echo implode(',', $priceTrend->cityPriceList); ?>">
    </div>
    <div class="price">
        <ul class="row">
            <li class="lp">
                <h3>楼盘价格</h3>
                <p class="unit"><?php echo $this->plot->price; ?><span><?php echo PlotPriceExt::$unit[$this->plot->unit]?></p>
                <p class="state"><?php echo $priceTrend->plotPriceMark[2]; ?><span class="num"><?php echo $priceTrend->plotPriceMark[1]; ?>%</span></p>
            </li>
            <li class="ap">
                <h3>区域价格</h3>
                <p class="unit"><?php echo $priceTrend->areaPriceMark[0];?>元/m<sup>2</sup></p>
                <p class="state"><?php echo $priceTrend->areaPriceMark[2]; ?><span class="num"><?php echo $priceTrend->areaPriceMark[1]; ?>%</span></p>
            </li>
            <li class="cp">
                <h3>城市价格</h3>
                <p class="unit"><?php echo $priceTrend->cityPriceMark[0]; ?>元/m<sup>2</sup></p>
                <p class="state"><?php echo $priceTrend->cityPriceMark[2]; ?><span class="num"><?php echo $priceTrend->cityPriceMark[1]; ?>%</span></p>
            </li>
        </ul>
    </div>
    <div class="simple-button gc6 simple-button-baoming mb30"><p class="text"><span class="gc0d">项目介绍</span> <br>降价通知，快人一步</p><a href="<?php echo $this->createUrl('/wap/order/form',array('spm'=>OrderExt::generateSpm('优惠通知', $this->plot),'title'=>$this->plot->title))?>" class="baoming">降价通知</a></div>
    <div class="loupan-dongtai-list">
        <ul>
            <?php $this->actionAddPrice($this->plot->id);?>
            <?php if(PlotPriceExt::model()->count('hid='.$this->plot->id) >= 4):?>
                <div class="addmore" data-hid="<?php echo $this->plot->id; ?>">
                    <a href="javascript:;">加载更多</a>
                </div>
            <?php endif; ?>
        </ul>
    </div>
    <a href="<?php echo $this->createUrl('/wap/plot/news',array('py'=>$this->plot->pinyin));?>" class="simple-button gc6 simple-button-arrow mt20"><p class="text">相关导购资讯</p><i class="icon icon-sright-arrow"></i></a>
</div>
<!--回到顶部 begin-->
<div class="gototop icon icon-goto-top"></div>
<!--回到顶部 end-->
<div class="blank80"></div>
<script>
    <?php Tools::startJs();?>
    var page=1;
    $('.addmore').click(function(){
        page++;
        var hid = $(this).data('hid');
        var obj = $(this);
        $.get("<?php echo $this->createUrl('/wap/plot/addPrice'); ?>",
            {
                hid:hid,
                page:page
            },
            function(data){
                if(data.length<=0) {
                    obj.hide();
                }
                obj.prev().after(data);
            },
            'html'
        );
    });
    <?php Tools::endJs('js');?>
</script>
