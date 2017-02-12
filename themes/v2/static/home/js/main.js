Do.add('jquery',{
    type : 'js',
    path : basedir + 'lib/jquery.min.js'
});
Do.add('placeholder',{
    type : 'js',
    path : basedir + 'extend/jquery.placeholder.min.js'
});
Do.add('form',{
    type : 'js',
    path : basedir + 'extend/form.js'
});
Do.add('lazyload',{
    type : 'js',
    path : basedir + 'extend/jquery.lazyload.min.js'
});
Do.add('extendjs',{
    type : 'js',
    path : basedir + 'extend.js'
});

Do.add('SuperSlide',{
    type : 'js',
    path : basedir + 'extend/jquery.SuperSlide.2.1.1.js'
});

Do.add('cal',{
    type : 'js',
    path : basedir + 'extend/cal.js'
});

Do.add('dialog-css',{
    type : 'css',
    path : basedir + 'extend/dialog.css'
});
Do.add('dialog',{
    type : 'js',
    path : basedir + 'extend/dialog.js'
});
Do.add('validform',{
    type : 'js',
    path : basedir + 'extend/validform.min.js'
});
Do.add('layer',{
    type : 'js',
    path : basedir + 'extend/layer.js',
    requires : ['layer-css']
});
Do.add('layer-css',{
    type : 'css',
    path : basedir + 'skin/layer.css'
});
Do.add('map',{
    type : 'js',
    path : basedir + 'extend/map.js'
});
Do.add('charts',{
    type : 'js',
    path : basedir + 'extend/charts.js'
});
Do.add('jqueryui',{
    type : 'js',
    path : basedir + 'jquery-ui.min.js'
});
Do.add('template',{
    type : 'js',
    path : basedir + 'template.js'
});

Do.add('highcharts',{
    type : 'js',
    path : basedir + 'extend/highcharts/highcharts.min.js'
});

Do.add('select',{
    type : 'js',
    path : basedir + 'selectordie.js',
    requires : ['select-css','select-css-theme']
});
Do.add('select-css',{
    type : 'css',
    path : basedir + 'selectordie.css'
});
Do.add('select-css-theme',{
    type : 'css',
    path : basedir + 'selectordie_theme_01.css'
});
Do.add('director',{
    type : 'js',
    path : basedir + 'director.min.js'
});

