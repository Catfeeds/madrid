<?php
/**
 * WARNING:if not necessary, Please don't change code below and relevant AR class!
 * 订单相关列表
 * @author weibaqiu
 * @date 2015-09-14
 */
class OrderController extends AdminController
{
    /**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
			//集客所有内容的权限设置
			array('allow',
				'roles' => array('guanlijike'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}
    /**
     * 订单列表
     * @param  string $t      搜索类型
     * @param  string $str    对应搜索类型的关键词
     * @param  string $time   提交时间段
     * @param  string $source 提交来源
     * @param  string $type   订单类型
     * @param  string $status 订单处理状态
     * @param  string $spm_c  对应spm_b的spm_c值
     * @return [type]         [description]
     */
    public function actionList($t='',$str='',$time='',$source='',$type='',$status='',$spm_c='',$export=0)
    {
        $criteria = new CDbCriteria(array(
            'order' => 'id desc'
        ));
        if($time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition('created>=:beginTime');
            $criteria->addCondition('created<:endTime');
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;
        }
        if($source!='')
        {
            $criteria->addCondition('spm_a=:source');
            $criteria->params[':source'] = $source;
            if($spm_c)
            {
                $criteria->addCondition('spm_c=:spm_c');
                $criteria->params[':spm_c'] = $spm_c;
            }
        }
        if($type!='')
        {
            $criteria->addCondition('spm_b=:type');
            $criteria->params[':type'] = $type;
            if($spm_c)
            {
                $criteria->addCondition('spm_c=:spm_c');
                $criteria->params[':spm_c'] = $spm_c;
            }
        }
        if($status!='')
        {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $status;
        }
        if(in_array($t, array('phone', 'name')) && $str!='')
        {
            $criteria->addSearchCondition($t, $str);
        }
        //导出excel表
        if($export)
        {
            $this->exportExcel($criteria);
        }
        
        //表格提交，批量导入
        if(Yii::app()->request->isPostRequest)
        {
            $tmp = $_FILES['file']['tmp_name'];
            if(!$tmp)
            {
                $this->setMessage('请提交表格！','error');
            }
            $ar = ExcelHelper::read($tmp);
            $checkAr = array_values($ar[0][1]);
            $tb = ['姓名','电话','订单来源类型','订单备注信息','性别','QQ','微信号','微信验证是否通过','住址','房源类型','意向楼盘','意向区域','关注点','其他关注点','意向购买时间','户型面积(填写数字，单位：平方)','购房预算(填写数字，单位：万)','看房邀请','备注信息','购房进度'];
            //表头判断
            if(array_diff($checkAr,$tb))
            {
                $this->setMessage('表头不符！','error');
            }
            else
            {
                $exlTmp = ExcelHelper::read($tmp,1);
                // $oldUsers = '';
                foreach ($exlTmp[0] as $key => $value) {
                    // $flag = $isOld = 0;
                    $value = array_values($value);
                     //空记录过滤
                    if(!$value[1])
                    {
                        continue;
                    }
                    $fpstate = Yii::app()->request->getPost('fpstate','0');
                    $staff_id = Yii::app()->request->getPost('staff_id',0);
                    if(!$this->dealOrder($value,1,$fpstate,$staff_id))
                    {
                        $this->setMessage('保存失败！','error');
                    }              
                }
                $this->setMessage('保存成功！','success',array('list'));
            }
            
        }
        $dataProvider = OrderExt::model()->getList($criteria);
        $data = $dataProvider->data;
        $pager = $dataProvider->pagination;

        $orderType = OrderExt::model()->findAll(array(
            'select' => 'spm_b',
            'group' => 'spm_b',
        ));

        $this->render('list', array(
            'data' => $data,
            'pager' => $pager,
            'source' => $source,
            't' => $t,
            'str' => $str,
            'time' => $time,
            'source' => $source,
            'type' => $type,
            'status' => $status,
            'orderType' => CHtml::listData($orderType,'spm_b','spm_b'),
            'spm_c' => $spm_c,
        ));
    }

