<?php
class IndexAction extends CAction
{
    public $plot;

    public function run()
    {
        //隐藏右侧浮动菜单
        $this->controller->showFloatMenu = false;
        $this->plot = $this->controller->plot;

        //该楼盘所有户型，2016.07.12规则：自定义顺序降序，发布时间降序
        $huxing = PlotHouseTypeExt::model()->enabled()->findAllByHid($this->plot->id, ['order'=>'sort desc,created desc']);
        //户型分类以及对应户型数量
        $houseTypeCate = [];
        foreach($huxing as $v) {
            if($v->bedroom>0){
                $houseTypeCate[$v->bedroom][] = $v;
            }
        }

        $faqlist = AskExt::model()->replyed()->findAll(array(
                                    'select' => 'id,question,answer,created',
                                    'condition'=>'status = 1 and hid = :hid',
                                    'params'=>array(':hid'=>$this->plot->id),
                                    'order' => 'created desc,updated desc',
                                    'limit' => 8
        ));

        $articlePlotRel = ArticlePlotRelExt::model()->with(array('article'=>array('order'=>'article.show_time desc')))->findAll(array(
                                    'limit'=>7,
//                                    'order'=>'created desc',
                                    'condition'=>'hid = :hid and status=1',
                                    'params'=>array(':hid'=>$this->plot->id),
        ));

        if (!isset($articlePlotRel) || empty($articlePlotRel)) {
            $articlePlotRel = array();
        }

        //价格动态
        $dongtai = PlotPriceExt::model()->find(array(
            'select' => 'description,created,hid',
            'condition' => 'hid=:hid',
            'order' => 'created desc',
            'limit' => 3,
            'params' => array(
                ':hid' => $this->plot->id
            )
        ));

        $specialplots = PlotSpecialExt::model()->with('houseType')->findAll(array(
            'condition' => 't.status = 1 and t.hid = :hid and t.end_time > :end_time',
            'params' => array(':hid' => $this->plot->id,':end_time'=>time()),
            'limit' => 10,
            'order' => 'recommend DESC, t.created DESC',
        ));

        if (false&&!$this->plot->tag_id) {
            $this->plot->tag_id = $this->getTagIdByTagName($this->plot->title);
            if ($this->plot->tag_id) {
                $this->plot->save();
            }
        }

        $dayS = 0;
        $dayG = 0;
        $hourS = 0;
        $hourG = 0;
        $secondS = 0;
        $secondG = 0;
        if ($this->plot->newKan && !empty($this->plot->newKan->expire) && ($this->plot->newKan->expire > time())) {
            $expire = $this->plot->newKan->expire;
            $distance = $expire - time();
            $day = floor($distance/86400);//天数
            $hour = floor(($distance-(floor($distance/86400)*86400))/3600);//小时
            $second = floor(($distance - (floor($distance/86400)*86400 + floor(($distance-(floor($distance/86400)*86400))/3600)*3600))/60);
            if ($day >= 10) {
                $dayS = floor($day/10);
                $dayG = $day%10;
            } else {
                $dayG = $day;
            }
            if ($hour >= 10) {
                $hourS = floor($hour/10);
                $hourG = $hour%10;
            } else {
                $hourG = $hour;
            }
            if ($second >= 10) {
                $secondS = floor($second/10);
                $secondG = $second%10;
            } else {
                $secondG = $second;
            }
        }

        $wantKan = PlotExt::model()->normal()->isNew()->findAll(array(
            'condition' => '(t.street=:street or t.area=:area) and t.price>:priceBegin and t.price<:priceEnd',
            'params' => array(
                ':street' => $this->plot->street,
                ':area' => $this->plot->area,
                ':priceBegin' => $this->plot->price-1000,
                ':priceEnd' => $this->plot->price+1000,
            ),
            'with' => array(
                'areaInfo' => array(
                    'alias' => 'a',
            )),
            'order' => 'a.parent desc, t.price desc',
            'limit' => 4,
        ));

        $this->controller->pageTitle = $this->plot->title.'_'.SM::urmConfig()->cityName().$this->plot->title.'价格_'.$this->plot->title.'户型_'.$this->plot->title.'电话_'.$this->plot->title.'环境_'.$this->plot->title.'图片-'.SM::globalConfig()->siteName().'房产-'.SM::globalConfig()->siteName();
        //存在seo_title，覆盖$this->pageTitle
        if($this->plot->data_conf['seo_title']){
            $this->controller->pageTitle = $this->plot->data_conf['seo_title'];
        }

        //楼盘点评
        $criteria = new CDbCriteria([
            'condition' => 'hid=:hid',
            'params' => [':hid'=>$this->plot->id],
            'order' => 'id desc',
        ]);
        $dianping = PlotCommentExt::model()->find($criteria);

        //沙盘图楼栋信息
        $periods = PlotPeriodExt::model()->enabled()->findAllByHid($this->plot->id,['order'=>'period asc']);
        $periodJsData = $periodHx = [];
        foreach($periods as $period) {
            foreach($period->buildings as $building) {
                if($building->pointX<=0 && $building->pointY<=0) continue;
                $fangyuan = [];
                $houseTypes = PlotHouseTypeExt::model()->findAllByBid($building->id);
                foreach($houseTypes as $houseType) {
                    $fangyuan [] = [
                        'huxing' => $houseType->title,
                        'tingshi' => $houseType->bedroom.'室'.$houseType->livingroom.'厅'.$houseType->bathroom.'卫',
                        'mianji' => $houseType->size.'平',
                        'url' =>$this->controller->createUrl('/home/plot/hximg',['py'=>$this->plot->pinyin,'pid'=>$houseType->id])
                    ];
                }
                //2016.08.10规则，点期数出现该期数下楼栋户型
                foreach($houseTypes as $ht) {
                    $periodHx[$period->period][$ht->id] = $ht;
                }
                $periodJsData[] = [
                    'x' => $building->pointX,
                    'y' => $building->pointY,
                    'state' => $building->getIsOnSale() ? '1' : ($building->getIsForSale() ? '2' : '3'),
                    'id' => $building->id,
                    'text' => $building->name,
                    'qi' => $building->pid,
                    'data' => [
                        'kaipan' => ($building->open_time)?date('Y-m-d',$building->open_time):(($this->plot&&$this->plot->open_time)?date('Y-m-d',$this->plot->open_time):'-'),
                        'jiaofang' => $building->delivery_time ? date('Y-m-d', $building->delivery_time) : '-',
                        'danyuan' => $building->unit_total,
                        'cengshu' => $building->floor_total,
                        'hushu' => $building->household_total,
                        'zaishou' => $building->sale_total,
                        'fangyuan' => $fangyuan
                    ]
                ];
            }

        }
        $criteria = new CDbCriteria(array(
            'alias' => 'i',
            'condition' => 'i.hid=:hid and i.is_cover=1',
            'with' => array(
                'tag' => array(
                    'alias' => 't',
                )
            ),
            'order' => 't.sort asc',
            'params' => array(':hid'=>$this->plot->id)
        ));
        $album = PlotImgExt::model()->findAll($criteria);

        $hxImage = PlotHouseTypeExt::model()->enabled()->find([
            'condition' => 'hid=:hid and is_cover=1',
            'params' => [':hid'=>$this->plot->id]
        ]);

        //交房时间
        $jfTime = PlotBuildingExt::model()->findAllByHid($this->plot->id, [
            'condition' => 'delivery_time>0',
            'group' => 'delivery_time',
            'limit' => 5,
        ]);
        $jfsj = [];
        if($jfTime) {
            $jfTime = CHtml::listData($jfTime,'id', 'delivery_time');
            $criteria = new CDbCriteria(['order'=>'delivery_time desc']);
            $criteria->addInCondition('delivery_time', $jfTime);
            $jfData = PlotBuildingExt::model()->findAllByHid($this->plot->id, $criteria);
            foreach($jfData as $v) {
                $jfsj[$v->delivery_time][] = $v->name;
            }
        }

        //已领取的红包数量
        $redCount=0;
        if($this->plot->red){
            $redCount = OrderExt::model()->count(array(
                'condition' => 'spm_b=:type and spm_c =:redId',
                'params' => array(':type' => OrderExt::$type['PlotRedExt'][0],':redId'=>$this->plot->red->id)));
        }

        //同价位楼盘,价格高于和低于当前楼盘价格（高于和低于各两条数据）,当前楼盘价格为0或价格类型不是“均价”时，不查询同价位楼盘
        $nearPricePlots=[];
        if($this->plot->price>0 &&$this->plot->price_mark==1){
            $abovePlots = PlotExt::model()->normal()->isNew()->findAll(array(
                'condition' => 'price_mark=1 and price>:price',
                'params' =>array(':price'=>$this->plot->price),
                'order'=>'price asc',
                'limit'=>2
            ));
            $downPlots = PlotExt::model()->normal()->isNew()->findAll(array(
                'condition' =>'price_mark=1 and price<=:price and id!=:id',
                'params' =>array(':price'=>$this->plot->price,':id'=>$this->plot->id),
                'order'=>'price desc',
                'limit'=>2
            ));
            $nearPricePlots=array_merge($nearPricePlots,$abovePlots,$downPlots);
        }

        /**
        打折楼盘：
        1. 调用特惠团的相关楼盘，按特惠团列表页的排序规则排。
        2.如果没有特惠团数据，调用有优惠信息（正常+未过期）的楼盘，按调用信息添加时间倒序。
        3.如果没有优惠信息，调用有红包（正常+未过期）的楼盘，按优惠信息添加时间倒序。
        **/
        $discountPlots=PlotTuanExt::model()->normal()->noExpire()->findAll(array(
            'order'=>'sort DESC, created DESC',
            'limit'=>4
        ));
        if(count($discountPlots)==0){
            $discountPlots=PlotDiscountExt::model()->normal()->findAll(array(
                'order'=>'created DESC',
                'limit'=>4
            ));
            if(count($discountPlots)==0){
                $discountPlots=PlotRedExt::model()->findAll(array(
                    'condition'=>'status=1 and end_time>:time',
                    'params'=>array(':time'=>time()),
                    'order'=>'created DESC',
                    'limit'=>4,
                ));
            }
        }

        //热门楼盘
        $hotPlots = PlotExt::model()->normal()->findAll(array(
            'condition' => 'is_new=1',
            'order' => 'sort desc ,recommend desc ,open_time desc',
            'limit'=>4,
        ));

        //附近楼盘
        $nearByPlots=PlotExt::model()->normal()->findAll(array(
            'select'=>array('*','(
                6371 * acos(
                    cos(radians(:lat)) * cos(radians(t.map_lat)) * cos(
                        radians(t.map_lng) - radians(:long)
                    ) + sin(radians(:lat)) * sin(radians(t.map_lat))
                )
            ) as distance'),
            'condition'=>'is_new=1 and id!=:id',
            'params'=>array(":id"=>$this->plot->id,':lat'=>$this->plot->map_lat,':long'=>$this->plot->map_lng),
            'order'=>'distance ASC',
            'limit'=>4
        ));

        $this->controller->render('plot_index', array(
            'faceimg' => $album,
            'hxImage' => $hxImage,
            'houseTypeCate' => $houseTypeCate,
            'huxing' => $huxing,
            'faqlist' => $faqlist,
            'articlePlotRel' => $articlePlotRel,
            'dongtai' => $dongtai,
            'specialplots' => $specialplots,
            'dayS' => $dayS,
            'dayG' => $dayG,
            'hourS' => $hourS,
            'hourG' => $hourG,
            'secondS' => $secondS,
            'secondG' => $secondG,
            'wantKan' => $wantKan,
            'periods' => $periods,
            'periodJsData' => $periodJsData,
            'dianping' => $dianping,
            'periodHx' => $periodHx,
            'jfsj' => $jfsj,
            'redCount'=>$redCount,
            'nearPricePlots'=>$nearPricePlots,
            'discountPlots'=>$discountPlots,
            'hotPlots'=>$hotPlots,
            'nearByPlots'=>$nearByPlots,
        ));
    }

    /**
     * 是否展示红包弹窗
     * @param integer $id 红包id
     * @return boolean
     */
    public function popRed($id)
    {
        $cookie = Yii::app()->request->getCookies();
        if(!isset($cookie['red'.$id])) {
            $cookie = new CHttpCookie('red'.$id, $id, ['expire'=>time()+86400]);
            Yii::app()->request->cookies['red'] = $cookie;
            return true;
        }
        return false;
    }
}
