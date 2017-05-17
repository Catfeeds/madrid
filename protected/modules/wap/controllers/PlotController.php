<?php
/**
 * 找楼盘
 */
class PlotController extends WapController{

    public  $plot,$addViews,$tag;
    public  $ext_ary=array();
    public $urlConstructor;

    public function init(){
        parent::init();
        $this->tag = CHtml::listData($this->siteTag,'id','name');
        $this->urlConstructor = new UrlConstructor;
    }

    public function filters()
    {
        return array('getPlot - list');
    }

    public function filterGetPlot($chain)
    {
        $py = Yii::app()->request->getQuery('py',0);

        if(!empty($py))
        {
            $this->plot = PlotExt::model()->normal()->isNew()->find(array(
                'condition' => 'pinyin = :pinyin',
                'params' => array(':pinyin' => $py),
            ));
            if(empty($this->plot))
                $this->redirect(array('plot/list'));
            $this->plot->AddViews();//楼盘浏览量计数
        }
        //print_r($this->plot);
        $chain->run();
    }

    public function actions()
    {
        $alias = 'wap.controllers.plot.';
        return array(
            'list' => $alias.'ListAction',//楼盘列表页
            'search' => $alias.'SearchAction',//楼盘搜索
            'huxingList' => $alias.'housetype.ListAction',//楼盘户型列表页
            'huxingDetail' => $alias.'housetype.DetailAction',//楼盘户型详细页
            'index' => $alias.'IndexAction',//楼盘主页
            'detail' => $alias.'DetailAction',//楼盘详情
            'comment' => $alias.'CommentAction',//房大白点评
            'album' => $alias.'AlbumAction',//楼盘图册浏览页
            'evaluate' => $alias.'EvaluateAction',//楼盘评测页
            'building' => $alias.'BuildingAction',//楼栋信息页
            'around' => $alias.'AroundAction',//周边配套
            'change' => $alias.'ChangeAction',//换一换接口
            'video' => $alias.'VideoAction',//视频播放
        );
    }


    public function actionMap(){
        $this->render('plot_map');
    }

    public function actionPrice(){
        $list = PlotPriceExt::model()->findAll(array('condition' => 'hid=:hid', 'params'=>array(':hid'=>$this->plot->id),'order'=>'created desc'));
        $jglb = CHtml::listData(TagExt::model()->getTagByCate('jglb')->normal()->findAll(), 'id', 'name');
        $priceTrend = new PriceTrendChart($this->plot);

        $this->render('plot_price', array(
            'list' => $list,
            'jglb' => $jglb,
            'priceTrend' => $priceTrend,
            )
        );
    }

    /**
     * 楼盘动态加载更多API
     */
    public function actionAddPrice($hid){
        $criteria = new CDbCriteria;
        $criteria->addCondition('hid = :hid');
        $criteria->params[':hid'] = $hid;
        $criteria->order = 'created DESC';
        $count = PlotPriceExt::model()->count($criteria);

        $pager = new CPagination($count);
        $pager -> pageSize = 3;
        $pager -> applyLimit($criteria);

        $data = PlotPriceExt::model()->findAll($criteria);

        if(Yii::app()->request->getQuery($pager->pageVar,0)>$pager->pageCount)
            $data = array();
        $this->renderPartial('addprice',array(
            'list'=>$data,
        ));
    }

    /******************华丽的分割线************************/

    //为模板组成搜索链接
    public function get_url($param , $value = '') {
    //var_dump($param);die;
        $query = '';
        foreach($this->ext_ary as $k=>$v){
            if($k === $param){
                $query .= $query ? '_'.$k.$value : $k.$value;
            }else{
                if($v){
                    $query .= $query ? '_'.$k.$v : $k.$v;
                }
            }
        }
        echo $this->createUrl('/wap/plot/list',array('query'=>$query));
    }

    public function get_id($id){
            $tag = TagRelExt::model()->findAll(array('condition'=>'tag_id = :tag_id','params'=>array(':tag_id'=>$id)));
            $hids = array();
            foreach($tag as $k=>$v){
                $hids[$k]=$v['hid'];
            }
            return $hids;
    }

