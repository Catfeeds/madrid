<?php
/**
 * 二手房配置
 * @author steven.allen <[<email address>]>
 * @date(2016.11.28)
 */
class SetAction extends CAction
{
	public function run($type)
	{
		try{
            $model = SM::$type();
        }catch(Exception $e) {
            throw new CHttpException(500, '参数不正确');
        }

        if(Yii::app()->request->getIsPostRequest() && $postData = Yii::app()->request->getPost(get_class($model), null)) {
            $model->attributes = $postData;
            if($model->save()) {
                $this->controller->setMessage('保存成功', 'success');
            } else {
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败！';
                $this->controller->setMessage($msg, 'error');
            }
        }

        $this->controller->render('/resoldSiteConfig/sitesetting', ['model'=>$model]);
	}
}