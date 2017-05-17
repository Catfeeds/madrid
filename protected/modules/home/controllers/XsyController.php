<?php
/**
 * 小首页
 * @author weibaqiu
 * @date 2015-11-26
 */
class XsyController extends HomeController
{
    public $urlConstructor;

    public function filters()
    {
        return [
            'checkSite'
        ];
    }

    public function filterCheckSite($filterChain)
    {
        if(SM::urmConfig()->siteID()=='hualongxiang') {
            $this->urlConstructor = new UrlConstructor;
            $filterChain->run();
        }
    }

    public $layout = false;
    /**
     * 论坛板块帖子列表上部小首页
     */
    public function actionOne()
    {
        $xs = Yii::app()->search->house_plot;
        $xs->setQuery('');
        $xs->setFacets(array('status'),true);
        $xs->addRange('status',1,1);
        $xs->addRange('is_new',1,1);
        $xs->setLimit(1,1);
        $xs->search();
        $count = array_sum($xs->getFacets('status'));
        //--统计楼盘数end--

        $recomCate = RecomCateExt::model()->findAll(array(
            'with' => array(
                'recom',
                'parent' => array(
                    'condition' => 'parent.pinyin=:pinyin',
                    'params' => array(':pinyin'=>'xsy1')
                )
            ),
        ));
        //--推荐分类end--

        $staffs = StaffExt::model()->normal()->findAll(array(
            'condition' => 'qq!=""',
            'limit' => 3,
            'order'=>'recommend desc'
        ));

        $bankuai = RecomExt::model()->getRecom('xsy1bk', 4)->findAll();

        $this->render('one',array(
            'count' => $count,
            'recomCate' => $recomCate,
            'staffs' => $staffs,
            'bankuai' => $bankuai,
        ));
    }

    /**
     * 小首页二
     * 推荐团购
     */
    public function actionTwo()
    {
        $content = RecomExt::model()->getRecom('xsy2', 6)->findAll();
        $this->render('three', array(
            'content' => $content,
        ));
    }

    /**
     * 小首页三，根据论坛标签调取
     * @param  string $tagName 论坛标签名
     */
    public function actionThree($tagName='',$p='')
    {
        if($p)
        {
            $tagName = trim(($pos = strpos($p,','))?substr($p,0,$pos):$p);
        }
        // $this->redirect('http://t.house.hualongxiang.com/iframe/houselabel?p='.$p);
        $plot = PlotExt::model()->normal()->isNew()->find('title=:name',array(':name'=>$tagName));
        if(!$plot)
        {
            $plot = PlotExt::model()->normal()->isNew()->find(array(
                'order' => 'recommend desc,id desc',
                'offset' => rand(1,10),
            ));
        }
        if(!$plot)
        {
            echo '找不到楼盘';
            Yii::app()->end();
        }
        $articleRel = ArticlePlotRelExt::model()->findAll(array(
            'with' => array('article'),
            'condition' => 'hid=:hid',
            'params' => array(':hid'=>$plot->id),
            'order' => 'aid desc',
            'limit' => 4,
        ));
        $class = array('purple','grass_green','green');
        $this->render('two', array(
            'plot' => $plot,
            'articleRel' => $articleRel,
            'class' => $class,
        ));
    }


}
