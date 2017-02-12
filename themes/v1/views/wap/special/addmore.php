<?php foreach($data as $n): ?>
    <li>
        <a href="<?php echo $this->createUrl('detail',array('id'=>$n->id))?>">
            <div class="pic"><img src="<?php echo ImageTools::fixImage($n->image)?>" alt="" /></div>
            <div class="info">
                <p><?php echo $n->room?></p>
                <p><?php echo $n->bed_room?>&#160;&#160;<?php echo $n->size; ?>㎡</p>
                <p><strong class="oprice em-1"><small>￥</small><?php echo $n->price_new?><small>万</small></strong><del>￥<?php echo $n->price_old?>万</del></p>
                <i class="goarrow icon icon-right-arrow2"></i>
            </div>
        </a>
    </li>
<?php endforeach;?>
