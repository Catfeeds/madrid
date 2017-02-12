<?php
/**
 * 替换资讯楼盘名称的api
 */
class PlotController extends ApiController
{

    /**
     * 地图找房ajax请求
     * 缩放到一定层级时统计几个行政区的相关楼盘数量
     */
    public function actionAjaxMapAreaInfo($wuye='',$price='',$tese='')
    {
        $data = array();
        $xs = Yii::app()->search->house_plot;
        $xs->setQuery('');
        if($price)
        {
            $priceTag = PlotPricetagExt::getPriceTag();
            foreach($priceTag as $k=>$v)
            {
                if($v->id == $price)
                {
                    $xs->addRange('price',intval($v->min>0?$v->min:0),intval($v->max>0?$v->max:0));
                }
            }
        }
        if($wuye)
            $xs->addQueryString('wylx:'.intval($wuye), XS_CMD_QUERY_OP_AND);
        if($tese)
            $xs->addQueryString('xmts:'.intval($tese), XS_CMD_QUERY_OP_AND);
        $xs->addRange('status',1,1);
        $xs->addRange('is_new',1,1);
        $xs->setFacets('area', true)->search();
        $nums = $xs->getFacets('area');
        $areas = AreaExt::model()->normal()->findAll(array('index'=>'id'));
        foreach($nums as $k=>$v)
        {
            if(!isset($areas[$k])) continue;
            $data[] = array('name'=>$areas[$k]->name, 'lng'=>$areas[$k]->map_lng, 'lat'=>$areas[$k]->map_lat, 'num'=>$v,'id'=>$areas[$k]->id);
        }
        echo CJSON::encode($data);
    }

    /**
     * 地图找房ajax请求
     * 根据筛选条件获得指定经纬度内的楼盘信息
     * @param  float $lng   地图中心点经度
     * @param  float $lat   地图中心点纬度
     * @param  integer $distance 西南-东北对角线的长度距离
     * @param  string $wuye  物业类型标签id
     * @param  string $jiage 价格标签id
     * @param  string $tese 项目特色标签id
     * @param  string $area 区域id
     */
    public function actionAjaxMapPlotInfo($lng, $lat, $distance, $wuye='',$price='',$tese='',$area='')
    {
        $mapArea = $this->getNearDistance( $lat, $lng, $distance / 2 );

        $criteria = new CDbCriteria(array(
            'limit' => 80
        ));
        $xs = Yii::app()->search->house_plot;
        $xs->setQuery('');
        if($price)
        {
            $priceTag = TagExt::model()->getTagByCate('xinfangjiage')->normal()->findAll();
            foreach($priceTag as $k=>$v)
            {
                if($v->id == $price)
                {
                    $v->min = intval($v->min>0 ? $v->min : 1);
                    $xs->addRange('unit' , 1, 1);
                    $xs->addRange('price',
                        intval($v->min),
                        intval($v->max>0?$v->max:0)
                    );
                    if($v->min)
                    {
                        $criteria->addCondition('price>=:min');
                        $criteria->params[':min'] = $v->min;
                    }
                    if($v->max)
                    {
                        $criteria->addCondition('price<=:max');
                        $criteria->params[':max'] = $v->max;
                    }
                }
            }
        }
        if($wuye||$tese||$area)
        {
            //旧版迅搜的bug，无法将小数位多的数字导入，会失去经度，只能在数据库端做限制了
            $xs->addRange('map_lat', floatval($mapArea['lat2']), floatval($mapArea['lat1']));
            $xs->addRange('map_lng', floatval($mapArea['lng2']), floatval($mapArea['lng1']));
            if($wuye)
                $xs->addQueryString('wylx:'.intval($wuye), XS_CMD_QUERY_OP_AND);
            if($tese)
                $xs->addQueryString('xmts:'.intval($tese), XS_CMD_QUERY_OP_AND);
            if($area)
                $xs->addQueryString('area:'.intval($area), XS_CMD_QUERY_OP_AND);
            $xs->addRange('status',1,1);
            $xs->addRange('is_new',1,1);
            $xs->setLimit(80);
            $result = $xs->search();
            // var_dump($result);die;
            $ids = array();
            foreach($result as $v)
            {
                $ids[] = $v->id;
            }
            $criteria->addInCondition('id', $ids);
        }

        $criteria->addBetweenCondition('map_lat', $mapArea['lat2'], $mapArea['lat1']);
        $criteria->addBetweenCondition('map_lng', $mapArea['lng2'], $mapArea['lng1']);

        $model = PlotExt::model()->normal()->isNew();
        $plots = $model->findAll($criteria);
        $data = array();
        foreach($plots as $v)
        {
            $data[] = array(
                'name' => $v->title,
                'sale_status' => $v->xszt ? $v->xszt->name : '',
                'url' => $this->createUrl('/home/plot/index', ['py'=>$v->pinyin]),
                'image' => ImageTools::fixImage($v->image),
                'price' => $v->price,
                'unit' => PlotPriceExt::$unit[$v->unit],
                'open_time' => $v->open_time ? date('Y-m-d',$v->open_time) : '暂无',
                'address' => $v->address,
                'phone' => $v->sale_tel,
                'lng' => $v->map_lng,
                'lat' => $v->map_lat,
                'link' => array(
                    '[楼盘信息]'=>$this->createUrl('/home/plot/index',['py'=>$v->pinyin]),
                    '[户型图]'=>$this->createUrl('/home/plot/huxing', ['py'=>$v->pinyin]),
                    '[相册]'=>$this->createUrl('/home/plot/album', ['py'=>$v->pinyin]),
                    '[楼盘资讯]'=>$this->createUrl('/home/plot/news',['py'=>$v->pinyin]),
                    '[问答]'=>$this->createUrl('/home/plot/faq',['py'=>$v->pinyin]),
                )
            );
        }
        echo CJSON::encode($data);
    }

