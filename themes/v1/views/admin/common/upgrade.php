<?php
$this->pageTitle = '新版房产升级';
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-block alert-warning fade in">
			<button type="button" class="close" data-dismiss="alert"></button>
			<h4 class="alert-heading">升级须知</h4>
			<p>
				 请先确认以下须知无误后，再点击按钮进行系统升级：
			</p>
            <p>
                1.是否升级新版房产请由相关主管负责人做决策，由技术人员进行操作；<br>
                2.升级过程不可逆，升级完成后会有一部分的新功能等待填充数据，因此请最好在平台访问的非高峰时段进行升级；<br>
                3.升级过程中系统将进行数据转换，请通知所有人员不要进行任何数据操作，等待升级完成后再进行操作；<br>
                4.负责操作升级的人员请停留在该页面等待升级完成，升级过程中请勿关闭浏览器；<br>
                5.升级过程中遇到问题或者升级失败请及时反馈到航加沟通群，以免不必要的损失。（建议计划升级前通知航加工作人员，保障升级顺利）<br>
            </p>
            <p>
                <br>
            </p>

            <p>
                <div class="caption font-red-intense">
                    <h4>
                        <span class="badge badge-danger">New</span>
                        <span class="caption-subject bold uppercase" id="liaojie" style="cursor:pointer">点击了解关于航加房产系统v2.0的更多详情</span>
                    </h4>
                </div>
            </p>
			<p>
                <?php if(!$pwRight): ?>
                <a class="btn red disabled" id="shengji" data-toggle="modal" href="#small">确认升级<span id="dengdai">[请先阅读须知]</span></a>
                <a class="btn blue" href="javascript:;">取消</a>
                <?php endif; ?>
			</p>
		</div>
    </div>
</div>

<?php if($pwRight): ?>

    <div class="row">
        <div class="col-md-12">
            <iframe src="<?=$this->createUrl('/admin/common/upgrade', ['process'=>time(),'token'=>md5('123')]); ?>" width="100%" height="400px" frameborder=0 scrolling="no"></iframe>
        </div>
    </div>

<?php else: ?>

<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
            <form class="" action="" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">请输入您的登录密码</h4>
			</div>
			<div class="modal-body">
                    <input type="password" name="pw" value="" class="form-control">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">关闭</button>
				<button type="submit" class="btn red">确认</button>
			</div>
        </form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php endif; ?>

<script type="text/javascript">
    <?php Tools::startJs(); ?>
    var sec = 20;
    var ds = setInterval(function(){
        $("#dengdai").text("[请先阅读须知"+(sec--)+"]");
        if(sec<0){
            clearInterval(ds);
            $("#shengji").removeClass('disabled');
            $("#dengdai").text('');
        }
    },1000);

    $("#liaojie").click(function(){
        window.open('http://www.hangjiayun.com/product/fcdsj');
    });
    <?php Tools::endJs('js'); ?>
</script>