    /**
     * ajax随机获取特价房
     */
    public function actionAjaxGetSpecial()
    {
        $id = Yii::app()->request->getQuery('id',0);
        $PlotSpecial = PlotSpecialExt::model()->with('plot')->findAll(array('condition'=>'plot.id=:hid','params'=>array(':hid'=>$id),'limit'=>3,'order'=>'rand()'));
        $formed = array();
        $ave_price = PlotPriceExt::model()->find(array('condition'=>'hid=:hid'.' and mark=1','params'=>array(':hid'=>$PlotSpecial[0]->plot->id),'order'=>'created desc'));
        foreach ($PlotSpecial as $key => $value) {
            $tmp = array(
                'link' => $this->createUrl('tjflist',array('id'=>$value['id'])),//bug,waiting for change
                'title' => $value['title'],
                'pic' => ImageTools::fixImage($value['image']),
                'sale' => '劲省'.round(($value->price_old) - ($value->price_new),2).'万',
                'detail' => $value['room'].'&nbsp;'.$value['bed_room'].'&nbsp;'.$value['size'],
                'price' => $ave_price['price'].PlotPriceExt::$unit[1],
                'tprice' => $value['price_new'],
                'yprice' => $value['price_old'],
                );
            $formed[] = $tmp;
        }
        echo CJSON::encode(array('lists'=>$formed));
    }

    /**
     * v2版wap页面获取沙盘图数据
     */
    public function actionAjaxGetBuilding($id)
    {
        $id = (int)$id;
        $period = PlotPeriodExt::model()->findByPk($id);
        $buildings = $period->buildings;
        $formed = array();
        $first = isset($buildings[0]) ? $buildings[0] : null;
        $formed['title'] = $first ?$first->name.'  共'.$first->unit_total.'个单元 '.$first->household_total.'户 '.$first->floor_total.'层 '.$first->liftNum.'梯'.$first->houseNum.'户' : '';
        $formed['href'] = $this->createUrl('/wap/plot/building',['py'=>$period->plot->pinyin,'pid'=>$id]);
        $formed['picture'] = ImageTools::fixImage($period['image']);
        $imgInfo = Yii::app()->file->getInfo($period->image);
        $formed['width'] = $period->getImageWidth();
        $formed['height'] = $period->getImageHeight();
        foreach ($buildings as $key => $value) {
            $tmp = array(
                'url' => $this->createUrl('/wap/plot/building',['py'=>$value->plot->pinyin,'pid'=>$id]),
                'link' => $this->createUrl('/wap/plot/huxingList',['br'=>0,'bid'=>$value->id,'py'=>$value->plot->pinyin]),
                'title' => $value['name'],
                'status' => PlotBuildingExt::getStatus($value->status),
                'left' => $value->point_x,
                'top' => $value->point_y,
                'kaipan' => $value->open_time?date('Y-m-d',$value->open_time):'-',
                'jiaofang' => $value->delivery_time?date('Y-m-d',$value->delivery_time):'-',
                'danyuan' => $value['unit_total'].'单元',
                'hushu' => $value['household_total'].'户',
                'cengshu' => $value['floor_total'].'层',
                'fangyuan' => $value['sale_total'].'套',
                );
            $formed['lists'][] = $tmp;
        }
        echo CJSON::encode($formed);
    }

    /**
     * ajax获取wap地图一级信息
     */
    public function actionAjaxMap()
    {
        $data = array();
        $kw = Yii::app()->request->getQuery('kw','');

        $xs = Yii::app()->search->house_plot;
        $xs->setQuery($kw);
        $xs->addRange('status',1,1);
        $xs->addRange('is_new',1,1);
        $xs->setFacets('area', true)->search();
        $nums = $xs->getFacets('area');
        $areas = AreaExt::model()->normal()->findAll(array('index'=>'id'));
        $data['total'] = array_sum($nums);
        $tmp = array();
        $data['lists'] = array();
        foreach($nums as $k=>$v)
        {
            if(!isset($areas[$k])) continue;
            $tmp = array('name'=>$areas[$k]->name, 'lng'=>$areas[$k]->map_lng, 'lat'=>$areas[$k]->map_lat, 'num'=>$v);
            $data['lists'][] = $tmp;
        }
        echo CJSON::encode($data);
    }

