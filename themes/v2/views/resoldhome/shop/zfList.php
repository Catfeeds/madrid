<?php
    $this->pageTitle = '中介租房列表页';
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/expert.css');
?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
    <form method="get" id="search-form" action="<?=$this->createUrl('/resoldhome/zf/list')?>">
        <div class="search-input fl">
            <input class="input" name="kw" value="" placeholder="请输入租房名称">
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
                        <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('www.baidu.com')]); ?>">
                        <p>扫描二维码获取房源信息</p>
                    </div>
                </div>
            </a>
            <div class="bdsharebuttonbox share-btn bdshare-button-style0-16" data-bd-bind="1477548223785"><a href="#" class="bds_more" data-cmd="more"><i class="detail-ico"></i>分享</a></div>
            <a href="javascript:void(0)" class="save-btn j-fav-btn" data-fid="<?=$shop->id?>" data-category="5">收藏店铺</a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="zj-nav">
        <ul>
            <li ><a href="<?=$this->createUrl('index',['shop'=>$shop->id])?>" >门店首页</a></li>
            <li ><a href="<?=$this->createUrl('esfList',['shop'=>$shop->id])?>" >二手房 (<?=$esfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('zfList',['shop'=>$shop->id])?>"  class="on">租房 (<?=$zfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('staffList',['shop'=>$shop->id])?>" >经纪人 (<?=$staffNum?>)</a></li>
            <li><a href="<?=$this->createUrl('info',['shop'=>$shop->id])?>" >门店介绍</a></li>
        </ul>
    </div>
</div>
<div class="blank20"></div>
    <div class="wapper overvisible">
        <div class="main-left">
            
            <div class="sort border-top">
                <span>找到<em class="c-main"><?=$zfNum?></em>套房源</span>
                
                <div class="filter fr mt8">
                    <div class="fl paixu">
                        <p>排序：<a href="<?=$this->createUrl('zflist',['shop'=>$get['shop'],'sort'=>'1'])?>" class="<?=$get['sort']==1?'on':''?>">按更新时间</a>
                            <a href="<?=$this->createUrl('zflist',['shop'=>$get['shop'],'sort'=>'2'])?>" class="<?=$get['sort']==2?'on':''?>">按发布时间</a></p>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('zflist',['shop'=>$get['shop'],'sort'=>$get['sort']==3?4:3])?>" class="sort-btn price-btn sort-<?=$get['sort']==4?'up':'down'?> <?=($get['sort']==4 || $get['sort']==3)?'on':'fr'?>">租金<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==3?'点击按租金从低到高排序':'点击按租金从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('zflist',['shop'=>$get['shop'],'sort'=>$get['sort']==5?6:5])?>" class="sort-btn size-btn sort-<?=$get['sort']==6?'up':'down'?> <?=($get['sort']==5 || $get['sort']==6)?'on':'fr'?>">面积<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==5?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>


                </div>
            </div>
            <ul class="item-list">
            <?php if($zfs)
                    foreach ($zfs as $key => $v) {?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <div class="content fl">
                            <p class="title"><a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                            <p class="detail"><span><?php if($v->bedroom):?><?=$v->bedroom?>室<?=$v->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$v->category]?><?php endif;?></span><em>|</em><span><?=$v->esffloorcate?TagExt::getNameByTag($v->esffloorcate):$v->floor?>/<?=$v->total_floor?>层</span><em>|</em><span><?php $face = TagExt::model()->findByPk($v->towards);echo isset($face)?$face->name:'暂无'?></span><em>|</em><span>建筑年代：<?=$v->age?$v->age:'暂无'?></span></p>
                            <p class="area"><a><?=$v->plot_name?></a><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/esfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);
                                ?>更新</span>
                            </p>
                            <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];$data_conf = json_decode($v->data_conf,true);$tss = [];
                                if(isset($data_conf['tags']) && $data_conf['tags'])
                                    foreach ($data_conf['tags'] as $key => $value) {
                                        if(TagExt::getCateByTag($value)=='zfzzts')
                                            $tss[] = TagExt::getNameByTag($value);
                                    }
                            ?>
                            <p class="tags">
                            <?php if($tss)
                                {
                                    $i = 0;
                                    foreach ($tss as $key => $v1) {?>
                                        <span class="<?=$colorArr[$i]?>"><?=$v1?></span>
                                    <?php $i++;}
                                }?>

                            </p>
                            <div class="area-detail"><p><?=isset($v->size)?(int)$v->size:"-"?>㎡</p><p class="tag">建筑面积</p></div>
                            <div class="about-price">
                                  <p class=""><em class="prices"><?=$v->price?((int)$v->price.'</em>元/月'):"面议</em>"?></p>
                                  <!-- <p class="tag"><?=isset($v->ave_price)?$v->ave_price:"-"?>元/㎡</p> -->
                             </div>
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
                    <span>租房房源</span>
                </div>
                <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/zf/info','sid'=>$shop->id,'type'=>2)) ?>
                <div class="dotted-line"></div>
                <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/zf/info','sid'=>$shop->id,'category'=>2,'type'=>2)) ?>
                <div class="dotted-line"></div>
                <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/zf/info','sid'=>$shop->id,'category'=>3,'type'=>2)) ?>
                
            </div>
            
        </div>     
    </div>