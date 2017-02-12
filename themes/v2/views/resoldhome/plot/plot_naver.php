<?php
    $this->pageTitle = SM::urmConfig()->cityName().$this->plot->title.'小区,二手房,租房-'.SM::urmConfig()->cityName().SM::GlobalConfig()->siteName();
    $this->keyword = $this->plot->title.'小区,'.SM::urmConfig()->cityName().$this->plot->title.'论坛,'.$this->plot->title.'租房,'.$this->plot->title.'二手房';
    $this->description = '提供'.$this->plot->title.'论坛、'.$this->plot->title.'二手房、'.$this->plot->title.'租房，'.$this->plot->title.'家居装修、'.$this->plot->title.'二手交易、'.$this->plot->title.'周边商户、小区活动、小区相册等栏目';
?>
<!--  小区名称  -->
<div class="xiaoqu-name clearfix">
    <ul>
        <li class="fl">
            <span class="sp-1"><?=$this->plot->title?></span>
        <?php if($this->plot->avg_esf):?>
            <span class="sp-2"><?=$this->plot->avg_esf->price?></span>
            <span class="sp-3">元/㎡</span>
        <?php else:?>
            <span class="sp-2">暂无</span>
        <?php endif;?>
        </li>

        <li class="fr">
            <div class="icon"></div>
            <span class="tel"><?=$this->plot->sale_tel?></span></li>
    </ul>
</div>
<div class="adress clearfix">
    <div class="adress-left clearfix">
        <ul class="clearfix">
            <!--地址：新北-恐龙园商圈丨新北巫山路东侧，太湖东路软件园附近 [查看地图]      物业类型：普通住宅      建筑年代：2014年-->
            <li class="adress-1">地址：</li>
            <li><?=$this->plot->address?></li>
            <li><a class="link-map" href="<?=$this->createUrl('plotmap',['py'=>$this->plot->pinyin])?>">&nbsp;[查看地图]</a></li>
            <li class="adress-1 ml25">物业类型：</li>
            <li>
                <?php
                    $wylx = [];
                    if($this->plot->wylx){
                        foreach($this->plot->wylx as $k=>$v){
                            $wylx[] = $v->name;
                        }
                    }
                    if(!empty($wylx)){
                        echo implode(' ',$wylx);
                    }
                ?>
            </li>
            <li class="adress-1 ml25"> 建筑年代：</li>
            <li><?=date('Y',$this->plot->open_time)?></li>
        </ul>
    </div>
    <div class="adress-right">
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
                </div>
</div>

<!--  tab切换栏  -->
<div class="tab clearfix">
    <ul class="tab-ul fl clearfix">
        <li <?php if($this->getAction()->getId() == 'index'):?>class="active"<?php endif; ?>><a href="<?php echo $this->createUrl('/resoldhome/plot/index',array('py'=>$this->plot->pinyin))?>" target="_blank">小区首页</a></li>
        <?php if($this->plot->is_new):?><li><a href="<?=$this->createUrl('/home/plot/index',['py'=>$this->plot->pinyin])?>" target="_blank">买新房</a></li><?php endif;?>
        <li <?php if($this->getAction()->getId() == 'pesflist'):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('pesflist',array('py'=>$this->plot->pinyin))?>" target="_blank">二手房</a></li>
        <li <?php if($this->getAction()->getId() == 'pzflist'):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('pzflist',array('py'=>$this->plot->pinyin))?>" target="_blank">租房</a></li>
        <li <?php if($this->getAction()->getId() == 'album' || $this->getAction()->getId() == 'image'):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('album',array('py'=>$this->plot->pinyin))?>" target="_blank">相册</a></li>
        <li <?php if($this->getAction()->getId() == 'plotmap'):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('plotmap',array('py'=>$this->plot->pinyin))?>" target="_blank">地图配套</a></li>
        <li <?php if($this->getAction()->getId() == 'detail'):?>class="active"<?php endif;?>><a href="<?php echo $this->createUrl('detail',array('py'=>$this->plot->pinyin))?>" target="_blank">小区详情</a></li>

    </ul>
</div>
