<?php
    $this->pageTitle = $resold_qg->title.'- 求购 - '.SM::urmConfig()->cityName.'二手房网 - ' . SM::globalConfig()->siteName;
    $this->keyword = SM::urmConfig()->cityName.$this->title.'求购';
    $this->description = $resold_qg->title.','.$resold_qg->content;
    Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/detail.css');
?>

<?php $this->widget('HomeBreadcrumbs',array('links'=>array('求购'.$this->title=>$this->createUrl('/resoldhome/qg/index',array('type'=>$this->category)),'求购'.$this->title.'详情')));?>

<div class="line"></div>
<div class="wapper">
    <div class="qg-top">
        <div class="title"><?php echo $resold_qg->title; ?></div>
        <div class="desc">
            <div class="left"><span>房源编号：<?php echo $resold_qg->id;  ?> </span><span>发布时间：<?php echo date('Y-m-d',$resold_qg->created); ?></span></div>
            <div class="share"><i class="detail-ico"></i><span>分享到</span>
                <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
            </div>
        </div>
    </div>
    <div class="qg-info">
        <ul>
            <li>期望价格： <em><?php echo $resold_qg->price ? $resold_qg->price .'</em>万元以内' : '面议</em>';?></li>
            <?php if($resold_qg->category == 1): ?>
            <li>期望户型： <?php echo $resold_qg->bedroom;?>室<?php echo $resold_qg->livingroom;?>厅<?php echo $resold_qg->bathroom;?>卫</li>
            <?php endif; ?>
            <?php if($resold_qg->category == 2): ?>
            <li>期望类型： <?php echo isset($tags['esfzfsptype']) ? implode(' , ',$tags['esfzfsptype']) : '暂无';?></li>
            <?php endif; ?>
            <?php if($resold_qg->category == 3): ?>
            <li>期望类型： <?php echo isset($tags['esfzfxzltype']) ? implode(' , ',$tags['esfzfxzltype']) : '暂无';?></li>
            <?php endif; ?>
            <li>期望面积： <?php echo $resold_qg->size > 0 ? $resold_qg->size.'平方米以上' : '暂无';?></li>
            <li class="long">期望区域： <?php echo isset($resold_qg->areaInfo) ? $resold_qg->areaInfo->name : '暂无'; ?> <?php echo isset($resold_qg->streetInfo) ? ' / '.$resold_qg->streetInfo->name : ''; ?> </li>
            <li>期望装修： <?php echo $resold_qg->decoration ? $resold_qg->decoration : '暂无'; ?> </li>
            <?php if($resold_qg->category == 1): ?>
                <li>期望房龄： <?php echo isset($tags['qgzzqwfl']) ? implode(' , ',$tags['qgzzqwfl']) : '暂无' ;?></li>
                <li>期望朝向： <?php echo $resold_qg->towards ? $resold_qg->towards : '暂无'; ?></li>
                <li>期望楼层： <?php echo isset($tags['qgzzqwlc']) ? implode(' , ',$tags['qgzzqwlc']) : '暂无'; ?></li>
                <li class="long">期望配套：
                    <?php echo isset($tags['esfzzpt']) ? implode(' , ',$tags['esfzzpt']) : '暂无' ;?>
                </li>
            <?php endif; ?>
            <?php if($resold_qg->category == 2): ?>
                <li class="long">期望配套：
                    <?php echo isset($tags['esfsppt']) ? implode(' , ',$tags['esfsppt']) : '暂无' ;?>
                </li>
                <li class="long">经营项目：
                    <?php echo isset($tags['esfspkjyxm']) ? implode(' , ',$tags['esfspkjyxm']) : '暂无' ;?>
                </li>
            <?php endif; ?>
            <?php if($resold_qg->category == 3): ?>
                <li class="long">期望配套：
                    <?php echo isset($tags['esfxzlpt']) ? implode(' , ',$tags['esfxzlpt']) : '暂无' ;?>
                </li>
            <?php endif; ?>
            <li class="long">意向楼盘：<?php echo $extend_plot?$extend_plot:'暂无'; ?></li>
        </ul>
        <div class="tel-box"><i class="detail-ico"></i><span><?php echo $resold_qg->phone;?></span><em><?php echo $resold_qg->username; ?></em></div>
        <p class="promite">打电话时请告知是在<?=SM::globalConfig()->siteName()?>租房看到的，谢谢</p>
    </div>
    <div class="qg-detail">
        <p class="title">求购详情</p>
        <div class="content">
            <?php echo $resold_qg->content ? $resold_qg->content : '暂无'; ?>
        </div>
    </div>
    <div class="yq_promite">友情提示：当您遇到恶意的电话骚扰，请拨打0519-83022315（周一至周日 9:00--18:00）联系我们，我们会在第一时间帮您解决。</div>
</div>
