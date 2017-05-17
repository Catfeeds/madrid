<?php
/**
 * 邻校房
 */
class SchoolController extends WapController
{
    public function actions()
    {
        $alias = 'wap.controllers.school.';
        return array(
            'index' => $alias.'IndexAction',
            'detail' => $alias.'DetailAction',
        );
    }

    /**
     * [actionAjaxGetSchools ajax获得邻校房]
     */
    public function actionAjaxGetSchools()
    {
        $kw = Yii::app()->request->getQuery('kw','');
        $type = Yii::app()->request->getQuery('type','');
        $id = Yii::app()->request->getQuery('aid',0);
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());

        $areaOne  = AreaExt::model()->find(array(
            'condition'=>'t.id = :id',
            'params'=>array(':id'=>$id),
        ));

        $name = $areaOne ? $areaOne->name : '';

        $schoolarea = SchoolAreaExt::model()->normal()->findAll();

        $criteria = new CDbCriteria();
        if(isset($id) && !empty($id)){
            $criteria->addCondition("t.area=:area");
            $criteria->params[':area']=$id;
        }

        if(isset($type) && !empty ($type)){
            $criteria->addCondition("t.type=:type");
            $criteria->params[':type']=$type;
        }
        $criteria->select='t.*,count(p.id) as num';
        $criteria->join='left join school_plot_rel p on p.sid=t.id left join plot pp on pp.id = p.hid';
        $criteria->addCondition("pp.is_new=1");
        $criteria->group ='t.id';
        $criteria->order = 't.recommend desc,num desc,t.created desc';
        if($kw)
        {
            $criteria->addSearchCondition("name",$kw);
        }
        $dataProvider = SchoolExt::model()->normal()->getList($criteria,10);
        $school = $dataProvider->data;
        $data = array();
        $data['totalPage'] = $dataProvider->pagination->pageCount;
        foreach ($school as $key => $value) {
            $tmp = array(
                'link'=>$this->createUrl('detail',array('id'=>$value['id'])),
                'pic'=>ImageTools::fixImage($value['image']),
                'schoolname'=>$kw?str_replace($kw, '<em class="c-red">'.$kw.'</em>', $value['name']):$value['name'],
                'area'=>$value->areaInfo?$value->areaInfo->name:'',
                'nub'=>$value->plotNum,
                );
            if($tmp['nub']>0){
                $data['lists'][] = $tmp;
            }
        }
        echo CJSON::encode($data);

    }
    /**
     * [actionAjaxGetSchoolPlot ajax获取学区楼盘]
     */
    public function actionAjaxGetSchoolPlot($lat=0,$lng=0)
    {
        $id = Yii::app()->request->getParam('id','');
        $school = SchoolExt::model()->find(array(
            'condition'=>'id=:id',
            'params'=>array(':id'=>$id),
        ));

        $ids= array();
        foreach($school->plotSchool as  $key=>$v){
            $ids[$key] = $v->hid;
        }

        $criteria = new CDbCriteria([
            'order' => 'acos(cos((map_lng - '.$lng.') * 0.01745329252) * cos((map_lat - '.$lat.') * 0.01745329252)) * 6371.004 asc'
        ]);
        $criteria->addInCondition('id', $ids);
        $dataProvider = PlotExt::model()->isNew()->getList($criteria,10);
        $plots = $dataProvider->data;

        $data = array();
        $data['totalPage'] = $dataProvider->pagination->pageCount;
        foreach ($plots as $key => $value) {
            $tags = array();
                foreach($value->xmts as $k=>$ts){
                    if($k<3) {
                        $tags[] = array(
                            'type' => $k+1,
                            'name' => $ts->name,
                        );
                    }
                }
            $des = '';
            if(isset($value->red)&&$value->red)
            {
                $des = $value->red->title;
            }
            else if(isset($value->discount)&&$value->discount)
            {
                $des = $value->discount->title;
            }
            $tmp = array(
                'link'=>$this->createUrl('plot/index',array('py'=>$value['pinyin'])),
                'pic'=> ImageTools::fixImage($value['image'],164,122),
                'title'=>$value['title'],
                'price'=>$value['price'].PlotPriceExt::$unit[$value->unit],
                'address'=>$value['sale_addr'],
                'description'=>$des,
                'lat' => $value->map_lat,
                'lng' => $value->map_lng,
                'tags' => $tags,
                'location' => $value->getDistance($value->map_lat,$value->map_lng,$lat,$lng).'米'
                );

            $data['lists'][] = $tmp;
        }
        echo CJSON::encode($data);
    }

}
