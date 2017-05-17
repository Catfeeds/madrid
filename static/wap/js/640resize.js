    var browser={
        versions:function(){
            var u = navigator.userAgent.toLowerCase(), app = navigator.appVersion.toLowerCase();
            return {
                trident: u.indexOf('trident') > -1, //IE内核
                presto: u.indexOf('presto') > -1, //opera内核
                webKit: u.indexOf('applewebKit') > -1, //苹果、谷歌内核
                gecko: u.indexOf('gecko') > -1 && u.indexOf('khtml') == -1,//火狐内核
                mobile: !!u.match(/applewebkit.*mobile.*/), //是否为移动终端
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                android: u.indexOf('android') > -1 || u.indexOf('linux') > -1, //android终端或者uc浏览器
                iPhone: u.indexOf('iphone') > -1 , //是否为iPhone或者QQHD浏览器
                iPad: u.indexOf('ipad') > -1, //是否iPad
                webApp: u.indexOf('safari') == -1, //是否web应该程序，没有头部与底部
                weixin: u.indexOf('micromessenger') > -1, //是否微信 （2015-01-22新增）
                qq: u.match(/\sqq/i) == " qq" //是否QQ
            };
        }(),
        language:(navigator.browserLanguage || navigator.language).toLowerCase()
    };

    function isInApp(){
        var index = navigator.userAgent.indexOf('QianFan');
        if(index == -1){
            return false;
        }else{
            return true;
        }
    }

    if(isInApp()){
        if(browser.versions.android){
            var app_code = getcookie('qianfan_appcode');
            //如果存在
            if(app_code){
                var int_app_code = parseInt(app_code.replace(/\./g,''));
                if(int_app_code < 140){
                    document.write('<meta name="viewport" content="width=640, minimum-scale = 1, maximum-scale = 1, target-densitydpi=device-dpi">');
                    function init_rem(){
                        var phoneScale = parseInt(window.screen.width)/640;
                        var irate=625;
                        var iw=640;
                        var w= document.documentElement.clientWidth;
                        var doc = document;
                        var irate= 625/(iw/w);
                        var str='html{width:640px;zoom:' + phoneScale + '}body{width:640px;}';
                        var style = doc.createElement('style');
                        style.innerHTML = str;
                        doc.querySelector('head').appendChild(style);
                    }
                    init_rem();
                }else{
                    var phonescale = parseInt(window.screen.width)/640;
                    document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phonescale +', maximum-scale = '+ phonescale +', target-densitydpi=device-dpi">');
                }
            }else{
                var phonescale = parseInt(window.screen.width)/640;
                document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phonescale +', maximum-scale = '+ phonescale +', target-densitydpi=device-dpi">');
            }
        }else{
            var phonescale = parseInt(window.screen.width)/640;
            document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phonescale +', maximum-scale = '+ phonescale +', target-densitydpi=device-dpi">');
        }
    }else{
        var phonescale = parseInt(window.screen.width)/640;
        document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phonescale +', maximum-scale = '+ phonescale +', target-densitydpi=device-dpi">');
    }

    function getcookie(name){  
        var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));  
        if(arr != null){  
            return (arr[2]);  
        }else{  
            return "";  
        }  
    } 
