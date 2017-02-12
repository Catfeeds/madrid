(function(window) {
    window.hj = {};
    Modernizr.load([{
        'load' : ['./js/zepto.min.js','./js/mobiscroll.min.js', './style/mobiscroll.min.css'],
        'complete' : function() {
           var dateopt = {
                preset: 'date', //日期
                dateFormat: 'yy-mm-dd', // 日期格式
                dateOrder: 'yymmdd', //面板中日期排列格式
                theme: 'ios', //皮肤样式
                display: 'bottom', //显示方式 
                setText: '确定', //确认按钮名称
                cancelText: '取消',
                height:68,
                tap:false,
                minWidth:160
           };
           $(".ui-datetime-date .ui-datetime-input").mobiscroll(dateopt); 

           var timeopt = {
                preset: 'time', //日期
                timeFormat: 'HH:ii', // 日期格式
                timeWheels: 'HHii', //面板中日期排列格式
                theme: 'ios', //皮肤样式
                display: 'bottom', //显示方式 
                setText: '确定', //确认按钮名称
                cancelText: '取消',
                height:68,
                tap:false,
                minWidth:160
           };
           $(".ui-datetime-time .ui-datetime-input").mobiscroll(timeopt); 
        }
    },{
        'load':['./js/zepto.min.js', './js/layer.m/layer.m.js', './js/layer.m/need/layer.css'],
        'complete':function() {
            $('#alert').click(function() {
                layer.open({
                    title:'提示信息',
                    content: '通过style设置你想要的样式',
                    btn: ['OK']
                });
            });
            $('#confirm').click(function() {
                layer.open({
                    title:'提交成功',
                    content: '你是想确认呢，还是想取消呢？',
                    btn: ['确认', '取消'],
                    shadeClose: false,
                    yes: function(){
                        layer.open({content: '你点了确认', time: 1});
                    }, no: function(){
                        layer.open({content: '你选择了取消', time: 1});
                    }
                });
            });
            $('#tips').click(function() {
                layer.open({
                    content: '2秒后消失',
                    style: 'width:200px;background-color:#09C1FF; color:#fff; border:none;',
                    time: 2,
                    shade:false
                });
            });
        }
    },{
        'load':['./js/zepto.min.js', './js/ui-tab.js'],
        'complete':function() {
            var t1 = hj.Tab({
                context : '.ui-tab',
                onTabEnd : function(tab, content, i, tabs, contents) {
                    tabs.find('i').removeClass('ui-arrow-up').addClass('ui-arrow-down');
                    if(tab.hasClass(this.cls_active)){
                        tab.find('i').removeClass('ui-arrow-down').addClass('ui-arrow-up');
                        $('.layer-overall').show();
                    }else{
                        tab.find('i').removeClass('ui-arrow-up').addClass('ui-arrow-down');
                    }
                },
                onToggle : function(tab, content) {
                    tab.find('i').removeClass('ui-arrow-up').addClass('ui-arrow-down');
                    tab.removeClass(this.cls_active);
                    content.removeClass(this.cls_active);
                    $('.layer-overall').hide();
                }
            });

            $('.layer-overall').click(function() {
                t1.close();
                $(this).hide();
            });

            hj.Tab({
                context:'.ui-tab',
                ui_menu:'.ui-type-two > li',
                ui_submenu:'.ui-type-two > li > ul',
                onTabEnd:function(tab, content, i, tabs, contents) {
                    tabs.removeClass('ui-current');
                    tabs.find('#area').removeClass('ui-current');
                    if(tab.hasClass(this.cls_active)){
                        tab.addClass('ui-current');
                        tab.find('#area').addClass('ui-current');
                    }else{
                        tab.removeClass('ui-current');
                        tab.find('#area').removeClass('ui-current');
                    }
                }
            });

            hj.Tab({
                context:'.ui-tab',
                ui_menu:'.ui-tab-nav li',
                ui_submenu:'.ui-tab-item',
                cls_active:'current',
                onTabEnd:function(tab, content, i, tabs, contents) {
                    contents.removeClass('show');
                    content.addClass('show').show();
                }
            });
        }
    }]);
})(window);

$(function () {
    var i = $("body");
    !
    function () {
        i.find(".ui-tab-link").on(xzmui.clickName, function () {
            $(this).addClass("current").siblings().removeClass("current"),
            $(this).parent().next(".ui-tab-con").find(".ui-tab-item").eq($(this).index()).addClass("show").siblings().removeClass("show")
        }),
        i.find(".ui-tab").on("swipeLeft", function () {
            $(this).find(".ui-tab-nav .current").next().trigger("tap")
        }),
        i.find(".ui-tab").on("swipeRight", function () {
            $(this).find(".ui-tab-nav .current").prev().trigger("tap")
        })
    }
});
