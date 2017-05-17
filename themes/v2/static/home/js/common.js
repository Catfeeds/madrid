Do.add('DD_belatedPNG', {
    path: basedir+'DD_belatedPNG.js',
    type: 'js'
});
Do.add('lazyload', {
    path: basedir+'jquery-lazyload/jquery.lazyload.js',
    type: 'js'
});
Do.add('LiveSeach', {
    path: basedir+'LiveSearch/livesearch.min.js',
    type: 'js'
});

var Browser = {};
var ua = navigator.userAgent.toLowerCase();
var s;
(s = ua.match(/msie ([\d.]+)/)) ? Browser.ie = s[1] : 0;

Do.ready(function(){
    /*登录 begin*/
    var $loginBox = $(".login-pop-up");
    $(".login-trigger").on('click', function(e){
        if($loginBox.is(":hidden")){
            $loginBox.fadeIn();
        } else {
            $loginBox.fadeOut();
        }
        e.preventDefault();
        e.stopPropagation();
    });
    $loginBox.on('click',function(e){
        e.stopPropagation();
    });
    $(document).on('click',function(){
        if($loginBox && !$loginBox.is(":hidden")){
            $loginBox.fadeOut();
        }
    });
    $(".userLogin").on("click", function(){
        var nickname = $loginBox.find('input[name="nickname"]').val(),
            pwd = $loginBox.find('input[name="pwd"]').val(),
            expireTime;
        if($loginBox.find('input[name="remember"]').attr("checked") == true){
            expireTime = 86400 * 30;
        }
        //验证
        if(nickname=="" || pwd==""){
            $loginBox.find(".login_msg").text("登录名和密码不能为空").show();
        }
        $.ajax({
            type: 'POST',
            url:loginUrl,
            dataType: 'json',
            data: {
                username:nickname,
                password:pwd,
                expireTime: expireTime
            },
            success: function(data){
                if(data.code){
                    location.reload();
                } else {
                    $loginBox.find(".login_msg").text("登录名或密码错误").show();
                }
            }
        });
    });

    $(document).on('keydown', function (e) {
        if(e.keyCode==13){
            if(!$(".login-pop-up").is(":hidden"))
                $(".userLogin").trigger("click");
        }
    });

$.getJSON(userinfoUrl + '?jsoncallback=?',  function(info){
    if(info.code){
     var userinfo = info.msg.userinfo;
        var infoStr = '<li><a title="' + userinfo.username + '" href="">'
            + '<img class="avatar" src="' + userinfo.icon +'">' + userinfo.username + '</a></li>'
            +'<li class="personal-select"><a title="个人中心" href="' +userCenterUrl.replace('{username}', userinfo.username) + '" target="_blank">个人中心<i class="head-icon arrowdown fr">&nbsp;</i></a>'
            +'<ul class="dropdown_info_box personal_center">';
            $(info.msg.menu).each(function(index){
                infoStr += '<li><a href="' + this.url.replace('{username}', userinfo.username).replace('{id}', userinfo.uid) + '">' + this.name + '</a></li>';
            });
            infoStr += '<li class="last"><a href="' + logoutUrl + '">帐号退出</a></li>';
            infoStr += '</ul></li>';
            $("#userlogin").html(infoStr);
    }
 });

    /*登录 end*/

	if (Browser.ie == "6.0") {
        Do('DD_belatedPNG',function(){
            DD_belatedPNG.fix('.head-icon');
			DD_belatedPNG.fix('.icon');
			DD_belatedPNG.fix('.index-icon');			
        });
    }
    

	/*滚动*/
	//Do('scrollbar');
    //Do('lazyload', function(){
            //$("img.lazy").lazyload({
                //effect : "fadeIn",
                //placeholder:siteSettings.noPicUrl
            //});
    //});

    /*$('.bm-form-ul input').keydown(function(){
        $(this).siblings().html('');
        $(this).removeClass('focus');
    });*/
    /*头部搜索开始*/
    var searchInput = $('#searchtxt');
    if(0){
    //if(searchInput.length > 0){
        $('#search-select').mouseenter(function(){
            $('.action-select').show();
        }).mouseleave(function(){
            $('.action-select').hide();
        });

        $('.action-select li').click(function(){
            $('.action-select').hide();
            var self = $(this);
            //searchInput.focus();
            $('.cur-selected').text(self.text());
            //searchInput.attr('data-ui',"u-placeholder|" + self.attr('data-placeholder'));
            searchInput.placeholder({
                word: self.attr('data-placeholder')
            });
            $(this).parents("form").attr("action", self.data("url"));
            if(self.attr("data-type")){
                if(self.attr("data-type") == "shop"){
                    LiveSearch.init(searchInput, {url: '/api/shop/list?parent=2&kw=',formatResult: function(obj){
                        return  '<li><a href="s' + obj.id + '">' + obj.name + '</a></li>';
                    }});
                } else if(self.attr("data-type") == "plot") {
                    LiveSearch.init(searchInput, {url: '/api/plot/list?kw=',formatResult: function(obj){
                        return  '<li><a href="/xiaoqu/' + obj.id + '">' + obj.name + '<span class="fr">装修案例（' + obj.xgtCount + '）</span></a></li>';
                    }});
                } else if(self.attr("data-type") == 'building'){
                    /*LiveSearch.init(searchInput, {url: '/api/shop/list?parent=1&kw=',formatResult: function(obj){
                        return  '<li><a href="/building/s/?id=' + obj.id + '">' + obj.name + '</a></li>';
                    }});*/
                    LiveSearch.init(searchInput, {url: '/api/shop/list?parent=2&kw=',formatResult: function(obj){
                        return  '<li><a href="s' + obj.id + '">' + obj.name + '</a></li>';
                    }});
                }
            } else {
                LiveSearch.destroy();
            }
        });

        Do('LiveSeach',function(){
            //默认找装修公司
            if(searchInput.attr('data-type') == 'shop'){
                LiveSearch.init(searchInput, {url: '/api/shop/list?parent=2&kw=',formatResult: function(obj){
                    return  '<li><a href="/s' + obj.id + '">' + obj.name + '</a></li>';
                }});
            } else if(searchInput.attr('data-type') == 'plot'){
                LiveSearch.init(searchInput, {url: '/api/plot/list?kw=',formatResult: function(obj){
                    return  '<li><a href="/xiaoqu/' + obj.id + '">' + obj.name + '<span class="fr">装修案例（' + obj.xgtCount + '）</span></a></li>';
                }});
            } else if(searchInput.attr('data-type') == 'building'){
                /*(LiveSearch.init(searchInput, {url: '/api/shop/list?parent=1&kw=',formatResult: function(obj){
                    return  '<li><a href="/building/s' + obj.id + '">' + obj.name + '</a></li>';
                }});*/
                LiveSearch.init(searchInput, {url: '/api/shop/list?parent=2&kw=',formatResult: function(obj){
                    return  '<li><a href="/s' + obj.id + '">' + obj.name + '</a></li>';
                }});
            } else {
                LiveSearch.destroy();
            }

        });
        $(".searchbut").on('click', function(e){
            var plas = ['挑选你心仪的装修公司','找自己小区工地，看真实装修案例','海量精美效果图任你选','挑选你心仪的建材公司','了解装修相关的资讯知识'];
            if(searchInput.val() == "" || ($.inArray(searchInput.val(),plas) >= 0)){
                e.preventDefault();
            }
        });
        /*头部搜索结束*/
    }
});
