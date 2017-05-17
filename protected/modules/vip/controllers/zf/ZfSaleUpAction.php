<?php

/**
 * User: fanqi
 * Date: 2016/8/30
 * Time: 10:23
 */
class ZfSaleUpAction extends CAction
{
    /**
     * 上架列表
     */
    public function run($type="title",$value = "",$time_type="created",$time="",$hid="",$sort="",$category=0)
    {
        if(Yii::app()->request->getIsPostRequest()){
            $fid = Yii::app()->request->getPost('fid',0);
            $this->addAppointTime($fid,$this->getController());
            $this->controller->redirect('saleUp');
        }
        $criteria = new CDbCriteria([
            'order' => 'sort desc ,refresh_time asc,created desc'
        ]);
        //排序条件
        if ($sort) {
            $st = strpos($sort, 'up') ? ' asc' : ' desc';
            $fields = strpos($sort, 'sale') ? ' sale_time' : ' refresh_time';
            $criteria->order = $fields . $st;
        }
        //添加时间、刷新时间筛选 $time[created,refresh_time,sale_time]
        $daterangepicker = new DaterangepickerForm();
        $daterangepicker->setTime($time);
        if ($time_type != '' && $daterangepicker->check()) {
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = $daterangepicker->beginTime;
            $criteria->params[':endTime'] = $daterangepicker->endTime + 86400;

        }
        //当前中介论坛id获取，并更具该值查询对应上架租房
        $criteria->addCondition("uid=:uid");
        $criteria->params[':uid'] = isset(Yii::app()->user->uid) ? Yii::app()->user->uid : 0;
        //状态为上架的数据
        $criteria->addCondition("sale_status=:sale_status");
        $saleStatus_arr = array_flip(Yii::app()->params['saleStatus']);
        $criteria->params[":sale_status"] = $saleStatus_arr["上架"];
        //根据楼盘ID判断
        if ($hid) {
            $criteria->addCondition("hid=:hid");
            $criteria->params[":hid"] = $hid;
        }
        if ($category) {
            $criteria->addCondition("category=:category");
            $criteria->params[":category"] = $category;
        }
        //根据标题或房源内容
        if ($value = trim($value)) {
            if ($type == 'title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type == 'content') {
                $criteria->addSearchCondition('content', $value);
            }
        }
        $dataProvider = ResoldZfExt::model()->undeleted()->getList($criteria,20);
        //筛选上架房源中出现过的房源
        $plots = [];
        if ($zfs = ResoldZfExt::model()->undeleted()->findAll(
            [
                'condition' => 'uid = :uid and sale_status=' . $saleStatus_arr["上架"],
                'params' => [
                    ':uid' => isset(Yii::app()->user->uid) ? Yii::app()->user->uid : 0
                ]
            ]
        )
        ) {
            foreach ($zfs as $zf) {
                $plots[$zf->hid] = $zf->plot_name;
            }
        }
        $plots = array_flip(array_flip($plots));
        $this->getController()->render("saleUp", [
            "zfs" => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
            'hid' => $hid,
            'plots' => $plots,
            'category' => $category,
            'sort' => $sort,
            'staff' => $this->getController()->getStaff(),

        ]);
    }

    /**
     * @param $fid
     * \
     * @return mixed
     */
    public function addAppointTime($fid,$controller)
    {
        if ($expire = Yii::app()->request->getPost('expire', 0)) {
            $zf = ResoldZfExt::model()->findByPk($fid);
            $zf->expire_time = $expire;
            $zf->refresh_time = time();
            if(!$zf->save()){
                $controller->setMessage('刷新失败','error');
            }
        }

        //预约操作 先判断预约配额 再更新预约时间
        if ($appoint_times = Yii::app()->request->getPost('appoint_times', [])) {
            $days = Yii::app()->request->getPost('appday', 0);
            if (count($appoint_times) * $days > $controller->getStaff()->getCanAppointNum()) {
                $controller->setMessage('套餐配额不足，您还可以预约' . $controller->getCanAppointNum() . '条', 'error');
            } else {
                $nowtime = TimeTools::getDayBeginTime();
                // var_dump($days);exit;
                $j = 1;
                while ($j <= $days) {
                    if ($appoint_times)
                        foreach ($appoint_times as $key => $v) {
                            $timeArr = explode(':', $v);
                            $resoldAppoint = new ResoldAppointExt;
                            $resoldAppoint->type = 2;
                            $resoldAppoint->uid = Yii::app()->user->uid;
                            $resoldAppoint->fid = $fid;
                            $resoldAppoint->appoint_time = $nowtime + (int)$timeArr[0] * 3600 + (int)$timeArr[1] * 60;
                            // var_dump($resoldAppoint->appoint_time);exit;
                            if (!$resoldAppoint->save()) {
                                var_dump($resoldAppoint->errors);
                                exit;
                            }
                            $zf = ResoldZfExt::model()->findByPk($fid);
                            $zf->appoint_time = time();
                            $zf->save();
                        }

                    $nowtime += 86400;
                    $j++;
                }

            }
        }
    }

}