<?php
  $this->pageTitle = '首页';
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
                <?php foreach ($images as $key => $value) { ?>
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
                    <div class="header wow">
                        <p class="title">菜品</p>
                        <p class="subtitle">PRODUCTS</p>
                    </div>
                    <div id="category" class="hide wow">
                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/cid/2008/">头盘</a>
                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/cid/2007/">汤</a>
                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/cid/2009/">副菜</a>
                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/cid/2006/">主菜</a>
                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/cid/2010/">蔬菜类菜肴</a>
                    </div>
                    <!--yyLayout masonry-->
                    <div class="module-content" id="projectlist">
                        <div class="projectSubList" id="projectSubList_">
                            <div class="projectSubHeader">
                                <p class="title"></p>
                                <p class="subtitle"></p>
                            </div>
                            <div class="wrapper">
                                <ul class="content_list" data-options-sliders="4" data-options-margin="20" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="0.5">
                                    <li id="projectitem_0" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6942/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468834055524.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">南非龙虾配澳洲带子（虾黄汁）</p>
                                                        <p class="subtitle">头盘开胃菜</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_1" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6940/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468572543951.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">新西兰羊排配黑椒蘑菇汁</p>
                                                        <p class="subtitle">意式蔬菜汤</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_2" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6941/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468833933745.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">黑椒牛仔骨配黄油西兰花</p>
                                                        <p class="subtitle">头盘开胃菜</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_3" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6939/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468572955507.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">奶油蘑菇汤配蒜香法包</p>
                                                        <p class="subtitle">法式局葱头汤</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_4" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6937/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/146857335777.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">迷你胡萝卜&amp;黄油心里</p>
                                                        <p class="subtitle">副菜</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_5" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6935/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468573446668.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">海鲜烩牛仔骨</p>
                                                        <p class="subtitle">副菜菜肴</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_6" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6936/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468897378465.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">花椰菜生蔬菜沙拉</p>
                                                        <p class="subtitle">蔬菜沙拉</p>
                                                        <p class="description hide"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li id="projectitem_7" class="projectitem wow">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/post/6938/" class="projectitem_content" target="_blank">
                                            <div class="projectitem_wrapper">
                                                <div class="project_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468897434580.jpg" width="650" height="385" /></div>
                                                <div class="project_info">
                                                    <div>
                                                        <p class="title">四季水果摩卡慕斯</p>
                                                        <p class="subtitle">甜品</p>
                                                        <p class="description hide">Semestral project - publicLocation: Nałęczów, PolandStatus: ideadate: 2013在线预约</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!--wrapper-->
                        </div>
                        <!--projectSubList-->
                        <a href="http://mo004_376.mo4.line1.jsmo.xin/project/" class="more wow">MORE<i class="fa fa-angle-right"></i></a>
                    </div>
                    <!--projectlist-->
                    <div class="clear"></div>
                </div>
            </div>
            <!--project-->
            <div id="mservice" class="module bgShow" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/1468488692500.png);">
                <div class="bgmask"></div>
                <div class="content layoutslider">
                    <div class="header wow fw" data-wow-delay=".1s">
                        <p class="title">服务</p>
                        <p class="subtitle">SERVICE</p>
                    </div>
                    <div class="module-content fw" id="servicelist">
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="3" data-options-margin="0" data-options-ease="1" data-options-speed="0.5">
                                <li id="serviceitem_0" class="serviceitem wow">
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1423/" target="_blank">
                                        <p class="service_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468579304436.png" width="320" height="120" /></p>
                                        <div class="service_info">
                                            <p class="title">西餐服务知识</p>
                                            <p class="description">在西餐中最具有代表性的食物，那就非牛排莫属了，精致菜式大放送!全部都出自世界 ...</p>
                                        </div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1423/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="serviceitem_1" class="serviceitem wow">
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1422/" target="_blank">
                                        <p class="service_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468579312756.png" width="320" height="120" /></p>
                                        <div class="service_info">
                                            <p class="title">西餐礼仪细节</p>
                                            <p class="description">吃沙拉时，通常会遇上较大片的菜叶，这时不要用刀子切开菜叶而应以刀叉将其折起来，再以 ...</p>
                                        </div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1422/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="serviceitem_2" class="serviceitem wow">
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1420/" target="_blank">
                                        <p class="service_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468579319816.png" width="320" height="120" /></p>
                                        <div class="service_info">
                                            <p class="title">米其林精美菜式须知</p>
                                            <p class="description">在法国，厨师属于艺术家的范畴，法国还有一家全球闻名、历史悠久的为这些艺术家及他们的 ...</p>
                                        </div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1420/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="serviceitem_3" class="serviceitem wow">
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1456/" target="_blank">
                                        <p class="service_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468923364933.png" width="320" height="120" /></p>
                                        <div class="service_info">
                                            <p class="title">SPECIAL EVENTS</p>
                                            <p class="description">For special events &amp; private functions in New York City please complete the below inquiry form ...</p>
                                        </div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1456/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="serviceitem_4" class="serviceitem wow">
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1451/" target="_blank">
                                        <p class="service_img"><img src="http://resources.jsmo.xin/templates/upload/376/201607/1468921073499.png" width="320" height="120" /></p>
                                        <div class="service_info">
                                            <p class="title">NEW YORK CITY RESTAURANT</p>
                                            <p class="description">Restaurant Week will be taking place in New York City from July 25 through August 19th...</p>
                                        </div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/post/1451/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <a href="http://mo004_376.mo4.line1.jsmo.xin/service/" class="more wow">MORE<i class="fa fa-angle-right"></i></a></div>
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
                                        <p class="description wow" data-wow-delay=".3s">Enterprise Edition is the latest research and development of the in the small and medium enterprise website template system, the team has many years of rich experience, to understand the latest web site experience and interaction principle, as far as possible for the user to consider and function, operation</p>
                                    </div>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/page/5738/" class="more wow" data-wow-delay=".5s">MORE<i class="fa fa-angle-right"></i></a>
                                    <div class="fimg wow" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/1468573808434.jpg)"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mnews" class="module bgShow" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/1468826587571.jpg);">
                <div class="bgmask"></div>
                <div class="content layoutnone">
                    <div class="header wow">
                        <p class="title">新闻</p>
                        <p class="subtitle">NEWS</p>
                    </div>
                    <div class="module-content" id="newslist">
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="4" data-options-margin="0" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="0.8" data-options-mode="horizontal" data-options-wheel="0">
                                <li id="newsitem_0" class="wow newstitem left">
                                    <a class="newscontent" target="_blank" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2033/">
                                        <div class="news_wrapper">
                                            <div class="newsbody">
                                                <p class="date"><span class="md">2015<span>-</span></span><span class="year">12-08</span></p>
                                                <p class="title">食物有超乎想象的治愈力量，它能填饱肚子</p>
                                                <div class="separator"></div>
                                                <p class="description">除了面包和泡面之外，一个人的餐桌，也可以有更多选择一个人的生活除了面包和泡面之外，一个人的餐桌 ... </p>
                                            </div>
                                        </div>
                                        <div class="newsimg" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/1468837341861.jpg)"></div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2033/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="newsitem_1" class="wow newstitem right">
                                    <a class="newscontent" target="_blank" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2032/">
                                        <div class="news_wrapper">
                                            <div class="newsbody">
                                                <p class="date"><span class="md">2015<span>-</span></span><span class="year">12-07</span></p>
                                                <p class="title">西餐礼仪细节，让你成为完美淑女 ...</p>
                                                <div class="separator"></div>
                                                <p class="description">除了面包和泡面之外，一个人的餐桌，也可以有更多选择一个人的生活 ...</p>
                                            </div>
                                        </div>
                                        <div class="newsimg" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/1468904224332.jpg)"></div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2032/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="newsitem_2" class="wow newstitem left">
                                    <a class="newscontent" target="_blank" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2030/">
                                        <div class="news_wrapper">
                                            <div class="newsbody">
                                                <p class="date"><span class="md">2015<span>-</span></span><span class="year">10-23</span></p>
                                                <p class="title">菊苣烤龙虾配照烧鹅肝和时令蔬菜 ...</p>
                                                <div class="separator"></div>
                                                <p class="description">合理的饮食，是身体健康的第一要素抵挡冬日的严寒一个人的餐桌，也可以有更 ...</p>
                                            </div>
                                        </div>
                                        <div class="newsimg" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/146890427581.jpg)"></div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2030/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="newsitem_3" class="wow newstitem right">
                                    <a class="newscontent" target="_blank" href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2031/">
                                        <div class="news_wrapper">
                                            <div class="newsbody">
                                                <p class="date"><span class="md">2015<span>-</span></span><span class="year">09-28</span></p>
                                                <p class="title">理想的下午，在家喝出女王范儿</p>
                                                <div class="separator"></div>
                                                <p class="description">合理的饮食，是身体健康的第一要素抵挡冬日的严寒一个人的餐桌，也可以有更其实除了各种游乐设施，既体现迪士尼童话主题，又入乡随俗 ...</p>
                                            </div>
                                        </div>
                                        <div class="newsimg" style="background-image:url(http://resources.jsmo.xin/templates/upload/376/201607/1468904322694.jpg)"></div>
                                    </a>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/post/2031/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <a href="http://mo004_376.mo4.line1.jsmo.xin/news/" class="more wow">更多<i class="fa fa-angle-right"></i></a>
                    <div style="height:0">&nbsp;</div>
                </div>
            </div>
            <div id="mteam" class="module">
                <div class="bgmask"></div>
                <div class="content layoutnone">
                    <div class="header wow">
                        <p class="title">团队</p>
                        <p class="subtitle">Team</p>
                    </div>
                    <div class="module-content fw">
                        <div class="wrapper">
                            <ul class="content_list" data-options-sliders="3" data-options-margin="20" data-options-ease="cubic-bezier(.73,-0.03,.24,1.01)" data-options-speed="1">
                                <li id="teamitem_0" class="wow">
                                    <div class="header wow" data-wow-delay=".2s">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2117/" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/269/201606/1466157259682.jpg" width="180" height="180" /></a>
                                    </div>
                                    <div class="summary wow">
                                        <p class="title"><a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2117/">王嘉尔 / Joseph</a></p>
                                        <p class="subtitle">运营总监/PM</p>
                                        <p class="description wow">7年互联网经验，曾服务于搜狐火炬传递、北京建筑设计研究院 、日本电通等大型客户 ,对设计品质有执着追求 ...</p>
                                    </div>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2117/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="teamitem_1" class="wow">
                                    <div class="header wow" data-wow-delay=".2s">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2116/" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/269/201606/1466157484713.jpg" width="180" height="180" /></a>
                                    </div>
                                    <div class="summary wow">
                                        <p class="title"><a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2116/">陆远 / Aaron </a></p>
                                        <p class="subtitle">米其林三星主厨</p>
                                        <p class="description wow">2012, the world's most authoritative Awwwards selected 365 global best CSS website, through the international assessment of the layers of screening, excellent art guest (UElike) </p>
                                    </div>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2116/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                                <li id="teamitem_2" class="wow">
                                    <div class="header wow" data-wow-delay=".2s">
                                        <a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2115/" target="_blank"><img src="http://resources.jsmo.xin/templates/upload/269/201606/1466157601281.jpg" width="180" height="180" /></a>
                                    </div>
                                    <div class="summary wow">
                                        <p class="title"><a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2115/">江莱 / Maggie</a></p>
                                        <p class="subtitle">市场总监</p>
                                        <p class="description wow">The world's leading electronic design journal NEWWEBPICK recommended the designer of the electronic magazine (twenty-ninth) China's design industry Youth Award winners and awarded</p>
                                    </div>
                                    <a href="http://mo004_376.mo4.line1.jsmo.xin/team/post/2115/" target="_blank" class="details">more<i class="fa fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <a href="http://mo004_376.mo4.line1.jsmo.xin/team/" class="more wow">MORE<i class="fa fa-angle-right"></i></a>
                </div>
            </div>
            <div id="mpartner" class="module">
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
            </div>
            <div id="mcontact" class="module">
                <div class="bgmask"></div>
                <div class="content">
                    <div class="header wow fadeInUp fw" data-wow-delay=".1s">
                        <p class="title"> 联系我们</p>
                        <p class="subtitle">CONTACT</p>
                    </div>
                    <div id="contactlist" class="fw">
                        <div id="contactinfo" class="fl wow" data-wow-delay=".2s">
                            <h3 class="ellipsis name">网站建设文化传播有限公司</h3>
                            <p class="ellipsis add"><span>地点：</span>中国地区XX分区5A写字楼8-88室</p>
                            <p class="ellipsis zip"><span>邮编：</span>100000</p>
                            <p class="ellipsis tel"><span>电话：</span>400-888-8888</p>
                            <p class="ellipsis mobile"><span>手机：</span>188-666-5188</p>
                            <p class="ellipsis fax"><span>传真：</span>000-66668888</p>
                            <p class="ellipsis email"><span>邮箱：</span>website@qq.com</p>
                            <div><a class="fl" target="_blank" href="http://weibo.com/web"><i class="fa fa-weibo"></i></a><a class="fl" target="_blank" href="tencent://message/?uin=40080000&Site=uemo&Menu=yes"><i class="fa fa-qq"></i></a> <a id="mpbtn" class="fl" href="http://resources.jsmo.xin/templates/upload/1/201508/1438424052624.jpg"><i class="fa fa-weixin"></i></a></div>
                        </div>
                        <div id="contactform" class="fr wow" data-wow-delay=".2s">
                            <form action="http://mo004_376.mo4.line1.jsmo.xin/message/" method="post">
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