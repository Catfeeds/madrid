<?php
$this->pageTitle = $this->siteConfig['cityName'].'房产特价房_一房一价_'.$this->siteConfig['cityName'].'特价房-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'特价房，'.$this->siteConfig['cityName'].'房产特价房，'.$this->siteConfig['siteName'].'房产，一房一价，'.$this->siteConfig['cityName'].'打折楼盘，热门楼盘，'.$this->siteConfig['siteName'].'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'房产特价房由'.$this->siteConfig['siteName'].'房产网联合开发商举行的优惠活动，为广大网友提供'.$this->siteConfig['cityName'].'特价房、刚需房、低总价房等优质性价比房源。','description');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');

$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>
    <!--头部 begin-->
    <header class="ui-title-bar">
        <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
        <span class="ml10 mr10 c-gc fl fs32">|</span>
        <span class="fl fs32 gc3">特价房 </span>
    </header>
    <!--头部 end-->
    <div class="gw">
        <div class="gcal">共有 <?php echo($pager->itemCount);?> 个特价房</div>
        <div class="tjf-list">
            <ul>
                <?php foreach($plot as $v):?>
                    <?php if($v->specialNum > 0):?>
                    <li>
                        <!--小区-->
                        <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$v->pinyin))?>">
                        <div class="fang-village">
                            <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image)?>" alt="" /></div>
                            <div class="info">
                                <h3><?php echo Tools::u8_title_substr($v->title,15);?></h3>
                                <p class="price em-1"><?php echo PlotPriceExt::getPrice($v->price,$v->unit) ?></p>
                                <p class="address"><?php echo (isset($this->siteArea[$v->area])&&!empty($this->siteArea[$v->area])) ? ($this->siteArea[$v->area].((isset($this->siteStreet[$v->area])&&!empty($this->siteStreet[$v->area])) ? ((isset($this->siteStreet[$v->area][$v->street])&&!empty($this->siteStreet[$v->area][$v->street])) ? '/'.$this->siteStreet[$v->area][$v->street] : '') :'' )) : '';?></p>
                                <p class="yh em-1"><?php echo $v->newDiscount ? Tools::u8_title_substr($v->newDiscount->title,28) : ''?></p>
                            </div>
                        </div>
                            </a>
                        <!--特价房-->
                        <div class="tjf-sublist">
                            <h2>
                                共有<strong class="em-1"><?php echo $v->specialNum; ?></strong>套特价房
                                <i class="down-arrow"></i>
                            </h2>
                            <ul>
                                <?php $this->actionAddMore($v->id);?>
                                <?php if($v->specialNum >= 4):?>
                                    <div class="addmore" data-hid="<?php echo $v->id; ?>">
                                        <a href="javascript:;">加载更多</a>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; endforeach;?>
            </ul>
        </div>
    </div>
    <!--分页begin-->
<?php $this->widget('WapLinkPager',array('pages'=>$pager));?>
    <!--分页end-->

<script>
    <?php Tools::startJs(); ?>

    var page=1;
    $('.addmore').click(function(){
        page++;
        var hid = $(this).data('hid');
        var obj = $(this);
        $.get("<?php echo $this->createUrl('/wap/special/addMore'); ?>",
            {
                hid:hid,
                p:page
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
