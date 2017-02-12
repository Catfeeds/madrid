<?php

/**
 * 资讯列表
 * @author SC
 * @date 2015-10-16
 */
class SpecialController extends HomeController {
    /**
     * 特价房
     */
    public function actionTrade(){
        $criteria = new CDbCriteria();
        $criteria -> order = 'status ASC,sort DESC,recommend DESC,created DESC';
        $dataProvider = PlotSpecialExt::model()->normal()->noExpire()->getList($criteria,16);
        $data = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $tuanNum = PlotTuanExt::model()->normal()->noExpire()->count();
        $this->render('trade',array('special'=>$data,'pager'=>$pager,'tuanNum'=>$tuanNum));
    }
    /**
     * 特惠房\团购
     */
    public function actionTuan(){
        $criteria = new CDbCriteria();
        $criteria -> order = 'sort DESC, created DESC';
        $dataProvider = PlotTuanExt::model()->normal()->noExpire()->getList($criteria,8);
        $data = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $this->render('tuan',array('tuan'=>$data,'pager'=>$pager));
    }

}
