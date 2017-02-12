<?php if($data): ?>
<div class="s-common-title"><span>推荐<?php echo $this->title; ?>房源</span><a href="<?php echo $this->moreUrl; ?>" target="_blank">更多&gt;</a></div>
<ul class="tj-list">
    <?php foreach ($data as $item): ?>
        <li>
            <a href="<?php if($this->type == 1){echo Yii::app()->createUrl('/resoldhome/esf/info',array('id'=>$item->id));}else{echo Yii::app()->createUrl('/resoldhome/zf/info',array('id'=>$item->id));} ?>" target="_blank">
                <div class="pic"><img src="<?=ImageTools::fixImage($item->image)?>" /></div>
                <div class="right">
                    <p class="title"><?php echo $item->title ; ?></p>
                    <p><?php echo $item->bedroom;?>室<?php echo $item->livingroom;?>厅</p>
                    <p class="price"><?php
                            if($this->type == 1){
                                echo $item->price > 0 ? $item->price.'万' : '面议';
                            }else{
                                echo $item->price > 0 ? $item->price.'元/㎡' : '面议';
                            }
                        ?></p>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>