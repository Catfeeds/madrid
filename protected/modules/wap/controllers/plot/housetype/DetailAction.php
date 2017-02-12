<?php
/**
 * 楼盘户型详细页
 * @author weibaqiu
 * @version 2016-05-25
 */
class DetailAction extends CAction
{
    public function run($id)
    {
        $huxing = PlotHouseTypeExt::model()->findByPk($id);
        if(!$huxing){
            throw new CHttpException(404, '户型不存在');
        }
        //2016.05.25问了刚哥，在线咨询放网站页面右侧的QQ，取第一个就行
        //接上句话，并且预约看房跳到买房顾问页面，并带参数过去
        $qq = '';
        $qqs = SM::globalConfig()->siteQq();
        foreach($qqs['type'] as $k=>$v) {
            if($v=='qq' && $qqs['number'][$k]) {
                $qq = $qqs['number'][$k];
            }
        }
        $this->controller->render('housetype/detail', array(
            'huxing' => $huxing,
            'loan' => $huxing->getLoanInfo(),
            'qq' => $qq,
        ));
    }
}
