<?php

/**
 * User: fanqi
 * Date: 2016/8/30
 * Time: 10:13
 */
class ZfController extends VipController
{
    public function getStaff()
    {
        return ResoldStaffExt::model()->findStaffByUid(Yii::app()->user->uid);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * [filters description]
     * @return [type] [description]
     */
    public function filters()
    {
        return array_merge(parent::filters(),[
            'expire + refresh,hurry,appoint',
            ]);
    }

    public function filterExpire($chain)
    {
        if($this->getStaff()->getIsExpire()) {
            $this->setMessage('您的套餐已过期！','error');
            $this->redirect('saleUp');
        } else {
            $chain->run();
        }
    }

    public function actions()
    {
        $alias = "vip.controllers.zf.";
        return [
            'publish' => $alias . 'ZfPublishAction',
            'saleUp' => $alias . 'ZfSaleUpAction',
            'saleDown' => $alias . 'ZfSaleDownAction'
        ];
    }

    /**
     *刷新
     */
    public function actionRefresh()
    {
        $success = $error = 0;
        if (Yii::app()->request->isPostRequest) {
            //获取房源ID,修改刷新时间
            // $expire_time = Yii::app()->request->getPost("expire", 0);
            $fid = Yii::app()->request->getPost("fid");
            if($fid)
                $fid = explode(',', $fid);

            if($fid && is_array($fid)) {
                $refreshInterval = SM::resoldConfig()->resoldRefreshInterval->value*60;
                $expireTime = SM::resoldConfig()->resoldExpireTime() * 86400;
                foreach ($fid as $key => $value) {

                    $esf = ResoldZfExt::model()->findByPk($value);
                    if(time()-$esf->refresh_time > $refreshInterval)
                    {
                        if(Yii::app()->db->createCommand('update resold_zf set refresh_time='.time().',expire_time='.(time()+$expireTime).' where id='.$value)->execute())
                            $success++;
                        else
                            $error++;
                    } else {
                        $error++;
                    }
                }
            }
            $this->setMessage("刷新成功".$success."条，失败".$error."条","success");
        }
        $this->redirect('saleUp');
    }

    /**
     * [actionDownSale 删除函数 支持批量或单个 post或get请求]
     * @param  [type] $fids [description]
     * @return [type]       [description]
     */
    public function actionDelete()
    {
        if(Yii::app()->request->getIsPostRequest())
            $fids = Yii::app()->request->getPost('fids');
        else
            $fids = Yii::app()->request->getQuery('fids');
        if($fids)
            $fids = explode(',', $fids);
        if($fids && is_array($fids))
            foreach ($fids as $key => $value) {
                $esf = ResoldZfExt::model()->findByPk($value);
                // 删除就回收且未审核
                $esf->sale_status = 3;
                $esf->status = 0;
                $esf->save();
            }
        $this->setMessage('操作成功！','success');
        return true;
    }

    /**
     * 预约刷新
     * 先判断预约配额 再更新预约时间
     */
    public function actionAppointRefresh()
    {
        $uid = $this->staff->uid;
        $error = $success = 0;
        $time = Yii::app()->request->getQuery('time',[]);
        $fid = Yii::app()->request->getQuery('fid',0);
        $day = Yii::app()->request->getQuery('day',1);
        $refreshInterval = SM::resoldConfig()->resoldRefreshInterval() * 60;
        if($this->staff->getCanAppointNum()<=0 || $this->staff->getCanAppointNum()<count($time)*count($fid))
        {
            // var_dump($fid,implode(',', $fid));exit;
            $this->setMessage('套餐配额不足，您还可以预约'.$this->staff->getCanAppointNum().'条','error');
            $this->redirect('/vip/esf/setAppoint?fid='.implode(',', $fid));
        }
        else
        {
            if(!is_array($fid))
            {
                if($time)
                {
                    $refresh_time = Yii::app()->db->createCommand('select refresh_time from resold_zf where id='.$fid )->queryScalar();
                    for($i = 1;$i <= $day;$i++)
                    {
                        foreach ($time as $key => $value) {
                            list($hour,$minute) = explode(':', $value);
                            $esfAppoint = new ResoldAppointExt;
                            $esfAppoint->appoint_time = TimeTools::getDayBeginTime() + ($i - 1)*86400 + $hour*3600 + $minute*60;
                            $esfAppoint->uid = $uid;
                            $esfAppoint->fid = $fid;
                            $esfAppoint->type = 2;
                            // 预约时间小于当前时间GG
                            if($esfAppoint->appoint_time < time())
                                $error++;
                            // 预约时间在刷新间隔内GG
                            elseif ($esfAppoint->appoint_time - $refresh_time < $refreshInterval) {
                                $error++;
                            }
                            else
                            {
                                $esfAppoint->save();
                                $success++;
                            }

                        }
                    }
                    $esf = ResoldEsfExt::model()->findByPk($fid);
                    $esf->appoint_time = time();
                    $esf->save();
                }
            }
            else
            {
                foreach ($fid as $key => $v) {
                    $refresh_time = Yii::app()->db->createCommand('select refresh_time from resold_zf where id='.$v )->queryScalar();
                    if($time)
                    {
                        for($i = 1;$i <= $day;$i++)
                        {
                            foreach ($time as $key => $value) {
                                list($hour,$minute) = explode(':', $value);
                                $esfAppoint = new ResoldAppointExt;
                                $esfAppoint->appoint_time = TimeTools::getDayBeginTime() + ($i - 1)*86400 + $hour*3600 + $minute*60;
                                $esfAppoint->uid = $uid;
                                $esfAppoint->fid = $v;
                                $esfAppoint->type = 2;
                                // 预约时间小于当前时间GG
                                if($esfAppoint->appoint_time < time())
                                    $error++;
                                // 预约时间在刷新间隔内GG
                                elseif ($esfAppoint->appoint_time - $refresh_time < $refreshInterval) {
                                    $error++;
                                }
                                else
                                {
                                    $esfAppoint->save();
                                    $success++;
                                }

                            }
                        }
                        $esf = ResoldEsfExt::model()->findByPk($v);
                        $esf->appoint_time = time();
                        $esf->save();
                    }
                }
            }
            $this->setMessage('预约成功'.$success.'条，失败'.$error.'条','success');
            $this->redirect('saleUp');
        }
        
    }


    /**
     * [actionHurry 加急操作]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionHurry($fid)
    {
        if($this->staff->getCanHurryNum()<=0)
        {
            $this->setMessage('套餐配额不足！','error');
        }
        else
        {
            $zf = ResoldZfExt::model()->findByPk($fid);
            $zf->hurry = time();
            if($zf->save()) {
                $this->setMessage('操作成功！', 'success');
            }else{
                $this->setMessage('操作失败','error');
            }
        }
    }
    /**
     * [actionDownSale 下架函数 支持批量或单个 post或get请求]
     * @param  [type] $fids [description]
     * @return [type]       [description]
     */
    public function actionDownSale()
    {
        $success = $error = 0;
        if(Yii::app()->request->getIsPostRequest())
            $fids = Yii::app()->request->getPost('fids');
        else
            $fids = Yii::app()->request->getQuery('fids');
        if(strpos($fids,','))
            $fids = explode(',', $fids);
        if($fids && is_array($fids))
            foreach ($fids as $key => $value) {
                $esf = ResoldZfExt::model()->findByPk($value);
                $esf->sale_status = 2;
                // 下架删除预约时间和加急时间
                ResoldAppointExt::model()->deleteAllByAttributes(['fid'=>$value,'uid'=>$this->staff->uid,'status'=>0,'type'=>2]);
                $esf->hurry = 0;
                if($esf->save())
                    $success++;
                else
                    $error++;
            }
        elseif($fids)
        {
            $esf = ResoldZfExt::model()->findByPk($fids);
            $esf->sale_status = 2;
            // 下架删除预约时间和加急时间
            ResoldAppointExt::model()->deleteAllByAttributes(['fid'=>$fids,'uid'=>$this->staff->uid,'status'=>0,'type'=>2]);
            $esf->hurry = 0;
            if($esf->save())
                $success++;
            else
                $error++;
        }
        $this->setMessage('下架成功'.$success.'条，失败'.$error.'条','success');
    }

    /**
     * 上架所选
     */
    public function actionUpSale()
    {
        $sid = Yii::app()->user->sid;
        $success = $error = 0;
        $shop = ResoldShopExt::model()->findByPk($sid);
        if($shop->status==2)
        {
            $this->setMessage('店铺已关闭，无法上架','error');
            exit;
        }
        if(Yii::app()->request->getIsPostRequest())
            $fids = Yii::app()->request->getPost('fids');
        else
            $fids = Yii::app()->request->getQuery('fids');
        $uid = Yii::app()->user->uid;
        //剩余条数不足或者上架条数超过剩余条数
        if($this->staff->getCanSaleNum()<=0 || count($fids)>$this->staff->getCanSaleNum())
        {
            $this->setMessage('套餐配额不足，您可能有上架房源已到期，您还可以上架'.$this->staff->getCanSaleNum().'条','error');
            return false;
        }
        if(strpos($fids,','))
            $fids = explode(',', $fids);
        if($fids && is_array($fids))
            foreach ($fids as $key => $value) {
                $zf = ResoldZfExt::model()->findByPk($value);
                $zf->sale_status = 1;
                $zf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
                if(!$zf->save()){
                    $error++;
                } else {
                    $success++;
                }
            }
        elseif($fids)
        {
            $zf = ResoldZfExt::model()->findByPk($fids);
            $zf->sale_status = 1;
            $zf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            if(!$zf->save()){
                $error++;
            } else {
                $success++;
            }
        }
        $this->setMessage('上架成功'.$success.'条，失败'.$error.'条','success');
    }

    /**
     * [actionAppoint 预约操作]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionAppoint()
    {
        $uid = $this->staff->uid;
        $error = $success = 0;
        $time = Yii::app()->request->getQuery('time',[]);
        $fid = Yii::app()->request->getQuery('fid',0);
        $day = Yii::app()->request->getQuery('day',1);
        $refreshInterval = SM::resoldConfig()->resoldRefreshInterval() * 60;
        if($this->staff->getCanAppointNum()<=0 || $this->staff->getCanAppointNum()<count($time)*count($fid))
        {
            $this->setMessage('套餐配额不足，您还可以预约'.$this->staff->getCanAppointNum().'条','error');
            $this->redirect('/vip/esf/setAppoint?fid='.implode(',', $fid));
        }
        else
        {
            if(!is_array($fid))
            {
                if($time)
                {
                    $refresh_time = Yii::app()->db->createCommand('select refresh_time from resold_zf where id='.$fid )->queryScalar();
                    for($i = 1;$i <= $day;$i++)
                    {
                        foreach ($time as $key => $value) {
                            list($hour,$minute) = explode(':', $value);
                            $esfAppoint = new ResoldAppointExt;
                            $esfAppoint->appoint_time = TimeTools::getDayBeginTime() + ($i - 1)*86400 + $hour*3600 + $minute*60;
                            $esfAppoint->uid = $uid;
                            $esfAppoint->fid = $fid;
                            $esfAppoint->type = 2;
                            // 预约时间小于当前时间GG
                            if($esfAppoint->appoint_time < time())
                                $error++;
                            // 预约时间在刷新间隔内GG
                            elseif ($esfAppoint->appoint_time - $refresh_time < $refreshInterval) {
                                $error++;
                            }
                            else
                            {
                                $esfAppoint->save();
                                $success++;
                            }
                            
                        }
                    }
                    $esf = ResoldZfExt::model()->findByPk($fid);
                    $esf->appoint_time = time(); 
                    $esf->save();
                }
            }
            else
            {
                foreach ($fid as $key => $v) {
                    $refresh_time = Yii::app()->db->createCommand('select refresh_time from resold_esf where id='.$v )->queryScalar();
                    if($time)
                    {
                        for($i = 1;$i <= $day;$i++)
                        {
                            foreach ($time as $key => $value) {
                                list($hour,$minute) = explode(':', $value);
                                $esfAppoint = new ResoldAppointExt;
                                $esfAppoint->appoint_time = TimeTools::getDayBeginTime() + ($i - 1)*86400 + $hour*3600 + $minute*60;
                                $esfAppoint->uid = $uid;
                                $esfAppoint->fid = $v;
                                $esfAppoint->type = 2;
                                // 预约时间小于当前时间GG
                                if($esfAppoint->appoint_time < time())
                                    $error++;
                                // 预约时间在刷新间隔内GG
                                elseif ($esfAppoint->appoint_time - $refresh_time < $refreshInterval) {
                                    $error++;
                                }
                                else
                                {
                                    $esfAppoint->save();
                                    $success++;
                                }
                                
                            }
                        }
                        $esf = ResoldZfExt::model()->findByPk($v);
                        $esf->appoint_time = time(); 
                        $esf->save();
                    }
                }
            }
            $this->setMessage('预约成功'.$success.'条，失败'.$error.'条','success');
            $this->redirect('saleUp');
        }
    }

    /**
     * [actionDelAppoint 取消预约操作]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionDelAppoint($fid)
    {
        ResoldAppointExt::model()->deleteAllByAttributes(['fid'=>$fid,'uid'=>$this->staff->uid,'status'=>0]);
        $esf = ResoldZfExt::model()->findByPk($fid);
        $esf->appoint_time = 0;
        $esf->save();
        $this->setMessage('操作成功！','success');
    }

    /**
     * [actionSetAppoint 设置预约的界面]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionSetAppoint($fid)  
    {
        $criteria = new CDbCriteria;
        if(strstr($fid,','))
        {
            $fid = explode(',', $fid);
            $criteria->addInCondition('id',$fid);
            $esf = ResoldZfExt::model()->findAll($criteria);
        }
        else
        {
            $esf = [ResoldZfExt::model()->findByPk($fid)];
        }
        $this->render('setappoint',['esf'=>$esf]);
    }

    /**
     * [actionDelSingleAppoint 单个取消预约操作]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionDelSingleAppoint($id,$fid)
    {
        ResoldAppointExt::model()->deleteAllByAttributes(['id'=>$id]);
        $this->setMessage('操作成功！','success');
        $this->redirect('/vip/zf/appointList?fid='.$fid);
    }

    /**
     * [actionAppointList 预约列表]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionAppointList($fid)  
    {
        $esf = ResoldZfExt::model()->findByPk($fid);
        $appoints = ResoldAppointExt::model()->findAll(['condition'=>'fid=:fid and type=2','params'=>[':fid'=>$fid],'order'=>'appoint_time asc']);
        $this->render('appointlist',['esf'=>$esf,'appoints'=>$appoints]);
    }

}