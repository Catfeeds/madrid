<?php
$this->pageTitle = '问答库';
$this->breadcrumbs = array('问答管理','问答列表');
?>
    <div class="table-toolbar">
        <div class="btn-group pull-left">
            <form class="form-inline">
                <div class="form-group">
                    <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('question'=>'问题标题','phone'=>'手机号','cid'=>'分类'),array('class'=>'form-control','encode'=>false)); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
                </div>
                <div class="form-group" >
                    <?php echo CHtml::dropDownList('parent',empty($_GET['parent'])?'':$_GET['parent'],$parents,array('class'=>'form-control')) ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::dropDownList('child',empty($_GET['child'])?'':$_GET['child'],$childs_arr,array('class'=>'form-control')) ?>
                </div>
                <button type="submit" class="btn red">搜索</button>
            </form>
        </div>
        <div class="btn-group pull-right">
            <a href="<?php echo $this->createUrl('edit') ?>" class="btn green">
                添加问答 <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    <table class="table table-bordered table-striped table-condensed flip-content">
        <thead class="flip-content">
        <tr>
            <th width="35px" class="text-center"></th>
            <th class="text-center">id</th>
            <th class="text-center">电话</th>
            <th class="text-center">称呼</th>
            <th class="text-center" width="300px">问题</th>
            <th class="text-center">浏览量</th>
            <th class="text-center">分类</th>
            <th class="text-center" width="150px">楼盘</th>
            <th class="text-center">是否回答</th>
            <th class="text-center" width="10%">提问时间</th>
            <th class="text-center" width="10%">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($data):
            foreach($data as $v): ?>
                <tr>
                    <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v->id;?>" class="checkboxes"></td>
                    <td class="text-center"><?php echo $v->id; ?></td>
                    <td class="text-center"><?php echo $v->phone; ?></td>
                    <td class="text-center"><?php echo $v->name; ?></td>
                    <td class="text-center"><a href="<?php echo Yii::app()->createUrl('/home/wenda/detail',array('id'=>$v->id))?>" target="_blank"><?php echo $v->question; ?></a></td>
                    <td class="text-center"><?php echo $v->views; ?></td>
                    <td class="text-center"><?php echo $v->cate? $v->cate->name : '无'; ?></td>
                    <td class="text-center"><?php echo $v->plot ? $v->plot->title : '无'; ?></td>
                    <td class="text-center"><?php echo $v->answer ? '是' : '否'; ?></td>
                    <td class="text-center"><?php echo date('Y-m-d',$v->created); ?></td>
                    <td class="text-center">
                        <a href="<?php echo $this->createUrl('/admin/ask/edit',array('id'=>$v->id)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                        <?php
                        echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('del'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                        ?>
                    </td>
                </tr>
            <?php endforeach;
        endif;?>
        </tbody>
    </table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
    <div class="form-group">
        <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
        <?php echo  CHtml::ajaxButton('删除所选', $this->createUrl('del'), array('data'=>array('id'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
    </div>
    <!-- 弹窗 -->
    <div class="modal fade" id="Admin">
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

    <script language="JavaScript">
        setInterval(function(){
            $("#AdminIframe").height($("#AdminIframe").contents().find("body").height());
            var $panel_title = $('#fade-title');
            $panel_title.html($("#AdminIframe").contents().find("title").html());
        },200);
        function do_admin(ts){
            $('#AdminIframe').attr('src',ts.data("url")).load(function(){
                self = this;
                //延时100毫秒设定高度
                $("#Admin").modal({ show: true, keyboard:false });
                $("#Admin .modal-dialog").css({width:"800px"});
            });
        }
    </script>
<?php
$js = "
    $(document).on('click',function(e){
          var target = $(e.target);
          if(!target.hasClass('sort_edit')){
             $('.sort_edit').trigger($.Event( 'keypress', 13 ));
          }
    });
    $('.sort_edit').click(function(){
        if($(this).find('input').length <1){
            $(this).html('<input type=\"text\" value=\"' + $(this).html() + '\" class=\"form-control input-sm sort_edit\" onkeypress=\"return do_sort(event)\" onblur=\"set_sort($(this),$(this).parent().data(\'id\'),$(this).val())\">');
            $(this).find('input').select();
        }
    });
";
Yii::app()->clientScript->registerScript('sort_edit',$js);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
<?php
$checkbox = '
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents(\'span\').hasClass("checked")){
                if(ids == \'\'){
                    ids = $(this).val();
                } else {
                    ids = ids + \',\' + $(this).val();
                }
            }
        });
        return ids;
    }

    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });

    $("#parent").change(function(){
        $.ajax({
            type:"get",
            url:"'.$this->createUrl("/admin/ask/AjaxGetChildCate").'",
            dataType: "json",
			delay: 250,
			data:"pid="+$(this).val(),
			success:function(data){
			    $("#child").empty();
                $.each(data,function(index,val){
                    $("#child").append("<option value=" + val.id + ">" + val.name + "</option>");
                })
			}
        });
    });


';

Yii::app()->clientScript->registerScript('sel', $checkbox, CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
<script>
    <?php Tools::startJs(); ?>
        function change_css_show(){
            var select_type = $("#type").val();
            if(select_type == "cid"){
                $("#value").hide().attr("disabled",true);
                $("#parent,#child").show().attr("disabled",false);
            }else{
                $("#value").show().attr("disabled",false);
                $("#parent,#child").hide().attr("disabled",true);
            }
        }
        $(function(){
            change_css_show();
        });
        $("#type").change(function(){
            change_css_show();
        });
    <?php Tools::endJs('js') ?>
</script>
