<?php
/**
 * 楼盘图册浏览页
 * @author weibaqiu
 * @version 2016-05-30
 */
class AlbumAction extends CAction
{
    public function run()
    {
        //取得图片数量不为0的分类
        $filter = PlotImgExt::model()->findAll(array(
            'select' => 'count(id) as count,type',
            'condition' => 'hid=:hid',
            'params' => array(':hid'=>$this->controller->plot->id),
            'group' => 'type',
        ));
        $cates = array();
        foreach($filter as $v){
            if($v->count>0){
                $cates[] = $v->type;
            }
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $cates);
        $criteria->order = 'sort asc';
        $cates = TagExt::model()->getTagByCate('xcfl')->normal()->findAll($criteria);
        if(!$cates) throw new CHttpException(404,'相册分类不存在');

        $type = (int)Yii::app()->request->getQuery('type', $cates[0]['id']);

        //获取相册数据
        $list = PlotImgExt::model()->findAll(array(
            'condition'=>'type=:type and hid=:hid',
            'params'=>array(':type'=>$type,':hid'=>$this->controller->plot->id),
        ));

        $this->controller->render('album',array(
            'list' => $list,
            'cates' => $cates,
            'type' => $type,
        ));
    }
}
