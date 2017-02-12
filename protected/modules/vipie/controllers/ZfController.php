<?php
/**
 *
 * User: jt
 * Date: 2017/1/20 10:27
 */

class ZfController extends VipieController{

    /**
     * 发布
     */
    public function actionPublish($id=''){
        if($id){
            $model  = ResoldZfExt::model()->undeleted()->findByPk($id,[
                'condition'=>'uid=:uid',
                'params'=>[':uid'=>$this->staff->uid],
            ]);
        }else{
            $model = new ResoldZfExt();
            $model->category = 1;
        }
        $allTag = TagExt::getAllByCate();
        $this->render('publish',['model'=>$model,'allTag'=>$allTag]);
    }

    public function actionSave(){
        if(Yii::app()->request->isPostRequest){
            $images = Yii::app()->request->getPost('images', array());
            $images = array_combine($images,Yii::app()->request->getPost('image_des', array()));
            $params = Yii::app()->request->getPost('ResoldZfExt', []);
            //信息来源 params.php source
            $source_arr = array_flip(Yii::app()->params['source']);
            $params['origin'] = $source_arr['中介']; //信息来源为中介

            //封面赋值
            $params['image'] = Yii::app()->request->getPost('fm', ""); //封面图
            $params['image_count'] = count(Yii::app()->request->getPost('images', []));//上传图片数量

            //发布人姓名、ID、手机号、所属商家
            $params['uid'] = $this->staff->uid;
            $params['sid'] = $this->staff->sid;
            $params['username'] = $this->staff->name;
            $params['phone'] = $this->staff->phone;
            $zf = new ResoldZfExt();
//            $tip = $id > 0 ? '修改' : '添加';
            $zf->scenario = Yii::app()->params['categoryPinyin'][$params['category']];
            $zf->attributes = $params;
            $dataconf = [];
            foreach ([
                         'esfzfzztype' => '',//二手房租房住宅类型
                         'esfzfsptype' => '',//二手房租房商铺类型
                         'zfspkjyxm' => [],//租房商铺可经营项目
                         'esfzfxzltype' => '',//二手房租房写字楼类型
                         'resoldface' => '',//朝向
                         'zfzzpt' => [],//租房住宅配套
                         'zfzzts' => [],//租房住宅特色
                         'zfsppt' => [],//租房商铺配套
                         'zfspts' => [],//租房商铺特色
                         'zfxzlts' => [],//租房写字楼特色
                         'zfxzlpt' => [],//租房写字楼配套
                         'zfxzllevel' => '',//租房写字楼等级
                         'esfsplevel' => '',//租房商铺等级
                         'esffloorcate' => ''//租房楼层等级
                     ] as $key => $value) {
                if(isset($params[$key]) && $params[$key])
                    $dataconf[$key] = $params[$key];
            }
            $zf->data_conf = json_encode($dataconf);
            $zf->source = 2;

            //后台中介，无需审核，默认为上架
            $status_arr = array_flip(Yii::app()->params['checkStatus']);
            $saleStatus_arr = array_flip(Yii::app()->params['saleStatus']);
            if (empty($zf->status)) {
                $zf->status = $status_arr["正常"];
            }
            if(!$zf->id && $zf->sale_status!=2)
                $zf->refresh_time = $zf->sale_time = time();
            $zf->sale_status = ($zf->sale_status != $saleStatus_arr['下架'] && $this->staff->getCanSaleNum() > 0) ? $saleStatus_arr['上架'] : $saleStatus_arr['下架'];
            if($zf->sale_status == 1) {
                $zf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            }
            // 有相册无封面取第一张图作为封面
            $imgs = [];
            if($images)
                foreach ($images as $key => $value) {
                    $imgs[] = $key;
                }
            if($imgs && !in_array($zf->image, $imgs))
                $zf->image = $imgs[0];
            elseif(!$imgs)
                $zf->image = '';
            if ($zf->save()) {
                //图片处理
                if ($images) {
                    ResoldImageExt::model()->deleteAllByAttributes(array('fid' => $zf->id));
                    foreach ($images as $key => $v) {
                        $image_rel = new ResoldImageExt;
                        $image_rel->fid = $zf->id;
                        $image_rel->name = $v;
                        $image_rel->url = $key;
                        $image_rel->type = 2;
                        $image_rel->save();
                    }
                } else {
                    ResoldImageExt::model()->deleteAllByAttributes(array('fid' => $zf->id));
                }
                $this->response(true,'保存成功');
            } else {
                $errors = array_values($zf->getErrors());
                
            }
        }
    }

