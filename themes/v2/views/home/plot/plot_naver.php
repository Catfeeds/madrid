<?php $this->widget('AdWidget',['position'=>'lpknydb']); ?>
<div class="wapperout plot-head-bg">
    <div class="wapper plot-head">
        <div class="hj-container hj-container-md content">
            <div class="plot-head-l">
                <h2><?php echo $this->plot->title;?>
                    <?php if($this->plot->data_conf['recordname']):?>
                        <span class="fs16 ml5">备案名：<?php echo $this->plot->data_conf['recordname']?></span>
                    <?php endif;?>
                </h2>
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
                <p>已被浏览过<?=$this->plot->views; ?>次</p>
            </div>
        </div>
    </div>
</div>
<div class="blank15"></div>
<div class="wapper">
    <div class="plot-nav">
        <ul>
            <?php foreach(SM::plotConfig()->homePlotIndexNav->getMenu($this->plot) as $v): ?>
                <li <?php if($v['active']):?>class="current"<?php endif;?>><a href="<?=$v['url']; ?>" <?php if($v['blank']): ?>target="_blank"<?php endif; ?>><?=$v['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="blank15"></div>
