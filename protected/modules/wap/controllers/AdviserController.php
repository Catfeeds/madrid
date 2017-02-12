<?php
/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2016/1/28
 * Time: 8:49
 */
class AdviserController extends WapController
{
    public function actions()
    {
        $alias = 'wap.controllers.adviser.';
        return array(
            'index' => $alias.'IndexAction',//买房顾问表单提交
            'record' => $alias.'RecordAction',//带看记录
            'staff' => $alias.'StaffAction',//买房顾问详细页
            'staffComment' => $alias.'StaffCommentAction',//对买房顾问的点评
            'plotComment' => $alias.'PlotCommentAction',//对楼盘的点评
            'praise' => $alias.'PraiseAction',//点赞
            'change' => $alias.'ChangeAction',//买房顾问详细页的换一换
        );
    }
}
