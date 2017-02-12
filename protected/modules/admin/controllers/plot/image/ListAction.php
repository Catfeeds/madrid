<?php
/**
 * 图片列表页
 * @author weibaqiu
 * @version 2016-07-14
 */
class ListAction extends CAction
{
    public function run($hid, $type = 0)
    {
        $hid = (int)$hid;
        $this->controller->layout = '/layouts/modal_base';
        //列表页不需要加normal命名范围，避免选择分类的相册展示出来报错
        $tags = TagExt::model()->getTagByCate('xcfl')->findAll(['index'=>'id']);
        $normalTags = [];
        foreach($tags as $tag){
            if($tag->getIsEnabled()){
                $normalTags[] = $tag;
            }
        }
        $ctype = CHtml::listData($normalTags, 'id', 'name');

        $criteria = new CDbCriteria(array(
            'condition' => 'hid=:hid',
            'params' => array(':hid'=>$hid),
        ));

        if ($type) {
            $criteria->addCondition("type = :type");
            $criteria->params[':type']=$type;
        }

        $criteria->order = 'sort DESC,id DESC';

        $dataProvider = PlotImgExt::model()->getList($criteria);

        $this->controller->render('image/list', array(
            'hid'   =>  $hid,
            'type' => $type,
            'tags' => $tags,
            'ctype' =>  $ctype,
            'data'  =>  $dataProvider->data,
            'pager' =>  $dataProvider->pagination,
        ));
    }
}
