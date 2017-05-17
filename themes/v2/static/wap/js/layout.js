Do.add('dropload',{
    type : 'js',
    path : basedir + 'dropload.min.js'
});
Do.add('slide',{
    type : 'js',
    path : basedir + 'swipeSlide.min.js'
});
Do.add('swiper',{
    type : 'js',
    path : basedir + 'swiper.min.js'
});
Do.add('highcharts',{
    type : 'js',
    path : basedir + 'highcharts.js'
});
Do.add('validform',{
    type : 'js',
    path : basedir + 'validform.min.js'
});
Do.add('TouchSlide',{
    type : 'js',
    path : basedir + 'TouchSlide.1.1.js'
});
Do.add('lazy',{
    type : 'js',
    path : basedir + 'jquery.lazyload.min.js'
});

Do.add('mui',{
    type : 'js',
    path : basedir + 'mui/dist/js/mui.min.js'
});
Do.add('mui-preview',{
    type : 'js',
    path : basedir +'mui/js/mui.previewimage.js',
    requires : ['mui-zoom','mui-css','mui-preview-css']
});
Do.add('mui-zoom',{
    type : 'js',
    path : basedir +'mui/js/mui.zoom.js',
    requires : ['mui']
});
Do.add('mui-css',{
    type : 'css',
    path : basedir + 'mui/dist/css/mui.css'
});
Do.add('mui-preview-css',{
    type : 'css',
    path : basedir + 'mui/mui-preview.css'
});

Do(function() {
    if($('.detail-content').length){
        $('.detail-content').find('img').attr({
            'data-preview-src' : '',
            'data-preview-group' : 1
        });
        Do('mui-preview',function() {
            mui.previewImage();
        });
    }
})

var noPicUrl = 'undefined' === typeof noPicUrl ? '' : noPicUrl;
Do('lazy',function() {

    /* 图片预加载 begin */

        //图片加载错误显示默认图片
        wh = $(window).height();
        if($.fn.lazyload){
            $("img.lazy").lazyload({
                effect : "fadeIn" ,
                placeholder: noPicUrl,
                threshold: wh,
                failure_limit:100,
                skip_invisible:false
            });
        }
    /* 图片预加载 end */

});

