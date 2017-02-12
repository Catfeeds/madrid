<?php
$this->pageTitle = '问答分类';
$this->breadcrumbs = array($this->pageTitle);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/jquery-nestable/jquery.nestable.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile("/static/global/plugins/jquery-nestable/jquery.nestable.css");
?>
    <script>
        var count_data = <?php echo $json; ?>;
    </script>

    <div class="tip-container">
    </div>
<div class="portlet-body flip-scroll">
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success');?></div>
<?php endif;?>
<?php if(Yii::app()->user->hasFlash('danger')):?>
    <div class="alert alert-danger"><?php echo Yii::app()->user->getFlash('danger');?></div>
<?php endif;?>
    <div style="padding-bottom:20px;float:right">
        <a onclick="editAskCate($(this))" class="btn blue">添加分类&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
        <?php echo CHtml::button('保存修改',array('id'=>'do_sort','class'=>'btn green'))?>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="portlet-body ">
                <?php echo $tree ? $tree : '' ?>
            </div>
        </div>
    </div>

    <!-- 弹窗 -->
    <div class="modal fade" id="Admin" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="panel-title">
                        <span id="fade-title"></span>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </h3>
                </div>
                <div class="modal-body">
                    <iframe id="AdminIframe" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
<?php Tools::startJs(); ?>
    $(function(){
        $('#treeAskCateExt').nestable({maxDepth:2});
        $('#do_sort').on('click',function(ev){
            dt = JSON.stringify($('#treeAskCateExt').nestable('serialize'));
            $.getJSON('<?php echo $this->createAbsoluteUrl("cateEdieJson"); ?>',{data:dt},function(msg) {
                if(msg.code == 100) {
                    location.reload();
                }
            });
        });

        $('#treeAskCateExt .dd-item').prepend('<span class=\"ops\" style=\"float:right;cursor: pointer; line-height:30px;\"><span style=\"margin-right:5px;\" onclick=\"editAskCate($(this))\">编辑</span><span style=\"margin-right:5px;\"  onclick=\"delAskCate($(this))\">删除</span></span>');
        $('#treeAskCateExt .dd-item[data-status=1]').find('span:first').prepend('<span style=\"margin-right:5px;\" onclick=\"setStatus(this)\" class=\"dd-status\">禁用</span>');
        $('#treeAskCateExt .dd-item[data-status=0] .dd-handle').addClass('bg-red-pink');
        $('#treeAskCateExt .dd-item[data-status=0]').find('span:first').prepend('<span class=\"dd-status\" onclick=\"setStatus(this)\" style=\"margin-right:5px;\">启用</span>');

    });

    setTimeout(function(){
        $('.ops').each(function(){
         var dd_handle = $(this);
         var cid = $(this).closest('.dd-item').data('id');
         dd_handle.prepend('<span style=\"margin-right:10px;\">[ '+count_data[cid].count+' ]</span>');
        });
    },1000);

    setInterval(function(){
        $("#AdminIframe").height($("#AdminIframe").contents().find("body").height());
        var $panel_title = $('#fade-title');
        $panel_title.html($("#AdminIframe").contents().find("title").html());
    },200);
    function delAskCate(obj){
        var subItem = $(obj).closest('li').find('.dd-item');
        if(subItem.length){
            alert('该分类下存在子分类，无法删除');
            return false;
        }else{
            del($(obj).closest('li').data('id'), obj);
        }
    }
    function editAskCate(ts){
        var edit_url;
        var id;
        id = ts.closest('li').data('id') || 0;
        edit_url = '<?php echo Yii::app()->createAbsoluteUrl("admin/ask/cateedit");?>'+'?id='+id;
        $('#AdminIframe').attr('src',edit_url).load(function(){
            self = this;
            //延时100毫秒设定高度
            $("#Admin").modal({ show: true, keyboard:false });
            $("#Admin .modal-dialog").css({width:"800px"});
        });
    }

    function setStatus(obj){
        var ddItem = $(obj).closest('.dd-item');
        var currentStatus = ddItem.attr('data-status');

        if(currentStatus == 1){
            ddItem.attr('data-status',0);
            $(obj).text('启用');

            var subItem = ddItem.find('.dd-item');
            if( subItem.length ){
                subItem.find('.dd-status').text('启用');
                subItem.attr('data-status',0);
            }

            ddItem.find('.dd-handle').addClass('bg-red-pink');
        }else{
            ddItem.attr('data-status',1);
            $(obj).text('禁用');

            var subItem = ddItem.find('.dd-item');
            if( subItem.length ){
                subItem.find('.dd-status').text('禁用');
                subItem.attr('data-status',1);
            }
            ddItem.find('.dd-handle').removeClass('bg-red-pink');
        }
    }

    function del(id,obj){
            if(confirm("是否确定删除?")){
                // location.href="<?php echo $this->createAbsoluteUrl('catedel')?>?id="+id;
                var url = "<?php echo $this->createAbsoluteUrl('catedel')?>?id="+id;
                var html_success = ' <div class="alert alert-success"> <strong>操作成功</strong> </div> ';
                var html_error = ' <div class="alert alert-success"> <strong>操作成功</strong> </div> ';

                $.getJSON(url,{},function(data){

                    if(data.code == 100){
                        $('.tip-container').append(html_success);

                    }else{
                        $('.tip-container').append(html_error);
                    }

                    setTimeout(function(){
                        $('.tip-container').find('.alert').remove();
                        $(obj).closest('li').remove();
                    },500);
                });
            }
        }
<?php Tools::endJs('js'); ?>
</script>
