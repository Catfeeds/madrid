<?php
class SiteController extends HangjiaController
{
    public function actionUpgrade()
    {
        $data = [
            'isLatest' => 0,
            'time' => 0,
        ];
        $row = SiteConfigExt::model()->find('name=:name', [':name'=>'isLatest']);
        if($row) {
            $data['isLatest'] = (int)$row->config;
            $data['time'] = $row->created;
        }
        echo CJSON::encode($data);
    }
}
