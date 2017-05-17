<div class="gj gj-index">
    <?php $this->renderPartial('_header'); ?>
    <div class="main">
        <?php $this->renderPartial('_search'); ?>
        <ul class="s-result-list">
            <?php foreach($data as $user): ?>
            <li>
                <?php $data_conf=$user->data_conf?>
                <a href="<?php echo $this->createUrl('detail',['phone'=>$user->phone,'status'=>$status,'page'=>$page]); ?>">
                    <div class="u-info">
                        <p class="name"><?php echo $user->name; ?>
                            <?php if($user->mark_new): ?><span class="icon-new">new</span><?php endif; ?>
                            <?php if(is_array($data_conf)&&$user->lastOrderTime&&$user->lastOrderTime->created>$data_conf['viewTime']):?><span class="icon-new2">new</span><?php endif;?>
                        </p>
                        <p class="phone"><?php echo $user->phone; ?></p>
                    </div>
                    <div class="u-state">
                        <p>登记楼盘：<strong class="em-1"><?php echo $user->checkNum; ?></strong>个</p>
                        <p>跟进状态：<strong class="em-1"><?php echo UserExt::$staffStatus[$user->staff_status]; ?></strong></p>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
    </div>
</div>
<script type="text/javascript">
    document.body.className = 'bg-fff';
</script>
