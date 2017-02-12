<?php
/**
 * 楼盘列表页
 * @author weibaqiu
 * @version 2016-05-30
 */
class ListAction extends CAction
{
    public $urlConstructor;

    public function run($ajax=0,$keywords='')
    {
        $this->urlConstructor = $this->controller->urlConstructor = new UrlConstructor;
        //开盘时间
        $kpsjOptions = array(
            'by' =>array('name'=>'本月开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+1, 1, date('Y'))),
            'xy' =>array('name'=>'下月开盘','start'=>mktime(0, 0, 0, date('m')+1, 1, date('Y')),'expire'=>null),
            'syn' =>array('name'=>'三月内开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+2, 17, date('Y'))),
            'lyn' =>array('name'=>'六月内开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+5, 17, date('Y'))),
            'qsy' =>array('name'=>'前三月已开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')-3, 17, date('Y'))),
            'qly' =>array('name'=>'前六月已开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')-6, 17, date('Y'))),
        );
        //排序设置
        $sortOptions = array(
            1 => array('name'=>'价格由高到低','value'=>false,'field'=>'price'),
            2 => array('name'=>'价格由低到高','value'=>true, 'field'=>'price'),
            3 => array('name'=>'开盘时间由近到远','value'=>false,'field'=>'open_time'),
            4 => array('name'=>'开盘时间由远到近','value'=>true,'field'=>'open_time'),
        );
        //所有标签
        $allTags = TagExt::model()->normal()->findAll(['order'=>'sort asc']);
        $allTagsIndexByCate = array();
        foreach($allTags as $tag){
            $allTagsIndexByCate[$tag->cate][$tag->id] = $tag;
        }
        //价格标签
        $priceTag = isset($allTagsIndexByCate['xinfangjiage']) ? $allTagsIndexByCate['xinfangjiage'] : [];
        //居室标签
        $hxTags = isset($allTagsIndexByCate['xinfanghuxing']) ? $allTagsIndexByCate['xinfanghuxing'] : [];
        $bedrooms = [];
        foreach($hxTags as $hx) {
            $bedrooms[$hx->id] = $hx->name;
        }
        if($ajax>0){
            $lng = (float)Yii::app()->request->getQuery('lng', 0);
            $lat = (float)Yii::app()->request->getQuery('lat', 0);
            $kw = $this->controller->cleanXss($keywords);
            $xs = Yii::app()->search->house_plot;
            $xs->setQuery($kw);
            /******************迅搜条件********************/
            $xs->setFacets(array('status'), true);//分面统计

            //分词搜索，类型、特色
            foreach(['wylx','xmts','zxzt'] as $k){
                if(isset($this->urlConstructor->extMap[$k])){
                    $q = $k.':'.$this->urlConstructor->extMap[$k];
                    $xs->addQueryString($q, XS_CMD_QUERY_OP_AND);
                }
            }

            //分词搜索，学校筛选
            if( $xid = $this->urlConstructor->xuexiao ) {
                $xs->addQueryString('school_id:'.$xid, XS_CMD_QUERY_OP_AND);
            }

            //分词搜索，户型筛选
            if( isset($hxTags[$this->urlConstructor->huxing]) ) {
                $hxTag = $hxTags[$this->urlConstructor->huxing];
                if($hxTag->min>0 && $hxTag->max>0){//max和min都设置了数值
                    if($hxTag->max-$hxTag->min>0) {//如：5-7之间户型
                        $xs->addQueryString('bedroom:'.$hxTag->min.'>', XS_CMD_QUERY_OP_AND);
                        $xs->addQueryString('bedroom:<'.$hxTag->max, XS_CMD_QUERY_OP_AND);

                    } else {
                        $i = $hxTag->max;
                        $xs->addQueryString('bedroom:'.$i, XS_CMD_QUERY_OP_AND);
                    }
                } else {//有一个0
                    if($hxTag->min>0) {
                        $i = $hxTag->min . '>';
                    } else {
                        $i = '<' . $hxTag->max;
                    }
                    $xs->addQueryString('bedroom:'.$i, XS_CMD_QUERY_OP_AND);
                }
            }

            //分词搜索：学校类型
            if( $xxlx = $this->urlConstructor->xxlx ) {
                $xs->addQueryString('school_type:'.$xxlx, XS_CMD_QUERY_OP_AND);
            }

            //基本条件
            $xs->addRange('status', 1, 1);
            $xs->addRange('deleted', 0, 0);
            $xs->addRange('is_new', 1, 1);

            //区域搜索
            $selectedStreet = $selectedArea = null;
            if($areaId = $this->urlConstructor->place){
                if($place = AreaExt::model()->findByPk($areaId)){
                    if($place->getIsFirstLevel()){
                        $selectedArea = $place;
                    }else{
                        $selectedArea = $place->getParentArea();
                        $selectedStreet = $place;
                        $xs->addRange('street', $selectedStreet->id, $selectedStreet->id);
                    }
                    $xs->addRange('area', $selectedArea->id, $selectedArea->id);
                }
            }
            //销售状态
            if($xszt = $this->urlConstructor->xszt){
                $xs->addRange('sale_status', $xszt, $xszt);
            }

            //价格
            if(isset($allTagsIndexByCate['xinfangjiage'][$this->urlConstructor->price])){
                $xs->addRange('unit' , 1, 1);
                $jg = $allTagsIndexByCate['xinfangjiage'][$this->urlConstructor->price];
                $jg->min = $jg->min > 0 ? (int)$jg->min : 1;
                $jg->max = $jg->max > 0 ? (int)$jg->max : null;
                $xs->addRange('price', $jg->min, $jg->max);
            }

            //开盘时间
            if($kpsj = $this->urlConstructor->kpsj){
                if(isset($kpsjOptions[$kpsj])){
                    $xs->addRange('open_time', $kpsjOptions[$kpsj]['start'], $kpsjOptions[$kpsj]['expire']);
                }
            }



            //排序
            if(isset($sortOptions[$this->urlConstructor->order])){
                $item = $sortOptions[$this->urlConstructor->order];
                if($item['field']=='price') {
                    $xs->addRange('unit', 1, 1);//价格排序时对价格单位限制
                    $xs->addRange('price_mark', 1, 1);//价格排序时对价格类型限制
                }
                $xs->setMultiSort(array($item['field']=>$item['value']));
            }elseif($lng>0 && $lat>0 && $this->urlConstructor->place<=0) {//7月5日和刚哥协商，默认进来按距离排序，所以走数据库，筛选叠加标签之后就不按距离排序了，走迅搜
                Yii::log('lat:'.$lat.',lng:'.$lng);
                $xs->setGeodistSort(['map_lng'=>$lng, 'map_lat'=>$lat]);
            }else{
                //默认排序
                $xs->setMultiSort(array('sort'=>false, 'open_time'=>false));
            }

            //增加排序条件需要放在Count统计完数量之后
            $count = 0;
            $xs->search();//count放在search之后才能应用排序条件
            $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量

            $pager = new CPagination($count);
            $xs->setLimit(10, 10*$pager->currentPage);
            $docs = $xs->search();


            $ids = array();
            if (!empty($docs)) {
                foreach ($docs as $k=>$v) {
                    $ids[] = $v->id;
                }
            }

            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $ids);
            if($ids && $idStr = implode(',', $ids)) {
                $criteria->order = 'field(id,'.$idStr.')';
            }
            $plots = PlotExt::model()->findAll($criteria);



