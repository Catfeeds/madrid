<?php
/**
 * wap首页
 */
class IndexController extends WapController
{
    /**
     * 新版房产走{@see actions()}方法中，并且使用布局为nobody
     * @return array
     */
    public function actions()
    {
        $this->layout = '/layouts/nobody';
        $alias = 'wap.controllers.index.';
        return array(
            'index' => $alias.'IndexAction',
            'nav' => $alias.'NavAction',
        );
    }

    /**
     * 跳转pc页面
     */
    public function actionRedirectPc()
    {
        $this->setStayInPc();
        $this->redirect(array('/home/index/index'));
    }
}
