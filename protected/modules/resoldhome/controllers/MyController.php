<?php
/**
 * 用户中心
 * User: jt
 * Date: 2016/11/4 15:44
 */
class MyController extends UcenterController{

    public function actionIndex(){
        $esf_count = ResoldEsfExt::model()->undeleted()->count('uid=:uid',array(':uid'=>$this->uid));
        $recent_month = time() - 86400 * 30; // 最近一个月
        $collect_count = ResoldUserCollectionExt::model()->count('created>=:time and uid=:uid',array(':uid'=>$this->uid,':time'=>$recent_month));
        $this->render('index',array('esf_count'=>$esf_count,'collect_count'=>$collect_count));
    }

    public function actionProfile(){
        $this->render('profile');
    }

}