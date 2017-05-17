<?php

/**
 * 前台首页
 * @author SC
 * @date 2015-10-20
 */
class WendaController extends HomeController{

    public $layout = '/layouts/base_red';

    /**
     * 问答首页
     */
    public function actionIndex($kw='',$cid=''){
        $kw = $this->cleanXss($kw);
        if(Yii::app()->request->isPostRequest){
            $question = Yii::app()->request->getPost('question','');
            $name = Yii::app()->request->getPost('name','');
            $phone = Yii::app()->request->getPost('phone','');

            $askq = new AskExt();
            $askq -> question = $question;
            $askq -> name = $name;
            $askq -> phone = $phone;
            $askq -> created = time();
            if($askq->save()){
                $this->setMessage('提问成功！', 'success');
            }else{
                $this->setMessage('提问失败！', 'error');
            }
        }

        $reask = AskExt::model()->normal()->findAll(array('limit'=>10,'order'=>'views desc, id asc'));

        $cate = AskCateExt::model()->getAskCateMenu();


        if($kw)
        {
            $criteria = new XsCriteria(array(
                'query' => $kw,
                'facetsField' =>'status',
            ));
            $dataProvider = AskExt::model()->normal()->replyed()->newest()->getXsList('house_ask',$criteria,15);
        }
        else
        {
            $criteria = new CDbCriteria;
            if($cid!==''){
                $criteria->addCondition('cid = :cid');
                $criteria->params[':cid'] = $cid;
            }
            $dataProvider = AskExt::model()->normal()->newest()->replyed()->getList($criteria, 15);
        }

        $ask = $dataProvider->data;
        $pager = $dataProvider->pagination;

        $this->render('index',array(
            'kw'=>$kw,
            'cate'=>$cate,
            'cid'=>$cid,
            'ask'=>$ask,
            'pager'=>$pager,
            'reask'=>$reask,
        ));
    }

    /**
     * 问答详情页
     */
    public function actionDetail(){
        $id = Yii::app()->request->getParam('id','');
        $ask = AskExt::model()->normal()->findByPk($id);
        if(!$ask){
            $this->redirect('/home/wenda/index');
        }
        $ask->addViews();
        $reask = AskExt::model()->normal()->findAll(array('limit'=>10,'order'=>'views desc, id asc'));

        $cid = $ask->cid;
        if(isset($cid) && !empty($cid)){
            $criteria = new CDbCriteria();
            $criteria -> order = 'created desc';
            $criteria -> addCondition('cid = :cid');
            $criteria -> params[':cid'] = $cid;
            $asks = AskExt::model()->normal()->getList($criteria,5);
            $this->render('detail',array(
            'ask'=>$ask,
            'asks'=>$asks->data,
            'reask'=>$reask,
             ));
        }else{
             $this->render('detail',array(
            'ask'=>$ask,
            'reask'=>$reask,
             ));
        }
    }
}
