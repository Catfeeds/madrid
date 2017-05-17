<?php
class AdController extends AdminController
{

    /**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
			//集客所有内容的权限设置
			array('allow',
				'roles' => array('guanggaoguanli'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}

    /**
     * 列表页
     * @return [type] [description]
     */
    public function actionList($substation=0)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'substation_id=:stationId',
            'params' => array(':stationId'=>$substation),
            'order' => 'position asc,size asc',
        ));
        $dataProvider = BaiduAdExt::model()->getList($criteria);
        $model = new BaiduAdExt;
        $model->substation_id = $substation;
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('BaiduAdExt', array());
            if($model->save())
                Yii::app()->user->setFlash('success', '保存成功！');
            else
                Yii::app()->user->setFlash('error', '保存失败！');
            $this->redirect(array('/admin/ad/list','substation'=>$substation));
        }
        $position = array();
        foreach(BaiduAdExt::$position as $k=>$v)
        {
            $position[$k] = $v['name'];
        }
        $this->render('list', array(
            'model' => $model,
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'position' => $position,
            'substation' => $substation,
        ));
    }

    /**
     * 删除广告
     */
    public function actionAjaxDel()
    {
        if($id = Yii::app()->request->getPost('id',0))
        {
            $model = BaiduAdExt::model()->findByPk($id);
            if($model&&$model->delete())
            {
                Yii::app()->user->setFlash('success','删除成功！');
                $this->response(true, '删除成功！');
            }
            else
            {
                $this->response(false, '删除失败！');
            }
        }
    }

    /**
     * ajax编辑
     */
    public function actionEdit($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $data = Yii::app()->request->getPost('BaiduAdExt', array());
            $model = BaiduAdExt::model()->findByPk($id);
            $model->attributes = $data;
            if($model->save())
                Yii::app()->user->setFlash('success', '保存成功！');
            else
                Yii::app()->user->setFlash('error', '保存失败！');
            $this->redirect(array('/admin/ad/list','substation'=>$model->substation_id));
        }
    }

    /**
     * 获取广告数据
     * @param  integer $id 广告id
     */
    public function actionAjaxEdit($id)
    {
        $data = BaiduAdExt::model()->findByPk($id);
        header("Content-type: application/json");
        echo CJSON::encode($data->attributes);
        Yii::app()->end();
    }
}
?>
