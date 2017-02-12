<?php
/**
 * 问答列表页
 * @author steven_allen
 * @version 2016-06-07
 */
class IndexAction extends CAction
{
    public function run()
    {
        $hid = (int)Yii::app()->request->getQuery('hid',0);
        $page = (int)Yii::app()->request->getQuery('page',1);
        $sort = Yii::app()->request->getQuery('sort','');
        $kw = Yii::app()->request->getQuery('kw','');
        $kw = $this->controller->cleanXss($kw);
        $cid = (int)Yii::app()->request->getQuery('cid',0);
        if($hid)
        {
            $ct = AskExt::model()->normal()->count(array('condition'=>'t.hid=:hid','params'=>array(':hid'=>$hid)));
            $this->controller->render('index',array('hid'=>$hid,'page'=>$page,'count'=>$ct));
        }
        else
        {
            $cate = AskCateExt::model()->getAskCateMenu();
            // echo CJSON::encode($cate);exit;
            $this->controller->render('index',array('sort'=>$sort,'page'=>$page,'cid'=>$cid,'cate'=>$cate,'kw'=>$kw));
        }

    }
}
