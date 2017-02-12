<?php
/**
 * 定时清理中介预约记录
 * liyu
 * 没半个执行一次
 */
class AppointCommand extends CConsoleCommand{
    public function actionClearAppoint(){
        $time = strtotime('-15 day');//半月 15 天之前
        try{
            $criteria = new CDbCriteria;
            $criteria->addCondition('created<:created');
            $criteria->params[':created'] = $time;
            ResoldAppointExt::model()->enabled()->deleteAll($criteria);
        }catch(Exception $e) {
            echo $e->getMessage() . "\n";
            return false;
        }


    }
}
