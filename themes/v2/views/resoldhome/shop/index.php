<?php
    $this->pageTitle = $seoArr['t'];
    $this->keyword = $seoArr['k'];
    $this->description = $seoArr['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/expert.css');
?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
    <form method="get" id="search-form" action="<?=$this->createUrl('/resoldhome/esf/list')?>">
        <div class="search-input fl">
            <input class="input" name="kw" value="" placeholder="请输入二手房名称">
        </div>
        <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
        </form>
        <div class="search-list-box">
        </div>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>[$shop->name]));?>
<div class="wapper overvisible">
    <div class="zj-head">
        <dl>
            <dt><img src="<?=ImageTools::fixImage($shop->image)?>"></dt>
            <dd>
                <p class="title"><?=$shop->name?></p>
                <p class="ads"><span>区域：<?=$shop->areaInfo?$shop->areaInfo->name:'--'?></span><span><i class="detail-ico addr-ico"></i>地址：<?=$shop->address?></span>  <span>电话：<em><?=$shop->phone?></em></span></p>
            </dd>
        </dl>
        <div class="operate">
            <a class="erweima-btn">
                <i class="detail-ico"></i>
                <div class="erweima-expand">
                    <div class="erweima-box">
                        <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl(Yii::app()->request->getUrl())]); ?>">
                        <p>扫描二维码获取房源信息</p>
                    </div>
                </div>
            </a>
            <div class="bdsharebuttonbox share-btn bdshare-button-style0-16" data-bd-bind="1477548223785"><a href="#" class="bds_more" data-cmd="more"><i class="detail-ico"></i>分享</a></div>
            <?php $saveClass = ''; if(isset(Yii::app()->uc->user->uid) && ResoldUserCollectionExt::model()->count(['condition'=>'house_type=5 and house_id=:fid and uid=:uid','params'=>[':fid'=>$shop['id'],':uid'=>Yii::app()->uc->user->uid]])) $saveClass = 'is_fav';?>
            <a href="javascript:void(0)" class="save-btn j-fav-btn <?=$saveClass?>" data-fid="<?=$shop->id?>" data-category="5"><i class="iconfont"></i>收藏店铺</a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="zj-nav">
        <ul>
            <li ><a href="<?=$this->createUrl('index',['shop'=>$shop->id])?>"  class="on">门店首页</a></li>
            <li ><a href="<?=$this->createUrl('esfList',['shop'=>$shop->id])?>" >二手房 (<?=$this->esfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('zfList',['shop'=>$shop->id])?>">租房 (<?=$this->zfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('staffList',['shop'=>$shop->id])?>" >经纪人 (<?=$this->staffNum?>)</a></li>
            <li><a href="<?=$this->createUrl('info',['shop'=>$shop->id])?>" >门店介绍</a></li>
        </ul>
    </div>
<!--    <div class="common-title"><span>最新发布房源</span><em class="new-record">最近15天发布二手房：<?/*=$latestEsfCount*/?>套&nbsp;&nbsp;租房：<?/*=$latestZfCount*/?>套</em><a href="<?/*=$this->createUrl('esfList',['shop'=>$shop->id])*/?>" target="_blank" class="more">查看最新房源 &gt;</a></div>
    <div class="fang-list long-list">
        <ul>
        <?php /*if($latestEsfs): foreach ($latestEsfs as $key => $value) {*/?>
        	<li>
                <a href="<?/*=$this->createUrl('/resoldhome/esf/info',['id'=>$value->id])*/?>">
                    <div class="pic">
                        <img src="<?/*=ImageTools::fixImage($value->image,200,150)*/?>" alt="">
                    </div>
                    <div class="info">
                        <div class="h-title fs16"><?/*=$value->title*/?></div>
                        <div class="aside">
                            <div class="cate"><?php /*if($value->bedroom):*/?><?/*=$value->bedroom*/?>室<?/*=$value->livingroom*/?>厅<?php /*else:*/?><?/*=Yii::app()->params['category'][$value->category]*/?><?php /*endif;*/?></div>
                            <div class="area"><?/*=(int)$value->size*/?>m²</div>
                            <div class="price"><?/*=Tools::formatPrice($value->price,'万')*/?></div>
                        </div>
                    </div>
                </a>
            </li>
        <?php /*}*/?>

        <?php /*endif;*/?>
        </ul>

    </div>-->

    <?php if($latestEsfs):  ?>
    <div class="common-title"><span>最新发布二手房<em>(<?=$this->esfNum?>)</em></span><a href="<?=$this->createUrl('esfList',['shop'=>$shop->id])?>" class="more">更多二手房 &gt;</a></div>
    <div class="fang-list long-list">
     <ul>
        <?php foreach ($latestEsfs as $key => $value) {?>
        	<li>
                <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value->id])?>">
                    <div class="pic">
                        <img src="<?=ImageTools::fixImage($value->image,200,150)?>" alt="">
                    </div>
                    <div class="info">
                        <div class="h-title fs16"><?=$value->title?></div>
                        <div class="aside">
                            <div class="cate"><?php if($value->bedroom):?><?=$value->bedroom?>室<?=$value->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$value->category]?><?php endif;?></div>
                            <div class="area"><?=(int)$value->size?>m²</div>
                            <div class="price"><?=Tools::formatPrice($value->price,'万')?></div>
                        </div>
                    </div>
                </a>
            </li>
        <?php }?>

        </ul>
    </div>
    <?php endif;?>
    <?php if($latestZfs):  ?>
    <div class="common-title"><span>最新发布租房<em>(<?=$this->zfNum?>)</em></span><a href="<?=$this->createUrl('zfList',['shop'=>$shop->id])?>" class="more">更多租房 &gt;</a></div>
    <div class="fang-list long-list">
     <ul>
        <?php foreach ($latestZfs as $key => $value) {?>
        	<li>
                <a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$value->id])?>">
                    <div class="pic">
                        <img src="<?=ImageTools::fixImage($value->image,200,150)?>" alt="">
                    </div>
                    <div class="info">
                        <div class="h-title fs16"><?=$value->title?></div>
                        <div class="aside">
                            <div class="cate"><?php if($value->bedroom):?><?=$value->bedroom?>室<?=$value->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$value->category]?><?php endif;?></div>
                            <div class="area"><?=(int)$value->size?>m²</div>
                            <div class="price"><?=Tools::formatPrice($value->price,'元/月')?></div>
                        </div>
                    </div>
                </a>
            </li>
        <?php }?>
        </ul>
    </div>
    <?php endif;?>
    <?php if($staffs): ?>
    <div class="common-title"><span>金牌经纪人</span><a href="<?=$this->createUrl('staffList',['shop'=>$shop->id])?>" target="_blank" class="more">更多经纪人 &gt;</a></div>
    <div class="jinpai-list">
        <ul class="clearfix">
        <?php  foreach ($staffs as $key => $value) {?>
        	<li>
                <a target="_blank" href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$value->id])?>"><img src="<?=ImageTools::fixImage($value->image,150,180)?>"><?=$value->name?></a>
            </li>
        <?php }?>
        </ul>
    </div>
    <?php endif; ?>
</div>