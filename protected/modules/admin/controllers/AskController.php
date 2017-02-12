<?php

/**
 * 问答管理相关
 * @author 19gris
 * @date 2015-09-21
 */
class AskController extends AdminController {
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
     * 编辑区域列表
     */
    function actionCateList()
    {
        $list = AskCateExt::model()->findAll(array('order'=>'id ASC'));
        $cateArr = AskExt::model()->findAll(array(
            'select' => 'cid,count(id) as count',
            'group' => 'cid'
        ));
        $json = array();
        foreach($cateArr as $key=>$val)
        {
            $json[$val['cid']] = array('count'=>(int)$val['count'],'url'=>Yii::app()->createAbsoluteUrl('home/ask/list',array('cid'=>$val['cid'])));
        }
        foreach($list as $key=>$val)
        {
            if($val['parent'] != 0)
            {
                $json[$val['id']]['url'] =  Yii::app()->createAbsoluteUrl('home/ask/list',array('cid'=>$val['id']));
                $json[$val['id']]['count'] =  isset($json[$val['id']]['count'])?intval($json[$val['id']]['count']):0;
                $json[$val['parent']]['count'] = isset($json[$val['parent']]['count'])?intval($json[$val['parent']]['count']):0;
                $json[$val['parent']]['count'] += intval($json[$val['id']]['count']);
            } else {
                $json[$val['id']]['url'] = Yii::app()->createAbsoluteUrl('home/ask/list',array('cid'=>$val['id']));
            }
        }
        $json = json_encode($json);

        $tree = Tools::makeTree($list);

        $this->render('cate_list',array('tree'=>$tree,'json'=>$json));
    }
    /**
     * 区域管理 -- 区域添加编辑
     */
    public function actionCateEdit()
    {
        $this->layout = '/layouts/modal_base';
        $id = Yii::app()->request->getParam('id',0);
        if($id >0){
            $cate = AskCateExt::getAskCate($id);
            $msg = '修改';
        }else{
            $cate= new AskCateExt();
            $msg = '添加';
        }

        $_data = Tools::menuMake(AskCateExt::model()->parentLevel()->findAll('id!=:id',array(':id'=>$id)));
        $catelist[0] = '--根节点--';
        foreach($_data as $v){
            $catelist[$v['id']] = $v['name'];
        }

        if( Yii::app()->request->isPostRequest )
        {
            $AskCateInfo = Yii::app()->request->getPost('AskCateExt');
            $cate->setAttributes($AskCateInfo);

            if( $cate->save() ){
                $this->setMessage($msg.'成功！','success');
                echo "<script> parent.location = 'catelist';</script>";
            }else{
                $this->setMessage($msg.'失败！','error',Yii::app()->request->urlReferrer);
            }
        }

        $this->render('cate_edit',array(
            'cate'        =>$cate,
            'catelist'    =>$catelist,
        ));
    }

    /**
     * 区域管理 -- 删除区域
     */
    public function actionCateDel()
    {
        $id = Yii::app()->request->getParam('id',0);
        if($id > 0) {
            if(AskCateExt::AskCateDel($id)){
                echo CJSON::encode(array('code'=>100));exit;
            }else{
                echo CJSON::encode(array('code'=>-1));exit;
            }
        } else {
            echo CJSON::encode(array('code'=>-1));exit;
        }
    }

    /**
     * 区域管理 -- 处理排序2
     */
    public function actionCateEdieJson()
    {
        $data = Yii::app()->request->getParam('data');
        if($data) {
            $data = json_decode($data,TRUE);
            if(AskCateExt::AskCateSort($data))
                echo CJSON::encode(array('code'=>100));Yii::app()->end();
        }
        echo CJSON::encode(array('code'=>-1));Yii::app()->end();
    }

    /**
     * 区域管理 -- 处理排序
     */
    public function actionCateSort()
    {
        $sort = $_GET['Area']['sort'];
        $count =0;
        if(!empty($sort)||!empty($title)){
            foreach($sort as $k=>$v){
                $count = AskCate::model()->updateByPk($k,array('sort'=>$v));
                $count++;
            }
            if($count>0){
                $this->setMessage('操作成功！','success',Yii::app()->request->urlReferrer);
            }else{
                $this->setMessage('操作失败！','error',Yii::app()->request->urlReferrer);
            }
        }
    }

