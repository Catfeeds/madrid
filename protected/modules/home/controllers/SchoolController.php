<?php

/**
 * 资讯列表
 * @author SC
 * @date 2015-10-12
 */
class SchoolController extends HomeController
{

    public $area = array();

    public function init()
    {
        parent::init();
        $this->area = SchoolAreaExt::model()->normal()->with(array('areaInfo'))->findAll(array( 'order' => 't.sort DESC'));
    }
    /**
     * 邻校房首页
     * 排序规则：推荐、重要、楼盘数
     */
    public function actionIndex()
    {
        $xxschools = $zxschools = [];
        if($this->area)
        foreach ($this->area as $key => $value) {
            $sql = "select s.name,s.id,s.pinyin,count(p.id) as plot_num from school s left join school_plot_rel p on p.sid=s.id left join plot pp on pp.id=p.hid where s.type=1 and s.status=1 and s.area=".$value->area." and pp.is_new=1 GROUP BY s.id order by s.recommend desc,plot_num desc,s.created desc limit 8";
            $xxschools[$value->area] = Yii::app()->db->createCommand($sql)->queryAll();
            $sql = "select s.name,s.id,s.pinyin,count(p.id) as plot_num from school s left join school_plot_rel p on p.sid=s.id left join plot pp on pp.id=p.hid where s.type=2 and s.status=1 and s.area=".$value->area." and pp.is_new=1 GROUP BY s.id order by s.recommend desc,plot_num desc,s.created desc limit 8";
            $zxschools[$value->area] = Yii::app()->db->createCommand($sql)->queryAll();
        }
        $this->render('index',['xx'=>$xxschools,'zx'=>$zxschools]);
    }

    /**
     * 区域
     */
    public function actionArea($id = 0) {
        $areaone = AreaExt::model()->find(array(
            'condition'=>'id = :id',
            'params'=>array(':id'=>$id),
        ));

        $xxids = '';
        foreach($areaone->allxxschool as $key => $v){
            if($xxids == ''){
                $xxids = $v->id;
            }else{
                $xxids = $xxids.','.$v->id;
            }
        }

        $zxids = '';
        foreach($areaone->allzxschool as $key => $v){
            if($zxids == ''){
                $zxids = $v->id;
            }else{
                $zxids = $zxids.','.$v->id;
            }
        }

        $this->render('area',array(
            'areaid'=>$id,
            'areaone'=>$areaone,
            'xxids'=>$xxids,
            'zxids' => $zxids,
            ));
    }

    /**
     * 学校
     */
    public function actionSchool($pinyin = ''){
        $school = SchoolExt::model()->find('pinyin=:pinyin',array(':pinyin'=>$pinyin));
        if(!$school)
            throw new Exception("学校不存在！");
        $plots = array(
            '500米' => SchoolPlotRelExt::model()->short()->with('plot:isNew')->findAll('sid=:sid',['sid'=>$school->id]),
            '1000米' => SchoolPlotRelExt::model()->middle()->with('plot:isNew')->findAll('sid=:sid',['sid'=>$school->id]),
            '1500米' => SchoolPlotRelExt::model()->long()->with('plot:isNew')->findAll('sid=:sid',['sid'=>$school->id]),
            '1500米外' => SchoolPlotRelExt::model()->extralong()->with('plot:isNew')->findAll('sid=:sid',['sid'=>$school->id]),
        );
        $this->render('school',array(
            'school'=>$school,
            'plots' => $plots,
        ));
    }
}
