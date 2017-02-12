<?php
/**
 * 添加/修改商家信息
 * @author  steven.allen
 * @date 2016.08.23
  */
class ShopEditAction extends CAction
{
    public function run($id=0)
    {
    	if(Yii::app()->request->isPostRequest)
    	{
            $values = Yii::app()->request->getPost('ResoldShopExt',[]);
            $new_shop = $id == 0 ? new ResoldShopExt :ResoldShopExt::model()->findByPk($id);
            $new_shop->attributes = $values;
            $phoneArr = Yii::app()->request->getPost('phone_arr',[]);
            $imgs = Yii::app()->request->getPost('imgs',[]);
            $phone = '';
            if($phoneArr)
                $phone = implode(' ', $phoneArr);
            $new_shop->phone = trim($phone);
            if($new_shop->save())
            {
                $oldarr = [];// 旧图片
                // 保存图片
                if($new_shop->imgs)
                {
                    foreach ($new_shop->imgs as $key => $value) {
                        $oldarr[] = $value->url;
                    }
                }
                if(array_diff($imgs,$oldarr) || array_diff($oldarr,$imgs))
                {
                    $new_shop->imgs = $imgs;
                    $new_shop->saveImgs();
                }
                $this->controller->redirect('shopList');
            }
            else
            {
                var_dump($new_shop->errors);exit;
                $this->setMessage('保存失败','error');
            }

    	}
    	// exit;
        $maps = array('zoom' => 14, 'lat' => SM::globalConfig()->mapLat() ? SM::globalConfig()->mapLat() : "31.810077", 'lng' => SM::globalConfig()->mapLng() ? SM::globalConfig()->mapLng() : "119.974454");

    	$shop = $id == 0 ? new ResoldShopExt : ResoldShopExt::model()->findByPk($id);
        $this->controller->render('shopEdit',['shop'=>$shop,'maps'=>$maps]);
    }
}
