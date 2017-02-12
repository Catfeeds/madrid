<?php

/**
 * 知识库分类
 * @author steven.allen
 * @date 2016-04-28
 */

class BaikeController extends AdminController
{
	/**
	 * 获取知识库分类列表
	 */
	public function actionCateList()
	{
		Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria;
        $criteria->order = 'sort desc ,id asc';
        $dataProvider= BaikeCateExt::model()->getList($criteria,20);
        $data = Tools::menuMake($dataProvider->data,-1,'sort',array(),true,2);
        // var_dump($data);exit;
        $this->render('catelist', array(
            'data' => $data,
            'pager' => $dataProvider->pagination,
        ));
	}

	/**
	 * 编辑、添加知识库分类
	 */
	public function actionCateEdit($id = 0)
	{
		$baikeCate = $id ? BaikeCateExt::model()->findByPk($id) : new BaikeCateExt;
		if (Yii::app()->request->isPostRequest) {
            $baikeCate->attributes = Yii::app()->request->getPost('BaikeCateExt', array());
            if ($baikeCate->save())
                $this->setMessage('操作成功！', 'success', true);
            else
                $this->setMessage('操作失败！', 'error',true);
        }

        $this->render('cateedit', array(
            'model' => $baikeCate
        ));
	}

	/**
	 * 删除知识库分类
	 */
	public function actionAjaxBaikeCateDel($id = 0)
	{
		$model = BaikeCateExt::model()->findByPk($id);
        $flag = BaikeExt::model()->noDel()->exists(array(
            'condition'=>'cid=:cid',
            'params'=>array(':cid'=>$id),
        ));
        if (!$flag && $model->delete()) {
            $this->setMessage('删除成功！', 'success', array('/admin/baike/baikecatelist'));
        } else {
            $this->setMessage($flag ? '该分类下有百科，禁止删除':'删除失败！', 'error',array('/admin/baike/baikecatelist'));
        }
	}

	/**
	 * 知识库列表
	 */
	public function actionList()
	{
		Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
		$params['title'] = Yii::app()->request->getParam('title', '');
        $params['author'] = Yii::app()->request->getParam('author', '');
        $params['cid'] = Yii::app()->request->getParam('cid', 0);
        if (isset($_GET['status']))
            $params['status'] = Yii::app()->request->getParam('status');
        $criteria = new CDbCriteria();
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
        if (!empty($params['author'])) {
            $criteria->addSearchCondition('author', $params['author']);
        }
        if (!empty($params['title'])) {
            $criteria->addSearchCondition('title', $params['title']);
        }
        $criteria->order = 'created DESC';
        $data = BaikeExt::model()->getList($criteria,20);
        $this->render('list', array(
            'data' => $data->data,
            'pager' => $data->pagination
        ));
	}

