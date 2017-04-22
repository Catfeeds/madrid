<?php
/**
 * 楼盘控制器
 * @author tivon <[<email address>]>
 * @date(2017.03.17)
 */
class HouseController extends AdminController{
	/**
	 * [actionImport 抓取页面]
	 * @return [type] [description]
	 */
	public function actionImport()
	{
		$urls = Yii::app()->request->getQuery('urls','');
		if(trim($urls)) {
			$urlArr = explode(' ', $urls);
			$urlArr = array_filter($urlArr);
			if($urlArr)
				foreach ($urlArr as $key => $value) {
					$this->fetchHouse($value);
				}
		}
		$this->render('import');
	}

	/**
	 * [fetchHouse 抓取流程]
	 * @param  string $url [description]
	 * @return [type]      [description]
	 */
	public function fetchHouse($url='')
	{
		// 地图数据
		// ditu.fang.com/?c=channel&a=xiaoquNew&newcode=1821031186&city=cz
		$plot = New PlotExt;
		$urlarr = explode('.', $url);
		// preg_match_all('', $urlarr[0], matches)
		$plot->pinyin = str_replace('http://', '', $urlarr[0]);
		// var_dump($plot->pinyin);exit;
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		// 截取body
		preg_match_all('/<body>[.|\s|\S]+body>/', $totalHtml, $results);
		// 去除script标签
		$result = str_replace('script', '', $results[0][0]);
		$result = $this->characet($result);
		// 标题
		preg_match_all('/<h1>[.|\s|\S]+h1>/', $result, $titleTag);
		// preg_match_all('/">.+<\/a>/', $titleTag[0][0], $titleTag2);
		if(isset($titleTag[0][0])) {
			preg_match_all('/title=.+target/', $titleTag[0][0], $tt);
			if(isset($tt[0][0])) {
				// var_dump(1);exit;
				$title = str_replace('title="', '', $tt[0][0]);
				$title = str_replace('" target', '', $title);
				$title = $this->characet($title);
				$plot->title = $title;
			}
		}
		// var_dump($title);exit;
		// $title = str_replace('">', '', $titleTag2[0][0]);
		// $title = str_replace('</a>', '', $title);
		// // 编码装换
		// $title = $this->characet($title);
		// $plot->title = $title;//var_dump($plot->title);exit;
		// 拼音
		// $plot->pinyin = $this->Pinyin($title,1);
		// var_dump(strpos($result, '常州'),$result);exit;
		// str_replace('销售信息', 'xsxx', $result);
		// var_dump($result);exit;
		// 基本信息+销售信息
		preg_match_all('/基本信息<\/h3>[.|\s|\S]+销售信息结束/', $result, $xsTags);
		$xxs = $xsTags[0][0];
		$xxs = $this->characet($xxs);
		// var_dump($xxs);exit;
		// 价格
		preg_match_all('/em>[.|\s|\S]+<\/em/', $xxs,$pricetag);
		$pricetag && $pricetag = $pricetag[0][0];
		$pricetag = str_replace('em>', '', $pricetag);
		$pricetag = str_replace('</em', '', $pricetag);
		$plot->price = trim($pricetag);
		// 物业类型和售楼地址
		preg_match_all('/<div class="list-right" title="[^>]+>/', $xxs, $wylxsldz);
		$wylxsldz && $wylxsldz = $wylxsldz[0];
		isset($wylxsldz[0][0]) && $wylx = $wylxsldz[0];
		isset($wylxsldz[0][1]) && $sldz = $wylxsldz[1];
		$wylx = str_replace('<div class="list-right" title="', '', $wylx);
		$wylx = str_replace('">', '', $wylx);

		$sldz = str_replace('<div class="list-right" title="', '', $sldz);
		$sldz = str_replace('">', '', $sldz);
		$plot->wylx = $wylx;
		$plot->sale_addr = $sldz;

		// 项目特色
		preg_match_all('/tag.+/', $xxs, $xstss);

		$xmts = '';
		if($xstss) {
			foreach ($xstss[0] as $key => $value) {
				$tmp = str_replace('tag">', '', $value);
				$tmp = str_replace('</span>', '', $tmp);
				$xmts .= $tmp.' ';
			}
			$xmts = trim($xmts);
		}
		$plot->xmts = $xmts;
		// 建筑类别
		// $xxs = str_replace(' ','',$xxs);
		$jzlb = $jzlbs = '';
		// [];
		preg_match('/bulid\-type[.|\s|\S]+<\/s/', $xxs, $jzlbTags);
		if($jzlbTags = $jzlbTags[0]) {
			$jzlb = str_replace('bulid-type">', '', $jzlbTags);
			$jzlb = str_replace('</s', '', $jzlb);
		}
		if($jzlb) {
			$jzlb = explode(' ', $jzlb);
			foreach ($jzlb as $key => $value) {
				if(trim($value)) {
					$jzlbs .= trim($value) . ' ';
				}
			}
			$jzlbs = trim($jzlbs);
		}
		$plot->jzlb = $jzlbs;
		// 开发商
		$kfs = '';
		preg_match_all('/_blank">.+<\/a/', $xxs, $kfss);
		if(isset($kfss[0][0]) && $kfss = $kfss[0][0]) {
			preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $kfss, $xsztarr);
			if(isset($xsztarr[0][0])) {
				foreach ($xsztarr[0] as $key => $value) {
					$kfs .= $value.' ';
				}
			}
		}
		$plot->developer = trim($kfs);
		// 楼盘地址
		$addr = '';
		preg_match_all('/楼盘地址[.|\s|\S]+基本信息结束/', $xxs, $adds);
			// var_dump($adds);exit;
		if(isset($adds[0][0]) && $adds = $adds[0][0]) {
			preg_match_all('/[\x{4e00}-\x{9fa5}|0-9|#]+/u', $adds, $dzs);
			if(isset($dzs[0]) && isset($dzs[0][1])) {
				$plot->address = $dzs[0][1];
			}
		}
		// $plot->address = $addr;
		// 销售状态
		$xszt = '';
		preg_match_all('/销售状态[.|\s|\S]+在售<\/div>/', $xxs, $xszts);
		if(isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
			$plot->sale_status = '在售';
		}else{
			preg_match_all('/销售状态[.|\s|\S]+待售<\/div>/', $xxs, $xszts);
			if(isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
				$plot->sale_status = '待售';
			} else {
				preg_match_all('/销售状态[.|\s|\S]+售完<\/div>/', $xxs, $xszts);
				if(isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
					$plot->sale_status = '售完';
				}
			}
		}
		// 开盘时间
		// 销售状态
		$kpsj = '';
		preg_match_all('/开盘时间：<\/div>[\s]+<div class="list-right">.+<a/', $xxs, $kpsjs);
		if(isset($kpsjs[0][0]) && $kpsjs = $kpsjs[0][0]) {
			// var_dump($kpsjs);exit;
			preg_match_all('/[\x{4e00}-\x{9fa5}|0-9|#]+/u', $kpsjs, $xsztarr);
			// var_dump($xsztarr);exit;
			$xszt = $xsztarr[0][1];
			// 格式处理
			preg_match_all('/[0-9]+年[0-9]+月[0-9]+日/', $xszt, $xszts);
			if($xszts[0] && isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
				$xszts = str_replace('年', '-', $xszts);
				$xszts = str_replace('月', '-', $xszts);
				$xszts = str_replace('日', '', $xszts);
				// var_dump($xszts);exit;
				$kpsj = strtotime($xszts);
			} else {
				preg_match_all('/[0-9]+年[0-9]+月/', $xszt, $xszts);
				if($xszts[0] && isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
					$xszts = str_replace('年', '-', $xszts);
					$xszts = str_replace('月', '', $xszts);
					// var_dump($xszts);exit;
					$kpsj = strtotime($xszts);
				}
			}

		}
		$plot->open_time = $kpsj;
		// 交房时间
		$jfsj = '';
		preg_match_all('/交房时间：<\/div>[\s]+<div class="list-right">.+<\//', $xxs, $jfsjs);
		if(isset($jfsjs[0][0]) && $kpsjs = $jfsjs[0][0]) {
			// var_dump($kpsjs);exit;
			preg_match_all('/[\x{4e00}-\x{9fa5}|0-9|#]+/u', $kpsjs, $xsztarr);
			// var_dump($xsztarr);exit;
			$xszt = $xsztarr[0][1];
			// 格式处理
			preg_match_all('/[0-9]+年[0-9]+月[0-9]+日/', $xszt, $xszts);
			if($xszts[0] && isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
				$xszts = str_replace('年', '-', $xszts);
				$xszts = str_replace('月', '-', $xszts);
				$xszts = str_replace('日', '', $xszts);
				// var_dump($xszts);exit;
				$kpsj = strtotime($xszts);
			} else {
				preg_match_all('/[0-9]+年[0-9]+月/', $xszt, $xszts);
				if($xszts[0] && isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
					$xszts = str_replace('年', '-', $xszts);
					$xszts = str_replace('月', '', $xszts);
					// var_dump($xszts);exit;
					$kpsj = strtotime($xszts);
				}
			}
		}
		$plot->delivery_time = $kpsj;
		// 装修情况
		$zxqk = '';
		preg_match_all('/装修状况：<\/div>[\s]+<div class="list-right">.+</', $xxs, $jfsjs);
		if(isset($jfsjs[0][0]) && $kpsjs = $jfsjs[0][0]) { 
			preg_match_all('/[\x{4e00}-\x{9fa5}|0-9|#]+/u', $kpsjs, $xsztarr);
			// var_dump($xsztarr);exit;
			$xszt = $xsztarr[0][1];
		}
		$plot->zxzt = $xszt;
		// 售楼电话
		preg_match_all('/">400.+/', $xxs, $jfsjs);
		if(isset($jfsjs[0][0]) && $kpsjs = $jfsjs[0][0]) { 
			$phone = str_replace('</div>', '', $kpsjs);
			// var_dump($phone);
			$phone = trim($phone,'">');
		}
		$plot->sale_tel = $phone;
		// 小区规划部分
		preg_match_all('/小区规划开始[.|\s|\S]+小区规划结束/', $result, $xqghs);
		if(isset($xqghs[0][0]) && $xqghs = $xqghs[0][0]) {
			preg_match_all('/占地面积：[.|\s|\S|0-9]+平方米<\/div>/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9]+/',$areas,$ars);
				if(isset($ars[0][0]))
					$plot->size = $ars[0][0];
				if(isset($ars[0][1]))
					$plot->buildsize = $ars[0][1];
			}
			// 容积率绿化率
			preg_match_all('/率：[.|\s|\S]+%/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9|.]+&nbsp;/',$areas,$ars);
				if(isset($ars[0][0])){
					$plot->capacity = trim($ars[0][0],'&nbsp;');
				}
				preg_match_all('/[0-9|.]+%/',$areas,$ars);
				if(isset($ars[0][0])){
					// var_dump(expression)
					$plot->green = trim($ars[0][0],'%');
				}
			}
			// 物业费
			preg_match_all('/[0-9|.]+元\//', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				// var_dump($areas);exit;
					$plot->manage_fee = trim($areas,'元\/');
			}
			// 物业公司
			preg_match_all('/物业公司：[.|\s|\S]+<\/a/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $areas, $arss);
				// var_dump($areas);exit;
				if(isset($arss[0][1])) {
					// var_dump($arss[0][1]);exit;
					$plot->manage_company = $arss[0][1];
				}
			}
			// 楼栋总数
			preg_match_all('/楼栋总数[.|\s|\S]+栋/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9]+/', $areas, $arss);
				// var_dump($areas);exit;
				if(isset($arss[0][0])) {
					// var_dump($arss[0][1]);exit;
					$plot->building_num = $arss[0][0];
				}
			}
			// 总户数
			preg_match_all('/list-right">[0-9]+户/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9]+/', $areas, $arss);
				// var_dump($areas);exit;
				if(isset($arss[0][0])) {
					// var_dump($arss[0][1]);exit;
					$plot->household_num = $arss[0][0];
				}
			}
			// 楼层状况
			preg_match_all('/list-right-floor.+</', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				$zk = str_replace('list-right-floor">', '', $areas);
				$zk = str_replace('<', '', $zk);
				$plot->floor_desc = $zk;
			}

		}else {
			preg_match_all('/楼盘情况开始[.|\s|\S]+楼盘情况结束/', $result, $xqghs);
			if(isset($xqghs[0][0]) && $xqghs = $xqghs[0][0]) {
			preg_match_all('/占地面积：[.|\s|\S|0-9]+平方米<\/div>/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9]+/',$areas,$ars);
				if(isset($ars[0][0]))
					$plot->size = $ars[0][0];
				if(isset($ars[0][1]))
					$plot->buildsize = $ars[0][1];
			}
			// 容积率绿化率
			preg_match_all('/率：[.|\s|\S]+="list-right">[0-9|.]+[.|\s|\S]+容积率详情/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9|.]+<a/',$areas,$ars);
				if(isset($ars[0][0])){
					$plot->capacity = trim($ars[0][0],'<a');
				}
				preg_match_all('/[0-9|.]+%/',$areas,$ars);
				if(isset($ars[0][0])){
					// var_dump(expression)
					$plot->green = trim($ars[0][0],'%');
				}
			}
			// 物业费
			preg_match_all('/[0-9|.]+元\//', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				// var_dump($areas);exit;
					$plot->manage_fee = trim($areas,'元\/');
			}
			// 物业公司
			preg_match_all('/物业公司：[.|\s|\S]+<\/a/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $areas, $arss);
				// var_dump($areas);exit;
				if(isset($arss[0][1])) {
					// var_dump($arss[0][1]);exit;
					$plot->manage_company = $arss[0][1];
				}
			}
			// 楼栋总数
			preg_match_all('/楼栋总数[.|\s|\S]+栋/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9]+/', $areas, $arss);
				// var_dump($areas);exit;
				if(isset($arss[0][0])) {
					// var_dump($arss[0][1]);exit;
					$plot->building_num = $arss[0][0];
				}
			}
			// 总户数
			preg_match_all('/list-right">[0-9]+户/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/[0-9]+/', $areas, $arss);
				// var_dump($areas);exit;
				if(isset($arss[0][0])) {
					// var_dump($arss[0][1]);exit;
					$plot->household_num = $arss[0][0];
				}
			}
			// 楼层状况
			preg_match_all('/list-right-floor.+</', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				$zk = str_replace('list-right-floor">', '', $areas);
				$zk = str_replace('<', '', $zk);
				$plot->floor_desc = $zk;
			}

		}
		}
		// 交通、配套部分
		preg_match_all('/交通配套开始[.|\s|\S]+交通配套结束/', $result, $xqghs);
		if(isset($xqghs[0][0]) && $xqghs = $xqghs[0][0]) {
			// var_dump($xqghs);exit;
			preg_match_all('/<p>[.|\s|\S]+class="set"/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/<p>[.|\s|\S]+<\/p>/',$areas,$ars);
				if(isset($ars[0][0])) {
					$ars = trim($ars[0][0],'<p>');
					$ars = trim($ars,'</p>');
					$ars = str_replace('\n', '', $ars);
					$ars = str_replace('\r', '', $ars);
					$ars = str_replace('\t', '', $ars);
					$ars = strip_tags($ars);
					// var_dump($ars);exit;
					$plot->transit = trim($ars);
				}
			}
			preg_match_all('/项目配套<\/h3>[.|\s|\S]+<\/p>/', $xqghs, $areas);
			if(isset($areas[0][0]) && $areas = $areas[0][0]) {
				preg_match_all('/<p>[.|\s|\S]+<\/p>/',$areas,$ars);
				if(isset($ars[0][0])) {
					$ars = trim($ars[0][0],'<p>');
					$ars = trim($ars,'</p>');
					// var_dump($ars);exit;
					$plot->peripheral = trim($ars);
				}
			}
		} else {
			preg_match_all('/配套信息开始[.|\s|\S]+配套信息结束/', $result, $pts);
			if(isset($pts[0][0]) && $pts = $pts[0][0]) {
				preg_match_all('/交通状况[.|\s|\S]+项目简介开始/', $pts, $areas);
				if(isset($areas[0][0]) && $areas = $areas[0][0]) {
					preg_match_all('/交通状况[.|\s|\S]+<\/div>/',$areas,$ars);
					if(isset($ars[0][0])) {
						$ss = str_replace('</div>', '', $ars[0][0]);
						$ss = str_replace('交通状况</h3>', '', $ss);
						$plot->transit = trim($ss);
					}
				}
				preg_match_all('/物业公司[.|\s|\S]+padd/', $pts, $areas);
				if(isset($areas[0][0]) && $areas = $areas[0][0]) {
					preg_match_all('/[\x{4e00}-\x{9fa5}]+/u',$areas,$ars);
					if(isset($ars[0][0])) {
						$plot->manage_company = $ars[0][1];
					}
				}
				preg_match_all('/<h3>周边配套<\/h3>[.|\s|\S]+class="set/', $pts, $areas);
				if(isset($areas[0][0]) && $areas = $areas[0][0]) {
					$pt = str_replace('<h3>周边配套</h3>', '', $areas);
					$pt = str_replace('<p>', '', $pt);
					$pt = str_replace('</p>', '', $pt);
					$pt = str_replace('<div class="set', '', $pt);
					$plot->peripheral = trim($pt);
				}
				// 物业费
				preg_match_all('/[0-9|.]+元\//', $pts, $areas);
				if(isset($areas[0][0]) && $areas = $areas[0][0]) {
					// var_dump($areas);exit;
						$plot->manage_fee = trim($areas,'元\/');
				}
			}

		}
		// 项目简介
		// intro">[.|\s|\S]+项目
		preg_match_all('/intro">[.|\s|\S]+项目/', $result, $xqghs);
		if(isset($xqghs[0][0]) && $xqghs = $xqghs[0][0]) {
			preg_match_all('/>[.|\s|\S]+<\/p>/',$xqghs,$ars);
			if(isset($ars[0][0])) {
				$ars = trim($ars[0][0],'>');
				$ars = trim($ars,'</p>');
				// var_dump(trim($ars));exit;
				$plot->content = trim($ars);
			}
		}
		
		// 区域
		preg_match_all('/header_mnav[.|\s|\S]+面包屑/', $result, $xqghs);
		if(isset($xqghs[0][0]) && $xqghs = $xqghs[0][0]) {
			// var_dump($xqghs);exit;
			preg_match_all('/<\/a>[\s]>[.|\s|\S]+<\/a>/',$xqghs,$ars);
			if(isset($ars[0][0])) {
				preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $ars[0][0], $arss);
				// var_dump($arss);exit;
				if(isset($arss[0][0])) {
					// var_dump();exit;
					$plot->street = str_replace('新楼盘', '', $arss[0][0]);
				}
			}
		}else{

		}
		// 产权年限
		preg_match_all('/产权年限[\s|\S|.]+[0-9]0年/', $result, $xqghs);
		if(isset($xqghs[0][0]) && $xqghs = $xqghs[0][0]) {
			// var_dump($xqghs);exit;
			preg_match_all('/[0-9]+/',$xqghs,$ars);
			if(isset($ars[0][0])) {
				$plot->property_years = $ars[0][0].'年';
			}
		}
		// 封面
		preg_match_all('/face.+.jpg\'/', $result, $jps);
		if(isset($jps[0][0]) && $jps = $jps[0][0]) {
			$jps = str_replace('face = ', '', $jps);
			$jps = trim($jps,"'");
			$jps = $this->sfImage($jps,$url);
			$jps && $plot->image = $jps;
		}
		// 城市
		preg_match_all('/vcity.+/', $result, $jps);
		if(isset($jps[0][0]) && $jps = $jps[0][0]) {
			$jps = str_replace("vcity= '", '', $jps);
			$jps = str_replace("';", '', $jps);
			$jps = trim($jps,"'");
			$plot->area = $jps;
			// $jps = Yii::app()->file->fetch($jps);
		} else {
			preg_match_all('/SouFunSearch.city.+/', $result, $jps);
			if(isset($jps[0][0]) && $jps = $jps[0][0]) {
				$jps = str_replace('SouFunSearch.city = "', '', $jps);
				$jps = str_replace('";', '', $jps);
				// $jps = trim($jps,"'");
				$plot->area = $jps;
			}
		}
		// 楼盘id
			preg_match_all('/newcode=.+/', $result, $jxs);
			if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) { 
				$code = str_replace("newcode='", '', $jxs);
				$code = str_replace("';", '', $code);
				$code = trim($code);
			} else {
				preg_match_all('/currNewcode.+/', $result, $jxs);
			if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) { 
				$code = str_replace("currNewcode = '", '', $jxs);
				$code = str_replace("';", '', $code);
				$code = trim($code);
			} 
			}
		// 地图数据
		preg_match_all('/SouFunSearch\.newhouseDomain.+/', $result, $jps);
		if(isset($jps[0][0]) && $jps = $jps[0][0]) {
			// 城市简写
			preg_match_all('/newhouse\..+fang/', $jps, $jxs);
			if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) { 
				$jx = str_replace("newhouse.", '', $jxs);
				$jx = str_replace(".fang", '', $jx);
			}
			

			if($jx && $code) {
				// 路由拼凑
				$mapurl = "http://ditu.fang.com/?c=channel&a=xiaoquNew&newcode=$code&city=$jx";
				$res1 = HttpHelper::get($mapurl);
				$totalHtml1 = $res1['content'];
				if($totalHtml1) {
					preg_match_all('/_vars.cityx.+newhouse_style/', $totalHtml1, $jxs);
					if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) { 
						$ds = explode(';', $jxs);
						if($ds) {
							foreach ($ds as $key => $value) {
								if(strrpos($value, '=')) {
									list($a,$b) = explode('=', $value);
									$a = trim($a,'_vars.');
									$a = trim($a);
									$b = trim($b);
									$b = trim($b,'"');
									$$a = $b;
								}
							}
							if(isset($cityx))
								$plot->map_lng = $cityx;
							if(isset($cityy))
								$plot->map_lat= $cityy;
							if(isset($zoom))
								$plot->map_zoom = $zoom;
						}
					}
				}
			}
		}
		// var_dump($code);exit();
		// 抓取户型图
		preg_match_all('/<a.+padding:0 11px;">户型/', $result, $jxs);
		if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) {
			
			preg_match_all('/photo\/list.+htm/', $jxs, $urls);
			if(isset($urls[0][0]) && $urls = $urls[0][0]) {
				$urlar = explode('com', $url);
				$hxurl = $urlar[0] . 'com/' . $urls;
			}
		}
		$urlarrr = explode('/', trim($url,'http://'));
		$hxurl = 'http://'.$urlarrr[0].'/photo/list_900_'.$code.'.htm';
		// var_dump($plot->attributes);exit;
		// 抓取资讯
		$newsurl = 'http://'.$urlarrr[0].'//house/'.$code.'/dongtai.htm';
		// 抓取房价走势
		$pricesurl = 'http://'.$urlarrr[0].'//house/'.$code.'/fangjia.htm';
		// 抓取问答
		$wdsurl = 'http://'.$urlarrr[0].'	/dianping.htm';
		
		// var_dump($hxurl);exit;
		$plot->code = $code;
		$plot->url = 'http://'.$urlarrr[0];
		if($plot->save()) {
			if(isset($hxurl) && $hxurl)
				$this->fetchHx($hxurl,$plot->id);
			// 抓取相册
			$imageurl = 'http://'.$urlarrr[0] . '/house/ajaxrequest/photolist_get.php';
			if($imageurl) {
				$this->fetchImage($imageurl,$code,$plot->id);
			}
			$this->fetchNews($newsurl,$plot->id);
			$this->fetchPrices($pricesurl,$plot->id);
			$this->fetchWds($wdsurl,$plot->id);
			$this->setMessage('保存成功','success');
		} else{
			$this->setMessage(current(current($plot->getErrors())),'success');
		}
		
	}

	public function actionMoreNews($id)
	{
		$plot = PlotExt::model()->findByPk($id);
		if($plot->news) {
			$this->setMessage('已抓取过','error');
			return;
		}
		$url = $plot->url;
		$code = $plot->code;
		$newsurl = "$url/house/$code/dongtai.htm";
		$this->fetchNews($newsurl,$id);
		// $this->setMessage('抓取成功');

	}

	public function actionMorePrices($id)
	{
		$plot = PlotExt::model()->findByPk($id);
		if($plot->prices) {
			$this->setMessage('已抓取过','error');
			return;
		}
		$url = $plot->url;
		$code = $plot->code;
		$newsurl = "$url/house/$code/fangjia.htm";
		$this->fetchPrices($newsurl,$id);
		// $this->setMessage('抓取成功');

	}

	public function actionMoreWds($id)
	{
		$plot = PlotExt::model()->findByPk($id);
		if($plot->wds) {
			$this->setMessage('已抓取过','error');
			return;
		}
		$url = $plot->url;
		$code = $plot->code;
		$newsurl = "$url/dianping";
		$this->fetchWds($newsurl,$id);
		// $this->setMessage('抓取成功');

	}

	public function fetchPrices($url='',$hid='')
	{
		if(!$url)
			return true;
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		preg_match_all('/<body[.|\s|\S]+body>/', $totalHtml, $results);
		// 去除script标签
		$result = str_replace('script', '', $results[0][0]);

		$result = $this->characet($result);
		preg_match_all('/价格表格[.|\s|\S]+价格表格/', $result, $tables);
		if(isset($tables[0][0]) && $tables = $tables[0][0]) {
			preg_match_all('/<td.+/', $tables, $tds);
			if(isset($tds[0][0])) {
				$arrr = implode('<br>', $tds[0]);
				$ars = explode('class', $arrr);
				if($ars) {
					// var_dump($ars); exit;
					foreach ($ars as $key => $value) {
						if(strstr($value,'元')) {
							preg_match_all('/td>[0-9|.]+元\/[\x{4e00}-\x{9fa5}]+<\/td>/u', $value, $prs);
							if(isset($prs[0][0]) && $prs = $prs[0][0]) {
								$plotprice = new PlotPriceExt;
								$plotprice->pid = $hid;
								// 价格
								$price = str_replace('td>', '', $prs);
								$price = str_replace('</td>', '', $price);
								$plotprice->price = trim($price,'</');
								// 日期
								preg_match_all('/[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]/', $value, $dts);
								if(isset($dts[0][0]) && $dts = $dts[0][0]) {
									$plotprice->time = strtotime($dts);
								}
								// 描述
								if(isset($ars[$key+1])) {
									preg_match_all('/payDeion[^(td)]+/', $ars[$key+1], $dess);
									if(isset($dess[0][0]) && $dess = $dess[0][0]) {
										$dess = str_replace('payDeion">', '', $dess);
										$dess = str_replace('</', '', $dess);
										$plotprice->description = trim($dess);
									}
								}
								$plotprice->save();
							}
						}
					}
				}
			}
		}
		$this->setMessage('抓取成功');
	}

	public function fetchNews($url='',$hid='')
	{
		if(!$url)
			return true;
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		preg_match_all('/<body[.|\s|\S]+body>/', $totalHtml, $results);
		// 去除script标签
		$result = str_replace('script', '', $results[0][0]);

		$result = $this->characet($result);
		preg_match_all('/动态列表 begin-->[.|\s|\S]+动态列表/', $result, $urls);
		if(isset($urls[0][0]) && $urls = $urls[0][0]) {
			preg_match_all('/<h1><a href=".+/', $urls, $sizss);
			if(isset($sizss[0])&&count($sizss[0])) {
				$uarr = [];
				foreach ($sizss[0] as $u) {
					preg_match_all('/http.+htm/', $u, $uu);
					list($l,$t) = explode('_blank', $u);
					$t = str_replace('">', '', $t);
					$t = str_replace('</a></h1>', '', $t);
					isset($uu[0][0]) && $uarr[] = ['url'=>$uu[0][0],'title'=>$t];
				}
				if($uarr) {
					foreach ($uarr as $u) {
						$res = HttpHelper::get($u['url']);
						$totalHtml1 = $res['content'];
						preg_match_all('/<body[.|\s|\S]+body>/', $totalHtml1, $results);
						// 去除script标签
						$result = str_replace('script', '', $results[0][0]);
						$title = $u['title'];
						$preg = '/atc-wrapper[.|\s|\S]+fy-wrapper/';
						preg_match_all($preg, $result, $newss);
						if(isset($newss[0][0])&&$newss = $newss[0][0]) {
							$news = new PlotNewsExt;
							$news->title = $u['title'];
							// 资讯时间
							preg_match_all('/<\/span>[.|\s|\S]+<\/h2>/', $newss, $times);
							if(isset($times[0][0])&&$times = $times[0][0]) {
								$times = str_replace('</span>', '', $times);
								$times = str_replace('</h2>', '', $times);
								$news->time = strtotime(trim($times));
							}
							// 资讯内容
							preg_match_all('/leftboxcom">[.|\s|\S]+<\/div>/', $newss, $times);
							if(isset($times[0][0])&&$times = $times[0][0]) {
								$times = str_replace('leftboxcom">', '', $times);
								$times = str_replace('</div>', '', $times);
								$times = trim($times);

								// 图片干掉
								$times = preg_replace('/<img.+["|\s]\/>/', '', $times);

								$news->content = $this->characet(trim($times)) ;
								$news->pid = $hid;
								$news->save();
							}
						}
					}
				}
			}
		} 
		
	}

	public function fetchWds($url='',$hid='')
	{
		// var_dump($url);exit;
		if(!$url)
			return true;
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		preg_match_all('/<body[.|\s|\S]+body>/', $totalHtml, $results);
		// 去除script标签
		$result = str_replace('script', '', $results[0][0]);

		$result = $this->characet($result);

		preg_match_all('/[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]/', $result, $times);
		// var_dump($result);exit;
		preg_match_all('/dp_content_[0-9]+.+/', $result, $ww);
		if(isset($ww[0][0])&&$ww = $ww[0]) {
			foreach ($ww as $key => $value) {
				preg_match_all('/>.+</', $value, $words);
				if(isset($words[0][0])&&$words = $words[0][0]) {
					$wd = new PlotWdExt;
					$words = trim($words,'<');
					$words = trim($words,'>');
					$wd->pid = $hid;
					$wd->question = $words;
					$wd->time = strtotime($times[0][$key]);
					$wd->save();
				}
				
			}
		}
		$this->setMessage('抓取成功');
	}

	/**
	 * [fetchHx 抓取户型图]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function fetchHx($url='',$hid=0)
	{
		if(!$url)
			return true;
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		// 截取body
		preg_match_all('/<body[.|\s|\S]+body>/', $totalHtml, $results);
		// 去除script标签
		$result = str_replace('script', '', $results[0][0]);

		$result = $this->characet($result);
		// var_dump($result);exit;
		preg_match_all('/ListModel[.|\S|\s]+户型图右部户型图信息[.|\s]+start/', $result, $jxs);

		if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) {
			$lists = explode('xc_img_list', $jxs);
			if($lists) {
				foreach ($lists as $key => $value) {
					preg_match_all('/src.+.jpg/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						$hximg = str_replace('src="', '', $urls);
						$hximg = str_replace('220x150', '748x578', $hximg);

					    // $hximg && $hximg = $this->sfImage($hximg,$url);
					} else continue;
					preg_match_all('/title.+"/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						$hxtitle = str_replace('title=', '', $urls);
						$hxtitle = str_replace('"', '', $hxtitle);
						// var_dump($hxtitle);exit;
					} else continue;
					preg_match_all('/[0-9]+室/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						$hxbed = str_replace('室', '', $urls);
					} else continue;
					preg_match_all('/[0-9]+厅/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						$hxlive = str_replace('厅', '', $urls);
					}
					preg_match_all('/[0-9]+卫/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						$hxbath = str_replace('卫', '', $urls);
					}
					preg_match_all('/fr.+/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						preg_match_all('/[0-9]+/', $urls, $sizss);
						if(isset($sizss[0][0]) && $sizss = $sizss[0][0]) {
							$hxsize = $sizss;
						}
					} else continue;
					preg_match_all('/biaoqian.+/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $urls, $sizss);
						if(isset($sizss[0][0]) && $sizss = $sizss[0][0]) {
							$hxstatus = $sizss;
						}
					} 
					if(isset($hximg) && isset($hxtitle) && isset($hxbed)){
						$hx = new PlotHxExt;
						$hx->image = $hximg;
						$hx->title = $hxtitle;
						$hx->bedroom = $hxbed;
						isset($hxlive) && $hx->livingroom = $hxlive;
						isset($hxbath) && $hx->bathroom = $hxbath;
						$hx->hid = $hid;
						isset($hxsize) && $hx->size = $hxsize;
						isset($hxstatus) && $hx->sale_status = $hxstatus;
						$hx->save();
					}

				}
			}
		}
	}

	/**
	 * [fetchImage 抓取相册]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function fetchImage($url='',$code='',$hid='')
	{
		if(!$url || !$code)
			return true;
		$typeArr = [
			'903'=>'实景图',
			'904'=>'效果图',
			'901'=>'交通图',
			'907'=>'配套图',
			'905'=>'样板间',
		];
		foreach (array_keys($typeArr) as $typeid) {
			foreach ([1] as $page) {
				// var_dump($url."?newcode=$code&type=$typeid&nextpage=$page");exit;
				$getUrl = $url."?newcode=$code&type=$typeid&nextpage=$page";
				$res = HttpHelper::get($getUrl);
				// var_dump($res);exit;
				$totalHtml = $res['content'];
				$totalHtml = $this->characet($totalHtml);
				$data = json_decode($totalHtml,true);
				if($data) {
					foreach ($data as $key => $value) {
						// var_dump($value);exit;
						$image = new PlotImageExt();
						isset($value['title'])&&$image->title = $value['title'];
						$image->type = $typeArr[$typeid];
						isset($value['url'])&&$image->url = $value['url'];
						// isset($value['url'])&&$image->url = $this->sfImage($value['url'],$getUrl);
						$image->hid = $hid;
						if($image->url)
							$image->save();
					}
				}
			}
		}
		return true;
	}

	/**
	 * [actionList 楼盘列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionList($title='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		if($title)
			$criteria->addSearchCondition('title',$title);
		$houses = PlotExt::model()->undeleted()->getList($criteria,20);
		$this->render('list',['infos'=>$houses->data,'pager'=>$houses->pagination]);
	}

	/**
	 * [actionList 户型列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionHxlist($hid='')
	{
		// $_SERVER['HTTP_REFERER']='http://www.baidu.com';
		$house = PlotExt::model()->findByPk($hid);
		if(!$house){
			$this->redirect('/admin');
		}
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		$criteria->addCondition('hid=:hid');
		$criteria->params[':hid'] = $hid;
		$houses = PlotHxExt::model()->undeleted()->getList($criteria,20);
		$this->render('hxlist',['infos'=>$houses->data,'pager'=>$houses->pagination,'house'=>$house]);
	}

	/**
	 * [actionList 动态列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionNewslist($hid='')
	{
		// $_SERVER['HTTP_REFERER']='http://www.baidu.com';
		$house = PlotExt::model()->findByPk($hid);
		if(!$house){
			$this->redirect('/admin');
		}
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		$criteria->addCondition('pid=:hid');
		$criteria->params[':hid'] = $hid;
		$houses = PlotNewsExt::model()->undeleted()->getList($criteria,20);
		$this->render('newslist',['infos'=>$houses->data,'pager'=>$houses->pagination,'house'=>$house]);
	}

	/**
	 * [actionList 价格列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionPricelist($hid='')
	{
		// $_SERVER['HTTP_REFERER']='http://www.baidu.com';
		$house = PlotExt::model()->findByPk($hid);
		if(!$house){
			$this->redirect('/admin');
		}
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		$criteria->addCondition('pid=:hid');
		$criteria->params[':hid'] = $hid;
		$houses = PlotPriceExt::model()->undeleted()->getList($criteria,20);
		$this->render('pricelist',['infos'=>$houses->data,'pager'=>$houses->pagination,'house'=>$house]);
	}

	/**
	 * [actionList 问答列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionWdslist($hid='')
	{
		// $_SERVER['HTTP_REFERER']='http://www.baidu.com';
		$house = PlotExt::model()->findByPk($hid);
		if(!$house){
			$this->redirect('/admin');
		}
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		$criteria->addCondition('pid=:hid');
		$criteria->params[':hid'] = $hid;
		$houses = PlotWdExt::model()->undeleted()->getList($criteria,20);
		$this->render('wdlist',['infos'=>$houses->data,'pager'=>$houses->pagination,'house'=>$house]);
	}

	/**
	 * [actionList 相册列表]
	 * @param  string $title [description]
	 * @return [type]        [description]
	 */
	public function actionImagelist($hid='')
	{
		// $_SERVER['HTTP_REFERER']='http://www.baidu.com';
		$house = PlotExt::model()->findByPk($hid);
		if(!$house){
			$this->redirect('/admin');
		}
		$criteria = new CDbCriteria;
		$criteria->order = 'updated desc,id desc';
		$criteria->addCondition('hid=:hid');
		$criteria->params[':hid'] = $hid;
		$houses = PlotImageExt::model()->undeleted()->getList($criteria,20);
		$this->render('imagelist',['infos'=>$houses->data,'pager'=>$houses->pagination,'house'=>$house]);
	}

	public function actionAjaxDel($id='')
	{
		if($id) {
			$plot = PlotExt::model()->findByPk($id);
			$plot->deleted=1;
			if($plot->save()) {
				$this->setMessage('操作成功','success');
			} else {
				$this->setMessage('操作失败','error');
			}
		}
	}

	/**
	 * [actionEdit 楼盘编辑页]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function actionEdit($id='')
	{
		$house = PlotExt::model()->findByPk($id);
		if(!$house){
			$this->redirect('/admin');
		}
		if(Yii::app()->request->getIsPostRequest()) {
			$values = Yii::app()->request->getPost('PlotExt',[]);
			$house->attributes = $values;
			if(strpos($house->open_time,'-')) {
				$house->open_time = strtotime($house->open_time);
			}
			if(strpos($house->delivery_time,'-')) {
				$house->delivery_time = strtotime($house->delivery_time);
			}
			if($house->save()) {
				$this->setMessage('保存成功','success');
				$this->redirect('/admin/house/list');
			} else {
				$this->setMessage('保存失败','error');
			}
		}
		$this->render('edit',['house'=>$house]);
	}

	public function actionDealimage($hid='')
	{
		$value = PlotExt::model()->findByPk($hid);
		$hxs = $value->hxs;
		$imgs = $value->images;
		if($hxs){
			if(!strstr($hxs[0]['image'],'http')) {
				$this->setMessage('已处理','success');
				$this->redirect('/admin/house/list');
			}
				
		}elseif($imgs){
			if(!strstr($imgs[0]['url'],'http')) {
				$this->setMessage('已处理','success');
				$this->redirect('/admin/house/list');
			}
				
		}
		// $value->image = $this->sfimage($value->image,$value->image);
  //       $value->save();
        if($hxs){
            foreach ($hxs as $hx) {
                $hx->image = $this->sfimage($hx->image,$hx->image);
                $hx->save();
            }
        }
        if($imgs){
            foreach ($imgs as $img) {
                $img->url = $this->sfimage($img->url,$img->url);
                $img->save();
            }
        }
        $this->setMessage('处理完毕','success');
        $this->redirect('/admin/house/list');
	}

	public function actionTohj($hid='')
	{
		$token = '000d811b3d06f933d9316b04359d0f1e';
		$plot = PlotExt::model()->findByPk($hid);
		$value = $plot->attributes;
        $data_conf = json_decode($value['data_conf'],true);
        // va
        unset($value['data_conf']);
        unset($value['deleted']);
        unset($value['created']);
        unset($value['updated']);
        // $tmp = array_merge($value,$data_conf);
        // var_dump($tmp);exit;
        foreach (array_merge($value,$data_conf) as $k => $v) {
            if($k!='transit'&&$k!='peripheral'&&$k!='content')
                $tmp[$k] = $this->unicode_decode($v); 
            else
                $tmp[$k] = str_replace(['\n','\t','\r'], '', $v);
        }
        $tmp['is_new'] = $tmp['status'] = $tmp['is_coop'] = 1;

        // $areas = Yii::app()->params['area'];
        $jzlbs = Yii::app()->params['jzlb'];
        $zxzts = Yii::app()->params['zxzt'];
        $xmtss = Yii::app()->params['xmts'];
        $wylxs = Yii::app()->params['wylx'];
        $xszts = Yii::app()->params['xszt'];
        // foreach ($areas as $k => $v) {
        //     if(strstr($value['area'],$k))
        //         $tmp['area'] = $v;
        //     if(strstr($value['street'],$k))
        //         $tmp['street'] = $v;
        // }
        foreach ($jzlbs as $k => $v) {
            if(isset($tmp['jzlb'])&&strstr($tmp['jzlb'],$k))
                $tmp_jzlb[] = $v;
        }
        foreach ($zxzts as $k => $v) {
            if(isset($tmp['zxzt'])&&strstr($tmp['zxzt'],$k))
                $tmp_zxzt[] = $v;
        }
        foreach ($xmtss as $k => $v) {
            if(isset($tmp['xmts'])&&strstr($tmp['xmts'],$k))
                $tmp_xmts[] = $v;
        }
        foreach ($wylxs as $k => $v) {
            if(isset($tmp['wylx'])&&strstr($tmp['wylx'],$k))
                $tmp_wylx[] = $v;
        }
        foreach ($xszts as $k => $v) {
            if(isset($tmp['xszt'])&&strstr($tmp['xszt'],$k))
                $tmp['xszt'] = $v;
        }
        if(strstr($tmp['image'],'http')){
            $tmp['image'] = $this->sfImage($tmp['image'],$tmp['image']);
        }
        $tmp['image'] && $tmp['image'] = ImageTools::fixImagefcc($tmp['image'],600,400);;
        // if(!is_numeric($tmp['area']))
        //     continue;
        if(!isset($tmp_jzlb))
            $tmp['jzlb'] = [];
        else
            $tmp['jzlb'] = $tmp_jzlb;
        if(!isset($tmp_zxzt))
            $tmp['zxzt'] = [];
        else
            $tmp['zxzt'] = $tmp_zxzt;
        if(!isset($tmp_xmts))
            $tmp['xmts'] = [];
        else
            $tmp['xmts'] = $tmp_xmts;
        if(!isset($tmp_wylx))
            $tmp['wylx'] = [];
        else
            $tmp['wylx'] = $tmp_wylx;
        if(!isset($tmp_xszt))
            $tmp['sale_status'] = 2;
        else
            $tmp['sale_status'] = $tmp_xszt;
        unset($tmp_jzlb);
        unset($tmp_zxzt);
        unset($tmp_xmts);
        unset($tmp_wylx);
        unset($tmp_xszt);

        if($tmp['price']) {
            if(strstr($tmp['price'],'套')){
                $tmp['unit'] = 2;
            } else {
                $tmp['unit'] = 1;
            }
            preg_match_all('/[0-9|.]+/', $tmp['price'], $pricefs);
            if(isset($pricefs[0][0]) && $tmp['price'] = intval($pricefs[0][0])) ;
            else $tmp['price'] = 0;
        }
        $tmp['token'] = $token;
        foreach ($tmp as $k => $v) {
        	if(is_array($v)) {
        		foreach ($v as $t => $m) {
        			$tmp[$k."[$t]"] = $m;
        		}
        		unset($tmp[$k]);
        	}
        }
        $tmp['area'] = trim($value['area']);
        $tmp['street'] = trim($value['street']);
        $res = HttpHelper::post('http://www.fangcc.cn/rest/importOnePlot',$tmp);
        // var_dump($res['content']);exit;
        $res = json_decode($res['content'],true);
        if(isset($res['data']) && array_keys($res['data'])[0]=='error'){
        	$this->setMessage($res['data']['error'],'error');
        	return;
        // if(1==2){
        }elseif(array_keys($res)[0]=='error'){
        	$this->setMessage($res['error'],'error');
        	return;
        }
        else{
        	if($hxs = $plot->hxs) {
        		$tmp = [];
        		foreach ($hxs as $t => $hx) {
        			if(!$hx->image||strstr($hx->image,'http'))
        				continue;
        			$tmp["images[$t]"] = ImageTools::fixImagefcc($hx->image);
        			$tmp["hids[$t]"] = $hx->hid;
        			$tmp["bedrooms[$t]"] = $hx->bedroom;
        			$tmp["titles[$t]"] = $hx->title;
        			$tmp["livingrooms[$t]"] = $hx->livingroom;
        			$tmp["bathrooms[$t]"] = $hx->bathroom;
        			$tmp["sizes[$t]"] = $hx->size;
        			// $tmp["sale_statuss[$t]"] = $hx->sale_status;
        			if($sat = $hx['sale_status']) {
	                    if($sat == '在售') {
	                        $tmp["sale_statuss[$t]"] = 1;
	                    } elseif($sat == '售完') {
	                        $tmp["sale_statuss[$t]"] = 0;
	                    } elseif($sat == '待售') {
	                        $tmp["sale_statuss[$t]"] = 2;
	                    }
	                }
        		}
        		$res = HttpHelper::post('http://www.fangcc.cn/rest/importPlotHx',$tmp);
		        // var_dump($res);exit;
		        $res = json_decode($res['content'],true);
		        // var_dump($res);exit;
		        if(array_keys($res['data'])[0]=='error'){
		        	$this->setMessage($res['data']['error'],'error');
		        	return;
		        } elseif($imgs = $plot->images) {
		        	$tmp = [];
	        		foreach ($imgs as $t => $hx) {
	        			if(!$hx->url||strstr($hx->url,'http'))
	        				continue;
	        			$tmp["urls[$t]"] = ImageTools::fixImagefcc($hx->url);
	        			// $tmp["urls[$t]"] = $hx->url;
	        			$tmp["hids[$t]"] = $hx->hid;
	        			$tmp["types[$t]"] = Yii::app()->params['imageTag'][$hx->type];
	        			$tmp["titles[$t]"] = $hx->title;
	        		}
	        		$res = HttpHelper::post('http://www.fangcc.cn/rest/importPlotImg',$tmp);
			        // var_dump($res['content']);exit;
			        $res = json_decode($res['content'],true);
			        if(array_keys($res['data'])[0]=='error'){
			        	$this->setMessage($res['data']['error'],'error');
			        	return;
	        		} elseif($prices = $plot->prices) {
	        			$this->exportPrices($prices);
	        		}
	        	}
        	}
		        	
        	$this->setMessage('导入成功','success');
        }
	}

	public function actionEPrices($id='')
	{
		$prices = PlotExt::model()->findByPk($id)->prices;
		if($prices) {
			$this->exportPrices($prices);
		} else{
			$this->setMessage('没有数据','error');
		}
	}

	public function exportPrices($prices=[])
	{
		$tmp = [];
		foreach ($prices as $t => $v) {
			preg_match_all('/[0-9]+/', $v->price, $pss);
			if(isset($pss[0][0]))
				$tmp["prices[$t]"] = $pss[0][0]; 
			else
				continue;
			$tmp["hids[$t]"] = $v->pid;
			$price = $v->price;
			if(strstr($v->price,'套')) {
				$tmp["units[$t]"] = 2;
				$tmp["jglbs[$t]"] = 79;
			} else {
				$tmp["units[$t]"] = 1;
				$tmp["jglbs[$t]"] = 76;
			}
			

			$tmp["descriptions[$t]"] = $v->description;
			$tmp["times[$t]"] = $v->time;
			// $tmp["titles[$t]"] = $v->title;
		}
		$res = HttpHelper::post('http://www.fangcc.cn/rest/importPlotPrices',$tmp);
        // var_dump($res['content']);exit;
        $res = json_decode($res['content'],true);
        if(array_keys($res['data'])[0]=='error'){
        	$this->setMessage($res['data']['error'],'error');
        	return;
		}
		$this->setMessage('导入成功');
	}

	public function actionENews($id='')
	{
		$prices = PlotExt::model()->findByPk($id)->news;
		if($prices) {
			$this->exportNews($prices);
		} else{
			$this->setMessage('没有数据','error');
		}
	}

	public function exportNews($prices=[])
	{
		$tmp = [];
		foreach ($prices as $t => $v) {
			$tmp["hids[$t]"] = $v->pid;
			$tmp["ids[$t]"] = $v->id;
			$tmp["cids[$t]"] = 2;
			$tmp["contents[$t]"] = $v->content;
			$tmp["times[$t]"] = $v->time;
			$tmp["titles[$t]"] = $v->title;
		}
		$res = HttpHelper::post('http://www.fangcc.cn/rest/importPlotNews',$tmp);
        // var_dump($res['content']);exit;
        $res = json_decode($res['content'],true);
        if(array_keys($res['data'])[0]=='error'){
        	$this->setMessage($res['data']['error'],'error');
        	return;
		}
		$this->setMessage('导入成功');
	}

	public function actionEWds($id='')
	{
		$prices = PlotExt::model()->findByPk($id)->wds;
		if($prices) {
			$this->exportWds($prices);
		} else{
			$this->setMessage('没有数据','error');
		}
	}

	public function exportWds($prices=[])
	{
		$tmp = [];
		foreach ($prices as $t => $v) {
			$tmp["hids[$t]"] = $v->pid;
			$tmp["ids[$t]"] = $v->id;
			$tmp["cids[$t]"] = 47;
			$v->question = preg_replace('/href="[^>]+"/', '', $v->question);

			$tmp["questions[$t]"] = $v->question;
			$tmp["times[$t]"] = $v->time;
			$tmp["answers[$t]"] = '感谢您的点评！';
		}
		$res = HttpHelper::post('http://www.fangcc.cn/rest/importPlotWds',$tmp);
        // var_dump($res['content']);exit;
        $res = json_decode($res['content'],true);
        if(array_keys($res['data'])[0]=='error'){
        	$this->setMessage($res['data']['error'],'error');
        	return;
		}
		$this->setMessage('导入成功');
	}

	public function actionDelNews($id='')
	{
		$news = PlotNewsExt::model()->findByPk($id);
		$news->deleted = 1;
		$news->save();
		$this->setMessage('操作成功','success');
	}

	public function actionDelPrice($id='')
	{
		$news = PlotPriceExt::model()->findByPk($id);
		$news->deleted = 1;
		$news->save();
		$this->setMessage('操作成功','success');
	}

	public function actionDelWds($id='')
	{
		$news = PlotWdExt::model()->findByPk($id);
		$news->deleted = 1;
		$news->save();
		$this->setMessage('操作成功','success');
	}


}