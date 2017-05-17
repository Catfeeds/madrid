<?php

/**
 * 资讯相关
 * @author sc
 * @date 2015-09-10
 */
class InfoController extends AdminController {
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
     * 资讯分类列表
     */
    public function actionCateList() {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria;
        $criteria->order = 'sort desc ,id desc';
        $dataProvider= ArticleCateExt::model()->getList($criteria,10);
        $this->render('catelist', array(
            'data' => $dataProvider -> data,
            'pager' => $dataProvider -> pagination,
        ));
    }

    /**
     *  添加、修改资讯分类
     */
    public function actionCateEdit($id = 0) {
        $model = $id ? ArticleCateExt::model()->findByPk($id) : new ArticleCateExt;
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('ArticleCateExt', array());
            if ($model->save())
                $this->setMessage('操作成功！', 'success', true);
            else
                $this->setMessage('操作失败！', 'error',true);
        }
        $_data = Tools::menuMake(ArticleCateExt::model()->normal()->findAll());
        $catelist[0] = '--根节点--';
        foreach ($_data as $v) {
            $catelist[$v['id']] = $v['name'];
        }
        $this->render('cateedit', array(
            'model' => $model,
            'catelist' => $catelist,
        ));
    }

    /**
     * 删除资讯分类
     */
    public function actionCateDel($id = 0) {
        $model = ArticleCateExt::model()->findByPk($id);
        $flag = ArticleExt::model()->noDel()->exists(array(
            'condition'=>'cid=:cid',
            'params'=>array(':cid'=>$id),
        ));
        if (!$flag && $model->delete()) {
            $this->setMessage('删除成功！', 'success', array('/admin/info/catelist'));
        } else {
            $this->setMessage($flag ? '该分类下有文章，禁止删除':'删除失败！', 'error',array('/admin/info/catelist'));
        }
    }

    /**
     * 资讯列表
     */
    public function actionList()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());

        $params['title'] = Yii::app()->request->getParam('title', '');
        $params['author'] = Yii::app()->request->getParam('author', '');
        $params['cid'] = Yii::app()->request->getParam('cid', 0);

        if (isset($_GET['status']))
            $params['status'] = Yii::app()->request->getParam('status');

        if (Yii::app()->request->isPostRequest) {
            $plots = Yii::app()->request->getPost('ArticleExt', array());
            $aid = Yii::app()->request->getPost('aid', '');
            $aid = explode(',', $aid);
            $flag = 0;
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $aid);
            $articles = ArticleExt::model()->findAll($criteria);
            foreach ($articles as $article) {
                $article->attributes = $plots;
                if ($article->addPlot(false)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                };
            }

            if (!$flag) {
                $this->setMessage('保存成功！', 'success', true);
            } else {
                $this->setMessage('保存失败！', 'false', true);
            }

        }

        $criteria = new CDbCriteria(array(
            'order'=>'show_time DESC'
        ));
        if (!empty($params['cid'])) {
            $criteria->addCondition('cid=:cid');
            $criteria->params[':cid'] = $params['cid'];
        }
        if (!isset($params['status']))
            $criteria->addCondition('status!=2');
        else {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $params['status'];
        }
        if (!empty($params['author'])||!empty($params['title'])) {
            $criteria = new XsCriteria(array(
                'facetsField'=>'status',
                'order'=>array('show_time'=>false)
            ));
            $criteria->addRange('status', 0, 1);

            if (!empty($params['author'])) {
                $criteria->query = 'author:' . $params['author'];
            }
            if (!empty($params['cid'])) {
                $criteria->addRange('cid', $params['cid'], $params['cid']);
            }
            if (!empty($params['title'])) {
                $criteria->query .= ' title:' . $params['title'];
            }
            $data = ArticleExt::model()->getXsList('house_article', $criteria, 20);
        }
        else{
            $data = ArticleExt::model()->getList($criteria,20);
        }

        $this->render('list', array(
            'data' => $data->data,
            'pager' => $data->pagination
        ));
    }

    /**
     * 资讯列表
     * ajax删除操作
     */
     public function actionAjaxArticleDel(){
         $id = Yii::app()->request->getPost('id',0);
         if($id){
            $ids = explode(',',$id);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
             $articles = ArticleExt::model()->findAll($criteria);
             $transaction = Yii::app()->db->beginTransaction();
             try{
                 foreach($articles as $v){
                     $v->delete();
                 }
                 $transaction->commit();
                 $this->setMessage('操作成功！','success');
                 $this->response(1, '操作成功！');
             }catch(Exception $e){
                 $transaction->rollback();
                 $this->setMessage('操作失败！','error');
                 $this->response(0, '操作失败！');
             }
         }
     }


    /**
     * 资讯列表
     * ajax改变状态
     */
    public function actionAjaxChangeStatus(){
        $id = Yii::app()->request->getPost('id',0);
        if($id){
            $ids = explode(',',$id);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $articles = ArticleExt::model()->findAll($criteria);
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach($articles as $v){
                    $v->changeStatus();
                }
                $transaction->commit();
                $this->setMessage('操作成功！','success');
                $this->response(1, '操作成功！');
            }catch (Exception $e){
                $transaction->rollback();
                $this->setMessage('操作失败！','error');
                $this->response(0, '操作失败！');
            }
        }
    }


    /**
     * 资讯编辑
     */
    public function actionEdit($id = 0) {
        $article = $id ? ArticleExt::model()->findByPk($id) : new ArticleExt;
        /**
         * 楼盘选项框的数据
         */
        $datasel = array();
        if($id){
            foreach($article->plot as $v){
                $datasel[] = array('id'=>$v->id,'text'=>$v->title);
            }
        }
        if (Yii::app()->request->isPostRequest) {
            $goto = Yii::app()->request->getPost('goto', 0);
            $referrer = Yii::app()->request->getParam('referrer');
            $article->attributes = Yii::app()->request->getPost("ArticleExt",array());
            if ($article->save()) {
                $article->addPlot();
                if ($goto) {
                    $this->redirect(Yii::app()->createUrl('/admin/info/Setsession', array('id' => $article->id)));
                }
                $this->setMessage('保存成功！', 'success', true);
                if ($referrer) {
                    $this->redirect($referrer);
                }
            } else {
                $this->setMessage('保存失败！', 'error',false);
            }
        }
        $this->render('edit', array(
            'article' => $article,
            'datasel' => CJSON::encode($datasel),
        ));
    }

    /**
     * 保存并推荐
     */
    public function actionSetsession() {
        $id = Yii::app()->request->getParam('id');
        $article = ArticleExt::model()->findByPk($id);

        $info = array(
            'hid' => empty($article->hid[0]) ? 0 : $article->hid[0],
            'title' => $article->title,
            's_title' => $article->s_title,
            'description' => $article->description,
            'image' => $article->image,
            'url' => $article->url ? $article->url : $this->createUrl('/home/news/detail', array('articleid' => $article->id)),
        );

        $session = Yii::app()->session;
        $session['article'] = $info;
        $this->redirect(Yii::app()->createAbsoluteUrl('admin/recommend/edit'));
    }


    /**
     * 编辑排序Ajax
     */
    public function actionEditArticlesort() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int) Yii::app()->request->getParam('id');
            $sort = (int) Yii::app()->request->getParam('sort');
            if (is_numeric($sort) && $id > 0)
                echo CJSON::encode(array('num' => ArticleExt::setSort($id, $sort), 'sort' => $sort));
        }
    }

    protected function performAjaxValidation($model) {
        $ajax = Yii::app()->request->getPost('ajax');
        if (isset($ajax) && $ajax === 'ArticleCateExt') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }



    /**
     * 根据关键词检索楼盘名，返回10条数据
     * @throws CException
     */
    public function actionGetHousesByStr()
	{
        $str = trim(Yii::app()->request->getParam('key'));
        $is_coop = Yii::app()->request->getParam('is_coop',FALSE);
        if(empty($str))
            return $this->response(500,'NULL');
        $params = array('title'=>$str,'limit'=>10);
        if($is_coop)
            $params['is_coop'] = $is_coop;
        $data = PlotExt::getHousesByStr($params);
        return $this->response(100,$data);
    }

    /**
     * 修改排序
     */
    public function actionAjaxInfoCateSort($id,$sort)
    {
        $old = 0;
        $model = ArticleCateExt::model()->findByPk($id);
        $old = $model->sort;
        $model->sort = $sort;
        if($model->save())
            $this->response(true,$sort);
        else
            $this->response(false,$old);

    }
}