	/**
	 * ajax删除百科
	 */
	public function actionAjaxBaikeDel()
	{
		$ids = Yii::app()->request->getPost('ids',0);
         if($ids){
            $ids = explode(',',$ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
	        $baikes = BaikeExt::model()->findAll($criteria);
	        $transaction = Yii::app()->db->beginTransaction();
	        try{
	            foreach($baikes as $v){
	                $v->delete();
	            }
	            $transaction->commit();
	            $this->setMessage('操作成功！','success');
	        }catch(Exception $e){
	            $transaction->rollback();
	            $this->setMessage('操作失败！','error');
	        }
	    }
	}

	/**
     * ajax改变百科状态
     */
    public function actionAjaxChangeBaikeStatus()
    {
        $ids = Yii::app()->request->getPost('ids',0);
		$type = Yii::app()->request->getPost('type', -1);
        if($ids){
            $ids = explode(',',$ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $baikes = BaikeExt::model()->findAll($criteria);
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach($baikes as $v){
					if($type==0) {
						$v->disable();
					} elseif($type==1) {
						$v->enable();
					} else {
						$v->toggleStatus();
					}
                    if(!$v->save()) {
						throw new Exception("处理失败！");
					}
                }
                $transaction->commit();
                $this->setMessage('操作成功！','success');
            }catch (Exception $e){
                $transaction->rollback();
                $this->setMessage('操作失败！','error');
            }
        }
    }

    /**
     * 百科编辑
     */
    public function actionEdit($id = 0)
    {
        $baike = $id ? BaikeExt::model()->findByPk($id) : new BaikeExt;
        if (Yii::app()->request->isPostRequest) {
            $baike->attributes = Yii::app()->request->getPost('BaikeExt', array());
			$baike->author = Yii::app()->user->username;
			$baike->author_id = Yii::app()->user->id;
            if ($baike->save()) {
                $this->setMessage('保存成功！', 'success', true);
            } else {
                $this->setMessage('保存失败！', 'error',true);
            }
        }
        $this->render('edit', array(
            'baike' => $baike
        ));
    }

    /**
     * 修改排序
     */
    public function actionAjaxBaikeCateSort($id,$sort)
    {
        $old = 0;
        $model = BaikeCateExt::model()->findByPk($id);
        $old = $model->sort;
        $model->sort = $sort;
        if($model->save())
            $this->response(true,$sort);
        else
            $this->response(false,$old);

    }

    /**
     * ajax改变百科分类状态
     */
    public function actionAjaxChangeBaikeCateStatus()
    {
        $id = Yii::app()->request->getPost('id',0);
        if($id){
            $ids = explode(',',$id);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $baikes = BaikeCateExt::model()->findAll($criteria);
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach($baikes as $v){
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
     * 编辑排序Ajax
     */
    public function actionEditBaikesort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int) Yii::app()->request->getParam('id');
            $sort = (int) Yii::app()->request->getParam('sort');
            if (is_numeric($sort) && $id > 0)
                echo CJSON::encode(array('num' => BaikeExt::setSort($id, $sort), 'sort' => $sort));
        }
    }

    /**
     * 拉取数据
     */
    public function actionAjaxPullData()
    {
        $baike = BaikeExt::model()->find(
            array('order'=>'yid desc')
            );
        $num = Yii::app()->request->getQuery('num',20);
        $html = 'http://yun.hangjiayun.com/house/api/baike?tid='.($baike?$baike->yid:'0').'&signature='.md5('house').'&num='.$num;
        $yun_baike = HttpHelper::get($html);
        $content = json_decode($yun_baike['content']);
        if((int)$content->msg->total > 0) {
            $data = $content->msg->data;
            foreach ($data as $key => $value) {
                $bk = new BaikeExt();
                $value = get_object_vars($value);
                //yid转换
                $value['yid'] = $value['id'];
                unset($value['id']);
                //cid转换
                $cate = BaikeCateExt::model()->findAll(array(
                    'select' => 'id,pinyin',
                    'index' => 'pinyin',
                ));
                $pinyin = $value['pinyin'];
                if(isset($cate[$pinyin])) {
                    $value['cid'] = $cate[$pinyin]->id;
                }

                $file = Yii::app()->file;
                //文章抠图抓取
                preg_match_all("/\<img.*?src\=[\"\'](.*?)[\"\'][^>]*>/i", $value['content'], $match);
                $oldPics = $match[1];
                $newPics = array();
                if(is_array($oldPics))
                {
                    foreach($oldPics as $k=>$picUrl)
                    {
                        $url = $file->fetch($picUrl);
                        if(!empty($url))
                        {
                            $url = ImageTools::fixImage($url);
                        }
                        else
                            $url = '';
                        $value['content'] = str_replace($picUrl, $url, $value['content']);//将文章内的图片链接替换成新抓取的
                    }
                }
                $localImage = $file->fetch($value['image']);
                $value['image'] = $localImage?$localImage:'';
                $value['author_id'] = Yii::app()->user->id;
				$value['author'] = Yii::app()->user->username;
                $bk->attributes = $value;
                if(!($bk->save()))
                {
                   $this->setMessage('操作失败！','error');
                   $this->response(0, '操作失败！');
                }
            }
        } else {
            $this->setMessage('远程无更新数据，请过段时间尝试','error');
            $this->response(false, '远程无更新数据，请过段时间尝试');
        }
        $this->setMessage('操作成功！','success');
        $this->response(1, '操作成功！');
    }

    /**
     * 获取知识库标签
     */
    public function actionTagList()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria;
        $criteria->order = 'sort desc ,id desc';
        $dataProvider= BaikeTagExt::model()->getList($criteria,20);
        $this->render('taglist', array(
            'data' => $dataProvider -> data,
            'pager' => $dataProvider -> pagination,
        ));
    }

	/**
	 * 百科标签编辑页
	 * @param  integer $id [description]
	 */
	public function actionTagEdit($id=0)
	{
		if(!$model = BaikeTagExt::model()->findByPk($id)) {
			$model = new BaikeTagExt;
		}

		if(Yii::app()->request->isPostRequest) {
			$model->attributes = Yii::app()->request->getPost('BaikeTagExt');
			if($model->save()) {
				$this->setMessage('保存成功','success',['tagList']);
			} else {
				$msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败';
				$this->setMessage($msg, 'error');
			}
		}
		$this->render('tagedit', [
			'model' => $model,
		]);

	}

    /**
     * ajax推荐知识库标签
     */
    public function actionAjaxRecomBaikeTag()
    {
        $id = Yii::app()->request->getPost('id',0);
		$type = Yii::app()->request->getPost('type',-1);
        if($id){
            $ids = explode(',',$id);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $tags = BaikeTagExt::model()->findAll($criteria);
            $transaction = Yii::app()->db->beginTransaction();
            foreach ($tags as $key => $tag) {
				if($type==0) {//取消推荐
					$tag->cancelRecommend();
				} elseif($type==1) {//推荐
					$tag->recommend();
				} else {//切换
					$tag->toggleRecommend();
				}
                if(!$tag->save())
                {
                    $transaction->rollback();
                    $this->setMessage('操作失败！','error');
                }
            }
            $transaction->commit();
            $this->setMessage('操作成功！','success');
        }
    }

    /**
     * Ajax编辑百科标签排序
     */
    public function actionAjaxBaikeTagSort($id = 0,$sort = 0)
    {
        $old = 0;
        $model = BaikeTagExt::model()->findByPk($id);
        $old = $model->sort;
        $model->sort = $sort;
        if($model->save())
            $this->response(true,$sort);
        else
            $this->response(false,$old);
    }

    /**
     * ajax删除百科标签
     */
    public function actionAjaxBaikeTagDel()
    {
        if(Yii::app()->request->getIsPostRequest()){
			$ids = Yii::app()->request->getPost('ids',0);
	        if($ids){
	            $ids = explode(',',trim($ids,','));
	            $criteria = new CDbCriteria;
	            $criteria->addInCondition('id', $ids);
	            $tags = BaikeTagExt::model()->findAll($criteria);
	            $transaction = Yii::app()->db->beginTransaction();
	            try{
	                foreach($tags as $v){
	                    if(!$v->delete()){
							throw new Exception('删除失败！');
						}
	                }
	                $transaction->commit();
	                $this->setMessage('操作成功！','success');
	            }catch(Exception $e){
	                $transaction->rollback();
	                $this->setMessage('操作失败！','error');
	            }
	        }
		}
    }
}
