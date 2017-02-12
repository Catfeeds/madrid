<?php
$this->pageTitle = '职员列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',$type,array('name'=>'姓名','uid'=>'UID','account'=>'论坛账号','sid'=>'商家名称','phone'=>'电话'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',$value,array('class'=>'form-control chose_text')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('time_type',$time_type,array('created'=>'添加时间','updated'=>'刷新时间','expire'=>'套餐到期时间'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <?php Yii::app()->controller->widget("DaterangepickerWidget",['time'=>$time,'params'=>['class'=>'form-control chose_text','style'=>'width:200px']]);?>

            <div class="form-group">
                <?php echo CHtml::dropDownList('checkStatus',$checkStatus,Yii::app()->params['shopStatus'],array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--审核状态--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('isPackage',$isPackage,[0=>'已使用套餐',1=>'未使用套餐'],array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--套餐状态--')); ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
        </form>
    </div>
    <div class="pull-right">
        <a href="<?php echo $this->createUrl('resoldStaffEdit') ?>" class="btn green">
            添加职员 <i class="fa fa-plus"></i>
        </a>
    </div>
    
</div>
   <table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <!-- <th class="text-center">ID</th> -->
        <th class="text-center">账号</th>
        <th class="text-center">真实姓名</th>
        <th class="text-center">商家名称</th>
        <th class="text-center">电话</th>
        <th class="text-center">套餐名称</th>
        <th class="text-center">总数/加急/预约数</th>
        <th class="text-center">套餐到期时间</th>
        <th class="text-center">添加时间</th>
        <!-- <th class="text-center">状态</th> -->
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $k=>$v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>" class="checkboxes"></td>
            <!-- <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td> -->
            <td style="text-align:center;vertical-align: middle"><acronym title="<?='uid:'.$v->uid?>"><?php echo $v->account; ?></acronym></td>
            <td class="text-center"><?=$v->name?> <i onmouseover="showStaffPic(this)" data-img="<?=ImageTools::fixImage($v['image'])?>" class="fa fa-file-image-o"></i></td>
            <td class="text-center"><?=$v->shop?$v->shop->name:'无'?></td>
            <td class="text-center"><?=$v->phone?></td>
            <td class="text-center"><?=$v->packages?$v['packages'][0]['name']:'无'?></td>            
            <td class="text-center"><a onclick="do_admin($(this))" data-url=<?=$this->createUrl('/admin/resoldStaff/packageEdit',['id'=>$v->id])?>><?php if($package = $v->packages){  $package = json_decode($package[0]['content'],true);echo $package['total_num'].'/'.$v->hurry_num.'/'.$package['appoint_num'];}else{echo SM::resoldConfig()->resoldExtraSaleNum->value.'/0/0';} $packageExpire = isset($v->staffPackage)?$v->staffPackage->expire_time:0; echo time()-$packageExpire>=0?' <b style="color:red">已到期</b>':'';  ?></a></td>
            <td class="text-center"><?=$v->expireTime?date('Y-m-d',$v->expireTime):'-'?></td>
            <td class="text-center"><?=date('Y-m-d',$v->created)?></td>
            <!-- <td class="text-center">
            <div class="btn-group">
                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <?=Yii::app()->params['shopStatus'][$v->status]?> <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                    <?php foreach(Yii::app()->params['shopStatus'] as $key=>$v1){?>
                        <li>
                            <?=CHtml::ajaxLink($v1,$this->createUrl('staffStatus',['kw'=>$v1=='正常'?'open':($v1=='禁用'?'close':'check'),'ids'=>$v->id]),['success'=>'function(){location.reload();}'])?>
                        </li>
                      <?php  }?>
                    </ul>
                </div>
            </td> -->
            <td style="text-align:center;vertical-align: middle">
                    <a href="<?php echo $this->createUrl('/admin/resoldStaff/resoldStaffEdit',array('id'=>$v->id)); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                    <?php
                        echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('AjaxDelStaff'),'type'=>'post','success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}','data'=>array('id'=>$v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/resoldStaff/staffStatus'), array('data'=>array('ids'=>'js:getChecked()','kw'=>'open'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/resoldStaff/staffStatus'), array('data'=>array('ids'=>'js:getChecked()','kw'=>'close'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
</div>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)); ?>


<!-- 弹窗 -->
<div class="modal fade" id="Admin" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="panel-title">
                    <span id="fade-title"></span>
                    <button type="button" class="close" onclick="location.reload()" data-dismiss="modal" aria-hidden="true"></button>
                </h3>
            </div>
            <div class="modal-body">
                <iframe id="AdminIframe" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
<?php Tools::startJs(); ?>
    setInterval(function(){
        $('#AdminIframe').height($('#AdminIframe').contents().find('body').height());
        var $panel_title = $('#fade-title');
        $panel_title.html($('#AdminIframe').contents().find('title').html());
    },200);
    function do_admin(ts){
        $('#AdminIframe').attr('src',ts.data('url')).load(function(){
            self = this;
            //延时100毫秒设定高度
            $('#Admin').modal({ show: true, keyboard:false });
            $('#Admin .modal-dialog').css({width:'800px'});
        });
    }
    function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('/admin/shop/ajaxShopSort')?>',{id:id,sort:sort},function(dt){
                location.reload();
            });
        }
    function do_sort(ts){
        if(ts.which == 13){
            _this = $(ts.target);
            sort = _this.val();
            id = _this.parent().data('id');
            set_sort(_this, id, sort);
        }
    }

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
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents('span').hasClass("checked")){
                if(ids == ''){
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
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
    //清空选项
    function removeOptions()
    {
        // alert($('.chose_select').val());
        $('.chose_text').val('');
        $('.chose_select').val('');
    }

    $("#hname").on("dblclick",function(){
        var hnames = $(".hname");
        console.log(hnames);
        hnames.each(function(){
            var _this = $(this);
            $.getJSON("<?php echo $this->createUrl('/api/houses/getsearch') ?>",{key:_this.html()},function(dt){
                _this.append(" (" + dt.msg[1].length + ")");
            });
        });
    });
    function showStaffPic(obj) {
        $('.staff-img').remove();
        var img = $(obj).data('img');
        if(img != '') {
            $(obj).after('<img onmouseout="clearStaffPic()" class="staff-img" src="'+ img +'" style="width:120px;height:150px">');
        }
    }
    function clearStaffPic() {
        $('.staff-img').remove();
    }
<?php Tools::endJs('js') ?>
</script>
