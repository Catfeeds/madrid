//计算器
(function($, window) {
    //利率类
    function Rate(option){
        if(!(this instanceof Rate)) return new Rate(option);
        this.rate = 0;
        this.setOption(option);
        return this;
    }

    Rate.prototype = {
        constructor:Rate,
        setOption:function(option) {
            var loanStyle = option.loanStyle;
            var timeStyle = option.timeStyle;
            var rateStyle = option.rateStyle;
            var csrf = option.csrf;
            
            this._loanStyle = loanStyle;
            this._timeStyle= timeStyle;
            this._rateStyle = rateStyle;
            this._csrf = csrf;
            return this;
        },
        get:function() {
            
        },
        update:function(cb) {
             var loanStyle = this._loanStyle;
             var timeStyle = this._timeStyle;
             var rateStyle = this._rateStyle;
             var csrf = this._csrf;
             var root = this;
             $.ajax({
                'url' : window.get_rate_url,
                'data' : {
                    'loan' : loanStyle,
                    'year' : timeStyle,
                    'rateStyle' : rateStyle,
                    'YII_CSRF_TOKEN' : csrf
                },
                'type' : 'post',
                'dataType' : 'jsonp',
                'success' : function(data){
                    if(typeof cb === 'function'){
                        cb(data);
                    }
                }
            }); 
            return this;
        },
        onUpdateCallback:function() {
            return this;
        }
    };


    //税费计算器
    //price 单价
    //size 面积

    function TaxCalculate(option){
        if(!(this instanceof arguments.callee)){
            return new arguments.callee(option);
        }
        this.setOption(option);
        this.result = {};
        return this;
    };

    TaxCalculate.prototype = {
        setOption:function(option) {
            this.price = option.price;
            this.size = option.size;
            this.onSuccess = option.onSuccess ? option.onSuccess : this.onSuccess;
            this.onError = option.onError ? option.onError : this.onError;
            return this;
        },
        run : function() {
            var state = true;
            var msg='';
            var data={};

            var price =this.price;
            var size =this.size;

            if( !/\d+/.test(price) || !/\d+/.test(size) ) {
                msg = '请正确填写内容';
                state = false;
            }
            if(state === true){
                data = {
                    //房款总价
                    zj : price * size,
                    //契税
                    qs : price * size * 0.015,
                    //印花税
                    yh : price * size * 0.0005,
                    //委托办理产权手续费
                    wt : price * size * 0.003,
                    //公证费
                    gzh : price * size * 0.003,
                    //房屋买卖手续费
                    fw : 500
                };
            }
            this.result = {
                state : state,
                msg : msg,
                data : data
            };

            if(state === true){
                this.onSuccess(this.result);
            }else{
                this.onError(this.result);
            }
            return this;
        },
        getResult:function() {
            return this.result;
        },
        onSuccess:function() {
            return this;
        },
        onError:function() {
            return this;
        }
    };

    //税费计算器界面
    function TaxCalculateView(id){
        var $ele = id ? id : $('#taxcal');

        //单价
        var $danjia = $ele.find('#danjia');
        //面积
        var $mianji = $ele.find('#mianji');
        //开始计算按钮
        var $begin_btn = $ele.find('.btn-begin');
        //重新计算
        var $btn_reset = $ele.find('.btn-reset');
        //房款总价
        var $fkz3 = $ele.find('#fkz3');
        //契税        
        var $qs = $ele.find('#qs');
        //印花税
        var $yh = $ele.find('#yh');
        //委托办理产权手续费
        var $wt = $ele.find('#wt');
        //公证费
        var $gzh = $ele.find('#gzh');
        //房屋买卖手续费
        var $fw = $ele.find('#fw');
        //错误信息
        var $errormsg = $ele.find('.errormsg');
        //结果页面
        var $results = $ele.find('.results');
        //正确处理函数
        var onSuccessCallback = function(result) {
            var data = result.data;
            $fw.text(data.fw);
            $gzh.text(data.gzh);
            $qs.text(data.qs);
            $wt.text(data.wt);
            $yh.text(data.yh);
            $fkz3.text(data.zj);
            $errormsg.text('');
        };

        //错误处理函数
        var onErrorCallback = function(result) {
            $errormsg.text(result.msg);
        };
        var serialize_data = function() {
            var option = {};
            option.price = $danjia.val();
            option.size = $mianji.val();
            option.onSuccess = onSuccessCallback;
            option.onError = onErrorCallback;
            return option;
        };
        var obj_TaxCalculate = new TaxCalculate({});

        $begin_btn.click(function() {
            var option = serialize_data();
            obj_TaxCalculate.setOption(option);
            obj_TaxCalculate.run();
            return false;
        });
        //重新计算
        $btn_reset.click(function() {
            reset();
            return false;
        });

        function reset(){
            $danjia.val('');
            $mianji.val('');
            $results.find('em').text('');
        }

        return {
            reset : reset
        };
    }



    /*
    房贷计算
    option
    还款方式：等额本息 等额本金
    back_type
    贷款总额
    total
    贷款类别
    loanStyle

    公积金贷款
    商业贷款 首套房优惠(0.15)利率 基准利率 第二套房上浮利率(0.1)

    按揭年数
    year
    */
    function HouseLoanCalculate(option){
        if(!(this instanceof arguments.callee)){
            return new arguments.callee(option);
        }

        this.setOption(option);
        //回调
        this.class_Rate = new Rate(option);
        this._updatecallback = function() {};

        this.result = {};
        return this;
    }
    /*
     * run 计算
     * changeOption 改变参数
     * getRate 获取利率
     * getResult 获取结果
     * onRateUpdate 当rate更新
     * onResultUpdate 当结果更新
     * onError 当发生错误的时候
     * */
    HouseLoanCalculate.prototype = {
        constructor:HouseLoanCalculate,
        setOption:function(option) {
            this._option = option;
            //利率
            this._ratenum = option.ratenum || 3.5;
            //还款方式
            this._payStyle = option.payStyle;
            //贷款总额
            this._loanTotalData = option.loanTotalData;
            //贷款类别
            this._loanStyle = option.loanStyle;
            //按揭年数
            this._timeStyle = option.timeStyle;
            //利率
            this._rateStyle = option.rateStyle;
            return this;
        },
        updateRate:function() {
            var root = this;
            this.class_Rate.setOption(this._option);
            this.class_Rate.update(function(data) {
                root._updatecallback(data);
            });
        },
        calResult:function() {
            var root = this;
            if(!/\d+/.test(this._loanTotalData)){
                this._errorcallback({msg:'请正确填写贷款金额'})
                return;
            }
            $.ajax({
                'url' : window.calculate_url,
                'dataType' : 'jsonp',
                'type' : 'post',
                'data' : {
                    YII_CSRF_TOKEN : this._option.csrf,
                    rate_post : this._ratenum,
                    back_type : this._payStyle,
                    total : this._loanTotalData,
                    loanStyle : this._loanStyle,
                    year : this._timeStyle,
                    rateStyle : this._rateStyle
                },
                'success' : function(data){
                    root._calresultcallback(data);
                }
            });
            //var data = {
                //back_per_month: 1646.7433289148,
                //back_total: 395218.39893956,
                //extra: 175218.39893956,
                //month: 240,
                //rate: 6.55,
                //total: 220000,
                //rateType : 2
            //};
            //this._calresultcallback(data);
        },
        //设置回调
        setUpdateRateCallback:function(cb) {
            this._updatecallback = cb;
            return this;
        },
        //设置获取结果回调
        setCalResultCallback:function(cb) {
            this._calresultcallback = cb;
        },
        //设置错误时候的回调
        setErrorCallback:function(cb) {
            this._errorcallback = cb;
            return this;
        }
    };

    //房贷计算器界面交互
    function HouseLoanCalculateView(id){
        var $ele = id ? id : $('#houseloancal');

        //利率
        var $ratenum = $ele.find('#ratenum');
        //还款方式
        var $payStyle = $ele.find('#payStyle');
        //贷款总额
        var $loanTotalData = $ele.find('#loanTotalData');
        //贷款类别
        var $loanStyle = $ele.find('#loanStyle');
        //按揭年数
        var $timeStyle = $ele.find('#timeStyle');
        //利率
        var $rateStyle = $ele.find('#rateStyle');
        //开始计算按钮
        var $btn_begin = $ele.find('.btn-begin');
        //重新计算按钮
        var $btn_reset = $ele.find('.btn-reset');

        //还款总额
        var $paybackTotal = $ele.find('#paybackTotal');
        //支付利息
        var $payRateTotal = $ele.find('#payRateTotal');
        //贷款总额
        var $loanTotal = $ele.find('#loanTotal');
        //公积金贷款利率
        var $gRate = $ele.find('#gRate');
        //商业贷款利率
        var $sRate = $ele.find('#sRate');
        //月均还款
        var $avgPay = $ele.find('#avgPay');
        //贷款月数
        var $loanMonth = $ele.find('#loanMonth');
        //错误消息
        var $errormsg = $ele.find('.errormsg');

        //结果
        var $results = $ele.find('.results');

        var serialize_data = function(){
            var data = {};
            data.ratenum = $ratenum.text();
            data.payStyle = $payStyle.find('option:selected').val();
            data.loanTotalData = $loanTotalData.val();
            data.loanStyle = $loanStyle.find('option:selected').val();
            data.timeStyle = $timeStyle.find('option:selected').val();
            data.rateStyle = $rateStyle.find('option:selected').val();
            data.csrf = window.csrf;
            return data;
        };

        //处理逻辑对象
        var data = serialize_data();
        var obj_HouseLoanCalculate = new HouseLoanCalculate(data);
        var update_rate_callback = function(result) {
            $ratenum.text(result.rate);
        };

        var calresult_callback = function(result) {
            $paybackTotal.text(result.back_total);
            $payRateTotal.text(result.extra);
            $loanTotal.text(result.total);
            $loanMonth.text(result.month);
            $gRate.text(result.rate);
            if(result.rateType === 1){
                $gRate.text(result.rate);
            }else{
                $sRate.text(result.rate);
            }
            $avgPay.text(result.back_per_month);
            $errormsg.text('');
            return this;
        };

        var onErrorCallback = function(data) {
            $errormsg.text(data.msg);
        };

        //设置更新费率后的回调
        obj_HouseLoanCalculate.setUpdateRateCallback(update_rate_callback);
        //设置获取结果后的回调
        obj_HouseLoanCalculate.setCalResultCallback(calresult_callback);
        //设置发生错误时候的回调
        obj_HouseLoanCalculate.setErrorCallback(onErrorCallback);

        //贷款类别切换，利率显示
        $loanStyle.change(function() {
            if($(this).find('option:selected').val() == 2){
                $rateStyle.closest('li').removeClass('dn');
                $sRate.closest('li').removeClass('dn');
                $gRate.closest('li').addClass('dn');
            }
            else{
                $rateStyle.closest('li').addClass('dn');
                $gRate.closest('li').removeClass('dn');
                $sRate.closest('li').addClass('dn');
            }
            obj_HouseLoanCalculate.setOption(serialize_data());
            obj_HouseLoanCalculate.updateRate();
        });
        //利率浮动切换
        $rateStyle.change(function() {
            obj_HouseLoanCalculate.setOption(serialize_data());
            obj_HouseLoanCalculate.updateRate();
        });

        //时间浮动
        $timeStyle.change(function() {
            obj_HouseLoanCalculate.setOption(serialize_data());
            obj_HouseLoanCalculate.updateRate();
        });

        //开始计算
        $btn_begin.click(function() {
            obj_HouseLoanCalculate.setOption(serialize_data());
            obj_HouseLoanCalculate.calResult();
            return false;
        });
        //重新计算
        $btn_reset.click(function() {
            reset();
            return false;
        });
        function reset(){
            $payStyle.val('1');
            $loanTotalData.val('');
            $loanStyle.val(1).change();
            $timeStyle.val(20).change();
            $results.find('em').text('');
            $errormsg.text('');
        }
        return {
            reset : reset
        };
    }


    function HouseBuyCalculate(option) {
        if(!(this instanceof arguments.callee)){
            return new arguments.callee(option);
        }

        this.setOption(option);
        this.result = null;
        return this;
    }
    HouseBuyCalculate.prototype = {
        onSuccess:function() {
            return this;
        },
        onError : function() {
            return this;
        },
        setOption:function(option) {
            this.gfzj = option.gfzj;
            this.years = option.years;
            this.ysr = option.ysr;
            this.area = option.area;
            this.mouthPay = option.monthPay;
            this.onError = option.onError ? option.onError : this.onError;
            this.onSuccess = option.onSuccess ? option.onSuccess : this.onSuccess;           
            return this;
        },
        run : function() {
            //购房能力评估
            //gfzj 购房资金
            //years 您期望偿还贷款的年限
            //ysr 现家庭月收入
            //area 您计划购买房屋的面积
            //mouthPay 每月可用于购房支出

            var result = _HouseBuyCalculate(this.gfzj, this.years, this.ysr, this.area, this.mouthPay);
            if(result.state === false){
                this.onError(result);
            }else{
                this.onSuccess(result);
                this.result = result.data;
            }
            function _HouseBuyCalculate(gfzj,years,ysr,area,mouthPay){

                var rhb = new Array(440.104, 301.103, 231.7, 190.136, 163.753, 144.08,
                        129.379, 117.991, 108.923, 101.542, 95.425, 90.282, 85.902, 82.133,
                        78.861, 75.997, 73.473, 71.236, 69.241, 67.455, 65.848, 64.397,
                        63.082, 61.887, 60.798, 59.802, 58.890, 58.052, 57.282);

                var gfzj = parseFloat(gfzj) * 10000;
                var mouthPay = parseFloat(mouthPay);
                var js02 = Math.round(mouthPay / rhb[parseInt(years / 12 - 2)]) * 10000;
                var area = parseFloat(area);

                var msg = '';
                var state = false;
                var data = {};

                var back = function(state, msg, data){
                    var result = {
                        state : state,
                        msg : msg,
                        data : data
                    };
                    return result;
                }

                if (gfzj < 4.7){
                    msg = ("--您确定是" + gfzj + "万元?--" + "\n\n" + "那么您目前尚不具备购房能力，" + "\n\n" + "建议积攒积蓄或能筹集更多的资金。");
                    return back(state, msg, data);
                }

                if(gfzj/10000 > 10000){ 
                    msg = ("您确定拥有超过一亿元的购房资金？");
                    return back(state, msg, data);
                }

                if (mouthPay > ysr * 0.7) {
                    msg = ("您预计家庭每月可用于购房支出已超过家庭月收入的70%，" + "\n\n" + "是否确定不会影响您的正常生活消费？" + "\n\n" + "建议在40%（" + ysr * 0.4 + "元）左右");
                    return back(state, msg, data);
                }

                if (isNaN(gfzj)) {
                    msg = ("请正确填写现可用于购房的资金");
                    return back(state, msg, data);
                }
                if (ysr == ""){
                    msg = ("请正确填写现家庭月收入");
                    return back(state, msg, data);
                }
                if(isNaN(mouthPay)){
                    msg = ("请正确填写预计家庭每月可用于购房支出");
                    return back(state, msg, data);
                }
                if(isNaN(area)){
                    msg = ("请正确填写您计划购买房屋的面积");
                    return back(state, msg, data);
                }
                            
                state = true;
                if (js02 > gfzj * 3.2)
                    js02 = gfzj * 3.2;

                var totalprice = Math.round((js02 + 0.8 * gfzj) * 100) / 100;
                var unitprice = Math.round(parseFloat(totalprice) / area * 100) / 100;
                data = {
                    totalprice : totalprice,
                    unitprice : unitprice
                };
                return back(state, msg, data);
            }
        }
    };

    //购房能力评估界面
    function HouseBuyCalculateView(id){
        var $ele = id ? id : $('#housebuycal');
        //购房的资金
        var $gfzj = $ele.find('#gfzj');
        //您期望偿还贷款的年限
        var $years = $ele.find('#years');
        //现家庭月收入
        var $ysr = $ele.find('#ysr');
        //您计划购买房屋的面积
        var $area = $ele.find('#area');
        //每月可用于购房支出
        var $monthPay = $ele.find('#monthPay');
        //房屋总价
        var $totalprice = $ele.find('#totalprice');
        //房屋单价
        var $unitprice = $ele.find('#unitprice');

        //开始计算按钮
        var $begin_btn = $ele.find('.btn-begin');
        //重新计算按钮
        var $btn_reset = $ele.find('.btn-reset');
        //错误信息
        var $errormsg = $ele.find('.errormsg');
        //结果页面
        var $results = $ele.find('.results');

        //数据计算成功回调
        var onSuccessCallback = function(result) {
            var data = result.data;
            $totalprice.text(data.totalprice);
            $unitprice.text(data.unitprice);
            $errormsg.text('');
        };

        //数据计算失败回调
        var onErrorCallback = function(data) {
            $errormsg.text(data.msg);
        };
        var serialize_data = function() {
            var option = {};
            option.gfzj = $gfzj.val();
            option.years = $years.val();
            option.ysr = $ysr.val();
            option.area = $area.val();
            option.monthPay = $monthPay.val();
            option.onSuccess = onSuccessCallback;
            option.onError = onErrorCallback;
            return option;
        };
        var obj_HouseBuyCalculate = new HouseBuyCalculate({});

        $begin_btn.click(function() {
            var option = serialize_data();
            obj_HouseBuyCalculate.setOption(option);
            obj_HouseBuyCalculate.run();
            return false;
        });
        //重新计算
        $btn_reset.click(function() {
            reset();
            return false;
        });
        
        function reset(){
            $('#gfzj').val('');
            $('#ysr').val('');
            $('#monthPay').val('');
            $('#timeStyle').val(24);
            $('#area').val('');
            $errormsg.text('');
            $results.find('em').text('');
        }
        return {
            reset : reset
        };
    }

    //公积金贷款
    function PublicFundLoanCalculate(option) {
        if(!(this instanceof arguments.callee)) return new arguments.callee(option);
        this.setOption(option);
        this._result = null;
        this.class_Rate = new Rate(option);

        return this;
    }
    PublicFundLoanCalculate.prototype = {
        constructor:PublicFundLoanCalculate,
        setOption:function(option) {
            this._loanStyle = 1;
            this._timeStyle = option.timeStyle;
            this._payStyle = option.payStyle;
            this._loanTotalData = option.loanTotalData;
            this._ratenum = option.ratenum;

            this._option = {
                'loanStyle' : 1,
                'timeStyle' : option.timeStyle,
                'payStyle' : option.payStyle,
                'loanTotalData' : option.loanTotalData,
                'csrf' : option.csrf
            };
            return this;
        },
        updateRate:function() {
            var root = this;
            this.class_Rate.setOption(this._option);
            this.class_Rate.update(function(data) {
                root._updatecallback(data);
            });
        },
        _updatecallback:function(data) {
            console.log(data);
        },
        setUpdateRateCallback:function(cb) {
            this._updatecallback = cb;
            return this;
        },
        calResult:function() {
            var root = this;
            if( !/\d+/.test(this._loanTotalData) ) {
                var msg = ( '请正确点写贷款金额' );
                this.onError(msg);
                return;
            }
             $.ajax({
                'url' : window.calculate_url,
                'dataType' : 'jsonp',
                'type' : 'post',
                'data' : {
                    YII_CSRF_TOKEN : this._option.csrf,
                    rate_post : this._ratenum,
                    back_type : this._payStyle,
                    total : this._loanTotalData,
                    loanStyle : this._loanStyle,
                    year : this._timeStyle
                },
                'success' : function(data){
                    switch( $('#payStyle').val() ) {
                        case '1':
                            $('#ze22').html( data.back_per_month );
                            $('#lx2').html( data.back_total );
                            break;
                        case '2':
                            $('#sfk2').html( data['every'][1] );
                            $('#lx3').html( data.back_total );
                            break;
                    }
                    root._calresultcallback();
                }
            });

            //var d1 = {
                //back_per_month: 9553.4828775701,
                //back_total: 229283.58906168,
                //extra: 9283.5890616822,
                //month: 24,
                //rate: 4,
                //total: 220000
            //};
            //var d2 = {
                //back_total: 229166.66666667,
                //every: {1: 9900, 2: 9869.4444444444, 3: 9838.8888888889, 4: 9808.3333333333, 5: 9777.7777777778},
                //extra: 9166.6666666667,
                //month: 24,
                //rate: 4,
                //total: 220000
            //};
            //switch(this._payStyle){
                //case '1':
                    //this._calresultcallback(this._payStyle, d1);
                    //break;
                //case '2':
                    //this._calresultcallback(this._payStyle, d2);
                    //break;
                //default:
                    //break;
            //}
        },
        setCalResultCallback:function(cb) {
            this._calresultcallback = cb;
            return this;
        },
        setErrorCallback:function(cb) {
            this.onError = cb;
            return this;
        }
    };

    //公积金贷款页面
    function PublicFundLoanCalculateView(id){
        var $ele = id ? id : $('#gloancal');
        //利率
        var $ratenum = $ele.find('#ratenum');
        //贷款额度
        var $loanTotalData = $ele.find('#loanTotalData');
        //申请年限
        var $timeStyle = $ele.find('#timeStyle');
        //还款方式
        var $payStyle = $ele.find('#payStyle');
        //开始计算
        var $begin_btn = $ele.find('.btn-begin');
        //重新计算
        var $btn_reset = $ele.find('.btn-reset');

        //计算结果
        //等额均还
        //月均还款额
        var $ze22 = $ele.find('#ze22');
        //本息合计
        var $lx2= $ele.find('#lx2');
        //等额本金
        //首月还款额
        var $sfk2 = $ele.find('#sfk2');
        //本息合计
        var $lx3 = $ele.find('#lx3');
        //错误信息
        var $errormsg = $ele.find('.errormsg');

        //结果
        var $results = $ele.find('.results');


        //成功的回调处理
        var onSuccessCallback = function(type, result) {
            //if(type == 1){
                //$ze22.text(result.back_per_month);
                //$lx2.text(result.back_total);
            //}else if(type==2){
                //$sfk2.text(result.every[1]);
                //$lx3.text(result.back_total);
            //}
            $errormsg.text('');
        };
        //失败的回调处理
        var onErrorCallback = function(msg) {
            $errormsg.text(msg);
        };
        //获得利率回调处理
        var onRateUpdate= function(result) {
            $ratenum.text(result.rate);
        };

        var serialize_data = function() {
            var option = {};
            option.ratenum = $ratenum.text();
            option.loanTotalData = $loanTotalData.val();
            option.timeStyle = $timeStyle.find('option:selected').val();
            option.payStyle = $payStyle.find('option:selected').val();
            return option;
        };

        var obj_PublicFundLoanCalculate = PublicFundLoanCalculate({});

        obj_PublicFundLoanCalculate.setErrorCallback(onErrorCallback);
        obj_PublicFundLoanCalculate.setUpdateRateCallback(onRateUpdate);
        obj_PublicFundLoanCalculate.setCalResultCallback(onSuccessCallback);
        //开始计算
        $begin_btn.click(function() {
            var option = serialize_data();
            obj_PublicFundLoanCalculate.setOption(option);
            obj_PublicFundLoanCalculate.calResult();
            return false;
        });
        //更新利率
        $timeStyle.change(function() {
            var option = serialize_data();
            obj_PublicFundLoanCalculate.setOption(option);
            obj_PublicFundLoanCalculate.updateRate();
        });

        $btn_reset.click(function() {
            reset();
            return false;
        });
        //重新计算
        function reset(){
            $loanTotalData.val('');
            $timeStyle.val(20).change();
            $payStyle.val(1);
            $results.find('em').text('');
            $errormsg.text('');
        }
        return {
            reset : reset
        };
    }
    window.hj.calculate = {
        tax:TaxCalculateView,
        houseloan:HouseLoanCalculateView,
        housebuy:HouseBuyCalculateView,
        publickfundloan:PublicFundLoanCalculateView
    };

})(jQuery,window);

