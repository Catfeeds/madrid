<?php
$this->pageTitle = '二手房上架列表';
//引入排序+筛选头部
// include('filterbase/base.php');
?>
<div class="esf-fabu-container">
    <!--多行式面包屑导航-->
    <?php $this->widget('VipieBreadCrumbsWidget',['fields'=>[['name'=>'管理二手房',],['name'=>'上架二手房']]])?>
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
	                <th class="cola">上架时间</th>
	                <th>刷新时间</th>
	                <th>刷新</th>
	                <th>预约</th>
	                <th>加急</th>
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
		            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d',$v->sale_time)?></td>
		            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d H:i:s',$v->refresh_time).'<br>'.((time()-$v->expire_time)>SM::resoldConfig()->resoldExpireTime()*86400?'<span style="color:red">已到期</span>':'')?></td>
		            <td style="text-align:center;vertical-align: middle"><?=($v->refresh_time&&(time()-$v->refresh_time) < SM::resoldConfig()->resoldRefreshInterval->value*60)?'<span style="color:grey">已刷新</span>':CHtml::ajaxLink('刷新',$this->createUrl('refresh'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}'),['class'=>'u-btn u-btn-1'])?>
		            </td>
		            <td style="text-align:center;vertical-align: middle"><?=ResoldAppointExt::model()->count(['condition'=>'fid=:fid and type=1 and status=0','params'=>[':fid'=>$v->id]])>0?'<a href="'.$this->createUrl('appointList',['fid'=>$v->id]).'">您已预约</a> '.CHtml::ajaxLink('取消预约',$this->createUrl('delAppoint'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}')):'<a class="btn btn-xs blue" href="'.$this->createUrl('setAppoint',['fid'=>$v->id]).'">点击预约</a>'?></td>
		            <td style="text-align:center;vertical-align: middle"><?=$v->hurry>0 && (time()-$v->hurry<SM::resoldConfig()->resoldHurryTime->value*3600)?'<span style="color:grey">您已加急</span>':CHtml::ajaxLink('点击加急',$this->createUrl('hurry'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}'))?></td>

		            <td style="text-align:center;vertical-align: middle">
		                    <a href="<?php echo $this->createUrl('publish',array('id'=>$v->id)); ?>" class="u-btn u-btn-3"><i class="fa fa-edit"></i> 修改 </a>
		                    <?php
		                        echo CHtml::htmlButton('下架', array('data-toggle' => 'confirmation', 'class' => 'u-btn u-btn-4','style'=>'margin-right:0', 'data-title' => '确认下架？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('downSale'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('fids' => $v->id))));
		                ?>
		            </td>
		        </tr>
		    <?php endforeach;?> 
            </tbody>
        </table>
        <div class="all-opt">
            <div class="blank20"></div>
            <?php $this->widget('VipLinkPager', array('pages'=>$pager));?>

            <!--通用自定义按钮-->
            <a class="u-btn u-btn-4 group-checkable" onclick="selectIt(this)" data-set=".checkboxes">全选/反选</a>
            <a class="u-btn u-btn-4">下架所选</a>
            <a class="u-btn u-btn-4" onclick="refreshAll()">刷新所有</a>
            <a class="u-btn u-btn-4">点击预选</a>
            <div class="blank20"></div>
        </div>
    </div>
</div>
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