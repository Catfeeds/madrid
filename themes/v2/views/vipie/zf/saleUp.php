<?php
$this->pageTitle = '租房上架列表';
?>
<div class="esf-fabu-container">
    <!--多行式面包屑导航-->
    <?php $this->widget('VipieBreadCrumbsWidget',['fields'=>[['name'=>'管理租房',],['name'=>'上架租房']]])?>
    <div class="blank20"></div>
    <div class="list-container">
        <div class="blank30"></div>
        <?php $this->widget('VipieFilterWidget',['num'=>$this->staff->getCanSaleNum(),'initPlots'=>$plots,'fields'=>[
            'type'=>$type,
            'value'=>$value,
            'time_type'=>$time_type,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'hid'=>$hid,
            'category'=>$category,
            'sort'=>$sort,
            'action'=>'/vipie/zf/saleUp',
        ]])?>
        <!--简易数据表格-->
        <table class="m-table">
            <thead>
            <tr>
                <th style="width: 30px" class="cola col-tc"></th>
                <th style="width: 30px" >ID</th>
                <th class="colc">房源详情</th>
                <th class="cola">发布时间</th>
                <th class="cola">上架时间</th>
                <th>刷新时间</th>
                <th>刷新</th>
                <th>预约刷新</th>
                <th>加急</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($dataProvider->data as $k=>$v): ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?=$v->id?>" class="checkbox"/></td>
                    <td><?= $v->id; ?></td>
                    <td>
                        <div  class="m-list3 m-list3-x">
                            <ul class="f-cb">
                                <li>
                                    <div class="u-img2"><a href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,120,90)?>" alt="" /></a></div>
                                    <div class="txt">
                                        <h3><a href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></h3>
                                        <p class="f-wsn"><?=$v->plot_name?></p>
                                        <p class="f-wsn"><?=$v->size.'m<sup>2</sup> | '.($v->bedroom?($v->bedroom.'室'.$v->livingroom.'厅'):Yii::app()->params['category'][$v->category]).' | '.$v->price.'万元'?></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td><?=date('Y-m-d',$v->created)?></td>
                    <td><?=date('Y-m-d',$v->sale_time)?></td>
                    <td><?=date('Y-m-d H:i:s',$v->refresh_time).'<br>'.((time()-$v->expire_time)>SM::resoldConfig()->resoldExpireTime()*86400?'<span style="color:red">已到期</span>':'')?></td>
                    <td>
                        <?php if($v->isRefresh): ?>
                            <a type="button" class="u-btn u-btn-1">已刷新</a>
                        <?php else: ?>
                            <a type="button" data-id="<?=$v->id;?>" class="u-btn u-btn-4 j-refresh">刷新</a>
                        <?php endif; ?>
                    </td>
                    <td><? if(ResoldAppointExt::model()->count(['condition'=>'fid=:fid and type=1 and status=0','params'=>[':fid'=>$v->id]])>0): ?>
                            <a href="<?= $this->createUrl('appointList',['fid'=>$v->id]) ?>">您已预约</a> <?= CHtml::ajaxLink('取消预约',$this->createUrl('delAppoint'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}')) ?>
                        <?php else: ?>
                            <a class="u-btn u-btn-3" href="<?=$this->createUrl('setAppoint',['fid'=>$v->id])?>">点击预约</a>
                        <?php endif; ?>
                    </td>
                    <td><?php if($v->hurry>0 && (time()-$v->hurry<SM::resoldConfig()->resoldHurryTime->value*3600)): ?>
                        <a type="button" class="u-btn u-btn-1">您已加急</a>
                        <?php else: ?>
                        <a href="javascript:;" type="button" class="u-btn u-btn-4 j-hurry" data-id="<?=$v->id?>">点击加急</a></td>
                        <?php endif; ?>
                    <td>
                        <a href="<?php echo $this->createUrl('publish',array('id'=>$v->id)); ?>" class="u-btn u-btn-3">修改 </a>
                        &nbsp;
                        <a type="button" class="u-btn u-btn-1 j-down-sale" data-id="<?=$v->id?>">下架</a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <div class="all-opt">
            <div class="blank20"></div>
            <!--通用自定义按钮-->
            <a class="u-btn u-btn-4 j-checkAll">全选/反选</a>
            <a class="u-btn u-btn-4 j-donwSaleAll">下架所选</a>
            <a class="u-btn u-btn-4 j-refreshAll">刷新所有</a>
            <a class="u-btn u-btn-4">点击预约</a>
            <?php $this->widget('VipLinkPager', array('pages'=>$dataProvider->pagination));?>
            <div class="blank20"></div>
        </div>
    </div>
</div>

<?php
    $js = "
        Do(function(){
        $('.j-checkAll').click(function(){
            if($('.checkbox').is(':checked')){
                $('.checkbox').attr('checked',false);
            }else{
                $('.checkbox').attr('checked',true);
            }
        });
         Do('dialog',function() {
            $('.j-donwSaleAll').click(function(){
                   if(!$('.checkbox').is(':checked')){
                        alert('请至少选择一项');
                        return false;
                   }
                   var ids = [];
                   $('.checkbox').each(function(){
                        if($(this).is(':checked')){
                            ids.push($(this).val());
                        }
                   })
                   $.fn.showConfirm({
                    'title' : '您确定要下架所选吗？',
                    'ok' : function() {
                        $.ajax({
                            type:'post',
                            dataType:'json',
                            url:'/vipie/zf/downSale',
                            data:{'id' : ids},
                            success:function(res){
                                if(res.code)
                                    location.reload();
                                else
                                    alert(res.msg);
                            }
                        })
                    }
                });
                return false; 
            });
            $('.j-refreshAll').click(function(){
                 if(!$('.checkbox').is(':checked')){
                        alert('请至少选择一项');
                        return false;
                   }
                   var ids = [];
                   $('.checkbox').each(function(){
                        if($(this).is(':checked')){
                            ids.push($(this).val());
                        }
                   })
                   $.fn.showConfirm({
                    'title' : '您确定要刷新所选吗？',
                    'ok' : function() {
                        $.ajax({
                            type:'post',
                            dataType:'json',
                            url:'/vipie/zf/refresh',
                            data:{'id' : ids},
                            success:function(res){
                                if(res.code)
                                    location.reload();
                                else
                                    alert(res.msg);
                            }
                        })
                    }
                });
                return false; 
            });
            $('.j-refresh').click(function() {
                var id = $(this).data('id');
                $.fn.showConfirm({
                    'title' : '您确定要刷新吗？',
                    'ok' : function() {
                        $.ajax({
                            type:'post',
                            dataType:'json',
                            url:'/vipie/zf/refresh',
                            data:{'id' : id},
                            success:function(res){
                                if(res.code)
                                    location.reload();
                                else
                                    alert(res.msg);
                            }
                        })
                    }
                });
                return false;
            });
            $('.j-hurry').click(function(){
                    var id = $(this).data('id');
                    $.fn.showConfirm({
                        'title' : '您确定要加急吗？',
                        'ok' : function() {
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                url:'/vipie/zf/hurry',
                                data:{'id' : id},
                                success:function(res){
                                    if(res.code)
                                        location.reload();
                                    else
                                        alert(res.msg);
                                }
                            })
                        }
                    });
                    return false;
            });
            $('.j-down-sale').click(function(){
                var id = $(this).data('id');
                    $.fn.showConfirm({
                        'title' : '您确定要下架吗？',
                        'ok' : function() {
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                url:'/vipie/zf/downSale',
                                data:{'id' : id},
                                success:function(res){
                                    if(res.code)
                                        location.reload();
                                    else
                                        alert(res.msg);
                                }
                            })
                        }
                    });
                    return false;
            })
        });
       })
    ";
    Yii::app()->clientScript->registerScript(__CLASS__.'#js',$js,CClientScript::POS_END);

?>