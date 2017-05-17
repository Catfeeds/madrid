<?php
/**
 * 楼盘搜索页
 * @author weibaqiu
 * @version 2016-06-05
 */
class SearchAction extends CAction
{
    public $urlConstructor;

    public function run($keywords='')
    {
        if($keywords!='') {
            $xs = Yii::app()->search->house_plot;
            $xs->setScwsMulti(15);
            $xs->setQuery($keywords);
            $xs->addRange('status',1,1);
            $xs->addRange('deleted',0,0);
            $xs->addRange('is_new',1,1);
            $xs->setLimit(10,0);
            $docs = $xs->search();
            $lists = array();
            foreach($docs as $v) {
                $lists[] = array(
                    'title' => $v->title,
                    'address' => $v->address,
                    'link' => $this->controller->createUrl('/home/plot/index',['py'=>$v->pinyin]),
                );
            }
            echo CJSON::encode(array('lists'=>$lists));
            Yii::app()->end();
        }
        $this->urlConstructor = $this->controller->urlConstructor = new UrlConstructor('wap/plot/search');

        //区域
        $allArea = AreaExt::model()->frontendShow()->findAll(['index'=>'id']);

        //价格标签
        $priceTag = TagExt::model()->normal()->getTagByCate('xinfangjiage')->findAll(['order'=>'sort asc,id asc','index'=>'id']);


        //居室标签
        $hxs = PlotHouseTypeExt::model()->enabled()->findAll(array(
            'condition' => 'bedroom>0',
            'group' => 'bedroom'
        ));
        $bedrooms = array();
        foreach($hxs as $hx) {
            $bedrooms[$hx->bedroom] = $hx->getChineseBedroom().'居室';
        }

        //标签
        $xmtsTags = TagExt::model()->getTagByCate('xmts')->normal()->findAll(['index'=>'id']);

        //学校数据
        $xxCriteria = new CDbCriteria(['index'=>'id']);
        $xuexiao = SchoolExt::model()->normal()->findAll($xxCriteria);

        //所有标签
        $allTags = TagExt::model()->normal()->findAll();
        $allTagsIndexByCate = array();
        foreach($allTags as $tag){
            $allTagsIndexByCate[$tag->cate][$tag->id] = $tag;
        }

        //开盘时间
        $kpsjOptions = array(
            'by' =>array('name'=>'本月开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+1, 1, date('Y'))),
            'xy' =>array('name'=>'下月开盘','start'=>mktime(0, 0, 0, date('m')+1, 1, date('Y')),'expire'=>null),
            'syn' =>array('name'=>'三月内开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+2, 17, date('Y'))),
            'lyn' =>array('name'=>'六月内开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')+5, 17, date('Y'))),
            'qsy' =>array('name'=>'前三月已开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')-3, 17, date('Y'))),
            'qly' =>array('name'=>'前六月已开盘','start'=>strtotime(date('Y-m')),'expire'=>mktime(0, 0, 0, date('m')-6, 17, date('Y'))),
        );
        //排序设置
        $sortOptions = array(
            1 => array('name'=>'价格由高到低','value'=>false,'field'=>'price'),
            2 => array('name'=>'价格由低到高','value'=>true, 'field'=>'price'),
            3 => array('name'=>'开盘时间由近到远','value'=>false,'field'=>'open_time'),
            4 => array('name'=>'开盘时间由远到近','value'=>true,'field'=>'open_time'),
        );
        //所有价格标签

        $this->controller->render('search', array(
            'allArea' => $allArea,
            'priceTag' => $priceTag,
            'xmtsTags' => $xmtsTags,
            'xuexiao' => $xuexiao,
            'bedrooms' => $bedrooms,
            'allTagsIndexByCate' => $allTagsIndexByCate,
            'kpsjOptions' => $kpsjOptions,
            'sortOptions' => $sortOptions
        ));
    }
}
