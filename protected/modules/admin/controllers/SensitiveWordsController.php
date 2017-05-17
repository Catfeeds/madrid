<?php

/**
 * User: fanqi
 * Date: 2016/9/20
 * Time: 8:53
 * 敏感词控制器
 */
class SensitiveWordsController extends AdminController
{
    public function actionEdit()
    {
        $words = "";
        /**
         * 如果有post值，获取words，打开filter.txt，写入words
         * 如果没有，直接读取filter.txt
         */
        $filterFile = "protected/docs/filter.txt";
        if (Yii::app()->request->isPostRequest) {
            $words = Yii::app()->request->getPost("words", "");
            file_put_contents($filterFile,$words);
            $this->setMessage("保存成功");
        } else {
            if (file_exists($filterFile)) {
                $words = file_get_contents($filterFile);
            }
        }
        $this->render("edit", ['words' => $words]);
    }
}