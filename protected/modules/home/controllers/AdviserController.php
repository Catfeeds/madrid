<?php
/**
 * 买房顾问相关
 * @author weibqiu
 * @date 2015-12-15
 */
class AdviserController extends HomeController
{
    /**
     * 买房顾问页面
     */
    public function actionIndex()
    {
        $staffs = StaffExt::model()->normal()->recommend()->findAll(array(
            'limit' => 4,
        ));
        $orders = OrderExt::model()->findAll(array(
            'limit'=>15,
            'order'=>'t.id desc',
        ));
        $this->render('index', array(
            'staffs' => $staffs,
            'orders' => $orders,
        ));
    }

    /**
     * 隐藏用户全名
     * @param  string $name 用户全名
     * @return 格式化后的姓名
     */
    protected function hideName($name)
    {
        if($name=='')
            return '匿名';
        // $strlen = mb_strlen($name, 'utf-8');
        $firstStr = mb_substr($name, 0, 1, 'utf-8');
        return $firstStr . str_repeat('*', 2);
    }

    /**
     * 点赞
     * @param $sid
     * @throws CException
     */
    public function actionPraise($sid)
    {
        $sid = (int)$sid;
        $staff = StaffExt::model()->findByPk($sid);
        $cookie = Yii::app()->request->getCookies();
        if(!isset($cookie['adviser_praise'.$sid])&&$staff&&$staff->saveCounters(array('praise'=>1))) {
            $cookie = new CHttpCookie('adviser_praise'.$sid, $staff->praise, ['expire'=>time()+7200]);
            Yii::app()->request->cookies['adviser_praise'] = $cookie;
            $this->response(1, $staff->praise);
        }
        $this->response(0,'您已经赞过啦');
    }
}
