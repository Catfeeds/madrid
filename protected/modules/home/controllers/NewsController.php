<?php

/**
 * 资讯列表
 * @author SC
 * @date 2015-10-8
 */
class NewsController extends HomeController {

    /**
     * 资讯列表
     */
    public function actionIndex($kw='', $cateid='') {
        $cate = ArticleCateExt::model()->normal()->findAll(array('limit' => 8, 'order' => 'sort DESC'));

        $criteria = new CDbCriteria(array(
            'condition' => 'show_time<=:time',
            'params' => [':time'=>time()],
            'order' => 'show_time desc',
        ));
        if ($cateid!='')
        {
            $criteria->addCondition('cid=:cid');
            $criteria->params[':cid'] = $cateid;
        }
        if($kw)
        {
            $criteria = new XsCriteria(array(
                'query' => $kw,
                'facetsField' => 'status',
            ));
            $criteria->addRange('show_time',null, time());
            $dataProvider = ArticleExt::model()->normal()->newest()->getXsList('house_article',$criteria,10);
        }
        else
        {
            $dataProvider = ArticleExt::model()->normal()->getList($criteria, 10);
        }
        $data = $dataProvider->data;
        $pager = $dataProvider->pagination;

        $this->render('index', array(
            'cate' => $cate,
            'article' => $data,
            'id'=>$cateid,
            'pager'=>$pager,
            ));
    }


