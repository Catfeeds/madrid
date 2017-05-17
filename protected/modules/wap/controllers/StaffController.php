<?php
/**
 * 管家后台
 * @author weibaqiu
 * @date 2015-11-02
 */
class StaffController extends WapController
{
    /**
     * 当前登录管家实例
     * @var StaffExt
     */
    public $staff;

    /**
     * 访问控制过滤器
     * @return array
     */
    public function filters()
    {
        return array(
            'accessControl - login,logout',
            'layout'
        );
    }

    /**
     * 布局过滤器
     */
    public function filterLayout($filterChain)
    {
        $this->layout = '/staff/layout';
        $filterChain->run();
    }

    /**
     * 访问控制规则
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?')
            ),
        );
    }

    /**
     * 管家登录页
     */
    public function actionLogin()
    {
        $this->pageTitle = '购房管家登录';
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }
        $loginForm = new StaffLoginForm;
        if (Yii::app()->request->isPostRequest) {
            $loginForm->attributes = $_POST;
            if ($loginForm->validate() && $loginForm->login()) {
                $this->redirect(array('index'));
            } else {
                $this->setMessage('用户名或密码错误！', 'info', array('login'));
            }
        }
        $this->render('login', array(
            'loginForm' => $loginForm,
        ));
    }

    /**
     * 退出登录
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }

    /**
     * 管家首页
     */
    public function actionIndex()
    {
        $staff = StaffExt::model()->findByPk(Yii::app()->user->id);
        if (!$staff) {
            throw new Exception('帐号不存在！');
        }
        //两条sql获取各状态用户的标识信息
        $info = array();
        $staffStatus = array_keys(UserExt::$staffStatus);
        $criteria = new CDbCriteria(array(
            'select' => 'count(id) as count,staff_status',
            'group' => 'staff_status',
            'index' => 'staff_status',
        ));
        $criteria->addInCondition('staff_status', $staffStatus);
        $num = UserExt::model()->getByStaff($staff->id)->findAll($criteria);
        $markNew = UserExt::model()->getByStaff($staff->id)->markNew()->findAll($criteria);
        foreach ($staffStatus as $v) {
            $flag = false;//记录是否有新的未看订单
            $users = UserExt::model()->with('lastOrderTime')->findAll(
                'staff_id=:staffId and staff_status=:status',
                array(":staffId" => $staff->id, ':status' => $v)
            );
            foreach ($users as $user) {
                $data_conf = $user->data_conf;
                if ($user->lastOrderTime&&$user->lastOrderTime->created > $data_conf['viewTime']) {
                    $flag = true;
                    break;
                }
            }
            $info[$v] = array(
                'num' => isset($num[$v]) ? $num[$v]->count : 0,
                'new' => isset($markNew[$v]) ? true : false,
                'newOrder' => $flag
            );
        }

        $this->render('index', array(
            'staff' => $staff,
            'info' => $info,
        ));
    }

    /**
     * 管家客户列表页
     * @param integer $status 管家状态，必须是{@see UserExt::$staffStatus}中的值
     */
    public function actionList($status = '', $kw = '', $page = 0)
    {
        $this->backUrl = $this->createUrl('index');
        $this->pageTitle = '用户列表';
        $criteria = new CDbCriteria(array(
            'order' => 'mark_new desc,assign_time desc',
        ));
        $user = UserExt::model()->getByStaff(Yii::app()->user->id);
        if ($kw !== '') {
            $this->pageTitle = $kw;
            $criteria->addSearchCondition('name', $kw);
            $criteria->addSearchCondition('phone', $kw, true, 'OR');
        }
        if ($status !== '') {
            $this->pageTitle = UserExt::$staffStatus[$status];
            $user = $user->getByStaffStatus($status);
        }
        $dataProvider = $user->getList($criteria);
        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'page' => $page,
            'status' => $status,
        ));
    }

    /**
     * 用户详细
     * @param  integer $phone 用户手机号
     */
    public function actionDetail($phone, $status = 0, $page = 0)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'phone=:phone',
            'params' => array(':phone' => $phone)
        ));
        $user = UserExt::model()->getByStaff(Yii::app()->user->id)->find($criteria);
        $this->backUrl = $this->createUrl('list', ['status' => $status, 'page' => $page]);
        $model = new UserLogExt('staffLog');
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('UserLogExt', array());
            Yii::import('application.components.jike.*');
            $jikeUserLog = new JikeUserLog($model);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $jikeUserLog->writeLog();
                if ($model->hasErrors()) {
                    throw new Exception(current(current($model->getErrors())));
                }
                $transaction->commit();
                $this->setMessage('保存成功！', 'info', ['detail', 'phone' => $phone, 'status' => $status, 'page' => $page]);
            } catch (Exception $e) {
                $transaction->rollback();
                $this->setMessage($e->getMessage(), 'info');
            }
        }
        $staffStatus = array();
        foreach (UserExt::$staffStatus as $k => $v) {
            $staffStatus[] = $v . '|' . $k;
        }
        $criteria->order = 'created desc';
        $log = UserLogExt::model()->findAll($criteria);
        $user->setViewTime();

        $this->render('detail', array(
            'user' => $user,
            'model' => $model,
            'log' => $log,
            'staffStatus' => $staffStatus,
            'status' => $status,
            'page' => $page,
        ));
    }

    /**
     * 楼盘登记
     * @param  integer $uid 用户id
     */
    public function actionAdd($phone, $status = 0, $page = 0, $id = 0)
    {
        $this->backUrl = $this->createUrl('detail', ['phone' => $phone, 'status' => $status, 'page' => $page]);
        //需要是分配给当前登录管家的用户
        $user = UserExt::model()->getByStaff(Yii::app()->user->id)->exists('phone=:phone', ['phone' => $phone]);
        if (!$user) {
            throw new Exception("无效的用户！");
        }
        $model = $id ? StaffCheckExt::model()->findByPk($id) : new StaffCheckExt;
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('StaffCheckExt', array());
            $model->phone = $phone;
            $model->sid = Yii::app()->user->id;
            // $model->hid = 1680;
            if ($model->save()) {
                $this->setMessage('保存成功！', 'info', array('detail', 'phone' => $phone, 'status' => $status, 'page' => $page));
            } else {
                $this->setMessage('保存失败！', 'info');
            }
        }
        $this->render('add', array(
            'model' => $model,
            'id' => $id,
        ));
    }

    /**
     * 添加意向楼盘(只可以添加，不可以修改)
     */
    public function actionAddMind($phone, $status = 0, $page = 0, $id = 0)
    {
        $this->backUrl = $this->createUrl('detail', ['phone' => $phone, 'status' => $status, 'page' => $page]);
        //需要是分配给当前登录管家的用户
        $user = UserExt::model()->getByStaff(Yii::app()->user->id)->exists('phone=:phone', ['phone' => $phone]);
        if (!$user) {
            throw new Exception("无效的用户！");
        }
        $model = new UserPlotRelExt();
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('UserPlotRelExt', array());
            $model->phone = $phone;
            //判断意向楼盘是否已存在
            if (UserPlotRelExt::model()->find('hid=:hid and phone=:phone', [':hid' => $model->hid, ':phone' => $model->phone])) {
                $this->setMessage('保存成功！', 'info', array('detail', 'phone' => $phone, 'status' => $status, 'page' => $page));
            }
            if ($model->save()) {
                $this->setMessage('保存成功！', 'info', array('detail', 'phone' => $phone, 'status' => $status, 'page' => $page));
            } else {
                $this->setMessage('保存失败！', 'info');
            }
        }
        $this->render('addMind', array(
            'model' => $model,
            'id' => $id
        ));
    }

    /**
     * ajax删除登记楼盘信息
     */
    public function actionAjaxDelCheck()
    {
        if (Yii::app()->request->isPostRequest) {
            $row = StaffCheckExt::model()->find('sid=:sid and id=:id', array(':sid' => Yii::app()->user->id, ':id' => Yii::app()->request->getPost('id', 0)));
            if ($row && $row->delete()) {
                Yii::app()->user->setFlash('info', '删除成功！');
                $this->response(true, '删除成功！');
            } else {
                $this->setMessage('删除失败！', 'info');
            }
        }
    }

    /**
     * ajax获取楼盘
     * @param  string $kw 搜索关键词
     */
    public function actionAjaxSearchPlot($kw)
    {
        $criteria = new CDbCriteria(array(
            'select' => 'id,title,star,data_conf',
        ));
        $criteria->addSearchCondition('title', $kw);
        $plots = PlotExt::model()->isNew()->isCoop()->normal()->findAll($criteria);
        $this->renderPartial('_searchPlot', array(
            'plots' => $plots,
        ));
    }

    /**
     * ajax获得区域楼盘
     */
    public function actionAjaxGetAreaPlot($area, $page = 1)
    {
        $criteria = new CDbCriteria(array(
            'select' => 'id,title,star,data_conf',
            'condition' => 'area=:area',
            'params' => array(':area' => $area)
        ));
        $dataProvider = PlotExt::model()->isNew()->isCoop()->normal()->getList($criteria, 3);
        $plots = $dataProvider->data;
        $pager = $dataProvider->pagination;
        if ($page > 1 && $page > $pager->pageCount) {
            die;
        }//不要无限返回
        $this->renderPartial('_areaPlot', array(
            'plots' => $plots,
            'pager' => $pager
        ));
    }

    /**
     * ajax 删除意向楼盘
     */
    public function actionAjaxDelMind()
    {
        if (Yii::app()->request->isPostRequest) {
            $row = UserPlotRelExt::model()->find('id=:id and phone=:phone', array(':id' => Yii::app()->request->getPost('id', 0), ':phone' => Yii::app()->request->getPost('phone', 0)));
            if ($row && $row->delete()) {
                Yii::app()->user->setFlash('info', '删除成功！');
                $this->response(true, '删除成功！');
            } else {
                $this->setMessage('删除失败！', 'info');
            }
        }
    }

    /**
     * ajax获取下一页的用户订单数据并组装成html
     */
    public function actionAjaxGetOrders()
    {
        $html = '';
        if (Yii::app()->request->isPostRequest) {
            $limit = Yii::app()->request->getPost('limit', 5);
            $page = Yii::app()->request->getPost('page', 1);
            $phone = Yii::app()->request->getPost('phone', 0);
            $orders = OrderExt::model()->findAll(array(
                'condition' => 'phone=' . $phone,
                'order' => 'created desc',
                'limit' => $limit,
                'offset' => ($page - 1) * $limit
            ));

            foreach ($orders as $order) {
                $html .= "<li><a class='inner'><p class='time'><strong class='em-2'>用户订单</strong>{$order->created}</p><p class='step'>来源类型：{$order->spm_b}</p>";
                if ($p = $order->getPlot()) {
                    $html .= "<p class='step'>意向楼盘：{$p->title}</p>";
                }
                $html .= ' </a></li>';
            }

        }
        echo CJSON::encode(['html'=>$html]);
    }
}
