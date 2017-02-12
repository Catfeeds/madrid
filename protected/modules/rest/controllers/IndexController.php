<?php
/**
 * @Author: weibaqiu
 * @Date:   2015-08-28
 */
class IndexController extends RestController
{

    /**
     * 推荐位内容
     * @param  string  $cate  推荐位标识
     * @param  integer $count 单页返回数量
     * @param  integer $page  页码
     */
    public function actionTag($cate='')
    {
        $keys = array_keys(TagExt::$xinfangCate['direct']);
        if($cate && !isset(TagExt::$xinfangCate['direct'][$cate]))
        {
            throw new CHttpException(401, '参数值不存在，可选值有'.implode('、',$keys));
        }
        $criteria = new CDbCriteria(array(
            'select' => 'id,name,cate',
        ));
        $criteria->addInCondition('cate', $keys);
        if($cate)
        {
            $criteria->addCondition('cate=:cate');
            $criteria->params[':cate'] = $cate;
        }
        $count = TagExt::model()->normal()->count($criteria);
        $result = TagExt::model()->normal()->findAll($criteria);
        $data = array();
        foreach($result as $k=>$v)
        {
            $data[$v->cate][] = array(
                'id' => $v->id,
                'name' => $v->name,
                'cate' => $v->cate,
                'cateName' => TagExt::$xinfangCate['direct'][$v->cate],
            );
        }

        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 推荐位内容
     * @param  string  $cate  推荐位标识
     * @param  integer $count 单页返回数量
     * @param  integer $page  页码
     */
    public function actionRecom($cate, $count=10, $page=0)
    {
        $pageSize = $count;
        $criteria = new CDbCriteria(array(
            'offset' => $count*$page,
            'select' => 'id,title,s_title,description,image,url,created'
        ));
        $count = RecomExt::model()->getRecom($cate,$pageSize)->count($criteria);
        $recoms = RecomExt::model()->getRecom($cate,$pageSize)->findAll($criteria);
        $data = array();
        foreach($recoms as $k=>$recom)
        {
            $data[$k] = $this->_filterAttribute($recom);
            $data[$k]['image'] = ImageTools::fixImage($recom->image);
        }

        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 推荐位内容
     * @param  string  $cate  推荐位标识
     * @param  integer $count 单页返回数量
     * @param  integer $page  页码
     */
    public function actionPlot($count=10, $page=0)
    {
        $criteria = new CDbCriteria(array(
            'offset' => $count*$page,
            'limit' => $count,
            'order' => 'sort desc,open_time desc,id desc'
        ));

        $total = PlotExt::model()->isNew()->normal()->count($criteria);
        $plots = PlotExt::model()->isNew()->normal()->findAll($criteria);
        $data = array();
        foreach($plots as $k=>$plot){
            $data_conf = $plot->data_conf;
            $row = array(
                'id' => $plot->id,
                'title' => $plot->title,
                'pinyin' => $plot->pinyin,
                'url' => $this->createAbsoluteUrl('/home/plot/index',['py'=>$plot->pinyin]),
                'fcode' => $plot->fcode,
                'xszt' => $plot->xszt ? $plot->xszt->name : '',
                'tag_id' => $plot->tag_id,
                'area_id' => $plot->area,
                'area_name' => $plot->areaInfo ? $plot->areaInfo->name : '',
                'street_id' => $plot->street,
                'street_name' => $plot->streetInfo ? $plot->streetInfo->name : '',
                'open_time' => $plot->open_time,
                'delivery_time' => $plot->delivery_time,
                'address' => $plot->address,
                'sale_addr' => $plot->sale_addr,
                'sale_tel' => $plot->sale_tel,
                'map_lng' => $plot->map_lng,
                'map_lat' => $plot->map_lat,
                'image' => ImageTools::fixImage($plot->image),
                'price' => $plot->price,
                'unit' => isset(PlotPriceExt::$unit[$plot->unit]) ? PlotPriceExt::$unit[$plot->unit] : PlotPriceExt::$unit[1],
                'price_mark' => isset(PlotPriceExt::$mark[$plot->price_mark]) ? PlotPriceExt::$mark[$plot->price_mark] : PlotPriceExt::$mark[1],
                'views' => $plot->views,
                'buildsize' => $data_conf['buildsize'],
                'size' => $data_conf['size'],
                'capacity' => $data_conf['capacity'],
                'green' => $data_conf['green'],
                'manage_fee' => $data_conf['manage_fee'],
                'manage_company' => $data_conf['manage_company'],
                'developer' => $data_conf['developer'],
                'agent' => $data_conf['agent'],
                'license' => $data_conf['license'],
                'transit' => $data_conf['transit'],
                'content' => $data_conf['content'],
                'peripheral' => $data_conf['peripheral'],
            );
            $data[$k] = $row;
        }

        $json = $this->renderJson($total, $data);
        echo $json;
    }

    /**
     * 资讯内容
     * @param  string  $cate  资讯分类拼音
     * @param  integer $count 单页返回数量
     * @param  integer $page  页码
     */
    public function actionArticle($cate, $count=10, $page=0)
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.id,t.title,t.s_title,t.description,t.content,t.image,t.url,t.source,t.show_time',
            'with' => array(
                'cate' => array(
                    'alias' => 'c',
                    'condition' => 'c.pinyin=:cate',
                    'params' => array(':cate'=>$cate)
                )
            ),
            'order' => 't.show_time desc',
            'limit' => $count,
            'offset' => $page * $count,
            'scopes' => 'normal',
        ));

