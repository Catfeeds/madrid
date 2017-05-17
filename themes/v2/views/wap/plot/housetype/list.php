<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'楼盘户型-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'楼盘户型','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>


<?php $this->renderPartial('/layouts/header',['title'=>$this->plot->title.'户型','bc'=>true]) ?>
    <!-- 内容开始 -->
    <div class="content-box">
        <div class="nav-slide">
            <!-- 滑动菜单开始 -->
            <div class="menu-slide-left">
                <ul class="swiper-wrapper" style="width:1000%">
                    <?php foreach($bedrooms as $bedroom): ?>
                    <li class="swiper-slide"><a href="<?php echo $this->createUrl('/wap/plot/huxingList',['py'=>$this->plot->pinyin,'br'=>$bedroom->bedroom,'bid'=>$bid]); ?>" <?php if($bedroom->bedroom==$br): ?>class="on"<?php endif; ?> data-isHref="true"><?php echo $bedroom->getChineseBedroom(); ?>居</a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- 滑动菜单结束 -->
        </div>
        <div class="house-type-list">
            <ul>
                <?php foreach($list as $v): ?>
                    <li>
                        <a href="<?php echo $this->createUrl('/wap/plot/huxingDetail',['py'=>$this->plot->pinyin,'id'=>$v->id]); ?>">
                            <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image,200,150); ?>"></div>
                            <div class="info">
                                <ul>
                                    <li>
                                        户   型：<?php echo $v->bedroom.'室'.$v->livingroom.'厅'.$v->bathroom.'卫'; ?></li>
                                            <li>面   积：<?php echo $v->size; ?>m²</li>
                                            <li>参考价：<span><?php echo $v->price>0?$v->price.'万':'暂无'; ?></span></li>
                                            <li>开   盘：<?php echo PlotHouseTypeExt::getSaleStatus($v->sale_status); ?>
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<div class="blank20"></div>
