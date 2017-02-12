<div class="detail_r">
    <a class="erweima-btn">
        <i class="detail-ico"></i>
        <div class="erweima-expand">
            <div class="erweima-box">
                <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl(Yii::app()->request->getUrl())]); ?>">
                <p>扫描二维码获取房源信息</p>
            </div>
        </div>
    </a>
    <div class="bdsharebuttonbox share-btn"><a href="#" class="bds_more" data-cmd="more"><i class="detail-ico"></i>分享</a></div>
    <div class="blank10"></div>
    <?php if($staff = $this->staff):?>
    <div class="publisher-box">
        <div class="people">

            <a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$staff->id])?>" target="_blank">
                <img src="<?=ImageTools::fixImage($this->staff?$staff->image:$this->moreGet['user']['icon'],150,200)?>"><?=$this->esf->username?$this->esf->username:$this->esf->account?>
            </a>
        </div>
            <?php if($staff->id_card || $staff->licence):?>
            <div class="renzheng">
                <em>认证：</em><?php if($staff->id_card): ?><span><i class="detail-ico sfz-ico"></i>身份证</span><?php endif;?><?php if($staff->licence): ?><span><i class="detail-ico zgz-ico"></i>资格证</span><?php endif;?>
            </div>
            <?php endif;?>


        <div class="btns">
            <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$staff->qq?>&amp;site=qq&amp;menu=yes" target="_blank" class="qq-btn">QQ联系</a>
            <a href="<?=$this->createUrl('shop/index',['shop'=>$staff->shop?$staff->shop->id:0])?>" target="_blank" class="enter-btn">进入店铺</a>
        </div>
        <div class="clearfix">
            <div class="count-box sell">
                <a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$staff->id])?>" target="_blank">
                    <p class="count"><?=$staff->getSalingInfoNum()?>套</p>
                    <p class="word">出售房源</p>
                </a>
            </div>
            <div class="count-box">
                <a href="<?=$this->createUrl('/resoldhome/staff/zfList',['staff'=>$staff->id])?>" target="_blank">
                    <p class="count"><?=$staff->getSalingInfoNum(2)?>套</p>
                    <p class="word">出租房源</p>
                </a>
            </div>
        </div>
        <div class="info">
            <p>电话：<?=$staff->phone?></p>
            <p>公司：<a href="<?=$this->createUrl('shop/index',['shop'=>$staff->shop?$staff->shop->id:0])?>" target="_blank"><?=$staff->shop?$staff->shop->name:'--'?></a></p>
            <p>地址：<?=$staff->shop?$staff->shop->address:'--'?></p>
        </div>
    </div>
    <?php endif;?>
    <div class="s-common-title"><span>最近浏览过的房源</span></div>
    <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>1,'category'=>$this->esf->category,'type'=>1])?>

    <div class="s-common-title"><span>本楼盘其他<?php if($this->esf->category==2):?>商铺<?php elseif($this->esf->category==3):?>写字楼<?php else:?>二手房<?php endif;?></span><a href="
    <?php
    if($this->esf->category != 1){
        echo $this->createUrl('/resoldhome/esf/list',['type'=>$this->esf->category,'kw'=>$this->esf->plot->title]);
    }else{
        echo $this->createUrl('/resoldhome/plot/pesflist',['py'=>$this->esf->plot->pinyin]);
    }

    ?>" target="_blank">更多&gt;</a></div>
    <?php if($others = $this->esf->getSamePlotInfo(6,$this->esf->category)):?>
        <ul class="right-list">
            <?php foreach ($others as $key => $value) {?>
                <li><a href="<?=Yii::app()->controller->createUrl('info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->title?></span><span class="cate tac"><?=$value->size.'m²'?></span><span class="price"><?=Tools::FormatPrice($value->price,'万')?></span></a></li>
            <?php }?>
        </ul>
    <?php endif;?>

    <?php if($this->staff):?>
        <?php $staffEsfs = ResoldEsfExt::model()->saling()->findAll(['condition'=>'uid=:uid and category=:cate','params'=>[':uid'=>$staff->uid,':cate'=>$this->esf->category],'order'=>'refresh_time desc,sale_time desc','limit'=>4]);
         if($staffEsfs): ?>
        <div class="s-common-title"><span>该经纪人其他<?=$this->esf->category==1?'二手房':Yii::app()->params->category[$this->esf->category]?></span><a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$staff->id])?>" target="_blank">更多&gt;</a></div>
        <ul class="right-list">
        <?php foreach ($staffEsfs as $key => $value) {?>
            <li><a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->plot->title?> </span><span class="cate tac"><?php if($value->bedroom):?><?=$value->bedroom?>室<?=$value->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$value->category]?><?php endif;?> </span><span class="price"><?=Tools::FormatPrice($value->price,'万')?></span></a></li>
        <?php }?>
        </ul>
        <?php endif;?>
    <?php endif;?>
    <?php ?>
    <?php if($this->esf->category == 1):?>
    <div class="s-common-title"><span>本楼盘租房房源</span><a href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$this->esf->plot->pinyin])?>" target="_blank">更多&gt;</a></div>
    <?php if($others = $this->esf->getSamePlotInfo(6,$this->esf->category,2)):?>
        <ul class="right-list">
            <?php foreach ($others as $key => $value) {?>
                <li><a href="<?=Yii::app()->controller->createUrl('/resoldhome/zf/info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->title?></span><span class="cate tac"><?=$value->size.'m²'?></span><span class="price"><?=Tools::FormatPrice($value->price,'元/月')?></span></a></li>
            <?php }?>
        </ul>
    <?php endif;?>
<?php endif;?>
<?php if($this->esf->category == 2 || $this->esf->category==3):?>
<div class="s-common-title"><span>本街道其他<?=Yii::app()->params['category'][$this->esf->category]?></span><a href="
    <?php
    $area = ['type' => $this->esf->category];
    if($this->esf->street)
        $area['street'] = $this->esf->street;
    elseif($this->esf->area)
        $area['area'] = $this->esf->area;
    echo $this->createUrl('/resoldhome/esf/list',$area);
?>" target="_blank">更多&gt;</a></div>
    <?php if($others = $this->esf->getSamePlotInfo(6,$this->esf->category,1)):?>
        <ul class="right-list">
            <?php foreach ($others as $key => $value) {?>
                <li><a href="<?=Yii::app()->controller->createUrl('/resoldhome/esf/info',['id'=>$value->id])?>" target="_blank"><span class="name"><?=$value->title?></span><span class="cate tac"><?=$value->size.'m²'?></span><span class="price"><?=Tools::FormatPrice($value->price,'万')?></span></a></li>
            <?php }?>
        </ul>
    <?php endif;?>
<?php endif;?>

<?php $this->widget('AdWidget',['position'=>'esfycbanner']); ?>
</div>
