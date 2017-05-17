<?php
$areaInfo = ($selectedArea ? $selectedArea->name : '') . ($selectedStreet ? $selectedStreet->name : '') . (isset($priceTag[$this->urlConstructor->price]) ? $priceTag[$this->urlConstructor->price]->name : '');
$this->pageTitle = SM::urmConfig()->cityName().$areaInfo.'楼盘_'.SM::urmConfig()->cityName().$areaInfo.'新楼盘_'.SM::urmConfig()->cityName().$areaInfo.'新房价格-'.SM::GlobalConfig()->siteName().'房产手机版-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().$areaInfo.'楼盘,'.SM::urmConfig()->cityName().$areaInfo.'新楼盘,'.SM::urmConfig()->cityName().$areaInfo.'新房价格-'.SM::GlobalConfig()->siteName().'房产','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网为您提供最新最全的'.$areaInfo.'新房信息，方便广大网友快速找到喜爱的新房楼盘，购买'.SM::urmConfig()->cityName().'新盘就上'.SM::GlobalConfig()->siteName(),'description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css'); ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=415167759dc5861ddbbd14154f760c7e"></script>
<!-- 顶部开始 -->

<?php $this->renderPartial('/layouts/header',['title'=>'买新房','search'=>true,'bc'=>true]) ?>

<!-- 顶部结束 -->

<input type="hidden" id="xmts" value="0">
<input type="hidden" id="place" value="0">
<input type="hidden" id="xuexiao" value="0">
<input type="hidden" id="price" value="0">
<input type="hidden" id="huxing" value="0">
<input type="hidden" id="wylx" value="0">
<input type="hidden" id="kpsj" value="0">
<input type="hidden" id="order" value="0">
<input type="hidden" id="zxzt" value="0">

