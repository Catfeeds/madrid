<?php 
	$this->pageTitle = '团队详情';
?>
 <div id="sitecontent">
        <div class="npagePage">
            <div class="content">
                <div id="teampost" class="fw">
                    <div id="teamimage"><img src="<?=ImageTools::fixImage($info->image,400,320)?>" width="408" /></div>
                    <div id="teambody">
                        <div class="theader">
                            <p class="title"><?=$info->title?></p>
                            <p class="subtitle"><?=$info->sub_title?></p>
                            <div class="postbody">
                            <?=$info->content?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>