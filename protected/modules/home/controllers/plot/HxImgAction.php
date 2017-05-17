<?php
/**
 * 楼盘户型页面
 * @author steven_allen
 * @version 2016-06-17
 */
class HxImgAction extends CAction
{
    public function run($offset=0)
    {
    	$plot = $this->controller->plot;
    	$pid = Yii::app()->request->getParam('pid', 0);
        $pic = PlotHouseTypeExt::model()->findByPk($pid);
        if (empty($pic)) {
            $this->controller->redirect(array('/home/plot/huxing', 'py'=>$plot->pinyin));
        }
        $count = PlotHouseTypeExt::model()->count(array(
            'condition'=>'hid=:hid and bedroom=:bedroom',
            'params'=>array(
                ':hid'=>$plot->id,
                ':bedroom'=>$pic->bedroom,
            ),
        ));
        $criteria = array(
                'select' => 'count(id) as count,bedroom',
                'condition' => 'hid=:hid',
                'group' => 'bedroom',
                'order' => 'bedroom asc',
                'limit' => 10,
                'params' => array(':hid'=>$plot->id)
        );
        $imgcate = PlotHouseTypeExt::model()->findAll($criteria);
        if($count <= $offset){
            $offset = 0;
            $list = $this->controller->getHxLb($plot->id,$pic->bedroom+1,$offset);
        }elseif($offset < 0){
            $offset = PlotHouseTypeExt::getCount($plot->id,$pic->bedroom-1);
            $list = $this->controller->getHxLb($plot->id,$pic->bedroom-1,$offset);
        }else{
            $list = $this->controller->getHxLb($plot->id,$pic->bedroom,$offset);
        }
        $this->controller->render('plot_hximg', array(
                'imgcate' =>$imgcate,
                'pic' => $pic,
                'list' => $list,
                'offset'=>$offset,
                'count'=>$count-1,
                'nextImg' => $this->getNext($list,$pic),
                'preImg' => $this->getPrev($list,$pic),
            )
        );
    }

    /**
     * 返回上一条图片的ID
     * @param $list 查询出来的相册
     * @param $pic 当前图片
     * @return int() 返回上一条图片的ID
     */
    public function getPrev($list,$pic){
        $pid = $list[0]['id'];
        foreach($list as $k=>$v){
            if($v['id'] == $pic->id && $k>=1){
                $pid = $list[$k-1]['id'];
            }
        }
        return $pid;
    }

    /**
     * 返回下一条图片的ID
     * @param $list 查询出来的相册
     * @param $pic 当前图片
     * @return int() 返回下一条图片的ID
     */
    public function getNext($list,$pic){
        $count = count($list);
        $last = $count-1;
        $pid = $list[$last]['id'];
        foreach($list as $k=>$v){
            if($v['id'] == $pic->id && $k<$last){
                $pid = $list[$k+1]['id'];
            }
        }
        return $pid;
    }
}
