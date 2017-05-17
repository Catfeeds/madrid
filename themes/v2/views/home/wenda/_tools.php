<!-- <script type="text/javascript">
    var calculate_url = "<?php echo $this->createUrl('/api/jsq/calculate'); ?>";
    var get_rate_url = "<?php echo $this->createUrl('/api/jsq/getRate'); ?>";
</script> -->
<div class="tool-block mod-wenda-tool">
    <h3 class="tool-title wenda-aside-title">购房工具</h3>
    <ul class="tool">
        <li><a class="k-cal-3">购房能力评估</a></li>
        <li><a class="k-cal-1" data-href="<?php echo $this->createUrl('/api/jsq/calculate'); ?>">提前还贷计算</a></li>
        <!-- <li><a href="">等额本息还款</a></li> -->
        <li><a class="k-cal-2" >税费计算器</a></li>
        <!-- <li><a href="">等额本金还款</a></li> -->
        <li><a class="k-cal-4" data-href="<?php echo $this->createUrl('/api/jsq/calculate'); ?>">公积金贷款计算</a></li>
        <!-- <li><a href="">二手房流程</a></li> -->
        <!-- <li><a href="">二手房合同</a></li> -->
    </ul>
</div>
