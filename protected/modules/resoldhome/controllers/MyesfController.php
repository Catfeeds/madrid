<?php
/**
 * 二手房管理
 * User: jt
 * Date: 2016/11/5 10:05
 */

class MyesfController extends UcenterController{

    /*
     * 发布出售房源
     */
    public function actionSellInput(){
        $resold_esf = ResoldEsfExt::model();
        $this->render('sell/input',array('model'=>$resold_esf));
    }

    public function actionSellEdit($id){
        $resold_esf = ResoldEsfExt::model()->with('plot')->normal()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
        if(!$resold_esf)
            throw new CHttpException(404,'找不到房源');
        $resold_esf->data_conf = json_decode($resold_esf->data_conf,true);
        $resold_esf->data_conf = TagExt::getNameByTag($resold_esf->data_conf['tags'],true);
        if($resold_esf->images){
            $images = array();
            foreach ($resold_esf->images as $image){
                $images[] = $image->url;
            }
            $resold_esf->images = $images;
        }
        $this->render('sell/edit',array('model'=>$resold_esf));
    }

    public function actionSellSave(){
        if(Yii::app()->request->isPostRequest && $post_data = $_POST){
            if(isset($post_data['images']) && !empty($post_data['images'])){
                $post_data['image_count'] = count($post_data['images']);
                if(!isset($post_data['image']) || empty($post_data['image'])){
                    $post_data['image'] = $post_data['images']['0'];
                }else{
                    if(!in_array($post_data['image'],$post_data['images'])){
                        $post_data['image'] = $post_data['images']['0'];
                    }
                }
            }
            $plot = PlotExt::model()->findByPk($post_data['hid']);
            if(!$plot)
                $this->response(false,'小区不存在');
            $post_data['plot_name'] = $plot->title ;
            $post_data['status'] = $this->status;  //审核中
            $post_data['source'] = $this->source; //个人
            $post_data['data_conf'] = CJSON::encode(['tags'=>$post_data['tags']]);
            $category = Yii::app()->params['categoryPinyin'][$post_data['category']];
            $t = Yii::app()->db->beginTransaction();
            if(isset($post_data['id']) && !empty($post_data['id'])){
                $resold_esf = ResoldEsfExt::model()->normal()->findByPk($post_data['id'],'t.uid=:uid',array(':uid'=>$this->uid));
                if(!$resold_esf)
                    $this->response(false,'找不到房源');
                $resold_esf->scenario = $category;
            }else{
                $resold_esf = new ResoldEsfExt($category);
            }
            //检测手机号
            $this->checkPhone($post_data['phone'],$post_data['code'],$resold_esf->phone);
            $resold_esf->attributes = $post_data;
            $resold_esf->uid = $this->uid;
            if(isset($post_data['esfspkjyxm']) && !empty($post_data['esfspkjyxm'])){
                $resold_esf->esfspkjyxm = $post_data['esfspkjyxm'];
            }
            try{
                if(!$resold_esf->save()){
                    $errors = $resold_esf->getErrors();
                    throw new CException(current($errors)[0]);
                }
                if(!$resold_esf->getIsNewRecord()){
                    ResoldImageExt::model()->deleteAll('fid=:fid and type=:type',array(':fid'=>$resold_esf->id,':type'=>ResoldImageExt::ESF_TYPE));
                }
                if(isset($post_data['images']) && $post_data['images']){
                    foreach ($post_data['images'] as $item){
                        $resold_image = new ResoldImageExt();
                        $resold_image->fid = $resold_esf->id ;
                        $resold_image->url = $item;
                        $resold_image->source = $this->source;
                        $resold_image->type = ResoldImageExt::ESF_TYPE;
                        if(!$resold_image->save())
                            throw new CException('保存失败');
                    }
                }
                $t->commit();
                $this->renderOutput(true,'发布成功',array(
                    'info_url'=>$this->createUrl('/resoldhome/myesf/selledit',array('id'=>$resold_esf->id)),
                    'list_url'=>$this->createUrl('/resoldhome/myesf/sellindex'),
                    'input_url'=>$this->createUrl('/resoldhome/myesf/sellinput')
                ));
            }catch (CException $e){
                $t->rollback();
                $this->response(false,$e->getMessage());
            }
        }
    }


    //管理出售房源
    public function actionSellIndex(){
        $criteria = new CDbCriteria(array(
            'order'=>'t.refresh_time asc , t.created desc',
            'condition'=>'t.uid=:uid',
            'with'=>array('areaInfo','plot'),
            'params'=>array(':uid'=>$this->uid),
        ));
        $dataProvider = ResoldEsfExt::model()->normal()->getList($criteria,$this->pageSize);
        foreach ($dataProvider->data as $value){
            $value->data_conf = json_decode($value->data_conf,true);
            $value->data_conf = TagExt::getNameByTag($value->data_conf['tags'],true);
        }
        $this->render('sell/index',array('dataProvider'=>$dataProvider));
    }

