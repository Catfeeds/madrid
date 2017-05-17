<?php
    $this->pageTitle = $seoArr['t'];
    $this->keyword = $seoArr['k'];
    $this->description = $seoArr['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/expert.css');
?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
    <form method="get" id="search-form" action="<?=$this->createUrl('/resoldhome/staff/staffList')?>">
        <div class="search-input fl">
            <input class="input" name="kw" value="" placeholder="请输入经纪人姓名">
        </div>
        <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
        </form>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>['经纪人列表']));?>
<div class="wapper">
	<div class="category-select">
        <dl class="clearfix">
          <dt>区域：</dt>
          <dd>
            <?php $this->widget('TagInfoWidget',['url'=>'/resoldhome/staff/staffList','cate'=>'area','get'=>$_GET,'id'=>$area?$area:$street])?>
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
                <p><a href="<?=$this->createUrl('staffList',['page'=>$page-1>0?$page-1:1]+array_filter($_GET))?>" title="上一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('staffList',['page'=>$page+1]+array_filter($_GET))?>" title="下一页">></a></p>
            </div>
            <ul class="clearfix">
              <li><a href="<?=$this->createUrl('staffList')?>" class="active">全部经纪人</a></li>
              <li><a href="<?=$this->createUrl('shopList')?>">中介门店</a></li>
            </ul>
        </div>
        <div class="sort">
            <span>找到<em class="c-main"><?=$staffCount?></em>个经纪人</span>
            <!-- <a href="" target="_blank" class="c-blue ml10">我也要出现在这里</a> -->
            <div class="filter fr mt8">
                <div class="pr fl">
                    <a href="<?=$this->createUrl('staffList',['sort'=>$sort==2?1:2]+$_GET)?>" class="sort-btn sort-<?=$sort==1?'up':'down'?> <?=$sort==1||$sort==2?'on':''?> fr">出售数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box">
                        <?=$sort==2?'点击按出售数从低到高排序':'点击按出售数从高到低排序'?>
                        </div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div>
                <div class="pr fl">
                    <a href="<?=$this->createUrl('staffList',['sort'=>$sort==4?3:4]+$_GET)?>" class="sort-btn sort-<?=$sort==3?'up':'down'?> <?=$sort==3||$sort==4?'on':''?> fr">出租数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box"><?=$sort==4?'点击按出租数从低到高排序':'点击按出租数从高到低排序'?></div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div>

            </div>
        </div>
        <?php if($staffs)
            foreach ($staffs as $key => $value) {?>
        <div class="jjr-list">
            <dl>
                <dt><a href="<?=$this->createUrl('esfList',['staff'=>$value->id])?>" target="_blank">
                        <?php if($value->image): ?>
                            <img src="<?=ImageTools::fixImage($value->image,150,180)?>">
                        <?php else: ?>
                            <img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,150,180)?>">
                        <?php endif; ?>
                    </a></dt>
                <dd>
                    <p class="title"><a href="<?=$this->createUrl('esfList',['staff'=>$value->id])?>" target="_blank"><?=$value->name?></a></p>
                    <p><span>电话：</span><?=$value->phone?></p>
                    <p><span>所属公司：</span><a target="_blank" href="<?=$this->createUrl('/resoldhome/shop/index',['shop'=>$value->sid])?>"><?= $value->shop ? $value->shop->name : '';?></a></p>
                    <p><span>上次登录：</span><?= $value->last_login ? date('Y-m-d',$value->last_login) : ''?></p>
                    <p><span>二手房信息：</span><a href="<?=$this->createUrl('esfList',['staff'=>$value->id])?>" target="_blank" class="c-red"><?=$staffEsfs = isset($value->uid) ? Yii::app()->db->createCommand('select count(id) from resold_esf where sale_status=1 and deleted=0 and expire_time>'.time().' and uid='.$value->uid)->queryScalar() : 0?></a> 条<span class="ml25">租房信息：</span><a href="<?=$this->createUrl('zfList',['staff'=>$value->id])?>" target="_blank" class="c-red"><?=$staffZfs = isset($value->uid) ? Yii::app()->db->createCommand('select count(id) from resold_zf where sale_status=1 and deleted=0 and expire_time>'.time().' and uid='.$value->uid)->queryScalar() : 0?></a> 条</p>
                    <p><a href="<?=$this->createUrl('esfList',['staff'=>$value->id])?>" target="_blank" class="c-red">进入TA的店铺 &gt;&gt;</a></p>
                </dd>
            </dl>
            <ul>
            <?php
            $staffInfos = [];
            $xs = Yii::app()->search->house_esf;
            $xs->setQuery('');
            $xs->addRange('sale_status',1,1);
            $xs->addRange('status',1,1);
            $xs->addRange('category',1,1);
            $xs->addRange('expire_time',time(),null);
            $xs->addRange('deleted',0,0);
            $xs->addRange('uid',$value->uid,$value->uid);
            $xs->setLimit(3);
            $xs->setMultiSort(['refresh_time'=>false]);
            if($docs = $xs->search()) {
                foreach ($docs as $key => $v) {
                    $staffInfos[] = ResoldEsfExt::model()->findByPk($v->id);
                }
            }
                ?>
                    <?php if($staffInfos) foreach ($staffInfos as $key => $v) {?>
                        <li>
                            <a href="<?=get_class($v)=='ResoldEsfExt'?$this->createUrl('/resoldhome/esf/info',['id'=>$v->id]):$this->createUrl('/resoldhome/zf/info',['id'=>$v->id])?>" target="_blank">
                                <div class="pic">
                                    <?php if($v->image): ?>
                                        <img src="<?=ImageTools::fixImage($v->image,120,90)?>">
                                    <?php else: ?>
                                        <img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,120,90)?>">
                                    <?php endif; ?>
                                </div>
                                <p class="name text-overflow"><?=$v->title?></p>
                                <p class="aside"><span class="cate"><?=$v->bedroom?>室<?=$v->livingroom?>厅</span><span class="area"><?=(int)$v->size?>m²</span></p>
                                <p class="price"><?=Tools::FormatPrice($v->price,'万')?></p>
                            </a>
                        </li>
                    <?php }?>
            </ul>
        </div>
        <?php }?>
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
<div class="blank20"></div>