    /**
     * ajax获取wap地图二级信息
     */
    public function actionAjaxMapChild()
    {
        $tmp = array();
        $kw = Yii::app()->request->getQuery('kw','');
        $lng = Yii::app()->request->getQuery('lng','');
        $lat = Yii::app()->request->getQuery('lat','');
        $distance = Yii::app()->request->getQuery('distance','');
        $mapArea = $this->getNearDistance( $lat, $lng, $distance / 2 );

        $criteria = new CDbCriteria(array(
            'limit' => 30
        ));
        $criteria->addBetweenCondition('map_lat', $mapArea['lat2'], $mapArea['lat1']);
        $criteria->addBetweenCondition('map_lng', $mapArea['lng2'], $mapArea['lng1']);
        if($kw)
            $criteria->addSearchCondition('title',$kw);
        $model = PlotExt::model()->normal()->isNew();
        $plots = $model->findAll($criteria);
        $data = array();
        foreach($plots as $v)
        {
            $data = array(
                'link' => $this->createUrl('index',['py'=>$v->pinyin]),
                'name' => $v->title,
                'lng' => $v->map_lng,
                'lat' => $v->map_lat,
            );
            $tmp['areas'][] = $data;
        }
        echo CJSON::encode($tmp);
    }

     /**
     * 根据地图某点获取附近的范围
     * @param string $lat
     * @param string $lng
     * @param number $distance
     * @return multitype:string
     */
    private function getNearDistance($lat = '', $lng = '' , $distance = 0) {
        $earth_radius = 6378137;

        //$distance = $distance / 10;
        $dlng = 2 * asin(sin($distance / (2 * $earth_radius)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
        $dlat = $distance/$earth_radius;
        $dlat = rad2deg($dlat);

        return array(
            'lat1'=>sprintf('%.7f', ($lat+$dlat)),
            'lat2'=>sprintf('%.7f', ($lat-$dlat)),
            'lng1'=>sprintf('%.7f', ($lng+$dlng)),
            'lng2'=>sprintf('%.7f', ($lng-$dlng)),
        );
    }

    /**
     * [actionAjaxJiaGe 获得价格趋势数据]
     */
    public function actionAjaxJiaGe()
    {
        $hid = Yii::app()->request->getQuery('hid',0);
        $plot = PlotExt::model()->normal()->findByPk($hid);
        $priceTrend = new PriceTrendChart($plot);
        $cat = array();
        foreach ($priceTrend->date as $key => $value) {
            $cat[] = $key.'月';
        }
        $lpj = array();//楼盘价格
        foreach ($priceTrend->plotPriceList as $key => $value) {
            $lpj[] = round($value/1000,2);
        }
        $qyj = array();//区域价格
        foreach ($priceTrend->areaPriceList as $key => $value) {
            $qyj[] = round($value/1000,2);
        }
        $ctj = array();//全市价格
        foreach ($priceTrend->cityPriceList as $key => $value) {
            $ctj[] = round($value/1000,2);
        }

        $data = [];
        $tmp['title'] = '楼盘价';
        $tmp['data'] = $lpj;
        $data[] = $tmp;
        unset($tmp);
        $tmp['title'] = $plot->areaInfo->name.'新房价';
        $tmp['data'] = $qyj;
        $data[] = $tmp;
        unset($tmp);
        $tmp['title'] = SM::urmConfig()->cityName().'楼盘价';
        $tmp['data'] = $ctj;
        $data[] = $tmp;

        $plotTrend = $priceTrend->plotPriceMark;//本月与上月价格比较
        $datas = array(
            'text' => $plotTrend[2],
            'price' => $plot->price,
            'categories' => $cat,
            'datas' => $data,
            );
        echo CJSON::encode($datas);
    }

    /**
     * [actionAjaxAround 配套信息]
     */
    public function actionAjaxAround()
    {
        $hid = Yii::app()->request->getQuery('hid');
        $plot = PlotExt::model()->normal()->findByPk($hid);
        $data = array(
            'name'=>$plot->title,
            'lng'=>$plot->map_lng,
            'lat'=>$plot->map_lat
            );
        echo CJSON::encode($data);
    }
}
