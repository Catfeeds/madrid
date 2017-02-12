<?php
$this->pageTitle = SM::seoConfig()->wapIndexIndex()['title'] ? SM::seoConfig()->wapIndexIndex()['title'] : (SM::urmConfig()->cityName().'房地产门户_'.SM::urmConfig()->cityName().'房产网_'.SM::urmConfig()->cityName().'房产信息网-'.SM::GlobalConfig()->siteName().'房产手机版-'.SM::GlobalConfig()->siteName());

Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->wapIndexIndex()['keyword']?SM::seoConfig()->wapIndexIndex()['keyword']:(SM::urmConfig()->cityName().'房地产门户，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房地信息网，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'房地产网，'.SM::urmConfig()->cityName().'房屋出租，'.SM::GlobalConfig()->siteName().'房产'),'keywords');
Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->wapIndexIndex()['desc']?SM::seoConfig()->wapIndexIndex()['desc']:(SM::GlobalConfig()->siteName().'房产网是'.SM::urmConfig()->cityName().'热门专业的网络房产平台，提供全面及时的'.SM::urmConfig()->cityName().'房产楼市资讯，'.SM::urmConfig()->cityName().'房产楼盘信息、近期'.SM::urmConfig()->cityName().'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.SM::urmConfig()->cityName().'房产近期优惠信息就上'.SM::GlobalConfig()->siteName().'房产网'),'description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/index.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/swiper.min.css'); ?>
<?php $this->widget('WapAdWidget', ['position' => 'wapbottom'])?>
<div class="content-box">
    <div class=" top-mark"></div>

    <?php $this->renderPartial('/layouts/header',['search'=>true]) ?>

    <div class="img-slide clearfix">
        <div class="slide" id="slide">
            <ul class="swiper-wrapper">
                <?php foreach($recom as $k=>$v):?>
                    <li class="swiper-slide"><a href="<?php echo $v->url;?>" target="_blank"><img <?=$k==0?'src':'data-src'?>="<?php echo ImageTools::fixImage($v->image);?>" alt="" <?php if($k>0): ?>class="swiper-lazy"<?php endif; ?>></a><?php if($v->isAd): ?><span class="ad-lab">广告</span><?php endif; ?></li>
                <?php endforeach;?>
            </ul>

            <div class="swiper-pagination">
            </div>
            <div class=" bottom-mark"></div>
        </div>

    </div>

</div>

<div class="index-nav">
    <ul class=" clearfix">
        <li>
            <a href="<?php echo $this->createUrl('/wap/plot/list'); ?>">
               <p class="red"><i class="redbg">找</i>新房</p>
               <p>享受购房独家补贴</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/wap/adviser/index'); ?>">
               <p class="org"><i class="orgbg">带</i>看新房</p>
               <p>全程带看,1对1服务</p>
            </a>
        </li>
        <li>

            <?php if(SM::schoolConfig()->enable()): ?>
                <a href="<?php echo $this->createUrl('/wap/school/index'); ?>" >
                   <p class="blue"><i class="bluebg">找</i>邻校房</p>
                   <p>附近有学校的好房</p>
                </a>
            <?php elseif(!empty(SM::pageUrlConfig()->esfListUrl())): ?>
                <a href="<?php echo SM::pageUrlConfig()->esfListUrl(); ?>" target="_blank" >
                   <p class="blue"><i class="bluebg">查</i>二手房</p>
                   <p>优质房源实时更新</p>
                </a>
            <?php else: ?>
                <a href="<?php echo $this->createUrl('/wap/tuan/index'); ?>" >
                   <p class="blue"><i class="bluebg">看</i>看房团</p>
                   <p>最新的看房团线路</p>
                </a>
            <?php endif; ?>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/wap/map/index'); ?>">
               <p><em class="iconfont fenzi">&#x3598;</em>地图找房</p>
               <p>离我最近的好房</p>
            </a>
        </li>
        <li>
            <?php if(SM::baikeConfig()->enable()): ?>
            <a href="<?php echo $this->createUrl('/wap/baike/index'); ?>">
              <p><em class="iconfont kafei">&#x1046;</em>买房宝典</p>
               <p>买房卖房没烦恼</p>
            </a>
            <?php else: ?>
                <a href="<?php echo $this->createUrl('/wap/wenda/index'); ?>">
                   <p><em class="iconfont kafei">&#x1046;</em>买房问答</p>
                   <p>买房前问一问</p>
                </a>
            <?php endif; ?>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/wap/news/index'); ?>">
               <p><em class="iconfont green">&#x1041;</em>购房资讯</p>
               <p>开盘讯息全知道</p>
            </a>
        </li>
    </ul>
</div>
<?php $this->widget('WapAdWidget', ['position' => 'wapgfgwsb'])?>
<?php if(count($news)>0):?>
<div class="content-box">
    <div class="today-head">
        <div class="left-box">今日<em>头条</em>：</div>
        <div class="mid-box">
            <div class="text-slide swiper-container-vertical">
                <ul class="swiper-wrapper" style="transform: translate3d(0px, -2880px, 0px); transition-duration: 0ms;">
                    <?php foreach($news as $k=>$v):?>
                    <li class="swiper-slide" data-swiper-slide-index="<?php echo $k?>" style="height: 720px;"><a href="<?php echo $v->url?>" target="_blank"><?php echo $v->title?></a></li>
                    <?php endforeach;?>
            </div>
            <a href="<?php echo $this->createUrl('/wap/news/index');?>" class="s-more">更多</a>
        </div>
    </div>
</div>
<?php endif;?>
<?php if(SM::adviserConfig()->enable() && $staff): ?>
<div class="blank20"></div>
<div class="content-box">
    <div class="title01"><h3>免费的贴身购房顾问</h3></div>
    <div class="free-adviser">
        <a href="<?php echo $this->createUrl('/wap/adviser/staff',['id'=>$staff->id]); ?>" >
            <dl class="clearfix">
                <dt><img class="lazy" data-original="<?php echo ImageTools::fixImage($staff->avatar,100,100); ?>"></dt>
                <dd>
                    <p><?php echo $staff->name; ?><em><?php echo $staff->job?$staff->job.'&nbsp;|':''; ?>&nbsp;<span id="zanshu"><?php echo $staff->praise; ?></span>个赞</em></p>
                    <div class="dialog-box">Hi，我是您的贴身专属分析师</div>
                </dd>
            </dl>
        </a>
        <ul>
            <li><a href="<?php echo $staff->phone ? 'tel:'.$staff->phone : 'javascript:;'; ?>"><em class="iconfont">&#x3658;</em>电话咨询</a></li>
            <li><a href="<?php if($staff->qq): ?>mqqwpa://im/chat?chat_type=wpa&uin=<?php echo $staff->qq; ?>&version=1&src_type=web<?php else: ?>javascript:;<?php endif; ?>"><em class="iconfont">&#x2033;</em>在线咨询</a></li>
            <li><a href="javascript:;" id="dianzan" data-sid="<?php echo $staff->id; ?>"><em class="iconfont">&#x2036;</em>给我点赞</a></li>
        </ul>
    </div>
</div>
<?php endif; ?>
<?php if(SM::specialConfig()->enable() && $special): ?>
<div class="blank20"></div>
<div class="content-box">
    <div class="title01 bnone"><h3>特价房</h3></div>
    <div class="tjf-list">
       <ul class="tjf-container">
        <?php foreach($special as $v): ?>
            <li>
                <a href="<?php echo $this->createUrl('/wap/special/detail',['id'=>$v->id]); ?>">
                    <div class="fang-village">
                        <div class="pic">
                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image); ?>" alt="" />
                            <div class="cx-news">劲省<?php echo round($v->price_old-$v->price_new,1); ?>万</div>
                        </div>
                        <div class="info">
                            <div class="name"><h2 class="fs16"><?php echo $v->plot?$v->plot->title:'';?></h2><?php if($v->plot&&$v->plot->unit==1): ?><span><?=PlotPriceExt::$mark[$v->plot->price_mark]?><?=$v->plot['price']?><?=PlotPriceExt::$unit[$v->plot->unit]
?></span><?php endif; ?></div>
                            <p class="fs14"><?php if($v->room):?><?php echo $v->room; ?>&#160;&#160;<?php endif;?>
                            <?php if($v->htid):?>
                            <?=$v->houseType->bedroom;?>室<?=$v->houseType->livingroom;?>厅<?=$v->houseType->bathroom;?>卫<?php echo $v->houseType->size ?>㎡</p>
                            <?php endif;?>
                            <p><strong class="oprice">¥<?php echo $v->price_new?>万元/套</strong><del>￥<?php echo $v->price_old; ?>万</del></p>
                            <!-- <i class="goarrow iconfont">&#x1020;</i> -->
                        </div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
        <?php if($specialHyh):?>
        <div class="change-box"><a href="" class="change-btn" data-url="<?php echo $this->createUrl('/wap/special/change'); ?>" data-template="tjfList" data-container="tjf-container">换一换</a><a href="<?php echo $this->createUrl('/wap/special/index'); ?>">查看更多</a></div>
        <?php endif;?>
    </div>
</div>
<?php endif; ?>
<?php if(SM::tuanConfig()->enable() && $tuan): ?>
<div class="blank20"></div>
<div class="content-box">
    <div class="title01 bnone"><h3>特惠团</h3></div>
    <div class="tjf-list">
        <ul class="thg-container">
        <?php foreach($tuan as $v): ?>
            <li>
                <a href="<?php echo $this->createUrl('/wap/plot/index',['py'=>$v->plot->pinyin,'md'=>'tht']); ?>">
                    <div class="fang-village">
                        <div class="pic">
                            <img data-original="<?php echo ImageTools::fixImage($v->wap_img); ?>" class="lazy" alt="" />
                        </div>
                        <div class="info">
                            <p class="discount"><?php echo $v->s_title; ?></p>
                            <div class="name"><h2><?php echo $v->plot?$v->plot->title:''; ?></h2><?php if($v->plot): ?><span><?php echo PlotPriceExt::$mark[$v->plot->price_mark].$v->plot->price.PlotPriceExt::$unit[$v->plot->unit]; ?></span><?php endif; ?></div>
                            <p class="news"><span><em><?php echo $v->stat+$v->tuanNum; ?></em>人已抢到</span>  <span><?php echo $v->getRemainingTime(); ?>后结束</span></p>
                            <!-- <i class="goarrow iconfont">&#x1020;</i> -->
                        </div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
        <?php if($tuanHyh):?>
        <div class="change-box"><a href="" class="change-btn" data-url="<?php echo $this->createUrl('/wap/purchase/change'); ?>" data-template="thgList" data-container="thg-container">换一换</a><a href="<?php echo $this->createUrl('/wap/purchase/index'); ?>">查看更多</a></div>
    <?php endif;?>
    </div>
</div>
<?php endif; ?>
<div class="blank20"></div>
<div class="content-box">
    <div class="title01 bnone"><h3>找新房</h3></div>
    <div class="nhouse-list">
        <ul class="xinfang-container">
            <?php foreach($plot as $v): ?>
                <li>
                    <a href="<?php echo $this->createUrl('/home/plot/index',['py'=>$v->pinyin]); ?>">
                        <div class="top-mark"></div>
                        <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image,640,300); ?>">
                        <p class="name"><?php echo $v->title; ?> <?php if($v->areaInfo): ?>[<?php echo $v->areaInfo->name.($v->streetInfo?' - '.$v->streetInfo->name:'') ?>]<?php endif;?> <br><?php echo PlotPriceExt::$mark[$v->price_mark].$v->price.PlotPriceExt::$unit[$v->unit]; ?></p>
                        <?php if($v->evaluate&&$v->evaluate->staff): ?>
                        <a href="<?=$this->createUrl('/wap/adviser/staff',['id'=>$v->evaluate->staff->id]); ?>">
                            <div class="person">
                                <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->evaluate->staff->avatar,100,100); ?>">
                            </div>
                        </a>
                        <?php endif; ?>
                    </a>
                    <div class="info">
                        <div class="label">
                            <?php
                            $class = ['green','pink','blue','org'];
                            foreach($v->xmts as $k=>$tag):
                                if($k<3):
                            ?>
                            <span class="<?php echo $class[$k%4]?>"><?php echo $tag->name; ?></span>
                            <?php endif;endforeach; ?>
                        </div>
                        <p><?php echo Tools::u8_title_substr($v->data_conf['content'],300); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if($plotHyh):?>
        <div class="change-box"><a href="" class="change-btn" data-url="<?php echo $this->createUrl('/wap/plot/change'); ?>" data-template="xinfangList" data-container="xinfang-container">换一换</a><a href="<?php echo $this->createUrl('/wap/plot/list'); ?>">查看更多</a></div>
    <?php endif;?>
    </div>
</div>
<div class="blank20"></div>

<?php $this->renderPartial('/layouts/contact'); ?>

<script type="text/javascript">
    <?php Tools::startJs(); ?>
    Do.ready(function(){
        $("#dianzan").click(function(){
            $.get("<?php echo $this->createUrl('/wap/adviser/praise'); ?>",{sid:$(this).data("sid")},function(d){
                if(d.code>0){
                    $("#zanshu").html(d.msg);
                } else {
                    alertPop(d.msg);
                }
            },'json');
        });
    });
    <?php Tools::endJs('dianzan'); ?>
    document.body.className += ' bg-f7';
</script>
