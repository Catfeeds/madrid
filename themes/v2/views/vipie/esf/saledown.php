<?php
$this->pageTitle = '二手房下架列表';
//引入排序+筛选头部
// include('filterbase/base.php');
?>
<div class="esf-fabu-container">
    <!--多行式面包屑导航-->
    <?php $this->widget('VipieBreadCrumbsWidget',['fields'=>[['name'=>'管理二手房',],['name'=>'下架二手房']]])?>
    <div class="blank20"></div>
    <div class="list-container">
        <div class="blank30"></div>
        <?php $this->widget('VipieFilterWidget',['num'=>$num,'initPlots'=>$initPlots,'fields'=>$fields])?>
        <!--简易数据表格-->
        <table class="m-table">
            <thead>
                <tr>
	                <th style="width: 30px" class="cola col-tc"><input type="checkbox"></th>
	                <th style="width: 50px" >ID</th>
	                <th class="colc">房源详情</th>
	                <th class="cola">发布时间</th>
	                <th>审核状态</th>
	                <th>操作</th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach($list as $k=>$v): ?>
		        <tr>
		            <td style="text-align:center;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>" onclick="choseIt(this)" class="checkboxes"><span class="ids"></span></td>
		            <td class="id" style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
		            <td class="">
		                <span class="title" style="display: none"><?=$v->title?></span>
		                <div style="height: 95px;display: inline-flex;">
		                    <div style="height: 90px;float: left;">
		                        <?php $image = $v->image?$v->image:SM::resoldImageConfig()->resoldNoPic();?>
		                        <img src="<?=ImageTools::fixImage($image,120,90)?>">
		                    </div>
		                    <div style="height: 90px;margin-left: 5px;font-size: 14px">
		                        <div style="height: 33%"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></div>
		                        <div style="height: 33%"><?=$v->plot_name?></div>
		                        <div style="height: 33%"><?=$v->size.'m<sup>2</sup> | '.($v->bedroom?($v->bedroom.'室'.$v->livingroom.'厅'):Yii::app()->params['category'][$v->category]).' | '.$v->price.'万元'?></div>
		                    </div>
		                </div>
		            </td>
		            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d',$v->created)?></td>
		            <td style="text-align:center;vertical-align: middle"><?php $checkStatus = Yii::app()->params['checkStatus'];echo $checkStatus[$v->status];?></td>
                    <td style="text-align:center;vertical-align: middle">
                        <a href="<?php echo $this->createUrl('publish',array('id'=>$v->id)); ?>" class="u-btn u-btn-1 green"><i class="fa fa-edit"></i> 修改 </a>
                        <?php
                            echo CHtml::ajaxLink('上架',$this->createUrl('onSale'),array('type'=>'get','data'=>['fids'=>$v->id],'success'=>'function(){location.reload()}'),['class'=>"u-btn u-btn-3"])
                        ?>
                        <?php
                            echo CHtml::htmlButton('删除', array('data-toggle' => 'confirmation', 'class' => 'u-btn u-btn-4','style'=>'margin-right:0', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('delete'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('fids' => $v->id))));
                            ?>
                    </td>
		        </tr>
		    <?php endforeach;?> 
            </tbody>
        </table>
        <div class="all-opt">
            <div class="blank20"></div>
            <!--通用自定义按钮-->
            <a class="u-btn u-btn-4 group-checkable" onclick="selectIt(this)" data-set=".checkboxes">全选/反选</a>
            <a class="u-btn u-btn-4">下架所选</a>
            <a class="u-btn u-btn-4" onclick="refreshAll()">刷新所有</a>
            <a class="u-btn u-btn-4">点击预选</a>
            <span class="tip">第1/1页，每页20条，共1条房源</span>
            <div class="blank20"></div>
        </div>
    </div>
</div>
<?php $this->widget('VipLinkPager', array('pages'=>$pager));?>
<script type="text/template" id="modselect-tpl">
        <span class="u-btns">
            <span class="u-btn u-btn-c4 select-name">{{now.name}}</span>
            <span type="button" class="u-btn u-btn-c4 select-arrow"><span class="btnsel"></span></span>
            <ul class="u-menu u-menu-min">
                {{each datalist as v k}}
                    <li><a href="#" data-value="{{v.value}}">{{v.name}}</a></li>
                {{/each}}
            </ul>
        </span>
    </script>
    <script>
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).attr('checked') == 'checked'){
                if(ids == ''){
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
                }
            }
        });
       
        return ids;
    }
    function selectIt(obj) {
    	var set = $(obj).data("set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        console.log(set);
        // $.uniform.update(set);
    }

    // $(".group-checkable").click(function () {
    //     var set = $(this).attr("data-set");
    //     $(set).each(function () {
    //         $(this).attr("checked", !$(this).attr("checked"));
    //     });
    //     $.uniform.update(set);
    // });
    //清空选项
    function removeOptions()
    {
        // alert($('.chose_select').val());
        $('input').val('');
        $('select').val('');
        var list = $('.select-name');
        for (var i = 0; i < list.length; i++) {
        	obj = $('.select-name')[i];
        	$(obj).text($(obj).next().next().find('li:first').text());
        }
        $("select[name='sort']").next().find('.select-name').text('----选择排序----');
    }
    function checkAppointIds() {
        var ids = getChecked();
        if(ids.length <= 0) {
            alert('请至少选择一项！');
            return false;
        }else {
             $('#set-appoint').after('<input type="hidden" name="fid" value="'+ids+'"></input>');
            return true;
        }
    }
    function refreshAll() {
    	var ids = getChecked();
    	// console.log(ids);
    }
    function choseIt(obj) {
    	// if()
    }
</script>