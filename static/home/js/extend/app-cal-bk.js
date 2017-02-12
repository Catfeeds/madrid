//计算器
(function($, window) {

    //税费计算器
    //price 单价
    //size 面积
    var cal_data_event= new window.hj.Event();
    var cal_view_event= new window.hj.Event();


    function TaxCalculate(option){
        if(!(this instanceof TaxCalculate)){
            return new TaxCalculate(option);
        }
        this.price = option.price;
        this.size = option.size;
        this.onSuccess = option.onSuccess ? option.onSuccess : this.onSuccess;
        this.onError = option.onError ? option.onError : this.onError;
        this.result = {};
        return this;
    };

    TaxCalculate.prototype = {
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

    //房贷计算
    function HouseLoanCalculate(){
        

        function getTypeTitle() {
            var title = '';
            switch( $('#loanStyle').val() ) {
                case '1':
                    title = '公积金贷款利率';
                    break;
                case '2':
                    title = '商业贷款利率';
                    break;
            }
            
            return title;
        }

        function showRate() {
            $.ajax({
                'url' : '/loupan/jsq/getRate',
                'data' : {
                    'loan' : $('#loanStyle').val(),
                    'year' : $('#timeStyle').val(),
                    'rateStyle' : $('#rateStyle').val(),
                    'YII_CSRF_TOKEN' : $('#csrf').val()
                },
                'type' : 'post',
                'dataType' : 'jsonp',
                'success' : function(data){
                    title = getTypeTitle();
                    var rate = data.rate;
                    /*if( $('#loanStyle').val() == '2' ) {
                        rate = rate * $('#rateStyle').val();
                    }*/
                    $('#rate_post').val(rate);
                    $('#rate').html(title + ' <span id="rate_num">'+rate+'</span> <span class="color_red">(2012年7月6日基准利率)</span>');
                }
            });
        }

            $('#loanStyle').bind('change',function(){
                type_str = ''
                switch( $(this).val() ) {
                    case '1':
                        $('#rateStyleLi').hide();
                        $('#saleRateRight').hide();
                        $('#rateRight').show();
                        break;
                    case '2':
                        $('#rateStyleLi').show();
                        $('#saleRateRight').show();
                        $('#rateRight').hide();
                        break;
                }
                
                showRate(type_str);
            });

            $('#timeStyle').bind('change',function(){
                showRate();
            });
            
            $('#rateStyle').bind('change',function(){
                showRate();
            });

            $('#payStyle').bind('change',function(){
                switch( $(this).val() ) {
                    case '1':
                        $('#avgPay').show();
                        $('#fistBack').hide();
                        $('#lastBack').hide();
                        $('#loanList').hide();
                        break;
                    case '2':
                        $('#avgPay').hide();
                        $('#fistBack').show();
                        $('#lastBack').show();
                        $('#loanList').show();
                        break;
                }
            });

                //表单提交
                $('#calculatorButton').bind('click',function(){
                    if( !/\d+/.test( $('#loanTotalData').val() ) ) {
                        alert( '请正确点写贷款金额' );
                        return false;
                    }
                    
                    $.ajax({
                        'url' : '/loupan/jsq/getFangdaiInfo',
                        'dataType' : 'jsonp',
                        'type' : 'post',
                        'data' : $('#leftForm').serialize(),
                        'success' : function(data){
                            if( $('#payStyle').val() == '1' ) {
                                switch( $('#loanStyle').val() ) {
                                    case '1':
                                        $('#pTotal').html(data.back_total);
                                        $('#lTotal').html(data.total);
                                        $('#gRate').html(data.rate);
                                        $('#rTotal').html(data.extra);
                                        $('#monthT').html(data.month);
                                        $('#avgP').html(data.back_per_month);
                                        break;
                                    case '2':
                                        $('#pTotal').html(data.back_total);
                                        $('#lTotal').html(data.total);
                                        $('#bRate').html(data.rate);
                                        $('#rTotal').html(data.extra);
                                        $('#monthT').html(data.month);
                                        $('#avgP').html(data.back_per_month);
                                        break;
                                }
                            } else {
                                var last = '';
                                for( var i in data.every ) {
                                    $('#loanListBox').html( $('#loanListBox').html() + '第' + i + '月' + data['every'][i] + "\r\n" );
                                    last = data['every'][i];
                                }
                                
                                switch( $('#loanStyle').val() ) {
                                    case '1':
                                        $('#pTotal').html(data.back_total);
                                        $('#lTotal').html(data.total);
                                        $('#gRate').html(data.rate);
                                        $('#rTotal').html(data.extra);
                                        $('#monthT').html(data.month);
                                        $('#fisrtB').html(data['every']['1']);
                                        $('#lastB').html(last);
                                        break;
                                    case '2':
                                        $('#pTotal').html(data.back_total);
                                        $('#lTotal').html(data.total);
                                        $('#bRate').html(data.rate);
                                        $('#rTotal').html(data.extra);
                                        $('#monthT').html(data.month);
                                        $('#fisrtB').html(data['every']['1']);
                                        $('#lastB').html(last);
                                        
                                        break;
                                }
                            }
                        }
                    });
                });

                    showRate();
    }

    HouseBuyCalculate.prototype = {
        cal : function() {
            
        }
    };
    //购房能力评估
    //gfzj 购房资金
    //years 您期望偿还贷款的年限
    //ysr 现家庭月收入
    //area 您计划购买房屋的面积
    //mouthPay 每月可用于购房支出
    function HouseBuyCalculate(gfzj,years,ysr,area,mouthPay){

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
    //公积金贷款
    function PublicFundLoanCalculate() {

        var o = {
            getRateCallback : getRateCallback,
            checkLoanTotalData : checkLoanTotalData,
            getResultCallback : getResultCallback
        }
        function getRateCallback(param,cb) {
            $.ajax({
                'url' : '/loupan/jsq/getRate',
                'data' : {
                    'loan' : $('#loanStyle').val(),
                    'year' : $('#timeStyle').val(),
                    'rateStyle' : $('#rateStyle').val(),
                    'YII_CSRF_TOKEN' : $('#csrf').val()
                },
                'type' : 'post',
                'dataType' : 'jsonp',
                'success' : function(data){
                    var rate = data.rate;
                    
                    $('#rate_post').val(rate);
                    $('#rate').html( '公积金贷款利率' + ' <span id="rate_num">'+rate+'</span> <span class="color_red">(2012年7月6日基准利率)</span>');
                }
            });
        }
        function getResultCallback(param,cb){
            $.ajax({
                'url' : '/loupan/jsq/getFangdaiInfo',
                'dataType' : 'jsonp',
                'type' : 'post',
                'data' : $('#leftForm').serialize(),
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
                }
            });
        }

        function checkLoanTotalData() {
            var msg = '';
            var state = false;
            if( !/\d+/.test( $('#loanTotalData').val() ) ) {
                msg = ( '请正确点写贷款金额' );
            }else{
                state = true;
            }
            return {
                msg : msg,
                state : state
            };
        }

        return o;
        
        //$('#timeStyle').bind('change',function(){
            //showRate();
        //});
        
        //表单提交
        //$('#calculatorButton').bind('click',function(){
            //if( !/\d+/.test( $('#loanTotalData').val() ) ) {
                //alert( '请正确点写贷款金额' );
                //return false;
            //}
        //});
        //showRate();
    }


            window.hj.calculate = {
                tax:TaxCalculate,
                houseloan:HouseLoanCalculate,
                housebuy:HouseBuyCalculate,
                publickfundload:PublicFundLoanCalculate
            };

})(jQuery,window);

