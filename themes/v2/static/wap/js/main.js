var backTop = $(".gototop");
backTop.bind("click", function (e) {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    return false;
});
$(document).bind("scroll", function () {
    var top = document.body.scrollTop || document.documentElement.scrollTop;
    if (top > $(window).height()){
        backTop.css({"bottom":"150px"});
        backTop.show();
    }
    else{
        backTop.hide();
    }
});
var $form = $('.form');
if($form.length && $.fn.Validform){
    $form.Validform({
        tipSweep:false,
        tiptype:function(msg,o,cssctl){
            if(o.type === 3){
                $(o.obj).parent().find('.ui-error-msg').remove();
                var $errormsg = $('<div class="ui-error-msg"/>');
                $errormsg.text(msg).addClass('show');
                $(o.obj).after($errormsg);
            }else if (o.type === 2){
                $(o.obj).parent().find('.ui-error-msg').remove();
            }
        },
        beforeSubmit:function() {
            return true;
        }
    });
}

function ui_switch(body,flag,evt,cls){
    cls = cls || 'on';
    evt = evt || 'click';
    var $body = $(body);
    $body.each(function() {
        var $this = $(this);
        var $flag = $this.find(flag);
        $flag.bind(evt,function() {
            $this.toggleClass(cls);
        });
    })
}

ui_switch('.tjf-sublist','h2');

/* 菜单 begin*/

var $menu = $('.ui-menu');
if($menu.length){
    var $menu_tabs = $menu.find('li');
    var $submenus = $('.ui-submenu');
    var $type_two = $('.ui-type-two');
    var $layer = $('.layer-overall');

    //一级菜单
    $menu_tabs.each(function(i) {
        var $self = $(this);
        $self.data('idx', i);
        $self.click(function() {
            var idx = $self.data('idx');
            var flag = $self.hasClass('ui-active');
            //关闭所有
            $menu_tabs.removeClass('ui-active');
            $submenus.hide();
            //重新开启
            if(flag){
                $self.removeClass('ui-active');
                $submenus.eq(idx).hide();
                $layer.hide();
            }else{
                $self.addClass('ui-active');
                $submenus.eq(idx).show();
                $layer.show();
            }
        });
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
        $lis.find('.ui-long a').click(function(e) {
            e.stopPropagation();
        });
    });
}

/* 菜单 end*/

/* mobiscroll 自定义 begin*/
var $ui_mobi_selects = $('.ui-mobi-select');
var $ui_mobi_select_vals = $('.ui-mobi-select-val');

if($ui_mobi_selects.length){
    $ui_mobi_selects.each(function(i) {
        var $self = $(this);
        var data_select = $self.data('select');
        var label = $self.data('label');
        var wheels = [[]];
        var selects = data_select.split(',');
        var select_wheels = {
            label : label,
            keys:[],
            values:[]
        };
        var valarr = [];
        $self.data('idx', i);

        for(var i=0,len=selects.length;i<len;i++){
            var o = selects[i];
            var os = o.split('|');
            var name = os[0];
            var val = os[1];
            valarr[name] = val;
            select_wheels.keys.push(name);
            select_wheels.values.push(name);
        }
        wheels[0].push(select_wheels);
        var mobi = $self.mobiscroll().scroller($.extend({},{
                theme:"ios",
                cancelText:false,
                setText:false,
                display: 'bottom',
                height:68,
                tap:false,
                minWidth:160,
                wheels: wheels,
                buttons:[
                    "set",{
                        text:"确定",
                        handler:"set"
                    },
                    "cancel",{
                        text:"取消",
                        handler:"cancel"
                    }
                ],
                onSelect:function(valueText, inst) {
                    $ui_mobi_select_vals.eq($self.data('idx')).val(valarr[valueText[0]]);
                },
                formatValue:function(value) {
                    return value;
                },
                parseValue:function(value) {
                }
        }));

    });
}
/* mobiscroll 自定义 end*/
//头部导航
(function(){
    var subnav = $('.subnav-layer'),
        subnav_bg = $('.layer-subnav-bg'),
        trigger = $('.layer-sub-btn');
    $(trigger).on('click', function(){
        if(!subnav.hasClass('menuin')){
            subnav.show();
            subnav.removeClass("menuout").addClass("menuin");
            subnav_bg.show();
        } else {
            subnav.removeClass("menuin").addClass("menuout");
            setTimeout(function(){subnav.hide()},100)
            subnav_bg.hide();
        }
    });
    $(subnav_bg).on('click', function(e){
        subnav.addClass("menuout");
        $(this).hide();
    });
})();
//back
$(".back-btn").on("click", function(e){
    history.go(-1);
    e.preventDefault();
});

