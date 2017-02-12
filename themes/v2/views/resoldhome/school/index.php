<?php
$this->pageTitle = SM::urmConfig()->cityName.'学校附近二手房出售|'.SM::urmConfig()->cityName.'学校小区价格-'.SM::urmConfig()->cityName . SM::globalConfig()->siteName;
$this->keyword =SM::urmConfig()->cityName.'学校附近二手房，'.SM::urmConfig()->cityName.'学校小区';
$this->description = SM::globalConfig()->siteName.SM::urmConfig()->cityName.'二手房网为您提供快速全面的'.SM::urmConfig()->cityName.'学校附近二手房出售信息及'.SM::urmConfig()->cityName.'学校小区信息。大量优质教育房源实时更新，为您提供舒适教育房购房体验。';
Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/list.css');
$current = array();
?>
<div class="wapper-out search-wrap clearfix">
<form method="get">
    <div class="search-box clearfix">
        <div class="search-input fl">
            <input name="kw" data-template="school-search-list" data-url="<?php echo $this->createUrl('/api/resoldwapapi/schoolsearch');?>" class="input" placeholder="请输入学校名称" autocomplete="off">
        </div>
        <input type="submit" class="btn fl" value="搜索" >
        <div class="search-list-box"></div>
        <?php $this->widget('CommonWidget'); ?>
    </div>