(function(window) {
    window.hj = {};
    window.global = {};
    //basedir = './js/';
    Do('jquery','placeholder','form','lazyload',function() {
         //添加拓展的JS
         Do('extendjs');

        //拓展的代码，分区
        var $otherweb = $('.other-web');
        $otherweb.each(function() {
            var $self = $(this);
            var title = $self.find('p');
            var content = $self.find('ul');
            $self.hover(function() {
                content.show();
            },function() {
                content.hide();
            })
        });

        if($('.hj-picScroll-left,.plot-slider,#slider').length > 0){
            //轮播
            Do('SuperSlide',function() {
                jQuery(".hj-picScroll-left").each(function() {
                    var datanum = $(this).data('num') || 4;
                    $(this).slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",scroll:1,vis:datanum});
                });
                jQuery(".plot-slider").slide({titCell:".hd ul li",mainCell:".bd",effect:"left", titOnClassName:'current', trigger:'click',autoPlay:false,interTime:3500,prevCell:null,nextCell:null});
                jQuery(".plot-slider").slide({mainCell:".hd ul",titCell:'.hd .autopages',vis:4,effect:"left", autoPage:true, autoPlay:false});
                //暂时解决BUG
                $('.plot-slider').find('.big-img img').each(function() {
                    var $self = $(this);
                    $self.prop('src',$self.data('original'));
                });
                if($('.txtMarquee-top').length){
                    jQuery(".txtMarquee-top").slide({mainCell:".bd ul",autoPlay:true,effect:"topMarquee",vis:5,interTime:50});
                }
                if($('#slider').length){
                    jQuery("#slider").slide({titCell:".hd ul",mainCell:"ul.bd",autoPage:true,effect:"fold",vis:1,autoPlay:true}); 
                }
       
            });
        }

        $(".school-info .more").bind("click", function (e) {
            e.preventDefault();
            var self = $(this);
            self.siblings(".detail").toggleClass("limit");
            if (self.text() == "更多") {
                self.text("收起");
            } else {
                self.text("更多");
            }
        });
         $('.raiders').mouseenter(function(){
            $(this).find('.cbox').addClass('on');
            $(this).find('.lis').show();    
        }).mouseleave(function(){        
            $(this).find('.cbox').removeClass('on');    
            $(this).find('.lis').hide();    
        });

        
        $(".dropdown_toggle").hover(function(){
            $(this).siblings(".dropdown-menu").show();
        },function(){
            $(this).siblings(".dropdown-menu").hide();
        });
        $(".dropdown-menu").hover(function(){
            $(this).show();
        },function(){
            $(this).hide();
        });
        //弹框
        //if($('.k-btn-1,.dialog-open-btn,.ui-mouseenter a.join, .k-dialog-type-1, .k-dialog-type-2').length > 0){
        if($('.ui-baoming-form,.k-dialog-type-1, .k-dialog-type-2,.k-cal-1,.k-cal-2,.k-cal-3,.k-cal-4,.kanfangform,.ui-question-form,.k-dialog-phone').length > 0){
            Do('cal','dialog-css','dialog','validform','layer',function() {
                //重置表单内容，去除错误信息，高亮显示
                function F_reset_valid_form($form){
                    $form.find('input[type="text"],input[type="tel"]').val('');
                    $form.find('input.focus').removeClass('focus');
                    $form.find('.error-box').hide();
                }

                 //房贷
                var cal_1_dom = null;
                var cal_1 = hj.Dialog({templateid:2,onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input,textarea').placeholder();
                    cal_1_dom = hj.calculate.houseloan(dom);
                },width:765,onBeforeOpen:function() {
                    cal_1_dom.reset();
                }});
                //税费
                var cal_2_dom = null;
                var cal_2 = hj.Dialog({templateid:3,onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input,textarea').placeholder();
                    cal_2_dom = hj.calculate.tax(dom);
                },width:765,onBeforeOpen:function() {
                    cal_2_dom.reset();
                }});
                //购房能力
                var cal_3_dom = null;
                var cal_3 = hj.Dialog({templateid:4,onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input,textarea').placeholder();
                    cal_3_dom = hj.calculate.housebuy(dom);
                },width:765,onBeforeOpen:function() {
                    cal_3_dom.reset();
                }});
                //公积金
                var cal_4_dom = null;
                var cal_4 = hj.Dialog({templateid:5,onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input,textarea').placeholder();
                    cal_4_dom = hj.calculate.publickfundloan(dom);
                },width:765,onBeforeOpen:function() {
                    cal_4_dom.reset();
                }});

                //提交成功弹框
                var dlok = hj.Dialog({templateid:6,onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('.state-btn').click(function() {
                        dlok.close();
                    });
                }});
                //提交失败弹框
                var dlerror  = hj.Dialog({templateid:7,onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('.state-btn').click(function() {
                        dlerror.close();
                    });
                }});


                //无备注弹框
                var dl = hj.Dialog({templateid:0, title:'测试标题',onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input[placeholder],textarea[placeholder]').placeholder();

                    dom.find('.ui-checkform').Validform({
                        tiptype:function(msg,o,cssctl){
                            if(o.type === 3){
                                layer.tips(msg,o.obj,{
                                    tips:[1,'#da5c4f']
                                });
                            }
                        },
                        beforeSubmit:function() {
                            var data = dl.getData();
                            var name = dom.find('.name input').val();
                            var phone = dom.find('.phone input').val();
                            var spm = data.spm;
                            var note = '';
                            var csrf = data.csrf;
                            $.post(orderApi,{
                                name : name,
                                phone : phone,
                                spm : spm,
                                note : note,
                                csrf : csrf
                            },function(data) {
                                dl.close();
                                dl.reset();
                                //提交成功
                                if(data.code){
                                    dlok.open();
                                    //console.log(data.msg);
                                }else{
                                //提交失败
                                    dlerror.setNote(data.msg);
                                    dlerror.open();
                                    //console.log(data.msg);
                                }
                            },'json');
                            return false;
                        }
                    });

                    dom.find('input[type="checkbox"]').change(function() {
                        if($(this).prop('checked')){
                            dom.find('input[type="submit"]').removeClass('disabled').prop('disabled',false);
                        }else{
                            dom.find('input[type="submit"]').addClass('disabled').prop('disabled',true);
                        }
                    }).change();

                    dom.find('.ui-checkform .ui-check-ele').each(function() {
                        var $msg = $('<div class="ui-check-errormsg"></div>');
                        $(this).append($msg);
                    });
                }});
                var dl2 = hj.Dialog({templateid:1, title:'测试标题',onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input[placeholder],textarea[placeholder]').placeholder();

                    dom.find('.ui-checkform').Validform({
                        tiptype:function(msg,o,cssctl){
                            if(o.type === 3){
                                layer.tips(msg,o.obj,{
                                    tips:[1,'#da5c4f']
                                });
                            }
                        },
                        beforeSubmit:function() {
                            var data = dl.getData();
                            var name = dom.find('.name input').val();
                            var phone = dom.find('.phone input').val();
                            var spm = data.spm;
                            var note = dom.find('.note input').val();
                            var csrf = data.csrf;
                            $.post(orderApi,{
                                name : name,
                                phone : phone,
                                spm : spm,
                                note : note,
                                csrf : csrf
                            },function(data) {
                                dl2.close();
                                dl2.reset();
                                //提交成功
                                if(data.code){
                                    dlok.open();
                                    //console.log(data.msg);
                                }else{
                                //提交失败
                                    dlerror.setNote(data.msg);
                                    dlerror.open();
                                    //console.log(data.msg);
                                }
                            },'json');
                            return false;
                        }

                    });


                    dom.find('input[type="checkbox"]').change(function() {
                        if($(this).prop('checked')){
                            dom.find('input[type="submit"]').removeClass('disabled').prop('disabled','disabled');
                        }else{
                            dom.find('input[type="submit"]').addClass('disabled').prop('disabled',false);
                        }
                    }).change();

                    dom.find('.ui-checkform .ui-check-ele').each(function() {
                        var $msg = $('<div class="ui-check-errormsg"></div>');
                        $(this).append($msg);
                    });
                }});

                var dl3 = hj.Dialog({templateid:8, title:'测试标题',onInit:function(dialog) {
                    var dom = dialog.getDom();
                    dom.find('input[placeholder],textarea[placeholder]').placeholder();

                    dom.find('.ui-checkform').Validform({
                        tiptype:function(msg,o,cssctl){
                            if(o.type === 3){
                                layer.tips(msg,o.obj,{
                                    tips:[1,'#da5c4f']
                                });
                            }
                        },
                        datatype:{
                            'identifycode':function(gets,obj,curform,regxp){
                                //异步请求验证是否为正确的验证码
                                if('undefined' === typeof captchacheck){
                                    captchacheck = '/home/plot/validateCaptcha';
                                }
                                if(gets.length === 0) return false;

                                $.post(captchacheck,{
                                    'captcha' : gets
                                },function(data) {
                                    if(data['status']){
                                        obj.parent().next().hide();
                                        $("#yzm").data('is_check',true);
                                    }else{
                                        layer.tips('验证码错误',obj,{
                                        tips:[1,'#da5c4f']
                                        });
                                        $("#yzm").data('is_check',false);
                                        return false;
                                    }
                                },'json');
                            }
                        },
                        beforeSubmit:function() {

                            if(!$('#yzm').data('is_check')){
                                return false;
                            }

                            var data = dl3.getData();
                            var name = dom.find('.name input').val();
                            var phone = dom.find('.phone input').val();
                            var spm = data.spm;
                            var note = dom.find('.note input').val();
                            var csrf = dom.find('#yzm input').val();
                            $.post(orderApi,{
                                name : name,
                                phone : phone,
                                spm : spm,
                                note : note,
                                csrf : csrf
                            },function(data) {
                                dl3.close();
                                dl3.reset();
                                //提交成功
                                if(data.code){
                                    dlok.open();
                                    //console.log(data.msg);
                                }else{
                                //提交失败
                                    dlerror.setNote(data.msg);
                                    dlerror.open();
                                    //console.log(data.msg);
                                }
                            },'json');
                            return false;
                        }

                    });


                    dom.find('input[type="checkbox"]').change(function() {
                        if($(this).prop('checked')){
                            dom.find('input[type="submit"]').removeClass('disabled').prop('disabled','disabled');
                        }else{
                            dom.find('input[type="submit"]').addClass('disabled').prop('disabled',false);
                        }
                    }).change();

                    dom.find('.ui-checkform .ui-check-ele').each(function() {
                        var $msg = $('<div class="ui-check-errormsg"></div>');
                        $(this).append($msg);
                    });
                }});


                //$('.k-btn-1,.dialog-open-btn').click(function() {
                    //dl.open();
                    //return false;
                //});

                //$('.ui-mouseenter a.join').click(function() {
                    //dl.open();
                    //return false;
                //});
                $('.k-dialog-type-1:not(".disabled")').click(function() {
                    var $self = $(this);
                    var data = {
                        spm : $self.data('spm'),
                        url : $self.data('url'),
                        csrf : window.csrf
                    }
                    dl.setTitle($self.data('title'));
                    dl.setData(data);
                    dl.reset();
                    dl.open();
                    return false;
                });

                $('.k-dialog-type-2:not(".disabled")').click(function() {
                    var $self = $(this);
                    var data = {
                        spm : $self.data('spm'),
                        url : $self.data('url'),
                        csrf : window.csrf
                    }
                    dl2.setTitle($self.data('title'));
                    dl2.setData(data);
                    dl2.reset();
                    dl2.open();
                    return false;
                });

                //打电话弹框
                $('.k-dialog-phone:not(".disabled")').click(function() {
                    var $self = $(this);
                    var data = {
                        spm : $self.data('spm'),
                        url : $self.data('url'),
                        csrf : window.csrf
                    }
                    var dom = dl3.getDom();
                    dom.find('.desc em').text($self.data('name'));
                    dom.find('.desc span').text($self.data('tel'));
                    dl3.setTitle($self.data('title'));
                    dl3.setData(data);
                    dl3.reset();
                    dl3.open();
                    return false;
                });


                //房贷计算器
                $('.k-cal-1').click(function() {
                    window.calculate_url = $(this).attr("data-href");
                    cal_1.open();
                    return false;
                });
                //税费计算器
                $('.k-cal-2').click(function() {
                    cal_2.open();
                    return false;
                });
                //购房能力评估
                $('.k-cal-3').click(function() {
                    cal_3.open();
                    return false;
                });
                //公积金贷款计算器
                $('.k-cal-4').click(function() {
                    window.calculate_url = $(this).attr("data-href");
                    cal_4.open();
                    return false;
                });

                /* 看房团 form begin */
                var $form = $('.kanfangform');
                $form.Validform({
                    tiptype:function(msg,o,cssctl){
                        if(o.type === 3){
                            layer.tips(msg,o.obj,{
                                tips:[1,'#da5c4f']
                            });
                        }
                    },
                    beforeSubmit:function() {

                        var data = $form.serializeArray();
                        var url = $form.prop('action');
                        $.post(url,data,function(data) {
                            //提交成功
                            if(data.code){
                                dlok.open();
                                $form.get(0).reset();
                                //console.log(data.msg);
                            }else{
                            //提交失败
                                dlerror.setNote(data.msg);
                                dlerror.open();
                                //console.log(data.msg);
                            }
                        },'json')
                        return false;
                    }
                });

                /* 看房团 form end */

                /* 问题 表单 begin*/
                var $forms = $('.ui-question-form');
                $forms.each(function() {
                    var $form = $(this);
                    $form.Validform({
                        tiptype:function(msg,o,cssctl){
                            if(o.type === 3){
                                layer.tips(msg,o.obj,{
                                    tips:[1,'#da5c4f']
                                });
                            }
                        },
                        beforeSubmit:function() {
                            var data = $form.serializeArray();
                            var url = $form.prop('action');
                            $.post(url,data,function(data) {
                                //提交成功
                                if(data.code){
                                    dlok.open();
                                    $form.get(0).reset();
                                    //console.log(data.msg);
                                }else{
                                //提交失败
                                    dlerror.setNote(data.msg);
                                    dlerror.open();
                                    //console.log(data.msg);
                                }
                            },'json')
                            return false;
                        }
                    });
                });
                /* 问题 表单 end*/
                /* 报名 表单 begin*/
                var $forms = $('.ui-baoming-form');
                $forms.each(function() {
                    var $form = $(this);
                    $form.Validform({
                        tiptype:function(msg,o,cssctl){
                            if(o.type === 3){
                                layer.tips(msg,o.obj,{
                                    tips:[1,'#da5c4f']
                                });
                            }
                        },
                        beforeSubmit:function() {
                            var data = $form.serializeArray();
                            var url = $form.prop('action');
                            $.post(url,data,function(data) {
                                //提交成功
                                if(data.code){
                                    dlok.open();
                                    $form.get(0).reset();
                                    //console.log(data.msg);
                                }else{
                                //提交失败
                                    dlerror.setNote(data.msg);
                                    dlerror.open();
                                    //console.log(data.msg);
                                }
                            },'json')
                            return false;
                        }
                    });
                });
                /* 报名 表单 end*/

                //路由控制
                Do('director',function() {
                    var dialog = function(id) {
                        if(typeof id!== 'undefined'){
                            var $ele = $('[data-dialog="' + id + '"]');
                            if($ele.length){
                                $ele.trigger('click');
                            }
                        }
                    };
                    var routes = {
                        '/dialog/:id' : dialog
                    };
                    var router = Router(routes);
                    router.init();
                });

            });
        };


        //地图
        if($('.map,.schoolmap').length > 0){
            //轮播
            Do('map','dialog-css');
        }

        //图表
        if($('.piece-box').length > 0){
            Do('charts');
        }
        //Tab
        function tabs(tabTit,active,tabCon){
            $(tabCon).each(function(){
                $(this).find('.tab-content').eq(0).show();
            });
            $(tabTit).each(function(){
                $(this).children().eq(0).addClass(active);
            });
            $(tabTit).children().hover(function(){
                $(this).addClass(active).siblings().removeClass(active);
                var index = $(tabTit).children().index(this);
                $(tabCon).find('.tab-content').eq(index).show().siblings().hide();
            });
        }
        tabs(".s-tab","active",".l-content");


        //placeholder
        $('input[placeholder],textarea[placeholder]').placeholder();


        //房产搜索下拉
        (function() {
            var $searchbox = $('div.s-search');
            var $searchtxt = $searchbox.find('.s-search-txt');
            var $searchbtn = $searchbox.find('.s-search-btn');
            var $searchresultbox = $searchbox.find('.s-search-down');
            var $url = $searchtxt.data('url');

            var get_search_data = function(val, callback) {
                $.get($url,{kw:val},function(data) {
                    callback(data);
                },'json');
            };

            $searchtxt.bind('keyup',function() {
                //异步请求数据后回调处理
                var val = $(this).val();
                if(val.length > 0){
                    get_search_data(val,function(data){
                        var html = '';
                        for(var i=0,len=data.length;i<len;i++){
                            var tpl = '<li><a href="' + data[i]['url'] + '" target="_blank">' + data[i]['name']+ '</a></li>';
                            html += tpl;
                        }
                        $searchresultbox.html(html);
                        $searchresultbox.show();
                    });
                }else{
                    $searchresultbox.hide();
                }
            });

            //$('body').click(function() {
                //$searchresultbox.hide();
            //});
        })();

        //头部搜索下拉
        (function() {
            var $searchselect = $('#search-select');
            var $actionselected = $('#action-selected');
            var $actionselect = $searchselect.find('.action-select');

            $searchselect.hover(function() {
                $actionselect.show();
            },function() {
                $actionselect.hide();
            });

            //点击后回调
            $actionselect.find('li').click(function() {
                $actionselected.text($(this).text());
                $actionselect.hide();
                $actionselected.closest('form').attr('action', $(this).data('url'));
            });

            $('body').click(function() {
                $actionselect.hide();
            });
        })();


        (function() {
            //团购
            var $modtuangou = $('.ui-mouseenter');
            $modtuangou.each(function() {
                var $items = $(this).find('.item');
                $items.first().addClass('on')
                    .end().mouseenter(function() {
                        $items.removeClass('on');
                        $(this).addClass('on');
                    });
            });

        })();


        //购房工具页面
        //
        (function() {
            var id = '#goufanggongju';
            if($(id).length === 0){}
            else{
                Do('cal','dialog-css','dialog','validform','layer',function() {
                    //初始化计算器测试
                    //税费计算器
                    hj.calculate.tax();
                    //房贷计算器
                    hj.calculate.houseloan();
                    //房屋购买能力计算器
                    hj.calculate.housebuy();
                    //公积金贷款计算器
                    hj.calculate.publickfundloan();
                })
            }
        })();

        //延迟加载
        var pic = 'undefined' === typeof noPicUrl ? '' : noPicUrl;

        //图片加载错误显示默认图片
        var wh = $(window).height();
        $("img").lazyload({
            effect : "fadeIn" ,
            placeholder: pic,
            threshold: wh,
            failure_limit:100,
            skip_invisible:false
        });
        //回到顶部
        $('.gotoTop').click(function() {
            $('html,body').animate({scrollTop:0},500);
        });

		$(".weixinlx").hover(function(){
			$(this).find('.weixin-box').show();
		},function(){
			$(this).find('.weixin-box').hide();
		});

        //到关键部分显示
        var tid = null;
        if($('.fixed_box').length > 0){
            var bartop = $('.plot-nav').length > 0  ? $('.plot-nav').offset().top : $('.vip_head').offset().top;
            function changeBar(){
                var st = $(window).scrollTop();
                if( st > bartop){
                    $('.fixed_box').addClass('common_fixed').fadeIn();
                }else{
                    $('.fixed_box').fadeOut(function(){
                        $('.fixed_box').removeClass('common_fixed')
                    });
                }
            }
            $(window).scroll( function(){
                clearTimeout(tid);
                tid = setTimeout(function() {
                    changeBar();
                },50);
            });
        }

        //侧边栏出现
        var $win = $(window);
        var $fmenu = $('.float-menu');
        var $wh = $win.height();
        //$win.scroll(function() {
            //var t = $win.scrollTop();
            //if(t >=150){
                //$fmenu.addClass('fixed');
            //}else{
                //$fmenu.removeClass('fixed');
            //}
        //}).scroll();
        //详情
        if($('.page-select').length>0){
            $('.page-select').hover(function(){
                $(this).find('ul').show();
            },function(){
                $(this).find('ul').hide();
            })
        }



        loupan_right_hongbao();
        tejiafang_extend_all();
        //loupan_dialog_hongbao();
        loudong_info();
        huanyihuan();
        house_loan_cal();
    });


    //新版房产代码
    //楼盘主页右侧红包关闭
    function loupan_right_hongbao(){
        var $hongbao = $('.fixed-hongbao');
        $hongbao.each(function() {
            var $self = $(this);
            $self.find('a.close').click(function() {
                $self.remove();
                return false;
            });
        });
    }
    //楼盘主页弹框红包
    function loupan_dialog_hongbao(){
        var $hongbao = $('.dialog-hongbao');
        if(!$hongbao.length) return;
        Do('layer',function() {
            var index = layer.open({
                type : 1,
                title : false,
                closeBtn : 0,
                skin : 'layer-hongbao-skin',
                content : $hongbao,
                offset : '200px',
                area : ['617px','345px'],
                shade: [0.8]
            });
            $hongbao.find('a.close').click(function() {
                layer.close(index);
                return false;
            });
        });
    }
    window.global.loupan_dialog_hongbao = loupan_dialog_hongbao;
    //楼栋信息
    function loudong_info(){
        //数据
        var $loudong_info = $('.loudong-info');
        if($loudong_info.length){
            var $tabs = $loudong_info.find('.tabs');
            var $loudong_maps = $('.loudong-map-container');
            var $loudong_info_detail = $loudong_info.find('.luodong-info-detail');

            Do('jqueryui',function() {
                //var sand_data = [
                    //{
                        //x : 100,
                        //y : 100,
                        //state : 1,
                        //id : 0,
                        //text : '1#',
                        //qi : 1,
                        //"data": {
                            //"kaipan": "2013-11-02",
                            //"jiaofang": "2016-06-30",
                            //"danyuan": "4",
                            //"cengshu": "3",
                            //"hushu": "2",
                            //"zaishou": "0",
                            //"fangyuan": [
                                //{
                                    //"huxing": "A户型 3室2厅2卫 面积:130㎡",
                                    //"tingshi": "3室2厅2卫",
                                    //"mianji": "130.00平"
                                //},
                                //{
                                    //"huxing": "E户型 3室2厅2卫 面积:158㎡",
                                    //"tingshi": "3室2厅2卫",
                                    //"mianji": "158.00平"
                                //}
                            //]
                        //}
                    //},
                    //{
                        //x : 200,
                        //y : 200,
                        //state : 2,
                        //id : 1,
                        //text : '2#',
                        //qi : 1
                    //},
                    //{
                        //x : 300,
                        //y : 300,
                        //state : 3,
                        //id : 2,
                        //text : '3#',
                        //qi : 1
                    //},
                    //{
                        //x : 300,
                        //y : 100,
                        //state : 1,
                        //id : 3,
                        //text : '4#',
                        //qi : 2
                    //},
                    //{
                        //x : 250,
                        //y : 250,
                        //state : 2,
                        //id : 4,
                        //text : '5#',
                        //qi : 2
                    //},
                    //{
                        //x : 100,
                        //y : 300,
                        //state : 3,
                        //id : 5,
                        //text : '6#',
                        //qi : 2
                    //}
                //];

                var _data = typeof sand_data  === 'undefined' ? [] : sand_data;

                var data = id_to_data(_data);

                draggable_img($loudong_maps.find('img').parent());
                $tabs.tabs({
                    'activate' : function(event, ui) {
                        var index = $tabs.tabs('option','active');
                        $loudong_info_detail.find('.b' + index).show().siblings().hide();
                    }
                });
                init_arrows(data);
                $loudong_maps.on('click','.arrow',function() {
                    var id = $(this).data('id');
                    var d = data[id]['data'];
                    show_loudong_detail($(this));
                    fill_loupan_detail_data(d,$('.arrow-detail-content'));
                    return false;
                });
                $('body').on('click','.arrow-detail .close',function() {
                    hide_loudong_detail();
                    return false;
                })
                //显示楼盘详情
                function show_loudong_detail($arrow){
                    var offset = $arrow.offset();
                    $('.arrow-detail').show().css({
                        left : offset.left + 50,
                        top : offset.top - 50
                    });
                }

                //填充楼盘详情数组
                function fill_loupan_detail_data(data,$container){
                    var tpl = 'arrow-detail-content-tpl';
                    var html = '';
                    Do('template',function() {
                        html = template(tpl,data);
                        $container.html(html);
                    });
                }
                function id_to_data(sand_data){
                    var arr = {};
                    for(var i=0,len=sand_data.length;i<len;i++){
                        arr[sand_data[i]['id']] = sand_data[i];
                    }
                    return arr;
                }
            });
        }


        //拖拽图片
        function draggable_img($img){
            $img.each(function() {
                var $self = $(this);
                var $p = $self.parent();
                var w = $self.data('width');
                var h = $self.data('height');
                var pw = $p.width();
                var poffset = $p.offset();
                var ph = $p.height();

                var diffx = (w - pw);
                var diffy = (h - ph);
                var x1 = poffset.left - diffx;
                var y1 = poffset.top - diffy;
                var x2 = poffset.left;
                var y2 = poffset.top;
                //console.log(x1,y1,x2,y2);

                $self.draggable({
                  //containment: "parent"
                  containment: [x1,y1,x2,y2]
                });
            });
        }


        //隐藏楼盘详情
        function hide_loudong_detail() {
            $('.arrow-detail').hide();
        }

        //初始化标注点
        function init_arrows(data){
            for(var i in data){
                var d = data[i];
                create_arrow(d);
            }
        }
        //创建标注点
        function create_arrow(data){
            //坐标
            var x = data.x;
            var y = data.y;
            //状态
            var state = data.state;
            //唯一标识
            var id = data.id;
            //内部文字
            var text = data.text;
            //期数
            var qi = data.qi;

            var html = '<span class="arrow arrow-' + state + '" data-id="' + id + '" style="left:' + x + 'px;top:'+ y + 'px">' + text + '</span>';

            $('#tabs-' + qi).find('.img-wrap').append(html);
        }

    }
    //特价房全部展开
    function tejiafang_extend_all(){
        var $tj_house = $('.tj-house-wrap');
        var $tj_house_list = $('.tj-house-list');
        var $link = $tj_house.find('.title-box a');
        $link.click(function() {
            if($tj_house_list.hasClass('extend')){
                $tj_house_list.removeClass('extend');
                $link.find('span').text('全部展开').parent()
                .find('.plot-ico').removeClass('plot-ico-uarrow');
            }else{
                $tj_house_list.addClass('extend');
                $link.find('span').text('收起').parent()
                .find('.plot-ico').addClass('plot-ico-uarrow');
            }
            return false;
        });
    }

    //换一换
    function huanyihuan(){
        var changeBtn = $(".change-btn");
        if(changeBtn.length) {
            changeBtn.on("click", function(e){
                e.preventDefault();
                var ajax_url = $(this).data("url");
                var change_template = $(this).data("template");
                var change_container = $(this).data("container");
                var $self = $(this);
                var $icon = $self.find('.iconfont');

                function deal_data(data){
                    var changeHtml = "";

                    //var data = [
                    //{
                        //url : '',
                        //title : '常州优质学区房助您赢在起跑线',
                        //info : '每个项目的唯一性导致每个项目 独有的销售动线，当你去售楼处 看房子的时候，置...',
                        //pic : 'images/80x60.jpg'
                    //},
                    //{
                        //url : '',
                        //title : '常州优质学区房助您赢在起跑线',
                        //info : '每个项目的唯一性导致每个项目 独有的销售动线，当你去售楼处 看房子的时候，置...',
                        //pic : 'images/80x60.jpg'
                    //},
                    //{
                        //url : '',
                        //title : '常州优质学区房助您赢在起跑线',
                        //info : '每个项目的唯一性导致每个项目 独有的销售动线，当你去售楼处 看房子的时候，置...',
                        //pic : 'images/80x60.jpg'
                    //},
                    //{
                        //url : '',
                        //title : '常州优质学区房助您赢在起跑线',
                        //info : '每个项目的唯一性导致每个项目 独有的销售动线，当你去售楼处 看房子的时候，置...',
                        //pic : 'images/80x60.jpg'
                    //},
                    //{
                        //url : '',
                        //title : '常州优质学区房助您赢在起跑线',
                        //info : '每个项目的唯一性导致每个项目 独有的销售动线，当你去售楼处 看房子的时候，置...',
                        //pic : 'images/80x60.jpg'
                    //}
                    //];
                    Do('template',function() {
                        changeHtml = template(change_template,{
                            'data' : data
                        });

                        var wh = $(window).height();

                        // 为了测试，延迟1秒加载
                        $("."+change_container).html(changeHtml).fadeOut().fadeIn();
                        $("."+change_container).find('img').lazyload({
                            effect : "fadeIn" ,
                            placeholder: noPicUrl,
                            threshold: wh,
                            failure_limit:100,
                            skip_invisible:false
                        });
                    });
                }
                $.ajax({
                    type: 'GET',
                    url: ajax_url,
                    dataType: 'json',
                    beforeSend : function() {
                        $icon.addClass('rotateall');
                    },
                    success: function(data){
                        $icon.removeClass('rotateall');
                        deal_data(data);
                    },
                    error: function(xhr, type){

                        console.log("换一换加载失败  错误信息："+type);
                        $icon.removeClass('rotateall');
                        deal_data();
                    }
                });
            }).click();
        }
    }

    //弹框计算器

    function house_loan_cal(){
        Do('highcharts',function() {
            var data = [100,60,40];
            show_data(data);
        });

        function show_data(data){
            $('.cal-result-map').highcharts({
                credits:{
                    text: ''
                },
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                colors : ['#dc4c4f','#81c33a','#387dbd'],
                title: {
                    text : ''
                },
                tooltip: {
                    pointFormat: '{point.percentage:.1f}%'
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            enabled: false,
                            distance: -50,
                            style: {
                                fontWeight: 'bold',
                                color: 'white',
                                textShadow: '0px 1px 2px black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: '贷款',
                    innerSize: '60%',
                    data: [
                        ['贷款总额', data[0]],
                        ['首期付款', data[1]],
                        ['支付利息', data[2]]
                    ]
                }]
            });
        }
        if($('.house-loan-cal').length){
            var $house_loan_cal = $('.house-loan-cal');
            var $cal_btn = $house_loan_cal.find('.cal-btn');
            var $total = $house_loan_cal.find('.total > span');
            var $junjia = $house_loan_cal.find('.junjia');
            Do('select',function() {
                $('.house-loan-cal').find('select').each(function() {
                  var opt = {
                      placeholder : $(this).data('placeholder'),
                      size : 5
                  };

                  var $self = $(this);

                  if($self.hasClass('huxing-select')){
                      opt = $.extend({},opt,{
                          onChange : function() {
                                var selected_opt = $self.find(':selected');
                                var total = selected_opt.data('total');
                                var junjia = selected_opt.data('junjia');

                                $total.text(total);
                                $junjia.text(junjia);

                          }
                      })
                  }
                  $self.selectOrDie(opt);
                })
            });
            $cal_btn.click(function() {

                var _total = parseFloat($total.text()) * 10000;

                var _shouf = $('#sf').find('option:selected').val();
                var _lv = $('#lv').find('option:selected').val() * $('#lv').find('option:selected').attr('d');
                var _year= $('#year').find('option:selected').val();




                var shoufu_money = _total * _shouf;

                var original = _total - shoufu_money;
                var yearratio = _lv;
                var year = _year;

                var result = Borrow(original,yearratio,year);
                result = {
                    'totalBack' : result[1],
                    'totalInterest' : result[3],
                    'monthBack' : result[0]
                };


                var dankuan_zong = result['totalBack'];
                console.log(dankuan_zong);
                var shouqi = shoufu_money;
                var lixi = result['totalInterest'];

                var data = [original,shouqi,lixi];

                show_data(data);
                $('.loan-month > .em').text(Math.ceil(result['monthBack']));
                $('#shoufu-text').text(Math.ceil(shouqi / 10000));
                $('#totalBack-text').text(Math.ceil(original/ 10000));
                $('#totalInterest-text').text(Math.ceil(lixi/ 10000));


                return false;
            });
        }

        $('.ui-loan-dialog').click(function() {
            var $loan = $('.house-loan-cal');
            var index = layer.open({
                type : 1,
                title : false,
                closeBtn : 0,
                content : $loan,
                area : ['724px','432px'],
                shade: [0.8],
                skin : 'loan-dialog'
            });
            $loan.find('a.close').click(function() {
                layer.close(index);
                return false;
            });
            return false;
        });

    }


    //等额本息还款法
    //original贷款金额
    //yearratio年利率%，如年利率5.6%就为5.6
    //year还款年限
    function Borrow(original,yearratio,year){
        //验证数据有限性
        year=parseInt(year);
        original=parseFloat(original);
        yearratio=parseFloat(yearratio);

        //还款月数
        timeSpan=year * 12;
        //某种利率
        active = yearratio * 10 / 12 * 0.001;

        var t1=Math.pow(1+active,timeSpan);
        var t2=t1-1;
        var tmp=t1/t2;
        //月利率
        var monthratio = active * tmp;

        //每月支付本息
        var monthBack=original*monthratio;
        //累计还款总额
        var totalBack=monthBack*timeSpan;
        //累计支付利息
        var totalInterest=totalBack-original;
        //每月应付利息
        var monthInterest=totalInterest/timeSpan;

        totalInterest=(Math.round(totalInterest*100))/100;//存款利息：取两位小数
        monthInterest=(Math.round(monthInterest*10000))/10000;//存款利息：取两位小数
        monthBack=(Math.round(monthBack*10000))/10000;//存款利息：取两位小数
        totalBack=(Math.round(totalBack*100))/100;//本息合计：取两位小数

        var objArray=new Array();
        objArray[0]=monthBack;
        objArray[1]=totalBack;
        objArray[2]=monthInterest;
        objArray[3]=totalInterest;

        //alert(objArray);
        return objArray;
    }
    

    


})(window);
/*
Do(function(){
    var count = 10,
        timeInterval;
    $(".send-yzm").on('click', function(){
        var self = $(this);
        var phone = $(".phone-txt").val();
        if(phone==""){
           layer.tips('请输入电话号码',$(".phone-txt"),{
                tips:[1,'#da5c4f']
            })
        }
        else if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))){
            layer.tips('请输入正确的电话号码',$(".phone-txt"),{
                tips:[1,'#da5c4f']
            })
        }  
        else{
            //self.text("60秒后再次发送请求");
            timeInterval = setInterval(function(){
                count--;
                if(count == 0){
                    clearInterval(timeInterval);
                    self.val("发送验证码");
                    self.attr('disabled', false); 
                    count = 10;
                }else{
                    self.attr('disabled', true); 
                    self.val("重新发送("+count+")"  );
                }
            },1000);

            $.ajax({
                type: "POST",
                url: "/api/mobile/sendCaptcha",
                dataType: "json",
                data: {'phone':phone},
                success: function (result) {
                    getCodeCallBack(result);
                }
            });
        }
    });
    function getCodeCallBack(result){
        var yzmCode = $(".send-yzm");
        if(!result.status){
            yzmCode.text("发送验证码");
            layer.tips(result.msg,$(".phone-txt"),{
                tips:[1,'#da5c4f']
            })
            clearInterval(timeInterval);
        }else{
            layer.tips(result.msg,$(".phone-txt"),{
                tips:[1,'#da5c4f']
            })
        }
    }
})
*/
Do(function(){
    //日历效果
    //新增修改开始
    ////实时获得月份
    var date = new Date();
    var myMonth = date.getMonth();
 
    if (+(myMonth) >= 6) {
        $("ul.month").css("margin-left", "-288px");
    };
 
    $("div.detail-content").eq(myMonth).removeClass("dn").siblings("div.detail-content").addClass("dn");
 
    $("ul.month li").eq(myMonth).addClass("on").siblings("li").removeClass("on");
 
    //新增修改结束
    ////////////////上翻
 
    $(".prev-month").click(function () {
 
        var thisIndex = $("ul.month li.on").index(); /////获取当前显示的月份li 的索引值
        if (thisIndex >= 1) { ////////当点击左边的时候，月份向下
            $("ul.month li").eq(thisIndex - 1).addClass("on").siblings().removeClass("on"); //给当前的下一个设置样式并显示对应的内容
            $("div.detail-content").eq(thisIndex - 1).removeClass("dn").siblings("div.detail-content").addClass("dn")
        }
    
        if (parseInt($("ul.month").css("margin-left")) < 0) {
            $("ul.month").css("margin-left", "+=48px")
        }
 
    })
 
    ////////////////下翻
    $(".next-month").click(function () {
        var thisIndex = $("ul.month li.on").index(); /////获取当前显示的月份li 的索引值
        var ulWidth = $("ul.month li").width() * $("ul.month").children("li").length; /////////ul整个长度
        if (thisIndex <= 11) { ////////当点击左边的时候，月份向下
            $("ul.month li").eq(thisIndex + 1).addClass("on").siblings().removeClass("on"); //同上
            $("div.detail-content").eq(thisIndex + 1).removeClass("dn").siblings("div.detail-content").addClass("dn")
        }
 
 
        if (parseInt($("ul.month").css("margin-left")) >- ulWidth / 2) {
            $("ul.month").css("margin-left", "-=48px")
        }
 
    })
 
    $("ul.month li").click(function () { /////////////////////点击月份时的样式
        var monthIndex = $("ul.month li").index($(this));
 
        $(this).addClass("on").siblings().removeClass("on");
        $("div.detail-content").eq(monthIndex).removeClass("dn").siblings("div.detail-content").addClass("dn")
    })

    var active_left_height=$(".new-left .active-list").height();
    var active_right_height=$(".new-right .date-content").height();
    if (active_left_height < active_right_height){
        $(".new-right .date-content").css("height",active_left_height-25);
        $(".new-right .detail-content").css("height",active_left_height-75);
    }


})