    /**
     * 资讯详情
     */
    public function actionDetail($old_id=0)
    {
        if (intval($old_id) > 0) {
            $article = ArticleExt::model()->normal()->find('old_id=:id', [':id' => $old_id]);
            $this->redirect(['/' . $this->route, 'articleid' => $article->id]);
            Yii::app()->end();
        }
        /**
         * 提取销售状态的标签
         */
        $xszt = TagExt::model()->findAll('cate = :cate', array(':cate' => 'xszt'));
        $i = 0;
        $arrxszt = array();
        foreach ($xszt as $v) {
            $i++;
            $arrxszt[$i] = $v->name;
        }

        $id = Yii::app()->request->getParam('articleid', '');
        $match = array();
        $getArr = array();
        if (isset($id) && !empty($id)) {
            $articledetail = ArticleExt::model()->normal()->find('id=:id', array(':id' => $id));
            if (!$articledetail)
                throw new CHttpException(404, "文章不存在");
            $articledetail->addViews();
            $articledetail->replaceSensitive();

            //按楼盘名从长到短排序
            function sortPlot($a, $b)
            {
                return -(mb_strlen($a->title) - mb_strlen($b->title));
            }

            $plots = PlotExt::model()->normal()->isNew()->findAll();
            usort($plots, 'sortPlot');
            $tmpWords = array();//临时存放需要替换的，防止长的替换后，短的又把长的中的内容替换了

            //把标签属性中的楼盘名去掉，比如<img alt="世茂香槟湖" />
            foreach ($plots as $k => $v) {
                $articledetail->content = preg_replace('/\[p\](.*)alt="((.*?)' . $v->title . '(.*?))?"\[\/p\]/', '', $articledetail->content);
            }

            if (SM::articleConfig()->enableKeywordMatch()) {
                $i = $j = 0;
                $indexs = array();//记录替换的索引位置
                $leftPlots=array();//记录筛选出的楼盘
                $th = [];//title中的楼盘，用于替换
                if (isset($articledetail->keywords_switch) && !empty($articledetail->keywords_switch)) {
                    foreach ($plots as $k => $v) {
                        if (strpos($articledetail->content, $v->title) !== false && !in_array(strpos($articledetail->content, $v->title),$indexs)) {
                            $indexs[] = strpos($articledetail->content, $v->title);
                            $leftPlots[$k]=$v;
                        }
                    }
                    foreach($leftPlots as $k=>$v){
                        $tmpWords['{:' . $k . '}'] = '<a href="' . $this->createUrl("/home/plot/index", array("py" => $v->pinyin)) . '" target="_blank" class="c-red">' . $v->title . '</a>' . '(<a href="' . $this->createUrl('/home/plot/detail', array('py' => $v->pinyin)) . '" target="_blank" class="c-blue mr10 fs14">楼盘详情</a><a href="' . $this->createUrl('/home/plot/huxing', array('py' => $v->pinyin)) . '" target="_blank" class="c-blue mr10 fs14">户型图</a><a href="' . $this->createUrl('/home/plot/album', array('py' => $v->pinyin)) . '" target="_blank" class="c-blue mr10 fs14">相册</a><a href="' . $this->createUrl('/home/plot/map', array('py' => $v->pinyin)) . '" target="_blank" class="c-blue mr10 fs14">地图</a><span class="c-red fs14">' . $v->sale_tel . '</span>)';
                        //将title中楼盘替换为某个字符串并进行标记，用$j进行标记
                        if (preg_match('/\[title\]([^\]]*)' . $v->title . '([^\[]*)\[\/title\]/', $articledetail->content, $th[])) {
                            $articledetail->content = preg_replace('/\[title\]([^\]]*)' . $v->title . '([^\[]*)\[\/title\]/', '\\1+_+' . $j . '\\2', $articledetail->content);
                            $j++;
                        }
                        $articledetail->content = preg_replace('/' . $v->title . '/', $tmpWords['{:' . $k . '}'], $articledetail->content, 1);
                        $i++;
                    }
                    //处理th数组，找出替换楼盘
                    $replaceStr = [];
                    foreach ($th as $key => $v1) {
                        if ($v1) {
                            $replaceStr[] = $v1[0];
                        }
                    }
                    //替换
                    for ($i = 0; $i < $j; $i++) {
                        $articledetail->content = str_replace('+_+' . $i, $replaceStr[$i], $articledetail->content);
                    }
                }
            }

            $patternpage = '/\[page\](.*)\[\/page\]/U';
            $strpage = $articledetail->content;

            if (preg_match($patternpage, $strpage)) {
                $str = ArticleExt::model()->find('id=:id', array(':id' => $id))->content;
                /**
                 * 分页
                 */
                $detailpage = preg_replace($patternpage, '[page]', $strpage);
                $stageSub = explode('[page]', $detailpage);

                /**
                 * 提取标题
                 */
                $pattern = '/\[title\](.*)\[\/title\]/U';
                preg_match_all($pattern, $str, $match);

                /**
                 * 提取楼盘ID
                 */
                $patternhid = '/\[hid\](.*)\[\/hid\]/U';
                preg_match_all($patternhid, $str, $matchhid);

                $pageid = (int)Yii::app()->request->getParam('page', 1);

                /**
                 * 判断是否文章开头有标签
                 */
                $pregStagesub = strip_tags($stageSub[0]);
                if ($pregStagesub != "" || $pregStagesub != null) {
                    array_unshift($match[1], $articledetail->title);
                    array_unshift($matchhid[1], '');
                }
                $getid = $pageid - 1;
                $count = count($match[1]);
                $plotid = $matchhid[1][$getid];

                $plotdetail = PlotExt::model()->find('id = :id', array(':id' => $plotid));

                $allarticle = Yii::app()->request->getParam('allarticle', '');

                if (isset($allarticle) && !empty($allarticle)) {
                    $aid = $articledetail->id;
                    $getAriterid = ArticlePlotRelExt::model()->find(array('condition' => 'aid = :aid', 'params' => array(':aid' => $aid), 'limit' => 1, 'order' => 'created desc'));
                    $getAriterid ? $plotdetail = PlotExt::model()->find('id = :id', array(':id' => $getAriterid->hid)) : $plotdetail = array();
                }
                $getArr = array(
                    'articledetail' => $articledetail,
                    'title' => $match[1],
                    'count' => $count,
                    'hid' => $matchhid,
                    'page' => $stageSub,
                    'articleid' => $id,
                    'pagedetail' => $pageid,
                    'allarticle' => $allarticle,
                    'matchhid' => $matchhid[1],
                    'arrxszt' => $arrxszt,
                    'plotdetail' => $plotdetail,
                    'pregStagesub' => $pregStagesub,
                );
            } else {
                $aid = $articledetail->id;
                $getAriterid = ArticlePlotRelExt::model()->find(array('condition' => 'aid = :aid', 'params' => array(':aid' => $aid), 'limit' => 1, 'order' => 'created desc'));
                $getAriterid ? $plot = PlotExt::model()->find('id = :id', array(':id' => $getAriterid->hid)) : $plot = array();
                $getArr = array(
                    'articledetail' => $articledetail,
                    'articleid' => $id,
                    'arrxszt' => $arrxszt,
                    'plot' => $plot,
                );
            }
//            var_dump($plot);die;
            $this->render('detail', $getArr);
        }
    }
}
