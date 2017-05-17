<?php
$this->pageTitle = $resold_qz->title.'- 求租 - '.SM::urmConfig()->cityName.'租房网 - ' . SM::globalConfig()->siteName;
$this->keyword = SM::urmConfig()->cityName.$this->title.'求租';
$this->description = $resold_qz->title.','.$resold_qz->content;
Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/detail.css');
?>

<?php $this->widget('HomeBreadcrumbs',array('links'=>array('求租'.$this->title=>$this->createUrl('/resoldhome/qz/index',array('type'=>$this->category)),'求租'.$this->title.'详情')));?>

<div class="line"></div>
<div class="wapper">
    <div class="qg-top">
        <div class="title"><?php echo $resold_qz->title; ?></div>
        <div class="desc">
            <div class="left"><span>房源编号：<?php echo $resold_qz->id;  ?> </span><span>发布时间：<?php echo date('Y-m-d',$resold_qz->created); ?></span></div>
            <div class="share"><i class="detail-ico"></i><span>分享到</span>
                <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
            </div>
        </div>
    </div>
    <div class="qg-info">
        <ul>
            <li>期望租金： <em><?php echo $resold_qz->price ? $resold_qz->price .'</em>元/月' : '面议</em>';?></li>
            <?php if($resold_qz->category == 1): ?>
            <li>期望方式： <?php echo $resold_qz->rent_type ? $resold_qz->rent_type : '暂无';?></li>
            <li  class="long">期望户型：
                <?php echo isset($tags['resoldhuxing']) ? implode(',',$tags['resoldhuxing']) : '暂无' ;?>
            </li>
            <?php endif; ?>
            <?php if($resold_qz->category == 2): ?>
                 <li>期望类型： <?php echo isset($tags['esfzfsptype']) ? $tags['esfzfsptype'] : '暂无';?></li>
            <?php endif; ?>
            <li class="long">期望区域： <?php echo $resold_qz->areaInfo ? $resold_qz->areaInfo->name : '暂无'; ?> <?php echo $resold_qz->streetInfo ? ' / '.$resold_qz->streetInfo->name : '';  ?> </li>
            <li>期望面积： <?php echo $resold_qz->size > 0 ? $resold_qz->size.'平方米以上' : '暂无';?></li>
            <li>期望装修： <?php echo $resold_qz->decoration ? $resold_qz->decoration : '暂无'; ?> </li>
            <li class="long">意向楼盘：<?php echo $extend_plot?$extend_plot:'暂无'; ?></li>
            <?php if($resold_qz->category == 1): ?>
                <li class="long">期望配套：
                    <?php echo isset($tags['zfzzpt']) ? implode(' , ',$tags['zfzzpt']) : '暂无' ;?>
                </li>
            <?php endif; ?>
            <?php if($resold_qz->category == 2): ?>
                <li class="long">经营项目：
                    <?php echo isset($tags['zfspkjyxm']) ? implode(' , ',$tags['zfspkjyxm']) : '暂无' ;?>
                </li>
                <li class="long">期望配套：
                    <?php echo isset($tags['zfsppt']) ? implode(' , ',$tags['zfsppt']) : '暂无' ;?>
                </li>
            <?php endif; ?>
            <?php if($resold_qz->category == 3): ?>
                <li>期望类型： <?php echo isset($tags['esfzfxzltype']) ? $tags['esfzfxzltype'] : '暂无';?></li>
                <li class="long">期望配套：
                    <?php echo isset($tags['zfxzlpt']) ? implode(' , ',$tags['zfxzlpt']) : '暂无' ;?>
                </li>
            <?php endif; ?>
        </ul>
        <div class="tel-box"><i class="detail-ico"></i><span><?php echo $resold_qz->phone;?></span><em><?php echo $resold_qz->username; ?></em></div>
        <p class="promite">打电话时请告知是在<?=SM::globalConfig()->siteName()?>租房看到的，谢谢</p>
    </div>
    <div class="qg-detail">
        <p class="title">求租详情</p>
        <div class="content">
            <?php echo $resold_qz->content ? $resold_qz->content : '暂无'; ?>
        </div>
    </div>
    <div class="yq_promite">友情提示：当您遇到恶意的电话骚扰，请拨打0519-83022315（周一至周日 9:00--18:00）联系我们，我们会在第一时间帮您解决。</div>
</div>
