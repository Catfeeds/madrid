<?php 
    $this->pageTitle = '服务详情';
?>
<div class="npagePage">
                <div class="content plr10">
                    <div id="newpost">
                        <div class="header">
                            <p class="title"><?=$info->title?></p>
                            <p class="subtitle"><?=$info->author.' '.date('Y-m-d',$info->updated)?></p>
                        </div>
                        <div class="postbody">
                        <?=$info->content?>
                        </div>
                    </div>
                    <div id="pages"></div>
                </div>
            </div>