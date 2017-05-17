<?php
    $this->pageTitle = '中介二手房列表页';
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
            <li ><a href="<?=$this->createUrl('esfList',['shop'=>$shop->id])?>"   class="on">二手房 (<?=$esfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('zfList',['shop'=>$shop->id])?>" >租房 (<?=$zfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('staffList',['shop'=>$shop->id])?>" >经纪人 (<?=$staffNum?>)</a></li>
            <li><a href="<?=$this->createUrl('info',['shop'=>$shop->id])?>" >门店介绍</a></li>
        </ul>
    </div>
</div>
<div class="blank20"></div>
    <div class="wapper overvisible">
        <div class="main-left">
            
            <div class="sort border-top">
                <span>找到<em class="c-main"><?=$esfNum?></em>套房源</span>
                
                <div class="filter fr mt8">
                    <div class="fl paixu">
                        <p>排序：<a href="<?=$this->createUrl('esflist',['shop'=>$get['shop'],'sort'=>'1'])?>" class="<?=$get['sort']==1?'on':''?>">按更新时间</a>
                            <a href="<?=$this->createUrl('esflist',['shop'=>$get['shop'],'sort'=>'2'])?>" class="<?=$get['sort']==2?'on':''?>">按发布时间</a></p>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('esflist',['shop'=>$get['shop'],'sort'=>$get['sort']==3?4:3])?>" class="sort-btn price-btn sort-<?=$get['sort']==4?'up':'down'?> <?=($get['sort']==4 || $get['sort']==3)?'on':'fr'?>">总价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==3?'点击按总价从低到高排序':'点击按总价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('esflist',['shop'=>$get['shop'],'sort'=>$get['sort']==5?6:5])?>" class="sort-btn price-btn sort-<?=$get['sort']==6?'up':'down'?> <?=($get['sort']==5 || $get['sort']==6)?'on':'fr'?>">单价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==5?'点击按单价从低到高排序':'点击按单价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('esflist',['shop'=>$get['shop'],'sort'=>$get['sort']==7?8:7])?>" class="sort-btn size-btn sort-<?=$get['sort']==8?'up':'down'?> <?=($get['sort']==7 || $get['sort']==8)?'on':'fr'?>">面积<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==7?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>

                </div>
            </div>
            <ul class="item-list">
            <?php
                $esfTags = [];
                $allTags = TagExt::tagCache();
                foreach($allTags as $key=>$value){
                    $esfTags[$value->id] = ['cate'=>$value->cate,'name'=>$value->name];
                }

            ?>
            <?php if($esfs):?>
                    <?php foreach ($esfs as $key => $v):?>
                    <?php
                        //获取当前对象的data_conf
                        $esftag = [];
                        $data_conf = CJSON::decode($v->data_conf);
                        if(isset($data_conf['tags']))
                        foreach($data_conf['tags'] as $key=>$value){
                            if(isset($esfTags[$value]) && isset($esfTags[$value]['cate'])) {
                                $cate = $esfTags[$value]['cate'];
                                if(!isset($esftag[$cate])){
                                    $esftag[$cate]=[];
                                }
                                array_push($esftag[$cate],$esfTags[$value]['name']);
                            }
                        }
                        //var_dump($esftag);
                    ?>
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
                            <p class="detail"><span><?=$v->bedroom?>室<?=$v->livingroom?>厅<?=$v->bathroom?>卫</span><em>|</em><span><?=$v->size?$v->size.'㎡':'暂无'?></span><em>|</em>
                                <?=isset($esftag['esffloorcate'])?$esftag['esffloorcate'][0]:'暂无';?>
                                <?php if($v->total_floor > 0 ): ?>
                                    /共<?=$v->total_floor?>层
                                <?php endif; ?>
                            </p>
                            <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area])?>"><?=$v->area?$v->areaInfo->name:'';?></a>
                                <span>
                                    <a href="<?=$this->createUrl('list',['street'=>$v->street])?>">
                                        <?=$v->street?$v->streetInfo->name:'';?>
                                    </a>
                                </span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/esfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);
                                ?>更新</span>
                            </p>
                            <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];;
                                    $tss = isset($esftag['esfzzts'])?$esftag['esfzzts']:[];
                                ?>
                                <?php if($tss)
                                        {?>
                                <p class="tags">
                                    <?php
                                            $i = 0;
                                            foreach ($tss as $key => $v1) {
                                                if($i==5) break;
                                                ?>
                                                <span class="<?=$colorArr[$i]?>"><?=$v1?></span>
                                            <?php $i++;}?>
                                </p>
                                        <?php }?>
                            <div class="about-price">
                                  <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>万')?></p>
                                      <p class="tag"><?=$v->ave_price&&$v->ave_price!='0.00'?$v->ave_price.'元/㎡':""?></p>
                             </div>
                        </div>
                    </li>
                <?php endforeach; endif;?>

                </ul>
            <div class="blank20"></div>
            <div class="page-box">
                <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
            </div>
        </div>

        <div class="main-right">
            <div class="frame side-box">
                <div class="stitle">
                    <span>二手房房源</span>
                </div>
                <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/esf/info','sid'=>$shop->id)) ?>
                <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/esf/info','sid'=>$shop->id,'category'=>2)) ?>
                <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/esf/info','sid'=>$shop->id,'category'=>3)) ?>
                
            </div>
            
        </div>     
    </div>