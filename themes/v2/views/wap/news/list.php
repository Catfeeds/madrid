<?php
  $this->pageTitle = '资讯列表';
?>
<div class="npagePage">
    <div class="content">
    <?php $cates = CHtml::listData(TagExt::model()->getTagByCate('wzlm')->normal()->sorted()->findAll(),'id','name')?>
        <div id="category" class="dropmenu pro-dropmenu">
            <div class="label plr20 cate1"><i class="down fa fa-angle-down transform"></i>
                <div class="text"><?=$cate?$cates[$cate]:'全部栏目'?></div>
            </div>
            <ul class="transform lll" data-height="246">
            <?php $cateArr = $_GET;unset($cateArr['cate'])?>
                <li><a href="<?=$this->createUrl('list',$cateArr)?>" class="<?=!$cate?'active':''?>">全部栏目</a></li>
                <?php if($cates) foreach ($cates as $key => $value) { if($key!='19' && $key!=20): ?>
                <li><a href="<?=$this->createUrl('list',$cateArr+['cate'=>$key])?>" class="<?=$key==$cate?'active':''?>"><?=$value?></a></li>
            <?php endif;} ?>
            </ul>
        </div>
        <div id="newslist">
            <?php if($infos) foreach ($infos as $key => $value) {?>
            <div class="newstitem plr10 wow fadeIn">
                <a class="newsinfo" href="<?=$this->createUrl('info',['id'=>$value->id])?>"><img src="<?=ImageTools::fixImage($value->image,150,100)?>" width="auto" height="auto" style="margin-right:10px;margin-bottom: 10px" />
                    <div class="newsdate">
                        <p class="md"><?=date('m',$value['created'])?>-<?=date('d',$value['created'])?></p>
                        <!-- <p class="year"><?=date('Y',$value['created'])?></p> -->
                        <p class="year"><?=$value->author?></p>
                    </div>
                    <div class="newsbody">
                        <p class="title ellipsis"><?=$value['title']?></p>
                        <p class="description"><?=Tools::u8_title_substr($value['desc'],46)?></p>
                    </div>
                </a>
            </div>
                    <?php } ?>
        </div>
        <div class="clear"></div>
        <?php $this->widget('WapLinkPager',['pages'=>$pager])?>
    </div>
</div>
<script type="text/javascript">
<?php Tools::startJs()?>
    $('.cate1').click(function(){
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