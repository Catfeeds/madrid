<?php
/**
 * 学区房
 * @author sc
 * @date 2015-09-15
 */
class SchoolController extends AdminController {
    /**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
            // array('allow',
            //     'action' => array(),
            // ),
			array('allow',
				'roles' => array('guanlineirong','ershoufangguanli'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}

    /**
     * 学区房列表
     */
    public function actionList($type = '', $value = '',$stype=0, $area=0)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $stype = (int)$stype;
        $area = (int)$area;
        
        $criteria = new CDbCriteria(array(
            'with' => array(
                'areaInfo' => array(
                    'select' => 'areaInfo.name'
                )
            )
        ));
        if($stype && in_array($stype, array_keys(SchoolExt::$type))){
            $criteria->addCondition('type=:type');
            $criteria->params[':type'] = $stype;
        }
        if ($type == 'name') {
            $criteria->addSearchCondition('t.name', $value);
        }

        if ($type == 'id' && $value != '') {
            $criteria->addCondition('t.id=:id');
            $criteria->params[':id'] = $value;
        }
        if($area){
            $criteria->addCondition('area=:area');
            $criteria->params[':area'] = $area;
        }
        $criteria->order = 't.recommend desc,t.id desc';
        $dataProvider = SchoolExt::model()->getList($criteria);

