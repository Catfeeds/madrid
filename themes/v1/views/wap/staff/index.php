<?php $this->pageTitle='购房管家'; ?>
<div class="main">
    <div class="userinfo">
        <div class="inner">
            <div class="userimg"><img src="/static/wap/images/userimg.png" alt="" /></div>
            <div class="info">
                <p class="name"><?php echo Yii::app()->user->username; ?></p>
                <p class="num">累计客户&#160;<strong class="em-1"><?php echo $staff->kehuNum; ?></strong>&#160;人</p>
                <p class="lianji">本月累计客户&#160;<strong class="em-1"><?php echo $staff->benyueKehuNum; ?></strong>&#160;人</p>
            </div>
        </div>
    </div>
    <?php $this->renderPartial('_search'); ?>
    <ul class="s-result">
    <?php foreach(UserExt::$staffStatus as $k=>$v): ?>
        <li>
            <a href="<?php echo $this->createUrl('/wap/staff/list', ['status'=>$k]); ?>">
                <div class="state"><?php echo $v; if($info[$k]['new']):?><span class="icon-new">new</span><?php endif; ?></div>
                <div class="num"><?php echo $info[$k]['num']; ?></div>
                <i class="icon icon-right-arrow2"></i>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
