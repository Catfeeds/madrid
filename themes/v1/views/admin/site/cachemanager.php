<?php 
$this->pageTitle = '缓存管理';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="note note-success">
    <p>下列列表展示的为已经缓存的数据信息，点击清除可将其清空，重新访问相关页面时会再次生成。</p>
</div>
<div class="portlet-body flip-scroll">
    <div class="table-toolbar">
        <form class="form-inline">
            缓存描述：
            <div class="form-group">
                <?php echo CHtml::textField('name',$name,array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
        <div class="btn-group pull-right">

    </div>
    </div>
    <table class="table table-bordered table-striped table-condensed flip-content">
        <thead class="flip-content text-center">
            <tr>
                <th width="20%">缓存标识id</th>
                <th class="numeric">缓存描述</th>
                <th class="numeric">过期时间</th>
                <th class="numeric">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $k=>$v): ?>
                <tr>
                    <td><?php echo $k; ?></td>
                    <td><?php echo $v[1]; ?></td>
                    <td><?php echo empty($v[0]) ? '永久有效，直到数据更新' : date('Y-m-d H:i:s',$v[0]); ?></td>
                    <td>
                        <a href="<?php echo $this->createUrl('cacheManager',array('id'=>$k)) ?>" class="btn default btn-sm red"><i class="fa fa-times"></i> 清除 </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>