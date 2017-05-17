Do.add('dialog', {
    path: basedir+'js/buckwilson-Lightbox/jquery.lightbox_me.min.js',
    type: 'js'
});
Do.add('placeholder', {
    path: basedir+'js/placeholder.js',
    type: 'js'
});
Do.add('datepicker-css', {
    path: basedir+'js/datepicker/datepicker.min.css',
    type: 'css'
});
Do.add('datepicker', {
    path: basedir+'js/datepicker/datepicker.min.js',
    type: 'js',
    requires:['datepicker-css']
});

Do.ready(function(){
    Do('placeholder',function() {
        $('input[type="text"]').each(function(){
            var inp = $(this);
            inp.placeholder({
                word: inp.attr("placeholder"),
                color: "#999"
            });
        });
    });
    //日期选择
    if($(".datepicker").length > 0){
        Do('datepicker',function(){
            $(".datepicker").datepicker({dateFormat: "yyyy-mm-dd"});
        });
    }

    Do('dialog',function(){
        $('.form-pop-trigger').on('click', function(e){
            var target = $(this).attr("data-href");
            if(target){
                target = $(target);
            } else {
                target = $('.form-wrap-box');
            }
            if($(this).attr("data-id"))
                target.find('input[name="shopid"]').val($(this).attr("data-id"));
            if($(this).attr("data-plot-name"))
                target.find('input[name="plot_name"]').val($(this).attr("data-plot-name"));
            target.find(".focus").removeClass("focus");
            target.find(".error-box").hide();
            target.lightbox_me({
                centered: true,
                closeSelector: ".pop-close-btn"
            });
            e.preventDefault();
        });
    });
    //效果图悬浮显示
    $(".item-img-container").hover(function(){
        $(this).find(".item-tag-l").show();
        $(this).find(".item-tag-r").show();
    },function(){
        $(this).find(".item-tag-l").hide();
        $(this).find(".item-tag-r").hide();
    });
    //预算下拉框
    $('.select-content li').click(function(){
        var formWrap = $(this).parents(".form-wrap-box");
        formWrap.find('.select-content').hide();
        formWrap.find('.budget').text($(this).text());
        formWrap.find('input[name="budget"]').val($(this).text());
    });
    $('.selects').mouseenter(function(){
        $('.select-content').show();
    }).mouseleave(function(){
        $('.select-content').hide();
    });
    //设置风格标签
    $('.style-tag-box a').click(function(e){
        var formWrap = $(this).parents(".form-wrap-box");
        formWrap.find('input[name="style"]').val($(this).attr("data-id"));
        $(this).siblings().removeClass("on");
        $(this).addClass("on");
        e.preventDefault();
    });


    $(".form-sub-btn").on('click', function(){
        var formWrap = $(this).parents(".form-wrap-box");
            //reset
            formWrap.find(".error-box").hide();
            formWrap.find(".focus").removeClass("focus");
        var nameinput = formWrap.find('input[name="name"]'),
            name = nameinput.val(),
            phoneinput = formWrap.find('input[name="phone"]'),
            phone = phoneinput.val(),
            size = formWrap.find('input[name="size"]').val(),
            budget = formWrap.find('input[name="budget"]').val(),
            source = formWrap.find('input[name="source"]').val(),
            type = formWrap.find('input[name="type"]').val(),
            cate = formWrap.find('input[name="cate"]').val(),
            shopid = formWrap.find('input[name="shopid"]').val(),
            is_marry = formWrap.find('input[name="is_marry"]:checked').val(),
            request = formWrap.find('textarea[name="request"]').val(),
            plot_name = formWrap.find('input[name="plot_name"]').val(),
            start_time = formWrap.find('input[name="start_time"]').val(),
            bedroom = formWrap.find('input[name="bedroom"]').val(),
            livingroom = formWrap.find('input[name="livingroom"]').val(),
            style = formWrap.find('input[name="style"]').val(),
            bathroom = formWrap.find('input[name="bathroom"]').val();

            size = size ? size : "";
            budget = budget ? budget : "";
            cate = cate ? cate : 1;
            shopid = shopid ? shopid : 0;
            is_marry = is_marry ? is_marry : 0;
            request = request ? request : "";
            plot_name = plot_name ? plot_name : "";
            start_time = start_time ? start_time : "";
            bedroom = bedroom ? bedroom : 0;
            style = style ? style : 0;
            livingroom = livingroom ? livingroom : 0;
            bathroom = bathroom ? bathroom : 0;

            if(name == nameinput.attr("placeholder") || name == ""){
                nameinput.addClass("focus");
                nameinput.next(".error-box").show();
                return false;
            }
            if(phone != phoneinput.attr("placeholder") && phone != ""){
                if(!checkPhone(phone)){
                    phoneinput.addClass("focus");
                    phoneinput.next(".error-box").show();
                    return false;
                }
            } else {
                phoneinput.addClass("focus");
                phoneinput.next(".error-box").show();
                return false;
            }
            //关闭弹出框
            $(".form-wrap-box").trigger('close');
            //显示正在加载
            loadingData();
            $.ajax({
                type: 'POST',
                url: '/orderapi',
                data: {
                    name:name,
                    phone:phone,
                    size: size,
                    budget: budget,
                    source:source,
                    type: type,
                    cate: cate,
                    sid:shopid,
                    plot_name: plot_name,
                    is_marry: is_marry,
                    request: request,
                    start_time: start_time,
                    bedroom: bedroom,
                    livingroom: livingroom,
                    bathroom: bathroom,
                    style: style
                },
                dataType: 'json',
                success: function(data){
                    alertSuccess();
                    nameinput.val("");
                    phoneinput.val("");
                }
            });
    });

    //提交成功提示
    function alertSuccess(msg){
        if(!msg){
            msg = '提交成功';
        }
        if($(".alert-box").length == 0){
            $("body").append('<div class="alert-box"><div class="success-text fs22 c-green bigfs"><i class="icon ok"></i>'+msg+'</div></div>');
        } else {
            $(".alert-box").html('<div class="success-text fs22 c-green bigfs"><i class="icon ok"></i>'+msg+'</div>');
        }
        $(".alert-box").lightbox_me({
            centered: true,
            onLoad: function() {
                setTimeout(function(){
                    $(".alert-box").trigger('close');
                },2000);
            }
        });
    }
    //loading
    function loadingData(msg){
        if(!msg){
            msg = '正在提交中...';
        }
        if($(".alert-box").length == 0){
            $("body").append('<div class="alert-box"><div class="success-text fs22 c-green bigfs">'+msg+'</div></div>');
        } else {
            $(".alert-box").html('<div class="success-text fs22 c-green bigfs">'+msg+'</div>');
        }
        $(".alert-box").lightbox_me({
            centered: true,
            onLoad: function() {
            }
        });
    }

    function checkPhone(phone){
        var mobile = /^1[3|4|5|7|8][0-9]\d{8}$/;
        if(!mobile.test(phone)){
            return false;
        }
        return true;
    }
});