//写cookies
function setCookie(name,value){
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
//读cookies
function getCookie(name){
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
//删cookies
function delCookie(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//设置url
function setDropUrl() {
    var place = $("#place").val();
    var xmts = $("#xmts").val();
    var xuexiao = $("#xuexiao").val();
    var price = $("#price").val();
    var huxing = $("#huxing").val();
    var wylx = $("#wylx").val();
    var kpsj = $("#kpsj").val();
    var order = $("#order").val();
    var zxzt = $("#zxzt").val();

    var ext_par = "";
    var place_par = "";
    var new_ajaxUrl = "";

    place_par += ($(".dropload").data("defurl").indexOf("?")>=0 ? "&" : "?") + "place="+place;

    if(xmts != 0) {
        ext_par += "_"+xmts;
    }
    if(xuexiao != 0) {
        ext_par += "_"+xuexiao;
    }
    if(price != 0) {
        ext_par += "_"+price;
    }
    if(huxing != 0) {
        ext_par += "_"+huxing;
    }
    if(wylx != 0) {
        ext_par += "_"+wylx;
    }
    if(kpsj != 0) {
        ext_par += "_"+kpsj;
    }
    if(order != 0) {
        ext_par += "_"+order;
    }
    if(zxzt != 0) {
        ext_par += "_"+zxzt;
    }

    if(ext_par != "") {
        ext_par = "&ext="+ext_par.substring(1,ext_par.length);
    }


    new_ajaxUrl = place_par+ext_par;
    $(".dropload").data("url",$(".dropload").data("defurl")+new_ajaxUrl);
}


//设置url
function setSearchDropUrl() {
    var place = $("#place").val();
    var xmts = $("#xmts").val();
    var price = $("#price").val();

    var ext_par = "";
    var place_par = "";
    var new_ajaxUrl = "";

    place_par += ($(".dropload").data("url").indexOf("?")>=0 ? "&" : "?") + "place="+place;

    if(xmts != 0) {
        ext_par += "_"+xmts;
    }
    if(price != 0) {
        ext_par += "_"+price;
    }

    if(ext_par != "") {
        ext_par = "&ext="+ext_par.substring(1,ext_par.length);
    }


    new_ajaxUrl = place_par+ext_par;
    $(".dropload").data("url",$(".dropload").data("defurl")+new_ajaxUrl);
}


function alertPop(str){
    var sucBox = $(".suc-box");
    if(sucBox.length) {
        sucBox.remove();
    }
    var sucBoxHtml = '<div class="suc-box">'+str+'</div>';
    $("body").append(sucBoxHtml);
    sucBox = $(".suc-box");
    sucBox.css({"marginLeft":-(sucBox.width()/2-20)})
    sucBox.fadeIn();
    myFade = setTimeout(function(){
        sucBox.fadeOut();
    },2000);
}


Do(function() {
    //不用了
    // var $zanBtn = $(".zan-click");
    // if($zanBtn.length) {
    //     var isZan = true;
    //     var myFade
    //     $zanBtn.on("click", function(){
    //         if(isZan) {
    //             var num = parseInt($(".touxiang-r label").text());
    //             $(".touxiang-r label").text(++num);
    //             isZan = false;
    //         } else {
    //             alertPop('已赞过了')
    //         }
    //     })
    // }



    $(function(){

        //有detail-bar样式的body增加bodypb样式
        var $detailBar = $(".detail-bar");
        if($detailBar.length) {
            if(!$("body").hasClass("bodypb")) {
                $("body").addClass("bodypb");
            }
        }

        var tht = $("#tht");
        if(tht.length && getUrlParam("md") == "tht") {
            setTimeout(function(){
                $("body").animate({"scrollTop":tht.offset().top},0);
            },0)

        }
    })



    Do('TouchSlide',function() {
        // var $leftslide = $('#leftTabBox');
        // if($leftslide.length > 0){
        //     TouchSlide({slideCell:"#leftTabBox",startFun:function(i,c){
        //         switch(i){
        //             case 0:
        //                 $(".long-btn .change-btn").data("url","./json/mxf_tags_change.json").data("container","mxf-container");
        //             break
        //             case 1:
        //                 $(".long-btn .change-btn").data("url","./json/esf_tags_change.json").data("container","esf-container");
        //             break;
        //             case 2:
        //                 $(".long-btn .change-btn").data("url","./json/zf_tags_change.json").data("container","zf-container");
        //             break;
        //         }
        //     }})
        // }

        //图册 begin
        var $photobox = $('#j-photo-box');
        if($photobox.length > 0){

            TouchSlide({slideCell:'#j-photo-box',startFun:function(i,c) {
                $photobox.find(".top .count").html('<em class="mr10">'+(i+1)+'</em>/<em>（'+c+'）</em>');

                $(".bottom .name").text($(".big-img .bd li:eq("+i+")").data("title"));
            }});
            $photobox.find('.bd li span').height(window.innerHeight);
            $photobox.find('.bd').height(window.innerHeight);
        }
        //图册 end
    });

    function getUrlParam(name){
        //构造一个含有目标参数的正则表达式对象
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        //匹配目标参数
        var r = window.location.search.substr(1).match(reg);
        //返回参数值
        if (r!=null) return unescape(r[2]);
        return null;
    }

    Do('swiper',function() {

        //新闻列表
        var newsSlide = $(".news-list-slider");
        if(newsSlide.length) {
            var swiper = new Swiper('.news-list-slider',{
                freeMode: true,
                slidesPerView: 'auto',
                initialSlide :index,
            });

            newsSlide.find("a").on("click", function(e){
                e.preventDefault();
                newsSlide.find("a").parent().removeClass("on");
                $(this).parent().addClass("on");
                $(".dropload").data("url", $(this).data("url"));
                resetNewsDropLoad();
            })
        }

        //详情页滑动封面
        var indexslide = $("#slide");
        if(indexslide.length > 0) {
            var swiper = new Swiper('#slide',{
                loop: true,
                lazyLoading: true,
                lazyLoadingInPrevNext : true,
                pagination:'.swiper-pagination',
                autoplay:3000,
            });
        }

        //户型评测页滑动切换
        var contentSlide = $(".content-slider");
        if(contentSlide.length > 0) {

            $(".huxing-nav li a").on("click", function(e){
                e.preventDefault();
                var index = $(this).parent().index(".huxing-nav li");
                $(".huxing-nav li").removeClass("current");
                $(this).parent().addClass("current");
                swiper.slideTo(index);
            })

            var swiper = new Swiper('.content-slider',{
                autoHeight: true,
                onSlideChangeEnd: function(swiper){
                    $(".huxing-nav li").removeClass("current");
                    $(".huxing-nav li:eq("+swiper.activeIndex+")").addClass("current");
                }
            });
        }

        //买新房滑动tab
        var menuSlide_left = $(".menu-slide-left");
        if(menuSlide_left.length > 0) {
            var index = getUrlParam('index') == null ? 0 : getUrlParam('index');
            var swiper = new Swiper('.menu-slide-left',{
                freeMode: true,
                slidesPerView: 'auto',
                initialSlide :index,
            });
            // $(".menu-slide-left").find("li a").removeClass("on");
            // menuSlide_left.find("li:eq("+index+") a").addClass("on");


            menuSlide_left.find("li a").on("click", function(e){
                // console.log($(this).data("isHref")!="true" || $(this).data("isHref") != undefined)
                var isHref = $(this).data("ishref") == undefined ? "false" : $(this).data("ishref");
                if(isHref != true) {
                    e.preventDefault();
                    $(".menu-slide-left").find("li a").removeClass("on");
                    $(this).addClass("on");
                    $("#xmts").val($(this).data("xmts"));
                    resetDropLoad();
                }
                $(".mask").trigger("click");
            })
        }

        //楼栋信息滑动tab
        var menuSlide_loudong = $(".menu-slide-loudong");
        if(menuSlide_loudong.length > 0) {
            var swiper = new Swiper('.menu-slide-loudong',{
                freeMode: true,
                slidesPerView: 'auto',
            });
            menuSlide_loudong.find("li a").on("click", function(e){
                e.preventDefault();
                $(".menu-slide-loudong").find("li a").removeClass("on");
                $(this).addClass("on");

                if($('.loudong-wapper').closest('.floor').length){
                    $('.loudong-wapper').click(function() {
                        var href = $(this).closest('.floor').find('a.ld-more').prop('href');
                        location.href = href;
                    });
                }
                var ajax_url = $(this).data("url");
                $.ajax({
                    type: 'GET',
                    url: ajax_url,
                    dataType: 'json',
                    success: function(data){
                        var pointsHtml = "";
                        if(data.lists && data.lists[0]){
                            if(menuSlide_loudong.parent().hasClass('loudong')){
                                data.lists = [data.lists[0]];
                            }
                            //新房列表
                            for(var i in data.lists) {
                                var left = data.lists[i].left/data.width*100;
                                var top = data.lists[i].top/data.height*100;

                                var className = data.lists[i].status != "售罄" ? "on" : "";
                                var text = data.lists[i].status;

                                pointsHtml += '<div class="point" style="left:'+left+'%; top:'+top+'%">'
                                pointsHtml += '    <a href="'+data.lists[i].url+'" data-title="'+data.lists[i].title+'" data-kaipan="'+data.lists[i].kaipan+'" data-jiaofang="'+data.lists[i].jiaofang+'" data-danyuan="'+data.lists[i].danyuan+'" data-hushu="'+data.lists[i].hushu+'" data-cengshu="'+data.lists[i].cengshu+'" data-fangyuan="'+data.lists[i].fangyuan+'" data-link="'+data.lists[i].link+'"><em class="'+className+'">'+data.lists[i].title+'</em><i>'+text+'</i></a>'
                                pointsHtml += '</div>'
                            }
                        }

                        // console.log(data.picture)
                        $(".loudong-wapper .drag-warp .img img").attr("src", data.picture);
                        $(".loudong-wapper .drag-warp .infos").html(pointsHtml);
                        //设置标题
                        if(data.title)
                            $('.loudong-wapper').closest('.floor').find('a.ld-more').html(data.title + '<i class="iconfont">&#x1020;</i>').attr('href',data.href);

                        //如果在楼盘详情首页则添加点击链接

                        if(menuSlide_loudong.attr("id") === "menu_slide_loudong_detail") {
                            $(".point a").on("click", function(e){
                                e.preventDefault();
                                $('.point a em').removeClass('clickon');
                                var _this = $(this);
                                _this.find('em').addClass('clickon');
                                $(".build-detail a").attr("href",_this.data("link"));
                                $(".build-detail h5").text(_this.data("title"));
                                $(".build-detail #kaipan").text(_this.data("kaipan"));
                                $(".build-detail #jiaofang").text(_this.data("jiaofang"));
                                $(".build-detail #danyuan").text(_this.data("danyuan"));
                                $(".build-detail #hushu").text(_this.data("hushu"));
                                $(".build-detail #cengshu").text(_this.data("cengshu"));
                                $(".build-detail #fangyuan").text(_this.data("fangyuan"));
                            })
                        }
                        $(".drag-warp").css({"width":data.width,"height":data.height})
                        $(".point:eq(0) a").triggerHandler("click");


                        if(data.lists){
                            var scroll_left = data.lists[0].left-$("#draggable").width()/2+25;
                            var scroll_top = data.lists[0].top-$("#draggable").height()/2;
                        }
                        $("#draggable").scrollTop(scroll_top).scrollLeft(scroll_left);
                    },
                    error: function(xhr, type){
                        console.log("加载楼栋信息出错 错误信息："+type);
                    }
                });
            })
            menuSlide_loudong.find("li:eq(0) a").trigger("click");
        }

        //详情页滑动封面
        var detailCover = $(".detail-cover");
        if(detailCover.length > 0) {
            var swiper = new Swiper('.detail-cover',{
                loop: true,
                lazyLoading: true,
                lazyLoadingInPrevNext : true,
                pagination:'.pages',
                paginationType : 'fraction',
                paginationFractionRender: function (swiper, currentClassName, totalClassName) {
                  return '<i class="iconfont">&#x1021;</i><span class="' + currentClassName + '"></span>' + '/' + '<span class="' + totalClassName + '"></span>';
                }
            });
        }

        //详情页楼房评测滑动
        var sliderPingce = $(".slider-pingce");
        if(sliderPingce.length > 0) {
            var swiper = new Swiper('.slider-pingce',{
                // freeMode: true,
                slidesPerView: 'auto',
            });
        }

        //详情页周边配套滑动
        var sliderPeitao = $(".slider-peitao");
        if(sliderPeitao.length > 0) {
            var swiper = new Swiper('.slider-peitao',{
                // freeMode: true,
                slidesPerView: 'auto',
            });
        }
        //首页今日头条
        var sliderText = $(".text-slide");
        if(sliderText.length > 0) {
            var swiper = new Swiper('.text-slide',{
                direction: 'vertical',
                autoplay: 3000,
                loop:true,
            });
        }


        //买新房滑动tab
        var menuSlide_left = $(".swiper-wrapper-nav");
        if(menuSlide_left.length > 0) {
            var swiper = new Swiper('.swiper-wrapper-nav',{
                freeMode: true,
                slidesPerView: 'auto',
            });
            menuSlide_left.find("li a").on("click", function(e){
                // e.preventDefault();
                menuSlide_left.find("li a").removeClass("on");
                $(this).addClass("on");
            })
        }
    });

    var backTop = $(".gototop");
    backTop.bind("click", function (e) {
        // document.body.scrollTop = 0;
        // document.documentElement.scrollTop = 0;
        $("body").animate({"scrollTop":"0"},300);
        return false;
    });
    $(document).bind("scroll", function () {
        var top = document.body.scrollTop || document.documentElement.scrollTop;
        if (top > $(window).height()){
            backTop.show();
        }
        else{
            backTop.hide();
        }
    });





    //是否禁止页面滚动
    function changeScroll(flag){
        if(flag){
            $(".container").css({"height":$(window).innerHeight()-$("header").height()-$(".menu-slide-left").height()})
            // document.body.style.overflow='hidden';
            // document.body.style.height=document.body.clientHeight+"px";
        } else {
            $(".container").css({"height":"auto"})
        }
    }


    //搜索选择类型
    var searchChoose = $(".search-choose");
    if(searchChoose.length) {
        searchChoose.find("li a").on("click", function(e){
            e.preventDefault();
            var index = $(this).parent().index(".search-choose li");

            searchChoose.find(".bd .expand-box:eq("+index+")").show();

        });

        //选择
        $(".bd .expand-box ul li").off("click").on("click", function(){
            var _this = $(this);
            _this.parent().find("li").removeClass("current");
            _this.addClass("current");
            var expandBox = _this.parent().parent();
            expandBox.hide();
            var index = expandBox.index(".bd .expand-box");
            searchChoose.find("li:eq("+index+") a span:eq(1)").html(_this.text() + "<i class='iconfont'>&#x1020;</i>");
            if(index == 0) {
                //区域
                $("#place").val($(this).data("place"));
            } else if(index == 1) {
                //价格
                $("#price").val($(this).data("price"));
            } else if(index == 2) {
                //特色
                $("#xmts").val($(this).data("xmts"));
            }

        })

        //重置
        $("#reset_btn").on("click", function(e){
            e.preventDefault();
            $(".search-choose").find("li").each(function(){
                $(this).find("a span:eq(1)").html("不限<i class='iconfont'>&#x1020;</i>");
            })
        });

        //清除历史记录
        $(".clear-btn").on("click", function(e){
            e.preventDefault();
            delCookie("xf_s_h_hlx");
            $("#search_history").find(".search-ul").html("");
        })

        //顶部搜索按钮
        $("#search_btn").on("click", function(e){
            e.preventDefault();

            var histories = getCookie("xf_s_h_hlx");
            var keywords = $("#keywords_input").val();

            if($.trim(keywords) != "") {
                if(histories == null) {
                    histories = keywords;
                } else {
                    var history_arr = histories.split("#");
                    histories = "";

                    var maxLength = history_arr.length > 4 ? 3 : (history_arr.length-1)
                    for(var i=maxLength; i>=0; i--) {
                        histories = "#" + history_arr[i] + histories;
                    }
                    histories  = keywords + histories;
                }
                setCookie("xf_s_h_hlx",histories);
            }
            $("form").submit();
        })

        //确认搜索
        $("#submit_btn").on("click", function(e){
            e.preventDefault();
            $("#search_index").hide();
            $("#search_history").hide();
            $("#search_list").show();
        })

        //搜索框获取焦点
        $("#keywords_input").on("focus", function(e){

            var histories = getCookie("xf_s_h_hlx");
            if(histories != null) {
                var history_arr = histories.split("#");
                var historyHtml = "";
                for(var i=0; i<history_arr.length; i++) {
                    historyHtml += '<li><a href="">'+history_arr[i]+'</a></li>';
                }
                $("#search_history").find(".search-ul").html(historyHtml);

                $("#search_history").find(".search-ul li a").on("click", function(e){
                    e.preventDefault();
                    $("#keywords_input").val($(this).text());
                    $("#search_btn").trigger("click");
                })
            }

            $("#search_index").hide();
            $("#search_list").hide();
            $("#search_history").show();
        })

        $("#keywords_input").on("input", function(e){
            var keywords = $("#keywords_input").val();
            if($.trim(keywords) == "") {
                $(".search-frame-expand").hide();
                return false;
            }
            var ajax_url = $(this).data("url")
            $.ajax({
                type: 'GET',
                url: ajax_url,
                'data' : $.extend({},{keywords:keywords}),
                dataType: 'json',
                success: function(data){
                    var searchHtml = "";
                    for(var i in data.lists) {
                        if(data.lists[i].title.indexOf(keywords) >= 0) {
                            searchHtml += '<li><a href="'+data.lists[i].link+'"><p>'+data.lists[i].title.replace(keywords,"<span>"+keywords+"</span>")+'</p><p>'+data.lists[i].address+'</p></a> </li>';
                        }
                    }
                    if(searchHtml != "") {
                        var h = $(window).height();
                        var t1 = $("header").outerHeight();
                        var t2 = $(".search").outerHeight();
                        searchHtml += '<a href="" class="close-search-expand">关闭</a>'
                        $(".search-frame-expand").html(searchHtml).css({"height":h-t1-t2,"overflow":"auto"}).show();

                        var searchClose = $(".close-search-expand");
                        searchClose.off("click").on("click", function(e){
                            e.preventDefault();
                            $("#keywords_input").val("");
                            $(this).parent().hide();
                        })
                    } else{
                        $(".search-frame-expand").hide();
                    }

                },
                error: function(xhr, type){
                    console.log('搜索加载失败 错误信息：'+type);
                }
            });
        })
    }

    //知识列表重选分类
    var rechooseBtn = $(".cate-box .rechoose-btn");
    if(rechooseBtn.length) {
        rechooseBtn.on("click", function(e){
            e.preventDefault();
            $(".mask").show();
            $(".cate-expand").show();
        })
        $(".mask").on("click", function(){
            $(this).hide();
            $(".cate-expand").hide();
        })
        $(".cate-expand dl").on("click", function(){
            $(".cate-expand dl").removeClass("on");
            $(this).addClass("on");
        })
    }

    //返回
    var headerBar_back = $(".title-bar a.back");
    if(headerBar_back.length > 0) {
        headerBar_back.on("click", function(e){
            if(!$(this).hasClass("nojs")) {
                e.preventDefault();
                window.history.back();
            }
        })
    }


    //知识搜索
    $("#knowledge_key").on("keyup", function(e){
        var keywords = $("#knowledge_key").val();
        if($.trim(keywords) == "") {
            $(".search-frame-expand").hide();
            return false;
        }
        var ajax_url = $(this).data("url")
        $.ajax({
            type: 'GET',
            url: ajax_url,
            'data' : $.extend({},{keywords:keywords}),
            dataType: 'json',
            success: function(data){
                var searchHtml = "";
                for(var i in data.lists) {
                    if(data.lists[i].title.indexOf(keywords) >= 0) {
                        searchHtml += '<li><a href="'+data.lists[i].link+'"><p>'+data.lists[i].title.replace(keywords,"<span>"+keywords+"</span>")+'</p></a> </li>';
                    }
                }

                if(searchHtml != "") {
                    var h = $(window).height();
                    var t1 = $("header").outerHeight();
                    var t2 = $(".search").outerHeight();
                    searchHtml += '<a href="" class="close-search-expand">关闭</a>'
                    $(".search-frame-expand").html(searchHtml).css({"height":h-t1-t2,"overflow":"auto"}).show();

                    var searchClose = $(".close-search-expand");
                    searchClose.off("click").on("click", function(e){
                        e.preventDefault();
                        $("#knowledge_key").val("");
                        $(this).parent().hide();
                    })
                } else{
                    $(".search-frame-expand").hide();
                }
            },
            error: function(xhr, type){
                console.log('搜索加载失败 错误信息：'+type);
            }
        });
    })

    //搜索
    // var headerBar_search = $(".title-bar a.search");
    // if(headerBar_search.length > 0) {
    //     headerBar_search.on("click", function(e){
    //         e.preventDefault();
    //         console.log("搜索")
    //     })
    // }

    //菜单
    var headerBar_menu = $(".title-bar a.menu");
    if(headerBar_menu.length > 0) {
        headerBar_menu.on("click", function(e){
            e.preventDefault();
            console.log("弹出菜单")
        })
    }

    //提交验证
    Do('validform',function() {
        var my_validForm = $("#yuyueform");
        if(my_validForm.length > 0) {
            $("#yuyueform").Validform({
                btnSubmit:"#btn_sub",
                tiptype:function(msg,o,cssctl){
                    if(o.type === 3) {
                        $(o.obj).parent().find(".error-msg").text(msg);
                    }else if(o.type === 2){
                        $(o.obj).parent().find(".error-msg").text('');
                    }
                },
                ajaxPost:false,
                tipSweep:true,
                callback:function(data){
                    $("#error-result").text(data.msg);
                }
            });
        }


        var wendaForm = $(".wendaForm");
        if(wendaForm.length) {
            wendaForm.Validform({
                btnSubmit:"#btn_sub",
                tiptype:function(msg,o,cssctl){
                    if(o.type === 3) {
                        wendaForm.find(".error-msg").text(msg);
                    }else if(o.type === 2){
                        wendaForm.find(".error-msg").text('');
                    }
                },
                tipSweep:true,
                callback:function(data){


                }
            });
        }



        var $form = $('#validform');
        if($form.length > 0){
        var isAjax = true;
        if($form.data("isajax") == false) {
            isAjax = false;
        }
        $form.Validform({
            tipSweep:true,
            ajaxPost:isAjax,
            tiptype:function(msg,o,cssctl){
                var $errormsg=o.obj.parent().siblings('.error-txt');
                if(o.type === 3){
                   $errormsg.text(msg);
                }else if (o.type === 2){
                    $errormsg.text('');
                }
            },
            callback:function(data){
                if(isAjax){
                    $form.get(0).reset();
                }
                alertPop("提交成功");
            }
        });

        }

    });

    //搜索页搜索
    var searchBtn = $("#submit_search");
    if(searchBtn.length) {
        searchBtn.on("click", function(e){
            $("#search_index").hide();
            $("#search_list").show();
            e.preventDefault();
            resetSearchDropLoad();
        })
    }



    //买新房选择菜单
    var selectSlide_down = $(".select-slide-down");
    if(selectSlide_down.length > 0) {
        selectSlide_down.find("li a").on("click", function(e){
            e.preventDefault();
            selectSlide_down.find("li a").removeClass("on");
            $(this).addClass("on");
            $(".select-slide-down li a i").removeClass("rotate180");
            $(this).find("i").addClass("rotate180");

            $(".mask").hide();
            $(".select-slider").hide();

            var index = $(this).parent().index(".select-slide-down li");
            $("body").scrollTop(0);
            changeScroll(true);
            $(".mask").show();

            var t_h = $(".menu-slide-left").outerHeight();
            var m_h = $(".select-slide-down").outerHeight();
            switch (index) {
                case 0:
                    $(".select-slider-location").css({"top":t_h+m_h-1,"border-top":"#ebebeb solid 1px"}).show();
                    $(".select-slider-location .select-left li").off("click").on("click", function(){
                        var _index = $(this).index(".select-left li");
                        $(".select-slider-location .select-left li").removeClass("on");
                        $(this).addClass("on");
                        $(".select-center,.select-right").hide();
                        $(".select-center:eq("+_index+")").show();
                    })

                    $(".select-slider-location .select-center li").off("click").on("click", function(){
                        var _index = $(this).data("index");
                        $(".select-slider-location .select-center li").removeClass("on");
                        $(this).addClass("on");
                        $(".select-right").hide();
                        $(".select-right:eq("+_index+")").show();

                        if($(this).text() == "不限") {
                            $(".select-slide-down li:eq(0) p").html($(this).text());
                            $(".select-slide-down li:eq(0) i").removeClass("rotate180");
                            $(".select-slide-down li:eq(0) a").removeClass("on");
                            $(".select-slider-location").hide();
                            $(".mask").hide();
                            $("#place").val($(this).data("place"));
                            $("#xuexiao").val("0");
                            changeScroll(false);
                            resetDropLoad();
                        }

                        $(".select-right:eq("+_index+") li").on("click", function(){
                            if($(this).data("xuexiao") != undefined){
                                $(".select-slide-down li:eq(0) p").html($(this).text());
                                $(".select-slide-down li:eq(0) i").removeClass("rotate180");
                                $(".select-slide-down li:eq(0) a").removeClass("on");
                                $(".select-slider-location").hide();
                                $(".mask").hide();
                                $("#xuexiao").val($(this).data("xuexiao"));
                                $("#place").val("0");
                                changeScroll(false);
                                resetDropLoad();
                            }

                        });
                    })
                    break;
                case 1:
                    $(".select-slider-price").css({"top":t_h+m_h-1,"border-top":"#ebebeb solid 1px"}).show();
                    break;
                case 2:
                    $(".select-slider-hot").css({"top":t_h+m_h-1,"border-top":"#ebebeb solid 1px"}).show();
                    break;
                case 3:
                    $(".select-slider-more").css({"top":t_h+m_h-1,"border-top":"#ebebeb solid 1px"}).show();
                    break;
            }
        })
    }

    //下拉条件选择
    $(".select-slider li,.select-slider a").on("click", function(){

        var forSlider = $(this).parent().attr("for");
        var parentClass = $(this).parent()[0].className;
        $(".select-slider ."+parentClass+" li").removeClass("on");
        $(this).addClass("on");
        if(forSlider == "select-slider-location") {
            $(".select-slide-down li:eq(0) p").html($(this).text());
            $(".select-slide-down li:eq(0) i").removeClass("rotate180");
            $(".select-slide-down li:eq(0) a").removeClass("on");
            $(".select-slider-location").hide();
            $(".mask").hide();
            $("#place").val($(this).data("place"));
            changeScroll(false);
            resetDropLoad();
        } else if(forSlider == "select-slider-price") {
            $(".select-slide-down li:eq(1) p").html($(this).find("em").text());
            $(".select-slide-down li:eq(1) i").removeClass("rotate180");
            $(".select-slide-down li:eq(1) a").removeClass("on");
            $(".select-slider-price").hide();
            $(".mask").hide();
            $("#price").val($(this).data("price"));
            changeScroll(false);
            resetDropLoad();
        } else if(forSlider == "select-slider-hot") {
            $(".select-slide-down li:eq(2) p").html($(this).find("em").text());
            $(".select-slide-down li:eq(2) i").removeClass("rotate180");
            $(".select-slide-down li:eq(2) a").removeClass("on");
            $(".select-slider-hot").hide();
            $(".mask").hide();
            $("#huxing").val($(this).data("huxing"));
            changeScroll(false);
            resetDropLoad();
        } else if(forSlider == "select-slider-more-child") {
            $(this).parent().find("div.slider-title em").text($(this).text());

            if($(this).data("zxzt") != undefined) {
                $("#zxzt").val($(this).data("zxzt"))
            }
            if($(this).data("wylx") != undefined) {
                $("#wylx").val($(this).data("wylx"))
            }
            if($(this).data("kpsj") != undefined) {
                $("#kpsj").val($(this).data("kpsj"))
            }
            if($(this).data("order") != undefined) {
                $("#order").val($(this).data("order"))
            }

        } else if(forSlider == "select-slider-more") {

            if($(this).hasClass("btn-reset")) {
                console.log("您点击的是重置");
                $(".select-slider-more ul").each(function(){
                    $(this).find("li:eq(0)").trigger("click");
                })
            } else if($(this).hasClass("btn-submit")) {
                console.log("您点击的是确认");
                $(".select-slide-down li:eq(3) i").removeClass("rotate180");
                $(".select-slide-down li:eq(3) a").removeClass("on");
                $(".select-slider-more").hide();
                $(".mask").hide();
                changeScroll(false);
                resetDropLoad();
            }
        }
    })


    //地图找房
    var l_map = $("#l-map");
    if(l_map.length > 0) {

        //初始化地图标注
        var getAreaInfoUrl = l_map.data("url");
        function initMapOverLays(){
            $.ajax({
                'url' : getAreaInfoUrl,
                'type' : 'get',
                'dataType' : 'json',
                'success' : function( data ) {
                    $(".map-title em").text(data.total);
                    for(var i in data.lists) {
                        var content = "<a href='' data-i='"+i+"' data-lng='"+data.lists[i].lng+"' data-lat='"+data.lists[i].lat+"'>"+data.lists[i].name+"<i>"+data.lists[i].num+"</i></a>";
                        var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(data.lists[i].lng,data.lists[i].lat), content, "map-marker");
                        mp.addOverlay(myCompOverlay);
                    }
                }
            });
        }

        var getAreaDetailUrl = l_map.data("childurl");
        function createMapOverLays(){
            var center = mp.getCenter();
            var current_bounds = mp.getBounds();
            var sw_point = current_bounds.getSouthWest();
            var ne_point = current_bounds.getNorthEast();
            var distance = mp.getDistance(sw_point,ne_point);
            $.ajax({
                'url' : getAreaDetailUrl,
                'type' : 'get',
                'data' : $.extend({},{lng:center.lng,lat:center.lat,distance:distance}),
                'dataType' : 'json',
                'success' : function( data ) {
                    for(var i in data.areas) {
                        var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(data.areas[i].lng,data.areas[i].lat), "<p data-link='"+data.areas[i].link+"'>"+data.areas[i].name+"</p>", "map-marker2");
                        mp.addOverlay(myCompOverlay);
                    }
                }
            });
        }

        var zoom = 12;
        l_map.css("height",$(window).height()-$(".title-bar").outerHeight());
        var mp = new BMap.Map("l-map");
        // var point = new BMap.Point(119.95887,31.787821);    //初始中心点
        // 百度地图API功能
        mp.centerAndZoom(cityName, 12);    //设置中心点以及地图层级  默认12级
        initMapOverLays();

        //缩放监听事件
        mp.addEventListener('zoomend', function() {
            //清除所有标注 OVERLAYS
            mp.clearOverlays();

            if( mp.getZoom() <= zoom ) {
                initMapOverLays();
            } else {
                createMapOverLays();
            }
        });

        //拖动监听事件
        mp.addEventListener('dragend' , function(){
            if( mp.getZoom() > zoom ) {
                //清除所有标注 OVERLAYS
                mp.clearOverlays();
                //生成新的标注
                createMapOverLays();
            }
        });

        //搜索
        var searchFrom = $("#search_form");
        if(searchFrom.length) {
            searchFrom.find("input[type=text]").on("keyup", function(e){
                if(e.which == 13) {
                    searchFrom.submit();
                } else {
                    var search_url = searchFrom.data("url");
                    var keywords = $(this).val();
                    $.ajax({
                        'url' : search_url,
                        'type' : 'get',
                        'data' : $.extend({},{key:keywords}),
                        'dataType' : 'json',
                        'success' : function(data) {
                            $(".search_result").remove();
                            $("body").append("<ul class='search_result'></ul>");
                            var search_html = "";
                            for(var i in data.lists) {
                                search_html += '<li><a href="#" data-lng="'+data.lists[i].lng+'" data-lat="'+data.lists[i].lat+'">'+data.lists[i].name+'</a></li>'
                            }
                            $(".search_result").html(search_html);

                            $(".search_result").find("a").on("click", function(e){
                                var area_point = new BMap.Point($(this).data("lng"),$(this).data("lat"));    //初始中心点
                                mp.centerAndZoom(area_point,18)
                                $(".search_result").remove();
                            })
                        }
                    });
                }
            })
        }


        // 复杂的自定义覆盖物
        function ComplexCustomOverlay(point, content, className){
          this._point = point;
          this._text = content;
          this._className = className;
        }
        ComplexCustomOverlay.prototype = new BMap.Overlay();
        ComplexCustomOverlay.prototype.initialize = function(map){
            this._map = map;
            var div = this._div = document.createElement("div");
            div.className = this._className;
            div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
            div.innerHTML = this._text+"";

            //显示到小区名称
            if(this._className=="map-marker") {
                div.addEventListener("touchend", function() {
                    var lng = this.getElementsByTagName("a")[0].getAttribute("data-lng");
                    var lat = this.getElementsByTagName("a")[0].getAttribute("data-lat");
                    var index = this.getElementsByTagName("a")[0].getAttribute("data-i");
                    point = new BMap.Point(lng,lat);
                    mp.clearOverlays();
                    mp.centerAndZoom(point, 13);
                });
            } else if(this._className == "map-marker2"){
                div.addEventListener("touchend", function() {
                    var link = this.getElementsByTagName("p")[0].getAttribute("data-link");
                    window.location.href=link;
                });
            }
            mp.getPanes().labelPane.appendChild(div);
            return div;
        }
        ComplexCustomOverlay.prototype.draw = function(){
          var map = this._map;
          var pixel = map.pointToOverlayPixel(this._point);
          this._div.style.left = pixel.x + "px";
          this._div.style.top  = pixel.y + "px";
        }

    }

    //点击mask
    $(".new-house .mask").on("click", function(){
        $(".select-slide-down li i").removeClass("rotate180");
        $(".select-slide-down li a").removeClass("on");
        $(".select-slider").hide();
        $(".mask").hide();
        changeScroll(false);
    })




    //周边配套
    var a_map = $("#a-map");
    if(a_map.length > 0) {
        var _data = {};
        var ajax_url = a_map.data("url");
        var mapBar = $(".map-around-bar");
        var mp = new BMap.Map("a-map");
        $.ajax({
            type: 'GET',
            url: ajax_url,
            dataType: 'json',
            success: function(data){

                a_map.css("height",$(window).height())
                var point = new BMap.Point(data.lng,data.lat);   //初始中心点
                // 百度地图API功能
                mp.centerAndZoom(point, 15);    //设置中心点以及地图层级  默认15级
                // 复杂的自定义覆盖物
                function ComplexCustomOverlay(point, content, className){
                  this._point = point;
                  this._text = content;
                  this._className = className;
                }
                ComplexCustomOverlay.prototype = new BMap.Overlay();
                ComplexCustomOverlay.prototype.initialize = function(map){
                    this._map = map;
                    var address = this._text;
                    var div = this._div = document.createElement("div");
                    div.setAttribute("data-lat", this._point.lat);
                    div.setAttribute("data-lng", this._point.lng);
                    div.className = this._className;
                    div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);


                    //小区名称
                    if(this._className=="map-marker2") {
                        div.innerHTML = this._text;
                    } else {
                        //点
                        var span = document.createElement("span");
                        span.innerHTML = address;
                        div.appendChild(span);
                        div.addEventListener("touchend", function() {
                            // console.log(this)
                            var _this = this;
                            var new_point = new BMap.Point(_this.getAttribute("data-lng"),_this.getAttribute("data-lat"));
                            // mp.centerAndZoom(new_point,15,300);
                            var point_wappers = document.getElementsByClassName("map-marker-wapper");
                            for(var i=0; i<point_wappers.length; i++) {
                                point_wappers[i].getElementsByTagName("span")[0].style.display = "none";
                            }
                            _this.getElementsByTagName("span")[0].style.display = "block";
                            setTimeout(function(){
                                _this.getElementsByTagName("span")[0].style.display = "none";
                            },5000)
                        });
                    }

                    mp.getPanes().labelPane.appendChild(div);
                    return div;
                }
                ComplexCustomOverlay.prototype.draw = function(){
                  var map = this._map;
                  var pixel = map.pointToOverlayPixel(this._point);
                  this._div.style.left = pixel.x + "px";
                  this._div.style.top  = pixel.y + "px";
                }

                mapBar.find("li a").on("click", function(e){
                    e.preventDefault();
                    var index = $(this).parent().index(".map-around-bar li");
                    var typeName = $(this).data("name");
                    var className = $(this).data("class");
                    mapBar.find("li a").removeClass("on");
                    $(this).addClass("on");
                    ajax_url = "http://api.map.baidu.com/place/v2/search?query="+typeName+"&page_size=10&page_num=0&scope=1&location="+data.lat+","+data.lng+"&radius=2000&output=json&ak=415167759dc5861ddbbd14154f760c7e"
                    $.ajax({
                        'url' : ajax_url,
                        'type' : 'get',
                        'dataType' : 'jsonp',
                        'jsonp':'callback',
                        'success' : function(data) {
                            mp.addOverlay(myCompOverlay);
                            mp.clearOverlays();
                            // console.log(data.result)
                            for(var i in data.results) {
                                var content = "名称："+data.results[i].name+"<br>地址："+data.results[i].address;
                                var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(data.results[i].location.lng,data.results[i].location.lat), content, "map-marker-wapper "+className);
                                mp.addOverlay(myCompOverlay);
                            }
                        }
                    });
                })
                //自动触发交通
                var index = is_plot_around_index || 0;
                mapBar.find("li:eq(" + index + ") a").trigger("click");
            },
            error: function(xhr, type){
                console.log("加载周边设施出错 错误信息："+type);
            }
        })
    }



    //详情页红包
    var hongbaoBtn = $(".detail-info a.hongbao");
    if(hongbaoBtn.length > 0) {
        hongbaoBtn.on("click", function(e){
            e.preventDefault();
            $(".hongbao-wapper").stop().animate({"top":"0"},200);
            $("body").css({"overflow":"hidden"});
        });
        $(".hongbao-wapper a.close").on("click", function(e){
            e.preventDefault();
            $(".hongbao-wapper").stop().animate({"top":"-100%"},200);
            $("body").css({"overflow":"auto"});
        })
    }

    //详情页问答输入框
    var wendaFormInput = $(".wenda-form input");
    if(wendaFormInput.length > 0) {
        wendaFormInput.on("focus blur", function(e){
            if(e.type == "focus") {
                wendaFormInput.parent().find(".btn-submit").fadeIn();
            } else {
                wendaFormInput.parent().find(".btn-submit").fadeOut();
            }
        })
    }

    //打开分享
    var shareBtn = $(".detail-title .share");
    if(shareBtn.length) {
        shareBtn.on("click", function(e){
            e.preventDefault();
            $(".share-wapper").show();
        })
    }
    //关闭分享
    var shareWapper = $(".share-wapper");
    if(shareWapper.length) {
        shareWapper.find("a.close").on("click", function(e){
            e.preventDefault();
            shareWapper.hide();
        })

        var shareWechat = shareWapper.find("a.my_bds_weixin");
        shareWechat.on("click", function(e){
            e.preventDefault();
            $(".share-bg").show();
            $("a.close-bg").on("click", function(e){
                e.preventDefault();
                $(".share-bg").hide();
            })
        })
    }

    //详情页价格趋势
    Do('highcharts',function() {
        var qushi = $(".qushi");
        if(qushi.length > 0) {
            var ajax_url = qushi.data("url");
            $.ajax({
                type: 'GET',
                url: ajax_url,
                dataType: 'json',
                success: function(data){
                    var colors = ['#7c9acc','#fb8438','#8db88d'];
                    var marker = {
                        radius : 4,
                        symbol : 'circle'
                    };


                    for(var i=0,len=data.datas.length;i<len;i++){
                        var current = data.datas[i];
                        data.datas[i] = {
                            color : colors[i],
                            marker : marker,
                            data : current.data,
                            name : current.title
                        };
                    }

                    qushi.highcharts({
                        chart: {
                            height: 200,
                            marginLeft: 35
                        },
                        credits:{
                             enabled:false // 禁用版权信息
                        },
                        title: {
                            text:'',
                        },
                        xAxis: {
                            categories: data.categories,
                            gridLineColor: '#ddd',
                            gridLineWidth: 1,
                            tickLength: 0
                        },
                        yAxis: {
                            title: {
                                text: ' '
                            },
                            // type: 'logarithmic',
                            tickInterval: 2,
                            min:0,
                            gridLineColor: '#ddd',
                            gridLineWidth: 1,
                            floor:0,
                            labels: {
                                formatter: function() {
                                    if(this.value == 0) {
                                        return this.value;
                                    } else {
                                        return this.value +'K';
                                    }
                                }
                            }
                        },
                        tooltip: {
                            valueSuffix: 'K',
                        },
                        series: data.datas
                    });



                    $(".qushi-title").html("本月楼盘价格<em>"+data.price+"</em>元/平 对比上月"+data.text);
                },
                error: function(xhr, type){
                    console.log("加载价格趋势出错 错误信息："+type);
                }
            });
        }

        var bingtu = $(".daikuan dt");
        if(bingtu.length) {
            $.ajax({
                type: 'GET',
                url: './json/daikuan.json',
                dataType: 'json',
                success: function(data){
                    bingtu.highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            backgroundColor:"#faf5f1",
                            margin:[0,0,0,0]
                        },
                        credits:{
                             enabled:false // 禁用版权信息
                        },
                        title: {
                            text: ''
                        },
                        tooltip: {
                            pointFormat: '{point.percentage:.1f}%'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            data: [
                                {
                                    color:"#9ed969",
                                    name:"首期付款",
                                    y:data.sqfk
                                },
                                {
                                    color:"#5b99ee",
                                    name:"支付利息",
                                    y:data.zflx
                                },
                                {
                                    color:"#ff9d97",
                                    name:"贷款总额",
                                    y:data.dkze
                                }
                            ]
                        }]
                    });

                    $(".dprice em").text(data.dkze*10000);
                    $(".daikuan-detail li:eq(0) p:eq(1)").text(data.sqfk+"万");
                    $(".daikuan-detail li:eq(1) p:eq(1)").text(data.zflx+"万");
                    $(".daikuan-detail li:eq(2) p:eq(1)").text(data.dkze+"万");
                },
                error: function(xhr, type){
                    console.log("加载贷款信息出错 错误信息："+type);
                }
            });
        }
    });





    /*统一换一换*/
    var changeBtn = $(".change-btn");
    if(changeBtn.length) {

        changeBtn.on("click", function(e){
            e.preventDefault();
            var ajax_url = $(this).data("url");
            var change_template = $(this).data("template");
            var change_container = $(this).data("container");

            var marginLeft = $("."+change_container).css("marginLeft");

            // $("."+change_container).stop().animate({"marginLeft":"-100%"},300);
            $("."+change_container).stop().animate({"opacity":"0"},300);
            $.ajax({
                type: 'GET',
                url: ajax_url,
                dataType: 'json',
                success: function(data){
                    var changeHtml = "";
                    switch(change_template){
                        case "tjfList" :
                            for(var i in data.lists) {

                                changeHtml += '<li>'
                                + '    <a href="'+data.lists[i].link+'">'
                                + '        <div class="fang-village">'
                                + '            <div class="pic">'
                                + '                <img class="lazy" data-original="'+data.lists[i].pic+'" alt="" />'
                                + '                <div class="cx-news">'+data.lists[i].sale+'</div>'
                                + '            </div>'

                                + '            <div class="info">'
                                + '                <div class="name"><h2 class="fs16">'+data.lists[i].title+'</h2><span>均价'+data.lists[i].price+'</span></div>'
                                + '                <p class="fs14">'+data.lists[i].detail+'</p>'
                                + '                <p><strong class="oprice">'+data.lists[i].tprice+'/套</strong><del>'+data.lists[i].yprice+'</del></p>'
                                //+ '                <i class="goarrow iconfont">&#x1020;</i>'
                                + '            </div>'
                                + '        </div>'
                                + '    </a>'
                                + '</li>'
                            }
                            break;
                        case "thgList" :
                            for(var i in data.lists) {
                                changeHtml += '<li>'
                                + '    <a href="'+data.lists[i].link+'">'
                                + '        <div class="fang-village">'
                                + '            <div class="pic">'
                                + '                <img class="lazy" data-original="'+data.lists[i].pic+'" alt="" />'
                                + '            </div>'
                                + '            <div class="info">'
                                + '                <p class="discount">'+data.lists[i].title+'</p>'
                                + '                <div class="name"><h2>'+data.lists[i].name+'</h2><span>均价'+data.lists[i].price+'</span></div>'
                                + '                <p class="news"><span><em>'+data.lists[i].num+'</em>人已抢到</span>  <span>'+data.lists[i].over+'</span></p>'
                                // + '                <i class="goarrow iconfont">&#x1020;</i>'
                                + '            </div>'
                                + '        </div>'
                                + '    </a>'
                                + '</li>'
                            }
                            break;
                        case "xinfangList" :
                            for(var i in data.lists) {
                                changeHtml += '<li>'
                                + '<a href="' + data.lists[i].link + '">'
                                + '    <div class="top-mark"></div>'
                                + '    <img class="lazy" data-original="'+data.lists[i].pic+'">'
                                + '    <p class="name">'+data.lists[i].title+' <br>'+data.lists[i].price+'</p>'
                                if(data.lists[i].person!=''){
                                    changeHtml += '    <div class="person"><img class="lazy" data-original="'+data.lists[i].person+'"></div>'
                                }
                                changeHtml += '</a>'
                                + '<div class="info"><div class="label">'

                                for(var j in data.lists[i].tags) {
                                    changeHtml += '<span class="'+data.lists[i].tags[j].className+'">'+data.lists[i].tags[j].txt+'</span>'
                                }

                                changeHtml += '    </div>'
                                + '    <p>'+data.lists[i].detail+'</p>'
                                + '</div>'
                                + '</li>'
                            }
                            break;
                        case "recordList" :
                            // changeHtml +='<tr>'
                            //     + '    <th>客户</th>'
                            //     + '    <th>电话</th>'
                            //     + '    <th>楼盘</th>'
                            //     + '    <th>带看时间</th>'
                            //     + '</tr>'
                            for(var i in data.lists) {

                                changeHtml += '<tr>'
                                + '    <td>'+data.lists[i].name+'</td>'
                                + '    <td>'+data.lists[i].mobile+'</td>'
                                + '    <td>'+data.lists[i].house+'</td>'
                                + '    <td>'+data.lists[i].date+'</td>'
                                + '</tr>'
                            }
                            break;
                        case "reviewList" :
                            for(var i in data.lists) {
                                changeHtml += '<li>'
                                + '    <p><span>楼盘名称：</span>'+data.lists[i].name+'</p>'
                                + '    <p><span>楼盘分析：</span>'+data.lists[i].detail+'</p>'
                                + '</li>'
                            }
                            break;
                        case "tagsList" :
                            changeHtml = "<li>"
                            for(var i in data.lists) {
                                changeHtml += '<a href="'+data.lists[i].link+'">'+data.lists[i].title+'</a>';
                            }
                            changeHtml += "</li>"
                            break;
                        case "newsList" :
                            for(var i in data.lists) {
                                changeHtml +='<li>'+'<a class="opacity" href="'+data.lists[i].link+'">'
                                +'<div class="pic">'
                                +'<img src="'+data.lists[i].pic+'" alt="">'
                                +'</div>'
                                +'<div class="info">'
                                +'<p>'+data.lists[i].title+'</p>'
                                +'</div>'
                                +'</a>'
                                +'<div class="tags">'
                                for(var j in data.lists[i].tags){
                                    changeHtml +='<a href="'+data.lists[i].tags[j].link+'">'+data.lists[i].tags[j].name+'</a>'
                                }
                                changeHtml +='</div>'
                                +'</li>';
                            }break;

                    }

                    // 为了测试，延迟1秒加载
                    setTimeout(function(){
                        // $("."+change_container).html(changeHtml).css({"marginLeft":"100%"}).stop().animate({"marginLeft":marginLeft},300);;
                        $("."+change_container).html(changeHtml).find('img.lazy').lazyload({
                            effect : "fadeIn" ,
                            placeholder: noPicUrl,
                            threshold: wh,
                            failure_limit:100,
                            skip_invisible:false
                        });
                        $("."+change_container).stop().animate({"opacity":"1"},300);
                    },300);
                },
                error: function(xhr, type){
                    console.log("换一换加载失败  错误信息："+type);
                }
            });
        })
    }




    /*统一加载更多*/
    var page = 1;
    var _dropLoad = null;

    function resetDropLoad() {
        $(".more-list").html("");
        setDropUrl();
        page = 1;
        if(_dropLoad != null) {
            _dropLoad.unlock();
            _dropLoad.isData = true;
            _dropLoad.resetload();
        }
    }

    function resetSearchDropLoad() {
        $(".more-list").html("");
        setSearchDropUrl();
        page = 1;
        if(_dropLoad != null) {
            _dropLoad.unlock();
            _dropLoad.isData = true;
            _dropLoad.resetload();
        }
    }

    function resetNewsDropLoad() {
        $(".more-list").html("");
        page = 1;
        if(_dropLoad != null) {
            _dropLoad.unlock();
            _dropLoad.isData = true;
            _dropLoad.resetload();
        }
    }


    var my_lng = "119.95887";
    var my_lat = "31.787821";   //默认经纬度

    //获取定位
    var my_map = null;
    var locationMap = $("#location_map");
    if(locationMap.length) {
        my_map = new BMap.Map("location_map");
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                my_lng = r.point.lng;
                my_lat = r.point.lat;
                // $(".more-list li em.location").each(function(){
                //     var pointA = new BMap.Point(my_lng, my_lat);  // 创建点坐标A
                //     var pointB = new BMap.Point($(this).data("lng"), $(this).data("lat"));  // 创建点坐标B
                //     var long = '<i class="iconfont">&#x1044;</i>'+(my_map.getDistance(pointA,pointB)).toFixed(0)+"米";
                //     $(this).html(long);
                // })
                var defurl = $(".dropload").data("defurl");
                var parurl = "lng="+my_lng+"&lat="+my_lat;
                if(defurl.indexOf("?") >= 0) {
                    parurl = "&" + parurl;
                } else {
                    parurl = "?" + parurl;
                }
                $(".dropload").data("defurl", defurl+parurl);
                $(".dropload").data("url", defurl+parurl);
                droploadInit();
            }else {
                console.log('failed'+this.getStatus());
            }
        },{enableHighAccuracy: true})
    } else{
        droploadInit();
    }

