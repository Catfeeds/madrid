<?php 
	$this->pageTitle = '马德里公馆-资讯详情';
    $this->keyword = '西班牙进口红酒，红酒资讯，红酒文化，红酒知识';
?>
<div id="sitecontent">
        <div class="npagePage newsl">
            <div class="content">
                <div class="header fw">
                    <p class="title"><?=$info->title?></p>
                    <p class="subtitle"><?=$info->author.' '.date('Y-m-d',$info->created)?></p>
                </div>
                <div class="fw postbody">
                	<?=$info->content?>
                </div>
                <div id="pages"></div>
                <div id="pageswitch">
                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2032/" class="next">
                        <!--img src="预留"/-->
                        <div>
                            <h3 class="title">西餐礼仪细节，让你成为完美淑女 ...</h3>
                        </div>
                    </a>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>