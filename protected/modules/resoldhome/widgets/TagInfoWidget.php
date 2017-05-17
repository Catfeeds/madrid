<?php
/**
 * 二手房标签筛选小物件
 * 二手房、租房、求租、求购的价格、面积、区域、户型筛选物件
 * $cate字段说明：面积cate传'area'，面积cate传'size'，其余的传TagExt定义的cate
 * $id字段说明：传每个cate对应的id
 * $get字段说明：传所有get参数，如$_GET
 * 渲染出的标签链接参数为{价格:price,面积:size,区域:area/street,户型:bedroom}
 * @author steven allen <[<email address>]>
 * @date(2016.10.31)
 */
class TagInfoWidget extends CWidget
{
	public $url;

	public $cate;

	public $id;

	public $get;

	public function run()
	{
		$get = array_filter($this->get);

		unset($get['page']);
		// var_dump($get);exit;
		// 区域街道筛选
		if($this->cate == 'area' || $this->cate == 'street')
		{
			unset($get['area']);
			unset($get['street']);
			$areaId = 0;
			// 当前区域
			if(!empty($this->id)){
				$nowArea = AreaExt::model()->normal()->findByPk($this->id);
				if($nowArea)
					$areaId = $nowArea->parent == 0 ? $this->id : $nowArea->getParentArea()->id;
			}
			// 所有区域
			$areas = AreaExt::model()->normal()->findAll(['condition'=>'parent = 0','order'=>'sort asc']);
			// 当前区域/街道 所在的区域显示被选
			$html = '<ul class="main"><li><a'.(!$areaId?(' class="on" '):'').' href="'.$this->getController()->createUrl($this->url,$get?array_merge(['area'=>0],$get):['area'=>0]).'">不限</a></li>';
    		foreach ($areas as $key => $value) {
	        	$html .= '<li><a class="'.($areaId==$value['id']?'on':'').'" href="'.$this->getController()->createUrl($this->url,$get?array_merge(['area'=>$value['id']],$get):['area'=>$value['id']]).'">'.$value['name'].'</a></li>';
	        }
	        $html .= ' </ul>';
	        if($this->id != 0 && SM::resoldConfig()->resoldIsOpenStreet())
	        {
	        	// 所有街道
	        	$streets = AreaExt::model()->normal()->findAll(['condition'=>'parent=:parent','params'=>[':parent'=>$areaId],'order'=>'sort asc']);
	        	// 当前街道所在的街道显示被选
	        	$html .= '<ul class="sub"><li><a'.($this->id == $areaId?(' class="on" '):'').' href="'.$this->getController()->createUrl($this->url,$get?array_merge(['area'=>$areaId],$get):['area'=>$areaId]).'">不限</a></li>';
	        	foreach ($streets as $key => $value) {
	        		$html .= '<li><a class="'.($this->id==$value['id']?'on':'').'" href="'.$this->getController()->createUrl($this->url,$get?array_merge(['street'=>$value['id']],$get):['street'=>$value['id']]).'">'.$value['name'].'</a></li>';
	       		 }
	       		 $html .= ' </ul>';
	       	}
            echo $html;

		}
		else
		{
			$arr = [
				'esfzzprice'=>'price',
				'esfspprice'=>'price',
				'esfxzlprice'=>'price',
				'plotprice'=>'price',
				'zfzzprice'=>'price',
				'zfspprice'=>'price',
				'zfxzlprice'=>'price',
				'resoldhuxing'=>'bedroom',
				'esfzzsize'=>'size',
				'esfspsize'=>'size',
				'esfxzlsize'=>'size',
				'zfzzsize'=>'size',
				'zfspsize'=>'size',
				'zfxzlsize'=>'size',
				'esfzfxzltype'=>'cate',
				'esfzfsptype'=>'cate',
				'zfmode'=>'way',
				'zfspts'=>'ts',
				'zfxzlts'=>'ts',
				'esfspts'=>'ts',
				'esfxzlts'=>'ts',
				'esfzzts'=>'ts',
				'zfzzts'=>'ts',
				'zfxzllevel'=>'level',
				'xinfangjiage'=>'price'
				];
			$tagCate = $arr[$this->cate];
			unset($get[$tagCate]);
			// tmpTag用来存放删去自定义标签后的标签
			$tmpTag = $get;
			$tags = isset(TagExt::getAllByCate()[$this->cate])?TagExt::getAllByCate()[$this->cate]:'';
			$html = '';
			if($tags)
			{
				// 选择价格、面积标签则把自定义价格、面积筛选删去
				if($tagCate == 'price'){
					if(isset($get['minprice']))
						unset($tmpTag['minprice']);
					if(isset($get['maxprice']))
						unset($tmpTag['maxprice']);
				}
				if($tagCate == 'size'){
					if(isset($get['minsize']))
						unset($tmpTag['minsize']);
					if(isset($get['maxsize']))
						unset($tmpTag['maxsize']);
				}

				$html = '<ul><li><a'.(!$this->id?(' class="on" '):'').' href="'.$this->getController()->createUrl($this->url,$get?array_merge([$tagCate=>0],$tmpTag):[$tagCate=>0]).'">不限</a></li>';
				foreach ($tags as $key => $value) {
					if($this->cate == 'zfmode'){
						if($value['name']=='不限'){
							continue;
						}
						$html .= '<li><a class="'.($this->id==$value['id']?'on':'').'" href="'.$this->getController()->createUrl($this->url,$get?array_merge([$tagCate=>$value['id']],$tmpTag):[$tagCate=>$value['id']]).'">'.$value['name'].'</a></li>';
					}else{
						$html .= '<li><a class="'.($this->id==$value['id']?'on':'').'" href="'.$this->getController()->createUrl($this->url,$get?array_merge([$tagCate=>$value['id']],$tmpTag):[$tagCate=>$value['id']]).'">'.$value['name'].'</a></li>';
					}

				}
				// 自定义价格筛选
				if(strstr($tagCate,'price'))
				{
					$html .= '<li><form method="get"><input type="text" name="minprice" class="short" value="'.(isset($get['minprice'])?$get['minprice']:'').'">-<input type="text" name="maxprice" class="short" value="'.(isset($get['maxprice'])?$get['maxprice']:'').'">'.(strstr($this->cate,'esf')?'万':'元').'<input  type="submit" value="确定" class="btn" >';
					if($get)
						foreach ($tmpTag as $key => $v) {
							$html .= '<input type="hidden" name="'.$key.'" value="'.$v.'"></input>';
						}
					$html .= '</form></li>';
				}
				// 自定义面积筛选
				if(strstr($tagCate,'size'))
				{
					$html .= '<li><form method="get"><input type="text" name="minsize" class="short" value="'.(isset($get['minsize'])?$get['minsize']:'').'">-<input type="text" name="maxsize" class="short" value="'.(isset($get['maxsize'])?$get['maxsize']:'').'"><input  type="submit" value="确定" class="btn" >';
					if($get)
						foreach ($tmpTag as $key => $v) {
							$html .= '<input type="hidden" name="'.$key.'" value="'.$v.'"></input>';
						}
					$html .= '</form></li>';
				}
				$html .= ' </ul>';
			}
			echo $html;
		}
	}



}
