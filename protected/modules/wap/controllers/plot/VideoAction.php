<?php

class VideoAction extends CAction
{
    public function run($id=0)
    {
        $id=(int)$id;
        $video=PlotVideoExt::model()->findByPk($id);
        $this->controller->render('video',['video'=>$video]);
    }
}