<?php
 /**
 * 小区列表
 * @author liyu
 * @created 2016年10月30日15:13:01
 */
class ListAction extends CAction{
    public $plot;
    public $kw;
    public function run(){
        /**
         * @param area 区域
         * @param pricetag 价格区间
         * @param miniprice 最小价
         * @param maxprice 最大
         *
         */
        $this->plot = $this->controller->plot;
        $area = Yii::app()->request->getQuery('area',0);
        $street = Yii::app()->request->getQuery('street',0);
        $pricetag = Yii::app()->request->getQuery('price',0);
        $miniprice = Yii::app()->request->getQuery('minprice',0);
        $maxprice = Yii::app()->request->getQuery('maxprice',0);
        $kw = Yii::app()->request->getQuery('kw','');
        $page = Yii::app()->request->getQuery('page',1);
        $limit = Yii::app()->request->getQuery('limit',10);
        $pricetags = TagExt::getAllByCate('xinfangjiage');
        $sort = Yii::app()->request->getQuery('sort',0);
        $ageTag = Yii::app()->request->getQuery('age',0);
        /******************* 排序 *********************/
        $defaultSort = ['resold_sort'=>false,'open_time'=>false,'updated'=>false];
        // 查询关键词先走plot再走school
        /******************迅搜条件********************/
        $xs = Yii::app()->search->house_plot;
        //$xs->setScwsMulti(15);//分词复合等级，最大化支持单字搜索
        $xs->setQuery($kw);
        $xs->setFacets(array('status'), true);//分面统计

        //基本条件
        $xs->addRange('status', 1, 1);
        $xs->addRange('deleted', 0, 0);
        $area and $xs->addRange('area',$area,$area);
        $street and $xs->addRange('street',$street,$street);

        //价格区间
        if($pricetag){
            $priceTag = TagExt::model()->findByPk($pricetag);
            $xs->addRange('esf_price',$priceTag->min,$priceTag->max?$priceTag->max:null);
        }
        //建筑年代
        if($ageTag){
            $age = TagExt::model()->findByPk($ageTag);
            $xs->addRange('age',$age->min,$age->max);
        }
        //默认排序
        $moreSort = [7=>['esf_price'=>false],8=>['esf_price'=>true],9=>['esf_num'=>false],10=>['esf_num'=>true],11=>['esf_rate'=>false],12=>['esf_rate'=>true]];

        $miniprice and $xs->addRange('esf_price',$miniprice,null);
        $maxprice and $xs->addRange('esf_price',null,$maxprice);
        $count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量
        $sortstr = '';
        if(isset($moreSort[$sort])){
            $xs->setMultiSort(array_merge($moreSort[$sort],$defaultSort));
        }else{
            $xs->setMultiSort($defaultSort);
        }
        $pager = new CPagination($count);
        $pager->pageSize = $limit;
        $xs->setLimit($limit,$limit*$pager->currentPage);
        $docs = $xs->search();
        $plots = [];

        if($docs){
            foreach ($docs as $key => $value) {
                $plots[] = PlotExt::model()->with('avg_esf')->findByPk($value->id);
	        }
        }
        // //排序
        // $criteria = new CDbCriteria(array(
        //     'order' => $sortstr.',sort desc,open_time desc',
        // ));
        // $criteria->addInCondition('id',$ids);
        // $plots = PlotExt::model()->findAll($criteria);
        //楼盘最新住宅数据
        $this->kw = $kw;
        $this->controller->render('list',array(
            'plots'=>$plots,
            'pager'=>$pager,
            'count'=>$count,
            'page'=>$page,
            'get'=>['area'=>$area,'kw'=>$kw,'street'=>$street,'price'=>$pricetag,'minprice'=>$miniprice,'maxprice'=>$maxprice,'sort'=>$sort]
        ));


    }
}
