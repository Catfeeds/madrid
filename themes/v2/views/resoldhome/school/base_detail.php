<?php
$this->pageTitle =  $this->school->name;
Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/detail.css');
?>
<?php $this->widget('HomeBreadcrumbs',array('links'=>array(SM::urmConfig()->cityName().'二手房'=>$this->createUrl('/resoldhome/esf/list'),SM::urmConfig()->cityName().'邻校房'=>$this->createUrl('/resoldhome/school/index'),$this->school->name)));?>

<div class="line"></div>
<div class="blank20"></div>
<div class="wapper">
    <div class="detail_l">
        <div class="school-top">
            <div class="pic"><img src="<?php echo ImageTools::fixImage($this->school->image); ?>"></div>
            <div class="c-right">
                <div class="clearfix">
                    <p class="title"><?php echo $this->school->name ; ?></p>
                    <a class="erweima-btn">
                        <i class="detail-ico"></i>
                        <div class="erweima-expand">
                            <div class="erweima-box">
                                <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('/wap/#/schooldetail/'.$this->school->id)]); ?>">
                                <p>扫描二维码获取房源信息</p>
                            </div>
                        </div>
                    </a>
                    <div class="bdsharebuttonbox share-btn"><a href="#" class="bds_more" data-cmd="more"><i class="detail-ico"></i>分享</a></div>
                </div>
                <div class="tags clearfix">
                    <span class="color1"><?php echo SchoolExt::$type[$this->school->type] ?></span>
                    <?php if($this->school->important == 1): ?>
                        <span class="color2">区重点</span>
                    <?php endif; ?>
                </div>
                <div class="blank20"></div>
                <?php if(array_filter($this->school->map)): ?>
                    <div class="buy-box clearfix">
                        <div class="left">
                            <p class="price">均价<span><?php echo $this->school->map['min_ave_price'];?> — <?php echo $this->school->map['max_ave_price'];?></span>元/平</p>
                            <p class="go">最低<?php echo $this->school->map['min_price']; ?>万获得学区房<a href="" target="_blank">去看看</a></p>
                        </div>
                        <div class="right">
                            <p class="count"><?php echo $this->school->map['count']; ?> 套</p>
                            <p>学区房抢购中</p>
                        </div>
                    </div>
                <?php endif;  ?>
                <div class="info">
                    <p>学校地址：<?php echo $this->school->address; ?></p>
                    <p>对口小区：<em><?php echo $this->school->plotNumAll;?></em>个二手房小区&nbsp;&nbsp;<em><?php echo $this->school->plotNum;?></em>个新房小区<a href="" target="_blank">查看小区</a></p>
                    <p>学校电话：<span><?php echo $this->school->phone; ?></span></p>
                </div>
            </div>

        </div>
        <div class="blank40"></div>
        <div class="common-nav">
            <ul>
                <li class="link <?php if($this->getAction()->getId() == 'plot'){echo 'on'; }?>">
                    <a href="<?php echo $this->createUrl('/resoldhome/school/plot',array('pinyin'=>$this->school->pinyin));?>">对口小区</a>
                </li>
               <!-- <li class="link <?php /*if($this->getAction()->getId() == 'profile'){echo 'on'; }*/?>">
                    <a href="<?php /*echo $this->createUrl('/resoldhome/school/profile',array('pinyin'=>$this->school->pinyin));*/?>">招生简章</a>
                </li>-->
                <li class="link">
                    <a href="<?php echo $this->createUrl('/resoldhome/esf/list',array('school'=>$this->school->id));?>">二手房源</a>
                </li>
            </ul>
        </div>
        <?php echo $content; ?>
        
    </div>
    <div class="detail_r">
        <div class="s-common-title"><span>推荐二手房房源</span><a href="" target="_blank">更多&gt;</a></div>
        <ul class="tj-list">
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">135万</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">135万</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">135万</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">135万</p>
                    </div>
                </a>
            </li>
        </ul>
        <div class="s-common-title"><span>推荐租房房源</span><a href="" target="_blank">更多&gt;</a></div>
        <ul class="tj-list">
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">1355元/月</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">1355元/月</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">1355元/月</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <div class="pic"><img src="<?php echo $this->staticPath ?>/images/118x78.jpg"></div>
                    <div class="right">
                        <p class="title">怡康花园</p>
                        <p>4室2厅</p>
                        <p class="price">1355元/月</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="blank20"></div>
    <div class="frame">
        <div class="s-title"><span>湖塘地区小学</span></div>
        <div class="h-list">
            <div class="box">
                <a href="">湖塘桥中心小学</a><a href="">古方小学</a><a href="">古方小学</a><a href="">城东小学</a><a href="">湖塘桥实验小学</a><a href="">湖塘桥中心小学花园校区</a><a href="">卢家巷实验学校</a><a href="">马杭中心小学</a><a href="">常州市武进区鸣凰中心小学</a><a href="">湖塘桥第二实验小学</a><a href="">刘海粟小学</a><a href="">星河小学</a>
            </div>
        </div>
    </div>
    <div class="blank10"></div>
    <div class="shengming"><span>免责声明：</span>本网页所刊载的所有学校和房源信息均由网友提供，如您发现信息有误，请联络我们。</div>
</div>