        $areas = CHtml::listData(AreaExt::model()->normal()->parent()->findAll(), 'id','name');

        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'areas' => $areas,
            'area' => $area,
            'stype' => $stype,
        ));
    }

    /**
     * 编辑和添加学区房
     */
    public function actionEdit($id = 0) {
        $model = $id ? SchoolExt::model()->findByPk($id) : new SchoolExt;
        $plot = $id == 0 ? new PlotExt : PlotExt::model()->findByPk($id);
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost("SchoolExt");
            if ($model->save()) {
                $this->setMessage('操作成功！', 'success',true);
            } else {
                $this->setMessage('操作失败！', 'error',true);
            }
        }
        $area = AreaExt::model()->normal()->parent()->findAll();
        $arr = array();
        foreach ($area as $v) {
            $arr[$v['id']] = $v['name'];
        };
        $maps = array('zoom' => 14, 'lat' => SM::globalConfig()->mapLat() ? SM::globalConfig()->mapLat() : "31.810077", 'lng' => SM::globalConfig()->mapLng() ? SM::globalConfig()->mapLng() : "119.974454");
        $this->render('edit', array(
            'school' => $model,
            'area' => $arr,
            'plot' => $plot,
            'maps' => $maps,
        ));
    }

    /**
     * 删除学区房
     */
    public function actionDel() {
        $id = Yii::app()->request->getParam("id", 0);
        if ($id) {
            $count = SchoolExt::model()->deleteByPk($id);
            if ($count > 0) {
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }

    /**
     * 修改学区房推荐状态
     */
    public function actionAjaxRecomStatus() {
        $ids = Yii::app()->request->getPost('ids', false);
        $status = Yii::app()->request->getPost('status', false);
        if ($ids !== false && $status !== false) {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = SchoolExt::model()->findAll($criteria);
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
     * 删除推荐
     */
    public function actionAjaxDelRecom() {
        $ids = Yii::app()->request->getPost('ids', false);
        if ($ids !== false) {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = SchoolExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    $v->delete();
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
     * 编辑学区房添加、修改
     */
    public function actionRel($plot = '', $id = 0) {

        $school = SchoolExt::model()->findByPk($id);
        if($id){
            $plotrel = SchoolPlotRelExt::model()->findAll('sid = :sid',array(':sid'=>$id));
        }

        if ($plot) {
            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('title', $plot);
            $data = PlotExt::model()->findAll($criteria);
            $arr = $data;
        } else {
            $areaplot = PlotExt::model()->findAll(array(
                'condition' => 'area=:area',
                'params' => array(':area' => $school->area),
                'limit' => 10
            ));
            $arr = $areaplot;
        }

        $hids = array();
        foreach($arr as $k=>$v){
            $cid = '/'.$v->id.'/';
            foreach($plotrel as $n){
                $hid = $n->hid;
                if(!preg_match($cid,$hid)){
                    $hids[$k] = $hid;
                }
            }
        }

            $criteria = new CDbCriteria();
            if(isset($hids) && !empty($hids)){
                $criteria->addNotInCondition('id',$hids);
            }
            if ($plot) {
                $criteria->addSearchCondition('title', $plot);
                $data = PlotExt::model()->findAll($criteria);
                $plots = $data;
            }else {
                $criteria->addCondition("area = :area");
                $criteria->params[':area']=$school->area;
                $criteria->limit = 10;
                $areaplot = PlotExt::model()->findAll($criteria);
                $plots = $areaplot;
            }

        $this->render('rel', array(
            'data'=>$plots,
            'id' => $id,
            'plotrel'=>$plotrel,
            'plot'=>$plot,
        ));
    }


    /**
     * 删除学区房楼盘
     */
    public function actionAjaxDelRel(){
        $id = Yii::app()->request->getPost('id',false);
        if($id != false){
             $count = SchoolPlotRelExt::model()->deleteByPk($id);
             if($count > 0){
                 $this->setMessage('删除成功！','success');
             }else{
                 $this->setMessage('删除失败！','error');
             }
        }
    }

    /**
     * 添加选择楼盘
     */
    public function actionAjaxGetPlot() {
        $ids = Yii::app()->request->getPost('ids', false);
        $sid = Yii::app()->request->getPost('sid', false);
        if ($ids != false && $sid != false) {
            $ids = explode(',', $ids);
            $school = SchoolExt::model()->findByPk($sid);
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach ($ids as $v) {
                    $plot = PlotExt::model()->findByPk($v);
                    $schoolplotrel = new SchoolPlotRelExt();
                    $schoolplotrel->school = $school;
                    $schoolplotrel->plot = $plot;
                    if(!$schoolplotrel->save())
                        throw new CException('保存失败！');
                }
                $transaction->commit();
                $this->setMessage('保存成功！', 'success');
            }catch(CException $e){
                $transaction->rollback();
                $this->response(false, $e->getMessage());
            }

        } else {
            $this->response(false, '修改失败！');
        }
    }

    /**
     * 学区房的开启状态
     */
    public function actionAjaxStatus() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $model = SchoolExt::model()->findByPk($id);
            if ($model && $model->changeStatus()) {
                $this->setMessage('保存成功！', 'success');
            } else {
                $this->response(false, '修改失败！');
            }
        }
    }

    /**
     * 学区房的推荐
     */
    public function actionajaxRecom() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $model = SchoolExt::model()->findByPk($id);
            $recommend = Yii::app()->request->getPost('recommend', 0);
            $model->recommend = $recommend;
            if ($model && $model->save()) {
                $this->setMessage('保存成功！', 'success');
            } else {
                $this->response(false, '修改失败！');
            }
        }
    }

    public function actionAjaxSchoolRelStatus(){
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $model = SchoolAreaExt::model()->findByPk($id);
            if ($model && $model->changeStatus()) {
                $this->setMessage('保存成功！', 'success');
            } else {
                $this->response(false, '修改失败！');
            }
        }
    }

    /**
     * 学区区域列表
     */
    public function actionAreaList($type = '', $value = '') {
//        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
//        $criteria = new CDbCriteria();
//        $dataProvider = AreaExt::model()->normal()->parent()->getList($criteria);
//        $this->render('arealist', array(
//            'data' => $dataProvider->data,
//            'pager'=> $dataProvider->pagination,
//        ));
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria();
        if ($type == 'title' && $value != '') {
            $areaid = AreaExt::model()->find(array(
                'condition'=>'name = :name',
                'params'=>array(':name'=>$value),
            ));
            if($areaid){
                $criteria->addSearchCondition('area', $areaid->id);
            }
        }
        if ($type == 'id' && $value != '') {
            $criteria->addCondition('id=:id');
            $criteria->params[':id'] = $value;
        }
        $criteria->order ='created DESC';
        $dataProvider = SchoolAreaExt::model()->getList($criteria);
        $this->render('arealist', array(
            'data' => $dataProvider->data,
            'pager'=> $dataProvider->pagination,
        ));
    }

    /**
     * 学区区域列表编辑、添加
     */
    public function actionAreaEdit($id = 0) {
        $areaParent = AreaExt::model()->normal()->parent()->findAll();
        $area = array();
        foreach($areaParent as $v){
            $area[$v->id] = $v->name;
        }

        $model = SchoolAreaExt::model()->find("t.id=:id", array(":id" => $id));
        $msg = '修改';
        if (!$model) {
            $model = new SchoolAreaExt();
            $model->area = $id;
            $msg = '添加';
        }
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost("SchoolAreaExt", array());
            if ($model->save()) {
                $this->setMessage($msg . '成功！', 'success',true);
            } else {
                $this->setMessage($msg . '失败！', 'error',true);
            }
        }
        $this->render('areaedit', array(
            'data' => $model,
            'area' => $area,
        ));
    }

    /**
     * 删除学区区域
     */
    public function actionAreaDel() {
        $id = Yii::app()->request->getParam("id", 0);
        if ($id) {
            $count = SchoolAreaExt::model()->deleteByPk($id);
            if ($count > 0) {
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }
    /**
     * 学区区域排序
     */
    public function actionEditSchoolAreaSort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int)Yii::app()->request->getParam('id');
            $sort = (int)Yii::app()->request->getParam('sort');
            $schoolarea = SchoolAreaExt::model()->findByPk($id);
            $schoolarea->sort = $sort;
            $schoolarea->save();
            $this->setMessage('操作成功', 'success');
            // echo CJSON::encode(array('num'=>$sort, 'sort'=>$sort));
        }
    }
}