function droploadInit(){
    var moreLoading = $(".dropload");
    if (moreLoading.length) {
        Do("dropload", function(){
            //请求地址
            var ajax_url = moreLoading.data("url");
            //渲染模板
            var ajax_template = moreLoading.data("template");
            var count = 0;
            moreLoading.dropload({
                scrollArea : window,
                loadDownFn : function(me){
                    _dropLoad = me;
                    if($("#search_list").css("display") == "none") {
                        me.noData();
                    }
                    ajax_url = moreLoading.data("url");
                    if(ajax_url.indexOf("?")>=0) {
                        ajax_url = ajax_url + "&page="+page;
                    } else {
                        ajax_url = ajax_url + "?page="+page;
                    }
                    $.ajax({
                        type: 'GET',
                        url: ajax_url,
                        dataType: 'json',
                        success: function(data){
                            var moreHtml = "";
                            switch(ajax_template){
                                //新房列表
                                case "houseList" :
                                    for(var i in data.lists) {
                                        count++;

                                        // var pointA = new BMap.Point(my_lng, my_lat);  // 创建点坐标A
                                        // var pointB = new BMap.Point(data.lists[i].lng,data.lists[i].lat);  // 创建点坐标B
                                        // var long = (my_map.getDistance(pointA,pointB)).toFixed(0)+"米";

                                        moreHtml += '<li><a href="'+data.lists[i].link+'">'
                                        moreHtml += '   <div class="cover">'
                                        moreHtml += '         <img class="lazy" data-original="'+data.lists[i].pic+'">'
                                    if(data.lists[i].isActive == "1") {
                                        moreHtml += '         <div class="active"></div>'
                                    }
                                        moreHtml += '   </div>'
                                        moreHtml += '   <div class="info">'
                                        moreHtml += '       <div class="info-left">'
                                        moreHtml += '           <h2>'+data.lists[i].title+'</h2>'
                                    var className = "location"
                                    if(data.lists[i].description == "") {
                                        className = "location2"
                                        moreHtml += '           <p class="p3">'+data.lists[i].address+'</p>'
                                    } else {
                                        moreHtml += '           <p class="p1">'+data.lists[i].address+'</p>'
                                        moreHtml += '           <p class="p2">'+data.lists[i].description+'</p>'
                                    }
                                        moreHtml += '       </div>'
                                        moreHtml += '       <div class="info-right">'
                                        moreHtml += '           <em class="price">'+data.lists[i].price+'</em>'
                                        moreHtml += '           <em class="'+className+'" data-lng="'+data.lists[i].lng+'" data-lat="'+data.lists[i].lat+'"><i class="iconfont">&#x1044;</i> '+data.lists[i].location+'</em>'
                                        moreHtml += '       </div>'
                                        moreHtml += '       <div class="tags">'
                                        for(var j in data.lists[i].tags) {
                                            var index = data.lists[i].tags[j].type;
                                            var className = "green";

                                            if(index == 2) {
                                                className = "pink"
                                            } else if(index == 3) {
                                                className = "blue"
                                            } else if(index == 4) {
                                                className = "yellow"
                                            }

                                            moreHtml += '       <i class="'+className+'">'+data.lists[i].tags[j].name+'</i>'
                                        }
                                        moreHtml += '       </div>'
                                        moreHtml += '   </div>'
                                        moreHtml += '</a></li>'
                                    }
                                    break;
                                case "searchList" :
                                    var keywords = $(".title-bar").find("input[name=keywords]").val();
                                    // console.log(keywords)
                                    for(var i in data.lists) {
                                        count++;
                                        // var pointA = new BMap.Point(my_lng, my_lat);  // 创建点坐标A
                                        // var pointB = new BMap.Point(data.lists[i].lng,data.lists[i].lat);  // 创建点坐标B
                                        // var long = (my_map.getDistance(pointA,pointB)).toFixed(0)+"米";

                                        moreHtml += '<li>'
                                        moreHtml += '<a href="'+ data.lists[i].link +'">'
                                        moreHtml += '   <div class="cover">'
                                        moreHtml += '         <img class="lazy" data-original="'+data.lists[i].pic+'">'
                                    if(data.lists[i].isActive == "1") {
                                        moreHtml += '         <div class="active"></div>'
                                    }
                                        moreHtml += '   </div>'
                                        moreHtml += '   <div class="info">'
                                        moreHtml += '       <div class="info-left">'
                                        moreHtml += '           <h2>'+data.lists[i].title.replace(keywords,"<em>"+keywords+"</em>")+'</h2>'
                                    var className = "location"
                                    if(data.lists[i].description == "") {
                                        className = "location2"
                                        moreHtml += '           <p class="p3">'+data.lists[i].address+'</p>'
                                    } else {
                                        moreHtml += '           <p class="p1">'+data.lists[i].address+'</p>'
                                        moreHtml += '           <p class="p2">'+data.lists[i].description+'</p>'
                                    }
                                        moreHtml += '       </div>'
                                        moreHtml += '       <div class="info-right">'
                                        moreHtml += '           <em class="price">'+data.lists[i].price+'</em>'
                                        moreHtml += '           <em class="'+className+'" data-lng="'+data.lists[i].lng+'" data-lat="'+data.lists[i].lat+'"><i class="iconfont">&#x1044;</i> '+data.lists[i].location+'</em>'
                                        moreHtml += '       </div>'
                                        moreHtml += '       <div class="tags">'
                                        for(var j in data.lists[i].tags) {
                                            var index = data.lists[i].tags[j].type;
                                            var className = "green";

                                            if(index == 2) {
                                                className = "pink"
                                            } else if(index == 3) {
                                                className = "blue"
                                            } else if(index == 4) {
                                                className = "yellow"
                                            }

                                            moreHtml += '       <i class="'+className+'">'+data.lists[i].tags[j].name+'</i>'
                                        }
                                        moreHtml += '       </div>'
                                        moreHtml += '   </div>'
                                        moreHtml += '</a>'
                                        moreHtml += '</li>'
                                    }
                                    $(".search-result span").text(data.totalCount);
                                    break;
                                case "tjfList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml += '<li><a class="opacity" href="'+data.lists[i].link+'">'
                                        +'<div class="fang-village">'
                                        +'<div class="pic">'
                                        +'<img class="lazy" data-original="'+data.lists[i].pic+'" alt="">'
                                        +'<div class="cx-news">'+data.lists[i].sale+'</div>'
                                        +'</div>'
                                        + '<div class="info">'
                                        + ' <div class="name"><h2>'+data.lists[i].title+'</h2><span>均价'+data.lists[i].price+'</span></div>'
                                        + ' <p>'+data.lists[i].detail+'</p>'
                                        + '<p><strong class="oprice">'+data.lists[i].tprice+'/套</strong><del>'+data.lists[i].yprice+'</del></p>'
                                        //+ ' <i class="goarrow iconfont">&#x1020;</i>'
                                        + ' </div>'
                                        +'</div>'
                                        +'</a></li>';
                                    }
                                    break;
                                case "newsList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml +='<li>'+'<a class="opacity" href="'+data.lists[i].link+'">'
                                        +'<div class="pic">'
                                        +'<img class="lazy" data-original="'+data.lists[i].pic+'" alt="">'
                                        +'</div>'
                                        +'<div class="info">'
                                        +'<p>'+data.lists[i].title+'</p>'
                                        +'<p><span>'+data.lists[i].source+'</span><span>'+data.lists[i].time+'</span>'
                                        if(data.lists[i].ad) {
                                        moreHtml +='<em class="ad-lab">'+data.lists[i].ad+'</em></p>'
                                        }
                                        moreHtml +='</div>'
                                        +'</a>'
                                        +'</li>';
                                    }
                                    break;
                                case "knowledgeList" :
                                for(var i in data.lists) {
                                    count++;
                                    moreHtml +='<li>'+'<a class="opacity" href="'+data.lists[i].link+'">'
                                    +'<div class="pic">'
                                    +'<img class="lazy" data-original="'+data.lists[i].pic+'" alt="">'
                                    +'</div>'
                                    +'<div class="info">'
                                    +'<p>'+data.lists[i].title+'</p>'
                                    +'</div>'
                                    +'</a>'
                                    +'<div class="tags">'

                                    for(var j in data.lists[i].tags){

                                        moreHtml +='<a href="'+data.lists[i].tags[j].link+'">'+data.lists[i].tags[j].name+'</a>'
                                    }
                                    moreHtml +='</div>'
                                    +'</li>';
                                }
                                break;
                                case "reviewList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml +='<li>'
                                        +'<p><a href="">'+data.lists[i].detail+'</a></p>'
                                        +'<p>'
                                        +'<span>'+data.lists[i].name+'</span>'
                                        +'<span>'+data.lists[i].date+'</span>'
                                        +'<span>'+data.lists[i].time+'</span>'
                                        +'</p>'
                                        +'</li>';
                                    }
                                    break;
                                case "dianpingList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml +='<li>'
                                        +'<p><span>楼盘名称：</span>'+data.lists[i].title+'</p>'
                                        +'<p><span>楼盘分析：</span>'+data.lists[i].content+'</p>'
                                        +'</li>';
                                    }
                                    break;
                                case "schoolList" :
                                    for(var i in data.lists) {
                                        count++;
                                        // var pointA = new BMap.Point(my_lng, my_lat);  // 创建点坐标A
                                        // var pointB = new BMap.Point(data.lists[i].lng,data.lists[i].lat);  // 创建点坐标B
                                        // var long = (my_map.getDistance(pointA,pointB)).toFixed(0)+"米";

                                        moreHtml += '<li><a href="'+data.lists[i].link+'">'
                                        moreHtml += '   <div class="cover">'
                                        moreHtml += '         <img class="lazy" data-original="'+data.lists[i].pic+'">'
                                    if(data.lists[i].isActive == "1") {
                                        moreHtml += '         <div class="active"></div>'
                                    }
                                        moreHtml += '   </div>'
                                        moreHtml += '   <div class="info">'
                                        moreHtml += '       <div class="info-left">'
                                        moreHtml += '           <h2>'+data.lists[i].title+'</h2>'
                                    var className = "location"
                                    if(data.lists[i].description == "") {
                                        className = "location2"
                                        moreHtml += '           <p class="p3">'+data.lists[i].address+'</p>'
                                    } else {
                                        moreHtml += '           <p class="p1">'+data.lists[i].address+'</p>'
                                        moreHtml += '           <p class="p2">'+data.lists[i].description+'</p>'
                                    }
                                        moreHtml += '       </div>'
                                        moreHtml += '       <div class="info-right">'
                                        moreHtml += '           <em class="price">'+data.lists[i].price+'</em>'
                                        moreHtml += '           <em class="'+className+'" data-lng="'+data.lists[i].lng+'" data-lat="'+data.lists[i].lat+'"><i class="iconfont">&#x1044;</i> '+data.lists[i].location+'</em>'
                                        moreHtml += '       </div>'
                                        moreHtml += '       <div class="tags">'
                                        for(var j in data.lists[i].tags) {
                                            var index = data.lists[i].tags[j].type;
                                            var className = "green";

                                            if(index == 2) {
                                                className = "pink"
                                            } else if(index == 3) {
                                                className = "blue"
                                            } else if(index == 4) {
                                                className = "yellow"
                                            }

                                            moreHtml += '       <i class="'+className+'">'+data.lists[i].tags[j].name+'</i>'
                                        }
                                        moreHtml += '       </div>'
                                        moreHtml += '   </div>'
                                        moreHtml += '</a></li>'
                                    }
                                    break;
                                case "schoolindexList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml +='<li>'+'<a class="opacity" href="'+data.lists[i].link+'">'
                                        +'<div class="pic">'
                                        +'<img class="lazy" data-original="'+data.lists[i].pic+'" alt="">'
                                        +'</div>'
                                        +'<div class="info">'
                                        +'<h3>'+data.lists[i].schoolname+'</h3>'
                                        +'<p class="">'+data.lists[i].area+'</p>'
                                        +'<p class="gc6">'+'共'+'<span class="c-red">'+data.lists[i].nub+'</span>'+'个楼盘'+'</p>'
                                        +'</div>'
                                        +'</a>'
                                        +'</li>';
                                    }
                                    break;
                                case "qaList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml +='<dl>'
                                        +'<dt class="wen">'+'<a href="'+data.lists[i].link+'">'+data.lists[i].wen+'</a>'+'</dt>'
                                        +'<dd class="timeblock">'+'<a href="'+data.lists[i].link2+'">'+data.lists[i].menu2+'</a>'
                                        +'&gt'+'<a href="'+data.lists[i].link3+'">'+data.lists[i].menu3+'</a>'
                                        +'<span class="time">'+data.lists[i].time+'</span>'
                                        +'</dd>'
                                        +'</dl>';
                                    }
                                    break;
                                case "thfList":
                                    for(var i in data.lists){
                                        count++;
                                        moreHtml += '<li>'
                                        + '<a href="'+data.lists[i].link+'">'
                                        + '<div class="fang-village">'
                                        + '<div class="pic">'
                                        + '<img class="lazy" data-original="'+data.lists[i].pic+'" alt="" />'
                                        + '</div>'
                                        + '<div class="info">'
                                        + '<p class="discount">'+data.lists[i].title+'</p>'
                                        + '<div class="name"><h2>'+data.lists[i].name+'</h2><span>均价'+data.lists[i].price+'</span></div>'
                                        + '<p class="news"><span><em>'+data.lists[i].num+'</em>人已抢到</span>  <span>'+data.lists[i].over+'</span></p>'
                                        + '</div>'
                                        + '</div>'
                                        + '</a>'
                                        + '</li>';
                                    }
                                    break;
                                case "kftList" :
                                    for(var i in data.lists) {
                                        count++;
                                        moreHtml += '<li>'
                                        moreHtml += '    <div class="baseinfo">'
                                        moreHtml += '        <h3>'+data.lists[i].title+'</h3>'
                                        moreHtml += '        <p class="time"><i class="iconfont icon-time"></i>'+data.lists[i].time+'</p>'
                                        moreHtml += '        <p class="address"><i class="iconfont icon-map"></i>'+data.lists[i].addr+'</p>'
                                        moreHtml += '    </div>'
                                        moreHtml += '    <ul class="progress">'
                                        for(var j in data.lists[i].progress) {
                                        moreHtml += '        <li>'
                                        moreHtml += '            <a href="'+data.lists[i].progress[j].link+'">'
                                        moreHtml += '                <div class="fang-village">'
                                        moreHtml += '                    <div class="pic"><img class="lazy" data-original="'+data.lists[i].progress[j].img+'" alt="" /></div>'
                                        moreHtml += '                    <div class="info">'
                                        moreHtml += '                        <h3>'+data.lists[i].progress[j].title+'</h3>'
                                        moreHtml += '                        <p class="price em-1">'+data.lists[i].progress[j].price+'</p>'
                                        moreHtml += '                        <p class="address">'+data.lists[i].progress[j].addr+'</p>'
                                        if(data.lists[i].progress[j].desc == "") {
                                            moreHtml += '       <div class="tags">'
                                            for(var k in data.lists[i].progress[j].tags) {
                                                var index = data.lists[i].progress[j].tags[k].type;
                                                var className = "green";

                                                if(index == 2) {
                                                    className = "pink"
                                                } else if(index == 3) {
                                                    className = "blue"
                                                } else if(index == 4) {
                                                    className = "yellow"
                                                }

                                                moreHtml += '       <i class="'+className+'">'+data.lists[i].progress[j].tags[k].name+'</i>'
                                            }
                                            moreHtml += '       </div>'
                                        } else {
                                        moreHtml += '                        <p class="yh em-1">'+data.lists[i].progress[j].desc+'</p>'
                                        }
                                        moreHtml += '                    </div>'
                                        moreHtml += '                </div>'
                                        moreHtml += '            </a>'
                                        moreHtml += '        </li>'
                                        }
                                        moreHtml += '    </ul>'
                                        moreHtml += '    <div class="calnum">'
                                        moreHtml += '        <ul class="row">'
                                        moreHtml += '          <li class="button normal-button">'+data.lists[i].bm_num+'人已报名</li>'
                                        if(data.lists[i].bm_state == "1") {
                                        moreHtml += '          <li><a href="'+data.lists[i].bm_link+'" class="button baoming-button">我要报名</a></li>'
                                        } else {
                                        moreHtml += '          <li><a href="javascript:void(0)" class="button dis-baoming-button">活动已结束</a></li>'
                                        }
                                        moreHtml += '        </ul>'
                                        moreHtml += '    </div>'
                                        moreHtml += '</li>'
                                    }
                                    break;

                            }

                            if( page >= parseInt(data.totalPage)) {
                                // 锁定
                                me.lock();
                                // 无数据
                                me.noData();
                            }
                            page++;

                            // 为了测试，延迟1秒加载
                            setTimeout(function(){
                                $(".more-list").append(moreHtml).find('img.lazy').lazyload({
                                    effect : "fadeIn" ,
                                    placeholder: noPicUrl,
                                    threshold: wh,
                                    failure_limit:100,
                                    skip_invisible:false
                                });
                                // 每次数据加载完，必须重置
                                me.resetload();

                                if (count == 0) {
                                    $(".dropload-noData").html("暂无数据");
                                }
                                count = 0;
                                $(".page-loader").fadeOut();

                            },0);
                        },
                        error: function(xhr, type){
                            alert('Ajax error!');
                            // 即使加载出错，也得重置
                            me.resetload();
                        }
                    });
                }
            });
        })
    }
}
var $menu = $('.ui-menu');
if($menu.length){
    var $menu_tabs = $menu.find('li');
    var $submenus = $('.ui-submenu');
    var $type_two = $('.ui-type-two');
    var $layer = $('.mask');

    //一级菜单
    $menu_tabs.each(function(i) {
        var $self = $(this);
        $self.data('idx', i);
        $self.click(function() {
            var idx = $self.data('idx');
            var flag = $self.hasClass('ui-active');
            //关闭所有
            $menu_tabs.find('i').html("&#x2035;");
            $menu_tabs.removeClass('ui-active');
            $submenus.hide();
            //重新开启
            if(flag){
                $self.removeClass('ui-active');
                $self.find('i').html("&#x2035;");
                $submenus.eq(idx).hide();
                $layer.hide();
            }else{
                $self.addClass('ui-active');
                $self.find('i').html("&#x1001;");
                $submenus.eq(idx).show();
                $layer.show();
            }
        });
        $(".mask").on("click", function(){
            $(this).hide();
            $menu_tabs.find('i').html("&#x2035;");
            $menu_tabs.removeClass('ui-active');
            $submenus.hide();
        })
    });

    //二级菜单
    $type_two.each(function() {
        var $self = $(this);
        var $lis  = $self.find('>li');
        $lis.click(function() {
            var $self = $(this);
            $self.toggleClass('ui-active').siblings().removeClass('ui-active');
            return false;
        });
        $lis.find('.ui-long li').click(function(e) {
            e.stopPropagation();
            $(this).parent().find("li").removeClass("ui-active");
        });
    });

    $(".ui-long li").on("click", function(){
        $(this).parent().find("li").removeClass("ui-active");
        $(this).addClass("ui-active");
        $(".ui-menu .ui-active span").text($(this).find("em").text());
        $(".ui-submenu").hide();
        $(".mask").hide();
        changeScroll(false);
    })
}

/* 菜单 end*/

});