    /**
     * [dealOrder 订单处理/用户分配函数]
     * @param  [array]  $value [订单数组]
     * @param  integer $type  [0为后台录入，1为导入]
     */
    public function dealOrder($value,$type = 0,$fpstate,$staff_id = 0)
    {
        $order = new OrderExt;
        //批量导入
        if($type)
        {
            $isOld = 0;
            $order->name = $value[0];
            $order->phone = $value[1];
            $order->note = $value[3];
            $order->spm_b = $value[2];
            $order->spm_a = "excel导入";
            if(!$order->save())
            {
                return false;
            }
            //用户处理
            $user = $order->user;
            
            //性别格式化
            $ar = array_flip(UserExt::$gender);
            $xb = $value[4]?$ar[$value[4]]:0;
            //房源类型格式化
            $ar = array_flip(UserExt::$roomType);
            $fylx = $value[9]?$ar[$value[9]]:0;
            //微信是否验证通过格式化
            $ar = array_flip(UserExt::$is_validate);
            $yztg = $value[7]?$ar[trim($value[7])]:0;
            //意向楼盘名字转id,并格式化
            $yxPlots = explode(' ',trim($value[10]));
            $yxlp = [];
            if($yxPlots)
            {
                foreach ($yxPlots as $key => $v) {
                    $p = PlotExt::model()->find(array('condition'=>'title=:title','params'=>[':title'=>$v]));
                    if($p)
                        $yxlp[] = $p->id;
                }
                $yxlp = implode(',', $yxlp);
            } 
            //意向区域格式化
            $yxAreas = explode(' ',trim($value[11]));
            $yxqy = [];
            if($yxAreas)
            {
                foreach ($yxAreas as $key => $v) {
                    $p = AreaExt::model()->find(array('condition'=>'name=:title','params'=>[':title'=>$v]));
                    if($p)
                        $yxqy[] = $p->id;
                }
            }

            //关注点格式化
            $gzds = explode(' ',trim($value[12]));
            $gzd = [];
            if($gzds)
            {
                $ar = array_flip(UserExt::$concern);
                foreach ($gzds as $key => $v) {
                    $p = in_array($v, UserExt::$concern)?$ar[$v]:'';
                    if($p)
                        $gzd[] = (string)$p;
                }
            }
            
            //意向时间格式化
            $yxsjs = TagExt::model()->find(array('condition'=>'name=:title','params'=>[':title'=>$value[14]]));
            if($yxsjs)
                $intent_time = $yxsjs['id'];
            //看房邀请格式化
            $ar = array_flip(UserExt::$takeNotice);
            $kfyq = $value[17]?$ar[$value[17]]:0;
            //购房进度格式化
            $ar = array_flip(UserExt::$progress);
            $gfjd = $value[19]?$ar[$value[19]]:1;

            $attr = array(
                'name'=>$value[0],
                'gender'=>(string)$xb,
                'phone'=>$value[1],
                'qq'=>$value[5],
                'wechat'=>$value[6],
                'is_validate'=>(string)$yztg,
                'address'=>$value[9],
                'room_type'=>(string)$fylx,
                'yxlp'=>$yxlp?$yxlp:'',
                'yxqy'=>$yxqy,
                'concern'=>$gzd,
                'concern_remark'=>$value[13],
                'intent_time'=>isset($intent_time)?$intent_time:0,
                'size'=>$value[15],
                'budget'=>$value[16],
                'take_notice'=>(string)$kfyq,
                'note'=>$value[18],
                'progress'=>(string)$gfjd,
                );

            $attr = array_filter($attr);
            $user->attributes = $attr;

            if(!$user->save())
            {
                return false;
            }
            else
            {
                if(isset($attr['yxlp']) && $attr['yxlp'])
                    $user->addYxlp();
                if(isset($attr['yxqy']) && $attr['yxqy'])
                    $user->addYxqy();
                //平均分配
                Yii::import('application.components.jike.*');
                //以小编流水的场景记录流水，并将流水状态同步到用户回访状态上
                $userLogModel = new UserLogExt('adminLog');
                $userLogModel->phone = $user->phone;
                $userLogModel->visit_status = UserExt::$assignValue;
                $userLog = new JikeUserLog($userLogModel);
                if($fpstate=='1')
                {
                    $userAssign = new JikeUserAssign($user);
                    $userAssign->userLog = $userLog;
                    $userAssign->assign();
                    OrderExt::model()->updateByPk($order->id, ['status'=>1]);
                }
                //选择买房顾问分配
                elseif ($fpstate=='2') {
                    $staff = StaffExt::model()->findByPk($staff_id);
                    $userAssign = new JikeUserAssign($user,$staff);
                    $userAssign->userLog = $userLog;
                    $userAssign->assign();
                    OrderExt::model()->updateByPk($order->id, ['status'=>1]);
                }

            }
        }
        else //单独录入
        {
            $order->attributes = $value;
            if(!$order->save())
            {
                return false;
            }
            $user = $order->user;
            //平均分配
            Yii::import('application.components.jike.*');
            //以小编流水的场景记录流水，并将流水状态同步到用户回访状态上
            $userLogModel = new UserLogExt('adminLog');
            $userLogModel->phone = $user->phone;
            $userLogModel->visit_status = UserExt::$assignValue;
            $userLog = new JikeUserLog($userLogModel);
            if($fpstate=='1')
            {
                //分配操作
                $userAssign = new JikeUserAssign($user);
                $userAssign->userLog = $userLog;
                $userAssign->assign();
                OrderExt::model()->updateByPk($order->id, ['status'=>1]);
            }
            //选择买房顾问分配
            elseif ($fpstate=='2') {
                $staff = StaffExt::model()->findByPk($staff_id);
                $userAssign = new JikeUserAssign($user,$staff);
                $userAssign->userLog = $userLog;
                $userAssign->assign();
                OrderExt::model()->updateByPk($order->id, ['status'=>1]);
            }
        }
        return true;
    }
    /**
     * 后台录入订单
     */
    public function actionAdd()
    {
        $order = new OrderExt;
        if(Yii::app()->request->isPostRequest)
        {
            $fpstate = Yii::app()->request->getPost('fpstate','0');
            $staff_id = Yii::app()->request->getPost('staff_id',0);
            $values = Yii::app()->request->getPost('OrderExt', array());

            if(!$this->dealOrder($values,0,$fpstate,$staff_id))
            {
                $this->setMessage('保存失败！','error');
            }
            $this->setMessage('保存成功！','success',array('list'));
        }

        //已有订单类型
        $typeArr = array();
        $criteria = new CDbCriteria(array(
            'select' => 'spm_b',
            'group' => 'spm_b',
        ));
        foreach(OrderExt::model()->findAll($criteria) as $v)
        {
            $typeArr[$v->spm_b] = $v->spm_b;
        }
        $type = array();
        foreach(OrderExt::$type as $v)
        {
            foreach($v as $vv)
            {
                $type[$vv] = $vv;
            }
        }
        $typeArr = array_merge($typeArr, $type);
        $this->render('add', array(
            'order' => $order,
            'typeArr' => $typeArr,
        ));
    }

