<?php
/**
 * 我的租房
 * User: jt
 * Date: 2016/11/8 19:24
 */
class MyzfController extends UcenterController{

    //发布出租
    public function actionRentInput(){
        $this->render('rent/input');
    }

    //保存出租
    public function actionRentSave(){
        if(Yii::app()->request->isPostRequest && $post_data = $_POST) {
            if (isset($post_data['images']) && !empty($post_data['images'])) {
                $post_data['image_count'] = count($post_data['images']);
                if(!isset($post_data['image']) || empty($post_data['image'])){
                    $post_data['image'] = $post_data['images']['0'];
                }else{
                    if(!in_array($post_data['image'],$post_data['images'])){
                        $post_data['image'] = $post_data['images']['0'];
                    }
                }
            }
            $post_data['source'] = $this->source;
            $post_data['status'] = $this->status;
            $category = Yii::app()->params['categoryPinyin'][$post_data['category']];
            if(isset($post_data['id']) && !empty($post_data['id'])){
                $resold_zf = ResoldZfExt::model()->normal()->findByPk($post_data['id'],'t.uid=:uid',array(':uid'=>$this->uid));
                if(!$resold_zf)
                    $this->response(false,'房源不存在');
                $resold_zf->scenario = $category;
            }else{
                $resold_zf = new ResoldZfExt($category);
            }

            //检测手机号
            $this->checkPhone($post_data['phone'],$post_data['code'],$resold_zf->phone);

            $resold_zf->attributes = $post_data;
            $resold_zf->setPay_jiao($post_data['pay_jiao']);
            $resold_zf->setPay_ya($post_data['pay_ya']);
            $resold_zf->uid = $this->uid;
            if(!$resold_zf->getIsNewRecord() && (!isset($post_data['zfspkjyxm']) || empty($post_data['zfspkjyxm']))){
                $data_conf = json_decode($resold_zf->data_conf,true);
                if(isset($data_conf['zfspkjyxm']) && $data_conf['zfspkjyxm']){
                    unset($data_conf['zfspkjyxm']);
                    $resold_zf->data_conf = $data_conf;
                }
            }
            $t = Yii::app()->db->beginTransaction();
            try{
                if(!$resold_zf->save()){
                    $errors = $resold_zf->getErrors();
                    throw new CException(current($errors)[0]);
                }
                if(!$resold_zf->getIsNewRecord()){
                    ResoldImageExt::model()->deleteAll('fid=:fid and type=:type',array(':fid'=>$resold_zf->id,':type'=>ResoldImageExt::ZF_TYPE));
                }
                if(isset($post_data['images']) && $images = $post_data['images']){
                    foreach ($images as $item){
                        $resold_image = new ResoldImageExt();
                        $resold_image->fid = $resold_zf->id ;
                        $resold_image->url = $item;
                        $resold_image->source = $this->source;
                        $resold_image->type = ResoldImageExt::ZF_TYPE;
                        if(!$resold_image->save())
                            throw new CException('保存失败');
                    }
                }
                $t->commit();
                $this->renderOutput(true,'发布成功',array(
                    'info_url'=>$this->createUrl('/resoldhome/myzf/rentedit',array('id'=>$resold_zf->id)),
                    'list_url'=>$this->createUrl('/resoldhome/myzf/rentindex'),
                    'input_url'=>$this->createUrl('/resoldhome/myzf/rentinput')
                ));
            }catch (CException $e){
                $t->rollback();
                $this->response(false,$e->getMessage());
            }
        }
    }

    //出租列表
    public function actionRentIndex(){
        $criteria = new CDbCriteria(array(
            'condition'=>'t.uid=:uid',
            'params'=>array(':uid'=>$this->uid),
            'with'=>array('areaInfo','streetInfo','plot'),
            'order'=>'t.refresh_time asc , t.created desc',
        ));
        $dataProvider = ResoldZfExt::model()->normal()->getList($criteria,$this->pageSize);
        foreach ($dataProvider->data as $value){
            $value->data_conf = json_decode($value->data_conf,true);
        }
        $this->render('rent/index',array('dataProvider'=>$dataProvider));
    }

    //更新出租
    public function actionRentEdit($id){
        $resold_zf = ResoldZfExt::model()->normal()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
        $resold_zf->data_conf = json_decode($resold_zf->data_conf,true);
        if($resold_zf->images){
            $images = array();
            foreach ($resold_zf->images as $image){
                $images[] = $image->url;
            }
            $resold_zf->images = $images;
        }
        $this->render('rent/edit',array('model'=>$resold_zf));
    }

