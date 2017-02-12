<?php
/**
 * 资讯详情页
 * @author steven_allen
 * @version 2016-05-27
 */
class DetailAction extends CAction
{
    public function run()
    {
        $id = Yii::app()->request->getQuery('id');
        $article = ArticleExt::model()->normal()->find(array('condition'=>'id=:id','params'=>array(':id'=>$id)));
        $article->addViews();
        $article->replaceSensitive();
        $patternpage = '/\[page\](.*)\[\/page\]/U';
        $article->content = preg_replace($patternpage, '', $article->content);
        //楼盘
        //按楼盘名从长到短排序
        function sortPlot($a,$b)
        {
            return -(mb_strlen($a->title)-mb_strlen($b->title));
        }
        $plots = PlotExt::model()->normal()->isNew()->findAll();
        usort($plots, 'sortPlot');
        $tmpWords = array();//临时存放需要替换的，防止长的替换后，短的又把长的中的内容替换了

        foreach($plots as $k=>$v){
            $article->content = preg_replace('/\[p\](.*)alt="((.*?)'.$v->title.'(.*?))?"\[\/p\]/', '', $article->content);
        }

        if(SM::articleConfig()->enableKeywordMatch()) {
            if (isset($article->keywords_switch) && !empty($article->keywords_switch)) {
                foreach ($plots as $k => $v) {
                    if (strpos($article->content, $v->title) !== false) {
                        $tmpWords['{:' . $k . '}'] = '<a href="' . $this->controller->createUrl("/wap/plot/index", array("py" => $v->pinyin)) . '" target="_blank" class="c-red">' . $v->title . '</a>';
                    }
                    $article->content = preg_replace('/' . $v->title . '/', '{:' . $k . '}', $article->content, 1);
                }
                $article->content = str_replace(array_keys($tmpWords), array_values($tmpWords), $article->content);
            }
        }

        $plot = $article->getPlot();
        $criteria = new CDbCriteria;

        //相关推荐
        $recom_news = ArticleExt::model()->normal()->with('cate')->findAll(array('condition'=>'cate.id=:cid','params' => array(':cid' => $article->cid),'order'=>'t.show_time desc','limit'=>5));
        //微信分享设置
        $this->controller->wxShareImg = $article->image ? ImageTools::fixImage($article->image) : '';
        $this->controller->wxShareTitle = $article->title;
        $this->controller->pageDescription = $article->getDescription();

        $this->controller->render('detail', array(
            'news' => $article,
            'recom_news' => $recom_news,
        ));
    }
}
