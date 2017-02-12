<?php
/**
 * wap特惠团首页
 */
class PurchaseController extends WapController
{
    public function actions()
    {
        $alias = 'wap.controllers.purchase.';
        return array(
            'index' => $alias.'IndexAction',
            'change' => $alias.'ChangeAction',//换一换接口
        );
    }

    /**
     * [actionAjaxGetPurchases ajax获取特惠团]
     */
    public function actionAjaxGetPurchases()
    {
        $criteria = new CDbCriteria(array(
            'order' => 'sort DESC,created DESC',
        ));
        $dataProvider = PlotTuanExt::model()->normal()->noExpire()->getList($criteria,10);
        $tuan = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $data = array();
        $data['totalPage'] =  $pager->pageCount;
        if($tuan)
        {
            foreach ($tuan as $key => $value) {
                $tmp = array(
                    'pic'=>ImageTools::fixImage($value->wap_img,168,126),
                    'link'=>$this->createUrl('plot/index',['py'=>$value->plot->pinyin,'md'=>'tht']),
                    'title'=>$value->s_title,
                    'name'=>$value->plot->title,
                    'price'=>PlotPriceExt::getPrice($value->plot->price,$value->plot->unit),
                    'num'=>$value->getTuanNum(),
                    'over'=>floor(($value->end_time - time())/86400).'天'.floor(($value->end_time - (time() + (floor(($value->end_time - time())/86400))*86400))/3600).'小时'.floor( ($value->end_time - (time() + floor(($value->end_time - time())/86400)*86400 + floor(($value->end_time - (time() + (floor(($value->end_time - time())/86400))*86400))/3600)*3600 ))/60).'分钟后结束',
                    );
                $data['lists'][] = $tmp;
            }
        }
        echo CJSON::encode($data);
    }
}
