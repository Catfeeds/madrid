<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'户型详情-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'户型详情','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
<div class="content-box">
    <div class=" top-mark"></div>
    <?php $this->renderPartial('/layouts/header',['search'=>false]); ?>
    <img src="<?php echo ImageTools::fixImage($huxing->image,640,480); ?>">
    <div class=" bottom-mark"></div>
</div>
<div class="content-box">

    <ul class="house-detail-info type-detail">
        <li><i class="iconfont">&#x1010;</i>户型：<span><?php echo $huxing->bedroom.'室'.$huxing->livingroom.'厅'.$huxing->bathroom.'卫'; ?></span></li>
        <li><i class="iconfont">&#x1005;</i>面积：<span><?php echo $huxing->size; ?>㎡</span></li>
        <li><i class="iconfont">&#x1011;</i>参考价：<em><?php echo $huxing->price>0?$huxing->price.'万':'暂无'; ?></em></li>
    </ul>
    <div class="daikuan clearfix">
        <dl>
            <dt><img src="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/images/bingtu.png"></dt>
            <dd>
                <p class="dprice">贷款<em><?php echo $loan->getLoan(false,true); ?></em></p>
                <p class="other">等额本息还款  按揭20年</p>
            </dd>
        </dl>
    </div>
    <ul class="daikuan-detail clearfix">
        <li><i class="co-01"></i><p>首期付款</p><p><?php echo $loan->getDownPayment(true); ?>万</p></li>
        <li><i class="co-02"></i><p>支付利息</p><p><?php echo $loan->getInterest(true); ?>万</p></li>
        <li><i class="co-03"></i><p>贷款总额</p><p><?php echo $loan->getLoan(true); ?>万</p></li>
        <li><i class="co-04"></i><p>月均还贷</p><p class="c-red"><?php echo $loan->getMonthRepay(); ?>元</p></li>
    </ul>
    <div class="loupan"><a href="<?php echo $this->createUrl('/wap/plot/index', ['py'=>$huxing->plot->pinyin]); ?>">开盘：<?php echo PlotHouseTypeExt::getSaleStatus($huxing->sale_status); ?><i class="goarrow iconfont">&#x1020;</i></a></div>
</div>
<div class="blank80"></div>

<?php $this->widget('BottomOperate',['style'=>'ul','plot'=>$huxing->plot,'url3'=>$this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('看房团需求', $huxing->plot),'title'=>($huxing->title)))]); ?>
