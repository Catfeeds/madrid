<?php
class ResoldTagEditAction extends CAction
{
    public function run($id=0,$cate='')
    {
    	$model = $id ? TagExt::model()->findByPk($id) : new TagExt;
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('TagExt', array());
            if($model->save())
                $this->controller->setMessage('保存成功', 'success', array('resoldTag'));
            else
                $this->controller->setMessage('保存失败', 'error');
        }

        if($id<=0 && (isset(TagExt::$resoldCate['direct'][$cate])||isset(TagExt::$resoldCate['range'][$cate]))) {
            $model->cate = $cate;
        }
        $dropDownListCates = $model->getIsDirectTag() ? TagExt::$resoldCate['direct'] : TagExt::$resoldCate['range'];

        $this->controller->render('resoldTagEdit', array(
            'model' => $model,
            'dropDownListCates' => $dropDownListCates,
        ));
    }
}
