<?php
  $this->pageTitle = '红酒列表';
?>
<div class="npagePage" id="t-project">
    <div class="content">
    <?php $cates = CHtml::listData(TagExt::model()->getTagByCate('hjlx')->findAll(),'id','name')?>
        <div id="category" class="dropmenu pro-dropmenu">
            <div class="label plr20"><i class="down fa fa-angle-down transform"></i>
                <div class="text"><?=$cate?$cates[$cate]:'全部类型'?></div>
            </div>
            <ul class="transform lll" data-height="246">
            <?php $cateArr = $_GET;unset($cateArr['cate'])?>
                <li><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$cate?'active':''?>">全部类型</a></li>
                <?php if($cates) foreach ($cates as $key => $value) {?>
            	<li><a href="<?=$this->createUrl('list',$cateArr+['cate'=>$key])?>" class="<?=$key==$cate?'active':''?>"><?=$value?></a></li>
            <?php } ?>
            </ul>
        </div>
        <div id="projectlist">
            <div class="wrapper plr5">
            <?php if($infos) foreach ($infos as $key => $value) {?>
            <div class="projectitem wow fadeIn">
                    <a href="<?=$this->createUrl('info',['id'=>$value->id])?>">
                        <div class="project_img"><img src="<?=ImageTools::fixImage($value->image,500,320)?>" width="500" height="320" /></div>
                        <div class="project_info">
                            <div>
                                <p class="title"><?=$value->name?></p>
                                <p class="subtitle"><?=$value->eng?></p>
                                <p class="description">￥<?=$value->price?></p>
                            </div>
                        </div>
                    </a>
                </div>
                    <?php } ?>
                
            </div>
        </div>
        <div class="clear"></div>
        <?php $this->widget('WapLinkPager',['pages'=>$pager])?>
    </div>
</div>
<script type="text/javascript">
<?php Tools::startJs()?>
	$('.fa-angle-down').click(function(){
		if($('#category').attr('class') == 'dropmenu pro-dropmenu') {
			$('.lll').css('height','auto');
			$('#category').attr('class','dropmenu pro-dropmenu open');
		}
		else{
			$('.lll').css('height','0');
			$('#category').attr('class','dropmenu pro-dropmenu');
		}
	});
<?php Tools::endJs('js')?>
</script>