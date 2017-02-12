<?php
/**
 * 楼盘点评页面
 * @author steven_allen
 * @version 2016-06-17
 */
class CommentAction extends CAction
{
    public function run()
    {
    	$plot = $this->controller->plot;
        $comments = PlotCommentExt::model()->findAllByHid($plot->id);
        $this->controller->render('comment/index', array(
            'comments' => $comments,
        ));
    }
}
