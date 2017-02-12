<?php
class ShopController extends VipController
{
    public function actions()
    {
        $alias = 'vip.controllers.shop.';
        return [
            'staff' => $alias . 'StaffListAction',//商家列表页
            'info' => $alias . 'ShopEditAction',//商家编辑页 
            'staffEdit' => $alias . 'StaffEditAction',//商家编辑页 
        ];
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

    public function actionStaffStatus()
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
                $data = ResoldStaffExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    switch ($kw) {
                        case 'open':
                            $v->status = 1;
                            break;
                        case 'close':
                            $v->status = 2;
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
}
