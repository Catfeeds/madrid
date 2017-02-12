<?php
    $this->pageTitle = $seoArr['t'];
    $this->keyword = $seoArr['k'];
    $this->description = $seoArr['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/expert.css');
?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
    <form method="get" id="search-form" action="<?=$this->createUrl('/resoldhome/staff/shopList')?>">
        <div class="search-input fl">
            <input class="input" name="kw" value="" placeholder="请输入店铺名称">
        </div>
        <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
        </form>
        <div class="search-list-box">
            <ul>
                <li>
                    <span>大名城<em>新北三井</em></span>
                    <span class="right">约469条房源</span>
                </li>
                <li>
                    <span>大名城别墅<em>新北三井</em></span>
                    <span class="right">约469条房源</span>
                </li>
            </ul>
        </div>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>['中介门店列表页']));?>
<div class="wapper">
	<div class="category-select">
        <dl class="clearfix">
          <dt>区域：</dt>
          <dd>
            <?php $this->widget('TagInfoWidget',['url'=>'/resoldhome/staff/shopList','cate'=>'area','get'=>$_GET,'id'=>$street ? $street : $area ])?>
          </dd>
        </dl>
        <div class="blank15"></div>
    </div>
</div>
<div class="blank10"></div>
<div class="wapper">
	<div class="main-left">
		<div class="next-tabs clearfix">
            <div class="page-right">
                <p><a href="<?=$this->createUrl('shopList',['page'=>$page-1>0?$page-1:1]+array_filter($_GET))?>" title="上一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('shopList',['page'=>$page+1]+array_filter($_GET))?>" title="下一页">></a></p>
            </div>
            <ul class="clearfix">
              <li><a href="<?=$this->createUrl('staffList')?>">全部经纪人</a></li>
              <li><a href="<?=$this->createUrl('shopList')?>" class="active">中介门店</a></li>               
            </ul>
        </div>
        <div class="sort">
            <span>找到<em class="c-main"><?=$shopCount?></em>中介门店</span>
            <!-- <a href="" target="_blank" class="c-blue ml10">我也要出现在这里</a> -->
            <div class="filter fr mt8">
                <div class="pr fl">
                    <a href="<?=$this->createUrl('shopList',['sort'=>$sort==6?5:6]+$_GET)?>" class="sort-btn sort-<?=$sort==5?'up':'down'?> <?=$sort==5||$sort==6?'on':''?> fr">经纪人数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box"><?=$sort==6?'点击按经纪人数从少到多排序':'点击按经纪人数从多到少排序'?></div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div>
                <div class="pr fl">
                    <a href="<?=$this->createUrl('shopList',['sort'=>$sort==2?1:2]+$_GET)?>" class="sort-btn sort-<?=$sort==1?'up':'down'?> <?=$sort==1||$sort==2?'on':''?> fr">出售数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box">
                        <?=$sort==2?'点击按出售数从低到高排序':'点击按出售数从高到低排序'?>
                        </div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div>
                <div class="pr fl">
                    <a href="<?=$this->createUrl('shopList',['sort'=>$sort==4?3:4]+$_GET)?>" class="sort-btn sort-<?=$sort==3?'up':'down'?> <?=$sort==3||$sort==4?'on':''?> fr">出租数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box"><?=$sort==4?'点击按出租数从低到高排序':'点击按出租数从高到低排序'?></div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div>

                
            </div>
        </div>
        <ul class="zjmd-list">
        <?php if($shops) foreach ($shops as $key => $value) {?>
            <li>
                <dl>
                    <dt><a href="<?=$this->createUrl('/resoldhome/shop/index',['shop'=>$value['id']])?>" target="_blank">
                            <?php if($value['image']): ?>
                                <img src="<?=ImageTools::fixImage($value['image'],150,150)?>">
                            <?php else: ?>
                                <img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,150,150)?>">
                            <?php endif; ?>
                        </a></dt>
                    <dd>
                        <div class="name text-overflow"><a href="<?=$this->createUrl('/resoldhome/shop/index',['shop'=>$value['id']])?>" target="_blank"><?=$value['name']?></a></div>
                        <P>地址：<?=isset($value['address'])?$value['address']:''?></p>
                        <p>电话：<?=isset($value['phone'])?$value['phone']:''?></p>
                        <P>经纪人：<a href="<?=$this->createUrl('/resoldhome/shop/staffList',['shop'=>$value['id']])?>" target="_blank"><?=$value['staff_num']?></a> 人&nbsp;&nbsp;&nbsp;二手房信息：<a href="<?=$this->createUrl('/resoldhome/shop/esfList',['shop'=>$value['id']])?>" target="_blank"><?=$value['esf_num']?></a> 条&nbsp;&nbsp;&nbsp;租房信息：<a href="<?=$this->createUrl('/resoldhome/shop/zfList',['shop'=>$value['id']])?>" target="_blank"><?=$value['zf_num']?></a></a> 条</p>
                    </dd>
                </dl>
                <div class="btns">
                <?php $saveClass = ''; if(isset(Yii::app()->uc->user->uid) && ResoldUserCollectionExt::model()->count(['condition'=>'house_type=5 and house_id=:fid and uid=:uid','params'=>[':fid'=>$value['id'],':uid'=>Yii::app()->uc->user->uid]])) $saveClass = 'is_fav';?>
                    <a href="" class="btn1 j-fav-btn <?=$saveClass?>" data-fid='<?=$value['id']?>' data-category="5"><i class="iconfont"></i>收藏店铺</a>
                    <a href="<?=$this->createUrl('/resoldhome/shop/index',['shop'=>$value['id']])?>" target="_blank" class="btn2">查看门店房源</a>
                </div>
            </li>
        <?php }?>
            
        </ul>
        <div class="blank20"></div>
        <div class="page-box">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>

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
            <?php $this->widget('ViewRecordWidget',['url'=>'resoldhome/esf/info','cssType'=>3])?>
        </div>
        
        <div class="blank20"></div>
        <?php $this->widget('AdWidget',['position'=>'esfycbanner']); ?>
    </div>
</div>
