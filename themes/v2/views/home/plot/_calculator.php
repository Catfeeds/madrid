<?php
$list = PlotHouseTypeExt::model()->enabled()->findAllByHid($this->plot->id,['index'=>'id']);
if(isset($id)&&isset($list[$id])){
    $pic = $list[$id];
} else {
    $pic = current($list);
}
?>
<div class="house-loan-cal-wrap">
    <div class="house-loan-cal">
        <div class="cal-block">
            <div class="title">房贷计算器</div>
            <dl>
              <dt>选择户型</dt>
              <dd>
                    <select name="" data-placeholder="<?=$pic['bedroom']?>室<?=$pic['livingroom']?>厅<?=$pic['cookroom']?>厨<?=$pic['bathroom']?>卫 <?=$pic['size']?>m²" class="huxing-select">
                    <?php foreach ($list as $key => $value) {?>
                        <option value="" data-junjia="均价<?php if($this->plot->price>0):?><?php echo $this->plot->price?><?php echo PlotPriceExt::$unit[$this->plot->unit];?><?php else:?>'暂无报价'<?php endif;?>" data-total="<?=$value['price']?>"><?=$value['bedroom']?>室<?=$value['livingroom']?>厅<?=$value['bathroom']?>厨<?=$value['cookroom']?>卫 <?=$value['size']?>m²</option>
                    <?php }?></select>
              </dd>
            </dl>
            <dl>
              <dt>参考总价</dt>
              <dd>
                <div class="total"><span><?=$pic['price']; ?></span>万</div>
                <div class="junjia"><?=PlotPriceExt::$mark[$this->plot->price_mark]; ?><span><?=$this->plot->price?></span><?=PlotPriceExt::$unit[$this->plot->unit]; ?></div>
              </dd>
            </dl>
            <dl>
              <dt>首期比例</dt>
              <dd>
              <select id="sf" data-placeholder="5成">
                    <option value="0.1">1成</option>
                    <option value="0.2">2成</option>
                    <option value="0.3">3成</option>
                    <option value="0.4">4成</option>
                    <option value="0.5" selected>5成</option>
                    <option value="0.6">6成</option>
              </select>
              </dd>
            </dl>
            <dl>
              <dt>贷款利率</dt>
              <dd>
                <select id="lv">
                    <option value="4.90" d="1" selected="selected">商业贷款基准利率（4.90%）</option>
                    <option value="4.90" d="1.1">商业贷款利率上限（1.1倍）</option>
                    <option value="4.90" d="0.7">商业贷款利率下限（7折）</option>
                    <option value="4.90" d="0.85">商业贷款利率下限（8.5折）</option>
                    <option value="3.25" d="1">公积金贷款基准利率（3.25%）</option>
                    <option value="3.25" d="1.1">公积金贷款利率上限（1.1倍）</option>
                    <option value="3.25" d="0.7">公积金贷款利率下限（7折）</option>
                    <option value="3.25" d="0.85">公积金贷款利率下限（8.5折）</option>
                </select>
              </dd>
            </dl>
            <dl>
              <dt>按揭年数</dt>
              <dd>
                <select id="year" data-placeholder="20年（240期）"><option value="1">1年&nbsp;(12期)</option><option value="2">2年&nbsp;(24期)</option><option value="3">3年&nbsp;(36期)</option><option value="4">4年&nbsp;(48期)</option><option value="5">5年&nbsp;(60期)</option><option value="6">6年&nbsp;(72期)</option><option value="7">7年&nbsp;(84期)</option><option value="8">8年&nbsp;(96期)</option><option value="9">9年&nbsp;(108期)</option><option value="10">10年&nbsp;(120期)</option><option value="11">11年&nbsp;(132期)</option><option value="12">12年&nbsp;(144期)</option><option value="13">13年&nbsp;(156期)</option><option value="14">14年&nbsp;(168期)</option><option value="15">15年&nbsp;(180期)</option><option value="16">16年&nbsp;(192期)</option><option value="17">17年&nbsp;(204期)</option><option value="18">18年&nbsp;(216期)</option><option value="19">19年&nbsp;(228期)</option><option selected="selected" value="20">20年&nbsp;(240期)</option><option value="25">25年&nbsp;(300期)</option><option value="30">30年&nbsp;(360期)</option></select>
              </dd>
            </dl>
            <input type="submit" value="开始计算" class="cal-btn"/>
        </div>
        <div class="cal-result">
            <div class="cal-result-map"></div>
            <div class="loan-month">月均还款：<span class="em">-</span></div>
            <ul class="cal-tips">
                <li><i class="i1"></i>首期付款：<span id="shoufu-text">-</span>万</li>
                <li><i class="i2"></i>贷款总额：<span id="totalBack-text">-</span>万</li>
                <li><i class="i3"></i>支付利息：<span id="totalInterest-text">-</span>万</li>
            </ul>
            <p class="tip">*根据等额本息计算，结果仅供参考</p>
        </div>
        <a href="" class="close"><i class="plot-ico plot-ico-close3"></i></a>
    </div>
</div>
