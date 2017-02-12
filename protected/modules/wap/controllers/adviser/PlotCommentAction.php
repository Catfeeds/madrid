<?php
/**
 * 对楼盘点评
 * @author weibaqiu
 * @version 2016-06-02
 */
class PlotCommentAction extends CAction
{
    public function run($sid,$ajax=0)
    {
        $sid = (int)$sid;
        if( $ajax>0 ) {
            $criteria = new CDbCriteria(array(
                'condition' => 'sid=:sid',
                'params' => [':sid'=>$sid],
                'order' => 'id desc',
            ));
            $dataProvider = PlotCommentExt::model()->getList($criteria,5);
            $plotComments = $dataProvider->data;
            $pager = $dataProvider->pagination;
            $lists = array();
            foreach($plotComments as $plotComment) {
                $lists[] = array(
                    'title' => $plotComment->plot ? $plotComment->plot->title : '已删除',
                    'content' => $plotComment->content,
                );
            }
            $data = array(
                'totalPage' => $pager->pageCount,
                'lists' => $lists,
            );
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        $this->controller->render('plot_comment', array(
            'sid' => $sid,
        ));
    }
}
