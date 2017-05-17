Do('validform',function(){
    var valid_form = $('.valid-form');
    var isFloat = /(^[0]\.{1}\d{1,2}$)|(^[1-9]\d*\.{1}\d{1,2}$)|(^[1-9]{1}\d*$)|(^[0]{1}$)/;
    var hxReg = /^[0-9]$/;
    var rentReg = /^[0-9](\d{1,5})?$/;
    var codeReg = /^\d{4}$/;
    var form = valid_form.Validform({
        postonce:true,
        ajaxPost:true,
        showAllError:true,
        tiptype:function (msg,o,cssctl) {
            var objtip = o.obj.parent('.ipt');
            var errorSpan =objtip.find(".errmsg");
            if(o.type == 3){
                if(errorSpan.length>0){
                    errorSpan.text(msg);
                }else{
                    objtip.append('<span class="errmsg">'+msg+'</span>');
                }
            }
            if(o.type == 2){
                if(errorSpan)
                    errorSpan.remove();
            }
        },
        datatype:{
            "price" : function(gets,obj,curform,regxp) {
                if(isFloat.test(gets)){
                    if(gets >= 0 && gets <=  100000){return true;}
                }
                return false;
            },
            "size" : function (gets,obj,curform,regxp) {
                if(isFloat.test(gets)){
                    if(gets >= 2 && gets <=  10000){return true;}
                }
                return false;
            },
            "hx" : function (gets,obj,curform,regxp){
                var category = curform.find('input[name="ResoldZfExt[category]"]:checked').val();
                console.log(category);
                if(category == 1){
                    return hxReg.test(gets);
                }
                return true;
            },
            "floor" : function (gets,obj,curform,regxp) {
                var msg = true;
                obj.parent().children('input').each(function () {
                    var value = $(this).val();
                    if(value == ''){
                        msg = $(this).data('name')+'不能为空';
                        return false;
                    }
                    if(value == 0){
                        msg =   $(this).data('name')+'请填写除0外的数字';
                        return false;
                    }
                    if(value < -99 || value > 99){
                        msg = $(this).data('name')+'在-99到99之间';
                        return false;
                    }
                });
                return msg;
            },
            "floors" : function (gets , obj , curform , regxp) {
                var floor = obj.siblings("input[name='floor']").val();
                if(Number(gets) < Number(floor)){
                    return '总楼层不能小于所在楼层';
                }
                return true;
            },
            "rent" : function (gets , obj , curform , regxp) {
                return rentReg.test(gets);
            },
            "code" : function (gets , obj , curform , regxp) {
                if(realPhone != '' && $('input[name="phone"]').val() == realPhone)
                    return true;
                return codeReg.test(gets);
            },
            "jyxm" : function (gets , obj , curform , regxp) {
                var category = curform.find('input[name="ResoldZfExt[category]"]:checked').val();
                if(category == 2){
                    var msg = '经营项目不能为空';
                    obj.closest('ul').find('input').each(function () {
                        if($(this).is(":checked")){
                            return msg = true;
                        }
                    });
                    return msg;
                }
                return true;
            },
            "ts" : function (gets , obj , curform , regxp) {
                var count = 0 ;
                obj.closest('ul').find('input').each(function () {
                    if($(this).is(":checked")){
                        count++;
                    }
                })
                return count > 5 ? false : true ;
            },
            'qwhx' : function (gets , obj , curform , regxp) {
                var category = curform.find('input[name="ResoldZfExt[category]"]:checked').val();
                if(category == 1){
                    var msg = '期望户型不能为空';
                    obj.closest('ul').find('input').each(function () {
                        if($(this).is(":checked")){
                            return msg = true;
                        }
                    });
                    return msg;
                }
                return true;
            }
        },
        callback:function(res){
            
        }
    })
});