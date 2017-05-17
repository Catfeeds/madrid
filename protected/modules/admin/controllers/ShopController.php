<?php
class ShopController extends AdminController
{
    public function actions()
    {
        $alias = 'admin.controllers.shop.';
        return [
            'shopList' => $alias . 'ShopListAction',//商家列表页
            'shopEdit' => $alias . 'ShopEditAction',//商家编辑页 
        ];
    }

    /**
     * [actionAjaxDelQg 删除二手房]
     * @return [type] [description]
     */
    public function actionAjaxDelShop()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $esf = ResoldShopExt::model()->findByPk($id);
            $esf->deleted = 1;
            if ($esf->save()) {
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }

    public function actionShopStatus()
    {
        if (Yii::app()->request->isPostRequest) 
        {
            $ids = Yii::app()->request->getPost('ids', false);
            $kw = Yii::app()->request->getPost('kw', false);

        }
        else
        {
            $ids = Yii::app()->request->getQuery('ids', false);
            $kw = Yii::app()->request->getQuery('kw', false);

        }
        if ($ids!==false && $kw!==false) {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = ResoldShopExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    switch ($kw) {
                        case 'open':
                            $v->status = 1;
                            break;
                        case 'close':
                            $v->status = 2;
                            //店铺关闭，店铺下所有房源下架
                            $esfs = ResoldEsfExt::model()->findAll(['condition'=>'sid=:sid and sale_status=1','params'=>[':sid'=>$v->id]]);
                            foreach ($esfs as $key => $v1) {
                                $v1->sale_status = 2;
                                $v1->save();
                            }
                            $zfs = ResoldZfExt::model()->findAll(['condition'=>'sid=:sid and sale_status=1','params'=>[':sid'=>$v->id]]);
                            foreach ($zfs as $key => $v2) {
                                $v2->sale_status = 2;
                                $v2->save();
                            }
                            break;
                        case 'check':
                            $v->status = 0;
                            break;   
                    }
                    $v->save();
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
     * ajax修改排序
     */
    public function actionAjaxShopSort()
    {
        $id = (int)Yii::app()->request->getParam('id', 0);
        $sort = (int)Yii::app()->request->getParam('sort', 0);
        $esf = ResoldShopExt::model()->findByPk($id);
        if ($esf) {
            $esf->sort = $sort;
            if($esf->save())
               $this->setMessage('操作成功!', 'success');
            else
                $this->setMessage('操作失败!', 'error');
        }
    }

    /**
     * [actionAjaxGetShop 获取所有商家]
     * @return [type] [description]
     */
    public function actionAjaxGetShop($kw='')
    {
        $data = [];
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('name',$kw);
        $shops = ResoldShopExt::model()->undeleted()->findAll($criteria);
        if($shops)
        foreach ($shops as $key => $value) {
            $tmp['id'] = $value['id'];
            $tmp['name'] = $value['name'];
            $data[] = $tmp;
        }
        echo CJSON::encode(['results'=>$data,'more'=>false]);
    }
}
