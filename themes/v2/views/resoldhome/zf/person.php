<div class="detail_r">
    <a class="erweima-btn">
        <i class="detail-ico"></i>
        <div class="erweima-expand">
            <div class="erweima-box">
<?php $plotPinyin = $this->zf->plot->pinyin;?>
                <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl(Yii::app()->request->getUrl())]); ?>">
                <p>扫描二维码获取房源信息</p>
            </div>
        </div>
    </a>
    <div class="bdsharebuttonbox share-btn"><a href="#" class="bds_more" data-cmd="more"><i class="detail-ico"></i>分享</a>
    </div>
    <div class="blank10"></div>
    <?php if($this->staff):?>
    <div class="publisher-box">
        <div class="people"><a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$this->staff->id])?>" target="_blank"><img src="<?=ImageTools::fixImage($this->staff?$this->staff->image:$user['icon'])?>"><?=$this->zf->username?$this->zf->username:$this->zf->account?></a></div>

            <?php if($this->staff->id_card || $this->staff->licence):?>
                <div class="renzheng">
                    <em>认证：</em><?php if($this->staff->id_card): ?><span><i class="detail-ico sfz-ico"></i>身份证</span><?php endif;?><?php if($this->staff->licence): ?><span><i class="detail-ico zgz-ico"></i>资格证</span><?php endif;?>
                </div>
            <?php endif;?>

        <div class="btns">
            <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$this->staff->qq?>&amp;site=qq&amp;menu=yes" target="_blank"
               class="qq-btn">QQ联系</a>
            <a href="<?=$this->createUrl('shop/index',['shop'=>$this->staff->shop?$this->staff->shop->id:0])?>" target="_blank" class="enter-btn">进入店铺</a>
        </div>
        <div class="clearfix">
            <div class="count-box sell">
                <a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$this->staff->id])?>" target="_blank">
                    <p class="count"><?=$this->staff->getSalingInfoNum()?>套</p>
                    <p class="word">出售房源</p>
                </a>
            </div>
            <div class="count-box">
                <a href="<?=$this->createUrl('/resoldhome/staff/zfList',['staff'=>$this->staff->id])?>" target="_blank">
                    <p class="count"><?=$this->staff->getSalingInfoNum(2)?>套</p>
                    <p class="word">出租房源</p>
                </a>
            </div>
        </div>
        <div class="info">
            <p>电话：<?=$this->staff->phone?></p>
            <p>公司：<a href="<?=$this->createUrl('shop/index',['shop'=>$this->staff->shop?$this->staff->shop->id:0])?>" target="_blank"><?=$this->staff->shop?$this->staff->shop->name:'--'?></a></p>
            <p>地址：<?=$this->staff->shop?$this->staff->shop->address:'--'?></p>
        </div>

    </div>
    <?php endif;?>

    <div class="s-common-title"><span>最近浏览过的房源</span></div>
    <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/zf/info','category'=>$this->zf->category,'cssType'=>1,'type'=>2,'infoId'=>$this->zf->id])?>

    <div class="s-common-title"><span>本楼盘其他<?=$this->zf->category==1?'租房':Yii::app()->params->category[$this->zf->category]?></span><a href="<?php
    if($this->zf->category != 1){
        echo $this->createUrl('/resoldhome/zf/list',['type'=>$this->zf->category,'kw'=>$this->zf->plot->title]);
    }else{
        echo $this->createUrl('/resoldhome/plot/pesflist',['py'=>$plotPinyin]);
    }
    ?>" target="_blank">更多&gt;</a></div>
    <?php if($others = $this->zf->getSamePlotInfo(6,$this->zf->category,2)):?>
        <ul class="right-list">
            <?php foreach ($others as $key => $value) {?>
                <li><a href="<?=Yii::app()->controller->createUrl('info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->title?></span><span class="cate tac"><?=$value->size.'m²'?></span><span class="price"><?=Tools::FormatPrice($value->price,'元/月')?></span></a></li>
            <?php }?>
        </ul>
    <?php endif;?>


    <?php if($this->staff):?>
        <?php $staffZfs = ResoldZfExt::model()->saling()->findAll(['condition'=>'uid=:uid and category=:category','params'=>[':uid'=>$this->staff->uid,':category'=>$this->zf->category],'order'=>'refresh_time desc,sale_time desc','limit'=>4]);
         if($staffZfs): ?>
        <div class="s-common-title"><span>该经纪人其他<?=$this->zf->category==1?'租房':Yii::app()->params->category[$this->zf->category]?></span><a href="<?=$this->createUrl('/resoldhome/staff/zfList',['staff'=>$this->staff->id])?>" target="_blank">更多&gt;</a></div>
        <ul class="right-list">
        <?php foreach ($staffZfs as $key => $value) {?>
            <li><a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->plot->title?> </span><span class="cate tac"><?=$value->size.'㎡'?></span><span class="price"><?=Tools::FormatPrice($value->price,'元/月')?></span></a></li>
        <?php }?>
        </ul>
        <?php endif;?>
    <?php endif;?>


    <!--本楼盘其他二手房-->
    <?php if($this->zf->category == 1):?>
    <div class="s-common-title"><span>本楼盘其他二手房</span><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$plotPinyin])?>" target="_blank">更多&gt;</a></div>
        <?php if($others = $this->zf->getSamePlotInfo(6,$this->zf->category,1)):?>
            <ul class="right-list">
                <?php foreach ($others as $key => $value) {?>
                    <li><a href="<?=Yii::app()->controller->createUrl('/resoldhome/esf/info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->title?></span><span class="cate tac"><?=$value->size.'m²'?></span><span class="price"><?=Tools::FormatPrice($value->price,'万')?></span></a></li>
                <?php }?>
            </ul>
        <?php endif;?>
    <?php elseif($this->zf->category == 2 || $this->zf->category==3):?>
    <div class="s-common-title"><span>本街区其他<?=Yii::app()->params['category'][$this->zf->category]?></span><a href="<?php
    $area = ['type' => $this->zf->category];
    if($this->zf->street)
        $area['street'] = $this->zf->street;
    elseif($this->zf->area)
        $area['area'] = $this->zf->area;
    echo $this->createUrl('/resoldhome/zf/list',$area);
    ?>" target="_blank">更多&gt;</a></div>
        <?php if($others = $this->zf->getSamePlotInfo(6,$this->zf->category,2)):?>
            <ul class="right-list">
                <?php foreach ($others as $key => $value) {?>
                    <li><a href="<?=Yii::app()->controller->createUrl('/resoldhome/zf/info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->title?></span><span class="cate tac"><?=$value->size.'m²'?></span><span class="price"><?=Tools::FormatPrice($value->price,'元/月')?></span></a></li>
                <?php }?>
            </ul>
        <?php endif;?>
    <?php endif;?>


<?php $this->widget('AdWidget',['position'=>'esfycbanner']); ?>
</div>
