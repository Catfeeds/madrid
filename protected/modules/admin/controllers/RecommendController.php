<?php
/**
 * 推荐相关
 * @author weibaqiu
 * @date 2015-09-08
 */
class RecommendController extends AdminController
{
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
				'roles' => array('guanlineirong'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}
    /**
     * 推荐分类
     */
    public $recomCate;
    /**
     * 初始化操作
     */
    public function init()
    {
        parent::init();
        if($this->recomCate===null)
            $this->recomCate = RecomCateExt::model()->findAll();
    }

    /**
     * 推荐内容列表
     */
    public function actionList($t='',$str='', $cid=0,$substation='')
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'condition' => 'substation_id=:substation',
            'params' => array(':substation'=>(int)$substation),
            'order' => 'id desc',
        ));
        if($t==1) $criteria->addSearchCondition('title', $str);
        if($t==2) $criteria->addSearchCondition('author', $str);
        if($cid)
        {
            $criteria->addCondition('cid=:cid');
            $criteria->params[':cid'] = $cid;
        }
        $dataProvider = RecomExt::model()->getList($criteria);
        $this->render('list', array(
            't' => $t,
            'str' => $str,
            'cid' => $cid,
            'substation' =>$substation,
            'list' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }

    /**
     * 添加、修改文章
     * @param  integer $id 文章id
     */
    public function actionEdit($id=0)
    {
        $model = $id ? RecomExt::model()->findByPk($id) : new RecomExt;
        $session = Yii::app()->session;
        if(isset($session['article']) && !empty($session['article'])){
            $model->hid = $session['article']['hid'];
            $model->title = $session['article']['title'];
            $model->s_title = $session['article']['s_title'];
            $model->description = $session['article']['description'];
            $model->image = $session['article']['image'];
            $model->url = $session['article']['url'];
        }
        unset(Yii::app()->session['article']);
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('RecomExt', array());
            if($model->save())
                $this->setMessage('保存成功！', 'success', array('list','substations'=>$model->substation_id));
            else
                $this->setMessage('保存失败！', 'error');
        }

        $this->render('edit', array(
            'model' => $model,
        ));
    }

    /**
     * 验证该推荐位是否具有分站区分
     */
    public function actionAjaxValidConfig()
    {
        $model = new RecomExt;
        $model->attributes = Yii::app()->request->getPost('RecomExt',array());
        $htmlIds = array();//将显示的html ID属性存入此数组
        if($model->cate&&in_array($model->cate->pinyin,RecomExt::$substationCatePinyin)){
            $htmlIds[] = 'fenzhan';
        }
        if($model->enableMarkColorConfig())
        {
            $htmlIds[] = 'mark_color';
        }
        $this->response($htmlIds?1:0, $htmlIds);
    }

    /**
     * 推荐分类列表
     */
    public function actionCateList()
    {
        $data = Tools::menuMake($this->recomCate,-1,'id',array(),true,2);
        $this->render('catelist', array(
            'data' => $data,
        ));
    }

    /**
     * 添加、修改推荐分类
     */
    public function actionCateEdit($id=0)
    {
        $model = $id ? RecomCateExt::model()->findByPk($id) : new RecomCateExt;
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('RecomCateExt', array());
            if($model->save())
                $this->setMessage('操作成功！','success', array('/admin/recommend/catelist'));
            else
                $this->setMessage('操作失败！','error');
        }
        $this->render('cateedit', array(
            'model' => $model,
        ));
    }

    /**
     * 删除推荐
     */
    public function actionAjaxDelRecom()
    {
        $ids = Yii::app()->request->getPost('ids', false);
        if($ids!==false)
        {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id',$ids);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $data = RecomExt::model()->findAll($criteria);
                foreach($data as $v)
                {
                    $v->delete();
                }
                $transaction->commit();
                $this->setMessage('操作成功','success');
                Yii::app()->end();
            }
            catch(Exception $e)
            {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!','error');
    }

    /**
     * 修改推荐状态
     */
    public function actionAjaxRecomStatus()
    {
        $ids = Yii::app()->request->getPost('ids', false);
        $status = Yii::app()->request->getPost('status', false);
        if($ids!==false && $status!==false)
        {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id',$ids);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $data = RecomExt::model()->findAll($criteria);
                foreach($data as $v)
                {
                    $v->changeStatus($status);
                }
                $transaction->commit();
                $this->setMessage('操作成功','success');
                Yii::app()->end();
            }
            catch(Exception $e)
            {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!','error');
    }

    /**
     * 修改排序
     */
    public function actionAjaxRecomSort($id,$sort)
    {
        $old = 0;
        $model = RecomExt::model()->findByPk($id);
        $old = $model->sort;
        $model->sort = $sort;
        if($model->save())
            $this->response(true,$sort);
        else
            $this->response(false,$old);

    }
}
?>
