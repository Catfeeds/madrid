<?php
$search = isset($search) ? (bool)$search : true;
?>
<div class="operate">
    <?php if($search): ?>
    <a href="<?php echo $this->createUrl('/wap/plot/search'); ?>" class="iconfont">&#x1014;</a>
    <?php endif; ?>
    <a href="<?php echo $this->createUrl('/wap/index/nav'); ?>" class="iconfont">&#x1022;</a>
</div>
