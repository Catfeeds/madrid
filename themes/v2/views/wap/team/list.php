<?php 
	$this->pageTitle = '团队列表';
?>
<div class="npagePage">
                <div class="content">
                    <div id="category">
                        <div class="label plr20">
                            <div class="text">团队</div>
                        </div>
                    </div>
                    <ul id="teamlist" class="plr10">
                    <?php if($infos) foreach ($infos as $key => $value) {?>
                    <li class="teamitem wow fadeIn">
                            <a href="<?=$this->createUrl('info',['id'=>$value->id])?>">
                                <div id="team_img"><img src="<?=ImageTools::fixImage($value->image,90,90)?>" width="90" height="90" /></div>
                                <div class="teaminfo">
                                    <div class="header">
                                        <p class="title"><?=$value->title?></p>
                                        <p class="subtitle"><?=$value->sub_title?></p>
                                    </div>
                                    <p class="description"><?=Tools::u8_title_substr($value->desc,50)?></p>
                                </div>
                            </a>
                        </li>
                    <?php }?>
                    </ul>
                    <div id="pages"></div>
                </div>
            </div>