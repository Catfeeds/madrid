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

		// 标题
		preg_match_all('/<h1>[.|\s|\S]+h1>/', $result, $titleTag);
		preg_match_all('/">.+<\/a><!--/', $titleTag[0][0], $titleTag2);
		// var_dump($titleTag2);
		$title = str_replace('">', '', $titleTag2[0][0]);
		$title = str_replace('</a><!--', '', $title);
		// 编码装换
		$title = $this->characet($title);
		$result = $this->characet($result);
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
			$plot->image = $this->sfImage($jps,$url);
			// $jps = Yii::app()->file->fetch($jps);
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
					    $hximg = $this->sfImage($hximg,$url);
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
	public function fetchImage($value='')
	{
		# code...
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
		$_SERVER['HTTP_REFERER']='http://www.baidu.com';
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

	// 找的中文转拼音的方法
	function Pinyin($_String, $_Code='gb2312'){
     
    $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
          "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
          "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
          "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
          "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
          "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
          "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
          "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
          "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
          "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
          "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
          "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
          "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
          "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
          "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
          "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
           
    $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
          "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
          "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
          "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
          "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
          "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
          "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
          "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
          "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
          "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
          "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
          "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
          "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
          "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
          "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
          "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
          "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
          "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
          "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
          "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
          "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
          "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
          "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
          "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
          "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
          "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
          "|-10270|-10262|-10260|-10256|-10254";
           
    $_TDataKey = explode('|', $_DataKey);
    $_TDataValue = explode('|', $_DataValue);
    $_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : $this->Arr_Combine($_TDataKey, $_TDataValue);
    arsort($_Data);
    reset($_Data);
    if($_Code != 'gb2312') $_String = $this->U2_Utf8_Gb($_String);
    $_Res = '';
    for($i=0; $i<strlen($_String); $i++){
      $_P = ord(substr($_String, $i, 1));
      if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; }
      $_Res .= $this->Pinyins($_P, $_Data);
    }
    return $_Res;
    //return preg_replace("/[^a-z0-9]*/", '', $_Res);
  }
     
  function Pinyins($_Num, $_Data){
    if ($_Num>0 && $_Num<160 ) return chr($_Num);
      elseif($_Num<-20319 || $_Num>-10247) return '';
    else {
      foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
      return $k;
    }
  }
  function U2_Utf8_Gb($_C){
    $_String = '';
    if($_C < 0x80){ 
      $_String .= $_C;
    }elseif($_C < 0x800){
      $_String .= chr(0xC0 | $_C>>6);
      $_String .= chr(0x80 | $_C & 0x3F);
    }elseif($_C < 0x10000){
      $_String .= chr(0xE0 | $_C>>12);
      $_String .= chr(0x80 | $_C>>6 & 0x3F);
      $_String .= chr(0x80 | $_C & 0x3F);
    }elseif($_C < 0x200000) {
      $_String .= chr(0xF0 | $_C>>18);
      $_String .= chr(0x80 | $_C>>12 & 0x3F);
      $_String .= chr(0x80 | $_C>>6 & 0x3F);
      $_String .= chr(0x80 | $_C & 0x3F);
    }
      return iconv('UTF-8', 'GB2312', $_String);
    }
  function Arr_Combine($_Arr1, $_Arr2){
    for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
    return $_Res;
  }

  function characet($data){
  if( !empty($data) ){
    $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
    if( $fileType != 'UTF-8'){
      $data = mb_convert_encoding($data ,'utf-8' , $fileType);
    }
  }
  return $data;
}

	function request_by_curl($remote_server,$post_string,$upToken) {  

		  $headers = array();
		  $headers[] = 'Content-Type:image/png';
		  $headers[] = 'Authorization:UpToken '.$upToken;
		  $ch = curl_init();  
		  curl_setopt($ch, CURLOPT_URL,$remote_server);  
		  //curl_setopt($ch, CURLOPT_HEADER, 0);
		  curl_setopt($ch, CURLOPT_HTTPHEADER ,$headers);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		  //curl_setopt($ch, CURLOPT_POST, 1);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		  $data = curl_exec($ch);  
		  curl_close($ch);  
		  
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
		$file_contents = file_get_contents($img,false, $context);
		$name = str_replace('.', '', microtime(1)) . rand(100000,999999).'.jpg';

		file_put_contents('/'.$name, $file_contents);
		$fileName = Yii::app()->file->getFilePath().str_replace('.', '', microtime(1)) . rand(100000,999999).'.jpg';

		$upManager = new UploadManager();
	    list($ret, $error) = $upManager->putFile($this->createQnKey(),$fileName, '/'.$name);
	    if(!$error)
	    	return $ret['key'];
	    else
	    	return '';
    }
}