<?php
/**
 * 报错信息
 */
class ErrorController extends RestController{

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if (!$error)
        {
            $error['code'] = '500';
            $error['message'] = '发生未知错误';
        }
        //Yii::log($error['code'].':'.$error['message'].':'.Yii::app()->request->requestUri,CLogger::LEVEL_ERROR,'error');
        $msg = array('error' => $error['message']);
        echo CJSON::encode($msg);
        Yii::app()->end();
    }
}
