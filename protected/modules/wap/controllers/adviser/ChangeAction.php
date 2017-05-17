<?php
/**
 * 买房顾问详细页的换一换接口
 * @author weibaqiu
 * @version 2016-06-14
 */
class ChangeAction extends CAction
{
    public function run($type,$sid)
    {
        switch($type) {
            case 'plotComment'://换一换点评楼盘
                $criteria = new CDbCriteria([
                    'limit' => 3,
                    'order' => 'rand()',
                ]);
                $count = PlotCommentExt::model()->countBySid($sid);
                $criteria->offset = $count>$criteria->limit ? rand(0, $count-$criteria->limit) : 0;
                $comments = PlotCommentExt::model()->findAllBySid($sid,$criteria);

                $lists = array();
                foreach($comments as $v) {
                    $lists[] = array(
                        'name' => $v->plot ? $v->plot->title : '-',
                        'detail' => $v->content,
                    );
                }
                echo CJSON::encode(['lists'=>$lists]);
                break;
            case 'record'://换一换带看记录
                $criteria = new CDbCriteria([
                    'condition' => 'sid=:sid',
                    'params' => array(':sid'=>$sid),
                    'limit' => 5,
                    'order' => 'rand()',
                ]);
                $count = StaffCheckExt::model()->countBySid($sid);
                $criteria->offset = $count>$criteria->limit ? rand(0, $count-$criteria->limit) : 0;
                $records = StaffCheckExt::model()->findAll($criteria);
                $lists = array();
                foreach($records as $v) {
                    $lists[] = array(
                        'name' => $v->user ? mb_substr($v->user->name,0,1,'utf-8').'**' : '匿名',
                        'mobile' => substr_replace($v->phone,'****',3,4),
                        'house' => $v->plot->title,
                        'date' => date('Y.m.d', $v->created)
                    );
                }
                echo CJSON::encode(['lists'=>$lists]);
                break;
        }
    }
}
