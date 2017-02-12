<?php
$this->pageTitle = '客户详情';
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/js/mobiscroll.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/wap/js/mobiscroll.min.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/static/wap/js/main.js',CClientScript::POS_END);
 ?>
<div class="gj gj-detail">
    <?php $this->renderPartial('_header'); ?>
    <div class="main">
        <div class="userinfo">
            <div class="inner">
                <p class="name"><?php echo $user->name ? $user->name : '(未确认姓名)'; ?></p>
                <p class="phone"><?php echo $user->phone; ?></p>
                <a href="tel:<?php echo $user->phone; ?>" class="tel"><i class="icon icon-tel"></i></a>
                <?php if($user->qq): ?>
                    <a href="mqqwpa://im/chat?chat_type=wpa&uin=<?php echo $user->qq; ?>&version=1&src_type=web" target="_blank" class="mail"><i class="icon icon-qq"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="addressinfo">
            <ul class="progress order-progress" id="orders-ul">
                <?php
                    $orders=$user->limitOrder;
                    $totalCount=count($user->order);
                foreach($orders as $order){
                ?>
                <li>
                    <a class="inner">
                        <p class="time"><strong class="em-2">用户订单</strong><?php echo date('Y-m-d H:i:s',$order->created)?></p>
                        <p class="step">来源类型：<?php echo $order->spm_b?></p>
                        <?php if($p = $order->getPlot()) :?>
                        <p class="step">意向楼盘：<?php echo $p->title?></p>
                        <?php endif;?>
                    </a>
                </li>
                <?php }?>
            </ul>
            <dl><dt>客服备注：</dt><dd class="em-grey"><?php echo $user->note?$user->note:'暂无'; ?></dd></dl>
            <?php if($totalCount>count($orders)):?>
            <div class="more">加载更多</div>
            <?php endif;?>
        </div>
        <div class="floormark">
            <h2>意向楼盘</h2>
            <div class="mindplot-floor">
                <ul>
                    <?php if($user->yxlp): ?>
                    <?php foreach($user->yxlp as $k=>$v):?>
                    <li>
                        <p><?php echo $v->title?></p>
                        <?php if($user->staff_status!=1&&$user->staff_status!=9) {
                            echo CHtml::ajaxLink('删除', $this->createUrl('ajaxDelMind'), array('type' => 'post', 'data' => array('id' => $v->yxyh[0]->id, 'phone' => $user->phone), 'success' => 'js:function(d){if(d.code){location.reload()}else{toastr.error("删除失败！")}}'), array('class' => 'link', 'confirm'=>'确认删除？'));
                        }?>
                    </li>
                    <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
            <?php if($user->staff_status!=1&&$user->staff_status!=9):?>
            <a href="<?php echo $this->createUrl('addMind',['phone'=>$user->phone,'status'=>$status,'page'=>$page]); ?>" class="button em-1">+意向楼盘</a>
            <?php endif;?>
            <h2>楼盘登记</h2>
            <?php foreach($user->check as $v): ?>
                <div class="floor-regist">
                    <a href="<?php echo $this->createUrl('/wap/staff/add',['phone'=>$user->phone,'id'=>$v->id,'status'=>$status,'page'=>$page]); ?>">
                        <p class="clearfix"><?php echo $v->plot->title; ?>
                            <span class="stars">
                        <?php for($i=0;$i<count(PlotExt::$star)-1;$i++): ?>
                            <i class="<?php echo $v->plot->star--<=0?'stars-none':''; ?>"></i>
                        <?php endfor; ?>
                        </span>
                            <span class="fr"><?php echo StaffCheckExt::$status[$v->status]; ?></span>
                        </p>
                        <p class="gc9">
                            <span class="gc3">登记时间: </span><?php echo date('Y-m-d', $v->created)?>
                            <?php if($v->end_time&&$v->status): ?><span class="gc3 ml10">截止时间:</span><?php echo date('Y-m-d',$v->end_time); ?><?php endif; ?>
                        </p>
                    </a>
                </div>
            <?php endforeach; ?>
            <a href="<?php echo $this->createUrl('add',['phone'=>$user->phone,'status'=>$status,'page'=>$page]); ?>" class="button em-1">+添加楼盘</a>
            <h2>进度跟踪</h2>
            <ul class="progress">
                <?php
                foreach($log as $v):
                    if($v->staff_id):
                        ?>
                        <li>
                            <a class="inner">
                                <p class="time"><strong class="em-2 em-3">[顾问]<?php echo UserExt::$staffStatus[$v->staff_status]; ?></strong><?php echo date('Y-m-d H:i', $v->created); ?></p>
                                <p class="step"><?php echo $v->content; ?></p>
                            </a >
                        </li>
                    <?php elseif($v->admin_id): ?>
                        <li>
                            <a class="inner">
                                <p class="time"><strong class="em-2">[客服]<?php echo UserExt::$visitStatus[$v->visit_status]; ?></strong><?php echo date('Y-m-d H:i', $v->created); ?></p>
                                <p class="step"><?php echo $v->content; ?></p>
                            </a >
                        </li>
                        <?php
                    endif;
                endforeach;
                ?>
            </ul>
            <?php $form = $this->beginWidget('CActiveForm'); ?>
            <h2>进度状态</h2>
            <div class="state-select">
                <?php echo CHtml::textField('sel',UserExt::$staffStatus[$user->staff_status],array(
                    'class'=>'ui-mobi-select',
                    'data-select'=>implode(',',$staffStatus),
                )); ?>
                <?php echo $form->hiddenField($model, 'staff_status', array('class'=>'ui-mobi-select-val')); ?>
                <?php echo $form->hiddenField($model, 'phone', array('value'=>$user->phone)); ?>
                <i class="icon icon-right-arrow2"></i>
            </div>
            <div class="textarea">
                <?php echo $form->textArea($model, 'content', ['cols'=>30, 'row'=>10, 'placeholder'=>'关键事件要求必须添加记录，描述情况内容']); ?>
            </div>
            <?php echo CHtml::submitButton('保存', array('class'=>'button em-1 save-btn')); ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script>
    var page= 1,limit=5;
    var count=<?php echo $totalCount;?>;
    $('.addressinfo .more').on('click',function(){
        page++;
        var url='<?php echo $this->createUrl('/wap/staff/ajaxGetOrders')?>';
        $.ajax({
            type:'POST',
            url:url,
            data:{
                page:page,
                limit:limit,
                phone:'<?php echo $user->phone;?>'
            },
            success:function(data){
                var result=$.parseJSON(data);
                var html=result['html'];
                $('#orders-ul').append(html);
                if(page*limit>=count){
                    $('.addressinfo .more').addClass('dn');
                }
            }
        });
    })
</script>






