<?php
    $this->pageTitle = $seoArr['t'];
    $this->keyword = $seoArr['k'];
    $this->description = $seoArr['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/expert.css');
?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
        <form method="get" id="search-form">
            <div class="search-input fl">
                <input autocomplete="off" class="input" name="kw" placeholder="请输入二手房名称" data-type="1" data-url="<?=$this->createUrl('/api/resoldwapapi/plotsearchajax')?>" data-category="1">
            </div>
            <input type="hidden" name="type" value="1" />
            <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
            <div class="search-list-box"></div>
        </form>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>['经纪人列表'=>$this->createUrl('/resoldhome/staff/staffList'),$this->staff->name.'个人店铺']));?>
    <div class="wapper">
        
        <div class="line"></div>
        <div class="jjr-info">
            <dl>
                <dt><a href="javascript:;" target="_blank">
                        <?php if($staff->image): ?>
                            <img src="<?=ImageTools::fixImage($staff->image)?>">
                        <?php else: ?>
                            <img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic);?>">
                        <?php endif; ?>
                    </a></dt>
                <dd>
                <?php  
                $areaInfo = isset($staff->shop->areaInfo) ? $staff->shop->areaInfo : [];
                $streetInfo = isset($staff->shop->streetInfo) ? $staff->shop->streetInfo : [] ;
                ?>
                    <div class="title"><a href="" target="_blank"><?=$staff->name?></a><i class="detail-ico"></i></div>
                    <P>服务区域： <span><?=$areaInfo?$areaInfo->name:''?><?php if($streetInfo && $areaInfo && $streetInfo->getParentArea()->id == $areaInfo->id):?> <?=$streetInfo->name?></span><?php endif;?></P>
                    <p>所属公司： <span><a target="_blank" href="<?=$this->createUrl('/resoldhome/shop/index',['shop'=>$staff->sid])?>"><?=$staff->shop?$staff->shop->name:'--'?></a></span> </p>
                    <a href="javascript:void(0)" class="save-jjr-btn j-fav-btn" data-fid="<?=$staff->id?>" data-category="4"><i class="iconfont"></i>收藏经纪人</a>
                </dd>
            </dl>
            <div class="tel-box">
                <div class="tel-l"><i class="detail-ico tel-ico"></i></div>
                <div class="tel-r"><?=$staff->phone?></div>
            </div>
            <!--div class="phone-shop">
                <span>手机店铺</span>
                <div class="erweima"><img src="images/100x100.jpg"></div>
            </div-->
        </div>
    </div>

    <div class="wapper">
        <div class="main-left">
            <div class="next-tabs clearfix">
                
                <ul class="clearfix">
                  <li><a href="<?=$this->createUrl('esfList',['staff'=>$staff->id])?>" class="active">二手房</a></li>
                  <li><a href="<?=$this->createUrl('zfList',['staff'=>$staff->id])?>">租房</a></li>               
                </ul>
            </div>
            <div class="sort">
                <span><?=$plot?('关于<em class="c-main">'.$plot->title.'</em>共'):''?>找到<em class="c-main"><?=$count?></em>套房源</span>
                
                <div class="filter fr mt8">
                    <div class="fl paixu">
                        <p>排序：<a href="<?=$this->createUrl('esflist',['staff'=>$get['staff'],'sort'=>'1'])?>" class="<?=$get['sort']==1?'on':''?>">按更新时间</a>
                            <a href="<?=$this->createUrl('esflist',['staff'=>$get['staff'],'sort'=>'2'])?>" class="<?=$get['sort']==2?'on':''?>">按发布时间</a></p>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('esflist',['staff'=>$get['staff'],'sort'=>$get['sort']==3?4:3])?>" class="sort-btn price-btn sort-<?=$get['sort']==4?'up':'down'?> <?=($get['sort']==4 || $get['sort']==3)?'on':'fr'?>">总价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==3?'点击按总价从低到高排序':'点击按总价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('esflist',['staff'=>$get['staff'],'sort'=>$get['sort']==5?6:5])?>" class="sort-btn price-btn sort-<?=$get['sort']==6?'up':'down'?> <?=($get['sort']==5 || $get['sort']==6)?'on':'fr'?>">单价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==5?'点击按单价从低到高排序':'点击按单价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('esflist',['staff'=>$get['staff'],'sort'=>$get['sort']==7?8:7])?>" class="sort-btn size-btn sort-<?=$get['sort']==8?'up':'down'?> <?=($get['sort']==7 || $get['sort']==8)?'on':'fr'?>">面积<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==7?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>

                </div>
            </div>
            <ul class="item-list">
            <?php if($esfs)
                    foreach ($esfs as $key => $v) {?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <div class="content fl">
                            <p class="title"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                            <p class="detail"><span><?php if($v->bedroom):?><?=$v->bedroom?>室<?=$v->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$v->category]?><?php endif;?></span><em>|</em><span><?=isset($v->getEsfTag()['floorcate'])?$v->getEsfTag()['floorcate']['name']:$v->floor?>/<?=$v->total_floor?>层</span><em>|</em><span><?php $face = TagExt::model()->findByPk($v->towards);echo isset($face)?$face->name:'暂无'?></span><em>|</em><span>建筑年代：<?=$v->age?$v->age:'暂无'?></span></p>
                            <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/index',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href=""><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);
                                ?>更新</span>
                            </p>
                            <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue','green','pink','blue','green','pink','blue','green','pink','blue'];$data_conf = json_decode($v->data_conf,true);$tss = [];
                                if(isset($data_conf['tags']) && $data_conf['tags'])
                                    foreach ($data_conf['tags'] as $key => $value) {
                                        if(TagExt::getCateByTag($value)=='esfzzts')
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
                                  <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'万')?></em></p>
                                  <p class="tag"><?=$v->ave_price?$v->ave_price.'元/㎡':""?></p>
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

        <div class="main-right mt47">
            <div class="frame side-box">
                <div class="stitle">
                    <span>二手房楼盘</span>
                </div>
                <?php $this->widget('StaffRightWidget',['uid'=>$staff->uid]);?>
                <div class="dotted-line"></div>
                <?php $this->widget('StaffRightWidget',['uid'=>$staff->uid,'category'=>2,'sid'=>$staff->shop?$staff->shop->id:0]);?>
                <div class="dotted-line"></div>
                <?php $this->widget('StaffRightWidget',['uid'=>$staff->uid,'category'=>3,'sid'=>$staff->shop?$staff->shop->id:0]);?>
            </div>
            
        </div>     
    </div>
    <div class="blank20"></div>