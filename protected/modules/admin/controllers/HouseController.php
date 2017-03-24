<?php
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
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
		preg_match_all('/">.+<\/a><!--/', $titleTag[0][0], $titleTag2);
		// var_dump($titleTag2);
		$title = str_replace('">', '', $titleTag2[0][0]);
		$title = str_replace('</a><!--', '', $title);
		// 编码装换
		$title = $this->characet($title);
		$plot->title = $title;
		// 拼音
		// $plot->pinyin = $this->Pinyin($title,1);
		// var_dump(strpos($result, '常州'),$result);exit;
		// str_replace('销售信息', 'xsxx', $result);
		// var_dump($result);exit;
		// 基本信息+销售信息
		preg_match_all('/<div class="main_1200">[.|\s|\s]+<!--[.|\s|\S]+list-right c00">.+/', $result, $xsTags);
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
		preg_match_all('/list-right-text">[\x{4e00}-\x{9fa5}|0-9]+/u', $xxs, $adds);
			// var_dump($adds);exit;
		if(isset($adds[0][0]) && $adds = $adds[0][0]) {
			$addr = str_replace('list-right-text">', '', $adds);
		}
		$plot->address = $addr;
		// 销售状态
		$xszt = '';
		preg_match_all('/销售状态：<\/div>[\s]+<div class="list-right">[\s].+<\/div>/', $xxs, $xszts);
		if(isset($xszts[0][0]) && $xszts = $xszts[0][0]) {
			// var_dump($xszts);exit;
			preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $xszts, $xsztarr);
			$xszt = $xsztarr[0][1];
		}
		$plot->sale_status = $xszt;
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
		preg_match_all('/c00">.+</', $xxs, $jfsjs);
		if(isset($jfsjs[0][0]) && $kpsjs = $jfsjs[0][0]) { 
			$phone = str_replace('c00">', '', $kpsjs);
			// var_dump($phone);
			$phone = trim($phone,'<');
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
			preg_match_all('/title=.+<\/a>/',$xqghs,$ars);
			if(isset($ars[0][0])) {
				preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $ars[0][0], $arss);
				// var_dump($arss);exit;
				if(isset($arss[0][1])) {
					// var_dump();exit;
					$plot->street = str_replace('楼盘', '', $arss[0][1]);
				}
			}
		}
		// 封面
		preg_match_all('/face.+.jpg\'/', $result, $jps);
		if(isset($jps[0][0]) && $jps = $jps[0][0]) {
			$jps = str_replace('face = ', '', $jps);
			$jps = trim($jps,"'");
			// $jps = $this->sfImage($jps,$url);
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
			// 楼盘id
			preg_match_all('/newcode=.+/', $result, $jxs);
			if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) { 
				$code = str_replace("newcode='", '', $jxs);
				$code = str_replace("';", '', $code);
				$code = trim($code);
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
		// 抓取户型图
		preg_match_all('/<a.+padding:0 11px;">户型/', $result, $jxs);
		if(isset($jxs[0][0]) && $jxs = $jxs[0][0]) {
			
			preg_match_all('/photo\/list.+htm/', $jxs, $urls);
			if(isset($urls[0][0]) && $urls = $urls[0][0]) {
				$urlar = explode('com', $url);
				$hxurl = $urlar[0] . 'com/' . $urls;
			}
		}
		
		// var_dump($hxurl);exit;
		if($plot->save()) {
			if(isset($hxurl) && $hxurl)
				$this->fetchHx($hxurl,$plot->id);
			// 抓取相册
			$imageurl = isset($urlar[0])?($urlar[0] . 'com/house/ajaxrequest/photolist_get.php'):'';
			if($imageurl) {
				$this->fetchImage($imageurl,$code,$plot->id);
			}
			$this->setMessage('保存成功','success');
		}
		
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
					preg_match_all('/fr.+/', $value, $urls);
					if(isset($urls[0][0]) && $urls = $urls[0][0]) {
						preg_match_all('/[0-9]+/', $urls, $sizss);
						if(isset($sizss[0][0]) && $sizss = $sizss[0][0]) {
							$hxsize = $sizss;
						}
					} else continue;
					if(isset($hximg) && isset($hxtitle) && isset($hxbed)){
						$hx = new PlotHxExt;
						$hx->image = $hximg;
						$hx->title = $hxtitle;
						$hx->bedroom = $hxbed;
						$hx->hid = $hid;
						isset($hxsize) && $hx->size = $hxsize;
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
			foreach ([1,2] as $page) {
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

	/**
	 * [actionExport 导出固定格式接口]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function actionExport($page='')
	{
		// is_new=>1 status=>1 is_coop=>1
		# code...
	}

  	function characet($data)
  	{
	  	if( !empty($data) ){
		    $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
		    if( $fileType != 'UTF-8'){
		      $data = mb_convert_encoding($data ,'utf-8' , $fileType);
		    }
		}
		return $data;
	}

	/**
     * [actionQnUpload 七牛图片上传]
     * @return [type] [description]
     */
    public function createQnKey()
    {
        $auth = new Auth(Yii::app()->file->accessKey,Yii::app()->file->secretKey);
        $policy = array(
            'mimeLimit'=>'image/*',
            'fsizeLimit'=>10000000,
            'saveKey'=>Yii::app()->file->createQiniuKey(),
        );
        $token = $auth->uploadToken(Yii::app()->file->bucket,null,3600,$policy);
        return $token;
    }

    public function sfImage($img='',$refer = '')
    {
    	$opt=array("http"=>array("header"=>"Referer: " . $refer)); 
		$context=stream_context_create($opt); 
		try{
			$file_contents = file_get_contents($img,false, $context);
		} catch(Exception $e){
			echo $e->getMessage();
			return '';
		}
		
		$name = str_replace('.', '', microtime(1)) . rand(100000,999999).'.jpg';
		$path = '/mnt/sfimages\/';
		if (! file_exists ( $path )) 
        	mkdir ( "$path", 0777, true );
		file_put_contents($path.$name, $file_contents);
		$fileName = Yii::app()->file->getFilePath().str_replace('.', '', microtime(1)) . rand(100000,999999).'.jpg';

		$upManager = new UploadManager();
		try{
			list($ret, $error) = $upManager->putFile($this->createQnKey(),$fileName, $path.$name);
		} catch(Exception $e) {
			echo $e->getMessage();
			return '';
		}
	    
	    if(!$error){
	    	unlink($path.$name);
	    	return $ret['key'];
	    }
	    else
	    	return '';
    }
}