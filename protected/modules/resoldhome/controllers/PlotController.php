<?php
 /**
	 * 二手房小区
	 *
	 * @param type
	 * @return void
 */
class PlotController extends ResoldHomeController{
    /**
     * 当前浏览的楼盘
     * @var PlotExt
     */
    public $plot;
    /**
     * 搜索关键词
     * @var string
     */
    public $kw;
    /**
     * 楼盘浏览记录器
     * @var PlotViewRecordor
     */
    public $viewRecordor;
    public $urlConstructor;

    public function init()
    {
        parent::init();
    }
    public function actions(){
        $alias = 'resoldhome.controllers.plot.';
        return array(
            'list'=>$alias.'ListAction',
            'index'=>$alias.'IndexAction',
            'pzflist'=>$alias.'ZfListAction',
            'pesflist'=>$alias.'PesfListAction',
        );
    }

    public function filters()
    {
        return array('getPlot - list');
    }

    public function filterGetPlot($chain)
    {
        $py = Yii::app()->request->getQuery('py', 0);
        // $this->layout = '/layouts/base_red';

        $model = PlotExt::model()->normal();
        if (!empty($py)) {
            $this->plot = $model->find(array(
                'condition' => 'pinyin = :pinyin',
                'params' => array(':pinyin' => $py),
            ));

        } if($oldId = Yii::app()->request->getQuery('old_id')) {
            $this->plot = $model->find(array(
                'condition' => 'old_id = :old_id',
                'params' => array(':old_id' => $oldId),
            ));
            if($this->plot) {
                $this->redirect(['/'.$this->route,'py'=>$this->plot->pinyin]);
            }
        }
        if (empty($this->plot)) {
            throw new CHttpException(404, "小区不存在！");
        }
        //$this->viewRecordor->add($this->plot);//记录最近浏览楼盘
        //$this->plot->AddViews();//楼盘浏览量计数
        $chain->run();
    }

    /**
     * 楼盘主页相册
     */
    public function actionAlbum()
    {
        $t = Yii::app()->request->getParam('t', 0);
        $imgcate = PlotImgExt::getImgBycate($this->plot->id);
        $cate_arr = TagExt::model()->getTagByCate('xcfl')->normal()->findAll();
        $cate = array();
        foreach ($cate_arr as $v) {
            $cate[$v->id] = $v->name;
        }
        $criteria = new CDbCriteria;
        $criteria->addCondition('hid = :hid');
        $criteria->params = array(':hid'=>$this->plot->id);
        $criteria->order = 'sort desc,id desc';
        if ($t>0) {
            $criteria->addCondition('type = :type');
            $criteria->params[':type'] = $t;
        }
        $data = PlotImgExt::model()->getList($criteria, 12);
        $this->render('plot_album', array(
                't' => $t,
                'cate' => $cate,
                'imgcate' =>$imgcate,
                'list' => $data->data,
                'pager' => $data->pagination
            )
        );
    }
    /**
     * 小区详情
     * @return [type] [description]
     */
    public function actionDetail(){
        $this->render('plot_detail');
    }
    /**
     * 图片详情
     *
     */
     public function actionImage($offset=5){
         $pid = Yii::app()->request->getParam('pid', 0);
         $pic = PlotImgExt::model()->findByPk($pid);
         if (empty($pic)) {
             $this->redirect(array('/resoldhome/plot/album', 'py'=>$this->plot->pinyin));
         }
         $imgcate = PlotImgExt::getImgBycate($this->plot->id);
         $cate_arr = TagExt::model()->normal()->getTagByCate('xcfl')->findAll();
         $cate = array();
         foreach ($cate_arr as $v) {
             $cate[$v->id] = $v->name;
         }
         $list = PlotImgExt::getLb($this->plot->id, $pic->type,$offset);
         $count = PlotImgExt::model()->count(array(
             'condition'=>'hid=:hid and type=:type',
             'params'=>array(
                 ':hid'=>$this->plot->id,
                 ':type'=>$pic->type,
             ),
         ));
         $this->render('plot_image', array(
                 'cate' => $cate,
                 'imgcate' =>$imgcate,
                 'pic' => $pic,
                 'list' => $list,
                 'offset' => $offset,
                 'count' => $count-1,
             )
         );
     }
     /**
      * 小区地图
      */
     public function actionPlotMap(){
         $imgcate = PlotImgExt::getImgBycate($this->plot->id);
         $criteria = new CDbCriteria;
         $criteria->addCondition('hid = :hid');
         $criteria->params = array(':hid'=>$this->plot->id);
         $criteria->order = 'sort desc,id desc';
         $criteria->addCondition('type = :type');
         $criteria->params[':type'] = 21;
         $criteria->limit = 6;
         $list = PlotImgExt::model()->findALl($criteria);
         //获取小区图片
         $this->render('plot_map',array(
             'list'=>$list
         ));

     }
}
