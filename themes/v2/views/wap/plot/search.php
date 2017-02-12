<?php
$this->pageTitle = '楼盘搜索-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('楼盘搜索','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/search.css');
Yii::app()->clientScript->registerScriptFile('http://api.map.baidu.com/api?v=2.0&ak=415167759dc5861ddbbd14154f760c7e', CClientScript::POS_HEAD);
?>
<input type="hidden" id="xmts" value="0">
<input type="hidden" id="place" value="0">
<input type="hidden" id="xuexiao" value="0">
<input type="hidden" id="price" value="0">
<input type="hidden" id="huxing" value="0">
<input type="hidden" id="wylx" value="0">
<input type="hidden" id="kpsj" value="0">
<input type="hidden" id="order" value="0">
<input type="hidden" id="zxzt" value="0">

<!-- 顶部开始 -->
<header class="title-bar title-bar-hasbg">
    <a href="" class="iconfont back">&#x2568;</a>
    <form action="<?php echo $this->createUrl('/wap/plot/list'); ?>" method="get">
        <div class="search">
             <input type="button" id="search_btn" value="确认" class="sure-btn" >
            <div class="search-frame">
                <i class="iconfont">&#x1014;</i>
                <input type="text" id="keywords_input" name="keywords" value="" placeholder="请输入楼盘名称" autocomplete="off" data-url="<?php echo $this->createUrl('/wap/plot/search'); ?>">
            </div>
            <ul class="search-frame-expand">

            </ul>
        </div>
    </form>
</header>
<!-- 顶部结束 -->

<!-- 搜索首页开始 -->
<div id="search_index">
    <div class="search-choose">
        <div class="hd">
            <ul>
                <li>
                    <a href=""><span>区域</span><span>不限<i class="iconfont">&#x1020;</i></span></a>
                </li>
                <li>
                    <a href=""><span>价格</span><span>不限<i class="iconfont">&#x1020;</i></span></a>

                </li>
                <li>
                    <a href=""><span>特色</span><span>不限<i class="iconfont">&#x1020;</i></span></a>
                </li>
            </ul>
        </div>
        <div class="bd">
            <div class="expand-box">
                <div class="title-bar title-bar-hasbg">
                    <a href="" class="iconfont back">&#x2568;</a>
                    <h1>区域</h1>
                    <div class="operate">&nbsp</div>
                </div>
                <ul>
                    <li data-place="" class="current">不限</li>
                    <?php foreach($allArea as $v):if($v->getIsFirstLevel()): ?>
                    <li data-place="<?=$v->id?>"><?php echo $v->name; ?></li>
                    <?php endif;endforeach; ?>
                </ul>
            </div>
            <div class="expand-box">
                <div class="title-bar title-bar-hasbg">
                    <a href="" class="iconfont back">&#x2568;</a>
                    <h1>价格</h1>
                    <div class="operate">&nbsp</div>
                </div>
                <ul>
                    <li data-price="" class="current">不限</li>
                    <?php foreach($priceTag as $v): ?>
                    <li data-price="<?=$this->urlConstructor->addParam('price', $v->id); ?>"><?php echo $v->name; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="expand-box" style="width:100%; height: 100%; overflow: auto;">
                <div class="title-bar title-bar-hasbg">
                    <a href="" class="iconfont back">&#x2568;</a>
                    <h1>特色</h1>
                    <div class="operate">&nbsp</div>
                </div>
                <ul>
                    <li data-xmts="" class="current">不限</li>
                    <?php foreach($xmtsTags as $v): ?>
                    <li data-xmts="<?=$this->urlConstructor->addParam('xmts', $v->id); ?>"><?php echo $v->name; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="blank50"></div>
    <div class="container">
        <div class="container">
            <div class="gw clearfix"><input type="button" id="reset_btn" value="重置" class="btn1 fl"><input type="button" id="submit_search" value="确认搜索" class="btn2 fr btn-submit"></div>
        </div>
    </div>
</div>
<!-- 搜索首页结束 -->

<!-- 搜索历史开始 -->
<div id="search_history" style="display: none;">
    <div class="container">
        <ul class="search-ul">
            <!-- <li><a href="">世茂香槟</a></li>
            <li><a href="">世茂香槟湖四期</a></li>
            <li><a href="">大名城</a></li> -->
        </ul>
        <input type="button"  value="清除历史记录" class="clear-btn">
        <div class="hot-search-list clearfix">
            <p>最近热搜</p>
            <ul>
                <?php foreach(RecomExt::model()->getRecom('pcrstj', 10)->findAll() as $v): ?>
                <li><a href="<?php echo $v->url; ?>" target="_blank"><?php echo $v->title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 搜索历史结束 -->

<div id="search_list" style="display: none;">
    <section class="container">
        <div class="new-house">
            <!-- 下拉选择菜单开始 -->
            <ul class="select-slide-down">
                <li><a href=""><p>位置</p><i class="iconfont">&#x2035;</i></a></li>
                <li><a href=""><p>价格</p><i class="iconfont">&#x2035;</i></a></li>
                <li><a href=""><p>热门</p><i class="iconfont">&#x2035;</i></a></li>
                <li><a href=""><p>更多</p><i class="iconfont">&#x2035;</i></a></li>
            </ul>
            <!-- 下拉选择菜单结束 -->
            <div class="search-result bg-hui">共搜到<span>0</span>条结果</div>
            <div class="house-list-content dropload" data-defurl='<?=$this->createUrl('/wap/plot/list',['ajax'=>1]);?>' data-url='<?=$this->createUrl('/wap/plot/list',['ajax'=>1]);?>' data-template='searchList'>
                <!-- 新房列表开始 -->
                <ul class="house-list more-list">

                </ul>
            </div>

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
                    <?php foreach($area->childArea as $childArea): ?>
                    <li data-place="<?=$childArea->id; ?>"><?php echo $childArea->name; ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif;endforeach; ?>

                <!-- 小学 -->
                <ul class="select-right" for="select-slider-location">
                    <?php foreach($xuexiao as $xx): ?>
                        <?php if($xx->type==1): ?>
                        <li><?php echo $xx->name; ?></li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <!-- 中学 -->
                <ul class="select-right" for="select-slider-location">
                    <?php foreach($xuexiao as $zx): ?>
                        <?php if($zx->type==2): ?>
                        <li><?php echo $zx->name; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- 位置选择结束 -->

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
    </div>
    <div class="blank50"></div>
<div id="location_map" style="width:0; height: 0;"></div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    document.body.className = 'bg-fff';
    Do.ready(function(){
        $('footer').hide();
    });
    <?php Tools::endJs('js'); ?>
</script>
