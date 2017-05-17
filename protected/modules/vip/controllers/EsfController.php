<?php
/**
 * 中介二手房管理，包括发布、上下架二手房和交互的相应操作
 * @author steven.allen <[<email address>]>
 * @date 2016.09.02
 */
class EsfController extends VipController
{
    /**
     * [$staff 当前登录职员]
     * @var [type]
     */
    public $staff;

    /**
     * [filters description]
     * @return [type] [description]
     */
    public function filters()
    {
        return array_merge(parent::filters(),[
            'expire + refresh,hurry,appoint,setAppoint',
            ]);
    }

    public function init()
    {
        parent::init();
        if(!isset(Yii::app()->user->uid)){
            $this->redirect('/vip/common/login');
        }
        $this->staff = ResoldStaffExt::model()->findStaffByUid(Yii::app()->user->uid);
        
    }

    public function filterExpire($chain)
    {
        if($this->staff->getIsExpire()) {
            $this->setMessage('您的套餐已过期！','error');
            $this->redirect('saleup');
        } else {
            $chain->run();
        }
    }

    /**
     * [actionPublish 发布二手房]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
	public function actionPublish($id=0)
	{
        $new_esf = $id == 0 ? new ResoldEsfExt : ResoldEsfExt::model()->findByPk($id);
        $images = Yii::app()->request->getPost('images', array());
        $images = array_combine($images,Yii::app()->request->getPost('image_des', array()));

		if(Yii::app()->request->isPostRequest)
    	{
            // echo CJSON::encode($_POST);exit;
    		$values = Yii::app()->request->getPost('ResoldEsfExt', array());

  			//封面赋值
    		$values['image'] = Yii::app()->request->getPost('fm','');
    		$values['image_count'] = count(Yii::app()->request->getPost('images',array()));

            //楼盘赋值
    		if($values['hid'])
    			$plot = PlotExt::model()->findByPk($values['hid']);
    		$values['plot_name'] = isset($plot)?$plot->title:'';

    		//标签集成
            $category = $values['category'];
            $new_esf->scenario = $values['category']==1?'zhuzhai':($values['category']==2?'shangpu':'xiezilou');
            $new_esf->attributes = $values;
            $tags = array_filter($values['tagsArr']);
            $tsTags = Yii::app()->request->getPost('tagsArr', array());
            foreach ($tsTags as $key => $v) {
                $tags = array_merge($tags,$v);
            }

            //中介后台 默认状态为正常且上架
            //如果修改房源，上架状态与之前一致
            //修改后不更新【刷新时间】
            $source_arr = array_flip(Yii::app()->params['source']);
            $new_esf->source = $source_arr['中介'];
            $new_esf->status = 1;//中介无需审核
            $new_esf->sale_status = ($new_esf->sale_status!=2 && $this->staff->getCanSaleNum() > 0) ? 1 : 2;
            if(!$new_esf->id && $new_esf->sale_status!=2) {
                $new_esf->refresh_time = $new_esf->sale_time = time();
                
            }
            if($new_esf->sale_status == 1) {
                // 到期时间延续
                $new_esf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            }
            // $new_esf->refresh_time = time();
            $new_esf->username = isset($this->staff->name)?$this->staff->name:'';
            $new_esf->uid = isset($this->staff->uid)?$this->staff->uid:0;
            $new_esf->phone = isset($this->staff->phone)?$this->staff->phone:'';
            $new_esf->sid = $this->staff->sid;
            $new_esf->data_conf = CJSON::encode(['tags'=>$tags]);
            // 有相册无封面取第一张图作为封面
            $imgs = [];
            if($images)
                foreach ($images as $key => $value) {
                    $imgs[] = $key;
                }
            if($imgs && !in_array($new_esf->image, $imgs))
                $new_esf->image = $imgs[0];
            elseif(!$imgs)
                $new_esf->image = '';
            // 黑名单限制
            if(ResoldBlackExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$new_esf->phone]]))
            {
                Yii::app()->controller->setMessage('该号码为黑名单用户','error');
                $this->redirect('saleup');

            }
            //二手房保存后保存图片
    		if($new_esf->save()){
    			if($images)
    			{
    				ResoldImageExt::model()->deleteAllByAttributes(array('fid'=>$new_esf->id));
    				foreach ($images as $key => $v) {
    					$image_rel = new ResoldImageExt;
	    				$image_rel->fid = $new_esf->id;
	    				$image_rel->name = $v;
	    				$image_rel->url = $key;
	    				$image_rel->type = 1;
	    				$image_rel->save();
	    			}
    			}
                else
                {
                    ResoldImageExt::model()->deleteAllByAttributes(array('fid'=>$new_esf->id));
                }
                $this->setMessage('操作成功','success');
                $this->redirect('saleup');
    		}
            else
            {
                $errors = array_values($new_esf->errors);
                $this->setMessage($errors[0][0],'error');
            }
    	}
        // var_dump($esf);exit;
        $this->render('publish',['esf'=>$new_esf]);
	}

    /**
     * [actionSaleup 上架列表]
     * @param  string  $type      [description]
     * @param  string  $value     [description]
     * @param  string  $time      [description]
     * @param  string  $startDate [description]
     * @param  string  $endDate   [description]
     * @param  integer $hid       [description]
     * @return [type]             [description]
     */
    public function actionSaleup($type='title',$value='',$time_type='created',$time='',$hid=0,$sort='',$category=0)
    {
        //排序字段 可配置
        $sortArray = ['saleup'=>'上架时间从早到晚','saledown'=>'上架时间从晚到早','refreshup'=>'刷新时间从早到晚','refreshdown'=>'刷新时间从晚到早'];
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc ,refresh_time asc,created desc',
        ));
        // 排序+筛选
        if($sort)
        {
            $st = strpos($sort,'up')?' asc':' desc';
            $fields = strpos($sort,'sale')?' sale_time':' refresh_time';
            $criteria->order = $fields.$st;
        }
        $criteria->addCondition('uid=:uid');
        $criteria->addCondition('sale_status=1');
        $criteria->params[':uid'] = isset($this->staff->uid)?$this->staff->uid:0;
        if($hid)
        {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        if($category)
        {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $category;
        }
        if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type=='content') {
                $criteria->addSearchCondition('content',$value);
            }
        //添加时间、刷新时间筛选
        if($time_type && $time)
        {
            // var_dump($time);
            $trans_time = explode('-', $time);
            $startDate = trim($trans_time[0]);
            $endDate = trim($trans_time[1]);
            if($startDate)
            {
                $criteria->addCondition($time_type.'>=:startDate');
                $criteria->params[':startDate'] = TimeTools::getDayBeginTime(strtotime($startDate));
            }
            if($endDate)
            {
                $criteria->addCondition($time_type.'<=:endDate');
                $criteria->params[':endDate'] = TimeTools::getDayEndTime(strtotime($endDate));
            }

        }
        // var_dump($criteria);exit;
        $dataProvider = ResoldEsfExt::model()->undeleted()->getList($criteria,20);
        $plots = [];
        if($dataProvider->data)
        foreach ($dataProvider->data as $key => $v) {
           $plots[$v['hid']] = $v['plot_name'];
        }
        // var_dump($this->staff->getCanSaleNum());exit;
        $this->render('saleup', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
            'staff'=>$this->staff,
            'hid'=>$hid,
            'plots'=>$plots,
            'category'=>$category,
            'sort'=>$sort,
            'sortArray'=>$sortArray,
            'action'=>'saleup'
        ));
    }

    /**
     * [actionSaleDown 下架列表]
     * @param  string  $type      [description]
     * @param  string  $value     [description]
     * @param  string  $time      [description]
     * @param  string  $startDate [description]
     * @param  string  $endDate   [description]
     * @param  integer $hid       [description]
     * @param  string  $sort      [description]
     * @return [type]             [description]
     */
    public function actionSaleDown($type='title',$value='',$time_type='created',$time='',$hid=0,$sort='',$category=0)
    {
        //排序字段 可配置
        $sortArray = ['saleup'=>'上架时间从早到晚','saledown'=>'上架时间从晚到早','refreshup'=>'刷新时间从早到晚','refreshdown'=>'刷新时间从晚到早'];
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc ,updated desc,created desc',
        ));
        // 排序+筛选
        if($sort)
        {
            $st = strpos($sort,'up')?' asc':' desc';
            $fields = strpos($sort,'sale')?' sale_time':' refresh_time';
            $criteria->order = $fields.$st;
        }
        $criteria->addCondition('uid=:uid');
        $criteria->addCondition('sale_status=2');
        $criteria->params[':uid'] = isset($this->staff->uid)?$this->staff->uid:0;
        if($hid)
        {
            $criteria->addCondition('hid=:hid');
            $criteria->params[':hid'] = $hid;
        }
        if($category)
        {
            $criteria->addCondition('category=:category');
            $criteria->params[':category'] = $category;
        }
        if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('title', $value);
            } elseif ($type=='content') {
                $criteria->addSearchCondition('content',$value);
            }
        //添加时间、刷新时间筛选
        if($time_type && $time)
        {
            // var_dump($time);
            $trans_time = explode('-', $time);
            $startDate = trim($trans_time[0]);
            $endDate = trim($trans_time[1]);
            if($startDate)
            {
                $criteria->addCondition($time_type.'>=:startDate');
                $criteria->params[':startDate'] = TimeTools::getDayBeginTime(strtotime($startDate));
            }
            if($endDate)
            {
                $criteria->addCondition($time_type.'<=:endDate');
                $criteria->params[':endDate'] = TimeTools::getDayEndTime(strtotime($endDate));
            }

        }
        // var_dump($criteria);exit;
        $dataProvider = ResoldEsfExt::model()->undeleted()->getList($criteria,20);
        $plots = [];
        if($dataProvider->data)
        foreach ($dataProvider->data as $key => $v) {
           $plots[$v['hid']] = $v['plot_name'];
        }
        // var_dump($this->staff->uid);exit;
        $this->render('saledown', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type'=>$time_type,
            'staff'=>$this->staff,
            'hid'=>$hid,
            'plots'=>$plots,
            'category'=>$category,
            'sort'=>$sort,
            'sortArray'=>$sortArray,
            'action'=>'saledown'
        ));
    }

    /**
     * [actionOnSale 上架函数 支持批量或单个 post或get请求]
     * @return [type] [description]
     */
    public function actionOnSale()
    {
        $sid = $this->staff->sid;
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
        $uid = $this->staff->uid;

        if(strpos($fids,','))
            $fids = explode(',', $fids);
        $success = $error = 0;
        //剩余条数不足或者上架条数超过剩余条数
        if($this->staff->getCanSaleNum()<=0 || count($fids)>$this->staff->getCanSaleNum())
        {
            $this->setMessage('套餐配额不足，您可能有上架房源已到期，您还可以上架'.$this->staff->getCanSaleNum().'条','error');
            return false;
        }

        if($fids && is_array($fids))
            foreach ($fids as $key => $value) {
                $esf = ResoldEsfExt::model()->findByPk($value);
                if($esf->status != 1){
                    // $this->setMessage('房源在审核中,请在审核通过后上架！','error');
                    $error++;
                    continue;
                }
                $esf->sale_status = 1;
                // 上架操作 到期时间延续
                $esf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;

                if($esf->save())
                    $success++;
                else
                    $error++;
            }
        elseif($fids)
        {
            $esf = ResoldEsfExt::model()->findByPk($fids);
            if($esf->status != 1){
                    $this->setMessage('房源在审核中,请在审核通过后上架！','error');
                    return true;
                }
            $esf->sale_status = 1;
            // 上架操作 到期时间延续
            $esf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            // $esf->sale_time = $esf->refresh_time = time();
            // $esf->expire_time = time() + 30*86400;
            $esf->save();
        }
        $this->setMessage('上架成功'.$success.'条，失败'.$error.'条','success');
        return true;
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
                $esf = ResoldEsfExt::model()->findByPk($value);
                $esf->sale_status = 2;
                // 下架删除预约时间和加急时间
                ResoldAppointExt::model()->deleteAllByAttributes(['fid'=>$value,'uid'=>$this->staff->uid,'status'=>0,'type'=>1]);
                $esf->hurry = 0;

                if($esf->save())
                    $success++;
                else
                    $error++;
            }
        elseif($fids)
        {
            $esf = ResoldEsfExt::model()->findByPk($fids);
            $esf->sale_status = 2;
            // 下架删除预约时间和加急时间
            ResoldAppointExt::model()->deleteAllByAttributes(['fid'=>$fids,'uid'=>$this->staff->uid,'status'=>0,'type'=>1]);
            $esf->hurry = 0;
            if($esf->save())
                $success++;
            else
                $error++;
        }
        $this->setMessage('下架成功'.$success.'条，失败'.$error.'条','success');
        return true;
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
                $esf = ResoldEsfExt::model()->findByPk($value);
                // 删除就回收且未审核
                $esf->sale_status = 3;
                $esf->status = 0;
                $esf->save();
            }
        $this->setMessage('操作成功！','success');
        return true;
    }

    /**
     * [actionRefresh 刷新操作]
     * @param  [type] $fid        [description]
     * @param  [type] $expireTime [description]
     * @return [type]             [description]
     */
    public function actionRefresh($fid)
    {
        $success = $error = 0;
        if($fid)
            $fid = explode(',', $fid);

        if($fid && is_array($fid)) {
            $refreshInterval = SM::resoldConfig()->resoldRefreshInterval->value*60;
            $expireTime = SM::resoldConfig()->resoldExpireTime() * 86400;
            foreach ($fid as $key => $value) {

                $esf = ResoldEsfExt::model()->findByPk($value);
                if(time()-$esf->refresh_time > $refreshInterval)
                {
                    if(Yii::app()->db->createCommand('update resold_esf set refresh_time='.time().',expire_time='.(time()+$expireTime).' where id='.$value)->execute())
                        $success++;
                    else
                        $error++;
                }else {
                    $error++;
                }
            }
        }
            
        $this->setMessage('刷新成功'.$success.'条，失败'.$error.'条','success');
    }

    /**
     * [actionHurry 加急操作]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionHurry($fid)
    {
        $uid = $this->staff->uid;
        if($this->staff->getCanHurryNum()<=0)
        {
            $this->setMessage('套餐配额不足！','error');
        }
        else
        {
            $esf = ResoldEsfExt::model()->findByPk($fid);
            $esf->hurry = time();
            $esf->save();
            $this->setMessage('操作成功！','success');
        }
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
                    $refresh_time = Yii::app()->db->createCommand('select refresh_time from resold_esf where id='.$fid )->queryScalar();
                    for($i = 1;$i <= $day;$i++)
                    {
                        foreach ($time as $key => $value) {
                            list($hour,$minute) = explode(':', $value);
                            $esfAppoint = new ResoldAppointExt;
                            $esfAppoint->appoint_time = TimeTools::getDayBeginTime() + ($i - 1)*86400 + $hour*3600 + $minute*60;
                            $esfAppoint->uid = $uid;
                            $esfAppoint->fid = $fid;
                            $esfAppoint->type = 1;
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
                                $esfAppoint->type = 1;
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
            $this->redirect('saleup');
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
        $esf = ResoldEsfExt::model()->findByPk($fid);
        $esf->appoint_time = 0;
        $esf->save();
        $this->setMessage('操作成功！','success');
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
        $this->redirect('/vip/esf/appointList?fid='.$fid);
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
            $esf = ResoldEsfExt::model()->findAll($criteria);
        }
        else
        {
            $esf = [ResoldEsfExt::model()->findByPk($fid)];
        }
        $this->render('setappoint',['esf'=>$esf]);
    }

    /**
     * [actionAppointList 预约列表]
     * @param  [type] $fid [description]
     * @return [type]      [description]
     */
    public function actionAppointList($fid)
    {
        $esf = ResoldEsfExt::model()->findByPk($fid);
        $appoints = ResoldAppointExt::model()->findAll(['condition'=>'fid=:fid and type=1','params'=>[':fid'=>$fid],'order'=>'appoint_time asc']);
        $this->render('appointlist',['esf'=>$esf,'appoints'=>$appoints]);
    }

}
