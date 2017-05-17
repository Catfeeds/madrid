<?php
$this->pageTitle = '下架租房';
?>
<div class="esf-fabu-container">
    <!--多行式面包屑导航-->
    <?php $this->widget('VipieBreadCrumbsWidget',['fields'=>[['name'=>'管理租房',],['name'=>'下架租房']]])?>
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
            'action'=>'/vipie/zf/saleDown',
        ]])?>
        <!--简易数据表格-->
        <table class="m-table">
            <thead>
            <tr>
                <th style="width: 5%"><input type="checkbox"></th>
                <th style="width: 5%">ID</th>
                <th class="colc">房源详情</th>
                <th class="cola">发布时间</th>
                <th class="cola">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($dataProvider->data as $k=>$v): ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?=$v->id?>" class="checkbox"/></td>
                    <td><?= $v->id; ?></td>
                    <td>
                        <div class="m-list3 m-list3-x">
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
                    <td>
                        <a href="<?php echo $this->createUrl('publish',array('id'=>$v->id)); ?>" class="u-btn u-btn-3">修改</a>
                        &nbsp;
                        <a class="u-btn u-btn-4 j-up-sale" data-id="<?=$v->id;?>">上架</a>
                        &nbsp;
                        <a class="u-btn u-btn-1 j-delete" data-id="<?=$v->id;?>">删除</a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <div class="all-opt">
            <div class="blank20"></div>
            <!--通用自定义按钮-->
            <a class="u-btn u-btn-4 j-checkAll">全选/反选</a>
            <a class="u-btn u-btn-4 j-upSaleAll">上架所选</a>
            <a class="u-btn u-btn-4 j-deleteAll">删除所选</a>
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
            $('.j-upSaleAll').click(function(){
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
                    'title' : '您确定要上架所选吗？',
                    'ok' : function() {
                        $.ajax({
                            type:'post',
                            dataType:'json',
                            url:'/vipie/zf/upSale',
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
            $('.j-deleteAll').click(function(){
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
                    'title' : '您确定要删除所选吗？',
                    'ok' : function() {
                        $.ajax({
                            type:'post',
                            dataType:'json',
                            url:'/vipie/zf/delete',
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
            $('.j-delete').click(function(){
                    var id = $(this).data('id');
                    $.fn.showConfirm({
                        'title' : '您确定要删除吗？',
                        'ok' : function() {
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                url:'/vipie/zf/delete',
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
            $('.j-up-sale').click(function(){
                var id = $(this).data('id');
                    $.fn.showConfirm({
                        'title' : '您确定要上架吗？',
                        'ok' : function() {
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                url:'/vipie/zf/upSale',
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
        })
       })
    ";
Yii::app()->clientScript->registerScript(__CLASS__.'#js',$js,CClientScript::POS_END);

?>

