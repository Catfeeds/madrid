<?php if($page==1): ?>
<table class="table table-bordered table-striped table-condensed flip-content" style="margin-bottom:0" id="log_table">
    <thead class="flip-content">
        <tr>
            <th class="text-center" width="5%">次数</th>
            <th class="text-center" width="10%">工作人员/管家</th>
            <th class="text-center" width="20%">状态</th>
            <th class="text-center" >流水内容</th>
            <th class="text-center" width="20%">记录时间</th>
        </tr>
    </thead>
    <tbody>
<?php endif; ?>
        <?php foreach($data as $k=>$v): ?>
        <tr>
            <td class="text-center"><?php echo $pager->getItemCount()-($page-1)*$pager->getPageSize()-$k; ?></td>
            <td class="text-center">
                <?php
                    if($v->admin_id){
                        echo CHtml::tag('span',array('class'=>'btn btn-xs btn-info','title'=>'小编'),CHtml::tag('i',array('class'=>"fa fa-user")).' '.$v->admin->username);
                    }elseif($v->staff_id){
                        echo CHtml::tag('span',array('class'=>'btn btn-xs red','title'=>'买房顾问'),CHtml::tag('i',array('class'=>"fa fa-user")).' '.$v->staff->username);
                    }else{
                        echo CHtml::tag('span',array('class'=>'btn btn-xs btn-info','title'=>'[系统]'),CHtml::tag('i',array('class'=>"fa fa-user")).'[系统]');
                    }
                ?>
            </td>
            <td class="text-center">
                <?php
                    echo $v->admin_id ?
                        CHtml::tag('span', array('class'=>UserExt::$visitStatusStyle[$v->visit_status]),UserExt::$visitStatus[$v->visit_status])
                        : CHtml::tag('span', array('class'=>UserExt::$staffStatusStyle[$v->staff_status]), UserExt::$staffStatus[$v->staff_status]); ?>
            </td>
            <td class="text-center"><?php echo $v->content; ?></td>
            <td class="text-center"><?php echo date('Y-m-d H:i:s', $v->created); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if(!$data): ?>
            <tr class="text-center"><td colspan="5">暂无</td></tr>
        <?php endif; ?>
<?php if($page==1): ?>
    </tbody>
</table>
<?php if($more): ?>
<script type="text/javascript">var order_list_page=2;</script>
<?php echo CHtml::ajaxLink('显示更多',$this->createUrl('ajaxLogList',array('phone'=>$phone)),array('data'=>array('page'=>'js:order_list_page'),'success'=>'function(d){order_list_page++;$("#log_table tbody").append(d.msg);window.parent.resizeModal();if(!d.code){$("#order_show_more").hide()}}'),array('class'=>'list-group-item list-group-item-warning text-center','id'=>'order_show_more')); ?>
<?php endif; ?>
<?php endif; ?>
