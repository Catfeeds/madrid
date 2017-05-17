<?php
/**
 * 分站配置
 * @author weibaqiu
 * @date 2015-12-30
 */
class SubstationController extends AdminController
{
    /**
     * 列表
     */
    public function actionList()
    {
        $dataProvider = SubstationExt::model()->getList(array(),10);
        $data = $dataProvider->data;
        $pager = $dataProvider->pagination;
        $this->render('list', array(
            'data' => $data,
            'pager' => $pager,
        ));
    }

    /**
     * 添加\编辑
     */
    public function actionEdit($id=0)
    {
        $model = $id ? SubstationExt::model()->findByPk($id) : new SubstationExt;
        if(Yii::app()->request->isPostRequest){
            $model->attributes = Yii::app()->request->getPost('SubstationExt', array());
            if($model->save()){
                $this->setMessage('保存成功','success', array('/admin/substation/list'));
            }else{
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败';
                $this->setMessage($msg,'error');
            }
        }

        $areaArr = AreaExt::model()->normal()->parent()->findAll();
        $areaArr = $areaArr ? CHtml::listData($areaArr,'id','name') : array('--请先添加区域--');
        $this->render('edit', array(
            'model' => $model,
            'areaArr' => $areaArr,
        ));
    }

    /**
     * ajax提交删除
     */
    public function actionAjaxDel()
    {
        if(Yii::app()->request->isPostRequest){
            $id = Yii::app()->request->getPost('id',0);
            $model = SubstationExt::model()->findByPk($id);
            if($model&&$model->delete()){
                $this->setMessage('删除成功！','success');
            }else{
                $this->setMessage('删除失败！','error');
            }
        }
    }
}