        $count = ArticleExt::model()->count($criteria);
        $articles = ArticleExt::model()->findAll($criteria);
        $data = array();
        foreach($articles as $k=>$article)
        {
            $baseRow = $this->_filterAttribute($article);
            $row = array(
                'image' => ImageTools::fixImage($article->image),
                'cate' => $article->cate->name,
                'cate_url' => $this->createAbsoluteUrl('/home/news/list', array('pinyin'=>$article->cate->pinyin)),
                'article_url' => $this->createAbsoluteUrl('/home/news/detail', array('articleid'=>$article->id)),
            );
            $data[] = CMap::mergeArray($baseRow, $row);
        }
        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 订单信息列表
     * @param  integer $count [description]
     * @param  integer $page  [description]
     * @return [type]         [description]
     */
    public function actionOrder($count=10, $page=0)
    {
        $criteria = new CDbCriteria(array(
            'order' => 'id desc',
            'limit' => $count,
            'offset' => $page * $count,
        ));

        $count = OrderExt::model()->count($criteria);
        $orders = OrderExt::model()->findAll($criteria);
        $data = array();
        foreach($orders as $k=>$order)
        {
            $baseRow = $this->_filterAttribute($order, array('id','name','phone','spm_a','spm_b','created'));
            $baseRow['source'] = $baseRow['spm_a'];
            $baseRow['type'] = $baseRow['spm_b'];
            unset($baseRow['spm_a']);
            unset($baseRow['spm_b']);
            $data[] = $baseRow;
        }
        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 特价房列表
     * @param  integer  $recom 是否返回首页推荐的特价房数据
     * @param  integer $count 单页返回数量
     * @param  integer $page  页码
     */
    public function actionSpecial($count=10, $page=0, $recom=0)
    {

        $criteria = new CDbCriteria(array(
            'alias' => 't',
            'select' => 't.id,t.title,t.hid,t.price_old,t.price_new,t.image,t.housetype_img,t.room,t.bed_room,t.size,t.created',
            'limit' => $count,
            'offset' => $page * $count,
            'with' => array(
                'plot' => array(
                    'alias'=>'plot',
                )
            )
        ));
        if($recom){
            $count = PlotSpecialExt::model()->normal()->recommend()->count();
            $result = PlotSpecialExt::model()->normal()->recommend()->findAll($criteria);
        }else{
            $criteria->order = 't.status ASC,t.sort DESC,t.recommend DESC,t.created DESC';
            $count = PlotSpecialExt::model()->normal()->count();
            $result = PlotSpecialExt::model()->normal()->findAll($criteria);
        }

        $data = array();
        foreach($result as $k=>$plotSpecial)
        {
            $data[$k] = $this->_filterAttribute($plotSpecial);
            $data[$k]['plot'] = $plotSpecial->plot ? $plotSpecial->plot->title : '';
            $data[$k]['plot_url'] = $plotSpecial->plot ? $this->createAbsoluteUrl('/home/plot/index',array('py'=>$plotSpecial->plot->pinyin)) : '';
            $data[$k]['image'] = ImageTools::fixImage($plotSpecial->image);
            $data[$k]['housetype_img'] = array_map(array('ImageTools','fixImage'), $plotSpecial->housetype_img);
        }

        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 特惠团列表
     * @param  integer  $recom 是否返回首页推荐的特价房数据
     * @param  integer $count 单页返回数量
     * @param  integer $page  页码
     */
    public function actionTuan($count=10, $page=0, $recom=0)
    {

        $criteria = new CDbCriteria(array(
            'alias' => 't',
            'select' => 't.id,t.hid,t.title,t.s_title,t.pc_img,t.url,t.hongbao,t.created',
            'limit' => $count,
            'offset' => $page * $count,
            'order' => 't.sort DESC,t.created DESC',
        ));
        if($recom){
            $count = PlotTuanExt::model()->normal()->noExpire()->recommend()->count();
            $result = PlotTuanExt::model()->normal()->noExpire()->recommend()->findAll($criteria);
        }else{
            $count = PlotTuanExt::model()->normal()->noExpire()->count();
            $result = PlotTuanExt::model()->normal()->noExpire()->findAll($criteria);
        }

        $data = array();
        foreach($result as $k=>$plotKan)
        {
            $data[$k] = $this->_filterAttribute($plotKan);
            $data[$k]['plot'] = $plotKan->plot ? $plotKan->plot->title : '';
            $data[$k]['plot_url'] = $plotKan->plot ? $this->createAbsoluteUrl('/home/plot/index',array('py'=>$plotKan->plot->pinyin)) : '';
            $data[$k]['pc_img'] = ImageTools::fixImage($plotKan->pc_img);
        }

        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 图片相册列表
     * @param int $count 每页返回的数量
     * @param int $page  当前页码
     * @param int $hid   楼盘id
     * @param int $type  相片类型
     */
    public function actionPLotImg($count=10,$page=0,$hid=0,$type=0)
    {
        $criteria = new CDbCriteria(array(
            'alias'=>'t',
            'select' => 't.id,t.hid,t.type,t.title,t.url,t.is_cover,t.created',
            'condition' =>'tag.status=1',
            'limit' => $count,
            'offset' => $page * $count,
            'order' => 't.sort DESC,t.created DESC'
        ));
        if ($hid) {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        if ($type) {
            $criteria->addCondition('type=:type');
            $criteria->params[':type'] = $type;
        }
        $count = PlotImgExt::model()->with('tag')->count($criteria);
        $result = PlotImgExt::model()->with('tag')->findAll($criteria);
        $data = array();
        foreach ($result as $k => $img) {
            $data[$k] = $this->_filterAttribute($img);
            //更换图片相对地址
            if(strpos($data[$k]['url'],'http')===false){
                $data[$k]['url']=ImageTools::fixImage($data[$k]['url']);
            }
            $data[$k]['plot'] = $img->plot ? $img->plot->title : '';
            $data[$k]['plot_url'] = $img->plot ? $this->createAbsoluteUrl('/home/plot/index',array('py'=>$img->plot->pinyin)) : '';
            $data[$k]['type_name']=$img->tag?$img->tag->name:'';
        }
        $json = $this->renderJson($count,$data);
        echo $json;
    }

    /**
     * 楼栋列表
     * @param int $count 每页返回的数量
     * @param int $page  当前页码
     * @param int $hid   楼盘id
     */
    public function actionPlotBuilding($count=10,$page=0,$hid=0)
    {
        $criteria = new CDbCriteria(array(
            'alias' => 't',
            'select' => 't.id,t.hid,t.name,t.unit_total,t.household_total,t.floor_total,t.sale_total,t.lift_house_match,t.pid,t.open_time,t.created,t.delivery_time',
            'condition' => 't.status=1',
            'limit' => $count,
            'offset' => $page * $count,
            'order' => 't.created DESC',
        ));
        if ($hid) {
            $criteria->addCondition('t.hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        $count = PlotBuildingExt::model()->count($criteria);
        $result = PlotBuildingExt::model()->findAll($criteria);
        $data = array();
        foreach ($result as $k => $building) {
            $data[$k] = $this->_filterAttribute($building);
            $data[$k]['plot'] = $building->plot ? $building->plot->title : '';
            $data[$k]['plot_url'] = $building->plot ? $this->createAbsoluteUrl('/home/plot/index', array('py' => $building->plot->pinyin)) : '';
        }
        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 户型列表
     * @param int $count 每页返回的数量
     * @param int $page  当前页码
     * @param int $hid   楼盘id
     * @param int $bedroom 卧室数量
     */
    public function actionPlotHouseType($count=10,$page=0,$hid=0,$bedroom=0)
    {
        $criteria = new CDbCriteria(array(
            'select' => 'id,hid,title,image,description,bedroom,livingroom,bathroom,cookroom,inside_size,size,sale_status,is_cover,created,ave_price,price',
            'condition' => 'status=1',
            'offset' => $count * $page,
            'limit' => $count,
            'order' => 'sort DESC,created DESC'
        ));
        if ($hid) {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        if ($bedroom) {
            $criteria->addCondition('bedroom=:bedroom');
            $criteria->params[':bedroom'] = $bedroom;
        }
        $count = PlotHouseTypeExt::model()->count($criteria);
        $result = PlotHouseTypeExt::model()->findAll($criteria);
        $data = array();
        foreach ($result as $k => $house) {
            $data[$k] = $this->_filterAttribute($house);
            //更换图片相对地址
            if(strpos($data[$k]['image'],'http')===false){
                $data[$k]['image']=ImageTools::fixImage($data[$k]['image']);
            }
            $data[$k]['plot'] = $house->plot ? $house->plot->title : '';
            $data[$k]['plot_url'] = $house->plot ? $this->createAbsoluteUrl('/home/plot/index', array('py' => $house->plot->pinyin)) : '';
        }
        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * 楼盘期数列表
     * @param int $count 每页返回的数量
     * @param int $page  当前页码
     * @param int $hid   楼盘id
     */
    public function actionPlotPeriod($count=10,$page=0,$hid=0)
    {
        $criteria = new CDbCriteria(array(
            'select' => 'id,hid,period,image,open_time,delivery_time,created',
            'condition' => 'status=1',
            'offset' => $count * $page,
            'limit' => $count,
            'order' => 'created DESC'
        ));
        if ($hid) {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        $count = PlotPeriodExt::model()->count($criteria);
        $result = PlotPeriodExt::model()->findAll($criteria);
        $data = array();
        foreach ($result as $k => $period) {
            $data[$k] = $this->_filterAttribute($period);
            //更换图片相对地址
            if(strpos($data[$k]['image'],'http')===false){
                $data[$k]['image']=ImageTools::fixImage($data[$k]['image']);
            }
            $data[$k]['plot'] = $period->plot ? $period->plot->title : '';
            $data[$k]['plot_url'] = $period->plot ? $this->createAbsoluteUrl('/home/plot/index', array('py' => $period->plot->pinyin)) : '';
        }
        $json = $this->renderJson($count, $data);
        echo $json;
    }

    /**
     * [actionPlotInfo 根据新/旧id/小区名获取楼盘信息]
     * @param  integer $kw      [description]
     * @param  integer $type [description]
     * @return [type]           [description]
     */
    public function actionPlotInfo($kw='',$type=1)
    {
        $plot = [];
        if(!$kw) {
            echo $this->renderJson(0, ['error'=>'参数错误']);
        } else {
            $criteria = new CDbCriteria;
            switch ($type) {
                case '1':
                    $criteria->addCondition('id=:id');
                    $criteria->params[':id'] = $kw;
                    break;
                case '2':
                    $criteria->addCondition('old_id=:id');
                    $criteria->params[':id'] = $kw;
                    break;
                case '3':
                    $criteria->addSearchCondition('title',$kw);
                    break;
            }
            $criteria->order = 'updated desc,created desc';
            $plot = PlotExt::model()->undeleted()->find($criteria);

            if($plot) {
                echo $this->renderJson(1, $plot->attributes);
            } else {
                echo $this->renderJson(0, ['error'=>'楼盘不存在']);
            }
        }

    }
    /**
     * [获取二手房或租房列表]
     * @param  integer $cate  [二手房/商铺/写字楼]
     * @param  integer $type  [二手房/租房]
     * @param  integer $limit []
     * @return [array]         []
     */
    public function actionEozList($cate=1, $type=1, $limit=10)
    {
        //二手房
        $xs = $type==1 ? Yii::app()->search->house_esf:Yii::app()->search->house_zf;
        //die(var_dump($xs));
        $xs->setQuery('');
        $xs->setFacets(array('status'), true);
        $xs->addRange('category',$cate,$cate);
        $xs->addRange('status', 1, 1);
        $xs->addRange('deleted', 0, 0);

        $xs->addRange('sale_status',1,1);
        $xs->addRange('expire_time',time(),null);
        $count = 0;
        $xs->search();//count放在search之后才能应用排序条件
        $count = array_sum($xs->getFacets('status'));//通过获取分面搜索值能得到精准数量
        $xs->setLimit($limit);
        $xs->setMultiSort(['sort' => false, 'refresh_time' => false, 'sale_time' => false]);
        $docs = $xs->search();

        $data = [];
        foreach($docs as $key => $value){

            $data[] = array_merge($value->getFields(),['url' => $type == 1 ? Yii::app()->createAbsoluteUrl('/resoldhome/esf/info', ['id' => $value->id]) : Yii::app()->createAbsoluteUrl('/resoldhome/zf/info',['id' => $value->id])]);
        }
        // die(var_dump($data));
        echo $this->renderJson(0,$data);
        //die(var_dump($docs));

    }

}
