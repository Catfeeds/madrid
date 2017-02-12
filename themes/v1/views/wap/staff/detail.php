<?php
$this->pageTitle = '客户详情';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/js/mobiscroll.min.css');
$this->registerEndJs(['mobiscroll.min','main']);
 ?>
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
        <dl>
            <dt>意向楼盘：</dt>
            <dd>
                <?php
                    if($user->yxlp)
                    {
                        foreach($user->yxlp as $k=>$v)
                        {
                            echo $k ? ','.$v->title : $v->title;
                        }
                    }
                    else
                        echo '无';
                 ?>
            </dd>
        </dl>
        <?php if($user->qq): ?><dl><dt>Q&nbsp;&nbsp;Q：</dt><dd><?php echo $user->qq; ?></dd></dl><?php endif; ?>
        <dl><dt>客服备注：</dt><dd class="em-grey"><?php echo $user->note?$user->note:'无'; ?></dd></dl>
    </div>
    <div class="floormark">
        <h2>楼盘登记</h2>
        <?php foreach($user->check as $v): ?>
        <div class="floor-regist">
            <a href="<?php echo $this->createUrl('/wap/staff/add',['phone'=>$user->phone,'id'=>$v->id,'status'=>$status,'page'=>$page]); ?>">
                <p class="clearfix"><?php echo $v->plot->title; ?>
                    <span class="stars">
                    <?php for($i=0;$i<count(PlotExt::$star)-1;$i++): ?>
                        <em class="<?php echo $v->plot->star--<=0?'stars-none':''; ?>"></em>
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
        <h2>状态</h2>
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
