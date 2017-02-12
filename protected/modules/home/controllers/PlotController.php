<?php
/**
 * 前台首页
 * @author SC
 * @date 2015-09-24
 */
class PlotController extends HomeController
{
    /**
     * 当前浏览的楼盘
     * @var PlotExt
     */
    public $plot;
    /**
     * 楼盘浏览记录器
     * @var PlotViewRecordor
     */
    public $viewRecordor;
    public $urlConstructor;

    public function init()
    {
        parent::init();
        $this->viewRecordor = new PlotViewRecordor;
        $this->urlConstructor = new UrlConstructor;
    }

    //验证码
    public function actions()
    {
        $alias = 'home.controllers.plot.';
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'Captcha',
                'backColor'=>0xf4f4f4,
                'padding'=>0,
                'height'=>30,
                'maxLength'=>4,
            ),
            'list' => $alias.'ListAction',//楼盘列表页
            'index' => $alias.'IndexAction',//楼盘主页
            'evaluate' => $alias.'EvaluateAction',//楼盘评测页
            'comment' => $alias.'CommentAction',//楼盘点评页
            'hximg' => $alias.'HxImgAction',//户型图详情
            'huxing' => $alias.'HuxingAction',//户型图列表
        );
    }

    public function filters()
    {
        return array('getPlot - list');
    }


    public function filterGetPlot($chain)
    {
        $py = Yii::app()->request->getQuery('py', 0);
        $this->layout = '/layouts/base_red';

        $model = PlotExt::model()->normal()->isNew();
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
        $this->viewRecordor->add($this->plot);//记录最近浏览楼盘
        $this->plot->AddViews();//楼盘浏览量计数
        $chain->run();
    }

    /**
     * 验证验证码
     */
    public function actionValidateCaptcha(){
        $cap = $_POST['captcha'];
        $captcha = new CaptchaExt;
        $captcha->verifyCode = $cap;
        if($captcha->validate()){
            $arr = array('status'=> true);
        }else{
            $arr = array('msg'=>"验证码错误！",'status'=> false,'tst'=>$_POST['captcha']);
        }
         echo CJSON::encode($arr);
    }

    public function actionDetail()
    {
        $hotTuan = PlotTuanExt::getHotTuan();
        $this->render('plot_detail', array(
                'hotTuan' => $hotTuan,
            )
        );
    }

    /**
     * 楼盘页面公共底部
     */
    protected function footer()
    {
        $benyue = PlotExt::model()->normal()->isNew()->findAll(array(
            'condition' => 'open_time>:begin',
            'params' => array(':begin'=>TimeTools::getMonthBeginTime()),
            'limit' => 5
        ));
        $tongQuYu = PlotExt::model()->normal()->isNew()->findAll(array(
            'condition' => 'street=:street',
            'params' => array(':street'=>$this->plot->area),
            'limit' => 5,
        ));
        $priceRange = PlotPricetagExt::getTidByPrice($this->plot->price);
        $this->renderPartial('plot_footer', array(
            'benyue' => $benyue,
            'tongQuYu' => $tongQuYu,
            'priceRange' => $priceRange,
        ));
    }

    /**
     * 楼盘主页相册
     */
    public function actionAlbum()
    {
        $t = Yii::app()->request->getParam('t', 0);
        $imgcate = PlotImgExt::getImgBycate($this->plot->id);
        $cate_arr = TagExt::model()->getTagByCate('xcfl')->findAll();
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
     * 楼盘主页相册详情页
     * @param int $offset 偏移量
     */
    public function actionImage($offset=0)
    {
        $pid = Yii::app()->request->getParam('pid', 0);
        $pic = PlotImgExt::model()->findByPk($pid);
        if (empty($pic)) {
            $this->redirect(array('/home/plot/album', 'py'=>$this->plot->pinyin));
        }
        $imgcate = PlotImgExt::getImgBycate($this->plot->id);
        $cate_arr = TagExt::model()->getTagByCate('xcfl')->normal()->findAll();
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

    public function actionMap()
    {
        $imglist = PlotImgExt::model()->findAll(array(
                            'condition' => 'hid=:hid and type=:type',
                            'order' =>  'id desc',
                            'limit' => 6,
                            'params' => array(
                                    ':hid' => $this->plot->id,
                                    ':type'=>TagExt::getPtId(),
                            )
        ));
        $this->render('plot_map', array(
                    'imglist' => $imglist
            )
        );
    }

    /**
     * 楼盘价格页
     */
    public function actionPrice()
    {
        $criteria = new CDbCriteria([
            'condition' => 'hid=:hid',
            'params'=>[':hid'=>$this->plot->id],
            'order'=>'created desc',
            'limit' => SM::urmConfig()->siteID()=='hualongxiang' ? 1 : 30//2016-10-18化龙巷临时，PriceTrendChart类中也要改
        ]);
        $list = PlotPriceExt::model()->findAll($criteria);
        $jglb = CHtml::listData(TagExt::model()->getTagByCate('jglb')->normal()->findAll(), 'id', 'name');
        $priceTrend = new PriceTrendChart($this->plot);

        $this->render('plot_price', array(
                    'list' => $list,
                    'jglb' => $jglb,
                    'priceTrend' => $priceTrend,
            )
        );
    }

    public function actionNews()
    {
        //分页过程
        $sql = "select count(t.id) from `article` t INNER JOIN `article_plot_rel` `apr` on `t`.`id`=`apr`.`aid` WHERE `apr`.`hid`=:hid AND `t`.`status`=1 ORDER BY `t`.`id` DESC";
        $params[':hid'] = $this->plot->id;
        $total = ArticleExt::model()->countBySql($sql, $params);
        $pager = new CPagination($total);
        $pager->pageSize = 15;

        //取数据
        $sql = str_replace('count(t.id)','t.*',$sql).' LIMIT :offset,:limit';
        $params[':limit'] = $pager->limit;
        $params[':offset'] = $pager->offset;
        $data = ArticleExt::model()->findAllBySql($sql, $params);

        $hotTuan = PlotTuanExt::getHotTuan();
        $this->render('plot_news', array(
                    'list' => $data,
                    'pager' => $pager,
                    'hotTuan' => $hotTuan
            )
        );
    }

    public function actionFaq()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('hid=:hid and status=1 and answer!=:answer');
        $criteria->params = array(':hid'=>$this->plot->id,':answer'=>"");
        $criteria->order = 'created DESC,updated DESC';
        $data = AskExt::model()->getList($criteria, 10);
        $this->render('plot_faq', array(
                'list' => $data->data,
                'pager' => $data->pagination,
            )
        );
    }


    //返回QUERY查询参数
    public function construct_uri($param, $value)
    {
        $uri_ary = array( 'kw' , 's' );
        $uri = '';
        foreach ($uri_ary as $key) {
            if ($key != $param) {
                if ($v = Yii::app()->request->getQuery($key, '')) {
                    $uri .= $uri?'&'.$key.'='.$v:'?'.$key.'='.$v;
                }
            } else {
                if ($value) {
                    $uri .= $uri?'&'.$key.'='.$value:'?'.$key.'='.$value;
                }
            }
        }
        echo $uri?$uri:'.';
    }



    /**
     * 根据楼盘ID、相册分类和偏移量查询
     * @param $hid 楼盘id
     * @param $room 房型(房间数目)
     * @param $offset 传入的偏移量
     * @param int $num 查询限制的条数
     * @return array()
     */
    public function getHxLb($hid,$room,$offset,$num=4)
    {
        $count = PlotHouseTypeExt::model()->count(array(
            'condition'=>'hid=:hid and bedroom=:bedroom',
            'params'=>array(':hid'=>$hid,':bedroom'=>$room),
        ));
        if($offset <= $num-2){
            $criteria = new CDbCriteria(array(
                'condition'=>'hid=:hid and bedroom=:bedroom',
                'params'=>array(':hid'=>$hid,':bedroom'=>$room),
                'order'=>'sort desc,id desc',
                'limit'=>$num,
                'offset'=>0,
            ));
            $offset1 = 0;
            $list = PlotHouseTypeExt::model()->findAll($criteria);
            foreach($list as $k=>$v){
                $arr = array();
                foreach($v as $kk=>$vv){
                    $arr[$kk] = $vv;
                }
                array_push($arr,$offset1);
                $list[$k] = $arr;
                $offset1 = $offset1 + 1;
            }
        }elseif($offset>$num-2 && $offset<=$count-4){
            $criteria = new CDbCriteria(array(
                'condition'=>'hid=:hid and bedroom=:bedroom',
                'params'=>array(':hid'=>$hid,':bedroom'=>$room),
                'order'=>'sort desc,id desc',
                'limit'=>$num,
                'offset'=>$offset-2,
            ));
            $offset2 = $offset-2;
            $list = PlotHouseTypeExt::model()->findAll($criteria);
            foreach($list as $k=>$v){
                $arr = array();
                foreach($v as $kk=>$vv){
                    $arr[$kk] = $vv;
                }
                array_push($arr,$offset2);
                $list[$k] = $arr;
                $offset2 = $offset2 + 1;
            }
        }else{
            $criteria = new CDbCriteria(array(
                'condition'=>'hid=:hid and bedroom=:bedroom',
                'params'=>array(':hid'=>$hid,':bedroom'=>$room),
                'order'=>'sort desc,id desc',
                'limit'=>$num,
                'offset'=>$count-4,
            ));
            $offset3 = $count-4;
            $list = PlotHouseTypeExt::model()->findAll($criteria);
            foreach($list as $k=>$v){
                $arr = array();
                foreach($v as $kk=>$vv){
                    $arr[$kk] = $vv;
                }
                array_push($arr,$offset3);
                $list[$k] = $arr;
                $offset3 = $offset3 + 1;
            }
        }
        return $list;
    }

    /**
     * 获取上一组图片的偏移量
     */
    public function getCount($hid,$room)
    {
        $count = PlotHouseTypeExt::model()->count(array(
            'condition'=>'type=:type and bedroom=:bedroom',
            'params'=>array(':type'=>$type,':bedroom'=>$room),
        ));
        if(empty($count)){
            $offset = 0;
        }else{
            $offset = $count - 1;
        }
        return $offset;
    }
}
