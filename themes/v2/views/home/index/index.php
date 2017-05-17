<?php
  $this->pageTitle = '马德里公馆-首页';
?>
    <div id="sitecontent">
        <div id="indexPage">
            <div id="mslider" class="module">
                <script type="text/javascript">
                $(function() {
                    $("#mslider li video").each(function(index, element) {
                        element.play();
                    });
                })
                </script>
                <ul class="slider" data-options-height="" data-options-auto="0" data-options-mode="0" data-options-pause="4" data-options-ease="ease-out">
                <?php if($images) foreach ($images as $key => $value) { ?>
                 <li style="background-image:url(<?=ImageTools::fixImage($value)?>)">
                        <div id="tempImage_0"></div><img style="display:none" src="<?=ImageTools::fixImage($value)?>" class="<?=$key==0?'active':''?>" />
                        <div class="mask"></div>
                        <a target="_blank">
                            <div>
                                <p class="title ellipsis"></p>
                            </div>
                            <div class="sliderArrow fa fa-angle-down"></div>
                        </a>
                    </li>
                <?php }?>
                    
                </ul>
            </div>
            <div id="mproject" class="module">
                <div class="bgmask"></div>
                <div class="content layoutslider">
                    <div class="header wow" style="padding-bottom: 0">
                        <p class="title">酒款</p>
                        <p class="subtitle">WINES</p>
                    </div>
                    <div id="category" class="hide wow">
                      <?php if($cates) foreach ($cates as $key => $value) {?>
                        <a href="<?=$this->createUrl('/home/product/list',['area'=>$key])?>"><?=$value?></a>
                      <?php }?>
                    </div>
                    <!--yyLayout masonry-->
                    <div class="module-content" id="projectlist">
                        <div class="projectSubList" id="projectSubList_">
                            <div class="projectSubHeader">
                                <p class="title"></p>
                                <p class="subtitle"></p>
                            </div>
                            <div class="wrapper">
                                <ul style="height: 400px;margin-top: 0" class="content_list" data-options-sliders="5" data-options-margin="20" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="0.5">
                                <?php if($wines) foreach ($wines as $key => $value) {?>
                                 <li class="projectitem" style="display:inline;height:300px;word-break:break-all;word-wrap : break-word ;margin-right:20px;width: 180px !important;margin-top: 20px">
                            <a href="<?=$this->createUrl('/home/product/info',['id'=>$value->id])?>" target="_blank">
                                <div class="project_img"><img style="height: 240px;width: 180px" src="<?=ImageTools::fixImage($value->image,180,240)?>" width="200" height="180" /></div>
                                <div class="project_info" style="height:60px;width: 180px">
                                    <div style="">
                                        <p class="title" style="padding-top:5px;margin-left: 0;margin-right: 0"><?=$value->name?></p>
                                        <p class="subtitle" style="padding-left:0px;margin-left: 0;margin-right: 0;font-size: 8px;padding-right: 0"><?=Tools::u8_title_substr($value->eng,20)?><span style="float: right;">￥<?=$value->price?></span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                                <?php }?>
                                </ul>
                            </div>
                            <!--wrapper-->
                        </div>
                        <!--projectSubList-->
                        <a href="<?=$this->createUrl('/home/product/info',['id'=>$value->id])?>" class="more wow">MORE<i class="fa fa-angle-right"></i></a>
                    </div>
                    <!--projectlist-->
                    <div class="clear"></div>
                </div>
            </div>
            <div id="mteam" class="module">
                <div class="bgmask"></div>
                <div class="content layoutnone">
                    <div class="header wow">
                        <p class="title">酒庄</p>
                        <p class="subtitle">Chateau</p>
                    </div>
                    <div class="module-content fw">
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="3" data-options-margin="20" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="1">
                            <?php if($houses) foreach ($houses as $key => $value) {?>
                              <li id="teamitem_<?=$key?>" class="wow">
                                    <div class="header wow" data-wow-delay=".2s">
                                        <a href="<?=$this->createUrl('/home/house/info',['id'=>$value->id])?>" target="_blank"><img src="<?=ImageTools::fixImage($value->image,180,180)?>" width="180" height="180" /></a>
                                    </div>
                                    <div class="summary wow">
                                        <p class="title"><a href=""><?=$value->name?></a></p>
                                        <p class="subtitle"><?=$value->eng?></p>
                                        <p class="description wow"><?=Tools::u8_title_substr(strip_tags($value['content']),100)?></p>
                                    </div>
                                    <a href="<?=$this->createUrl('/home/house/info',['id'=>$value->id])?>" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <a href="<?=$this->createUrl('/home/house/info',['id'=>$value->id])?>"></i></a>
                </div>
            </div>
            <!--project-->
            <div id="mservice" class="module bgShow" style="background-image:url(<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcIndexServe'))?>);">
                <div class="bgmask"></div>
                <div class="content layoutslider">
                    <div class="header wow fw" data-wow-delay=".1s">
                        <p class="title">服务</p>
                        <p class="subtitle">SERVICE</p>
                    </div>
                    <div class="module-content fw" id="servicelist">
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="3" data-options-margin="0" data-options-ease="1" data-options-speed="0.5">
                            <?php if($serves) foreach ($serves as $key => $value) {?>
                                <li id="serviceitem_<?=$key?>" class="serviceitem wow">
                                    <a href="<?=$this->createUrl('/home/serve/info',['id'=>$value->id])?>" target="_blank">
                                        <p class="service_img"><img src="<?=ImageTools::fixImage($value->image,320,120)?>" width="320" height="120" /></p>
                                        <div class="service_info">
                                            <p class="title"><?=$value->title?></p>
                                            <p class="description"><?=Tools::u8_title_substr($value->desc,30)?></p>
                                        </div>
                                    </a>
                                    <a href="<?=$this->createUrl('/home/serve/info',['id'=>$value->id])?>" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <a href="<?=$this->createUrl('/home/serve/list')?>" class="more wow">MORE<i class="fa fa-angle-right"></i></a></div>
            </div>
            <div id="mnews" class="module bgShow" style="background-image:url(<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcIndexNews'),1300,900)?>);">
                <div class="bgmask"></div>
                <div class="content layoutnone">
                    <div class="header wow">
                        <p class="title">资讯</p>
                        <p class="subtitle">NEWS</p>
                    </div>
                    <div class="module-content" id="newslist">
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="4" data-options-margin="0" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="0.8" data-options-mode="horizontal" data-options-wheel="0">
                            <?php if($news) foreach ($news as $key => $value) {?>
                              <li id="newsitem_<?=$key?>" class="wow newstitem <?=$key%2==0?'right':'left'?>">
                                    <a class="newscontent" target="_blank" href="<?=$this->createUrl('/home/news/info',['id'=>$value->id])?>">
                                        <div class="news_wrapper">
                                            <div class="newsbody">
                                                <p class="date"><span class="md"><?=date('Y',$value['created'])?><span>-</span></span><span class="year"><?=date('m',$value['created'])?>-<?=date('d',$value['created'])?></span></p>
                                                <p class="title"><?=$value['title']?></p>
                                                <div class="separator"></div>
                                                <p class="description"><?=Tools::u8_title_substr($value['desc'],30)?></p>
                                            </div>
                                        </div>
                                        <div class="newsimg" style="background-image:url(<?=ImageTools::fixImage($value['image'],600,400)?>)"></div>
                                    </a>
                                    <a href="<?=$this->createUrl('/home/news/info',['id'=>$value->id])?>" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                            <?php }?>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/" class="more wow">更多<i class="fa fa-angle-right"></i></a>
                    <div style="height:0">&nbsp;</div>
                </div>
            </div>
            <div id="mpage" class="module">
                <div class="bgmask"></div>
                <div class="content">
                    <div class="module-content">
                        <div class="wrapper">
                            <ul class="slider one">
                                <li>
                                    <div class="header wow" data-wow-delay=".2s">
                                        <p class="title">关于</p>
                                        <p class="subtitle">ABOUT US</p>
                                    </div>
                                    <div class="des-wrap">
                                        <p class="description wow" data-wow-delay=".3s"><?=SiteExt::getAttr('qjpz','pcIndexAboutText')?></p>
                                    </div>
                                    <!-- <a href="http://mo004_376.mo4.line1.jsmo.xin/page/5738/" class="more wow" data-wow-delay=".5s">MORE<i class="fa fa-angle-right"></i></a> -->
                                    <div class="fimg wow" style="background-image:url(<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcIndexAbout'),650,900)?>)"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!-- <div id="mpartner" class="module">
                <div class="bgmask"></div>
                <div class="content layoutslider">
                    <div class="header wow fw" data-wow-delay=".1s">
                        <p class="title">合作伙伴</p>
                        <p class="subtitle">OUR PARTNER</p>
                    </div>
                    <div class="module-content fw">
                        <div class="wrapper">
                            <ul class="content_list" data-options-ease="1" data-options-speed="0.5">
                                <li id="partneritem_0" class="wow">
                                    <a href="https://www.baidu.com/" title="WEB1" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523420267.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB2" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523449578.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB3" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523457913.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB4" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523465497.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB5" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523474415.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB6" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523487207.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB7" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523495245.png" width="160" height="80" /></a>
                                    <a href="https://www.baidu.com/" title="WEB8" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523960866.png" width="160" height="80" /></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
            <div id="mcontact" class="module">
                <div class="bgmask"></div>
                <div class="content">
                    <div class="header wow fadeInUp fw" data-wow-delay=".1s">
                        <p class="title"> 联系我们</p>
                        <p class="subtitle">CONTACT</p>
                    </div>
                    <div id="contactlist" class="fw">
                        <div id="contactinfo" class="fl wow" data-wow-delay=".2s">
                            <h3 class="ellipsis name">常州马德里公馆</h3>
                            <p class="ellipsis add"><span>地点：</span>常州市钟楼区龙江中路169号</p>
                            <p class="ellipsis zip"><span>邮编：</span>213000</p>
                            <!-- <p class="ellipsis tel"><span>电话：</span>400-888-8888</p> -->
                            <p class="ellipsis mobile"><span>手机：</span><?=SiteExt::getAttr('qjpz','sitePhone')?></p>
                            <p class="ellipsis mobile"><span>微信：</span>madrid_cz</p>
                            <p class="ellipsis fax"><span>QQ ：</span><?=SiteExt::getAttr('qjpz','qq')?></p>
                            <p class="ellipsis email"><span>邮箱：</span><?=SiteExt::getAttr('qjpz','mail')?></p>
                            <!-- <div><a class="fl" target="_blank" href="http://weibo.com/web"><i class="fa fa-weibo"></i></a><a class="fl" target="_blank" href="tencent://message/?uin=40080000&Site=uemo&Menu=yes"><i class="fa fa-qq"></i></a> <a id="mpbtn" class="fl" href="http://resources.jsmo.xin/templates/upload/1/201508/1438424052624.jpg"><i class="fa fa-weixin"></i></a></div> -->
                        </div>
                        <div id="contactform" class="fr wow" data-wow-delay=".2s">
                            <form action="" method="post" onsubmit="onsit()">
                                <p>
                                    <input type="text" class="inputtxt name" name="name" placeholder="姓名" autocomplete="off" />
                                </p>
                                <p>
                                    <input type="text" class="inputtxt email" name="email" placeholder="邮箱" autocomplete="off" />
                                </p>
                                <p>
                                    <input type="text" class="inputtxt tel" name="tel" placeholder="电话" autocomplete="off" />
                                </p>
                                <p>
                                    <textarea class="inputtxt cont" name="content" placeholder="内容" autocomplete="off"></textarea>
                                </p>
                                <p>
                                    <input class="inputsub" type="submit" value="提交" />
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function onsit() {
            alert('提交成功');
            return true;
        }
    </script>