<div class="wapper">
    <div class="houses-bottom">
        <div class="addition clearfix">
            <div class="phone-apply plot-ico fl">
                <strong ><?php echo $this->plot->sale_tel;?></strong>
                <span class="fs14 c-g6">售楼处免费咨询电话 </span>
            </div>
            <div class="item-block fs16 fl">
                <dl>
                    <dt class="c-g6">参考价格</dt>
                    <dd><?php if($this->plot->price>0):?><span class="fs30 c-red"><?php echo $this->plot->price;?></span><?php echo PlotPriceExt::$unit[$this->plot->unit];?><?php else:?><span class="fs30 c-red">暂无报价</span><?php endif;?></dd>
                </dl>
                <dl>
                    <dt  class="c-g6">最新优惠</dt>
                    <dd class="c-red"><?php echo Tools::u8_title_substr($this->plot->newDiscount['title'],20);?></dd>
                </dl>
            </div>
            <div class="item-erweima fl">
                <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('/wap/plot/index',['py'=>$this->plot->pinyin])]); ?>" >
                <p>直接用手机扫描<br>查看“<?php echo $this->plot->title;?>”信息</p>
            </div>
        </div>
        <div class="well-enough">
            <p class="fs18">接下来您还可以</p>
            <ul class="clearfix">
                <li><a href="<?php echo $this->createUrl('/home/plot/news',array('py'=>$this->plot->pinyin))?>" ><?php echo $this->plot->title;?>销售动态 </a></li>
                <li><a href="<?php echo $this->createUrl('/home/plot/price',array('py'=>$this->plot->pinyin))?>"  ><?php echo $this->plot->title;?>价格 </a></li>
                <li><a href="<?php echo $this->createUrl('/home/plot/detail',array('py'=>$this->plot->pinyin))?>"><?php echo $this->plot->title;?>怎么样 </a></li>
                <li><a href="<?php echo $this->createUrl('/home/plot/faq',array('py'=>$this->plot->pinyin))?>"><?php echo $this->plot->title;?>导购 </a></li>
                <li><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin))?>"><?php echo $this->plot->title;?>户型图 </a></li>
            </ul>
        </div>
        <ul class="tuij-box fs16">
            <li><strong>相似楼盘：</strong>
                <span>
                    <a target="_blank" href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area))?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:$this->siteConfig['cityName']?>楼盘</a>
                </span>
                <span>
                    <a target="_blank" href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->street))?>"><?php echo isset($this->siteStreet[$this->plot->area][$this->plot->street])?$this->siteStreet[$this->plot->area][$this->plot->street]:'';?>楼盘</a>
                </span>
                <span>
                    <a target="_blank" href="<?php echo $priceRange?$this->createUrl('/home/plot/list',array('ext'=>'p'.$priceRange['id'])):$this->createUrl('/home/plot/list',array('ext'=>'s2'))?>"><?php if($this->plot->price>0&&$priceRange):?>均价<?php echo $priceRange['name']; ?>元<?php else:?>待售<?php endif;?>楼盘</a>
                </span>
            </li>
            <?php if(!empty($benyue)):?>
            <li><strong>本月开盘：</strong>
                <?php foreach($benyue as $v): ?>
                <span><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin));?>"><?php echo $v->title;?></a></span>
                <?php endforeach; ?>
            </li>
            <?php endif;?>
            <?php if(!empty($samearea)): ?>
            <li><strong>同区域楼盘：</strong>
                <?php foreach($tongQuYu as $v): ?>
                        <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin));?>" target="_blank"><?php echo $v->title;?></a>
                    <?php endforeach; ?>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="wapperout fixed_box">
    <div class="wapper guide-box">
        <ul class="fl">
            <li <?php if($this->getAction()->getId() == 'index'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('index', array('py'=>$this->plot->pinyin)); ?>">楼盘主页</a></li>
            <li <?php if($this->getAction()->getId() == 'detail'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('detail',array('py'=>$this->plot->pinyin));?>">详情</a></li>
            <li <?php if($this->getAction()->getId() == 'huxing' || $this->getAction()->getId() == 'pic'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('huxing',array('py'=>$this->plot->pinyin));?>">户型</a></li>
            <li <?php if($this->getAction()->getId() == 'album' || $this->getAction()->getId() == 'image'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('album',array('py'=>$this->plot->pinyin));?>">相册</a></li>
            <li <?php if($this->getAction()->getId() == 'map'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('map',array('py'=>$this->plot->pinyin));?>">地图交通</a></li>
            <li <?php if($this->getAction()->getId() == 'price'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('price',array('py'=>$this->plot->pinyin));?>">价格</a></li>
            <li <?php if($this->getAction()->getId() == 'news'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('news',array('py'=>$this->plot->pinyin));?>">动态</a></li>
            <li <?php if($this->getAction()->getId() == 'faq'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('faq',array('py'=>$this->plot->pinyin));?>">问答</a></li>
            <?php if($this->plot->old_id&&$this->siteConfig['plotEsfUrl']||$this->plot->data_conf['esfUrl']): ?>
            <li><a href="<?php echo isset($this->plot->data_conf['esfUrl'])&&$this->plot->data_conf['esfUrl']?$this->plot->data_conf['esfUrl']:str_replace('{id}',$this->plot->old_id,$this->siteConfig['plotEsfUrl']); ?>" target="_blank">二手房</a></li>
            <?php endif; ?>
            <?php if($this->plot->old_id&&$this->siteConfig['plotEsfUrl']||$this->plot->data_conf['zfUrl']): ?>
            <li><a href="<?php echo isset($this->plot->data_conf['zfUrl'])&&$this->plot->data_conf['zfUrl']?$this->plot->data_conf['zfUrl']:str_replace('{id}',$this->plot->old_id,$this->siteConfig['plotZfUrl']); ?>" target="_blank">租房</a></li>
            <?php endif; ?>
            <?php if($this->siteConfig['bbsTagPageUrl']&&$this->plot->tag_id): ?>
            <li><a href="<?php echo str_replace('{tagid}',$this->plot->tag_id, $this->siteConfig['bbsTagPageUrl']); ?>" target="_blank">论坛</a></li>
            <?php endif;?>
        </ul>
        <input type="button" value="报名团购" class="baotuan-btn k-dialog-type-1" data-title="<?php echo $this->plot->title; ?>" data-spm="<?php echo OrderExt::generateSpm('报名团购',$this->plot); ?>">
    </div>
</div>
