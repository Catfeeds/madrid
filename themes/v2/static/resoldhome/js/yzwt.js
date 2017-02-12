/**
 * Created by lei on 2016/10/30.
 */


Do.add("layer", {
    type: 'js',
    path: basedir + 'layer.js'
});

Do.add('SuperSlide', {
    type: 'js',
    path: basedir + 'jquery.SuperSlide.2.1.1.js'
});
Do(function () {

    var inputName = $("#input-name");
    var inputMianji = $("#input-mianji");
    var inputPrice = $("#input-price");
    var inputContactts = $("#input-contacts");
    var inputPhone = $("#input-phone");

    inputName.blur(function () {
        if (inputName.val() == "") {
            $(".xiaoqu-wran-1").show();
            $(".form-input-1").css("border", "1px solid #d51938");
            $("#input-name").focus();
        } else {
            $(".xiaoqu-wran-1").hide();
            $(".form-input-1").css("border", "1px solid #dfdfdf");
        }
    });
    $(inputMianji).blur(function () {
        if (inputMianji.val() == "") {
            $(".xiaoqu-wran-2").show();
            $(".form-input-2").css("border", "1px solid #d51938");
            $(inputMianji).focus();
        } else {
            $(".xiaoqu-wran-2").hide();
            $(".form-input-2").css("border", "1px solid #dfdfdf");
        }
    });

    $(inputPrice).blur(function () {
        if (inputPrice.val() == "") {
            $(".xiaoqu-wran-3").show();
            $(".form-input-3").css("border", "1px solid #d51938");
            inputPrice.focus();
        } else {
            $(".xiaoqu-wran-3").hide();
            $(".form-input-3").css("border", "1px solid #dfdfdf");
        }
    });
    inputContactts.blur(function () {
        if ($("#input-contacts").val() == "") {
            $(".xiaoqu-wran-4").show();
            $(".form-input-4").css("border", "1px solid #d51938");
            $("#input-contacts").focus();
        } else {
            $(".xiaoqu-wran-4").hide();
            $(".form-input-4").css("border", "1px solid #dfdfdf");
        }
    });

    inputPhone.blur(function () {
        if (inputPhone.val() == "") {
            $(".xiaoqu-wran-5").show();
            $(".form-input-5").css("border", "1px solid #d51938");
            inputPhone.focus();
            return false;
        } else if (!inputPhone.val().match(/^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/)) {
            $(".xiaoqu-wran-5").text("手机格式不正确").show();
            $(".form-input-5").css("border", "1px solid #d51938");
            inputPhone.focus();
        } else {
            $(".xiaoqu-wran-5").hide();
            $(".form-input-5").css("border", "1px solid #dfdfdf");
        }

        return false;
    });

    $(".form-input-2 .xiaoqu-name-i")


});

Do("layer", function () {
    $(".form-btn a").on("click", function () {

        var $name = $("#input-name").val();
        var $mianji = $("#input-mianji").val();
        var $price = $("#input-price").val();
        var $contacts = $('#input-contacts').val();
        var $phone = $('#input-phone').val();

        if ( $name.length != 0 && $mianji.length !=0  && $price.length !=0  && $contacts.length !=0 && $phone.length !=0) {
            layer.msg("您的信息以提交");
            $.ajax({
                url: "",
                type: "post",
                data: "",
                dataType: "",
                success: function () {

                }
            })
        }



    });
});


Do('SuperSlide', function () {

    jQuery(".main-footer").slide({
        mainCell: ".yuyue-list ul",
        autoPlay: true,
        effect: "leftMarquee",
        vis: 5,
        interTime: 50
    });
});

