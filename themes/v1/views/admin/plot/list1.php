<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */
$this->pageTitle = '房源列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',$type,array('title'=>'标题','id'=>'ID'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',$value,array('class'=>'form-control')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('status', $status, PlotExt::$status, array('class'=>'form-control','prompt'=>'--状态--')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('new', $new, array(1=>'新盘',0=>'旧房'), array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
    <div class="pull-right">
        <a href="<?php echo $this->createAbsoluteUrl('edit') ?>" class="btn green">
            添加楼盘 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
        <th class="text-center" id="hname">楼盘名称</th>
        <th class="text-center">均价</th>
        <th class="text-center">点击量</th>
        <th class="text-center">信息编辑</th>
        <th class="text-center">状态</th>
        <th class="text-center">推荐</th>
        <th class="text-center">更新时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $k=>$v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>" class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort ?></td>
            <?php
            $lab =  array(
                'data-original-title'=>'地图',
                'data-content'=> CHtml::image('http://api.map.baidu.com/staticimage?width=246&height=299&center='.$v['map_lng'].','.$v['map_lat'].'&zoom='.$v['map_zoom'].'&markers='.$v['map_lng'].','.$v['map_lat'].'&markerStyles=l,&copyright=1'),
                'data-html'=>'true',
                'data-placement'=>'right',
                'data-trigger'=>'hover',
                'data-container'=>'body',
                'class'=>'popovers'
            );
            ?>
            <?php echo CHtml::openTag('td',$lab); ?><a href="<?php echo Yii::app()->createUrl('home/plot/index',array('py'=>$v->pinyin))?>" target="_blank" class="hname"><?php echo Tools::utf8substr($v->title,0,30); ?></a><?php echo CHtml::closeTag('td'); ?>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->price ? $v->price.PlotPriceExt::$unit[$v->unit] : '暂无'; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->views;?></td>
            <td style="text-align:center;vertical-align: middle">
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a class="label label-primary" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('/admin/plot/pricelist',array('hid'=> $v->id)) ?>">价格动态</a>
                </div>
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a href="javascript:;" class="label label-success" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('/admin/plot/imagelist',array('hid'=> $v->id)) ?>">图片相册</a>
                </div>
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a href="javascript:;" class="label label-primary" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('/admin/plot/deliverylist',array('hid'=> $v->id)) ?>">交房时间</a>
                </div>
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a href="javascript:;" class="label bg-blue-hoki" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('/admin/plot/discountlist',array('hid'=> $v->id)) ?>">优惠信息</a>
                </div>
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a href="javascript:;" class="label label-warning" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('/admin/plot/commentList',array('hid'=> $v->id)) ?>">顾问点评</a>
                </div>
                <div class="btn-group">
					<div class="label label-danger dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" style="cursor:pointer;">更多<i class="fa fa-angle-down"></i>
					</div>
					<ul class="dropdown-menu" role="menu">
						<li><a href="javascript:;" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('evaluate',array('hid'=> $v->id)) ?>">楼盘评测</a></li>
                        <li><a href="javascript:;" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('redList',array('hid'=> $v->id)) ?>">楼盘红包</a></li>
                        <li><a href="javascript:;" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('houseTypeList',array('hid'=> $v->id)) ?>">楼盘户型</a></li>
                        <li><a href="javascript:;" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('periodList',array('hid'=> $v->id)) ?>">楼盘期数</a></li>
                        <li><a href="javascript:;" onclick="do_admin($(this))" data-url="<?php echo $this->createUrl('buildingList',array('hid'=> $v->id)) ?>">楼盘楼栋</a></li>
					</ul>
				</div>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(PlotExt::$status[$v->status],$this->createUrl('ajaxStatus'), array('type'=>'post', 'data'=>array('ids'=>$v->id,'status'=>$v->status),'success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>PlotExt::$statusStyle[$v->status])); ?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink('推荐',$this->createUrl('ajaxRecomTime'),array('type'=>'post','data'=>array('id'=>$v->id,'time'=>time()),'success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>'btn btn-xs btn-primary'));?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo ($v->updated > 0) ? date('Y-m-d',$v->updated) : date('Y-m-d',$v->created);?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                    <a href="<?php echo $this->createUrl('/admin/plot/edit',array('id'=>$v->id)); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                    <?php
                        echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('ajaxDel'),'type'=>'post','success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}','data'=>array('id'=>$v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/plot/ajaxStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>0),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/plot/ajaxStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>1),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
</div>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)); ?>


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
            $('#Admin .modal-dialog').css({width:'1000px'});
        });
    }
    function set_sort(_this, id, sort){
        $.getJSON("<?php echo $this->createUrl('/admin/plot/ajaxPlotSort');?>",{id:id,sort:sort},function(dt){
            _this.parent().html(dt.sort);
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

    $("#hname").on("dblclick",function(){
        var hnames = $(".hname");
        console.log(hnames);
        hnames.each(function(){
            var _this = $(this);
            $.getJSON("<?php echo $this->createAbsoluteUrl('/api/houses/getsearch') ?>",{key:_this.html()},function(dt){
                _this.append(" (" + dt.msg[1].length + ")");
            });
        });
    });
<?php Tools::endJs('js') ?>
</script>
