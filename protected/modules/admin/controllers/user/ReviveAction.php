<?php
/**
 * 复活页面
 * 该页面仅在v2版中启用，并且需要在平均分单模式下才会出现
 * @author weibaqiu
 * @version 2016-07-19
 */
class ReviveAction extends CAction
{
    public function run($t='', $str='', $visit_status='', $progress='')
    {
        $criteria = new CDbCriteria();
        if($t=='name' && $str) {
            $criteria->addSearchCondition('name', $str);
        }
        if($t=='phone' && $str) {
            $criteria->addCondition('phone=:phone');
            $criteria->params[':phone'] = $str;
        }
        if($visit_status) {
            $criteria->addCondition('visit_status=:vs');
            $criteria->params[':vs'] = $visit_status;
        }
        $dataProvider = UserExt::model()->revive()->getList($criteria);

        //回访状态
        $visitStatusArr = array();
        foreach(UserExt::$visitStatus as $k=>$v)
        {
            if(UserExt::$syncUserStatus[$k]) $visitStatusArr[$k] = $v;
        }

        $this->controller->render('revive', [
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'visit_status' => $visit_status,
            'progress' => $progress,
            't' => $t,
            'str' => $str,
            'visitStatusArr' => $visitStatusArr,
        ]);
    }
}
