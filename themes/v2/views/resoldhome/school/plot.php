<?php
$this->pageTitle =  SM::urmConfig()->cityName.$school->name.'附近二手房/小区详情/招生简章|'.$school->name.'- '.SM::urmConfig()->cityName.SM::globalConfig()->siteName;
$this->keyword = $school->name.'，小区详情，招生简章，'.$school->name.'附近二手房';
$this->description  = SM::globalConfig()->siteName.SM::urmConfig()->cityName.'二手房网为您提供最新、最全的'.$school->name.'附近二手房出售信息以及'.$school->name.'招生简章、入学条件等信息。查找'.$school->name.'小区出售信息，就到'.SM::globalConfig()->siteName.SM::urmConfig()->cityName.'二手房网！';
Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/detail.css');
?>
<?php $this->widget('HomeBreadcrumbs',array('links'=>array(SM::urmConfig()->cityName().'二手房'=>$this->createUrl('/resoldhome/esf/list'),SM::urmConfig()->cityName().'邻校房'=>$this->createUrl('/resoldhome/school/index'),$school->name)));?>

<div class="line"></div>
<div class="blank20"></div>
<div class="wapper">
    <div class="detail_l">
        <div class="school-top">
            <div class="pic"><img src="<?php echo ImageTools::fixImage($school->image); ?>"></div>
            <div class="c-right">
                <div class="clearfix">
                    <p class="title"><?php echo $school->name ; ?></p>
                    <a class="erweima-btn">
                        <i class="detail-ico"></i>
                        <div class="erweima-expand">
                            <div class="erweima-box">
                                <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('/resoldwap/#/schooldetail/'.$school->id)]); ?>">
                                <p>扫描二维码获取房源信息</p>
                            </div>
                        </div>
                    </a>
                    <div class="bdsharebuttonbox share-btn"><a href="#" class="bds_more" data-cmd="more"><i class="detail-ico"></i>分享</a></div>
                </div>
                <div class="tags clearfix">
                    <span class="color1"><?php echo SchoolExt::$type[$school->type] ?></span>
                    <?php if($school->important == 1): ?>
                        <span class="color2">区重点</span>
                    <?php endif; ?>
                </div>
                <div class="blank20"></div>
                <?php if($price): ?>
                    <div class="buy-box clearfix">
                        <div class="left">
                            <p class="price">均价<span><?php echo min($price);?> — <?php echo max($price);?></span>元/平</p>
                            <p class="go">最低<?php echo min($price); ?>元/平获得学区房<a href="<?php echo $this->createUrl('/resoldhome/esf/list',array('school'=>$school->id));?>" target="_blank">去看看</a></p>
                        </div>
                        <div class="right">
                            <p class="count"><?php echo $school->esf_num; ?> 套</p>
                            <p>学区房抢购中</p>
                        </div>
                    </div>
                <?php endif;  ?>
                <div class="info">
                    <p>学校地址：<?php echo $school->address; ?></p>
                    <p>对口小区：<em><?php echo $school->plotNumAll;?></em>个二手房小区&nbsp;&nbsp;<em><?php echo $school->plotNum;?></em>个新房小区</p>
                    <p>学校电话：<span><?php echo $school->phone; ?></span></p>
                </div>
            </div>

        </div>
        <div class="blank40"></div>
        <div class="common-nav">
            <ul>
                <li class="link <?php if($this->getAction()->getId() == 'plot'){echo 'on'; }?>">
                    <a href="<?php echo $this->createUrl('/resoldhome/school/plot',array('pinyin'=>$school->pinyin));?>">对口小区</a>
                </li>
                 <li class="link <?php if($this->getAction()->getId() == 'profile'){echo 'on'; }?>">
                    <a href="<?php echo $this->createUrl('/resoldhome/school/profile',array('pinyin'=>$school->pinyin));?>">招生简章</a>
                </li>
                <li class="link">
                    <a href="<?php echo $this->createUrl('/resoldhome/esf/list',array('school'=>$school->id));?>">二手房源</a>
                </li>
                <li class="link">
                    <a href="<?php echo $this->createUrl('/resoldhome/zf/list',array('school'=>$school->id));?>">租房房源</a>
                </li>
                <li class="link">
                    <a target="_blank" href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$school->pinyin));?>">买新房</a>
                </li>
            </ul>
        </div>
        <div class="school-box">
            <ul class="school-list">
                <?php foreach ($list as $value): ?>
                    <li>
                        <div class="pic">
                            <a href="<?php echo $this->createUrl('/resoldhome/plot/index',array('py'=>$value->pinyin));?>" target="_blank">
                            <img src="<?=ImageTools::fixImage($value->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'">
                            </a>
                        </div>
                        <div class="right">
                            <div class="title-box"><a href="<?php echo $this->createUrl('/resoldhome/plot/index',array('py'=>$value->pinyin));?>" target="_blank" class="title"><?php echo Tools::u8_title_substr($value->title,50); ?></a><a href="<?php echo $this->createUrl('/resoldhome/plot/pesflist',array('py'=>$value->pinyin));?>" target="_blank" class="count"><?php echo $value->lastResoldData ? $value->lastResoldData->esf_num:0;?>套在售房源&gt;&gt;</a></div>
                            <div class="info"><span><i class="detail-ico price-ico"></i>小区均价：<?php echo $value->avg_esf  ? '<em>'.$value->avg_esf->price.'</em>元/㎡' : '<em>暂无</em>';?> </span><span><i class="detail-ico addr-ico"></i>距离学校：<?php echo $value->getDistance($school->map_lat, $school->map_lng, $value->map_lat, $value->map_lng);?> km</span></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="blank20"></div>
            <div class="page-box">
                <?php $this->widget('HomeLinkPager', array('pages'=>$pages)); ?>
            </div>
        </div>

    </div>
    <div class="detail_r">
        <?php $this->widget('SchoolRightWidget',['type'=>1,'relatedid'=>$school->id]); ?>
        <?php $this->widget('SchoolRightWidget',['type'=>2,'relatedid'=>$school->id]);?>
    </div>
    <div class="blank20"></div>
    <div class="shengming"><span>免责声明：</span>本网页所刊载的所有学校和房源信息均由网友提供，如您发现信息有误，请联络我们。</div>
</div>