    /**
     * autocomplete查找楼盘
     * @param  string $kw 查找关键字
     */
    public function actionAjaxGetPlot($kw)
    {
        $criteria = new CDbCriteria(array(
            'limit' => 15
        ));
        $xs = Yii::app()->search->house_plot;
        $xs->setScwsMulti(15);
        $xs->setQuery($kw);
        //
        //基本条件
        $xs->addRange('status', 1, 1);
        $xs->addRange('deleted', 0, 0);
        $xs->addRange('is_new', 1, 1);

        $xs->setLimit(15);
        $docs = $xs->search();

        $ids = [];
        foreach($docs as $v) {
            $ids[] = $v['id'];
        }

        $criteria->addInCondition('id', $ids);
        $plots = PlotExt::model()->normal()->isNew()->findAll($criteria);
        $data = array();
        foreach($plots as $v)
        {
            $data[] = array(
                'name' => $v->title,
                'recordname'=>$v->data_conf['recordname'],
                'sale_status' => $v->xszt ? $v->xszt->name : '',
                'url' => $this->createUrl('/home/plot/index', ['py'=>$v->pinyin]),
                'image' => ImageTools::fixImage($v->image),
                'price' => $v->price,
                'area' => $v->areaInfo?$v->areaInfo->name:'未知',
                'unit' => PlotPriceExt::$unit[$v->unit],
                'open_time' => $v->open_time ? date('Y-m-d') : '暂无',
                'address' => $v->address,
                'phone' => $v->sale_tel,
                'lng' => $v->map_lng,
                'lat' => $v->map_lat,
                'link' => array(
                    '[楼盘信息]'=>$this->createUrl('/home/plot/index',['py'=>$v->pinyin]),
                    '[户型图]'=>$this->createUrl('/home/plot/huxing', ['py'=>$v->pinyin]),
                    '[相册]'=>$this->createUrl('/home/plot/album', ['py'=>$v->pinyin]),
                    '[楼盘资讯]'=>$this->createUrl('/home/plot/news',['py'=>$v->pinyin]),
                    '[问答]'=>$this->createUrl('/home/plot/faq',['py'=>$v->pinyin]),
                )
            );
        }
        echo CJSON::encode($data);
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

    public function actionTest($page=1)
    {
        echo '[{"id":303475,"title":"\u5c6f\u6eaa\u533a\u575e\u5c71\u5df7\u7535\u4fe1\u5927\u697c\u65c1 3\u5ba41\u53851\u536b 80\u33a1","phone":"18655902772","username":"\u7a0b\u5148\u751f","uid":2357314,"account":"anistoncc","price":1200,"size":80,"category":1,"hid":"219","plot_name":"\u672a\u77e5\u5c0f\u533a","floor":"5","total_floor":"2","created":"1452646397","source":1,"sale_time":"1452646397","area":1,"street":"","updated":"1452646397","expire_time":"1455238397","refresh_time":"1452646397","bedroom":"3","livingroom":"1","bathroom":"1","content":"1\u3001\u95f9\u4e2d\u53d6\u9759\uff1a\u4f4d\u4e8e\u5c6f\u6eaa\u533a\u7edd\u5bf9\u5e02\u4e2d\u5fc3\uff0c\u4f46\u623f\u5c4b\u6240\u5904\u4f4d\u7f6e\u5b89\u9759\u4e0d\u5435\u95f9\uff0c\u65e0\u566a\u97f3\uff0c\u9002\u5b9c\u5c45","status":"1","sale_status":1,"data_conf":{"tags":[179,177,182,180,178,181]},"hits":"6","ip":"","image":"","image_count":0,"decoration":114,"towards":0,"wuye_fee":"0","top":"0","appoint_time":"0","address":"\u79fb\u52a8\u624b\u673a\u5927\u4e16\u754c\u5bf9\u9762\uff0c\u7535\u4fe1\u5927\u697c\u9694\u58c1\u5df7\u5b50\u5185","age":"0","sort":"0","contacted":"0","hurry":"0","sid":"0","year":"","month":"","day":"","recommend":"0","images":[],"pay_type":{"jiao":"0","ya":"0"},"rent_type":186}]';
        exit;
    }
}
