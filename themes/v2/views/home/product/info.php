<?php 
	$this->pageTitle = '马德里公馆-红酒详情';
    $this->keyword = '西班牙进口红酒，里奥哈酒庄'.'-'.$info->name.'-'.$info->eng.'。';
    $this->description = '马德里公馆-'.$info->name.'更多红酒资讯请持续关注马德里公馆。';
?>
<div id="sitecontent">
	<div class="npagePage " id="npagePage" style="width: 90%">
	    <div class="content">
	        <div id="projectwrap" class="fw">
	            <div id="projectbody">
	                <ul id="projectimages">
	                    <li><img src="<?=ImageTools::fixImage($info->image,1200,800)?>" /></li>
	                </ul>
	                <div class="clear"></div>
	                <div class="postbody">
	                    <p><?=$info->content?></p>
	                </div>
	            </div>
	            <div id="projectinfo">
	                <div id="projectih">
	                    <div class="header">
	                        <p class="title"><?=$info->name?></p>
	                        <p class="subtitle"><?=$info->eng?></p>
	                        <p class="subtitle">￥<?=$info->price?></p>
	                        <div class="description">
	                        <?php $tags = $info->getTagName();?>
	                            <p>类型: <?=$tags['cid']?></p>
	                            <p>葡萄品种: <?=$tags['ptpz']?></p>
	                            <p>系列: <?=$tags['xl']?></p>
	                            <p>酒庄: <?=$info->houseInfo?$info->houseInfo->name:'-'?></p>
	                            <p>等级: <?=$info->houseInfo?TagExt::getNameByTag($info->houseInfo->level):'-'?></p>
	                            <p>
	                                <br />
	                            </p>
	                            <p><a href="tencent://message/?uin=<?=SiteExt::getAttr('qjpz','qq')?>&Site=uelike&Menu=yes">在线预定</a></p>
	                            <?php if($info->images):?>
	                            <p>
	                                <br />
	                            </p>
	                            <p><a href="<?=$this->createUrl('album',['id'=>$info->id])?>">查看相册</a></p>
	                        <?php endif;?>
	                            <p>
	                                <br />
	                            </p>
	                        </div>
	                    </div>
	                </div>
	                <div class="clear"></div>
	            </div>
	            <div id="projectshow">
	                <div id="projecttags">
	                <!-- 此处是红酒类型 -->
	                </div>
	                <div id="projectib">
	                <!-- 同一个系列 -->
	                <?php foreach (ProductExt::model()->normal()->sorted()->findAll(['limit'=>6]) as $key => $value) {?>
	                	<div class="projectitem" style="width: auto">
	                        <a href="<?=$this->createUrl('info',['id'=>$value->id])?>" target="_blank">
	                            <span class="propost_img"><img src="<?=ImageTools::fixImage($value->image,600,400)?>"/></span>
	                            <div class="project_info">
	                                <div>
	                                    <p class="title"><?=$value->name?></p>
	                                    <p class="subtitle">￥<?=$value->price?></p>
	                                </div>
	                            </div>
	                        </a>
	                    </div>
	                <?php }?>
	                </div>
	            </div>
	            <div class="clear"></div>
	        </div>
	        <div id="pages"></div>
	        <div id="pageswitch">
	            <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6946/" class="prev">
	                <!--img src="预留"/-->
	                <div>
	                    <h3 class="title">鲜柠香煎银鳕鱼</h3>
	                    <p class="subtitle">bacon-ranchero</p>
	                </div>
	            </a>
	            <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6944/" class="next">
	                <!--img src="预留"/-->
	                <div>
	                    <h3 class="title">友禅什锦啫喱配美味汁</h3>
	                    <p class="subtitle">甜品</p>
	                </div>
	            </a>
	            <div class="clear"></div>
	        </div>
	    </div>
	</div>
</div>