    /**
     * ajax请求修改订单状态
     */
    public function actionAjaxChangeStatus()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $id = Yii::app()->request->getPost('id', 0);
            $model = OrderExt::model()->findByPk($id);
            if($model && $model->changeStatus())
                $this->response(true, '修改成功！');
            else
                $this->response(false, '修改失败！');
        }
    }

    /**
     * ajax删除订单
     */
    public function actionAjaxDel()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $id = Yii::app()->request->getPost('id', 0);
            if(OrderExt::model()->deleteByPk($id))
                $this->setMessage('删除成功！', 'success');
            else
                $this->response(false, '删除失败！');
        }
    }

    /**
     * 集客订单统计页面
     * @param string $type  统计类型
     * @param string $time  时间段
     */
    public function actionStatistics($type='statistics', $time='')
    {
        //查询时间
        if($time)
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime))+86400;
        }
        else
        {
            $beginTime = TimeTools::getMonthBeginTime();
            $endTime = time();
        }

        //查询类型
        if($type!='statistics')
        {
            $this->layout = false;
            $data = array();
        }
        switch ($type)
        {
            //来源统计
            case 'lytj':
                $lytj = OrderExt::model()->getByTimeRange($beginTime, $endTime)->findAll(array(
                    'select' => 'count(id) as count,spm_a',
                    'group' => 'spm_a',
                ));
                $data['series'] = $data['legend'] = array();
                foreach($lytj as $v)
                {
                    $data['series'][] = array('name'=>$v->spm_a, 'value'=>$v->count);
                    $data['legend'][] = $v->spm_a;
                }
                break;
                //订单类型统计
            case 'ddlxtj':
                $ddlxtj = OrderExt::model()->getByTimeRange($beginTime, $endTime)->findAll(array(
                    'select' => 'count(id) as count,spm_b',
                    'group' => 'spm_b',
                ));
                $data['series'] = $data['legend'] = array();
                foreach($ddlxtj as $v)
                {
                    $data['series'][] = array('name'=>$v->spm_b, 'value'=>$v->count);
                    $data['legend'][] = $v->spm_b;
                }
                break;
            case 'ddltj':
                $ddltj = OrderExt::model()->getByTimeRange($beginTime, $endTime)->findAll(array(
                    'select' => 'count(id) as count, created_ymd,created',
                    'order' => 'created_ymd asc',
                    'group' => 'created_ymd',
                ));
                $data['series'] = $data['xAxis'] = array();
                foreach($ddltj as $v)
                {
                    $data['series'][] = (int)$v->count;
                    $data['xAxis'][] = date('m-d', $v->created);
                }
                $data['average'] = $ddltj ? array_sum($data['series'])/count($data['series']) : 0;
                $data['max'] = $ddltj ? max($data['series']) : 0;
                $data['min'] = $ddltj ? min($data['series']) : 0;
                break;
            case 'yxlpph':
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count,hid',
                    'order' => 'count asc',
                    'group' => 'hid',
                ));
                $yxlpph = UserPlotRelExt::model()->getByTimeRange($beginTime, $endTime)->findAll($criteria);
                $data['series'] = $data['yAxis'] = array();
                foreach($yxlpph as $v)
                {
                    $data['series'][] = (int)$v->count;
                    $data['yAxis'][] = $v->plot ? $v->plot->title : '-';
                }
                break;
            case 'yhltj':
                //新增人数
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count',
                ));
                $xinzeng = UserExt::model()->getByTimeRange($beginTime, $endTime)->find($criteria);
                //有效用户数，除无效和未联系的
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count',
                    'condition' => 'visit_status!=1 and visit_status!=6'
                ));
                $youxiao = UserExt::model()->getByTimeRange($beginTime, $endTime)->find($criteria);
                //未联系用户数
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count',
                    'condition' => 'visit_status=1',
                ));
                $lianxi = UserExt::model()->getByTimeRange($beginTime, $endTime)->find($criteria);
                //联系用户数
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count',
                    'condition' => 'visit_status=2',
                ));
                $lianxi = UserExt::model()->getByTimeRange($beginTime, $endTime)->find($criteria);
                //无效用户数
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count',
                    'condition' => 'visit_status=6'
                ));
                $wuxiao = UserExt::model()->getByTimeRange($beginTime, $endTime)->find($criteria);
                //已分配用户数
                $criteria = new CDbCriteria(array(
                    'select' => 'count(id) as count',
                    'condition' => 'staff_id!=0',
                ));
                $fenpei = UserExt::model()->getByTimeRange($beginTime, $endTime)->find($criteria);
                $data = array('新增用户数'=>$xinzeng->count, '有效用户数'=>$youxiao->count, '联系用户数'=>$lianxi->count, '无效用户数'=>$wuxiao->count,'已分配用户数'=>$fenpei->count);
                break;
            default:
                $data = array();
                break;
        }

        $this->render($type, array(
            'data' => $data,
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
        $data = OrderExt::model()->findAll($criteria);
        //excel列名
        $fileds = array('订单号','姓名','电话','订单状态','订单来源','订单类型','管家','订单备注','订单提交时间');
        $content = array();
        $gmsjArr = CHtml::listData(TagExt::model()->normal()->getTagByCate('gmsj')->findAll(),'id','name');
        foreach($data as $order)
        {
            $order->status = $order->status?'已处理':'未处理';
            $content[] = array($order->id,$order->name,$order->phone,$order->status,$order->spm_a,$order->spm_b,($order->user && $order->user->staff) ? $order->user->staff->username : '未分配',$order->note,date('Y-m-d H:i:s', $order->created));
        }
        unset($data);
        ExcelHelper::write_browser(date('YmdHis'),$fileds,$content);
        Yii::app()->end();
    }

}
?>
