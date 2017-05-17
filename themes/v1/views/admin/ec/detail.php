<?php
$this->pageTitle = '详细信息';
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-condensed flip-content">
            <tr>
                <th><?php echo $user->name.'('.$user->phone.')'; ?></th>
                <th>回访状态：<?php echo UserExt::$visitStatus[$user->visit_status]; ?></th>
                <th>分配管家：<?php echo $user->staff->username; ?></th>
            </tr>
            <tr>
                <td colspan="3">
                    意向楼盘：<?php echo $user->intent_plot; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    客服备注：<?php echo $user->note; ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bell-o"></i>楼盘登记
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-condensed flip-content">
                        <tr>
                            <th class="text-center">意向楼盘</th>
                            <th class="text-center">楼盘登记</th>
                            <th class="text-center">登记时间</th>
                            <th class="text-center">截止时间</th>
                            <th class="text-center">跟进人</th>
                            <th class="text-center">备注内容</th>
                        </tr>
                        <?php foreach($user->check as $v): ?>
                        <tr>
                            <td class="text-center"><?php echo $v->plot->title; ?></td>
                            <td class="text-center"><?php echo StaffCheckExt::$status[$v->status]; ?></td>
                            <td class="text-center"><?php echo date('Y-m-d H:i:s', $v->created); ?></td>
                            <td class="text-center"><?php echo date('Y-m-d', $v->end_time); ?></td>
                            <td class="text-center"><?php echo $v->staff->username; ?></td>
                            <td class="text-center"><?php echo $v->note; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bell-o"></i>管家流水
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>次数</th>
                            <th>管家</th>
                            <th>状态</th>
                            <th>流水内容</th>
                            <th>时间</th>
                        </tr>
                        <?php foreach($user->staffLog as $k=>$v): ?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo $v->staff->username; ?></td>
                            <td><?php echo UserExt::$staffStatus[$v->staff_status]; ?></td>
                            <td><?php echo $v->content; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $v->created); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
        setTimeout(function(){
            window.parent.resizeModal();
        }, 500)
    <?php Tools::endJs('js') ?>
</script>
