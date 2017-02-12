<?php
/**
 * 点赞接口
 * @author weibaqiu
 * @version 2016-06-07
 */
class PraiseAction extends CAction
{
    public function run($sid)
    {
        $sid = (int)$sid;
        $staff = StaffExt::model()->findByPk($sid);
        $cookie = Yii::app()->request->getCookies();
        if(!isset($cookie['adviser_praise'.$sid])&&$staff&&$staff->saveCounters(array('praise'=>1))) {
            $cookie = new CHttpCookie('adviser_praise'.$sid, $staff->praise, ['expire'=>time()+7200]);
            Yii::app()->request->cookies['adviser_praise'] = $cookie;
            $this->controller->response(1, $staff->praise);
        }
        $this->controller->response(0,'您已经赞过啦');
    }
}