</form>
</div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>array(SM::urmConfig()->cityName().'二手房'=>$this->createUrl('/resoldhome/esf/list'),SM::urmConfig()->cityName.'邻校房')));?>
<div class="wapper">
    <div class="big-filter">
        <div class="tabs clearfix">
            <div class="btn-right">
                <a href="<?php echo $this->createUrl('/resoldhome/myesf/sellinput');?>">免费发布房源</a>
            </div>
            <ul class="clearfix">
                <li><a href="<?php echo $this->createUrl('/resoldhome/esf/list');?>" >按区域查询</a></li>
                <li><a class="on">按学校查询</a></li>
                <li><a href="<?php echo $this->createUrl('/resoldhome/map/index');?>" >切换到地图搜索</a></li>
            </ul>
        </div>
        <div class="category-select">

            <dl class="clearfix">
                <dt>区域：</dt>
                <dd>
                    <?php $this->widget('TagInfoWidget',['url'=>'/resoldhome/school/index','cate'=>'area','id'=>$params['street'] ? $params['street'] : $params['area'],'get'=>$_GET])?>
                </dd>
            </dl>

            <dl class="clearfix">
                <dt>特色：</dt>
                <dd>
                    <ul>
                        <li><a class="<?php if(!isset(SchoolExt::$type[$params['type']])){echo 'on'; } ?>" href="<?php $current = $params;unset($current['type']); echo $this->createUrl('index',array_filter($current)); ?>">不限</a></li>
                        <?php foreach (SchoolExt::$type as $key => $type): ?>
                            <li><a class="<?php if($params['type'] == $key){ echo 'on'; }?>" href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('type'=>$key))) ?>"><?php echo $type; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </dd>
            </dl>
            <?php if(!empty($condition)): ?>
            <dl class="hascheck">
                <dt>当前选择条件：</dt>
                <dd>
                    <ul class="clearfix">
                        <?php foreach ($condition as $k => $v): ?>
                            <li><a href="<?php
                                $current = $params ;
                                unset($current[$k]);
                                echo $this->createUrl('index',array_filter($current)); ?>" class="k-select-1"><?php echo $v;?><i class="list-icon icon-12"></i></a></li>
                        <?php endforeach; ?>
                        <li><a href="<?php echo $this->createUrl('index')?>" class="k-select-2"><i class="list-icon icon-clear"></i>清空所有条件</a></li>
                    </ul>
                </dd>
            </dl>
            <?php  endif; ?>
        </div>
    </div>
    <div class="blank20"></div>
    <div class="main-left">

        <div class="next-tabs clearfix">
            <div class="page-right">
                <p><a href="<?php echo $this->createUrl('/resoldhome/school/index',array_merge($_GET, array($pager->pageVar=>$pager->currentPage))); ?>" title="下一页"><</a><span class="page"><em><?php echo $pager->currentPage+1; ?></em>/<?php echo $pager->pageCount ? $pager->pageCount : 1; ?></span>
                    <a href="<?php echo $this->createUrl('/resoldhome/school/index',array_merge($_GET, array($pager->pageVar=>$pager->currentPage+2))); ?>" title="上一页">></a>
                </p>
            </div>
            <ul class="clearfix">
                <li><a href="" class="active">全部房源</a></li>
            </ul>
        </div>
        <div class="sort">
            <span>找到<em class="c-main"><?php echo $pager->itemCount; ?></em>个学校</span>

            <div class="filter fr mt8">
              <!--  <div class="pr fl">
                    <a href="<?php /*$current = $params;unset($current['sort']);echo $this->createUrl('index',array_filter($current))*/?>" class="sort-btn <?php /*if($params['sort'] == '') {echo 'on';} */?>">默认排序</a>
                </div>-->
                <div class="pr fl">
                    <?php if($params['sort'] == '2'): ?>
                        <a href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('sort'=>'1')))?>" class="sort-btn sort-up on">小区数量<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box">点击按小区数量从高到低排序</div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('sort'=>'2')))?>" class="sort-btn sort-down <?php if($params['sort'] == '1'){echo  'on'; }?>">小区数量<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box">点击按小区数量从低到高排序</div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="pr fl">
                    <?php if($params['sort'] == '3'): ?>
                        <a href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('sort'=>'4')))?>" class="sort-btn sort-down on">房源数量<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box">点击按房源数量从低到高排序</div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('sort'=>'3')))?>" class="sort-btn sort-up <?php if($params['sort'] == '4'){echo  'on'; }?>">房源数量<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box">点击按房源数量从高到低排序</div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <ul class="item-list">
            <?php foreach ($data as $item): ?>
            <li class="item clearfix">
                <div class="pic fl">
                    <a href="<?php echo $this->createUrl('plot',array('pinyin'=>$item->pinyin));?>"><img src="<?=ImageTools::fixImage($item->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                </div>
                <div class="content scl-box fl">
                    <p class="title"><a href="<?php echo $this->createUrl('plot',array('pinyin'=>$item->pinyin));?>"><?php echo Tools::u8_title_substr($item->name,50);?></a></p>
                    <p class="detail"><span><?php echo $item->areaInfo ? $item->areaInfo->name : ''; ?><?php echo $item->streetInfo ? '-'.$item->streetInfo->name : ''; ?></span><em>|</em><span><?php echo $item->address ; ?></span></p>
                    <p class="area">
                        <span><?php echo $item->house_num; ?>个小区</span>
                    </p>
                    <p class="tags">
                        <span class="green"><?php echo SchoolExt::$type[$item->type] ?></span>
                        <?php if($item->important == 1): ?>
                            <span class="pink">区重点</span>
                        <?php endif; ?>
                    </p>
                    <div class="about-price">
                        <p class="taoshu prices"><em><?php echo $item->esf_num ? $item->esf_num.'</em>套<p class="tag">在售房源</p>' : ''; ?></p>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="blank20"></div>
        <div class="page-box">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager)); ?>
        </div>
    </div>
    <div class="main-right">
        <div class="frame side-box">
            <div class="stitle">
                <span>二手房资讯</span>
            </div>
            <?php $this->widget('RightWidget',['type'=>'news','limit'=>8])?>
        </div>
        <div class="blank20"></div>
        <div class="frame side-box">
            <div class="stitle">
                <span><?=SM::urmConfig()->cityName()?>二手房价格趋势</span>
            </div>
            <?php $this->widget('RightWidget',['type'=>'pricetrend','limit'=>5])?>
        </div>
        <div class="blank20"></div>
        <div class="frame side-box">
            <div class="stitle">
                <span>最近浏览的房源</span>
            </div>
            <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>3,'type'=>1,'category'=>1])?>
        </div>
        <div class="blank20"></div>
        <div class="frame side-box">
            <div class="stitle">
                <span>热门小区</span>
            </div>
            <?php $this->widget('RightWidget',['type'=>'hotplot','limit'=>10])?>
        </div>
        <div class="blank20"></div>
        <?php $this->widget('AdWidget',['position'=>'esfycbanner']); ?>
    </div>

</div>

<div class="blank20"></div>

<?php $this->widget('CommonWidget',['type'=>3])?>

<script type="text/html" id="school-search-list">
    <ul>
        {{each data as value}}
        <li>
            <a href="/resoldhome/school/plot?pinyin={{value.pinyin}}">
                <span>{{value.name}}</span>
                <span class="right">约{{value.plotNum}}条房源</span>
            </a>
        </li>
        {{/each}}
    </ul>
</script>
