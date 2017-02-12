<?php
/**
 * 楼盘相关
 * @author 19%gris
 * @date 2015-09-16
 */
class ResoldPlotController extends AdminController
{
    /**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
            array('allow',
                'actions' => array('ajaxGetHouse'),
            ),
			array('allow',
				'roles' => array('guanlineirong','ershoufangguanli'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}

    public function actions()
    {
        $alias = 'admin.controllers.ResoldPlot.';
        return array(
            'houseTypeList' => $alias.'houseType.ListAction',
            'houseTypeEdit' => $alias.'houseType.EditAction',
            'houseTypeDelete' => $alias.'houseType.DeleteAction',
            'periodList' => $alias.'period.ListAction',
            'periodEdit' => $alias.'period.EditAction',
            'periodDelete' => $alias.'period.DeleteAction',
            'periodStatus' => $alias.'period.AjaxStatusAction',
            'buildingList' => $alias.'building.ListAction',
            'buildingEdit' => $alias.'building.EditAction',
            'buildingDelete' => $alias.'building.DeleteAction',
            'commentList' => $alias.'comment.ListAction',
            'commentEdit' => $alias.'comment.EditAction',
            'commentDelete' => $alias.'comment.DeleteAction',
            'evaluate' => $alias.'evaluate.EditAction',
            'evaluateItem' => $alias.'evaluate.ItemAction',
            'redList' => $alias.'red.ListAction',
            'redEdit' => $alias.'red.EditAction',
            'redDelete' => $alias.'red.DeleteAction',
            'redStatus' => $alias.'red.AjaxStatusAction',
            'imagelist' => $alias.'image.ListAction',
        );
    }

    /**
     * 添加、编辑楼盘
     * @param  integer $id 楼盘id
     */
    public function actionEdit($id=0)
    {
        $plot = $id == 0 ? new PlotExt : PlotExt::model()->findByPk($id);
        if (Yii::app()->request->isPostRequest && !empty($_POST['PlotExt'])) {
            //楼盘编辑需要使用事务
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $plot->attributes = $_POST['PlotExt'];
                // var_dump($plot);die;
                $plot->save();
                $plot->saveTag();
                if($plot->hasErrors())
                    throw new Exception(current(current($plot->getErrors())));
                else
                {
                    $transaction->commit();
                    $this->setMessage('保存成功！', 'success', true);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                $this->setMessage('保存失败！', 'error');
            }
        }
        $parentArea = AreaExt::model()->parent()->normal()->findAll();
        $parent = $plot->area?$plot->area:(isset($parentArea[0])?$parentArea[0]->id:0);
        $childArea = $parent ? AreaExt::model()->getByParent($parent)->normal()->findAll() : array(0=>'--无子分类--');
        $maps = array('zoom' => 14, 'lat' => SM::globalConfig()->mapLat() ? SM::globalConfig()->mapLat() : "31.810077", 'lng' => SM::globalConfig()->mapLng ? SM::globalConfig()->mapLng : "119.974454");
        $this->render('admin/plot/edit', array('parentArea' => $parentArea, 'childArea' => $childArea, 'plot' => $plot, 'maps' => $maps));
    }