<!-- 内容开始 -->
<section class="container">
    <div class="new-house dropload" data-url='<?php echo $ajaxUrl; ?>' data-defurl='<?php echo $ajaxUrl; ?>' data-template='houseList'>
        <!-- 滑动菜单开始 -->
        <div class="menu-slide-left">
            <ul class="swiper-wrapper">
                <li class="swiper-slide"><a href="" class="on">全部</a></li>
                <?php foreach($allTagsIndexByCate['xmts'] as $v):?>
                <li class="swiper-slide"><a data-xmts="<?=$this->urlConstructor->addParam('xmts', $v->id); ?>" href="javascript:;"><?php echo $v->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 滑动菜单结束 -->

        <!-- 下拉选择菜单开始 -->
        <ul class="select-slide-down">
            <li><a href="javascript:;"><p>位置</p><i class="iconfont">&#x2035;</i></a></li>
            <li><a href="javascript:;"><p>价格</p><i class="iconfont">&#x2035;</i></a></li>
            <li><a href="javascript:;"><p>户型</p><i class="iconfont">&#x2035;</i></a></li>
            <li><a href="javascript:;"><p>更多</p><i class="iconfont">&#x2035;</i></a></li>
        </ul>
        <!-- 下拉选择菜单结束 -->

        <!-- 新房列表开始 -->
        <ul class="house-list more-list">

        </ul>

        <!-- 新房列表结束 -->

        <div class="mask"></div>

        <!-- 位置选择开始 -->
        <div class="select-slider-location select-slider">
            <ul class="select-left">
                <li class="on"><i class="iconfont blue2">&#x3659;</i>地区</li>
                <li><i class="iconfont green">&#x2985;</i>学校</li>
            </ul>
            <!-- 一级区域 -->
            <ul class="select-center" style="display: block">
                <li data-index="0" class="on" data-place="">不限</li>
                <?php
                $dataIndex = 1;
                foreach($allArea as $id=>$area):
                    if($area->getIsFirstLevel()):
                ?>
                <li data-index="<?php echo $dataIndex++; ?>"><?php echo $area->name; ?></li>
                <?php endif;endforeach; ?>
            </ul>
            <!-- 学校分类 -->
            <ul class="select-center" >
                <li data-xuexiao="" class="on">不限</li>
                <?php foreach(SchoolExt::$type as $k=>$name): ?>
                    <li data-index="<?php echo $dataIndex++; ?>"><?php echo $name; ?></li>
                <?php endforeach; ?>
            </ul>

            <!-- 二级区域 -->
            <ul class="select-right" for="select-slider-location" style="display: none"></ul>
            <?php
                foreach($allArea as $id=>$area):
                    if($area->getIsFirstLevel()):
            ?>
            <ul class="select-right" for="select-slider-location" >
                <li data-place="<?=$area->id?>">不限</li>
                <?php foreach($area->childArea as $childArea): ?>
                <li data-place="<?=$childArea->id; ?>"><?php echo $childArea->name; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif;endforeach; ?>

            <!-- 小学 -->
            <ul class="select-right" for="select-slider-location">
                <li data-xuexiao="<?=$this->urlConstructor->addParam('xxlx', 1); ?>">不限</li>
                <?php foreach($xuexiao as $xx): ?>
                    <?php if($xx->type==1): ?>
                    <li data-xuexiao="<?=$this->urlConstructor->addParam('xuexiao', $xx->id); ?>"><?php echo $xx->name; ?></li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <!-- 中学 -->
            <ul class="select-right" for="select-slider-location">
                <li data-xuexiao="<?=$this->urlConstructor->addParam('xxlx', 2); ?>">不限</li>
                <?php foreach($xuexiao as $zx): ?>
                    <?php if($zx->type==2): ?>
                    <li data-xuexiao="<?=$this->urlConstructor->addParam('xuexiao', $zx->id); ?>"><?php echo $zx->name; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>


        </div>

        <!-- 价格选择开始 -->
        <div class="select-slider-price select-slider">
            <ul class="select-price" for="select-slider-price">
                <li class="on"><em>不限</em><i class="iconfont">&#x2571;</i></li>
                <?php foreach($priceTag as $v):?>
                    <li data-price="<?=$this->urlConstructor->addParam('price', $v->id); ?>"><em><?php echo $v->name; ?></em><i class="iconfont">&#x2571;</i></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 价格选择结束 -->

        <!-- 居室开始 -->
        <div class="select-slider-hot select-slider">
            <ul class="select-hot" for="select-slider-hot">
                <li class="on" data-huxing=""><em>不限</em><i class="iconfont">&#x2571;</i></li>
                <?php foreach($bedrooms as $num=>$bedroom):?>
                <li data-huxing="<?=$this->urlConstructor->addParam('huxing', $num); ?>"><em><?php echo $bedroom; ?></em><i class="iconfont">&#x2571;</i></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 居室结束 -->

        <!-- 更多开始 -->
        <div class="select-slider-more select-slider">
            <!-- 物业类型开始 -->
            <ul class="select-type" for="select-slider-more-child">
                <div class="slider-title">类型：<em>不限</em><i class="iconfont">&#x1001;</i></div>
                <li data-wylx="" class="on">不限</li>
                <?php foreach($allTagsIndexByCate['wylx'] as $v):?>
                    <li data-wylx="<?=$this->urlConstructor->addParam('wylx', $v->id); ?>"><?php echo $v->name; ?></li>
                <?php endforeach; ?>
            </ul>

            <!-- 开盘时间开始 -->
            <ul class="select-open" for="select-slider-more-child">
                <div class="slider-title">开盘：<em>不限</em><i class="iconfont">&#x1001;</i></div>
                <li data-kpsj="" class="on">不限</li>
                <?php foreach($kpsjOptions as $pinyin=>$kpsj): ?>
                <li data-kpsj="<?=$this->urlConstructor->addParam('kpsj', $pinyin); ?>"><?php echo $kpsj['name']; ?></li>
                <?php endforeach; ?>
            </ul>

            <ul class="select-sort" for="select-slider-more-child">
              <div class="slider-title">排序：<em>不限</em><i class="iconfont">&#x1001;</i></div>
                <li data-order="" class="on">不限</li>
                <?php foreach($sortOptions as $k=>$op): ?>
                <li data-order="<?=$this->urlConstructor->addParam('order', $k); ?>" class="<?php echo Tools::strlen($op['name'])>6?'small ':'' ?>"><?php echo $op['name']; ?></li>
                <?php endforeach; ?>
            </ul>

            <ul class="select-reno" for="select-slider-more-child">
                <div class="slider-title">装修：<em>不限</em><i class="iconfont">&#x1001;</i></div>
                <li data-zxzt="" class="on">不限</li>
                <?php foreach($allTagsIndexByCate['zxzt'] as $k=>$v): ?>
                <li data-zxzt="<?=$this->urlConstructor->addParam('zxzt', $v->id); ?>" class="<?php echo Tools::strlen($v->name)>6?'small ':''; ?>"><?php echo $v->name; ?></li>
                <?php endforeach; ?>
            </ul>

            <div class="select-btns" for="select-slider-more">
                <a href="javascript:void(0)" class="btn-reset">重置</a>
                <a href="javascript:void(0)" class="btn-submit">确认</a>
            </div>
        </div>
        <!-- 价格选择结束 -->

    </div>
</section>
<div id="location_map" style="width:0; height: 0;"></div>
<!-- 内容结束 -->