/* 搜索 begin */
var $searchinput = $('.ui-search-text');
if($searchinput.length){
    var $searchlist = $('.search-list');
    $searchinput.bind('input propertychange',function() {
        var val = $(this).val();
        if(val.length > 0)
            $searchlist.show();
        else{
            $searchlist.hide();
        }
    });
}
/* 搜索 end */
/* 搜索下拉 begin */
var $input = $('#search-box');
if($input.length){
    var url = $input.data('url');
    var tid = null;
    $input.focus(function() {
        var val = $input.val();
        $other_item.hide();
        $area_blocks.show();

        $('.back').one('click',function() {
            $area_blocks.hide();
            $search_result.hide();
            $other_item.show();
            return false;
        });
    });
    $input.bind('input',function() {
        clearTimeout(tid);
        var value = $(this).val();
        var data = [1,2,3,4,5];
        var url = $input.data('url');
        tid = setTimeout(function() {
            if(value){
                $area_blocks.hide();
                $search_result.show();
                getSearchData(url,value);
                //$.get(url,{kw:value},function(data) {
                    //data = $.parseJSON(data);
                    //initItem(data);
                //});
            }else{
                $search_result.empty();
                $area_blocks.show();
            }
        },100);
    });

    var $search_result = $('.area-search-list');
    var $area_blocks = $('.area-block');
    var $other_item = $('.other-item');
    var $id = $('#StaffCheckExt_hid');
    //点击后的回调事件 搜索结果回调处理
    $search_result.delegate('a','click',function() {
        $input.val($(this).text().trim());
        $id.val($(this).data('id'));
        $search_result.empty();
        $('.back').click();
    });

    //地区搜索回调
    $area_blocks.on('click','.area-block-item:not(".more-btn") a',function() {
        var $obj = $(this);
        var id = $obj.data('id');
        var text = $obj.text().trim();
        $input.val(text);
        $id.val(id);
        $('.back').click();
        return false;
    });

    $('.more-btn').each(function() {
        var $self = $(this);
        var $ele = $self.find('a');
        $ele.click(function() {
            var url = $ele.data('url');
            var page = $ele.data('page') || 2;
            var area = $ele.data('area');
            getAreaData($self,url,area,page);
            page = page + 1;
            $ele.data('page', page);
        });
    });

    function getAreaData($obj, url, area, page){
        $.get(url,{area:area,page:page},function(html) {
            $obj.before(html);
        },'html');
    };
    function getSearchData(url,kw){
        $.get(url,{kw:kw},function(html) {
            $search_result.html(html);
        },'html');
    }
}
/* 搜索下拉 end */

/* 弹框 JS begin */
(function() {
    var $btn = $('.j-dialog-btn');
    $btn.click(function() {
        $('.pop-box').show();
        $('.layer-overall').show();
        $('.layer-overall').click(function() {
            $(this).hide();
            $('.pop-box').hide();
        });
        return false;
    });
})();
/* 弹框 JS end*/

/* 管家楼盘登记 begin */
var $area_blocks = $('.area-block');
$area_blocks.each(function() {
    var $ele = $(this);
    $ele.find('dt').click(function() {
        var $arrow = $ele.find('.arrow');
        $arrow.toggleClass('on');
        check_block($ele);
    });
    check_block($ele);
    function check_block($ele){
        var $arrow = $ele.find('.arrow');
        if($arrow.hasClass('on')){
            $ele.find('.area-block-item').show();
        }else{
            $ele.find('.area-block-item').hide();
        }
    }
});
//图片加载错误显示默认图片
if($.fn.lazyload){
    var pic = 'undefined' === typeof noPicUrl ? '' : noPicUrl;
    var wh = $(window).height();
    $("img").lazyload({ 
        effect : "fadeIn" ,
        placeholder: pic,
        threshold: wh,
        failure_limit:100,
        skip_invisible:false
    });
}
/* 管家楼盘登记 end */

/* 首页分区功能 begin */
function OtherWeb($el){
    this.$el = $el;
    this.init();
}
$.extend(OtherWeb.prototype,{
    init : function() {
        this.$el.each(function() {
            var $self = $(this);
            var $nextBlock = $self.next();
            $self.on('touchstart',function() {
                $nextBlock.toggle();
            });
        });
    }
})

$('.other-web').each(function() {
    new OtherWeb($(this));
});
/* 首页分区功能 end */

/*房大白验证*/

var $form = $('.baom-form');
if($form.length && $.fn.Validform){
    $form.Validform({
        tiptype:function(msg,o,cssctl){
            if(o.type === 3){
                if($('.layer-overall').length==0){
                    $('body').append('<div class="layer-overall"></div>');
                }
                var bglayout=$('.layer-overall');
                if($('.ui-error-msg').length==0){
                    $('body').append('<div class="ui-error-msg"></div>');
                }
                var obj=$('.ui-error-msg');
                obj.html(msg).show();
                bglayout.css({"min-height":$("body").height()-90}).show();
                setTimeout(function () {
                    obj.hide();
                    bglayout.hide();
                }, 2000);
            }
        },
        beforeSubmit:function() {
            return true;
        }
    });
}

//加载更多
$('.addressinfo .more').click(function() {
    $('.order-progress').find('.dn').removeClass('dn');
    $(this).remove();
});