    /**
     * 楼盘列表
     * @param  string $type   搜索类型
     * @param  string $value  搜索值
     * @param  string $status 状态
     */
    public function actionList($type='', $value='', $status='', $new='')
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc ,recommend desc ,open_time desc',
        ));
        if ($type=='title') {
            $criteria->addSearchCondition('title', $value);
        } elseif ($type=='id') {
            $criteria->addCondition('id=:id');
            $criteria->params[':id'] = $value;
        }
        if ($status!='') {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $status;
        }
        if($new != '') {
            $criteria->addCondition('is_new=:new');
            $criteria->params[':new'] = $new;
        }

        $dataProvider = PlotExt::model()->undeleted()->getList($criteria);
        $this->render('list', array(
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'type' => $type,
            'value' => $value,
            'status' => $status,
            'new' => $new,
        ));
    }

    /**
     * ajax删除楼盘
     */
    public function actionAjaxDel()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $plot = PlotExt::model()->findByPk($id);
            if ($plot && $plot->delete()) {
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }

    /**
     * ajax修改楼盘状态
     */
    public function actionAjaxStatus()
    {
        if (Yii::app()->request->isPostRequest) {
            $ids = Yii::app()->request->getPost('ids', false);
            $status = Yii::app()->request->getPost('status', false);

            if ($ids!==false && $status!==false) {
                $ids = explode(',', $ids);
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', $ids);
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $data = PlotExt::model()->findAll($criteria);
                    foreach ($data as $v) {
                        $v->changeStatus($status);
                    }
                    $transaction->commit();
                    $this->setMessage('操作成功', 'success');
                    Yii::app()->end();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }
            $this->setMessage('操作失败!', 'error');
        }
    }

    /**
     * ajax修改楼盘推荐时间
     */
    public function actionAjaxRecomTime()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $plot = PlotExt::model()->findByPk($id);
            $time = Yii::app()->request->getPost('time', 0);
            $plot->recommend = $time;
            if ($plot->save()) {
                $this->setMessage('推荐修改成功', 'success');
            } else {
                $this->setMessage('推荐修改失败', 'error');
            }
        }
    }


    /**
     * ajax修改楼盘排序
     */
    public function actionAjaxPlotSort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int)Yii::app()->request->getParam('id', 0);
            $sort = (int)Yii::app()->request->getParam('sort', 0);
            $plot = PlotExt::model()->findByPk($id);
            if ($plot && $plot->sort($sort)) {
                echo CJSON::encode(array('num'=>1, 'sort'=>$sort));
            }
        }
    }


    /**
     * 楼盘图库添加图片
     * @param  integer $hid 关联的楼盘id
     */
    public function actionImageAdd($hid)
    {
        $hid = (int)$hid;
        $this->layout = '/layouts/modal_base';

        $ctype = CHtml::listData(TagExt::model()->getTagByCate('xcfl')->normal()->findAll(), 'id', 'name');
        if (Yii::app()->request->isPostRequest) {
            $postData = Yii::app()->request->getPost('img', array());
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($postData as $tagId=>$tagImgs) {
                    foreach ($tagImgs as $img) {
                        $model = new PlotImgExt;
                        $model->attributes = $img;
                        $model->hid = $hid;
                        $model->type = $tagId;
                        $model->save();
                        if ($model->hasErrors()) {
                            throw new Exception(current(current($model->getErrors())));
                        }
                    }
                }
                $transaction->commit();
                $plot = PlotExt::model()->findByPk($hid);
                $plot->save();
                $this->setMessage('保存成功！', 'success',  array('/admin/plot/imagelist', 'hid'=>$hid));
            } catch (Exception $e) {
                $transaction->rollback();
                $msg = $model->hasErrors() ? $e->getMessage(): '保存失败！';
                $this->setMessage($msg, 'error');
            }
        }
        $this->render('imageadd', array(
            'ctype' => $ctype,
            'hid'   => $hid
        ));
    }

    /**
     * 编辑图片
     */
    public function actionImageEdit($id)
    {
        $id = (int)$id;
        $this->layout = '/layouts/modal_base';
        $image = PlotImgExt::model()->findByPk($id);
        if (Yii::app()->request->isPostRequest) {
            $image->attributes = Yii::app()->request->getPost('PlotImgExt', array());
            if ($image->save()) {
                $this->setMessage('保存成功！', 'success',  array('/admin/plot/imageList', 'hid'=>$image->hid));
            } else {
                $this->setMessage('保存失败！', 'error');
            }
        }
        $this->render('imageedit', array(
            'image' => $image,
        ));
    }

    /**
     * ajax设为封面
     */
    public function actionAjaxSetCover()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $model = PlotImgExt::model()->findByPk($id);
            if ($model && $model->setCover()) {
                $this->setMessage('保存成功！', 'success');
            } else {
                $this->setMessage('保存失败！', 'error');
            }
        }
    }

    /**
     * 编辑排序Ajax
     */
    public function actionEditImageSort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int)Yii::app()->request->getParam('id');
            $sort = (int)Yii::app()->request->getParam('sort');
            if (is_numeric($sort) && $id > 0) {
                echo CJSON::encode(array('num'=>PlotImgExt::setSort($id, $sort), 'sort'=>$sort));
            }
        }
    }


    /**
     * 删除图片
     */
    public function actionAjaxImageDel()
    {
        $ids = Yii::app()->request->getPost('ids', '');
        if (Yii::app()->request->isPostRequest && !empty($ids)) {
            $ids = explode(',', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            $plots = array();
            try{
                foreach($ids as $id){
                    $img = PlotImgExt::model()->findByPk($id);
                    if($img){
                        $plots[] = $img->plot;
                        $img->delete();
                    }
                }
                $transaction->commit();
                //更新楼盘迅搜
                foreach($plots as $v){
                    $v&&$v->save();
                }
                $this->setMessage('操作成功！', 'success', Yii::app()->request->urlReferrer);
            }catch(Exceotion $e){
                $transaction->rollback();
                $this->setMessage('操作失败！', 'error');
            }
        }
    }

    /********************价格走势********************************/

    public function actionPriceList()
    {
        $hid = (int)Yii::app()->request->getParam('hid', 0);
        $this->layout = '/layouts/modal_base';
        $data = ResoldPlotPriceExt::getListByHid($hid);
        $this->render('priceList', array(
            'hid'   =>  $hid,
            'data'  =>  $data->data,
            'pager' =>  $data->pagination,
        ));
    }

    /**
     * 楼盘动态价格编辑
     * @param  integer  $hid 楼盘id
     * @param  integer $id  价格记录id
     */
    public function actionPriceEdit($hid, $id=0)
    {
        $this->layout = '/layouts/modal_base';
        $model = $id == 0 ? new ResoldPlotPriceExt : ResoldPlotPriceExt::model()->findByPk($id);
        $model->hid = $hid;
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('ResoldPlotPriceExt', array());
            if ($model->save()) {
                $this->setMessage('保存成功！', 'success',  array('resoldPlot/priceList', 'hid'=>$hid));
            } else {
                $this->setMessage('保存失败！', 'error');
            }
        }
        $this->render('priceEdit', array(
            'model'=>$model,
            'hid'=>$hid
        ));
    }

    public function actionPriceDel()
    {
        $id = (int)Yii::app()->request->getPost('id');
        if ($id>0) {
            if (ResoldPlotPriceExt::model()->deleteAll(array('condition'=>'id = '.$id)) >0) {
                $this->setMessage('删除成功！', 'success', Yii::app()->request->urlReferrer);
                Yii::app()->end();
            } else {
                $this->setMessage('保存失败！', 'error');
                Yii::app()->end();
            }
        }
    }

    /********************交付时间************************************/

    public function actionDeliverylist()
    {
        $hid = (int)Yii::app()->request->getParam('hid', 0);
        $this->layout = '/layouts/modal_base';
        $data = PlotDeliveryExt::getListByHid($hid);
        $this->render('deliverylist', array(
            'hid'   =>  $hid,
            'data'  =>  $data->data,
            'pager' =>  $data->pagination,
        ));
    }

    public function actionDeliveryEdit()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $this->layout = '/layouts/modal_base';
        $data = $id == 0 ? new PlotDeliveryExt() : PlotDeliveryExt::model()->findByPk($id);

        $params = Yii::app()->request->getPost('PlotDeliveryExt');

        if (Yii::app()->request->isPostRequest&&!empty($params)) {
            if (!is_numeric($params['delivery_time'])) {
                $params['delivery_time'] = strtotime($params['delivery_time']);
            }
            $params['hid'] = Yii::app()->request->getParam('hid');
            $params['id'] = $id;

            $data->attributes = $params;
            if ($data->save()) {
                if (Yii::app()->request->getParam('set_new')) {
                    PlotExt::model()->updateByPk($params['hid'], array('delivery_time'=>$params['delivery_time']));
                }
                $this->setMessage('保存成功！', 'success', array('plot/deliverylist', 'hid'=>Yii::app()->request->getParam('hid')));
            } else {
                $this->setMessage('保存失败！', 'error');
            }
        }
        $this->render('deliveryedit', array(
            'delivery'     =>$data,
            'hid'      =>Yii::app()->request->getParam('hid')
        ));
    }

    public function actionDeliveryDel()
    {
        $id = (int)Yii::app()->request->getPost('id');
        if ($id>0) {
            if (PlotDeliveryExt::model()->deleteAll(array('condition'=>'id = '.$id)) >0) {
                $this->setMessage('删除成功！', 'success', Yii::app()->request->urlReferrer);
                Yii::app()->end();
            } else {
                $this->setMessage('删除失败！', 'error');
                Yii::app()->end();
            }
        }
    }

    /*********************优惠信息***********************************/
    public function actionDiscountlist()
    {
        $hid = (int)Yii::app()->request->getParam('hid', 0);
        $this->layout = '/layouts/modal_base';
        $data = PlotDiscountExt::getListByHid($hid);
        $this->render('discountlist', array(
            'hid'   =>  $hid,
            'data'  =>  $data->data,
            'pager' =>  $data->pagination,
        ));
    }

    public function actionDiscountedit()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $hid = Yii::app()->request->getParam('hid');
        $this->layout = '/layouts/modal_base';
        $data = $id == 0 ? new PlotDiscountExt() : PlotDiscountExt::model()->findByPk($id);

        $params = Yii::app()->request->getPost('PlotDiscountExt');
        if (Yii::app()->request->isPostRequest&&!empty($params)) {
            if (!is_numeric($params['start']) && !is_numeric($params['expire'])) {
                $params['start'] = strtotime($params['start']);
                $params['expire'] = strtotime($params['expire']);
            }

            $params['hid'] = $hid;
            $params['id'] = $id;
            $data->attributes = $params;
            if ($data->save()) {
                $plot = PlotExt::model()->findByPk($hid);
                $plot->save();
                $this->setMessage('保存成功！', 'success', array('plot/discountlist', 'hid'=>Yii::app()->request->getParam('hid')));
            } else {
                $this->setMessage('保存失败！', 'error');
            }
        }
        $this->render('discountedit', array(
            'discount'     =>$data,
            'hid'      =>Yii::app()->request->getParam('hid')
        ));
    }

    public function actionDiscountDel()
    {
        $id = (int)Yii::app()->request->getPost('id');
        $discount = PlotDiscountExt::model()->findByPk($id);
        if ($id>0) {
            if (PlotDiscountExt::model()->deleteAll(array('condition'=>'id = '.$id)) >0) {
                $plot = PlotExt::model()->findByPk($discount->hid);
                $plot->save();
                $this->setMessage('删除成功！', 'success', Yii::app()->request->urlReferrer);
                Yii::app()->end();
            } else {
                $this->setMessage('删除失败！', 'error');
                Yii::app()->end();
            }
        }
    }

    /********************看房团*************************************/
    /**
     * 看房团列表
     */
    public function actionKanlist($type='', $value='')
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'order' => 'sort desc,id desc',
        ));
        if ($type=='title' && $value) {
            $criteria->addSearchCondition('title', $value);
        }
        if ($type=='id' && $value) {
            $criteria->addSearchCondition('id', $value);
        }

        $dataProvider = PlotKanExt::model()->getList($criteria);

        $this->render('kanlist', array(
            'list'  =>  $dataProvider->data,
            'pager' =>  $dataProvider->pagination,
        ));
    }

    /**
     * 列表页ajax修改推荐
     */
    public function actionAjaxKanRecom()
    {
        if (Yii::app()->request->getIsPostRequest()) {
            $id = Yii::app()->request->getPost('id', 0);
            $kan = PlotKanExt::model()->findByPk($id);
            if ($kan && $kan->recommend()) {
                $this->setMessage('修改成功！', 'success');
            } else {
                $this->setMessage('修改失败！', 'error');
            }
        }
    }

    /**
     * 列表页ajax修改状态
     */
    public function actionAjaxKanStatus()
    {
        $ids = Yii::app()->request->getPost('ids', false);
        $status = Yii::app()->request->getPost('status', false);
        if ($ids!==false && $status!==false) {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = PlotKanExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    $v->changeStatus($status);
                }
                $transaction->commit();
                $this->setMessage('操作成功', 'success');
                Yii::app()->end();
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!', 'error');
    }

    /**
     * 编辑看房团信息
     * @param  integer $id 编辑的看房团活动id
     */
    public function actionKanEdit($id=0)
    {
        $kan = $id==0? new PlotKanExt : PlotKanExt::model()->findByPk($id);
        if (Yii::app()->request->isPostRequest) {
            $kan->attributes = Yii::app()->request->getPost('PlotKanExt', array());
            $gather = strtotime($kan->gather_time);
            $expire = strtotime($kan->expire);
            if ($gather > $expire) {
                if ($kan->save()) {
                    $this->setMessage('保存成功！', 'success', true);
                } else {
                    $msg = $kan->hasErrors() ? current(current($kan->getErrors())) : '保存失败！';
                    $this->setMessage($msg, 'error');
                }
            } else {
                $this->setMessage('集合时间需要晚于截止时间', 'error', true);
            }
        }

        //select2多选框数据
        $select2Plots = array();
        foreach ($kan->plots as $v) {
            $select2Plots[] = array('id'=>$v->id, 'text'=>$v->title);
        }
        $this->render('kanedit', array(
            'kan'  =>  $kan,
            'select2Plots' => CJSON::encode($select2Plots),
        ));
    }
    /**
     * 看房团相册
     */
    public function actionKanimg($kid = 0){
        $criteria = new CDbCriteria();
        $criteria->addCondition("kan_id = :kan_id");
        $criteria->params[':kan_id']=$kid;
        $criteria->order = 'created desc';
        $dataProvider = PlotKanImgExt::model()->getList($criteria,10);
        $this->render('kanimg',array(
            'data'=>$dataProvider->data,
            'pager'=>$dataProvider->pagination,
            'kid'=>$kid,
        ));
    }

    /**
     * 看房团相册编辑、修改
     */
    public function actionKanimgedit($id = 0,$kid = 0){
        $img = $id ? PlotKanImgExt::model()->findByPk($id) : new PlotKanImgExt();
        if(Yii::app()->request->getIsPostRequest()){
            $img->attributes = Yii::app()->request->getPost('PlotKanImgExt');
            $img->kan_id = $kid;
            if ($img->save()) {
                $this->setMessage('保存成功！', 'success', array('/admin/plot/kanimg?kid='.$kid));
            } else {
                $this->setMessage($img->hasErrors()?current(current($img->getErrors())):'保存失败！', 'error');
            }
        }
        $this->render('kanimgedit',array(
            'img'=>$img,
            'kid'=>$kid,
        ));
    }

    /**
     * 修改看房团相册的状态
     */
    public function actionAjaxKanimgstatus(){
        $id = Yii::app()->request->getPost('id', false);
        $status = Yii::app()->request->getPost('status', false);
        if ($id!==false && $status!==false) {
            $id = explode(',', $id);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = PlotKanImgExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    $v->changeStatus($status);
                }
                $transaction->commit();
                $this->setMessage('操作成功', 'success');
                Yii::app()->end();
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!', 'error');
    }
    /**
     * 删除看房团相册
     */
    public function actionKanimgdel()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = PlotKanImgExt::model()->deleteByPk($id);
            if ($count>0) {
                $this->setMessage('删除成功！', 'success', true);
                Yii::app()->end();
            }
        }
        $this->setMessage('删除失败！', 'error');
        Yii::app()->end();
    }


    /**
     * 永久删除楼盘
     */
    public function actionKandel()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = PlotKanExt::model()->deleteByPk($id);
            if ($count>0) {
                $this->setMessage('删除成功！', 'success', true);
                Yii::app()->end();
            }
        }
        $this->setMessage('删除失败！', 'error');
        Yii::app()->end();
    }

    public function actionEditkansort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int)Yii::app()->request->getParam('id');
            $sort = (int)Yii::app()->request->getParam('sort');
            if (is_numeric($sort) && $id > 0) {
                echo CJSON::encode(array('num'=>PlotKanExt::setSort($id, $sort), 'sort'=>$sort));
            }
        }
    }


    /********************ajax请求获取房源****************************/

    /**
     * ajax获取楼盘
     * @param  [type]  $kw       [description]
     */
    public function actionAjaxGetHouse($kw)
    {
        $criteria = new CDbCriteria();
        if (!$kw) {
            $criteria->limit = 15;
        }
        if (preg_match("/^[a-zA-Z\s]+$/", $kw)) {
            $criteria->addSearchCondition('pinyin', $kw);
        } else {
            $criteria->addSearchCondition('title', $kw);
        }

        $data = array();
        $house = PlotExt::model()->normal()->isNew()->findAll($criteria);
        foreach ($house as $v) {
            $data[] = array('id'=>$v->id, 'name'=>$v->title);
        }
        $data = array('results'=>$data, 'more'=>false);
        echo CJSON::encode($data);
    }


    /**
     * 价格走势列表
     */
    public function actionPriceTrendList()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'order' => 'time desc',
        ));
        $area = AreaExt::model()->parent()->normal()->findAll(array(
            'index'=>'id',
        ));
        $data = PlotPricetrendExt::model()->getList($criteria, 15);
        $this->render('pricetrendlist', array(
            'area' => $area,
            'data' => $data->data,
            'pager' => $data->pagination,
        ));
    }

    /**
     * 删除价格走势
     */
    public function actionPriceTrendDel()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = PlotPricetrendExt::model()->deleteByPk($id);
            if ($count > 0) {
                $this->setMessage('删除成功！', 'success');
                Yii::app()->end();
            }
        }
        $this->setMessage('删除失败！', 'error');
        Yii::app()->end();
    }

    /**
     * 添加/编辑价格走势
     */
    public function actionPriceTrendEdit($id=0)
    {
        $model = $id ? PlotPricetrendExt::model()->findByPk($id) : new PlotPricetrendExt;
        if (Yii::app()->request->getIsPostRequest()) {
            $model->attributes = Yii::app()->request->getPost('PlotPricetrendExt');
            if ($model->save()) {
                $this->setMessage('保存成功！', 'success', array('priceTrendList'));
            } else {
                $this->setMessage($model->hasErrors()?current(current($model->getErrors())):'保存失败！', 'error');
            }
        }
        $area = AreaExt::model()->parent()->normal()->findAll();
        $this->render('pricetrendedit', array('model' => $model, 'area' => $area));
    }

    public function actionPriceTaglist()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria;
        $criteria->order = 'sort asc';
        $data = PlotPricetagExt::model()->getList($criteria);
        $this->render('pricetaglist', array(
            'data' => $data->data,
            'pager' => $data->pagination,
        ));
    }

    public function actionPriceTagedit()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $data = $id == 0 ? new PlotPricetagExt() : PlotPricetagExt::model()->findByPk($id);

        if (Yii::app()->request->isPostRequest) {
            $data->attributes = Yii::app()->request->getPost('PlotPricetagExt', array());
            if ($data->save()) {
                $this->setMessage('保存成功！', 'success', true);
            } else {
                $this->setMessage('保存失败！', 'error');
            }
        }
        $this->render('pricetagedit', array(
            'data' => $data,

        ));
    }

    /**
     * ajax修改楼盘状态
     */
    public function actionAjaxTagStatus()
    {
        $ids = Yii::app()->request->getPost('ids', false);
        $status = Yii::app()->request->getPost('status', false);
        if ($ids!==false && $status!==false) {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = PlotPricetagExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    $v->changeStatus($status);
                }
                $transaction->commit();
                $this->setMessage('操作成功', 'success');
                Yii::app()->end();
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!', 'error');
    }

    /**
     * ajax修改楼盘排序
     */
    public function actionAjaxPriceTagSort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int)Yii::app()->request->getParam('id', 0);
            $sort = (int)Yii::app()->request->getParam('sort', 0);
            $plot = PlotPricetagExt::model()->findByPk($id);
            if ($plot && $plot->sort($sort)) {
                echo CJSON::encode(array('num'=>1, 'sort'=>$sort));
            }
        }
    }

    /**
     * 删除价格走势
     */
    public function actionPriceTagDel()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = PlotPricetagExt::model()->deleteByPk($id);
            if ($count > 0) {
                $this->setMessage('删除成功！', 'success');
                Yii::app()->end();
            }
        }
        $this->setMessage('删除失败！', 'error');
        Yii::app()->end();
    }

    /**
     * ajax修改楼盘户型排序
     */
    public function actionAjaxPlotHouseTypeSort($id,$sort)
    {
        $old = 0;
        $model = PlotHouseTypeExt::model()->findByPk($id);

        $old = $model->sort;
        $model->sort = $sort;
        $model->_notSaveBuilding = 1;
        if($model->save())
            $this->response(true,$sort);
        else
            $this->response(false,$old);
    }

    /**
     * [actionAjaxGetImgs 根据hid获得楼盘图片]
     * @return [type] [description]
     */
    public function actionAjaxGetImgs($hid)
    {
        $images = [];
        $imgs = PlotImgExt::model()->findAll(array('condition'=>'hid=:hid','params'=>[':hid'=>$hid],'limit'=>30));
        if(!$imgs)
        {
            echo CJSON::encode(['msg'=>'error']);
        }
        else
        {
            foreach ($imgs as $key => $value) {
                $tmp['image'] = ImageTools::fixImage($value['url']);
                $tmp['ori_image'] = $value['url'];
                $tmp['img_id'] = $value['id'];
                $images['data'][] = $tmp;
            }
            $images['msg'] = 'success';
            $images['addr'] = $imgs?$imgs[0]->plot->address:'';
            echo CJSON::encode($images);
        }
    }

    /**
     * [actionChangeResoldSort 修改二手房排序]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function actionChangeResoldSort($hid,$sort)
    {
        $plot = PlotExt::model()->findByPk($hid);
        $plot->resoldSort = $sort;
        if($plot->save()) {
             echo CJSON::encode(array('num'=>1, 'sort'=>$sort));
        }
    }
}
