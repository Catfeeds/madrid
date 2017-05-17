<?php
    $this->pageTitle = '中介经纪人列表页';
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
            <li ><a href="<?=$this->createUrl('index',['shop'=>$shop->id])?>">门店首页</a></li>
            <li ><a href="<?=$this->createUrl('esfList',['shop'=>$shop->id])?>">二手房 (<?=$esfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('zfList',['shop'=>$shop->id])?>">租房 (<?=$zfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('staffList',['shop'=>$shop->id])?>"  class="on">经纪人 (<?=$staffNum?>)</a></li>
            <li><a href="<?=$this->createUrl('info',['shop'=>$shop->id])?>" >门店介绍</a></li>
        </ul>
    </div>
</div>
<div class="blank20"></div>
<div class="wapper ovisible">
    <div class="main-left">
        
        <div class="sort border-top">
            <span>找到<em class="c-main"><?=$staffNum?></em>个经纪人</span>
            <!-- <a href="<?=$this->createUrl('/resoldhome')?>" target="_blank" class="c-blue ml10">我也要出现在这里</a> -->
            <div class="pages-right">
            <p><a href="<?=$this->createUrl('staffList',['page'=>$page-1>0?$page-1:1,'shop'=>$shop->id])?>" title="上一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('staffList',['page'=>$page+1,'shop'=>$shop->id])?>" title="上一页">></a></p>
        </div>
            <div class="filter fr mt8">
                <!-- <div class="pr fl">
                    <a href="<?=$this->createUrl('/resoldhome')?>" class="sort-btn sort-up on">出售数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box">点击按出售数从高到低排序</div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div>
                <div class="pr fl">
                    <a href="<?=$this->createUrl('/resoldhome')?>" class="sort-btn sort-down fr">出租数<i></i></a>
                    <div class="tips-notice">
                        <div class="tips-box">点击按出租数从高到低排序</div>
                        <span class="bottom-arrow"><span></span></span>
                    </div>
                </div> -->
                
            </div> 
        </div>
        <?php if($staffs) 
            foreach ($staffs as $key => $value) {?>
        <div class="jjr-list">
            <dl>
                <dt><a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$value->id])?>" target="_blank"><img src="<?=ImageTools::fixImage($value->image)?>"></a></dt>
                <dd>
                    <p class="title"><a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$value->id])?>" target="_blank"><?=$value->name?></a></p>
                    <p><span>电话：</span><?=$value->phone?></p>
                    <p><span>所属公司：</span><?=$shop->name?></p>
                    <p><span>上次登录：</span><?=date('Y-m-d',$value->last_login)?></p>
                    <p><span>二手房信息：</span><a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$value->id])?>" target="_blank" class="c-red"><?=$staffEsfs = count($value->onsaleEsfs)?></a> 条<span class="ml25">租房信息：</span><a href="<?=$this->createUrl('/resoldhome/staff/zfList',['staff'=>$value->id])?>" target="_blank" class="c-red"><?=$staffZfs = count($value->onsaleZfs)?></a> 条</p>
                    <p><a href="<?=$this->createUrl('/resoldhome/staff/esflist',['staff'=>$value->id])?>" target="_blank" class="c-red">进入TA的店铺 &gt;&gt;</a></p>
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
                                <div class="pic"><img src="<?=ImageTools::fixImage($v->image)?>"></div>
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
                <span>二手房房源</span>
            </div>
            <?php $this->widget('StaffRightWidget', array('sid'=>$shop->id)) ?>
            <div class="dotted-line"></div>
            <?php $this->widget('StaffRightWidget', array('sid'=>$shop->id,'category'=>2)) ?>
            <div class="dotted-line"></div>
            <?php $this->widget('StaffRightWidget', array('sid'=>$shop->id,'category'=>3)) ?>
            
        </div>
        <div class="frame side-box">
            <div class="stitle">
                <span>租房房源</span>
            </div>
            <?php $this->widget('StaffRightWidget', array('type'=>2,'sid'=>$shop->id)) ?>
            <div class="dotted-line"></div>
            <?php $this->widget('StaffRightWidget', array('type'=>2,'sid'=>$shop->id,'category'=>2)) ?>
            <div class="dotted-line"></div>
            <?php $this->widget('StaffRightWidget', array('type'=>2,'sid'=>$shop->id,'category'=>3)) ?>
            
        </div>
        
    </div>     
</div> 