<?php if($page==1): ?>
<table class="table table-bordered table-striped table-condensed flip-content" style="margin-bottom:0" id="order_list">
    <thead class="flip-content">
        <tr>
            <th class="text-center" width="10%">编号</th>
            <th class="text-center" width="10%">来源</th>
            <th class="text-center" width="10%">类型</th>
            <th class="text-center" width="10%">处理状态</th>
            <th class="text-center" width="20%">提交时间</th>
            <th class="text-center" width="10%">操作</th>
        </tr>
    </thead>
    <tbody>
<?php endif; ?>
        <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td class="text-center"><?php echo $v->spm_a; ?></td>
            <td class="text-center"><?php echo $v->spm_b.'-';if($c=$v->getDetailInfo()){echo $c->text?$c->text:'';} ?></td>
            <td class="text-center"><?php echo CHtml::dropDownList('status', $v->status, OrderExt::$status, array('id'=>'status_'.$v->id,'ajax'=>array('url'=>$this->createUrl('/admin/order/ajaxChangeStatus'),'type'=>'post','data'=>array('id'=>$v->id),'success'=>'function(d){if(d.code){toastr.success(d.msg)}else{toastr.error(d.msg)}}'))); ?></td>
            <td class="text-center"><?php echo date('Y-m-d H:i:s', $v->created); ?></td>
            <td class="text-center uniqueid">
                <?php
                    echo CHtml::button('删除', array('id'=>'del_order_'.$v->id, 'class'=>'btn btn-xs red'));
                    $js = '
                        $("#del_order_'.$v->id.'").one("click", function(){
                            $.ajax("'.$this->createUrl('/admin/order/ajaxDel').'",{
                                type:"post",
                                dataType:"json",
                                data: {id:'.$v->id.'},
                                success: function(d){
                                    if(d.code){
                                        toastr.success(d.msg);
                                        load_order_list();
                                    }else{
                                        toastr.error(d.msg);
                                    }
                                }
                            });
                        });
                    ';
                    Yii::app()->clientScript->registerScript('deljs'.$v->id, $js, CClientScript::POS_END);
                 ?>
            </td>
        </tr>
        <?php endforeach; ?>
<?php if($page==1): ?>
    </tbody>
</table>
<?php if($more): ?>
<script type="text/javascript">var order_list_page=2;</script>
<?php echo CHtml::ajaxLink('显示更多',$this->createUrl('ajaxOrderList',array('phone'=>$phone)),array('data'=>array('page'=>'js:order_list_page'),'success'=>'function(d){order_list_page++;$("#order_list tbody").append(d.msg);window.parent.resizeModal();if(!d.code){$("#order_show_more").hide()}}'),array('class'=>'list-group-item list-group-item-warning text-center','id'=>'order_show_more')); ?>
<?php endif; ?>
<?php endif; ?>