    /**
     * 已上架租房
     */
    public function actionSaleUp($type="title",$value = "",$time_type="created",$start_time="",$end_time="",$hid="",$sort="",$category=0){
        $dataProvider = $this->sale(true,$type,$value,$time_type,$start_time,$end_time,$hid,$sort,$category);
        //筛选上架房源中出现过的房源
        $plots = $this->getPlots();
        $this->render("saleUp", compact('dataProvider','type','value','start_time','end_time','time_type','hid','plots','category','sort'));
    }

    /**
     * 下架租房
     */
    public function actionSaleDown($type='title',$value='',$time_type = 'created', $start_time='' , $end_time='' ,$hid=0,$sort='',$category=0){
        $dataProvider = $this->sale(false,$type,$value,$time_type,$start_time,$end_time,$hid,$sort,$category);
        $plots = $this->getPlots();
        $this->render('saleDown',compact('dataProvider','type','value','start_time','end_time','time_type','hid','plots','category','sort'));
    }

    protected function getPlots(){
        $plots = [];
        $condition = new CDbCriteria([
            'condition' => 'uid = :uid and sale_status=1',
            'params' => [
                ':uid' => $this->staff->uid
            ]
        ]);
        $data = ResoldZfExt::model()->undeleted()->findAll($condition);
        foreach ($data as $item) {
            $plots[$item->hid] = $item->plot_name;
        }
        return $plots;
    }

    protected function sale($onSale=true,$type,$value,$time_type,$start_time,$end_time,$hid,$sort,$category){
        $criteria = new CDbCriteria([
            'condition'=>'uid=:uid',
            'params'=>[':uid'=>$this->staff->uid],
            'order' => 'sort desc ,refresh_time asc,created desc'
        ]);
        //排序条件
        if ($sort) {
            $st = strpos($sort, 'up') ? ' asc' : ' desc';
            $fields = strpos($sort, 'sale') ? ' sale_time' : ' refresh_time';
            $criteria->order = $fields . $st;
        }
        //添加时间、刷新时间筛选 $time[created,refresh_time,sale_time]
        if ($time_type && $start_time) {
           /* $criteria->addCondition("{$time_type}>=:beginTime and {$time_type}<:endTime");
            $criteria->params[':beginTime'] = $beginTime;
            $criteria->params[':endTime'] = $endTime + 86400;*/
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->params[':beginTime'] = strtotime($start_time);
        }
        if($time_type && $end_time){
            $criteria->addCondition("{$time_type}<=:endTime");
            $criteria->params[':endTime'] = strtotime($end_time);
        }
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
        if($onSale){
            $criteria->addCondition('sale_status=1 and deleted=0 and status=1');
        }else{
            $criteria->addCondition('deleted=0 and sale_status=2');
        }
        return ResoldZfExt::model()->getList($criteria,20);
//        return $onSale ? ResoldZfExt::model()->saling()->getList($criteria,20) : ResoldZfExt::model()->undeleted()->saleout()->getList($criteria,20);
    }

