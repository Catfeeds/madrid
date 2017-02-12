<?php
/**
 *
 * User: jt
 * Date: 2016/10/28 11:14
 */

class ResoldHelpController extends AdminController{

    public function actionIndex($title=''){
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'order'=>'updated desc , created desc',
        ));
        if($title){
            $criteria->addSearchCondition('title',$title);
        }
        $dataProvider = ResoldHelpExt::model()->getList($criteria);
        $this->render('index',array('dataProvider'=>$dataProvider));
    }

    public function actionEdit($id=''){
        $model = $id === '' ? new ResoldHelpExt() : ResoldHelpExt::model()->findByPk($id);
        if(Yii::app()->request->isPostRequest && $post = Yii::app()->request->getPost('ResoldHelpExt')){
                $model->attributes = $post;
                if($model->save()){
                    $this->setMessage('提交成功！','success',true);
                }
                $this->setMessage('提交失败！','error',Yii::app()->request->urlReferrer);
        }
        $this->render('edit',array('model'=>$model));
    }

    public function actionAjaxDel(){
        if(Yii::app()->request->isAjaxRequest && $id = Yii::app()->request->getPost('id')){
            $resold_help = ResoldHelpExt::model()->findByPk($id);
            if(!$resold_help)
                $this->setMessage('帮助不存在！','error');
            if($resold_help->delete())
                $this->setMessage('删除成功！','success');
            $this->setMessage('删除失败！','error');
        }
    }
}