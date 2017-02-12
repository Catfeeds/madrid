<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title>房产小首页</title>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/static/home/style/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/static/home/style/shouse.css"/>
</head>

<body>
<div class="wapper bigfs">
	<div class="b_frame clearfix">
    	<div id="shouse_left">
            <p class="c-g3 tac fs26 bigfs">房大白服务申请表</p>
            <p class="c-g6 tac fs16 bigfs">一对一专业看房服务，杜绝忽悠</p>
            <form class="text-form" action="post">
                <?php
                    echo CHtml::textField('phone','',array('placeholder'=>'请填写您的联系方式'));
                    echo CHtml::hiddenField('csrf',Yii::app()->request->getCsrfToken());
                    echo CHtml::hiddenField('spm',OrderExt::generateSpm('看房团需求'));
                    echo CHtml::ajaxSubmitButton('免费申请',$this->createUrl('/api/order/ajaxSubmit'),array('success'=>'function(d){alert(d.msg)}'),array('class'=>'btn_apply'));
                ?>
            </form>
    	</div>
    	<div id="shouse_right">
            <div class="box-left">
                <ul id="house_ul" class="clearfix">
                    <?php
                        foreach($recomCate as $k=>$v):
                            if($k<=2):
                     ?>
                    <li>
                        <span class="title"><?php echo $v->name; ?></span>
                        <div>
                            <?php foreach($v->recom as $kk=>$vv): ?>
                                <?php echo $kk?'|':'' ?><a href="<?php echo $vv->url; ?>" target="_blank"><?php echo $vv->title; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <?php
                            endif;
                        endforeach;
                    ?>
                </ul>
                <div class="fangdabai">
                    <p>买房就找房大白：</p>
                    <?php if(isset($staffs[0])): ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $staffs[0]->qq; ?>&site=qq&menu=yes" target="_blank" class="bue"><i class="icon-qq"></i><?php echo $staffs[0]->name; ?></a><?php endif; ?>
                    <?php if(isset($staffs[1])): ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $staffs[1]->qq; ?>&site=qq&menu=yes" target="_blank" class="org"><i class="icon-qq"></i><?php echo $staffs[1]->name; ?></a><?php endif; ?>
                    <?php if(isset($staffs[2])): ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $staffs[2]->qq; ?>&site=qq&menu=yes" target="_blank" class="red"><i class="icon-qq"></i><?php echo $staffs[2]->name; ?></a><?php endif; ?>
                </div>
            </div>
            <div class="box_right">
                <p class="fs12"><span class="fs18 color_red mr15">新房中心</span>共有<span class="color_red"><?php echo $count; ?></span>个楼盘再售</p>
                <div class="ssearch_bar fl mt10 mb10 clearfix">
                    <form action="<?php echo $this->createUrl('/home/plot/list'); ?>" target="_blank">
                        <input type="text" name="kw" placeholder="请输入楼盘地址或楼盘名" class="search_long">
                        <input type="submit" class="find_house fw" value="搜 索" title="搜 索" align="搜 索">
                    </form>
                </div>
                <ul>
                    <li>
                        <span class="fw gc3 fs14 mr10">区域</span>
                        <?php $i = 0; foreach($this->siteArea as $k=>$v):$i++;if($i<=10):?>
                            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$k))?>" title="<?php echo $v?>" target="_blank"><?php echo $v?></a>
                        <?php endif; endforeach;?>
                    </li>
                    <li>
                        <span class="fw gc3 fs14 mr10">价格</span>
                        <?php foreach($this->sitePriceTag as $k=>$v):?>
                            <?php if($v->min == 0):?>
                                <a href="<?php echo $this->createUrl('/home/plot/list',array('ext'=>'p'.$v->id))?>" title="<?php echo $v->title;?>" target="_blank"><?php echo $v->title;?></a>
                            <?php endif;?>

                            <?php if($v->min < $v->max && $v->min != 0 && $v->max != 0):?>
                                <a href="<?php echo $this->createUrl('/home/plot/list',array('ext'=>'p'.$v->id))?>" title="<?php echo $v->title;?>" target="_blank"><?php echo $v->title;?></a>
                            <?php endif;?>
                            <?php if($v->max == 0):?>
                                <a href="<?php echo $this->createUrl('/home/plot/list',array('ext'=>'p'.$v->id))?>" title="<?php echo $v->title;?>" target="_blank"><?php echo $v->title;?></a>
                            <?php endif;?>
                        <?php endforeach;?>
                    </li>
                    <li>
                        <span class="fw gc3 fs14 mr10">版块</span>
                        <?php foreach($bankuai as $k=>$v):?>
                            <a href="<?php echo $v->url; ?>" title="<?php echo $v->title; ?>" target="_blank"><?php echo $v->title; ?></a>
                        <?php endforeach;?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>

</html>
