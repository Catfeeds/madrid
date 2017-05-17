<?php
$this->pageTitle = '学区房';
$this->breadcrumbs = array('学区房', '学区房/管理');
?>

<form action="" method="GET" style="margin-bottom: 10px;">
    <div class="form-inline">
        <label class="control-label">搜索楼盘：</label>
        <input type="text" id="plot_title" class="form-control" name="plot" value="<?php echo $plot?>">
        <input type="hidden" id="plot_id" class="form-control" name="id" value="<?php echo $id ?>">
        <input type="submit" value="搜索" class="btn default ">
    </div>
</form>

<div class="portlet box blue-hoki">  
    <div class="portlet-title">
        <div class="caption">
            所在区楼盘列表\搜索楼盘列表
        </div>        
    </div>
    <div class="portlet-body">
        <div data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
            <?php foreach ($data as $v): ?>
            <a class="val" data-id="<?php echo $v->id; ?>"><?php echo $v->title; ?></a>    
                <?php endforeach; ?>
        </div>
    </div>
</div>


<div class="portlet box blue-hoki"> 
    <div class="portlet-title">
        <div class="caption">
            已选择
        </div>        
    </div>    
    <div class="portlet-body">
        <div data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" >
            <div class="body_data">                
            </div>
            <?php echo CHtml::ajaxButton('保存所选', $this->createAbsoluteUrl('ajaxGetPlot'), array('data' => array('ids' => 'js:getPlotClass()', 'sid' => $id), 'type' => 'post','success'=>'function(data){if(data.code){location.reload()}else{toastr.error(data.msg)}}'), array('class' => 'btn btn-success btn-sm blue')); ?>
        </div>        
    </div>
</div>

<div class="portlet box blue-hoki">  
    <div class="portlet-title">
        <div class="caption">
            已添加
        </div>        
    </div>      
    <div class="portlet-body">
        <div data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
            <?php foreach ($plotrel as $v): ?>
                <div class="plot"><?php echo $v->hname; ?>&nbsp;&nbsp;&nbsp;<?php echo CHtml::ajaxLink('删除', array($this->createUrl('school/ajaxDelRel')),array('data' => array('id' => $v->id), 'type' => 'post','success'=>'function(data){if(data.code){location.reload()}else{toastr.error(data.msg)}}')) ?></div><br/>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
<?php Tools::startJs(); ?>
    var getPlotClass = function() {
        var ids = '';
        $('.body_data').children('div').each(function() {
            if (ids == '') {
                ids = $(this).data('id');
            } else {
                ids = ids + ',' + $(this).data('id');
            }
        });
        return ids;
    };

    $(".val").live("click", function() {
        var id = $(this).data('id');
        var data = $(this).html();
        if (!$('.data' + id).hasClass("data" + id)) {
            $(".body_data").append('<div  class = "data' + id + '" data-id = ' + id + '>' + data + '<a class="delplot" style="color:red">&nbsp;&nbsp;&nbsp;删除</a></div>');
        }
    });

    $(".delplot").live("click", function() {
        $(this).parent().remove();
    });

<?php Tools::endJs('js'); ?>
</script>



