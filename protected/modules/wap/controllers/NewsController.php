<?php
/**
 * 资讯
 */
class NewsController extends WapController
{
    public function actions()
    {
        $alias = 'wap.controllers.news.';
        return array(
            'index' => $alias.'ListAction',//新版资讯列表
            'detail' => $alias.'DetailAction',//新版资讯详情
        );
    }

    /**
     * ajax获取资讯列表
     */
    public function actionAjaxGetNewsList()
    {
        $criteria = new CDbCriteria([
            'condition' => 'show_time<:time',
            'params' => [':time'=>time()]
        ]);
        if($cid = Yii::app()->request->getQuery('cid',0))
        {
            $criteria->addCondition('t.cid=:cid');
            $criteria->params[':cid'] = $cid;
        }
        if($hid = Yii::app()->request->getQuery('hid',0))
        {
            $criteria->join = 'left join article_plot_rel pr on t.id=pr.aid ';
            $criteria->addCondition('pr.hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        $dataProvider = ArticleExt::model()->normal()->noDel()->newest()->getList($criteria,10);
        $data = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $formed = array();
        foreach ($data as $key => $value) {
            $tmp["link"] = $this->createUrl('detail',array('id'=>$value->id));
            $tmp["title"] = $value['title'];
            $tmp["pic"] = ImageTools::fixImage($value['image']);
            $tmp["detail"] = $value->getDescription();
            $tmp['source'] = $value->source?$value->source:SM::urmConfig()->cityName();
            $tmp['time'] = Tools::friendlyDate($value->show_time);
            $tmp['ad'] = $value->isAd ? '广告' : '';
            $formed[] = $tmp;
        }
        echo CJSON::encode(array('lists' => $formed,'totalPage' => $pager->pageCount));
    }


}
