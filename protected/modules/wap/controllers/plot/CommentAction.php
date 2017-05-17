<?php
/**
 * 楼盘买房顾问点评页
 * @author weibaqiu
 * @version 2016-05-30
 */
class CommentAction extends CAction
{
    public $plot;

    public function run()
    {
        $this->plot = $this->controller->plot;
        $comments = PlotCommentExt::model()->findAllByHid($this->plot->id,['order'=>'id desc']);
        $this->controller->render('comment', array(
            'comments' => $comments,
        ));
    }
}
