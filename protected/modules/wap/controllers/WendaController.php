<?php
/**
 * wap问答
 */
class WendaController extends WapController
{
    public function actions()
    {
        $alias = 'wap.controllers.wenda.';
        return array(
            'index' => $alias.'IndexAction',//问答列表
            'detail' => $alias.'DetailAction',//问答详情
            'deal' => $alias.'DealAction',//问题提交处理
            'ask' => $alias.'AskAction',//问题提交处理
        );
    }


    public function actionResult(){
        $hid = (int)Yii::app()->request->getParam('hid',0);
        $result = Yii::app()->request->getParam('result','');
        $msg = Yii::app()->request->getParam('msg','');
        $msg = $this->cleanXss($msg);
        $this->render('result',array(
                    'hid'=>$hid,
                    'rs' => $result,
                    'msg' => $msg,
        ));
    }

    /**
     * [actionAjaxGetWendas ajax获取问答列表]
     */
    public function actionAjaxGetWendas()
    {
        $hid = Yii::app()->request->getQuery('hid',0);
        $sort = Yii::app()->request->getQuery('sort','created');
        $cid = Yii::app()->request->getQuery('cid',0);
        $kw = Yii::app()->request->getQuery('kw','');
        $criteria = new CDbCriteria;
        if($hid)
        {
            $criteria->addCondition('hid=:hid');
            $criteria->params = array(':hid'=>$hid);
        }
        if($kw)
        {
            $criteria->addSearchCondition('question',$kw);
        }
        if($cid)
        {
            $askcate = AskCateExt::model()->find(array('condition'=>'id = :id','params'=>array(':id'=>$cid)));
            if($askcate->parent == 0){
                $pcate = AskCateExt::model()->findAll(array('condition'=>'parent=:parent','params'=>array(':parent'=>$cid)));
                $ids = array();
                foreach($pcate as $k => $v){
                    $ids[$k] = $v->id;
                }
                $criteria->addInCondition('cid',$ids);
            }else{
                $criteria->addCondition('cid = :cid');
                $criteria->params[':cid'] = $cid;
            }
        }
        $criteria->addNotInCondition('cid',array(0));
        $criteria->order = $sort.' desc';
        $dataprovider = AskExt::model()->normal()->getList($criteria,10);
        $data = array();
        foreach ($dataprovider->data as $key => $value) {
            $scate = $value->cate ? $value->cate->name : '';
            if($scate = $value->cate) {
                $fcate = $scate->parentCate ? $scate->parentCate->name : '';
                $scate = $scate->name;
            } else {
                $fcate = '';
                $scate = '';
            }

            $tmp = array(
                'link' => $this->createUrl('detail',array('id'=>$value['id'])),
                'wen' => $kw?str_replace($kw, '<em class="c-red">'.$kw.'</em>', $value['question']):$value['question'],
                'link2' => "#",//$hid?"#":$this->createUrl('index',array('cid'=>$fcate->id)),
                'menu2' => $fcate,
                'link3' => "#",//$hid?"#":$this->createUrl('index',array('cid'=>$scate->id)),
                'menu3' => $scate,
                'time' =>date('Y-m-d H:i',$value['created']),
                );
            $data['lists'][] = $tmp;
        }
        $data['totalPage'] = $dataprovider->pagination->pageCount;
        echo CJSON::encode($data);
    }
}
