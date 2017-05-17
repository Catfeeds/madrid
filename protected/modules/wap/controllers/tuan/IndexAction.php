<?php
/**
 * 看房团列表页
 * @author steven_allen
 * @version 2016-06-08
 */
class IndexAction extends CAction
{
    public function run($ajax=0)
    {
        if(!$ajax)
        {
            $this->controller->render('index');
        }
        else
        {
            $data = array();
            $criteria = new CDbCriteria();
            $criteria -> order = 'created desc';
            $dataProvider = PlotKanExt::model()->normal()->getList($criteria,10);
            $kan = $dataProvider->data;
            $pager = $dataProvider->pagination;
            $data['totalPage'] = $pager->pageCount;
            if($kan)
            foreach ($kan as $key => $v) {
                $progress = array();
                foreach ($v->plots as $k => $n) {
                    $tags = array();
                    foreach($n->xmts as $k=>$ts){
                        if($k<3) {
                            $tags[] = array(
                                'type' => $k+1,
                                'name' => $ts->name,
                            );
                        }
                    }
                    $progress[] = array(
                        "title"=>$n->title,
                        "price"=>PlotPriceExt::getPrice($n->price,$n->unit),
                        "addr"=>(isset($this->controller->siteArea[$n->area])&&!empty($this->controller->siteArea[$n->area])) ? ($this->controller->siteArea[$n->area].((isset($this->controller->siteStreet[$n->area])&&!empty($this->controller->siteStreet[$n->area])) ? ((isset($this->controller->siteStreet[$n->area][$n->street])&&!empty($this->controller->siteStreet[$n->area][$n->street])) ? '/'.$this->controller->siteStreet[$n->area][$n->street] : '') :'' )) : '',
                        "desc"=>($n->red)?($n->red->title):($n->discount?($n->discount->title):''),
                        "link"=>$this->controller->createUrl('plot/index',['py'=>$n->pinyin]),
                        "img"=>ImageTools::fixImage($n->image),
                        "tags"=>$tags
                        );
                }
                $tmp = array(
                    "title"=>Tools::utf8substr($v->title,0,50),
                    "time"=>date('Y-m-d H:i',$v->gather_time),
                    "addr"=>$v->location,
                    "bm_num"=>$v->stat + $v->kanNum,
                    "bm_link"=>$this->controller->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('看房团',$v), 'title'=>$v->title,'plotName'=>$v->getPlots()?current($v->getPlots())->title:'')),
                    "progress"=>$progress,
                    "bm_state"=>$v->expire>time()?1:2,
                    );
                $data['lists'][] = $tmp;
            }
            echo CJSON::encode($data);
        }
    }
}
