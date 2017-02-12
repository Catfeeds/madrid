<?php $plotAlbum = PlotImgExt::model()->with('tag')->findAll(['condition'=>'hid=:hid and tag.name=:name','params'=>[':hid'=>$this->zf->plot->id,':name'=>'配套图'],'order'=>'t.sort desc,t.created desc','limit'=>5]);if($plotAlbum):?>
<div class="common-title"><span><?=$this->zf->plot->title?>相册</span><a class="more" href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$this->zf->plot->pinyin,'t'=>$plotAlbum[0]->type])?>">查看更多图片&nbsp;&nbsp;&gt;</a></div>
<div class="fang-list long-list">
    <ul>
        <?php foreach($plotAlbum as $key=>$value):?>
        <li>
            <a href="<?=$this->createUrl('/resoldhome/plot/image',['py'=>$this->zf->plot->pinyin,'pid'=>$value->id])?>" target="_blank">
                <div class="pic">
                    <img src="<?=ImageTools::fixImage($value->url,200,150)?>" alt="">
                </div>

            </a>
        </li>
        <?php endforeach;?>
    </ul>
    <div class="more-info">更多信息：<a href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$this->zf->plot->pinyin])?>" target="_blank"><?=$this->zf->plot->title?></a><a href="<?=$this->createUrl('/home/plot/price',['py'=>$this->zf->plot->pinyin])?>" target="_blank"><?=$this->zf->plot->title?>房价走势</a><a href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$this->zf->plot->pinyin])?>" target="_blank"><?=$this->zf->plot->title?>相册</a><a href="http://www.hualongxiang.com/yezhu" target="_blank"><?=$this->zf->plot->title?>业主论坛</a></div>
</div>
<?php endif;?>
<div class="blank10"></div>
<div class="common-title"><span>您可能感兴趣的房源</span></div>
<div class="fang-list long-list">
    <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/zf/info','cssType'=>4,'type'=>2,'category'=>$this->zf->category,'limit'=>5,'infoId'=>$this->zf->id])?>
</div>
