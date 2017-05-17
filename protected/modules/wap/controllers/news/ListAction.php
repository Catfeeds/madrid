<?php
/**
 * 资讯列表页
 * @author steven_allen
 * @version 2016-05-26
 */
class ListAction extends CAction
{
    public function run($hid=0,$cid=0)
    {
        $cates = ArticleCateExt::model()->normal()->findAll(array('condition'=>'parent=0','order'=>'sort desc'));
        // var_dump($cid);exit;
        $this->controller->render('list', array(
            'cates' => $cates,
            'cid' => (int)($cid),
            'hid' => (int)$hid,
        ));
    }
}
