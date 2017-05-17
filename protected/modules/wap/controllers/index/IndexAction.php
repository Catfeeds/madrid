<?php
/**
 * wap首页
 * @author weibaqiu
 * @version 2016-05-24
 */
class IndexAction extends CAction
{
    public function run()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $recom = RecomExt::model()->getRecom('wapsytwlh',6)->findAll();
        $news = RecomExt::model()->getRecom('wapsyzxtj')->findAll();
        //取比展示的多一个，用于判断是否显示换一换按钮，但实际上多出的那一个不显示
        $specialHyh = $tuanHyh = $plotHyh = true;
        $limit1 = 4;
        $special = PlotSpecialExt::model()->normal()->recommend()->noExpire()->findAll(array('limit'=>$limit1));
        if(count($special)<$limit1) {
            $specialHyh = false;
        } else {
            $special = array_slice($special,0,$limit1-1);
        }
        $tuan = PlotTuanExt::model()->noExpire()->normal()->findAll(array('limit'=>$limit1,'order' => 'sort DESC,created DESC,updated DESC'));
        if(count($tuan)<$limit1) {
            $tuanHyh = false;
        } else {
            $tuan = array_slice($tuan,0,$limit1-1);
        }
        $limit2 = 5;
        $plot = PlotExt::model()->normal()->isNew()->findAll(array('limit'=>$limit2,'order' => 'sort DESC,recommend DESC ,open_time DESC'));
        if(count($plot)<$limit2) {
            $plotHyh = false;
        } else {
            $plot = array_slice($plot,0,$limit2-1);
        }
        $staff = StaffExt::model()->normal()->recommend()->find();
        $this->controller->pageDescription=SM::seoConfig()->wapIndexIndex()['desc'];
        $this->controller->render('index',array(
            'recom' => $recom,
            'special' => $special,
            'tuan' => $tuan,
            'plot' => $plot,
            'staff' => $staff,
            'specialHyh' => $specialHyh,
            'tuanHyh' => $tuanHyh,
            'plotHyh' => $plotHyh,
            'news' =>$news,
        ));
    }
}
