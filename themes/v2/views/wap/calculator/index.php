<?php
$this->pageTitle = SM::GlobalConfig()->siteName().'房贷计算器-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['keyword']?SM::seoConfig()->homeIndexIndex()['keyword']:(SM::urmConfig()->cityName().'房地产门户，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房地信息网，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'房地产网，'.SM::urmConfig()->cityName().'房屋出租，'.SM::GlobalConfig()->siteName().'房产'),'keywords');
Yii::app()->clientScript->registerMetaTag(SM::seoConfig()->homeIndexIndex()['desc']?SM::seoConfig()->homeIndexIndex()['desc']:(SM::GlobalConfig()->siteName().'房产网是'.SM::urmConfig()->cityName().'最热最专业的网络房产平台，提供全面及时的'.SM::urmConfig()->cityName().'房产楼市资讯，'.SM::urmConfig()->cityName().'房产楼盘信息、最新'.SM::urmConfig()->cityName().'房价、买房流程、业主论坛等高质量内容，为广大网友提供全方面的买房服务。了解'.SM::urmConfig()->cityName().'房产最新优惠信息就上'.SM::GlobalConfig()->siteName().'房产网'),'description');
$this->registerHeadJs(['jquery.min','validform.min','cal']);
?>
<link rel="stylesheet" href="<?=Yii::app()->theme->baseUrl.'/static/wap/style/calculator.css'?>" media="screen" title="no title" charset="utf-8">
<div class="ui-wrapper" >

<?php $this->renderPartial('/layouts/header',['title'=>'计算器']) ?>

<div class="ui-tab calc-main" >
<div class="ui-tab-nav ui-tab-full" >
    <a class="ui-tab-link current" href="javascript:;" onclick="$('#js-calc-tit').html($(this).html()+'计算器')">商业贷款</a>
    <a class="ui-tab-link" href="javascript:;" onclick="$('#js-calc-tit').html($(this).html()+'计算器')">公积金贷款</a>
    <a class="ui-tab-link" href="javascript:;" onclick="$('#js-calc-tit').html($(this).html()+'计算器')">组合贷款</a>
    <a class="ui-tab-link" href="javascript:;" onclick="$('#js-calc-tit2').html($(this).html()+'计算器')">税费计算</a>
