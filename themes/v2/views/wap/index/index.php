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
                                        <a href="<?=$this->createUrl('/home/product/info',['id'=>$value->id])?>" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="<?=ImageTools::fixImage($value->image,600,400)?>" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title"><?=$value->name?></p>
                                                        <p class="subtitle"><?=$value->eng?></p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
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
    <div id="mservice" class="module">
        <div class="content">
            <div class="header">
                <p class="title">服务</p>
                <p class="subtitle">SERVICE</p>
            </div>
            <div class="slider_wrapper">
                <ul class="slider">
                <?php if($serves) foreach ($serves as $key => $value) {?>
                    <li class="serviceitem wow fadeIn">
                        <a href="<?=$this->createUrl('/home/serve/info',['id'=>$value->id])?>"><img src="<?=ImageTools::fixImage($value->image,160,60)?>" width="160" height="60" /></a>
                        <div>
                            <p class="title"><?=$value->title?></p>
                            <p class="description"><?=Tools::u8_title_substr($value->desc,30)?></p>
                        </div>
                    </li>
                <?php } ?>
                </ul>
            </div><a href="<?=$this->createUrl('/home/serve/list')?>" class="more">MORE</a>
            <div style="height:0">&nbsp;</div>
        </div>
    </div>
    <div id="mpage" class="module ">
        <div class="content">
            <div class="plr10">
                <div class="header">
                    <p class="title">关于</p>
                    <p class="subtitle">ABOUT US</p>
                </div>
                <p class="description">Enterprise Edition is the latest research and development of the in the small and medium enterprise website template system, the team has many years of rich experience, to understand the latest web site experience and interaction principle, as far as possible for the user to consider and function, operation</p>
            </div>
            <a href="http://mo004_376.mo4.line1.jsmo.xin/page/5738/" class="more">MORE</a>
            <div class="fimg wow fadeIn">
                <img src="http://resources.jsmo.xin/templates/upload/376/201607/1468573808434.jpg" />
            </div>
        </div>
    </div>
    <div id="mnews" class="module">
        <div class="content">
            <div class="header">
                <p class="title">新闻</p>
                <p class="subtitle">NEWS</p>
            </div>
            <div id="newslist">
                <div class="newstitem plr10 wow fadeIn" data-wow-delay="0.0s">
                    <a class="newsinfo" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2033/">
                        <div class="newsimage"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468837341861.jpg" width="auto" height="auto" /></div>
                        <div class="newsdate">
                            <p class="md">12-08</p>
                            <p class="year">2015</p>
                        </div>
                        <div class="newsbody">
                            <p class="title ellipsis">食物有超乎想象的治愈力量，它能填饱肚子</p>
                            <p class="description">除了面包和泡面之外，一个人的餐桌，也可以有更多选择一个人的生活除了面包和泡面之外，一个人的餐桌 ... </p>
                        </div>
                    </a>
                </div>
                <div class="newstitem plr10 wow fadeIn" data-wow-delay="0.1s">
                    <a class="newsinfo" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2032/">
                        <div class="newsimage"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468904224332.jpg" width="auto" height="auto" /></div>
                        <div class="newsdate">
                            <p class="md">12-07</p>
                            <p class="year">2015</p>
                        </div>
                        <div class="newsbody">
                            <p class="title ellipsis">西餐礼仪细节，让你成为完美淑女 ...</p>
                            <p class="description">除了面包和泡面之外，一个人的餐桌，也可以有更多选择一个人的生活 ...</p>
                        </div>
                    </a>
                </div>
                <div class="newstitem plr10 wow fadeIn" data-wow-delay="0.2s">
                    <a class="newsinfo" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2030/">
                        <div class="newsimage"><img src="http://resources.jsmo.xin/templates/upload/376/201607/146890427581.jpg" width="auto" height="auto" /></div>
                        <div class="newsdate">
                            <p class="md">10-23</p>
                            <p class="year">2015</p>
                        </div>
                        <div class="newsbody">
                            <p class="title ellipsis">菊苣烤龙虾配照烧鹅肝和时令蔬菜 ...</p>
                            <p class="description">合理的饮食，是身体健康的第一要素抵挡冬日的严寒一个人的餐桌，也可以有更 ...</p>
                        </div>
                    </a>
                </div>
                <div class="newstitem plr10 wow fadeIn" data-wow-delay="0.3s">
                    <a class="newsinfo" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2031/">
                        <div class="newsimage"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468904322694.jpg" width="auto" height="auto" /></div>
                        <div class="newsdate">
                            <p class="md">09-28</p>
                            <p class="year">2015</p>
                        </div>
                        <div class="newsbody">
                            <p class="title ellipsis">理想的下午，在家喝出女王范儿</p>
                            <p class="description">合理的饮食，是身体健康的第一要素抵挡冬日的严寒一个人的餐桌，也可以有更其实除了各种游乐设施，既体现迪士尼童话主题，又入乡随俗 ...</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="clear"></div>
            <a href="http://mo004_376.mo4.line1.jsmo.xin/news/" class="more">MORE</a>
            <div style="height:0">&nbsp;</div>
        </div>
    </div>
    <div id="mpartner" class="module">
        <div class="content">
            <div class="wrapper">
                <ul style="width:640px">
                    <li>
                        <a href="https://www.baidu.com/" title="WEB1" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523420267.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB2" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523449578.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB3" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523457913.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB4" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523465497.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB5" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523474415.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB6" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523487207.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB7" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523495245.png" width="160" height="80" /></a>
                    </li>
                    <li>
                        <a href="https://www.baidu.com/" title="WEB8" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468523960866.png" width="160" height="80" /></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="mcontact" class="module">
        <div class="content plr10 wow fadeIn">
            <div class="header">
                <p class="title"> 联系我们</p>
                <p class="subtitle">CONTACT</p>
            </div>
            <div id="contactlist">
                <div id="contactinfo">
                    <h3 class="ellipsis name">网站建设文化传播有限公司</h3>
                    <p class="ellipsis add"><span>地点：</span>中国地区XX分区5A写字楼8-88室</p>
                    <p class="ellipsis zip"><span>邮编：</span>100000</p>
                    <p class="ellipsis tel"><span>电话：</span><a href='tel:400-888-8888'>400-888-8888</a></p>
                    <p class="ellipsis mobile"><span>手机：</span><a href='tel:188-666-5188'>188-666-5188</a></p>
                    <p class="ellipsis fax"><span>传真：</span>000-66668888</p>
                    <p class="ellipsis email"><span>邮箱：</span>website@qq.com</p>
                    <div><a class="fl" href="http://weibo.com/web"><i class="fa fa-weibo"></i></a> <a id="mpbtn" class="fl" href="http://resources.jsmo.xin/templates/upload/1/201508/1438424052624.jpg"><i class="fa fa-weixin"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
