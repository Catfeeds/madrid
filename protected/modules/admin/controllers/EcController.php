<?php
/**
 * 电商管理
 * @author weibaqiu
 * @date 2015-09-22
 */
class EcController extends AdminController
{
    /**
     * 电商列表
     */
    public function actionList($t='', $str='', $time='', $staff_status='', $progress='',$staff=0,$export=0)
    {
        $criteria = new CDbCriteria(array(
            'order' => 'new_log desc',
        ));
        if($time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition('assign_time>=:beginTime');
            $criteria->addCondition('assign_time<:endTime');
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;
        }
        if($t=='name'&&$str!='')
            $criteria->addSearchCondition('t.name', $str);
        if($t=='phone'&&$str!='')
            $criteria->addSearchCondition('t.phone', $str);
        if($staff_status!='')
        {
            $criteria->addCondition('t.staff_status=:staff_status');
            $criteria->params[':staff_status'] = $staff_status;
        }
        if($progress!='')
        {
            $criteria->addCondition('progress=:progress');
            $criteria->params[':progress'] = $progress;
        }
        if($staff)
        {
            $criteria->addCondition('t.staff_id=:staff');
            $criteria->params[':staff'] = $staff;
        }
        if($export==1) {
            $this->exportExcel($criteria);
            Yii::app()->end();
        }
        $dataProvider = UserExt::model()->assigned()->getList($criteria, 15);

        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            't' => $t,
            'str' => $str,
            'time' => $time,
            'progress' => $progress,
            'staff_status' => $staff_status,
            'staff' => $staff,
        ));
    }

    /**
     * 用户详细页
     */
    public function actionDetail($phone)
    {
        $this->layout = '/layouts/modal_base';
        $criteria = new CDbCriteria(array(
            'condition' => 'phone=:phone',
            'params' => array(':phone'=>$phone),
        ));
        $user = UserExt::model()->find($criteria);
        $this->render('detail', array(
            'user' => $user,
        ));
    }

    /**
     * 导出excel文件
     * @param  CDbCriteria $criteria 查询条件对象
     */
    private function exportExcel(CDbCriteria $criteria)
    {
        set_time_limit(0);
        $criteria->select = '*';
        $criteria->limit = 3000;//限制最多3000
        $data = UserExt::model()->assigned()->findAll($criteria);
        //excel列名
        $fileds = array('用户id','姓名（性别）','电话','看房状态','最新流水记录','买房顾问','购房进度','分配时间','最新流水时间');
        $content = array();
        $gmsjArr = CHtml::listData(TagExt::model()->normal()->getTagByCate('gmsj')->findAll(),'id','name');
        foreach($data as $user)
        {
            $gender = isset(UserExt::$gender[$user->gender]) ? UserExt::$gender[$user->gender] : '未知';
            $zuixinliushui = $user->newStaffLog ? $user->newStaffLog->content : '无';
            $maifangguwen = $user->staff ? $user->staff->username : '无';
            $goufangjindu = UserExt::$progress[$user->progress];
            $fenpeishijian = date('Y-m-d H:i:s', $user->assign_time);
            $zuixinliushuishijian = $user->new_log ? date('Y-m-d H:i:s', $user->new_log) : '无';

            $content[] = array($user->id,$user->name."({$gender})",$user->phone,UserExt::$staffStatus[$user->staff_status],$zuixinliushui,$maifangguwen,$goufangjindu,$fenpeishijian,$zuixinliushuishijian);
        }
        unset($data);
        ExcelHelper::write_browser(date('YmdHis'),$fileds,$content);
        Yii::app()->end();
    }
}
?>
