<?php
    $this->pageTitle = '中介公司介绍页';
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
            <li><a href="<?=$this->createUrl('zfList',['shop'=>$shop->id])?>" >租房 (<?=$zfNum?>)</a></li>
            <li><a href="<?=$this->createUrl('staffList',['shop'=>$shop->id])?>">经纪人 (<?=$staffNum?>)</a></li>
            <li><a href="<?=$this->createUrl('info',['shop'=>$shop->id])?>"  class="on">门店介绍</a></li>
        </ul>
    </div>
</div>
 <div class="blank20"></div>
    <div class="wapper">
        <div class="main-left">
            <div class="common-title"><span>门店介绍</span></div>
            <div class="zj-content">
                <?=$shop->description?>
            </div>
            <!-- <div class="common-title"><span>店长专访</span></div>
            <div class="zj-content">
                满意房产：让大众满意，服务满意，买房卖房都满意
在“让大众满意，服务满意，买房卖房都满意”的口号下，2010年6月份满意房产应运而生。 满意房产从6月份开始迅速占领常州武进、钟楼、天宁地区。坚持要求员工工作服、车辆统一，严格要求员工，高要求，高质量、高服务、高档次的服务！中凉、清凉、南都、兰陵、勤业、湖塘、荆川、五角场、人民路、清山湾、定安路、府琛、新城逸境等分公司的开启，满意房产快速发展，打造常州品牌中介，勇争服务第一!
满意房产员工出行是一大特色，被客户所赞不绝口，就是标志性的统一服装、统一车辆，无论到哪里看房，都能看到满意房产员工矫健的身姿和热情的服务！服装和车辆都是公司配备，让员工在服务客户的时候，从表到里、从外到里都给客户传达专业服务的信息。
            </div> -->
            <div class="common-title"><span>店面掠影</span></div>
            <div class="zj-photo">
                <ul>
                <?php if($images = $shop->images) foreach ($images as $key => $value) {?>
                    <li><img src="<?=ImageTools::fixImage($value->url)?>"></li>
                <?php } ?>
                </ul>
            </div>
        </div>

        <div class="main-right">
        <div class="frame side-box">
            <div class="stitle">
                <span>二手房房源</span>
            </div>
            <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/esf/info','sid'=>$shop->id)) ?>
            <div class="dotted-line"></div>
            <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/esf/info','sid'=>$shop->id,'category'=>2)) ?>
            <div class="dotted-line"></div>
            <?php $this->widget('StaffRightWidget', array('url'=>'/resoldhome/esf/info','sid'=>$shop->id,'category'=>3)) ?>
            
        </div>
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