    public function actionRefresh(){
        if(Yii::app()->request->isPostRequest && $id = $_POST['id']){
            $resold_esf = ResoldEsfExt::model()->normal()->findByPk($id,'uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_esf)
                $this->response(false,'出售房源不存在');
            if($resold_esf->status != 1)
                $this->response(false, '出售房源审核未通过');
            if($resold_esf->sale_status != 1)
                $this->response(false, '出售房源还未上架');
            if($resold_esf->isRefresh){
                $space = SM::resoldConfig()->resoldRefreshInterval->value * 60;
                $this->response(false,'休息'.ceil(($space - (time()-$resold_esf->refresh_time))/60).'分钟再来刷新吧');
            }
            $resold_esf->refresh_time = time();
            $resold_esf->save();
            $this->response(true,'刷新成功');
        }
    }

    public function actionBuyRefresh(){
        if(Yii::app()->request->isPostRequest && $id = $_POST['id']) {
            $resold_qg = ResoldQgExt::model()->undeleted()->findByPk($id,'uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_qg)
                $this->response(false,'求购房源不存在');
            if($resold_qg->status != 1)
                $this->response(false, '求购房源审核未通过');
            if($resold_qg->isRefresh){
                $space = SM::resoldConfig()->resoldRefreshInterval->value * 60;
                $this->response(false,'休息'.ceil(($space - (time()-$resold_qg->refresh_time))/60).'分钟再来刷新吧');
            }
            $resold_qg->refresh_time = time();
            $resold_qg->save();
            $this->response(true,'刷新成功');
        }
    }

    public function actionSellDelete($id){
        if(Yii::app()->request->isAjaxRequest){
            $resold_esf = ResoldEsfExt::model()->undeleted()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_esf)
                $this->response(false, '找不到房源');
            $sale_status_arr = array_flip(Yii::app()->params['saleStatus']);
            $resold_esf->status = 0;
            $resold_esf->sale_status = $sale_status_arr['回收'];
            $resold_esf->save();
            $this->response(true,'删除成功');
        }
    }

    //管理求购房源
    public function actionBuyIndex(){
        $criteria = new CDbCriteria(array(
            'condition'=>'t.uid=:uid',
            'params'=>array(':uid'=>$this->uid),
            'order'=>'t.refresh_time asc , t.created desc',
            'with'=>array('areaInfo','streetInfo')
        ));
        $dataProvider = ResoldQgExt::model()->undeleted()->getList($criteria,$this->pageSize);
        $this->render('buy/index',array('dataProvider'=>$dataProvider));
    }

    public function actionBuyInput(){
        $this->render('buy/input');
    }

    public function actionBuySave(){
        if(Yii::app()->request->isPostRequest && $post_data = $_POST){
            $category = Yii::app()->params['categoryPinyin'][$post_data['category']];
            if(isset($post_data['id']) && !empty($post_data['id'])){
                $resold_qg = ResoldQgExt::model()->undeleted()->findByPk($post_data['id'],'t.uid=:uid',array(':uid'=>$this->uid));
                if(!$resold_qg)
                    $this->response(false,'找不到房源');
                $resold_qg->setScenario($category);
            }else{
                $resold_qg = new ResoldQgExt();
                $resold_qg->setScenario($category);
            }
            //检测手机号
            $this->checkPhone($post_data['phone'],$post_data['code'],$resold_qg->phone);

            if(isset($post_data['hid']) && $post_data['hid'])
                $post_data['hid'] = json_encode($post_data['hid']);
            $resold_qg->attributes = $post_data;
            if(isset($post_data['tags']) && $post_data['tags']){
                $resold_qg->data_conf = json_encode(array('tags'=>$post_data['tags']));
            }
            $resold_qg->uid = $this->uid;
            $resold_qg->status = $this->status; //审核中
            if($resold_qg->save())
                $this->renderOutput(true,'发布成功',array(
                    'info_url'=>$this->createUrl('/resoldhome/myesf/buyedit',array('id'=>$resold_qg->id)),
                    'list_url'=>$this->createUrl('/resoldhome/myesf/buyindex'),
                    'input_url'=>$this->createUrl('/resoldhome/myesf/buyinput')
                ));
            $this->response(false,current($resold_qg->getErrors())[0]);
        }
    }

    public function actionBuyDelete($id){
        if(Yii::app()->request->isAjaxRequest){
            $resold_qg = ResoldQgExt::model()->undeleted()->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
            if(!$resold_qg)
                $this->response(false, '找不到房源');
            $resold_qg->deleted = 1;
            $resold_qg->status = 0 ;
            $resold_qg->save();
            $this->response(true,'删除成功');
        }
    }

    public function actionBuyEdit($id){
        $resold_qg = ResoldQgExt::model()->undeleted()->with('streetInfo')->findByPk($id,'t.uid=:uid',array(':uid'=>$this->uid));
        if(!$resold_qg)
            throw new CHttpException(404,'找不到房源');
        $resold_qg->data_conf = json_decode($resold_qg->data_conf,true);
        $resold_qg->data_conf = TagExt::getNameByTag($resold_qg->data_conf['tags'],true);
        $this->render('buy/edit',array('model'=>$resold_qg));
    }


}