/**
 * Created by Administrator on 2016/11/11.
 */
$(function () {


    $(".more-select").on("click", function () {
        $(".last-ul").toggle();
    });
    var flag;
    $(".more-select").click(function () {
        if (!flag) {
            flag = true;
            $(this).text("收起条件");

        } else {
            flag = false;
            $(this).text("更多条件");
        }
    });


    $(".delete-all").click(function () {
        $(".dropdown_toggle")
    });



    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "esfzzprice"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li data-val="1"><a href="#" >' + result.tags[i]['name'] + '</a></li>';
            }
            // console.log(str);
            $(".filter_sel_box").eq(1).html(str);

            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "resoldhuxing"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            $(".filter_sel_box").eq(2).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "esfzzsize"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            // console.log(str);
            $(".filter_sel_box").eq(3).html(str);
        }
    });
    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "esfzzts"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            $(".filter_sel_box").eq(4).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "esfzfzztype"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            $(".filter_sel_box").eq(5).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "resoldage"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            $(".filter_sel_box").eq(6).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "resoldface"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            $(".filter_sel_box").eq(7).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "esffloorcate"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            console.log(result);
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            // console.log(str);
            $(".filter_sel_box").eq(8).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "esfzzpt"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            // console.log(str);
            $(".filter_sel_box").eq(9).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $.ajax({
        type: "get",
        async: "true",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
        data: {cate: "resoldzx"},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            var str = "";
            for (var i = 0; i < result.tags.length; i++) {
                str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
            }
            // console.log(str);
            $(".filter_sel_box").eq(10).html(str);
            $(".dropdown-menu  li").click(function () {
                $(this).parent().hide();
                var str = '<span class="caret list-icon"></span>';
                $(this).parent().siblings().html($(this).text()+str);
            });
        }
    });

    $(".dropdown_toggle").hover(function () {
        $(this).siblings(".dropdown-menu").show();
    }, function () {
        $(this).siblings(".dropdown-menu").hide();
    });
    $(".dropdown-menu").hover(function () {
        $(this).show();
    }, function () {
        $(this).hide();
    });

    /*  下拉选中效果 */
    $("a").click(function (e) {
        e.preventDefault();//取消默认行为
    });
    $(".filter_sel_box>li").each(function () {
        $(this).click(function () {
            var val = $(this).children().html();
            var str = '<span class="caret list-icon"></span>';
            $(this).parent().siblings().html(val + str);
        });
    });
//点击选项后隐藏
    $(".dropdown-menu").click(function () {
        $(this).hide();
    });


    $(".more-select").bind("click", function () {
        if ($(".last-ul ").css("display") == "block") {
            $(".wapper").height("80px");
        } else {
            $(".wapper").height("40px");
        }
    });

     $(".delete-all").click(function () {
         var $dropdown = $(".dropdown_toggle");
         $dropdown.eq(0).text("来源");
         $dropdown.eq(1).text("总价");
         $dropdown.eq(3).text("户型");
         $dropdown.eq(4).text("面积");
         $dropdown.eq(5).text("特色");
         $dropdown.eq(6).text("住宅类型");
         $dropdown.eq(7).text("房龄");
         $dropdown.eq(8).text("朝向");
         $dropdown.eq(9).text("楼层");
         $dropdown.eq(10).text("配套设置");
         $dropdown.eq(11).text("装饰");

     });

    $(".dropdown_toggle").click(function () {

    });


    var cate = ["", "esfzzprice", "resoldhuxing", "esfzzsize", "esfzzts", "esfzfzztype", "resoldage", "resoldface", "esffloorcate", "esfzzpt", "resoldzx"];


  /*  for (var i = 0; i < cate.length; i++) {

        $.ajax({
            type: "get",
            async:"true",
            url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/commontags",
            data: {cate: cate[i]},
            dataType: "json",
            success: function (data) {
                var result = data.data;
                console.log(result);
                var str = "";
                for (var i = 0; i < result.tags.length; i++) {
                    str += '<li><a href="#">' + result.tags[i]['name'] + '</a></li>';
                }
                console.log(str);
                $(".filter_sel_box").eq(i)
            }

        });

    }*/

});