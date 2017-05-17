<?php
$this->pageTitle = SM::GlobalConfig()->siteName().'买房顾问信息页-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('买房顾问信息页，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag('特色买房顾问整装待发为您提供专业贴心的房产服务','description');
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/search.css'); ?>
<header class="buy-banner sm-banner">
    <div class=" top-mark"></div>
    <?php $this->renderPartial('/layouts/header',['search'=>false]); ?>
    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/images/buy_banner2.jpg" class="banner-img">
    <div class=" bottom-mark"></div>
    <div class="zan-click-bg"></div>
    <div  id="dianzan" class="zan-click"><i class="iconfont">&#x2036;</i>点赞</div>
    <div class="people-touxiang">
        <div class="touxiang-l"><img src="<?php echo ImageTools::fixImage($staff->avatar); ?>"></div>
        <div class="touxiang-r">
            <P><span><?php echo $staff->name?$staff->name:'未填写'; ?></span><?php echo $staff->job; ?></P>
            <p><span><i class="iconfont">&#x2036;</i><label id="zanshu"><?php echo $staff->praise; ?></label>个赞</span><span>最近带看: <em><?php echo StaffCheckExt::model()->count('sid='.$staff->id); ?></em></span><span>从业经验: <em><?php echo $staff->work_time; ?></em>年</span></p>
        </div>
    </div>
</header>

<div class=" people-intro">
    <?php echo $staff->introduction; ?>
</div>
<div class="blank20"></div>
<?php if($staff->plotCommentNum):?>
<div class="plot-reviews content-box">
    <p class="s-title">楼盘点评（<?php echo $staff->plotCommentNum; ?>）</p>
    <ul class="reviews-list-ul review-container">
        <?php foreach($staff->plotComments as $comment): ?>
            <li>
                <p><span>楼盘名称：</span><?php echo $comment->plot?CHtml::link($comment->plot->title,['/wap/plot/index','py'=>$comment->plot->pinyin]):'-'; ?></p>
                <p><span>楼盘分析：</span><?php echo $comment->content; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if($staffCommentHyh):?>
    <div class="operate-btns"><a href="" class="change-btn" data-url="<?php echo $this->createUrl('/wap/adviser/change',['type'=>'plotComment','sid'=>$staff->id]); ?>" data-template="reviewList" data-container="review-container">换一换</a><a href="<?php echo $this->createUrl('plotComment',['sid'=>$staff->id]); ?>">查看更多</a></div>
    <?php endif;?>
</div>
<div class="blank20"></div>
<?php endif;?>
<?php if($staff->checkNum):?>
<div class="record-box content-box">
    <p class="s-title">带看记录（<?php echo $staff->checkNum; ?>）</p>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <th>客户</th>
            <th>电话</th>
            <th>楼盘</th>
            <th>带看时间</th>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" width="100%" class="record-container">
        <?php foreach($records as $record): ?>
            <tr>
                <td><?php echo $record->user ? mb_substr($record->user->name, 0, 1, 'utf-8').'**' : '匿名'; ?></td>
                <td><?php echo substr_replace($record->phone,'****',3,4) ?></td>
                <td><?php echo $record->plot->title; ?></td>
                <td><?php echo date('Y.m.d', $record->created); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if($recordsHyh):?>
    <div class="operate-btns"><a href="" class="change-btn" data-url="<?php echo $this->createUrl('/wap/adviser/change',['type'=>'record','sid'=>$staff->id]); ?>" data-template="recordList" data-container="record-container">换一换</a><a href="<?php echo $this->createUrl('/wap/adviser/record',['sid'=>$staff->id]); ?>">查看更多</a></div>
<?php endif;?>
</div>
<?php endif;?>
<div class="blank20"></div>
<div class="plot-reviews content-box" id="comment">
    <p class="s-title">网友点评（<?php echo $commentNum; ?>）</p>
    <div class="write-reviews-box">
        <form method="post" action="<?php echo $this->createUrl('/wap/adviser/staffComment'); ?>" class="wendaForm">
        <div class="write-reviews">
            <i class="iconfont">&#x1002;</i>
            <input type="hidden" name="StaffCommentExt[sid]" value="<?php echo $staff->id; ?>">
            <input type="text" datatype="*1-255" nullmsg="*点评内容不能为空" errormsg="*字数不能超过255个字符" sucmsg="提交成功" name="StaffCommentExt[content]" placeholder="我也来说两句，限255字">
            <input type="submit" id="btn_sub" value="提交">
        </div>
        <div class="error-msg"><?php echo Yii::app()->user->hasFlash('tip')?Yii::app()->user->getFlash('tip'):''; ?></div>
        </form>
    </div>
    <!-- <div class="reviews-content dropload" data-url='json/answer-more.json' data-template='reviewList'> -->
     <div class="reviews-content dropload" data-url='<?php echo $this->createUrl('/wap/adviser/staffComment',['ajax'=>1,'sid'=>$staff->id]); ?>' data-template='reviewList'>
            <!-- 新房列表开始 -->
            <ul class="reviews-list more-list">

            </ul>
        </div>

</div>
<?php $this->widget('BottomOperate',['style'=>'ul','url1'=>$staff->phone?'tel:'.$staff->phone:null,'url2'=>$staff->qq>0?'mqqwpa://im/chat?chat_type=wpa&uin='.$staff->qq.'&version=1&src_type=web':null,'url3'=>$this->createUrl('/wap/adviser/index')]); ?>
<div class="blank20"></div>

<script type="text/javascript">
    <?php Tools::startJs(); ?>
    Do.ready(function(){
        $("#dianzan").click(function(){
            $.get("<?php echo $this->createUrl('/wap/adviser/praise'); ?>",{sid:<?php echo $staff->id; ?>},function(d){
                if(d.code>0){
                    $("#zanshu").html(d.msg);
                } else {
                    alertPop(d.msg);
                }
            },'json');
        });
    });
    <?php Tools::endJs('dianzan'); ?>
</script>
