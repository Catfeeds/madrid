<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/home/style/plot.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/main.js', CClientScript::POS_END);
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'价格_'.$this->plot->title.'价格走势-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'价格，'.$this->plot->title.'价格走势', 'keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].$this->siteConfig['cityName'].'房产网。', 'description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo $this->siteConfig['cityName'].'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo $this->siteConfig['cityName']?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list', array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <span><?php echo $this->plot->title;?></span>
        </div>
    </div>
</div>

<?php $this->renderPartial('plot_naver')?>

<div class="wapper">
    <div class="plot-detail-l">
        <div class="piece-box"
                data-plot-name="<?php echo $this->plot->title?>"
                data-area-name="<?php echo $this->siteArea[$this->plot->area];?>"
                data-city-name="<?php echo $this->siteConfig['cityName'];?>"
                data-month="<?php echo implode(',', $priceTrend->date); ?>"
                data-plot="<?php echo implode(',', $priceTrend->plotPriceList); ?>"
                data-area="<?php echo implode(',', $priceTrend->areaPriceList); ?>"
                data-city="<?php echo implode(',', $priceTrend->cityPriceList); ?>"
        >

        </div>
        <div class="trend-data" js="clearSonAttr">
            <dl>
                <dt>
                    <span class="blue-square"></span><?php echo $this->plot->title;?>价格
                </dt>
                <dd>
                    <strong>
                        <?php echo round($this->plot->price);?><span><?php echo PlotPriceExt::$unit[$this->plot->unit]?></span>
                    </strong>
                    <em class="c-red">
                        <?php echo $priceTrend->plotPriceMark[2]; ?>
                    </em>
                    <em class="c-g6"> <?php echo $priceTrend->plotPriceMark[1]; ?>% </em>
                </dd>
            </dl>
            <dl>
                <dt>
                    <span class="green-square"></span><?php echo $this->siteConfig['cityName']; ?>新房均价
                </dt>
                <dd>
                    <strong>
                        <?php echo round($priceTrend->cityPriceMark[0]);?><span>元/m<sup>2</sup></span>
                    </strong>
                    <em class="c-red">
                        <?php echo $priceTrend->cityPriceMark[2]; ?>
                    </em>
                    <em class="c-g6"> <?php echo $priceTrend->cityPriceMark[1]; ?>% </em>
                </dd>
            </dl>
            <dl style="border: none;">
                <dt>
                    <span class="pink-square"></span><?php echo $this->siteArea[$this->plot->area];?>新房价格
                </dt>
                <dd>
                    <strong>
                        <?php echo round($priceTrend->areaPriceMark[0]) ;?><span>元/m<sup>2</sup></span>
                    </strong>
                    <em class="c-red">
                        <?php echo $priceTrend->areaPriceMark[2]; ?>
                    </em>
                    <em class="c-g6"> <?php echo $priceTrend->areaPriceMark[1]; ?>% </em>
                </dd>
            </dl>

        </div>
        <div class="title-box">
            <h2>历史记录</h2>
        </div>
        <table class="history-tb" width="100%">
            <tr>
                <th width="15%">时间</th>
                <th width="30%">价格</th>
                <th width="55%">说明</th>
            </tr>
            <?php
                if (!empty($list)):
                    foreach ($list as $k=>$v):
            ?>
            <tr class="<?php if ($k%2==0):?>has-bg<?php endif;?><?php if ((count($list)-$k)==1):?> last<?php endif;?>">
                <td class="fs16"><?php echo Tools::friendlyDate($v->created)?></td>
                <td class="fs16">
                    <?php echo PlotPriceExt::$mark[$v->mark];?> ￥<?php echo $v->price?><?php echo PlotPriceExt::$unit[$v->unit]?>
                    （<?php echo $jglb[$v->jglb]; ?>）
                </td>
                <td><?php echo $v->description; ?></td>
            </tr>
            <?php
                    endforeach;
                endif;
            ?>
        </table>
    </div>

    <div class="plot-detail-r">
        <div class="gray-bg p10">
            <div class="mod-tuangou ui-mouseenter">
                <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->footer(); ?>
