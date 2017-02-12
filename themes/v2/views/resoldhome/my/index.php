<?php
    $this->pageTitle = '首页';
?>
<div class="userinfo">
    <span class="ava"><img src="<?php echo ImageTools::fixImage(Yii::app()->uc->user->icon); ?>" alt="" width="50px" height="50px" /></span>
    <span class="username"><?php echo Yii::app()->uc->user->username; ?></span>
</div>
<!--我的管理-->
<div class="my-content-manage">
    <div class="my-fav-manage">我的收藏：在最近一个月内，您共有 <span class="num"><?php echo $collect_count;?></span> 个收藏记录，请到"<a href="<?php echo $this->createUrl('/resoldhome/mycollect/index'); ?>" class="link">我的收藏</a>"中查看。</div>
    <div class="my-house-manage">房源管理：共发布了 <span class="num"><?php echo $esf_count;?></span> 条二手房信息，请点击"<a href="<?php echo $this->createUrl('/resoldhome/myesf/sellindex');?>" class="link">二手房管理</a>"查看和修改</div>
</div>
<!--我感兴趣的房源-->
<div class="my-ist-house">
    <div class="title"><span>你可能感兴趣的房源</span></div>
    <div class="fang-list">
        <ul class="change-sub-box clearfix">
            <?php $infos = ResoldEsfExt::model()->findAll(['condition'=>'category=1','order'=>'sale_time desc','limit'=>4]); if($infos) foreach ($infos as $key => $value) {?>
                <li>
                    <a href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value->id])?>">
                        <div class="pic">
                            <img src="<?=ImageTools::fixImage($value->image,200,150)?>" alt="">
                        </div>
                        <div class="info">
                            <div class="h-title"><span><?=$value->areaInfo?$value->areaInfo->name:''?></span><span><?=$value->title?></span></div>
                            <div class="aside">
                                <div class="cate"><?=$value->bedroom?>室<?=$value->livingroom?>厅</div>
                                <div class="area"><?=$value->size?>m²</div>
                                <div class="price"><?=$value->price?>万</div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php }?>

        </ul>
    </div>
</div>
<!--我最近浏览的房源-->
<div class="my-query-house">
    <div class="title"><span>我最近浏览的房源</span></div>
    <div class="fang-list">
        <?php $this->widget('ViewRecordWidget',['type'=>0,'cssType'=>2])?>
    </div>
</div>