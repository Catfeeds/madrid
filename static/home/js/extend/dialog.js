/* dialog.js
 * 统一的弹框插件
 * @type 0使用默认模版 1使用外部模版
 * @tempateid type=0 使用
 * 0 无备注
 * 1 有备注
 * 2 房贷计算器
 * 3 税费计算器
 * 4 购房能力评估
 * 5 公积金贷款
 * @domid type=1 使用 废弃
 * @title 模版中的标题
 * open() 打开
 * close() 关闭
 */
if('undefined' === typeof tradeTermsUrl ) tradeTermsUrl = '';
(function(window, $) {
    function Dialog(option){
        if(!(this instanceof arguments.callee)) return new arguments.callee(option);

        var type = option.type;
        var templateid = option.templateid;
        var domid = option.domid;
        var title = option.title;
        var onInit = option.onInit  ? option.onInit : this.onInit;
        var onOpenAfter = option.onOpenAfter ? option.onOpenAfter: this.onOpenAfter;
        var width = option.width ? option.width : 560;

        this._type = type;
        this._templateid = templateid;
        this._domid = domid;
        this._title = title;
        this._width = width;
        this.onInit = onInit;
        this.onOpenAfter = onOpenAfter;
        this.onBeforeOpen = option.onBeforeOpen ? option.onBeforeOpen : this.onBeforeOpen;

        this._option = option;
        this._init();
        this.onInit(this);
        this.onOpenAfter(this);
        return this;
    }
    Dialog.prototype = {
        constructor:Dialog,
        _opencls:'ui-dialog-open',
        _init:function() {
            var html = '';
            var title = this._title;
            var $html = null;
            var obj_templates = this._templates;
            var tempateid = this._templateid;

            html = obj_templates[tempateid]['tpl'];

            html = '<div class="ui-dialog-wrap"><div class="ui-dialog"><div class="ui-dialog-body">' + html + '</div></div><div class="ui-dialog-mask"></div></div>';
            $html = $(html);
            if(title)
                $html.find('.title').html(title);

            $('body').append($html);
            //添加后计算高度
            var h = $html.find('.ui-dialog-body').height();
            $html.remove();
            $html.find('.ui-dialog-body').css('top', - 1/2 * h + 'px');

            //默认a.close点击后关闭
            var root = this;
            $html.find('a.close').click(function() {
                root.close();
                return false;
            });
            this._html = $html;
            return this;
        },
        onBeforeOpen:function() {
            
        },
        open:function() {
            this.onBeforeOpen();
            var $html = this._html;
            var opencls = this._opencls;
            var width = this._width;
            if($html){
                $('body').append($html);
            }

            var index = layer.open({
                type: 1,
                shade: .3,
                title: false, //不显示标题
                content: $html, //捕获的元素
                area:width + "px",
                closeBtn:false //不显示关闭按钮
            });
            this.index = index;
            return this;
        },
        close:function() {
            var index = this.index;

            if(index){
                layer.close(index);
            }
            return this;
        },
        remove:function() {
            var $html = this._html;
            $html.remove();
            this._html = null;
            return this;
        },
        onInit : function() {
            return this;
        },
        onOpenAfter:function() {
            
        },
        getDom:function() {
            return this._html;
        },
        setData:function(data) {
            this.data = data;
            return this;
        },
        getData:function(data) {
            return this.data;
        },
        setTitle:function(title) {
            this._html.find('h1.title').text(title);
            return this;
        },
        setNote:function(note) {
            this._html.find('.note').text(note);
            return this;
        },
        reset:function() {
            this._html.find('.name input, .phone input, .note input').val('');
            this._html.find('input[type="checkbox"]').prop('checked',true);
            this._html.find('input[type="submit"]').removeClass('disabled').prop('disabled','');
            return this;
        }
    };

    Dialog.prototype._templates = [];
    Dialog.prototype._templates[0] = {
        tpl : ['<div class="form-1 ui-checkform">',
        '            <a class="close" href=""></a>',
        '            <div class="title-bg">',
        '            <h1 class="title">降价通知我</h1>',
        '            <p class="desc">√团购价折扣优惠 √额外礼包 √专属顾问提供购房指导</p>',
        '            </div>',
        '            <form action="">',
        '                <div class="ele name">',
        '                    <i class="kanfangicon icon-17"></i><input id="" type="text" name="" placeholder="姓名" datatype="s1-16" nullmsg="请输入姓名" errormsg="姓名至少1个字符！">',
        '                </div>',
        '                <div class="ele phone">',
        '                    <i class="kanfangicon icon-18"></i><input id="" type="text" name="" placeholder="手机号" datatype="m" nullmsg="请输入手机号" errormsg="手机号码格式不正确">',
        '                </div>',
        '                <div class="errormsg"></div>',
    '<div class="agreement"><label><input id="" type="checkbox" checked="true" name="" />我已阅读并同意</label><a href="'+ tradeTermsUrl +'" target="_blank">《房产交易条款》</a></div>',
        '                <div class="submit">',
        '                    <input type="submit" value="立即提交">',
        '                </div>',
        '            </form>',
        '        </div>'].join(""),
        events:{}
    };
    

    Dialog.prototype._templates[1] = {
        tpl:
    ['<div class="form-1">',
    '            <a class="close" href=""></a>',
    '            <div class="title-bg">',
    '            <h1 class="title">立即参团</h1>',
    '            <p class="desc">√团购价折扣优惠 √额外礼包 √专属顾问提供购房指导</p>',
    '            </div>',
    '            <form action="">',
    '                <div class="ele name">',
    '                    <i class="kanfangicon icon-17"></i><input id="" type="text" name="" placeholder="姓名" datatype="s1-16" nullmsg="请输入姓名" errormsg="姓名至少1个字符！">',
    '                </div>',
    '                <div class="ele phone">',
    '                    <i class="kanfangicon icon-18"></i><input id="" type="text" name="" placeholder="手机号" datatype="m" nullmsg="请输入手机号" errormsg="手机号码格式不正确">',
    '                </div>',
    '                <div class="ele note">',
    '                    <i class="kanfangicon icon-19"></i><input id="" type="text" name="" placeholder="备注">',
    '                </div>',
    '<div class="agreement"><label><input id="" type="checkbox" checked="true" name="" />我已阅读并同意</label><a href="'+ tradeTermsUrl +'" target="_blank">《房产交易条款》</a></div>',
    '                <div class="submit">',
    '                    <input type="submit" value="立即提交">',
    '                </div>',
    '            </form>',
    '        </div>'].join(""),
        events:{}
    };

    Dialog.prototype._templates[2] = {
        tpl:
['        <div class="cal-1" id="houseloancal">',
'            <a class="close" href=""></a>',
'            <h1 class="title">房贷计算器</h1>',
'            <p class="rate">公积金贷款利率 <span id="ratenum">3.5</span> (2015年6月28日基准利率)</p>',
'            <div class="options">',
'                <ul>',
'                    <li>',
'                        <dl>',
'                          <dt>还款方式：</dt>',
'                          <dd><select id="payStyle"><option selected="selected" value="1">等额本息</option><option value="2">等额本金</option></select></dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>贷款总额：</dt>',
'                          <dd><input id="loanTotalData" type="text" name="" class="text-input"/>万元</dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>贷款类别：</dt>',
'                          <dd><select id="loanStyle" name=""><option selected="selected" value="1">公积金贷款</option><option value="2">商业贷款</option></select></dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>按揭年数：</dt>',
'                          <dd><select size="1" class="timeStyle" id="timeStyle" name="year" style="width:160px"><option value="1">1年&nbsp;(12期)</option><option value="2">2年&nbsp;(24期)</option><option value="3">3年&nbsp;(36期)</option><option value="4">4年&nbsp;(48期)</option><option value="5">5年&nbsp;(60期)</option><option value="6">6年&nbsp;(72期)</option><option value="7">7年&nbsp;(84期)</option><option value="8">8年&nbsp;(96期)</option><option value="9">9年&nbsp;(108期)</option><option value="10">10年&nbsp;(120期)</option><option value="11">11年&nbsp;(132期)</option><option value="12">12年&nbsp;(144期)</option><option value="13">13年&nbsp;(156期)</option><option value="14">14年&nbsp;(168期)</option><option value="15">15年&nbsp;(180期)</option><option value="16">16年&nbsp;(192期)</option><option value="17">17年&nbsp;(204期)</option><option value="18">18年&nbsp;(216期)</option><option value="19">19年&nbsp;(228期)</option><option selected="selected" value="20">20年&nbsp;(240期)</option><option value="25">25年&nbsp;(300期)</option><option value="30">30年&nbsp;(360期)</option></select></dd>',
'                        </dl>',
'                    </li>',
'                    <li class="lilv dn">',
'                        <dl>',
'                          <dt>利率：</dt>',
'                          <dd><select size="1" class="rateStyle" id="rateStyle" name="rateStyle"><option value="0.85">首套房优惠(0.15)利率</option><option selected="" value="1">基准利率</option><option value="1.1">第二套房上浮利率(0.1)</option></select></dd>',
'                        </dl>',
'                    </li>',
'                </ul>',
'            </div>',
'            <div class="blank5"></div>',
'            <div class="errormsg"></div>',
'            <div class="btns">',
'                <a href="" class="btn-begin">开始计算</a><a href="" class="btn-reset">重新计算</a>',
'            </div>',
'            <div class="results clearfix">',
'                <h2>查看结果（以下结果仅供参考）</h2>',
'                <ul>',
'                  <li><label>还款总额：</label><em id="paybackTotal"></em></li>',
'                  <li><label>支付利息：</label><em id="payRateTotal"></em></li>',
'                  <li><label>贷款总额：</label><em id="loanTotal"></em></li>',
'                  <li><label>贷款月数：</label><em id="loanMonth"></em></li>',
'                  <li><label>公积金贷款利率：</label><em id="gRate"></em></li>',
'                  <li class="dn"><label>商业贷款利率：</label><em id="sRate"></em></li>',
'                  <li><label>月均还款：</label><em id="avgPay"></em></li>',
'                </ul>',
'            </div>',
'            <div class="tips">',
'                <h3>等额本息还款方式：</h3>',
'                <p>在还款期内，每月偿还同等数额的贷款（包括本金和利息），这样由于每月的还款额固定，可以有计划地控制家庭收入的支出，也便于每个家庭根据自己的收入情况，确定还贷能力。</p>',
'            </div>',
'        </div>'].join(""),
        events:{}
    };

    Dialog.prototype._templates[3] = {
        tpl:
['        <div class="cal-1" id="taxcal">',
'            <a class="close" href=""></a>',
'            <h1 class="title">税费计算器</h1>',
'            <div class="options">',
'                <ul>',
'                    <li>',
'                        <dl>',
'                          <dt>单&#160;&#160;价：</dt>',
'                          <dd><input id="danjia" type="text" name="danjia" class="text-input"/>元/平方</dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>面&#160;&#160;积：</dt>',
'                          <dd><input id="mianji" type="text" name="mianji" class="text-input"/>平方米</dd>',
'                        </dl>',
'                    </li>',
'                </ul>',
'            </div>',
'            <div class="errormsg"></div>',
'            <div class="btns">',
'                <a href="" class="btn-begin">开始计算</a><a href="" class="btn-reset">重新计算</a>',
'            </div>',
'            <div class="results clearfix">',
'                <h2>查看结果（以下结果仅供参考）</h2>',
'                <ul>',
'                  <li><label>房款总价：</label><em id="fkz3"></em></li>',
'                  <li><label>契&#160;&#160;&#160;&#160;税：</label><em id="qs"></em></li>',
'                  <li><label>印&#160;花&#160;税：</label><em id="yh"></em></li>',
'                  <li><label>委托办理产权手续费：</label><em id="wt"></em></li>',
'                  <li><label>公&#160;证&#160;费：</label><em id="gzh"></em></li>',
'                  <li><label>房屋买卖手续费：</label><em id="fw"></em></li>',
'                </ul>',
'            </div>',
'            <div class="tips">',
'                <h3 class="fs-big">税费：</h3>',
'                <p>1. 购房需交纳的第一组税费是契税、印花税、交易手续费、权属登记费。<br/>2. 契税金额是房价的1.5%，一般情况下是在交易签证时交50%，入住后拿房产证时交50%。<br/>3. 印花税金额为房价的0.05%，在交易签证时交纳。<br/>4. 交易手续费一般是每平方米2.5元，也在交易签证时交纳。<br/>5. 权属登记费100元到200元之间。</p>',
'            </div>',
'        </div>'].join(""),
        events:{}
    };

    Dialog.prototype._templates[4] = {
        tpl:
['        <div class="cal-1" id="housebuycal">',
'            <a class="close" href=""></a>',
'            <h1 class="title">购房能力评估</h1>',
'            <div class="options clearfix">',
'                <ul class="clearfix">',
'                    <li>',
'                        <dl>',
'                          <dt class="w140">可用于购房的资金：</dt>',
'                          <dd><input id="gfzj" type="text" name="" class="text-input"/>万元</dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>您期望偿还贷款的年限：</dt>',
'                          <dd><select style="width:160px;" name="rg04" class="timeStyle" size="1" id="years"><option value="24">2年&nbsp;(24期)</option><option value="36">3年&nbsp;(36期)</option><option value="48">4年&nbsp;(48期)</option><option value="60">5年&nbsp;(60期)</option><option value="72">6年&nbsp;(72期)</option><option value="84">7年&nbsp;(84期)</option><option value="96">8年&nbsp;(96期)</option><option value="108">9年&nbsp;(108期)</option><option value="120">10年&nbsp;(120期)</option><option value="180">15年&nbsp;(180期)</option><option value="240" selected="selected">20年&nbsp;(240期)</option><option value="300">25年&nbsp;(300期)</option><option value="360">30年&nbsp;(360期)</option></select></dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt class="w140">现家庭月收入：</dt>',
'                          <dd><input id="ysr" type="text" name="" class="text-input"/>元</dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>您计划购买房屋的面积：</dt>',
'                          <dd><input id="area" type="text" name="" class="text-input"/>平方米</dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt class="w140">每月可用于购房支出：</dt>',
'                          <dd><input id="monthPay" type="text" name="" class="text-input"/>元</dd>',
'                        </dl>',
'                    </li>',
'                </ul>',
'            </div>',
'            <div class="errormsg"></div>',
'            <div class="btns">',
'                <a href="" class="btn-begin">开始计算</a><a href="" class="btn-reset">重新计算</a>',
'            </div>',
'            <div class="results clearfix">',
'                <h2>查看结果（以下结果仅供参考）</h2>',
'                <ul>',
'                  <li><label>您可购买的房屋总价为：</label><em id="totalprice"></em></li>',
'                  <li><label>您可购买的房屋单价为：</label><em id="unitprice"></em></li>',
'                </ul>',
'            </div>',
'            <div class="tips">',
'                <h3 class="fs-big">购房能力评估：</h3>',
'                <p>1. 北京公积金贷款最高额度为80万元人民币左右；<br/>2. 对已贷款购买一套住房但人均面积低于当地平均水平，再申请购买第二套普通自住房的居民，比照执行首次贷款购买普通自住房的优惠政策。</p>',
'            </div>',
'        </div>'].join(""),
        events:{}
    };

    Dialog.prototype._templates[5] = {
        tpl:
['        <div class="cal-1" id="gloancal">',
'            <a class="close" href=""></a>',
'            <h1 class="title">公积金贷款计算器</h1>',
'            <p class="rate">公积金贷款利率 <span id="ratenum">3.5</span> (2015年6月28日基准利率))</p>',
'            <div class="options clearfix">',
'                <ul>',
'                    <li>',
'                        <dl>',
'                          <dt>您所需要的贷款额度：</dt>',
'                          <dd><input id="loanTotalData" type="text" name="" class="text-input"/>万元</dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt>贷款申请年限：</dt>',
'                          <dd><select size="1" class="timeStyle" id="timeStyle" name="year" style="width:160px"><option value="1">1年&nbsp;(12期)</option><option value="2">2年&nbsp;(24期)</option><option value="3">3年&nbsp;(36期)</option><option value="4">4年&nbsp;(48期)</option><option value="5">5年&nbsp;(60期)</option><option value="6">6年&nbsp;(72期)</option><option value="7">7年&nbsp;(84期)</option><option value="8">8年&nbsp;(96期)</option><option value="9">9年&nbsp;(108期)</option><option value="10">10年&nbsp;(120期)</option><option value="11">11年&nbsp;(132期)</option><option value="12">12年&nbsp;(144期)</option><option value="13">13年&nbsp;(156期)</option><option value="14">14年&nbsp;(168期)</option><option value="15">15年&nbsp;(180期)</option><option value="16">16年&nbsp;(192期)</option><option value="17">17年&nbsp;(204期)</option><option value="18">18年&nbsp;(216期)</option><option value="19">19年&nbsp;(228期)</option><option selected="selected" value="20">20年&nbsp;(240期)</option><option value="25">25年&nbsp;(300期)</option><option value="30">30年&nbsp;(360期)</option></select></dd>',
'                        </dl>',
'                    </li>',
'                    <li>',
'                        <dl>',
'                          <dt class="w140">请选择还款方式：</dt>',
'                          <dd><select id="payStyle" name="back_type" size="1"><option value="1">等额均还</option><option value="2">等额本金</option></select></dd>',
'                        </dl>',
'                    </li>',
'                </ul>',
'            </div>',
'            <div class="errormsg"></div>',
'            <div class="btns">',
'                <a href="" class="btn-begin">开始计算</a><a href="" class="btn-reset">重新计算</a>',
'            </div>',
'            <div class="results clearfix">',
'                <h2>查看结果（以下结果仅供参考）</h2>',
'                <ul>',
'                  <li><label for="">等额均还&#160;月均还款额：</label><em id="ze22"></em></li>',
'                  <li><label for="">本息合计：</label><em id="lx2"></em></li>',
'                  <li><label for="">等额本金&#160;首月还款额：</label><em id="sfk2"></em></li>',
'                  <li><label for="">本息合计：</label><em id="lx3"></em></li>',
'                </ul>',
'            </div>',
'        </div>'].join(""),
        events:{}
    };

    Dialog.prototype._templates[6] = {
        tpl:
['        <div class="form-1 success-1">',
'            <a class="close" href=""></a>',
'            <h1 class="title">提交成功</h1>',
'            <div class="icon"></div>',
'            <p class="note">提交成功，我们会尽快与您取得联系</p>',
'            <a class="state-btn">知道了</a>',
'        </div>'].join("")
    };

    Dialog.prototype._templates[7] = {
        tpl:
['        <div class="form-1 error-1">',
'            <a class="close" href=""></a>',
'            <h1 class="title">提交失败</h1>',
'            <div class="icon"></div>',
'            <p class="note">请不要重复提交，否则小编会发狂哦！</p>',
'            <a class="state-btn">知道了</a>',
'        </div>'].join("")
    };

    Dialog.prototype._templates[8] = {
        tpl : 
['    <div class="form-1 ui-checkform">',
'        <a class="close" href=""></a>',
'        <div class="title-bg">',
'            <h1 class="title">免费通话</h1>',
'            <p class="desc tels">您现在呼叫的是<em>中环CBD</em>售楼处电话：<span>400-8181-365转175310</span></p>',
'        </div>',
'        <div class="step3"></div>',
'        <form method="post">',
'            <dl class="free-tel clearfix">',
'                <dt>手机号码：</dt>',
'                <dd>',
'                    <div class="ele phone"><input id="" type="text" name="" placeholder="请输入您的手机号或固话" datatype="m" nullmsg="请输入手机号" errormsg="手机号码格式不正确"/></div>',
'                    <p>固定电话，请先填写区号  例如：0105891000</p>',
'                </dd>',
'            </dl>',
'            <dl class="free-tel clearfix">',
'                <dt>验证码：</dt>',
'                <dd>',
'                    <div class="w-frame">',
'                        <div class="ele yanzhengma fl"><input id="yzm" type="text" name="" placeholder=""  datatype="identifycode" nullmsg="请输入验证码" errormsg="验证码不正确"/> </div>',
'                        <div class="right-yanzheng">',
                            '<img src="/home/plot/captcha" class="changepic" onclick="this.src=\'/home/plot/captcha?\'+Math.random();""/>',
                            '<a onclick="$(\'.changepic\').attr(\'src\',\'/home/plot/captcha?\'+ Math.random());">换一换</a>',
                        '</div>',
                     '</div>',
'                    <p class=" ">过程中100%完全免费绝不产生任何长途、市话费用！</p>',
'                </dd>',
'            </dl>',
'           <div class="blank10"></div>',
'            <div class="submit">',
'                <input type="submit" value="免费通话" />',
'            </div>',
'        </form>',
'    </div>'].join("")
    };
    window.hj.Dialog = Dialog;

})(window, jQuery);