            $lists = array();
            foreach($plots as $plot) {
                $tags = array();
                foreach($plot->xmts as $k=>$ts){
                    if($k<3) {
                        $tags[] = array(
                            'type' => $k+1,
                            'name' => $ts->name,
                        );
                    }
                }
                $distance = $plot->getDistance($lat, $lng, $plot->map_lat, $plot->map_lng);
                $lists[] = array(
                    'pic' => ImageTools::fixImage($plot->image,166,123),
                    'link' => $this->controller->createUrl('/wap/plot/index',['py'=>$plot->pinyin]),
                    'title' => $plot->title,
                    'address' => $plot->address,
                    'location' => $distance>1000000 ? '' : $distance.'米',
                    'description' => $plot->red ? $plot->red->title : ($plot->newDiscount ? $plot->newDiscount->title : ''),
                    'price' => $plot->price ? $plot->price.PlotPriceExt::$unit[$plot->unit] : '暂无',
                    'lat' => $plot->map_lat,
                    'lng' => $plot->map_lng,
                    'tags' => $tags,
                    'isActive' => $plot->red ? 1: 0,//是否有红包
                );
            }

            $data = array(
                'totalCount'=>$pager->itemCount,
                'totalPage'=>$pager->pageCount,
                'lists' => $lists
            );
            echo CJSON::encode($data);
            Yii::app()->end();
        }

        //所有区域
        $allArea = AreaExt::model()->frontendShow()->findAll(['index'=>'id']);
        $selectedArea = $selectedStreet = null;
        if(isset($allArea[$this->urlConstructor->place])) {
            $selectedStreet = $allArea[$this->urlConstructor->place];
            isset($allArea[$selectedStreet->parent]) && $selectedArea = $allArea[$selectedStreet->parent];
        }

        //学校数据
        $xxCriteria = new CDbCriteria(['index'=>'id']);
        if($selectedArea) {
            $xxCriteria->addCondition('area=:area');
            $xxCriteria->params[':area'] = $selectedArea->id;
        }
        $xuexiao = SchoolExt::model()->normal()->findAll($xxCriteria);
        $selectedSchool = isset($xuexiao[$this->urlConstructor->xuexiao]) ? $xuexiao[$this->urlConstructor->xuexiao] : null;

        //ajax请求地址
        $ajaxUrl = $this->controller->createUrl('/wap/plot/list', array_merge($_GET, ['ajax'=>1]));

        $this->controller->render('list', array(
            'allTagsIndexByCate' => $allTagsIndexByCate,
            'allArea' => $allArea,
            'selectedArea' => $selectedArea,
            'selectedStreet' => $selectedStreet,
            'selectedSchool' => $selectedSchool,
            'xuexiao' => $xuexiao,
            'bedrooms' => $bedrooms,
            'kpsjOptions' => $kpsjOptions,
            'sortOptions' => $sortOptions,
            'priceTag' => $priceTag,
            'ajaxUrl' => $ajaxUrl,
        ));
    }
}
