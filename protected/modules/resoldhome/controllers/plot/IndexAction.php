<?php
/**
 * 楼盘首页
 * @param $pinyin string
 */
class IndexAction extends CAction{

    public $plot;

    public function run(){
        $this->plot = $this->controller->plot;
        $jzlb = [];
        //住宅类型
        foreach($this->plot->jzlb as $k=>$v){
            $jzlb[] = $v->name;
        }
        //特色
        $xmts = [];
        foreach($this->plot->xmts as $k=>$v){
            $xmts[] = $v->name;
        }
        //物业类型
        $wylx = [];
        foreach($this->plot->wylx as $k=>$v){
            $wylx[] = $v->name;
        }
        $sort = 'sort desc';
        /**
         * 小区二手房
         */

        foreach(['xsesf','xszf'] as $k=>$v){
            //die(var_dump($v));
            $xs = $v=='xsesf'?Yii::app()->search->house_esf:Yii::app()->search->house_zf;
            $count = 0;
            $ids = [];
            $xs->setQuery('');
            $xs->setFacets(array('status'), true);//分面统计
            $xs->addRange('hid',$this->plot->id,$this->plot->id);
            $xs->addRange('category',1,1);
            $xs->addRange('expire_time',time(),null);
            $xs->search();
            $xs->setLimit(10,0);
            $count = array_sum($xs->getFacets('status'));
            $xs->setMultiSort(['sort'=>false,'created'=>false]);
            $docs = $xs->search();
            foreach($docs as $k=>$v){
                $ids[] = $v->id;
            }
            $data[] = ['count'=>$count,'ids'=>$ids];
        }
        //die(var_dump($data));

        //二手房数量
        $esfcount = $data[0]['count'];
        // $esfcount = ResoldEsfExt::model()->enabled()->undeleted()->saling()->count(['condition'=>'hid=:id and category=:category','params'=>[':id'=>$this->plot->id,':category'=>1]]);
        //租房数量
        $zfcount = $data[1]['count'];
        // $zfcount = ResoldZfExt::model()->enabled()->undeleted()->saling()->count(['condition'=>'hid=:id and category=:category','params'=>[':id'=>$this->plot->id,':category'=>1]]);
        //当前小区二手房
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$data[0]['ids']);
        $criteria->order='created desc';
        $esfs = ResoldEsfExt::model()->enabled()->undeleted()->saling()->findAll($criteria);

        if(count($esfs)>5){
            $esfs = array_slice($esfs,0,5);
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$data[1]['ids']);
        $criteria->order='created desc';
        $zfs = ResoldZfExt::model()->enabled()->undeleted()->saling()->findAll($criteria);
        if(count($zfs)>5){
            $zfs = array_slice($zfs,0,5);
        }
        // $esfs = ResoldEsfExt::model()->enabled()->undeleted()->saling()->findAll(['condition'=>'hid=:id and category=:category','order'=>$sort,'limit'=>5,'params'=>[':id'=>$this->plot->id,':category'=>1]]);
        // //当前小区租房
        // $zfs = ResoldZfExt::model()->enabled()->undeleted()->saling()->findAll(['condition'=>'hid=:id and category=:category','order'=>$sort,'limit'=>5,'params'=>[':id'=>$this->plot->id,':category'=>1]]);
        //周边小区
        //街道--区域
        $zbplots = PlotExt::model()->normal()->findAll(['condition'=>'t.id!=:id and t.street=:street and t.image!=""','order'=>$sort,'limit'=>5,'params'=>[':id'=>$this->plot->id,':street'=>$this->plot->street]]);
        //die(var_dump($zbplots));
        //小区相册
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
        $imgcate = PlotImgExt::getImgBycate($this->plot->id);
        $cate_arr = TagExt::model()->getTagByCate('xcfl')->findAll();
        $cate = array();
        foreach ($cate_arr as $v) {
            $cate[$v->id] = $v->name;
        }
        $criteria = new CDbCriteria;
        $criteria->addCondition('hid = :hid');
        $criteria->params = array(':hid'=>$this->plot->id);
        $criteria->order = 'sort desc,id desc';
        $ablum = PlotImgExt::model()->getList($criteria, 3);
        $this->controller->render('plot_index',array(
            'plot'=>$this->plot,
            'jzlb'=>$jzlb,
            'xmts'=>$xmts,
            'wylx'=>$wylx,
            'esfcount'=>$esfcount,
            'zfcount'=>$zfcount,
            'esfs'=>$esfs,
            'zfs'=>$zfs,
            'zbplots'=>$zbplots,
            'cate'=>$cate,
            'imgcate'=>$imgcate,
            'ablum'=>$ablum->data
        ));
    }
}