    /**
     * 刷新
     */
    public function actionRefresh(){
        if(Yii::app()->request->isPostRequest){
            $id = Yii::app()->request->getPost('id');
            if(!is_array($id))
                $id = (array)$id;
            $resold_zf = $this->findModelByIds($id);
            if($resold_zf){
                foreach ($resold_zf as $item){
                    if(!$item->isRefresh) {
                        $item->refresh_time = time();
                        $item->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
                        $item->save();
                    }
                }
            }
            $this->response(true,'刷新成功');
        }
    }
    /**
     * 加急
     */
    public function actionHurry(){
        if(Yii::app()->request->isPostRequest){
            $id = Yii::app()->request->getPost('id');
            if($this->staff->getCanHurryNum()<=0) {
                $this->response(false,'套餐配额不足！');
            }else {
                $resold_zf = ResoldZfExt::model()->findByPk($id);
                if(empty($resold_zf)){
                    $this->response(false,'房源未找到');
                }
                if($resold_zf->hurry > 0 && time()-$resold_zf->hurry<SM::resoldConfig()->resoldHurryTime->value*3600){
                    $this->response(false,'您已加急');
                }
                $resold_zf->hurry = time();
                $resold_zf->save();
                $this->response(true,'加急成功');
            }
        }
    }
    /**
     * 删除
     */
    public function actionDelete(){
        if(Yii::app()->request->isPostRequest){
            $id = Yii::app()->request->getPost('id');
            if(!is_array($id))
                $id = (array)$id;
            $resold_zf = $this->findModelByIds($id,false);
            if($resold_zf){
                foreach ($resold_zf as $item){
                    $item->deleted = 1;
                    $item->save();
                }
            }
            $this->response(true, '删除成功');
        }

    }
    /**
     * 预约刷新
     */
    public function actionAppointRefresh(){}
    /**
     * 下架函数 支持批量或单个 post或get请求
     */
    public function actionDownSale(){
        if(Yii::app()->request->isPostRequest){
            $id = Yii::app()->request->getPost('id');
            if(!is_array($id))
                $id = (array)$id;
            $resold_zf = $this->findModelByIds($id);
            if($resold_zf){
               foreach ($resold_zf as $item) {
                   $item->sale_status = 2;
                   // 下架删除预约时间和加急时间
                   ResoldAppointExt::model()->deleteAllByAttributes(['fid' => $item->id, 'uid' => $this->staff->uid, 'status' => 0, 'type' => 2]);
                   $item->hurry = 0;
                   $item->save();
               }
            }
            $this->response(true,'下架成功');
        }
    }
    /**
     * 上架所选
     */
    public function actionUpSale(){
        if(Yii::app()->request->isPostRequest){
            if($this->staff->getCanSaleNum()<=0){
                $this->response(false,'套餐配额不足');
            }
            $id = Yii::app()->request->getPost('id');
            if(!is_array($id)) {
                $id = (array)$id;
            }
            $resold_zf = $this->findModelByIds($id,false);
            if($resold_zf) {
                foreach ($resold_zf as $item) {
                    $item->sale_status = 1;
                    $item->status = 1;
                    $item->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
                    $item->save();
                }
            }
            $this->response(true,'上架成功');
        }
    }
    /**
     * 预约操作
     */
    public function actionAppoint(){}
    /**
     * 取消预约操作
     */
    public function actionDelAppoint($fid){}
    /*
     * 设置预约的界面
     */
    public function actionSetAppoint($fid){}
    /**
     * 单个取消预约操作
     */
    public function actionDelSingleAppoint($id,$fid){}
    /**
     * 预约列表
     */
    public function actionAppointList($fid){}

    protected function findModelByIds($ids,$sale=true){
        $condition = new CDbCriteria([
            'condition'=>'uid=:uid',
            'params'=>[':uid'=>$this->staff->uid],
        ]);
        $condition->addInCondition('id',$ids);
        return $sale ? ResoldZfExt::model()->saling()->findAll($condition) : ResoldZfExt::model()->undeleted()->saleout()->findAll($condition);
    }

}