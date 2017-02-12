/**
 * Created by Administrator on 2016/11/14.
 */

Do.add("layer", {
    type: 'js',
    path: basedir + 'layer.js'
});

Do("layer", function () {
    var index = new Object();
    $('.jubao-btn').click(function () {
        index = layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            shade: 0.8,
            skin: 'pop-box',
            content: '<div class=""><div class="title"><span>举报虚假房源</span><a href="javascript:void(0)" class="iconfont close-ico">&#xe60d;</a></div><form><div class="ui-dialog"> <p><label><input type="radio" name="RadioGroup1" value="单选" id="RadioGroup1_0" />房源不存在/房源已售</label> <label> <input type="radio" name="RadioGroup1" value="单选" id="RadioGroup1_1" /> 房源信息不真实</label></p> <p><textarea placeholder="详细举报理由请在此处填写（100个汉字）"></textarea></p><p>您的手机号：<input type="number" placeholder="请输入您的手机号" class="txt" maxlength="11" datatype="m" nullmsg="请输入手机号" errormsg="请输入正确的手机号"></input></p><p>短信验证码：<input type="number" placeholder="请输入短信验证码" class="txt"></input><input type="button" class="yzm-btn" value="获取"></input></p><a href="javascript:;" style="display: block" class="tj-btn">立即举报 </a></div></form></div>'

        });

        $(".close-ico").click(function () {
            layer.close(index);
        });

        // 验证码
        $(".yzm-btn").click(function () {
            showTime();
            $.ajax({

            })

        });

        var time=60;
        function showTime(){
            var IntervalName = setInterval(function () {
                $('.yzm-btn').attr("disabled", true);
                $('.yzm-btn').attr('value',time+'s');
                time=time-1;
                if(time<0){
                    $('.yzm-btn').attr("value",'获取');
                    $('.yzm-btn').removeAttr("disabled");
                    time=10;
                    clearInterval(IntervalName);
                };
            }, 1000);
        }

        $(".tj-btn").click(function () {
            layer.closeAll();
            $.ajax({
             url:"",
             type:"",
             dtat:{},
             dataType:"json",
             success:function () {

             }
             })
        })
    });

var falg = false
    $(".save-btn").click(function () {
        if (!falg) {
            $(".save-btn i").css({"color":"#FF7900"});
            layer.msg("已加入收藏");
            falg = true;
        }
    });
});

