<?php
/**
 * 邻校房
 * User: jt
 * Date: 2016/11/3 9:55
 */

class SchoolController extends ResoldHomeController{

    public function actionIndex($area='',$street='',$type='',$kw='',$sort=''){
        $criteria = new CDbCriteria(array(
            'order'=>'t.recommend ,t.house_num desc,t.created desc',
            'with'=>array('plotNumAll','plot')
        ));
        $condition = array();
        if($area || $street){
            if(($selectedArea = AreaExt::model()->findByPk($area)) &&  $selectedArea->getIsFirstLevel()){
                $criteria->addCondition('t.area=:area');
                $criteria->params[':area'] = $area;
                $condition = array_merge($condition,array('area'=>$selectedArea->name));
            }
            if(($selectedStreet = AreaExt::model()->findByPk($street)) && $selectedArea = $selectedStreet->getParentArea()) {
                $criteria->addCondition('t.area=:area and t.street=:street');
                $criteria->params[':street'] = $selectedStreet->id;
                $criteria->params[':area'] = $selectedArea->id;
                $condition = array_merge($condition,array('street'=>$selectedStreet->name));
            }
        }
        if($kw){
            $kw=$this->cleanXss($kw);
            $criteria->addSearchCondition('t.name',$kw);
            $condition = array_merge($condition,array('kw'=>$kw));
        }
        if($type && array_key_exists($type,SchoolExt::$type)){
            $criteria->addCondition('t.type=:type');
            $criteria->params[':type'] = $type;
            $condition = array_merge($condition,array('type'=>SchoolExt::$type[$type]));
        }
        if($sort != '' && $sort != 1){
            if($sort == 2){
                $criteria->order = 't.house_num asc';
            }elseif($sort == 3){
                $criteria->order = 't.esf_num desc';
            }elseif($sort == 4){
                $criteria->order = 't.esf_num asc';
            }
        }
        $pager = new CPagination(SchoolExt::model()->normal()->count($criteria));
        $pager->pageSize = 10;
        $pager->applyLimit($criteria);

        $data = SchoolExt::model()->normal()->findAll($criteria);
        $params = array(
            'area'=>$area,
            'street'=>$street,
            'type'=>$type,
            'sort'=>$sort
        );
        $this->render('index',array('data'=>$data,'pager'=>$pager,'params'=>$params,'condition'=>$condition));
    }

    public function actionPlot($pinyin){
        $school = SchoolExt::model()->normal()->with('plotNum','plotNumAll','plotSchool')->find('t.pinyin=:pinyin',array(':pinyin'=>$pinyin));
        if(!$school)
            throw new CHttpException(404,"学校不存在！");
        $plot_ids = array();
        foreach ($school->plotSchool as $plot){
            $plot_ids[] = $plot->hid;
        }
        $price = ResoldPlotPriceExt::getLastMonthPrice($plot_ids);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.id',$plot_ids);
        $counts = PlotExt::model()->normal()->count($criteria);
        $pages = new CPagination($counts);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $plots = PlotExt::model()->normal()->findAll($criteria);
        $this->render('plot',array('price'=>$price,'pages'=>$pages,'list'=>$plots,'school'=>$school));
    }

    public function actionProfile($pinyin){
        $school = SchoolExt::model()->normal()->with('plotNum','plotNumAll','plotSchool')->find('t.pinyin=:pinyin',array(':pinyin'=>$pinyin));
        if(!$school)
            throw new CHttpException(404,"学校不存在！");
        $plot_ids = array();
        foreach ($school->plotSchool as $plot){
            $plot_ids[] = $plot->hid;
        }
        $price = ResoldPlotPriceExt::getLastMonthPrice($plot_ids);
        $this->render('profile',array('price'=>$price,'school'=>$school));
    }
}