    public function actionRentDelete($id){
        if(Yii::app()->request->isAjaxRequest){
            $resold_zf = ResoldZfExt::model()->normal()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_zf)
                $this->response(false, '找不到房源');
            $sale_status_arr = array_flip(Yii::app()->params['saleStatus']);
            $resold_zf->status = 0;
            $resold_zf->sale_status = $sale_status_arr['回收'];
            $resold_zf->save();
            $this->response(true,'删除成功');
        }
    }

    //出租刷新
    public function actionRefresh(){
        if(Yii::app()->request->isPostRequest && $id = $_POST['id']){
            $resold_zf = ResoldZfExt::model()->normal()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_zf)
                $this->response(false,'出租房源不存在');
            if($resold_zf->status != 1)
                $this->response(false, '出租房源审核未通过');
            if($resold_zf->sale_status != 1)
                $this->response(false, '出租房源还未上架');
            if($resold_zf->isRefresh){
                $space = SM::resoldConfig()->resoldRefreshInterval->value * 60;
                $this->response(false,'休息'.ceil(($space - (time()-$resold_zf->refresh_time))/60).'分钟再来刷新吧');
            }
            $resold_zf->refresh_time = time();
            $resold_zf->save();
            $this->response(true,'刷新成功');
        }
    }

    public function actionForRentRefresh(){
        if(Yii::app()->request->isPostRequest && $id = $_POST['id']){
            $resold_qz = ResoldQzExt::model()->undeleted()->findByPk($id,'uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_qz)
                $this->response(false,'求租房源不存在');
            if($resold_qz->status != 1)
                $this->response(false, '求租房源审核未通过');
            if($resold_qz->isRefresh){
                $space = SM::resoldConfig()->resoldRefreshInterval->value * 60;
                $this->response(false,'休息'.ceil(($space - (time()-$resold_qz->refresh_time))/60).'分钟再来刷新吧');
            }
            $resold_qz->refresh_time = time();
            $resold_qz->save();
            $this->response(true,'刷新成功');
        }
    }

    //求租列表
    public function actionForRentIndex(){
        $criteria = new CDbCriteria(array(
            'condition'=>'uid=:uid',
            'params'=>array(':uid'=>$this->uid),
            'with'=>array('areaInfo'),
            'order'=>'t.refresh_time asc , t.created desc',
        ));
        $dataProvider = ResoldQzExt::model()->undeleted()->getList($criteria,$this->pageSize);
        foreach ($dataProvider->data as $item){
            $item->data_conf = json_decode($item->data_conf,true);
        }
        $this->render('forrent/index',array('dataProvider'=>$dataProvider));
    }

    //发布求租
    public function actionForRentInput(){
        $this->render('forrent/input');
    }

    public function actionForRentSave(){
        if(Yii::app()->request->isPostRequest && $post_data = $_POST){
            $category = Yii::app()->params['categoryPinyin'][$post_data['category']];
            if(isset($post_data['id']) && $id = $post_data['id']){
                $resold_qz = ResoldQzExt::model()->undeleted()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
                if(!$resold_qz)
                    $this->response(false,'找不到求租');
                $resold_qz->setScenario($category);
            }else{
                $resold_qz = new ResoldQzExt();
                $resold_qz->setScenario($category);
            }
            //检测手机号
            $this->checkPhone($post_data['phone'],$post_data['code'],$resold_qz->phone);

            $resold_qz->attributes = $post_data;
            $resold_qz->uid = $this->uid;
            $resold_qz->status = $this->status;
            $data_conf = array_filter(ResoldQzExt::getTagName());
            if($data_conf){
                $resold_qz->data_conf = json_encode($data_conf);
            }
            if($resold_qz->save()){
                $this->renderOutput(true,'发布成功',array(
                    'info_url'=>$this->createUrl('/resoldhome/myzf/forrentedit',array('id'=>$resold_qz->id)),
                    'list_url'=>$this->createUrl('/resoldhome/myzf/forrentindex'),
                    'input_url'=>$this->createUrl('/resoldhome/myzf/forrentinput')
                ));
            }
            $this->response(false,current($resold_qz->getErrors())[0]);
        }
    }

    public function actionForRentEdit($id){
        $resold_qz = ResoldQzExt::model()->undeleted()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
        if(!$resold_qz)
            throw new CHttpException(404,'找不到房源');
        $resold_qz->data_conf = json_decode($resold_qz->data_conf,true);
        $this->render('forrent/edit',array('model'=>$resold_qz));
    }

    public function actionForRentDelete($id){
        if(Yii::app()->request->isAjaxRequest){
            $resold_zf = ResoldQzExt::model()->undeleted()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_zf)
                $this->response(false, '找不到房源');
            $resold_zf->deleted = 1;
            $resold_zf->status = 0 ;
            $resold_zf->save();
            $this->response(true,'删除成功');
        }
    }
}