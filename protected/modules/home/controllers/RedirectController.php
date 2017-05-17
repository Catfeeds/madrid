<?php
class RedirectController extends HomeController
{
    public function actionPlot($id=0, $pinyin='')
    {
        if($id>0 && $plot = PlotExt::model()->find('old_id=:id', [':id'=>$id])) {
            $pinyin = $plot->pinyin;
        }
        if($pinyin!='') {
            $this->redirect(['/home/plot/index','py'=>$pinyin]);
        } else {
            $this->redirect(['/home/plot/list']);
        }
    }

    public function actionArticle($id)
    {
        if($id>0 && $article = ArticleExt::model()->find('old_id=:id',[':id'=>$id])) {
            $this->redirect(['/home/news/detail', 'articleid'=>$article->id]);
        }
        $this->redirect(['/home/news/list']);
    }
}
