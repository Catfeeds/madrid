<?php $this->widget('AdWidget',['position'=>'lpknydb']); ?>
<div class="wapperout plot-head-bg">
    <div class="wapper plot-head">
        <div class="hj-container hj-container-md content">
            <div class="plot-head-l">
                <h2><?php echo $this->plot->title;?></h2>
                <ul class="status-tag">
                    <?php if($this->plot->xszt): ?>
                    <li><span class="blue-square"></span><?php echo $this->plot->xszt->name;?></li>
                    <?php endif; ?>
                    <?php if($this->plot->kan_id > 0):?>
                    <li><span class="pink-square"></span>看房团</li>
                    <?php endif;?>
                    <?php if($this->plot->tuan_id > 0):?>
                    <li><span class="red-square"></span>团购进行中</li>
                    <?php endif;?>
                    <?php if($this->plot->is_new > 0):?>
                        <li><span class="orange-square"></span>新盘</li>
                    <?php endif;?>
                </ul>
                <ul class="advantage-tag">
                    <?php foreach($this->plot->xmts as $k=>$v):?>
                    <li><?php echo $v->name;?></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="plot-head-r">
                <strong class="plot-ico"><?php echo $this->plot->sale_tel?></strong>
                <p>最后更新于<?php echo date('Y-m-d G:i',$this->plot->updated ? $this->plot->updated : $this->plot->created); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="blank15"></div>
<div class="wapper">
    <div class="plot-nav">
        <ul>
            <li <?php if($this->getAction()->getId() == 'index'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$this->plot->pinyin));?>">主页</a></li>
            <li <?php if($this->getAction()->getId() == 'detail'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('detail',array('py'=>$this->plot->pinyin));?>">详情</a></li>
            <li <?php if($this->getAction()->getId() == 'huxing' || $this->getAction()->getId() == 'pic'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('huxing',array('py'=>$this->plot->pinyin));?>">户型</a></li>
            <li <?php if($this->getAction()->getId() == 'album' || $this->getAction()->getId() == 'image'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('album',array('py'=>$this->plot->pinyin));?>">相册</a></li>
            <li <?php if($this->getAction()->getId() == 'map'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('map',array('py'=>$this->plot->pinyin));?>">地图交通</a></li>
            <li <?php if($this->getAction()->getId() == 'price'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('price',array('py'=>$this->plot->pinyin));?>">价格</a></li>
            <li <?php if($this->getAction()->getId() == 'news'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('news',array('py'=>$this->plot->pinyin));?>">资讯</a></li>
            <li <?php if($this->getAction()->getId() == 'faq'):?>class="current"<?php endif;?>><a href="<?php echo $this->createUrl('faq',array('py'=>$this->plot->pinyin));?>">问答</a></li>
            <?php if($this->plot->old_id&&$this->siteConfig['plotEsfUrl']||isset($this->plot->data_conf['esfUrl'])&&$this->plot->data_conf['esfUrl']): ?>
            <li><a href="<?php echo $this->plot->data_conf['esfUrl']?$this->plot->data_conf['esfUrl']:str_replace('{id}',$this->plot->old_id,$this->siteConfig['plotEsfUrl']); ?>" target="_blank">二手房</a></li>
            <?php endif; ?>
            <?php if($this->plot->old_id&&$this->siteConfig['plotEsfUrl']||isset($this->plot->data_conf['zfUrl'])&&$this->plot->data_conf['zfUrl']): ?>
            <li><a href="<?php echo $this->plot->data_conf['zfUrl']?$this->plot->data_conf['zfUrl']:str_replace('{id}',$this->plot->old_id,$this->siteConfig['plotZfUrl']); ?>" target="_blank">租房</a></li>
            <?php endif; ?>
            <?php if($this->siteConfig['bbsTagPageUrl']&&$this->plot->tag_id): ?>
            <li><a href="<?php echo str_replace('{tagid}',$this->plot->tag_id, $this->siteConfig['bbsTagPageUrl']); ?>" target="_blank">论坛</a></li>
            <?php endif;?>
        </ul>
    </div>
</div>
<div class="blank15"></div>
