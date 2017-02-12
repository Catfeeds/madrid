<?php
/**
 * 用户相关控制器
 * @author weibaqiu
 * @date 2015-09-12
 */
class UserController extends AdminController
{
    public function actions()
    {
        $alias = 'admin.controllers.user.';
        return array(
            'revive'=>$alias.'ReviveAction',//复活页面，将买房顾问标记为失效和休眠的用户列在这，等待重新激活分配
        );
    }

    /**
     * 用户列表
     */
    public function actionList($t='',$str='',$yxlpsj='',$visit_status='',$staff_status='',$progress='',$yxlp='',$export=0)
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.`id`,t.`phone`,t.`name`,t.`visit_status`,t.`staff_status`,t.`created`,t.`progress`,t.`new_order`,t.`staff_id`',
            'order' => 't.new_order desc,t.visit_status asc,created desc',
            'group' => 't.`phone`'
        ));
        if(in_array($t, array('phone','name','qq')) && $str!='')
            $criteria->addSearchCondition($t, $str.'%', false);
        //意向楼盘
        $initValue = '';
        $dataInit = array();
        if($yxlp!='')
        {
            //意向楼盘条件
            $yxlp = implode(',', explode(',',$yxlp));//防止可能的注入
            $plot = PlotExt::model()->findAll('id in('.$yxlp.')');
            foreach($plot as $k=>$v)
            {
                $initValue .= $k ? ','.$v->id : $v->id;
                $dataInit[] = array('id'=>$v->id, 'text'=>$v->title);
            }
            $criteria->join = 'INNER JOIN `user_plot_rel` `yxlp` ON `yxlp`.`phone`=`t`.`phone`';
            $criteria->addCondition('`yxlp`.hid in('.$yxlp.')');

            //意向时间条件
            $yxlpsjArr = explode('-', $yxlpsj);
            $beginTime = isset($yxlpsjArr[0])&&$yxlpsjArr[0] ? trim($yxlpsjArr[0]) : '';
            $endTime = isset($yxlpsjArr[1])&&$yxlpsjArr[1] ? trim($yxlpsjArr[1]) : '';
            if($beginTime && $endTime){
                $criteria->join .= ' AND `yxlp`.`created`>=:begintime AND `yxlp`.`created`<:endtime';
                $criteria->params[':begintime'] = strtotime($beginTime);
                $criteria->params[':endtime'] = strtotime($endTime)+86400;
            }
        }
        if($visit_status!='')
        {
            $criteria->addCondition('visit_status=:visit_status');
            $criteria->params[':visit_status'] = $visit_status;
        }
        if($staff_status!='')
        {
            $criteria->addCondition('staff_status=:staff_status');
            $criteria->params[':staff_status'] = $staff_status;
        }
        if($progress!='')
        {
            $criteria->addCondition('progress=:progress');
            $criteria->params[':progress'] = $progress;
        }
        //导出用户列表，excel表
        if($export == 1)
        {
            $this->exportExcel($criteria);
        }
        //导出添加用户表，excel表
        if($export == 2)
        {
            ExcelHelper::write_browser(date('YmdHis'),['姓名','电话','订单来源类型','订单备注信息','性别','QQ','微信号','微信验证是否通过','住址','房源类型','意向楼盘','意向区域','关注点','其他关注点','意向购买时间','户型面积(填写数字，单位：平方)','购房预算(填写数字，单位：万)','看房邀请','备注信息','购房进度'],[]);
        }
        $dataProvider = UserExt::model()->getList($criteria);

        $user = new UserExt;

        $visitStatusArr = array();
        foreach(UserExt::$visitStatus as $k=>$v)
        {
            if(UserExt::$syncUserStatus[$k]) $visitStatusArr[$k] = $v;
        }

        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            't' => $t,
            'str' => $str,
            'yxlpsj' => $yxlpsj,
            'visit_status' => $visit_status,
            'staff_status' => $staff_status,
            'progress' => $progress,
            'initValue' => $initValue,
            'dataInit' => $dataInit,
            'user' => $user,
            'visitStatusArr' => $visitStatusArr,
        ));
    }

    /**
     * 添加用户
     */
    public function actionAdd()
    {
        $user = new UserExt;
        if(Yii::app()->request->isPostRequest)
        {
            // var_dump(Yii::app()->request->getPost('UserExt', array()));exit;
            $user->attributes = Yii::app()->request->getPost('UserExt', array());

            if($user->save())
            {
                $user->addYxlp();
                $user->addYxqy();
                $this->setMessage('添加成功！','success',array('list'));
            }
            else
                $this->setMessage('添加失败','error');
        }
        $this->render('add', array(
            'user' => $user,
        ));
    }

    /**
     * 用户详细信息modal页，包括订单、管家信息等
     * @param  integer $phone 手机号码
     */
    public function actionDetail($phone)
    {
        $this->layout = '/layouts/modal_base';
        $user = UserExt::model()->find('phone=:phone', array(':phone'=>$phone));

        //意向楼盘
        $yxlpData = $user->getYxlp();
        $yxlpArr = array();
        $yxlpValue = '';
        foreach($yxlpData as $k=>$v)
        {
            $yxlpValue .= $k ? ','.$v->id : $v->id;
            $yxlpArr[] = array('id'=>$v->id, 'text'=>$v->title);
        }

        //意向区域
        $yxqyData = $user->getYxqy();
        $yxqyArr = array();
        $yxqyValue = '';
        foreach($yxqyData as $k=>$v)
        {
            $yxqyValue .= $k ? ','.$v->id : $v->id;
            $yxqyArr[] = array('id'=>$v->id, 'text'=>$v->name);
        }

        $userLog = new UserLogExt;
        $this->render('detail', array(
            'user' => $user,
            'userLog' => $userLog,
            'yxlpArr' => $yxlpArr,
            'yxlpValue' => $yxlpValue,
            'yxqyArr' => $yxqyArr,
            'yxqyValue' => $yxqyValue,
        ));
    }

    /**
     * 用户信息编辑提交处理
     */
    public function actionEdit()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $id = Yii::app()->request->getPost('id', 0);
            $model = UserExt::model()->findByPk($id);
            $model->attributes = Yii::app()->request->getPost('UserExt', array());
            $model->addYxlp();
            $model->addYxqy();
            if($model->save())
                $this->setMessage('保存成功！', 'success', $this->createUrl('detail', array('phone'=>$model->phone,'#'=>'tab_2')));
            else
                $this->setMessage('保存失败！', 'error', $this->createUrl('detail', array('phone'=>$model->phone,'#'=>'tab_2')));
        }
    }

    /**
     * 用户订单列表
     * @param  integer $phone 手机号
     */
    public function actionAjaxOrderList($phone,$page=1)
    {
        //因为两处删除订单的地方使用的提示消息是setMessage，为了消除没有显示的flash，所以在这里进行删除
        Yii::app()->user->getFlash('success');

        $this->layout = false;
        $criteria = new CDbCriteria(array(
            'condition' => 'phone=:phone',
            'params' => array(':phone' => $phone),
            'order' => 'id desc',
        ));
        $dataProvider = OrderExt::model()->getList($criteria,10);
        $data = $dataProvider->data;
        $more = $dataProvider->pagination->currentPage+1<$dataProvider->pagination->pageCount;

        foreach($data as $v){
            if(in_array($v->spm_b, OrderExt::$type['PlotExt'])){
                $spmIds[] = $v->spm_c;
            }
        }
        $spmInfo = array();
        if(isset($spmIds)&&$spmIds){
            $criteria = new CDbCriteria(['index'=>'id']);
            $criteria->addInCondition('id', $spmIds);
            $spmInfo = PlotExt::model()->findAll($criteria);
        }

        $html = $this->render('orderlist', array(
            'data' => $data,
            'page' => $page,
            'pager' => $dataProvider->pagination,
            'more' => $more,
            'spmInfo' => $spmInfo,
            'phone' => $phone,
        ), true);
        if($page==1)
            echo $html;
        else
            $this->response($more, $html);
    }

    /**
     * 用户流水列表
     * @param  integer $phone 手机号
     */
    public function actionAjaxLogList($phone, $page=1)
    {
        $this->layout = false;
        $criteria = new CDbCriteria(array(
            'condition' => 'phone=:phone',
            'params' => array(':phone'=>$phone),
            'order' => 'id desc',
        ));
        $dataProvider = UserLogExt::model()->getList($criteria, 10);
        $data = $dataProvider->data;
        $more = $dataProvider->pagination->currentPage+1<$dataProvider->pagination->pageCount;
        $html = $this->render('loglist', array(
            'data' => $data,
            'page' => $page,
            'pager' => $dataProvider->pagination,
            'more' => $more,
            'phone' => $phone,
        ), true);
        if($page==1)
            echo $html;
        else
            $this->response($more, $html);
    }

    /**
     * ajax提交流水信息
     */
    public function actionAjaxLog()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $session = Yii::app()->session;
            if(!isset($session['ajaxLog'])||isset($session['ajaxLog'])&&$session['ajaxLog']+3<time()){
                $session['ajaxLog'] = time();
            }else{
                $this->response(false,'提交太快请休息一下^_^');
            }
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model = new UserLogExt('adminLog');
                Yii::import('application.components.jike.*');
                $model->attributes = Yii::app()->request->getPost('UserLogExt', array());
                $userLog = new JikeUserLog($model);

                //选择的是分配的选项
                if($model->visit_status == UserExt::$assignValue){
                    $staff = StaffExt::model()->normal()->findByPk(Yii::app()->request->getPost('staff_id', 0));
                    $rand = (int)Yii::app()->request->getPost('rand', 0);

                    if($rand==0 && $staff==null) {//指定分配但管家查找不到
                        $model->addError('visit_status','选择的买房顾问无效');
                    } else {//正常逻辑
                        $userAssign = new JikeUserAssign($model->user, ($rand>0 || empty($staff)) ? null : $staff);
                        $userAssign->userLog = $userLog;
                        $userAssign->assign(true);
                    }

                }

                if(!$userLog->writeLog())
                    throw new CException(current(current($model->getErrors())));
                $transaction->commit();
                $this->response(true, '保存成功！');
            }
            catch(CException $e)
            {
                $transaction->rollback();
                $this->response(false, $e->getMessage());
            }
        }
    }

    /**
     * ajax提交分配管家
     */
    public function actionAjaxAssign()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $phone = Yii::app()->request->getPost('phone', 0);
            $sid = Yii::app()->request->getPost('sid', 0);
            $user = UserExt::model()->find('phone=:phone', array(':phone'=>$phone));
            $staff = StaffExt::model()->findByPk($sid);
            if($user && $user->assign($staff))
                $this->response(true, '分配成功！');
            else
                $this->response(false, '分配失败！');
        }
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
        $data = UserExt::model()->findAll($criteria);
        //excel列名
        $fileds = array('id','姓名(性别)','电话','QQ','住址','房源类型','意向楼盘','意向区域','关注点','意向购买时间','户型面积','购房预算','回访状态','买房顾问','看房状态','购房进度','看房邀请','备注','最新流水');
        $content = array();
        $gmsjArr = CHtml::listData(TagExt::model()->normal()->getTagByCate('gmsj')->findAll(),'id','name');
        foreach($data as $user)
        {
            $gender = isset(UserExt::$gender[$user->gender]) ? UserExt::$gender[$user->gender] : '未知';
            $roomType = isset(UserExt::$roomType[$user->room_type]) ? UserExt::$roomType[$user->room_type] : '-';
            $yxlp = $yxqy = $concern = array();
            foreach($user->yxlp as $v)
            {
                $yxlp[] = $v->title;
            }
            $yxlp = $yxlp ? implode(',', $yxlp) : '-';
            foreach($user->yxqy as $v)
            {
                $yxqy[] = $v->name;
            }
            $logContent = isset($user->latestLog->content)?$user->latestLog->content:'-';
            $yxqy = $yxqy ? implode(',', $yxqy) : '-';
            foreach($user->concern as $v)
            {
                if(isset(UserExt::$concern[$v])) $concern[] = UserExt::$concern[$v];
            }
            if($user->concern_remark) $concern[] = '其他：'.$user->concern_remark;
            $concern = $concern ? implode(',',$concern) : '-';
            $intentTime = isset($gmsjArr[$user->intent_time]) ? $gmsjArr[$user->intent_time] : '-';
            $size = $user->size ? $user->size.'平米' : '-';
            $budget = $user->budget ? $user->budget.'万' : '-';
            $visitStatus = isset(UserExt::$visitStatus[$user->visit_status]) ? UserExt::$visitStatus[$user->visit_status] : '-';
            $staff = $user->staff ? $user->staff->username."(id:{$user->staff->id})" : '-';
            $staffStatus = isset(UserExt::$staffStatus[$user->staff_status]) ? UserExt::$staffStatus[$user->staff_status] : '-';
            $progress = isset(UserExt::$progress[$user->progress]) ? UserExt::$progress[$user->progress] : '-';
            $notice = isset(UserExt::$takeNotice[$user->take_notice]) ? UserExt::$takeNotice[$user->take_notice] : '-';
            $content[] = array($user->id,$user->name."({$gender})",$user->phone,$user->qq,$user->address,$roomType,$yxlp,$yxqy,$concern,$intentTime,$size,$budget,$visitStatus,$staff,$staffStatus,$progress,$notice,$user->note,$logContent);
        }
        unset($data);
        ExcelHelper::write_browser(date('YmdHis'),$fileds,$content);
        Yii::app()->end();
    }
}
