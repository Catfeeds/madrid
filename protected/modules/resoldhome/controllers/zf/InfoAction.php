<?php
class InfoAction extends CAction{
    //出租房详情页
    public function run($id=0 ,$type=0){
        if(!$id)
            $this->controller->redirect('list');
        $zf = ResoldZfExt::model()->saling()->findByPk($id);
        if(!$zf)
        {
            $this->redirect('/resoldhome');
        }
        if($zf->category != 1 && !$type)
            $this->controller->redirect("/resoldhome/zf/info?id=$id&type=".$zf->category);
        $this->controller->viewRecordor->add($id,2);


        $zf->hits += 1;
        $zf->save();
        $user = $staff = $lasterZfs = [];
        $staff = $zf->getIsStaff();
        $lasterZfs = $zf->getLasterZf();
        $ptArr = [1=>'zfzzpt',2=>'zfsppt',3=>'zfxzlpt'];
        $tsArr = [1=>'zfzzts',2=>'zfspts',3=>'zfxzlts'];
        !$staff && $user = Yii::app()->uc->getUser(2,2) && $user = $user?$user[2]:[];
        $daily = PlotResoldDailyExt::getLastInfoByHid($zf->plot->id);
        $this->controller->zf = $zf;
        $this->controller->staff = $staff;
        $all_tag = $this->controller->allTag;
        $rent_type = TagExt::getNameByTag($zf->rent_type);
        $zf->rent_type = $rent_type === null ? '暂无' : $rent_type;
        $tag_array = array();
        $zf->data_conf = json_decode($zf->data_conf,true);
        foreach ($zf->data_conf as $key => $value) {
            if(isset($all_tag[$key])){
                foreach ($all_tag[$key] as $el){
                    if(is_array($value) && in_array($el['id'],$value))
                        $tag_array[$key][] = $el['name'];
                    if(!is_array($value) && $el['id'] == $value)
                        $tag_array[$key] = $el['name'];
                }
            }
        }
        $this->controller->render('info',array(
            'zf'=>$zf,
            'daily'=>$daily,
            'plot'=>$zf->plot?$zf->plot:[],
            'staff'=>$staff,
            'lasterZfs'=>$lasterZfs,
            'user'=>$user,
            'ptArr'=>$ptArr,
            'tsArr'=>$tsArr,
            'tagArray'=>$tag_array
        ));
    }
}
