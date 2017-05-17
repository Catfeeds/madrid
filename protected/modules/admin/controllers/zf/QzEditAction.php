<?php

/**
 * User: fanqi
 * Date: 2016/8/9
 * Time: 16:12
 */
class QzEditAction extends CAction
{
    public function run($id = 0)
    {
        $qz = ResoldQzExt::getQz($id);
        if (Yii::app()->request->getIsPostRequest()) {
            $params = Yii::app()->request->getPost('ResoldQzExt', []);
            $qz->scenario = Yii::app()->params['categoryPinyin'][$params['category']];
            $qz->attributes = $params;
            
            // $hids = [];
            // if(is_array($params['hid'])){
            //     foreach ($params['hid'] as $key => $value) {
            //        $value &&  $hids[] = $value;
            //     }
            // }
            // if($hids)
            //     $qz->hid = json_encode($hids);
            // else
            //      $qz->hid = '';
            $qz->hid = json_encode($params['hid']);
            $tip = $id > 0 ? '修改' : '添加';
            // var_dump($params,$qz->resoldhuxing);exit;
            !$qz->uid && $qz->uid = SM::resoldConfig()->resoldAdminUid();
            if ($qz->save()) {
                $msg = $tip . '成功!';
                $this->controller->setMessage($msg);
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'qzList');
            } else {
                $msg = array_values($qz->errors)[0][0];
                $this->controller->setMessage($msg, 'error');
            }
        }
        //根据hid集合获取楼盘信息集合
//        if (($json_hid = $qz->hid) && (is_array($hids = CJSON::decode($json_hid)))) {
//            $qz->hid = array_filter($hids);
//        }
        $plots = $qz->plots;
        // var_dump($plots);exit;
        return $this->controller->render('qzedit', ['qz' => $qz, 'plots' => $plots]);
    }
}