</div>
<div class="ui-tab-con">
    <!-- 商业贷款 start -->
    <div class="ui-tab-item show mt20">
        <form id="sydk-form" class="ui-form form" action="">
            <div class="ui-tab-nav calc-type gw bg-fff clearfix">
                <a class="current total-btn" href="javascript:;" on=1>总价计算</a>
                <a class="single-btn" href="javascript:;" on=0>单价计算</a>
            </div>
            <div class="bg-fff">
                <ul class="ui-list ui-list-arrows mt20 bb0 single-calc" style="display:none">
                    <li class="ui-list-item no-arrows">
                        <div  class="ui-form-field">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价</div>
                        <div class="ui-form-controls"><input id="sy-dj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请输入单价" data-error="请填写正确的单价"></div>
                        <div class="unit">元/㎡</div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div  class="ui-form-field">面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积</div>
                        <div class="ui-form-controls"><input id="sy-mj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请输入面积" data-error="请填写正确的面积"></div>
                        <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;㎡</div>
                    </li>
                </ul>

                <ul class="ui-list ui-list-arrows mt20 bb0" style="border-top:0;">
                    <li class="ui-list-item no-arrows total-calc">
                        <div class="ui-form-field">贷款总额</div>
                        <div class="ui-form-controls"><input id="sy-bj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请输入贷款总额" data-error="请输入正确的贷款总额"></div>
                        <div class="unit">万元</div>
                    </li>
                    <li class="ui-list-item single-calc" style="display:none">
                        <div class="ui-form-field">按揭成数</div>
                        <div class="ui-form-controls ui-custom-select">
                            <input id="sy-cs" type="text" class="ui-input-text" data-type="*" data-null="请选择按揭成数" value="7成">
    							<select class="ui-form-select" data-type="*" data-null="请选择按揭成数" name="">

    								<option {if="" $i="=7}selected{/if}" value="1">1成</option>


    								<option {if="" $i="=7}selected{/if}" value="2">2成</option>


    								<option {if="" $i="=7}selected{/if}" value="3">3成</option>


    								<option {if="" $i="=7}selected{/if}" value="4">4成</option>


    								<option {if="" $i="=7}selected{/if}" value="5">5成</option>


    								<option {if="" $i="=7}selected{/if}" value="6">6成</option>


    								<option {if="" $i="=7}selected{/if}" value="7">7成</option>


    								<option {if="" $i="=7}selected{/if}" value="8">8成</option>


    								<option {if="" $i="=7}selected{/if}" value="9">9成</option>

    															</select>
                        </div>
                    </li>
                    <li class="ui-list-item">
                        <div class="ui-form-field">按揭年数</div>
                        <div class="ui-form-controls ui-custom-select">
                            <input  id="sy-ns" type="text" class="ui-input-text js-year" data-type="*" data-null="请选择按揭年数" value="20年（240期）">
    							<select class="ui-form-select" data-type="*" data-null="请选择按揭年数" name="">

    								<option {if="" $i="=20}selected{/if}" value="1">1年（12期）</option>


    								<option {if="" $i="=20}selected{/if}" value="2">2年（24期）</option>


    								<option {if="" $i="=20}selected{/if}" value="3">3年（36期）</option>


    								<option {if="" $i="=20}selected{/if}" value="4">4年（48期）</option>


    								<option {if="" $i="=20}selected{/if}" value="5">5年（60期）</option>


    								<option {if="" $i="=20}selected{/if}" value="6">6年（72期）</option>


    								<option {if="" $i="=20}selected{/if}" value="7">7年（84期）</option>


    								<option {if="" $i="=20}selected{/if}" value="8">8年（96期）</option>


    								<option {if="" $i="=20}selected{/if}" value="9">9年（108期）</option>


    								<option {if="" $i="=20}selected{/if}" value="10">10年（120期）</option>


    								<option {if="" $i="=20}selected{/if}" value="11">11年（132期）</option>


    								<option {if="" $i="=20}selected{/if}" value="12">12年（144期）</option>


    								<option {if="" $i="=20}selected{/if}" value="13">13年（156期）</option>


    								<option {if="" $i="=20}selected{/if}" value="14">14年（168期）</option>


    								<option {if="" $i="=20}selected{/if}" value="15">15年（180期）</option>


    								<option {if="" $i="=20}selected{/if}" value="16">16年（192期）</option>


    								<option {if="" $i="=20}selected{/if}" value="17">17年（204期）</option>


    								<option {if="" $i="=20}selected{/if}" value="18">18年（216期）</option>


    								<option {if="" $i="=20}selected{/if}" value="19">19年（228期）</option>


    								<option {if="" $i="=20}selected{/if}" value="20">20年（240期）</option>


    								<option {if="" $i="=20}selected{/if}" value="21">21年（252期）</option>


    								<option {if="" $i="=20}selected{/if}" value="22">22年（264期）</option>


    								<option {if="" $i="=20}selected{/if}" value="23">23年（276期）</option>


    								<option {if="" $i="=20}selected{/if}" value="24">24年（288期）</option>


    								<option {if="" $i="=20}selected{/if}" value="25">25年（300期）</option>


    								<option {if="" $i="=20}selected{/if}" value="26">26年（312期）</option>


    								<option {if="" $i="=20}selected{/if}" value="27">27年（324期）</option>


    								<option {if="" $i="=20}selected{/if}" value="28">28年（336期）</option>


    								<option {if="" $i="=20}selected{/if}" value="29">29年（348期）</option>


    								<option {if="" $i="=20}selected{/if}" value="30">30年（360期）</option>

    															</select>
                        </div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div class="ui-form-field" >银行利率</div>
                        <div class="ui-form-controls ui-custom-select js-rate">
                            <input id="sy-lv" type="text" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请设置银行利率" data-error="请填写正确的银行利率" value="5.15" rate1="5.1" rate2="5.5" rate3="5.15">
                                <select name="" class="">
    							<!-- rate值是由后台传过来的利率 -->
    							<!-- rat1:小于5年利率 rate2:五年以上利率 -->
                                    <option value="0" rate1="5.1" rate2="5.5" rate3="5.15">2015年5月11日 基准利率</option>
                                    <option value="1" rate1="5.355" rate2="5.775" rate3="5.9325">2015年5月11日 上浮5%</option>
                                    <option value="2" rate1="5.61" rate2="6.05" rate3="6.215">2015年5月11日 上浮10%</option>
                                    <option value="3" rate1="5.35" rate2="5.75" rate3="5.9">2015年3月1日 基准利率</option>
                                    <option value="4" rate1="5.6175" rate2="6.0375" rate3="6.195">2015年3月1日 上浮5%</option>
                                    <option value="5" rate1="5.885" rate2="6.325" rate3="6.49">2015年3月1日 上浮10%</option>
                                    <option value="6" rate1="5.6" rate2="6" rate3="6.15">2014年11月22日 基准利率</option>
                                    <option value="7" rate1="5.88" rate2="6.3" rate3="6.4575">2014年11月22日 上浮5%</option>
                                    <option value="8" rate1="6.16" rate2="6.6" rate3="6.765" selected="selected">2014年11月22日 上浮10%</option>
                                </select>

                        </div>
                        <div class="persent" >%<a href="javascript:;"><span>修改</span></a></div>
                    </li>
                </ul>
                <div class="js-return-way">
                    <ul class="ui-list mt20 bb0 way-tag" style="border-top:0;">
                        <li class="ui-list-item" style="border-top:0;">
                            <div class="ui-form-field">还款方式</div>
                            <div class="ui-form-controls">
                                <label class="ui-form-label bx"><input type="radio" name="return-way" class="ui-input-radio"  checked on=1>等额本息</label>
                                <label class="ui-form-label bj"><input type="radio" name="return-way" class="ui-input-radio" value="0" on=0>等额本金</label>
                            </div>
                        </li>
                    </ul>
                    <div class="way-tip bx-tip" style="display:block">每月还款额固定，所还总利息较多，适合收入稳定者。</div>
                    <div class="way-tip bj-tip" style="display:none">每月还款额递减，所还总利息较低，前期还款额较大。</div>
                </div>
            </div>


            <div class="ui-btn-wrap">
                <input id="sy-calc-start" type="submit" class="ui-btn ui-btn-danger" value="开始计算">
            </div>
        </form>
    </div>
    <!-- 商业贷款 end -->

    <!-- 公积金贷款 start -->
    <div class="ui-tab-item mt20">
        <form id="gjjdk-form" class="ui-form" action="">
            <div class="ui-tab-nav calc-type gw bg-fff clearfix">
                <a class="current total-btn" href="javascript:;" on=1>总价计算</a>
                <a class="single-btn" href="javascript:;" on=0>单价计算</a>
            </div>
            <div class="bg-fff">
                <ul class="ui-list ui-list-arrows mt20 bb0 single-calc" style="display:none">
                    <li class="ui-list-item no-arrows">
                        <div  class="ui-form-field">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价</div>
                        <div class="ui-form-controls"><input id="gjj-dj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写单价" data-error="请填写正确的单价"></div>
                        <div class="unit">元/㎡</div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div  class="ui-form-field">面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积</div>
                        <div class="ui-form-controls"><input id="gjj-mj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写面积" data-error="请填写正确的面积"></div>
                        <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;㎡</div>
                    </li>
                </ul>

                <ul class="ui-list ui-list-arrows mt20 bb0">
                    <li class="ui-list-item no-arrows total-calc">
                        <div class="ui-form-field">贷款总额</div>
                        <div class="ui-form-controls"><input id="gjj-bj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写贷款总额" data-error="请填写正确的贷款总额"></div>
                        <div class="unit">万元</div>
                    </li>
                    <li class="ui-list-item single-calc" style="display:none">
                        <div class="ui-form-field">按揭成数</div>
                        <div class="ui-form-controls ui-custom-select">
                            <input id="gjj-cs" type="text" class="ui-input-text" data-type="*" data-null="请选择按揭成数" value="7成">
    <select class="ui-form-select" data-type="*" data-null="请选择按揭成数" name="">

    								<option {if="" $i="=7}selected{/if}" value="1">1成</option>


    								<option {if="" $i="=7}selected{/if}" value="2">2成</option>


    								<option {if="" $i="=7}selected{/if}" value="3">3成</option>


    								<option {if="" $i="=7}selected{/if}" value="4">4成</option>


    								<option {if="" $i="=7}selected{/if}" value="5">5成</option>


    								<option {if="" $i="=7}selected{/if}" value="6">6成</option>


    								<option {if="" $i="=7}selected{/if}" value="7">7成</option>


    								<option {if="" $i="=7}selected{/if}" value="8">8成</option>


    								<option {if="" $i="=7}selected{/if}" value="9">9成</option>

    															</select>
                        </div>
                    </li>
                    <li class="ui-list-item">
                        <div class="ui-form-field">按揭年数</div>
                        <div class="ui-form-controls ui-custom-select">
                            <input id="gjj-ns" type="text" class="ui-input-text js-year" data-type="*" data-null="请选择按揭年数" value="20年（240期）">
    <select class="ui-form-select" data-type="*" data-null="请选择按揭年数" name="">

    								<option {if="" $i="=20}selected{/if}" value="1">1年（12期）</option>


    								<option {if="" $i="=20}selected{/if}" value="2">2年（24期）</option>


    								<option {if="" $i="=20}selected{/if}" value="3">3年（36期）</option>


    								<option {if="" $i="=20}selected{/if}" value="4">4年（48期）</option>


    								<option {if="" $i="=20}selected{/if}" value="5">5年（60期）</option>


    								<option {if="" $i="=20}selected{/if}" value="6">6年（72期）</option>


    								<option {if="" $i="=20}selected{/if}" value="7">7年（84期）</option>


    								<option {if="" $i="=20}selected{/if}" value="8">8年（96期）</option>


    								<option {if="" $i="=20}selected{/if}" value="9">9年（108期）</option>


    								<option {if="" $i="=20}selected{/if}" value="10">10年（120期）</option>


    								<option {if="" $i="=20}selected{/if}" value="11">11年（132期）</option>


    								<option {if="" $i="=20}selected{/if}" value="12">12年（144期）</option>


    								<option {if="" $i="=20}selected{/if}" value="13">13年（156期）</option>


    								<option {if="" $i="=20}selected{/if}" value="14">14年（168期）</option>


    								<option {if="" $i="=20}selected{/if}" value="15">15年（180期）</option>


    								<option {if="" $i="=20}selected{/if}" value="16">16年（192期）</option>


    								<option {if="" $i="=20}selected{/if}" value="17">17年（204期）</option>


    								<option {if="" $i="=20}selected{/if}" value="18">18年（216期）</option>


    								<option {if="" $i="=20}selected{/if}" value="19">19年（228期）</option>


    								<option {if="" $i="=20}selected{/if}" value="20">20年（240期）</option>


    								<option {if="" $i="=20}selected{/if}" value="21">21年（252期）</option>


    								<option {if="" $i="=20}selected{/if}" value="22">22年（264期）</option>


    								<option {if="" $i="=20}selected{/if}" value="23">23年（276期）</option>


    								<option {if="" $i="=20}selected{/if}" value="24">24年（288期）</option>


    								<option {if="" $i="=20}selected{/if}" value="25">25年（300期）</option>


    								<option {if="" $i="=20}selected{/if}" value="26">26年（312期）</option>


    								<option {if="" $i="=20}selected{/if}" value="27">27年（324期）</option>


    								<option {if="" $i="=20}selected{/if}" value="28">28年（336期）</option>


    								<option {if="" $i="=20}selected{/if}" value="29">29年（348期）</option>


    								<option {if="" $i="=20}selected{/if}" value="30">30年（360期）</option>

    															</select>
                        </div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div class="ui-form-field">银行利率</div>
                        <div class="ui-form-controls ui-custom-select js-rate">
                            <input id="gjj-lv" type="text" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请设置银行利率" data-error="请填写正确的银行利率" value="3.25" rate1="3.25" rate2="3.25" rate3="3.25">
                                <select name="" class="">
    							<!-- rate值是由后台传过来的利率 -->
    							<!-- rat1:小于5年利率 rate2:五年以上利率 -->
                                    <option value="0" rate1="3.25" rate2="3.25" rate3="3.25" selected="selected">2015年5月11日 基准利率</option>
                                    <option value="1" rate1="3.58" rate2="3.58" rate3="4.13">2015年5月11日 上浮10%</option>
                                    <option value="2" rate1="3.5" rate2="3.5" rate3="4.0">2015年3月1日 基准利率</option>
                                    <option value="3" rate1="3.85" rate2="3.85" rate3="4.4">2015年3月1日 上浮10%</option>
                                    <option value="4" rate1="3.75" rate2="3.75" rate3="4.25">2014年11月22日 基准利率</option>
                                    <option value="5" rate1="4.125" rate2="4.125" rate3="4.675">2014年11月22日 上浮10%</option>
                                </select>
                        </div>
                        <div class="persent" >%<a href="javascript:;"><span>修改</span></a></div>
                    </li>
                </ul>
                <div class="js-return-way">
                    <ul class="ui-list mt20 bb0 way-tag">
                        <li class="ui-list-item">
                            <div class="ui-form-field">还款方式</div>
                            <div class="ui-form-controls">
                                <label class="ui-form-label bx"><input type="radio" name="return-way" class="ui-input-radio"  checked on=1>等额本息</label>
                                <label class="ui-form-label bj"><input type="radio" name="return-way" class="ui-input-radio" value="0" on=0>等额本金</label>
                            </div>
                        </li>
                    </ul>
                    <div class="way-tip bx-tip" style="display:block">每月还款额固定，所还总利息较多，适合收入稳定者。</div>
                    <div class="way-tip bj-tip" style="display:none">每月还款额递减，所还总利息较低，前期还款额较大。</div>
                </div>
            </div>

            <div class="ui-btn-wrap">
                <input id="gjj-calc-start" type="submit" class="ui-btn ui-btn-danger" value="开始计算">
            </div>
        </form>
    </div>
    <!-- 公积金贷款 end -->

    <!-- 组合贷款 start -->
    <div class="ui-tab-item">
        <form id="zhdk-form" class="ui-form" action="">
            <div class="bg-fff">
                <ul class="ui-list mt20 bb0">
                    <li class="ui-list-item no-arrows">
                        <div class="ui-form-field">商业贷款总额</div>
                        <div class="ui-form-controls"><input id="zh-sy-bj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写商业贷款总额" data-error="请填写正确的商业贷款总额"></div>
                        <div class="unit">万元</div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div class="ui-form-field" >公积金贷款总额</div>
                        <div class="ui-form-controls"><input id="zh-gjj-bj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写公积金贷款总额" data-error="请填写正确的公积金贷款总额" ></div>
                        <div class="unit">万元</div>
                    </li>
                </ul>
                <ul class="ui-list ui-list-arrows mt20 bb0">
                    <li class="ui-list-item">
                        <div class="ui-form-field">按揭年数</div>
                        <div class="ui-form-controls ui-custom-select">
                            <input id="zh-ns" type="text" class="ui-input-text js-year" data-type="*" data-null="请选择按揭年数" value="20年（240期）">
    <select class="ui-form-select" data-type="*" data-null="请选择按揭年数" name="">

    								<option {if="" $i="=20}selected{/if}" value="1" selected="selected">1年（12期）</option>


    								<option {if="" $i="=20}selected{/if}" value="2">2年（24期）</option>


    								<option {if="" $i="=20}selected{/if}" value="3">3年（36期）</option>


    								<option {if="" $i="=20}selected{/if}" value="4">4年（48期）</option>


    								<option {if="" $i="=20}selected{/if}" value="5">5年（60期）</option>


    								<option {if="" $i="=20}selected{/if}" value="6">6年（72期）</option>


    								<option {if="" $i="=20}selected{/if}" value="7">7年（84期）</option>


    								<option {if="" $i="=20}selected{/if}" value="8">8年（96期）</option>


    								<option {if="" $i="=20}selected{/if}" value="9">9年（108期）</option>


    								<option {if="" $i="=20}selected{/if}" value="10">10年（120期）</option>


    								<option {if="" $i="=20}selected{/if}" value="11">11年（132期）</option>


    								<option {if="" $i="=20}selected{/if}" value="12">12年（144期）</option>


    								<option {if="" $i="=20}selected{/if}" value="13">13年（156期）</option>


    								<option {if="" $i="=20}selected{/if}" value="14">14年（168期）</option>


    								<option {if="" $i="=20}selected{/if}" value="15">15年（180期）</option>


    								<option {if="" $i="=20}selected{/if}" value="16">16年（192期）</option>


    								<option {if="" $i="=20}selected{/if}" value="17">17年（204期）</option>


    								<option {if="" $i="=20}selected{/if}" value="18">18年（216期）</option>


    								<option {if="" $i="=20}selected{/if}" value="19">19年（228期）</option>


    								<option {if="" $i="=20}selected{/if}" value="20">20年（240期）</option>


    								<option {if="" $i="=20}selected{/if}" value="21">21年（252期）</option>


    								<option {if="" $i="=20}selected{/if}" value="22">22年（264期）</option>


    								<option {if="" $i="=20}selected{/if}" value="23">23年（276期）</option>


    								<option {if="" $i="=20}selected{/if}" value="24">24年（288期）</option>


    								<option {if="" $i="=20}selected{/if}" value="25">25年（300期）</option>


    								<option {if="" $i="=20}selected{/if}" value="26">26年（312期）</option>


    								<option {if="" $i="=20}selected{/if}" value="27">27年（324期）</option>


    								<option {if="" $i="=20}selected{/if}" value="28">28年（336期）</option>


    								<option {if="" $i="=20}selected{/if}" value="29">29年（348期）</option>


    								<option {if="" $i="=20}selected{/if}" value="30">30年（360期）</option>

    															</select>
                        </div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div class="ui-form-field">公积金利率</div>
                        <div class="ui-form-controls ui-custom-select js-rate">
                            <input id="zh-gjj-lv" type="text" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请设置银行利率" data-error="请填写正确的银行利率" value="3.25" rate1="3.25" rate2="3.25" rate3="3.25">
                                <select name="" class="">
    							<!-- rate值是由后台传过来的利率 -->
    							<!-- rat1:小于5年利率 rate2:五年以上利率 -->
                                    <option value="0" rate1="3.25" rate2="3.25" rate3="3.25">2015年5月11日 基准利率</option>
                                    <option value="1" rate1="3.58" rate2="3.58" rate3="4.13">2015年5月11日 上浮10%</option>
                                    <option value="2" rate1="3.5" rate2="3.5" rate3="4.0">2015年3月1日 基准利率</option>
                                    <option value="3" rate1="3.85" rate2="3.85" rate3="4.4">2015年3月1日 上浮10%</option>
                                    <option value="4" rate1="3.75" rate2="3.75" rate3="4.25">2014年11月22日 基准利率</option>
                                    <option value="5" rate1="4.125" rate2="4.125" rate3="4.675">2014年11月22日 上浮10%</option>
                                </select>

                        </div>
                        <div class="persent" >%<a href="javascript:;"><span>修改</span></a></div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div class="ui-form-field">商业利率</div>
                        <div class="ui-form-controls ui-custom-select js-rate">
                            <input id="zh-sy-lv" type="text" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请设置商业利率" data-error="请填写正确的商业利率" value="5.15" rate1="5.1" rate2="5.5" rate3="5.15">
                                <select name="" class="">
    							<!-- rate值是由后台传过来的利率 -->
    							<!-- rat1:小于5年利率 rate2:五年以上利率 -->
                                    <option value="0" rate1="5.1" rate2="5.5" rate3="5.15">2015年5月11日 基准利率</option>
                                    <option value="1" rate1="5.355" rate2="5.775" rate3="5.9325">2015年5月11日 上浮5%</option>
                                    <option value="2" rate1="5.61" rate2="6.05" rate3="6.215">2015年5月11日 上浮10%</option>
                                    <option value="3" rate1="5.35" rate2="5.75" rate3="5.9">2015年3月1日 基准利率</option>
                                    <option value="4" rate1="5.6175" rate2="6.0375" rate3="6.195">2015年3月1日 上浮5%</option>
                                    <option value="5" rate1="5.885" rate2="6.325" rate3="6.49">2015年3月1日 上浮10%</option>
                                    <option value="6" rate1="5.6" rate2="6" rate3="6.15">2014年11月22日 基准利率</option>
                                    <option value="7" rate1="5.88" rate2="6.3" rate3="6.4575">2014年11月22日 上浮5%</option>
                                    <option value="8" rate1="6.16" rate2="6.6" rate3="6.765">2014年11月22日 上浮10%</option>
                                </select>

                        </div>
                        <div class="persent" >%<a href="javascript:;"><span>修改</span></a></div>
                    </li>
                </ul>
                <div class="js-return-way">
                    <ul class="ui-list mt20 bb0 way-tag">
                        <li class="ui-list-item">
                            <div class="ui-form-field">还款方式</div>
                            <div class="ui-form-controls">
                                <label class="ui-form-label bx"><input type="radio" name="return-way" class="ui-input-radio"  checked on=1>等额本息</label>
                                <label class="ui-form-label bj"><input type="radio" name="return-way" class="ui-input-radio" value="0" on=0>等额本金</label>
                            </div>
                        </li>
                    </ul>
                    <div class="way-tip bx-tip" style="display:block">每月还款额固定，所还总利息较多，适合收入稳定者。</div>
                    <div class="way-tip bj-tip" style="display:none">每月还款额递减，所还总利息较低，前期还款额较大。</div>
                </div>
            </div>

            <div class="ui-btn-wrap">
                <input id="zh-calc-start" type="submit" class="ui-btn ui-btn-danger" value="开始计算">
            </div>
        </form>
    </div>
    <!-- 组合贷款 end -->
    <!-- 税费计算 start -->
    <div class="ui-tab-item">
        <form id="sfjs-form" class="ui-form form" action="" >
            <div class="bg-fff" >
                <ul class="ui-list ui-list-arrows mt20">
                    <li class="ui-list-item no-arrows">
                        <div  class="ui-form-field">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价</div>
                        <div class="ui-form-controls"><input id="sf-dj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请输入单价" data-error="请填写正确的单价"></div>
                        <div class="unit">元/㎡</div>
                    </li>
                    <li class="ui-list-item no-arrows">
                        <div  class="ui-form-field">面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;积</div>
                        <div class="ui-form-controls"><input id="sf-mj" type="number" name="" placeholder="" class="ui-input-text" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请输入面积" data-error="请填写正确的面积"></div>
                        <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;㎡</div>
                    </li>
                </ul>
            </div>


            <div class="ui-btn-wrap">
                <input id="sf-calc-start" type="submit" class="ui-btn ui-btn-danger" value="开始计算">
            </div>
        </form>
    </div>
    <!-- 税费计算 end -->

    </div>
    </div>
    </div>
    <div class="wrap calc-result" style="display:none;">
    <header class="title-bar title-bar-hasbg">
        <a href="javascript:void(0)" class="back iconfont" onclick="$('.calc-main').show();$('.calc-result').hide();$('body').removeClass('result-show')">&#x2568;</a>
         <h1>计算结果</h1>
        <div class="operate"></div>
    </header>
    <div class="ui-form bg-fff">
        <ul class="ui-list ui-list-arrows mt20 bb0">
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">贷款总额</div>
                <div class="ui-form-controls"><input id="result-dkze" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写贷款总额" data-error="请填写正确的贷款总额" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">还款总额</div>
                <div class="ui-form-controls"><input id="result-hkze" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写正确的还款总额" data-error="请填写正确的还款总额" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">支付利息</div>
                <div class="ui-form-controls"><input id="result-zflx" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写支付利息" data-error="请填写正确的支付利息" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
        </ul>
        <ul class="ui-list mt20 bb0">
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">按揭年数</div>
                <div class="ui-form-controls"><input id="result-ajns" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly value="20年（240期）"></div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">首月还款</div>
                <div class="ui-form-controls"><input id="result-syhk" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">末月还款</div>
                <div class="ui-form-controls"><input id="result-myhk" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field">月均还款</div>
                <div class="ui-form-controls"><input id="result-yjhk" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item check-detail bb0">
                <span>查看还款详情</span><i class="icon icon-bottom-arrow"></i>
            </li>
        </ul>
        <div class="detail-list" style="display:none">
            <div class="detail-list-tit content-wrap"><strong class="tal">月份</strong><strong class="tac">每月还款</strong><strong class="tar">剩余还款</strong></div>
            <div id="detail-list-content">
                <div class="per-year content-wrap">
                    <p>第1年</p>
                    <ul class="bb0">
                        <!-- <li><span class="tal">一月</span><span class="tac">￥2016</span><span class="tar">￥501600</span></li>
                        <li><span class="tal">一月</span><span class="tac">￥2016</span><span class="tar">￥501600</span></li>
                        <li><span class="tal">一月</span><span class="tac">￥2016</span><span class="tar">￥501600</span></li> -->
                    </ul>
                </div>
                <div class="per-year content-wrap">
                    <p>第15年</p>
                    <ul class="bb0">
                        <!-- <li><span class="tal">一月</span><span class="tac">￥2016</span><span class="tar">￥501600</span></li>
                        <li><span class="tal">一月</span><span class="tac">￥2016</span><span class="tar">￥501600</span></li>
                        <li><span class="tal">一月</span><span class="tac">￥2016</span><span class="tar">￥501600</span></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="result-tip content-wrap">结果超出预算啦？您可以尝试调整按揭年数，或者找航加房产抢优惠！</div>
        <div class="ui-btn-wrap">
            <a href="javascript:;" class="ui-btn ui-btn-danger"  onclick="$('.calc-main').show();$('.calc-result').hide();$('body').removeClass('result-show')" >重新计算</a>
        </div>
    </div>
    </div>
    <div class="wrap calc-result2" style="display:none;">
    <header class="title-bar title-bar-hasbg">
        <a href="javascript:void(0)" class="back iconfont" onclick="$('.calc-main').show();$('.calc-result2').hide();$('body').removeClass('result-show')">&#x2568;</a>
         <h1>税费计算结果</h1>
        <div class="operate"></div>
    </header>
    <div class="ui-form bg-fff">
        <ul class="ui-list ui-list-arrows mt20 bb0">
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field ">房款总价</div>
                <div class="ui-form-controls"><input id="result-zj" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写贷款总额" data-error="请填写正确的贷款总额" readonly></div>
                <div class="unit ">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field ">契税</div>
                <div class="ui-form-controls"><input id="result-qs" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写正确的还款总额" data-error="请填写正确的还款总额" readonly></div>
                <div class="unit ">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field ">印花税</div>
                <div class="ui-form-controls"><input id="result-yh" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="请填写支付利息" data-error="请填写正确的支付利息" readonly></div>
                <div class="unit ">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
        </ul>
        <ul class="ui-list mt20 bb0">
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field ">公证费</div>
                <div class="ui-form-controls"><input id="result-wt" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly></div>
                <div class="unit">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field ">公证费</div>
                <div class="ui-form-controls"><input id="result-gzh" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly></div>
                <div class="unit ">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
            <li class="ui-list-item no-arrows total-calc">
                <div class="ui-form-field ">房屋买卖手续费</div>
                <div class="ui-form-controls"><input id="result-fw" type="text" name="" placeholder="" class="ui-input-text c-red" data-type="/^[0-9]+(\.[0-9]+)?$/" data-null="" data-error="" readonly></div>
                <div class="unit ">&nbsp;&nbsp;&nbsp;&nbsp;元</div>
            </li>
        </ul>
        <div class="ui-btn-wrap">
            <a href="javascript:;" class="ui-btn ui-btn-danger"  onclick="$('.calc-main').show();$('.calc-result2').hide();$('body').removeClass('result-show')" >重新计算</a>
        </div>
    </div>
    </div>
    <script>
    //选择总价计算
    $('.total-btn').on('click',function(){
        $('.single-btn').removeClass('current').attr('on',0);
        $('.total-btn').addClass('current').attr('on',1);
        $('.single-calc').hide();
        $('.total-calc').show();
    });

    //选择单价计算
    $('.single-btn').on('click',function(){
        $('.total-btn').removeClass('current').attr('on',0);
        $('.single-btn').addClass('current').attr('on',1);
        $('.total-calc').hide();
        $('.single-calc').show();
    });

    //切换按揭年数时，切换利率高低
    $('.js-year').on('touchstart',function(){

        var val=$(this).val();
        var _this=this;
        clearInterval(this.timer);
        this.timer=setInterval(function(){
            if(val!=$(_this).val()){
                clearInterval(_this.timer);
                var oRateInp=$(_this).closest('ul').find('.js-rate input');
                var curVal=parseInt($(_this).val());
                if(curVal<2){
                    for(var i=0;i<oRateInp.length;i++){
                        $(oRateInp[i]).val($(oRateInp[i]).attr('rate1'));
                    }
                }else if(curVal<6){
                    for(var i=0;i<oRateInp.length;i++){
                        $(oRateInp[i]).val($(oRateInp[i]).attr('rate2'));
                    }
                }else{
                    for(var i=0;i<oRateInp.length;i++){
                        $(oRateInp[i]).val($(oRateInp[i]).attr('rate3'));
                    }
                }
            }
        },20);

    });

    //按照利率描述返回相应的利率数值到输入框
    $('.js-rate').on('touchstart',function(){
        var oInp=$(this).find('input');
        oInp[0].val=oInp.val();
        var aOption=$(this).find('option');
        _this=this;
        clearInterval(oInp.timer);
        oInp.timer=setInterval(function(){
            if(oInp[0].val!=oInp.val()){
                clearInterval(oInp.timer);
                for(var i=0;i<aOption.length;i++){
                    if(aOption[i].innerHTML==oInp.val()){
                        oInp.attr('rate1',$(aOption[i]).attr('rate1'));
                        oInp.attr('rate2',$(aOption[i]).attr('rate2'));
                        oInp.attr('rate3',$(aOption[i]).attr('rate3'));
                        var year=parseInt($(_this).closest('ul').find('.js-year').val());
                        if(year<2){
                            oInp.val(oInp.attr('rate1'));
                        }else if(year<6){
                            oInp.val(oInp.attr('rate2'));
                        }else{
                            oInp.val(oInp.attr('rate3'));
                        }
                    }
                }
            }
        },20);
    });

    //等额本息和等额本金提示
    $('.bx').on('click',function(){
        var oRoot=$(this).closest('.js-return-way');
        oRoot.find('.bx input').attr('on',1);
        oRoot.find('.bj input').attr('on',0);
        oRoot.find('.bj-tip').hide();
        oRoot.find('.bx-tip').show();
    });

    $('.bj').on('click',function(){
        var oRoot=$(this).closest('.js-return-way');
        oRoot.find('.bx input').attr('on',0);
        oRoot.find('.bj input').attr('on',1);
        oRoot.find('.bx-tip').hide();
        oRoot.find('.bj-tip').show();
    });

    //查看详情展开收起
    $(function(){
        $('.check-detail').on('click',function(){
            if(!this.on){
                $('.detail-list').show();
                $(this).find('i').removeClass('icon-arrows-down').addClass('icon-arrows-up');
                $(this).find('span').html('收起还款详情');
                this.on=1;
            }else{
                $('.detail-list').hide();
                $(this).find('i').removeClass('icon-arrows-up').addClass('icon-arrows-down');
                $(this).find('span').html('查看还款详情');
                this.on=0;
            }
        });
    });

    //手动设置利率
    $('.persent').on('click',function(){
        var $input=$(this).parent().find('input');
        $input.attr('type','number').get(0).select();
        $input.one('blur',function(){
            $(this).attr('type','text');
        });

        var top=$(this).offset().top;
        var sTop=0;
        var i=0;
        setTimeout(function(){
            var timer=setInterval(function(){
                i++;
                if(i==10){
                    clearInterval(timer);
                }
                sTop=top/10*i;
                $(window).scrollTop(sTop);
            },1);
        },1000);

        return false;
    });

    //----------------------------------计算----------------------------------


    //开始计算
    //$('#sy-calc-start').on('click',sydkStart);
    //$('#gjj-calc-start').on('click',gjjdkStart);
    //$('#zh-calc-start').on('click',zhdkStart);
    xzmui.validform("#sydk-form", {
        beforeSubmit: function(form, params){
            sydkStart();
            return false;
        }
    });

    xzmui.validform("#gjjdk-form", {
        beforeSubmit: function(form, params){
            gjjdkStart();
            return false;
        }
    });

    xzmui.validform("#zhdk-form", {
        beforeSubmit: function(form, params){
            zhdkStart();
            return false;
        }
    });
    xzmui.validform("#sfjs-form", {
        beforeSubmit: function(form, params){
            sfjsStart();
            return false;
        }
    });

    /*等额本息还款方式*/
    function debx(bj,lv,m){
        //月均还款=〔贷款本金×(银行利率÷12)×（1＋(银行利率÷12)）＾还款月数〕÷〔（1＋(银行利率÷12)）＾还款月数－1〕

        var averM=(bj*(lv/12)*Math.pow(1+lv/12,m))/(Math.pow(1+lv/12,m)-1);
        //还款总额=月均还款×按揭期数

        var hkze=averM*m;

        var result={
            dkze:bj,
            hkze:hkze,
            zflx:hkze-bj,
            ajns:m/12,
            averM:averM
        };

        return result;
    }

    /*等额本金还款方式*/
    function debj(bj,lv,m){
        //每月还款=（贷款总额÷还款月数）+（本金－已归还本金累计额）×(银行利率÷12)
        var perM=[];
        for(var i=0;i<m;i++){
            yhbj=(bj/m)*i;//已还本金
            perM[i]=bj/m+(bj-yhbj)*(lv/12);//每月还款额（包括利息）
        }

        var hkze=0;
        for(var i=0;i<perM.length;i++){
            //还款总额=每月还款总额
            hkze+=perM[i];
        }

        var result={
            dkze:bj,
            hkze:hkze,
            zflx:hkze-bj,
            ajns:m/12,
            perM:perM
        };
        return result;
    }

    //商业贷款计算
    function sydkStart(){
        $('.calc-main').hide();
        $('body').addClass('result-show');
        $('.calc-result').show();

        var oRoot=$('#sy-calc-start').closest('form');
        var bj;
        var lv=$('#sy-lv').val()/100;
        var m=parseInt($('#sy-ns').val())*12;

        if(oRoot.find('.total-btn').attr('on')==1){
            //总价计算
            bj=$('#sy-bj').val()*10000;
        }else if(oRoot.find('.single-btn').attr('on')==1){
            //单价计算
            bj=$('#sy-dj').val()*$('#sy-mj').val()*parseInt($('#sy-cs').val())/10;
        }

        if(oRoot.find('.bx input').attr('on')==1){
            //等额本息
            var result=debx(bj,lv,m);
            $('#result-dkze').val(fmoney(result.dkze,2));
            $('#result-hkze').val(fmoney(result.hkze,2));
            $('#result-zflx').val(fmoney(result.zflx,2));
            $('#result-ajns').val(result.ajns+'年（'+result.ajns*12+'期）');
            $('#result-yjhk').val(fmoney(result.averM,2));

            $('#result-yjhk').closest('li').show();
            $('#result-syhk').closest('li').hide();
            $('#result-myhk').closest('li').hide();
            $('.check-detail').hide();
        }else if(oRoot.find('.bj input').attr('on')==1){
            //等额本金
            var result=debj(bj,lv,m);
            $('#result-dkze').val(fmoney(result.dkze,2));
            $('#result-hkze').val(fmoney(result.hkze,2));
            $('#result-zflx').val(fmoney(result.zflx,2));
            $('#result-ajns').val(result.ajns+'年（'+result.ajns*12+'期）');
            $('#result-syhk').val(fmoney(result.perM[0],2));
            $('#result-myhk').val(fmoney(result.perM[result.perM.length-1],2));

            //详细列表
            var str='';
            var index=0;
            var yh=0;//已还
            for(var i=0;i<m/12;i++){
                str+='<div class="per-year content-wrap">\
    						<p>第'+(i+1)+'年</p><ul class="bb0">'+(function(){
                    var str='';
                    for(var j=0;j<12;j++){
                        yh+=result.perM[index];
                        str+='<li><span class="tal">'+(j+1)+'月</span><span class="tac">￥'+(fmoney(result.perM[index],2))+'</span><span class="tar">￥'+(fmoney(result.hkze-yh,2))+'</span></li>';
                        index++;
                    }

                    return str;
                })()+'</ul></div>';
            }
            $('#detail-list-content').html(str);


            $('#result-yjhk').closest('li').hide();
            $('#result-syhk').closest('li').show();
            $('#result-myhk').closest('li').show();
            $('body').addClass('show-detail');
            $('.check-detail').show();
        }
    }

    //公积金贷款计算
    function gjjdkStart(){

        $('.calc-main').hide();
        $('body').addClass('result-show');
        $('.calc-result').show();

        var oRoot=$('#gjj-calc-start').closest('form');
        var bj;
        var lv=$('#gjj-lv').val()/100;
        var m=parseInt($('#gjj-ns').val())*12;

        if(oRoot.find('.total-btn').attr('on')==1){
            //总价计算
            bj=$('#gjj-bj').val()*10000;
        }else if(oRoot.find('.single-btn').attr('on')==1){
            //单价计算
            bj=$('#gjj-dj').val()*$('#gjj-mj').val()*parseInt($('#sy-cs').val())/10;
        }

        $('.calc-result li').show();
        if(oRoot.find('.bx input').attr('on')==1){
            //等额本息
            var result=debx(bj,lv,m);
            $('#result-dkze').val(fmoney(result.dkze,2));
            $('#result-hkze').val(fmoney(result.hkze,2));
            $('#result-zflx').val(fmoney(result.zflx,2));
            $('#result-ajns').val(result.ajns+'年（'+result.ajns*12+'期）');
            $('#result-yjhk').val(fmoney(result.averM,2));

            $('#result-yjhk').closest('li').show();
            $('#result-syhk').closest('li').hide();
            $('#result-myhk').closest('li').hide();
            $('.check-detail').hide();
        }else if(oRoot.find('.bj input').attr('on')==1){
            //等额本金
            var result=debj(bj,lv,m);
            $('#result-dkze').val(fmoney(result.dkze,2));
            $('#result-hkze').val(fmoney(result.hkze,2));
            $('#result-zflx').val(fmoney(result.zflx,2));
            $('#result-ajns').val(result.ajns+'年（'+result.ajns*12+'期）');
            $('#result-syhk').val(fmoney(result.perM[0],2));
            $('#result-myhk').val(fmoney(result.perM[result.perM.length-1],2));

            //详细列表
            var str='';
            var index=0;
            var yh=0;//已还
            for(var i=0;i<m/12;i++){
                str+='<div class="per-year content-wrap">\
    						<p>第'+(i+1)+'年</p><ul class="bb0">'+(function(){
                    var str='';
                    for(var j=0;j<12;j++){
                        yh+=result.perM[index];
                        str+='<li><span class="tal">'+(j+1)+'月</span><span class="tac">￥'+(fmoney(result.perM[index],2))+'</span><span class="tar">￥'+(fmoney(result.hkze-yh,2))+'</span></li>';
                        index++;
                    }

                    return str;
                })()+'</ul></div>';
            }
            $('#detail-list-content').html(str);

            $('#result-yjhk').closest('li').hide();
            $('#result-syhk').closest('li').show();
            $('#result-myhk').closest('li').show();
            $('.check-detail').show();
            $('body').addClass('show-detail');
        }
    }

    //组合贷款
    function zhdkStart(){
        $('.calc-main').hide();
        $('body').addClass('result-show');
        $('.calc-result').show();

        var oRoot=$('#zh-calc-start').closest('form');
        var bj1=$('#zh-sy-bj').val()*10000;
        var lv1=$('#zh-sy-lv').val()/100;
        var m=parseInt($('#zh-ns').val())*12;

        var bj2=$('#zh-gjj-bj').val()*10000;
        var lv2=$('#zh-gjj-lv').val()/100;

        if(oRoot.find('.bx input').attr('on')==1){
            //等额本息
            var result1=debx(bj1,lv1,m);
            var result2=debx(bj2,lv2,m);

            $('#result-dkze').val(fmoney(result1.dkze+result2.dkze,2));
            $('#result-hkze').val(fmoney(result1.hkze+result2.hkze,2));
            $('#result-zflx').val(fmoney(result1.zflx+result2.zflx,2));
            $('#result-ajns').val(result1.ajns+'年（'+result1.ajns*12+'期）');
            $('#result-yjhk').val(fmoney((result1.averM+result2.averM),2));

            $('.calc-result li').show();
            $('#result-yjhk').closest('li').show();
            $('#result-syhk').closest('li').hide();
            $('#result-myhk').closest('li').hide();
            $('.check-detail').hide();
        }else if(oRoot.find('.bj input').attr('on')==1){
            //等额本金
            var result1=debj(bj1,lv1,m);
            var result2=debj(bj2,lv2,m);

            $('#result-dkze').val(fmoney(result1.dkze+result2.dkze,2));
            $('#result-hkze').val(fmoney(result1.hkze+result2.hkze,2));
            $('#result-zflx').val(fmoney(result1.zflx+result2.zflx,2));
            $('#result-ajns').val(result1.ajns+'年（'+result1.ajns*12+'期）');
            $('#result-syhk').val(fmoney(result1.perM[0]+result2.perM[0],2));
            $('#result-myhk').val(fmoney(result1.perM[result1.perM.length-1]+result2.perM[result2.perM.length-1],2));

            //详细列表
            var str='';
            var index=0;
            var yh=0;//已还
            for(var i=0;i<m/12;i++){
                str+='<div class="per-year content-wrap">\
    						<p>第'+(i+1)+'年</p><ul class="bb0">'+(function(){
                    var str='';
                    for(var j=0;j<12;j++){
                        yh+=(result1.perM[index]+result2.perM[index]);
                        str+='<li><span class="tal">'+(j+1)+'月</span><span class="tac">￥'+(fmoney(result1.perM[index]+result2.perM[index],2))+'</span><span class="tar">￥'+(fmoney(result1.hkze+result2.hkze-yh,2))+'</span></li>';
                        index++;
                    }

                    return str;
                })()+'</ul></div>';
            }
            $('#detail-list-content').html(str);

            $('#result-yjhk').closest('li').hide();
            $('#result-syhk').closest('li').show();
            $('#result-myhk').closest('li').show();
            $('.check-detail').show();
            $('body').addClass('show-detail');
        }
        return false;

    }

    //税费计算
    function sfjsStart(){
        $('.calc-main').hide();
        $('body').addClass('result-show');
        $('.calc-result2').show();

        var price = $('#sf-dj').val();
        var size= $('#sf-mj').val();
        var data = {
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

        $('#result-zj').val(data.zj);
        $('#result-qs').val(data.qs);
        $('#result-yh').val(data.yh);
        $('#result-wt').val(data.wt);
        $('#result-gzh').val(data.gzh);
        $('#result-fw').val(data.fw);
        return false;
    }


    /*金钱格式汉化*/
    // fn fmoney(s,n) 千分位逗号隔开
    //params s：钱数 n:小数点后面保存位数
    function fmoney(s, n){
        if(Math.abs(parseFloat(s))<100){
            return s.toFixed(2);
        }
        s+='';
        n = n > 0 && n <= 20 ? n : 2;
        s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
        var l = s.split(".")[0].split("").reverse(),
                r = s.split(".")[1];
        t = "";
        for(i = 0; i < l.length; i ++ ){
            t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
        }
        return t.split("").reverse().join("") + "." + r;
    }


    </script>

    <style type="text/css">
        .result-show .ui-wrapper .title-bar{
            display:none;
        }
    </style>
