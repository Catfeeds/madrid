<?php
  $this->pageTitle = '首页';
?>
<div id="indexPage">
    <div id="mslider">
        <ul class="slider" id="t-slider">
            <?php if($images) foreach ($images as $key => $value) { ?>
            <li>
                <a>
                    <div class="slider_img"><img src="<?=ImageTools::fixImage($value)?>" class="imgcw" /></div>
                    <div class="slider_info">
                        <p class="title ellipsis"></p>
                    </div>
                </a>
            </li>
            <?php }?>
        </ul>
        <div class="clear"></div>
    </div>
    <div id="mproject" class="module">
        <div class="content">
            <div class="header">
                <p class="title">酒款</p>
                <p class="subtitle">WINES</p>
            </div>
            <div id="projectlist">
                <!--yyLayout masonry-->
                <div class="module-content" id="projectlist">
                    <div class="projectSubList" id="projectSubList_">
                        <div class="projectSubHeader">
                            <p class="title"></p>
                            <p class="subtitle"></p>
                        </div>
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="4" data-options-margin="20" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="0.5">
                            <?php if($wines) foreach ($wines as $key => $value) {?>
                                 <li id="projectitem_<?=$key?>" class="projectitem wow">
                                        <a href="<?=$this->createUrl('/home/product/info',['id'=>$value->id])?>" class="projectitem_content" target="">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="<?=ImageTools::fixImage($value->image,400,600)?>" width="400" height="600" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title"><?=$value->name?></p>
                                                        <p class="subtitle"><?=Tools::u8_title_substr($value->eng,16)?><span style="float: right;margin-right: 2px">￥<?=$value->price?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php }?>
                                <div class="clear"></div>
                            </ul>
                        </div>
                        <!--wrapper-->
                    </div>
                    <!--projectSubList-->
                </div>
                <!--projectlist-->
                <div class="clear"></div>
            </div>
            <a id="projectmore" href="<?=$this->createUrl('/home/product/list')?>">MORE</a></div>
    </div>
    <div id="mteam" class="module">
        <div class="content plr10">
            <div class="header">
                <p class="title">酒庄</p>
                <p class="subtitle">Chateau</p>
            </div>
            <ul id="teamlist">
                <?php if($houses) foreach ($houses as $key => $value) {?>
                <li class="teamitem wow fadeIn">
                    <a href="<?=$this->createUrl('/home/house/info',['id'=>$value->id])?>">
                        <div id="mteam_img"><img src="<?=ImageTools::fixImage($value->image,90,90)?>" width="90" height="90" /></div>
                        <div class="teaminfo">
                            <div class="header">
                                <p class="title"><?=$value->name?></p>
                                <p class="subtitle"><?=$value->eng?></p>
                            </div>
                            <p class="description"><?=Tools::u8_title_substr(strip_tags($value['content']),100)?></p>
                        </div>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <div style="height:0">&nbsp;</div>
        </div>
    </div>
    <!-- <div id="mservice" class="module">
        <div class="content">
            <div class="header">
                <p class="title">服务</p>
                <p class="subtitle">SERVICE</p>
            </div>
            <div class="slider_wrapper">
            <div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 168px;">

                <ul class="slider"  data-orig-style="[object CSSStyleDeclaration]" style="width: 715%; position: relative; transition-duration: 0.5s; transform: translate3d(-338px, 0px, 0px);">
                <?php if($serves) foreach ($serves as $key => $value) {?>
                    <li class="serviceitem wow fadeIn" data-orig-style="[object CSSStyleDeclaration]" style="float: left; list-style: none; position: relative; width: 338px; visibility: visible; animation-name: fadeIn;">
                        <a href="<?=$this->createUrl('/home/serve/info',['id'=>$value->id])?>"><img src="<?=ImageTools::fixImage($value->image,160,60)?>" width="160" height="60" /></a>
                        <div>
                            <p class="title"><?=$value->title?></p>
                            <p class="description"><?=Tools::u8_title_substr($value->desc,30)?></p>
                        </div>
                    </li>
                <?php } ?>
                </ul>
            </div>
            <div class="bx-controls bx-has-controls-direction"><div class="bx-controls-direction"><a class="bx-prev" href=""><i class="fa fa-angle-left"></i></a><a class="bx-next" href=""><i class="fa fa-angle-right"></i></a></div></div>
                <a href="<?=$this->createUrl('/home/serve/list')?>" class="more">MORE</a>
            <div style="height:0">&nbsp;</div>
            </div>
        </div>
    </div> -->
    <div id="mpage" class="module ">
        <div class="content">
            <div class="plr10">
                <div class="header">
                    <p class="title">关于</p>
                    <p class="subtitle">ABOUT US</p>
                </div>
                <p class="description"><?=Tools::u8_title_substr(SiteExt::getAttr('qjpz','pcIndexAboutText'),600)?></p>
                <br>
            </div>
            <!-- <a href="http://mo004_376.mo4.line1.jsmo.xin/page/5738/" class="more">MORE</a> -->
            <div class="fimg wow fadeIn">
                <img src="<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcIndexAbout'))?>" />
            </div>
        </div>
    </div>
    <div id="mnews" class="module">
        <div class="content">
            <div class="header">
                <p class="title">资讯</p>
                <p class="subtitle">NEWS</p>
            </div>
            <div id="newslist">
            <?php if($news) foreach ($news as $key => $value) {?>
            <div class="newstitem plr10 wow fadeIn" data-wow-delay="0.0s">
                    <a class="newsinfo" href="<?=$this->createUrl('/home/news/info',['id'=>$value->id])?>">
                        <div class="newsimage"><img src="<?=ImageTools::fixImage($value['image'])?>" width="auto" height="auto" /></div>
                        <div class="newsdate">
                            <p class="md"><?=date('m',$value['created'])?>-<?=date('d',$value['created'])?></p>
                            <p class="year"><?=date('Y',$value['created'])?></p>
                        </div>
                        <div class="newsbody">
                            <p class="title ellipsis"><?=$value['title']?></p>
                            <p class="description"><?=Tools::u8_title_substr($value['desc'],30)?></p>
                        </div>
                    </a>
                </div>
                <?php }?>
            </div>
            <div class="clear"></div>
            <a href="<?=$this->createUrl('/home/news/list')?>" class="more">MORE</a>
            <div style="height:0">&nbsp;</div>
        </div>
    </div>
    <!-- <div id="mpartner" class="module">
        <div class="content">
            <div class="wrapper">
                <ul style="width:640px">
                    <li>
                        <a href="https://www.baidu.com/" title="WEB1" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523420267.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB2" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523449578.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB3" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523457913.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB4" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523465497.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB5" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523474415.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB6" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523487207.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB7" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523495245.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB8" target=""><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523960866.png" width="160" height="80" /></a>
                    </li>
                </ul>
            </div>
        </div>
    </div> -->
    <div id="mcontact" class="module">
        <div class="content plr10 wow fadeIn">
            <div class="header">
                <p class="title"> 联系我们</p>
                <p class="subtitle">CONTACT</p>
            </div>
            <div id="contactlist">
                <div id="contactinfo">
                    <h3 class="ellipsis name">常州马德里公馆</h3>
                    <p class="ellipsis add"><span>地点：</span>常州市钟楼区龙江中路169号</p>
                    <p class="ellipsis zip"><span>邮编：</span>213000</p>
                    <p class="ellipsis tel"><span>手机：</span><a href='tel:<?=SiteExt::getAttr('qjpz','sitePhone')?>'><?=SiteExt::getAttr('qjpz','sitePhone')?></a></p>
                    <p class="ellipsis mobile"><span>微信：</span>madrid_cz</p>
                    <p class="ellipsis fax"><span>QQ：</span><?=SiteExt::getAttr('qjpz','qq')?></p>
                    <p class="ellipsis email"><span>邮箱：</span><?=SiteExt::getAttr('qjpz','mail')?></p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
