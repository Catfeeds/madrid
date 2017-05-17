<?php
/**
 * 预约看房页面
 * @author steven_allen
 * @version 2016-05-27
 */
class IndexAction extends CAction
{
    public function run($spm='',$plot='')
    {
        $purifier = new CHtmlPurifier;
        $spm = $this->controller->cleanXss($spm);
        $plot = $this->controller->cleanXss($plot);
        if(empty($spm)) {
            $spm = OrderExt::generateSpm('自由组团');
        }
        $comments = StaffCommentExt::model()->enabled()->findAll(array('order'=>'created desc','limit'=>6));
        $this->controller->render('index', array(
            'comments' => $comments,
            'spm' => $spm,
            'plot' => $plot,
        ));
    }
}
