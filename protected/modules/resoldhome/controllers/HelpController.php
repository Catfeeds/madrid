<?php
/**
 *
 * User: jt
 * Date: 2016/11/15 16:12
 */

class HelpController extends ResoldHomeController{

    public function actionIndex($keyword=''){
        if($keyword == ''){
            $help = ResoldHelpExt::model()->find();
        }else{
            $help = ResoldHelpExt::model()->find('keyword=:keyword',array(':keyword'=>$keyword));
        }
        if(!$help){
           $this->redirect($this->createUrl('index'));
        }
        $helps = ResoldHelpExt::model()->common()->findAll();
        $this->render('index',array('help'=>$help,'helps'=>$helps));
    }

}