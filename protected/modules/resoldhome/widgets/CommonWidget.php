<?php
/**
 * 二手房通用挂件
 * @author steven allen <[<email address>]>
 * @date(2016.11.13)
 */
class CommonWidget extends CWidget
{
	public $type = 1;

	public function run()
	{
		switch ($this->type) {
			case '1':
				$tjs = ResoldRecomExt::model()->getRecom('pcss', 6)->findAll(['select'=>'url,created,title']);
				$html = '<p class="hot-word">热门：';
				if($tjs)
					foreach ($tjs as $key => $value) {
						$html .= '<a href="'.$value->url.'" class="'.((time()-$value->created<=7*86400)?'new':'').'">'.$value->title.'</a>';
					}
				$html .= '</p>';
				break;
			case '2':
				$item = $html = '';
				$siteQq = SM::resoldConfig()->resoldSiteQq();
				if(isset($siteQq) && $siteQq['number'][0])
				{
				    $item = '<dl class="item">
				        <dt>客服<br>QQ
				        <div class="online-box">
				            <span class="right-arrow"><span></span></span>
				            <ul>';
				    foreach ($siteQq['number'] as $k => $v) {

				    	$item .= '<li '.(count($siteQq)==$k+1?'class="last"':'').'><i class="iconfont">&#xe614;</i><a href="tencent://message/?uin='.$siteQq['url'][$k].'&Menu=yes" target="_blank">'.$siteQq['name'][$k].'<br>'.$siteQq['number'][$k].'</a></li>';
				    }
				    $item .= '</ul></div>

						        </dt>
						        <dd><i class="iconfont"></i></dd>
						    </dl>';
			    }
				$html .= '<div class="float-menu">'.$item.'
						    <dl class="item tuangou">
						        <dt>客服<br>热线<div class="online-box tel-box">
						            <span class="right-arrow"><span></span></span>
						            <ul>
						                <li><i class="iconfont"></i>客服热线<br>'.SM::resoldConfig()->resoldPhone().' </li>
						            </ul>
						        </div></dt>
						        <dd><i class="iconfont"></i></dd>
						    </dl>
						    <dl class="item">
						        <dt>关注<br>微信
						            <div class="weixin-box">
						                <span class="right-arrow"><span></span></span>
						                <div class="weixin-img">
						                    <img src="'.ImageTools::fixImage(SM::resoldImageConfig()->resoldWeixinQrCode()).'">
						                    <p class="c-g6">关注房产微信</p>
						                    <p class="c-e">获取更多优惠</p>
						                </div>
						            </div>

						        </dt>
						        <dd><i class="iconfont"></i></dd>
						    </dl>
						    <dl class="gotoTop">
						        <dd><i class="iconfont"></i></dd>
						    </dl>
						</div>';
				break;
			case '3':
				$rmjq = $rmxq = $yqlj = '';
				$arr = ['rmjq','rmxq','yqlj'];
				foreach ($arr as $key => $value) {
					$$value = '';
				}
				foreach ($arr as $key => $v) {
					if($infos = ResoldRecomExt::model()->getRecom('pcdb'.$v, 40)->findAll(['select'=>'url,title']))
						foreach ($infos as $key => $value) {
							$$v .= '<a href="'.$value->url.'">'.$value->title.'</a>';
						}
				}

				$html = '
					<div class="wapper">';
					if($rmjq || $rmxq) {
						$html .= 
						'<div class="frame">
					        <div class="s-title"><span>'.SM::urmConfig()->cityName().'二手房源</span></div>
					        <div class="h-list">';
					        if($rmjq)
					        	$html .= '<div class="box">
					                <span>'.SM::urmConfig()->cityName().'二手房热门街区：</span>'.$rmjq.'
					            </div>';
					        if($rmxq)
					        	$html .= '<div class="box">
					                <span>'.SM::urmConfig()->cityName().'二手房热门小区：</span>'.$rmxq.'
					            </div>';

					        $html .= '</div>
					    </div>';
					}

				    $html .= '<div class="blank20"></div>';
				    if($yqlj)
				    $html .=
					'<div class="frame">
				        <div class="s-title"><span>友情链接</span></div>
				        <div class="h-list">
				            <div class="box">
				                '.$yqlj.'
				            </div>
				        </div>
				    </div>
				    <div class="blank20"></div>';
				    $html .= 
				    '<div class="frame">
				        <div class="h-list">
				            <p>'.(SM::resoldConfig()->resoldPCBottomAd()?SM::resoldConfig()->resoldPCBottomAd():(''.SM::globalConfig()->siteName().' '.SM::urmConfig()->cityName().'二手房为您提供更新更全的'.SM::urmConfig()->cityName().'二手房价格信息，每天更新海量'.SM::urmConfig()->cityName().'个人二手房、经纪人二手房信息，让您更快找到满意的'.SM::urmConfig()->cityName().'二手房。欢迎使用'.SM::globalConfig()->siteName().'找'.SM::urmConfig()->cityName().'二手房，'.SM::urmConfig()->cityName().'二手房移动端更精彩！')).'</p>
				        </div>
				    </div>

				</div>
				';
				break;
			default:
				# code...
				break;

		}
		echo $html ;
	}
}
