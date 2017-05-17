<?php
/**
 * 特价房详情页
 * @author weibaqiu
 * @version 2016-05-25
 */
class DetailAction extends CAction
{
    public function run($id)
    {
        $special = PlotSpecialExt::model()->findByPk($id);
        if (!$special) {
            throw new CHttpException(404, '特价房未找到');
        }
        //默认使用关联的户型图
        $image = $special->houseType ? $special->houseType->image : '';

        $this->controller->render('detail', array(
            'special' => $special,
            'image' => $image,
        ));
    }
}
