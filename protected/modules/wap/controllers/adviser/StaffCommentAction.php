<?php
/**
 * 对买房顾问的点评
 * @author weibaqiu
 * @version 2016-06-02
 */
class StaffCommentAction extends CAction
{
    public function run()
    {
        $sid = (int)Yii::app()->request->getParam('sid', 0);
        //正常ajax请求数据展示列表
        if(Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria(array(
                'order' => 'id desc',
                'condition' => 'sid=:sid',
                'params' => [':sid'=>$sid]
            ));
            $dataProvider = StaffCommentExt::model()->enabled()->getList($criteria, 10);
            $comments = $dataProvider->data;
            $pager = $dataProvider->pagination;
            $lists = array();
            foreach($comments as $comment) {
                $lists[] = array(
                    'detail' => $comment->content,
                    'name' => '游客',
                    'date' => date('Y-m-d', $comment->created),
                    'time' => date('H:i:s', $comment->created),
                );
            }
            $data = array(
                'totalPage' => $pager->pageCount,
                'lists' => $lists,
            );
            echo CJSON::encode($data);
            Yii::app()->end();

        } elseif(Yii::app()->request->isPostRequest && $url = Yii::app()->request->getUrlReferrer()) {//提交点评

            $model = new StaffCommentExt;
            $model->attributes = Yii::app()->request->getPost('StaffCommentExt', []);
            $msg = $model->save() ? '提交成功，待审核后显示' : '提交失败，请重试';
            Yii::app()->user->setFlash('tip', $msg);
            $this->controller->redirect($url.'#comment');
            Yii::app()->end();
        }
    }
}
