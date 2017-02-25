<?php 
    $this->pageTitle = '团队详情';
?>
<div class="npagePage">
                <div class="content">
                    <div id="newpost">
                    <div class="plr5"><img src="<?=ImageTools::fixImage($info->image,320,200)?>" width="320" class="imgcw" /></div>
                        <div class="plr10">
                            <div class="header">
                                <p class="title"><?=$info->title?></p>
                                <p class="subtitle"><?=$info->sub_title?></p>
                            </div>
                            <div class="postbody">
                                <?=$info->content?>
                            </div>
                        </div>
                        </div>
                    <div id="pages"></div>
                </div>
            </div>