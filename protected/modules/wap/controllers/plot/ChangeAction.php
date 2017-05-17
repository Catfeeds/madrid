<?php
/**
 * 新房换一换接口
 * @author weibaqiu
 * @version 2016-06-07
 */
class ChangeAction extends CAction
{
    public function run()
    {
        $count = PlotExt::model()->normal()->isNew()->count();
        $criteria = new CDbCriteria;
        $criteria->limit = 4;
        $criteria->offset = $count>$criteria->limit ? rand(0, $count-$criteria->limit) : 0;
        $criteria->order = 'rand()';
        $plots =  PlotExt::model()->normal()->isNew()->findAll($criteria);
        $lists = array();

        $className = array('green', 'pink', 'blue', 'org');
        foreach($plots as $v) {
            $areaInfo = $v->areaInfo ? $v->areaInfo->name . ($v->streetInfo?' - '.$v->streetInfo->name:'') : '';
            $tags = array();
            foreach($v->xmts as $k=>$tag) {
                if($k<3) {
                    $tags[] = array(
                        'className' => $className[$k],
                        'txt' => $tag->name,
                    );
                }
            }
            $lists[] = array(
                'pic' => ImageTools::fixImage($v->image,640,300),
                'person' =>$v->evaluate && $v->evaluate->staff ? ImageTools::fixImage($v->evaluate->staff->avatar,100) : '',
                'link' => $this->controller->createUrl('/home/plot/index',['py'=>$v->pinyin]),
                'title' => $v->title . ($areaInfo?'['.$areaInfo.']':''),
                'detail' => Tools::u8_title_substr(str_replace(' ','',$v->data_conf['content']),118),
                'price' => $v->price ? PlotPriceExt::$mark[$v->price_mark].$v->price.PlotPriceExt::$unit[$v->unit] : '暂无价格',
                'tags' => $tags
            );
        }
        $data = array(
            'lists' => $lists,
        );
        echo CJSON::encode($data);
    }
}