    /**
     * 问答列表
     */
    public function actionList()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $data['type'] = Yii::app()->request->getParam('type','');
        $data['value'] = Yii::app()->request->getParam('value','');
        $parent_id = Yii::app()->request->getParam('parent','');
        $child_id = Yii::app()->request->getParam('child',0);
        $criteria = new CDbCriteria(array(
            'order' => 'id desc',
        ));
        if($data['type']=='phone') $criteria->addSearchCondition('phone', $data['value']);
        if($data['type']=='question') $criteria->addSearchCondition('question', $data['value']);

        if($data['type']=='cid'){
            $criteria->addCondition("cid = :cid");
            $criteria->params[':cid']=$child_id;
        }
        $data = AskExt::model()->getList($criteria);
        $parents = AskCateExt::model()->parentLevel()->normal()->findAll(array('select'=>'id,name'));
        $arr = array();
        foreach($parents as $v){
            $arr[$v->id] = $v->name;
        }
        $parent_id = empty($parent_id) ? key($arr) : $parent_id;
        $childs = AskCateExt::model()->childLevel()->normal()->findAll(array('select'=>'id,name','condition'=>'parent=:parent','params'=>array(':parent'=>$parent_id)));
        $childs_arr = array();
        foreach($childs as $v){
            $childs_arr[$v->id] = $v->name;
        }
        $this->render('list', array(
            'data'=>$data->data,
            'pager'=>$data->pagination,
            'parents'=>$arr,
            'childs_arr'=>$childs_arr,
        ));

    }

    /**
     * 编辑问答
     */
    public function actionEdit($id=0)
    {
        $ask = $id ? AskExt::model()->findByPk($id) : new AskExt();
        $ask->scenario = 'answer';

        if(Yii::app()->request->getIsPostRequest())
        {
            $ask->attributes = Yii::app()->request->getPost('AskExt');
            if($ask->answer())
            {
                $this->setMessage('提交成功！','success',true);
            } else {
                $this->setMessage('提交失败！','error',Yii::app()->request->urlReferrer);
            }
        }
        $parentCate = AskCateExt::model()->parentLevel()->normal()->findAll();
        $pid = $ask->cate&&$ask->cate->parentCate ? $ask->cate->parentCate->id : (isset($parentCate[0])?$parentCate[0]->id:0);
        $childCate = AskCateExt::model()->childLevel()->normal()->findAll('parent=:id',[':id'=>$pid]);
        $this->render('edit', array(
            'ask'=>$ask,
            'parentCate'=>$parentCate,
            'childCate' => $childCate,
        ));
    }

    /**
     * 删除问答
     */
    public function actionDel()
    {
        $id = Yii::app()->request->getPost('id',0);
        if($id)
        {
            if(strpos($id,','))
                $id = explode(',', $id);
            $count = AskExt::model()->deleteByPk($id);
            if($count>0)
            {
                $this->setMessage('删除成功！','success',Yii::app()->request->urlReferrer);
            }
        }
        $this->setMessage('删除失败！','error',Yii::app()->request->urlReferrer);
    }

    /**
     * ajax获取二级联动下拉菜单[楼盘信息编辑页用]
     * @param  integer $parentId 上级id
     */
    public function actionAjaxGetCate($pid)
    {
        $data = AskCateExt::model()->childLevel()->normal()->findAll('parent=:id',[':id'=>$pid]);
        if($data)
        {
            foreach($data as $v)
            {
                echo CHtml::tag('option', array('value'=>$v->id), CHtml::encode($v->name), true);
            }
        }
        else
            echo CHtml::tag('option', array('value'=>''), CHtml::encode('--请添加子分类--'), true);
    }
    /**
     * ajax获取二级联动下拉菜单[问答页面用]
     * @param  integer $parentId 上级id
     */
    public function actionAjaxGetChildCate($pid){
        $data = AskCateExt::model()->childLevel()->normal()->findAll('parent=:id',[':id'=>$pid]);
        if($data){
            $arr = array();
            foreach($data as $k=>$v){
                $arr[$k] = array('id'=>$v->id,'name'=>$v->name);
            }
            echo CJSON::encode($arr);
        }
    }

}
