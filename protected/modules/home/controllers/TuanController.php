<?php
/**
 * 前台首页
 * @author SC
 * @date 2015-10-21
 */
class TuanController extends HomeController{

    //public $layout = '/plot/plot_base';

    public function actionIndex(){

        $criteria = new CDbCriteria(array(
            'condition' => 'expire > :expire',
            'order' => 'sort desc,created desc',
            'params' => array(':expire'=>time())
        ));
        $dataProvider = PlotKanExt::model()->normal()->getList($criteria,5);
        $kan = $dataProvider->data;
        $pager = $dataProvider->pagination;

        $kanNum = Yii::app()->db->createCommand('select sum(stat) from `plot_kan`')->queryScalar()+OrderExt::model()->count('spm_b="看房团"');
        $plotNum = PlotExt::model()->count('kan_id > 0');//楼盘数


        $recom = RecomExt::model()->getRecom('kftjchg', 3)->findAll();

        $this->render('index',array(
            'kan'=>$kan,
            'pager'=>$pager,
            'plotNum'=>$plotNum,
            'kanNum'=>$kanNum,
            'recom'=>$recom,
        ));
    }

    /**
     * 看房团回顾
     */
    public function actionBack(){
        $criteria = new CDbCriteria();
        $criteria -> order = 'created desc';
        $criteria->addCondition("expire <= :expire");
        $criteria->params[':expire'] = time();
        $dataProvider = PlotKanExt::model()->normal()->getList($criteria,5);
        $kan = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $kanNum = 0;
        foreach($kan as $v){
            $kanNum = $kanNum + $v->stat;
        }

        $this->render('back',array(
            'kan'=>$kan,
            'pager'=>$pager,
            'kanNum'=>$kanNum,
        ));
    }

}
