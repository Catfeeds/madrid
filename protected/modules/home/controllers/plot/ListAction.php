<?php
/**
 * 楼盘列表页
 * @author weibaqiu
 * @version 2016-06-21
 */
class ListAction extends CAction
{
    public $urlConstructor;

    public function run($place=0, $kw='')
    {
        $this->urlConstructor = $this->controller->urlConstructor;
        $allTags = TagExt::model()->normal()->findAll(['order'=>'sort asc']);
        foreach($allTags as $tag){
            $allTagsIndexByCate[$tag->cate][$tag->id] = $tag;
        }

        $sizeMin =$this->controller->cleanXss(Yii::app()->request->getParam('sizemin',0));
        $sizeMax =$this->controller->cleanXss( Yii::app()->request->getParam('sizemax',0));
        $priceMin =$this->controller->cleanXss(Yii::app()->request->getParam('pricemin',0));
        $priceMax =$this->controller->cleanXss(Yii::app()->request->getParam('pricemax',0));

        if($sizeMin>0&&$sizeMax>0&&$sizeMin>$sizeMax){
            $temp=$sizeMin;
            $sizeMin=$sizeMax;
            $sizeMax=$temp;
        }
        if($priceMin>0&&$priceMax>0&&$priceMin>$priceMax){
            $temp = $priceMin;
            $priceMin=$priceMax;
            $priceMax=$temp;
        }

        /******************迅搜条件********************/
        $xs = Yii::app()->search->house_plot;
        $xs->setScwsMulti(15);//分词复合等级，最大化支持单字搜索
        $xs->setQuery($kw);
        $xs->setFacets(array('status'), true);//分面统计

        //分词搜索，类型、特色
        foreach(['wylx','xmts','zxzt','ditie','jzlb'] as $k){
            if(isset($this->urlConstructor->extMap[$k])){
                $q = $k.':'.$this->urlConstructor->extMap[$k];
                $xs->addQueryString($q, XS_CMD_QUERY_OP_AND);
            }
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

        //分词搜索，户型筛选
        if( isset($allTagsIndexByCate['xinfanghuxing'][$this->urlConstructor->huxing]) ) {
            $hxTag = $allTagsIndexByCate['xinfanghuxing'][$this->urlConstructor->huxing];
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

        //面积筛选
        if( isset($allTagsIndexByCate['xinfangmianji'][$this->urlConstructor->mianji])||$sizeMin||$sizeMax){
            if(isset($allTagsIndexByCate['xinfangmianji'][$this->urlConstructor->mianji])){
                $sizeTag = $allTagsIndexByCate['xinfangmianji'][$this->urlConstructor->mianji];
                $mianji=array('min'=>$sizeTag->min,'max'=>$sizeTag->max);
            }
            else{
                $mianji=array('min'=>$sizeMin,'max'=>$sizeMax);
            }
            if($mianji['max']>0){
                $xs->addRange('size_min',0,$mianji['max']);
                $xs->addRange('size_max',$mianji['min'],null);
            }
            else{
                $xs->addRange('size_max',$mianji['min'],null);
            }
        }

        //销售状态
        if($xszt = $this->urlConstructor->xszt){
            $xs->addRange('sale_status', $xszt, $xszt);
        }

        //价格
        if(isset($allTagsIndexByCate['xinfangjiage'][$this->urlConstructor->price])||$priceMin||$priceMax){
            $xs->addRange('unit' , 1, 1);
            if(isset($allTagsIndexByCate['xinfangjiage'][$this->urlConstructor->price])){
                $jg = $allTagsIndexByCate['xinfangjiage'][$this->urlConstructor->price];
                $price=array('min'=>$jg->min,'max'=>$jg->max);
            }
            else
                $price=array('min'=>$priceMin,'max'=>$priceMax);
            $price['min'] =$price['min']>0?(int)$price['min']:1;
            $price['max'] =$price['max']>0?(int)$price['max']:null;
            $xs->addRange('price', $price['min'], $price['max']);
        }

        //开盘时间
        $kpsjOptions = array(
            'by' =>array('name'=>'本月开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+1, 1, date('Y'))),
            'xy' =>array('name'=>'下月开盘','start'=>mktime(0, 0, 0, date('m')+1, 1, date('Y')),'expire'=>null),
            'syn' =>array('name'=>'三月内开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+2, 17, date('Y'))),
            'lyn' =>array('name'=>'六月内开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+5, 17, date('Y'))),
            'qsy' =>array('name'=>'前三月已开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')-3, 17, date('Y'))),
            'qly' =>array('name'=>'前六月已开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')-6, 17, date('Y'))),
        );
        if($kpsj = $this->urlConstructor->kpsj){
            if(isset($kpsjOptions[$kpsj])){
                $xs->addRange('open_time', $kpsjOptions[$kpsj]['start'], $kpsjOptions[$kpsj]['expire']);
            }
        }

        //是否团购活动
        if($this->urlConstructor->tuan){
            $xs->addRange('tuan', 1, 1);
        }

        $criteria = new CDbCriteria(array(
            'order' => 'sort desc,open_time desc',
        ));

        //排序
        $sortItems = new SortItems(array(
            '售价'=>array('price', '1', '2'),
            '开盘时间'=>array('open_time', '3', '4')
        ), $this->urlConstructor);
        if($this->urlConstructor->order){
            if($sortItems->item=='price') {
                $xs->addRange('unit', 1, 1);//价格排序时对价格单位限制
                $xs->addRange('price_mark', 1, 1);//价格排序时对价格类型限制
                $criteria->order = 'price '.($sortItems->desc?'desc':'asc');
            }
            $xs->setMultiSort(array($sortItems->item=>!$sortItems->desc));
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


        $criteria->addInCondition('id', $ids);
        $plots = PlotExt::model()->findAll($criteria);
        //查户型
        $criteria = new CDbCriteria([
            'select' => 'hid,bedroom,count(id) as count',
            'condition' => 'bedroom>0',
            'group' => 'hid,bedroom',
        ]);
        $criteria->addInCondition('hid', $ids);
        $houseTypes =  PlotHouseTypeExt::model()->enabled()->findAll($criteria);
        $huxings = [];
        foreach($houseTypes as $v) {
            $huxings[$v->hid][] = $v;
        }


        $allArea = AreaExt::model()->frontendShow()->findAll(['index'=>'id']);
        //最新开盘
        $newPlot = PlotExt::model()->normal()->isNew()->findAll(array(
            'order' => 'open_time desc',
            'limit' => 8
        ));

        $this->controller->render('list', array(
                'tag' => $tag,
                'allTagsIndexByCate' => $allTagsIndexByCate,
                'plots' => $plots,
                'huxings' => $huxings,
                'pager' => $pager,
                'newPlot' => $newPlot,
                'kpsjOptions' => $kpsjOptions,
                'sortItems' => $sortItems,
                'selectedArea' => $selectedArea,
                'selectedStreet' => $selectedStreet,
                'allArea' => $allArea,
                'sizeMax' =>$sizeMax?$sizeMax:'',
                'sizeMin' =>$sizeMin?$sizeMin:'',
                'priceMax'=>$priceMax?$priceMax:'',
                'priceMin'=>$priceMin?$priceMin:'',
            )
        );
    }
}
