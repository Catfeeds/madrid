/*
 * 表单校验 js
 * validform.js
 * */
if($('.ui-checkform').length > 0){
    Modernizr.load([{
        load:[basedir + 'extend/validform.min.js',basedir + 'extend/layer.js'],
        complete:function() {
            $('.ui-checkform').Validform({
                tiptype:function(msg,o,cssctl){
                    //msg：提示信息;
                    //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
                    //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
                    if(o.type === 3){
                        layer.tips(msg,o.obj,{
                            tips:[1,'#da5c4f']
                        });
                    }else if (o.type === 2){
                    }
                }
            });

            $('.ui-checkform .ui-check-ele').each(function() {
                var $msg = $('<div class="ui-check-errormsg"></div>');
                $(this).append($msg);
            });
        }
    }
    ]);
}
