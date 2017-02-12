<?php
/**
 * 楼盘主页
 * @author steven_allen
 * @version 2016-05-27
 */
class IndexAction extends CAction
{
    public function run()
    {
        $this->controller->layout = '/layouts/body';
        $plot = $this->controller->plot;
        $data = array();
        $data['plot'] = $plot;
        $data['faceimg'] = PlotImgExt::getFaceByHid($plot->id);
        $data['tags'] = $plot->getXmts();
        $data['thtuan'] = $plot->tuan;
        $data['newKan'] = $plot->newKan && !empty($plot->newKan->expire) && ($plot->newKan->expire > time())?$plot->newKan:[];
        $data['special'] =  PlotSpecialExt::model()->findAll(array(
            'condition' => 'status = 1 and hid = :hid and end_time > :end_time',
            'params' => array(':hid' => $plot->id,':end_time'=>time()),
            'limit' => 3,
            'order' => 'recommend DESC, created DESC',
        ));
        $data['totalSpecial'] = $plot->specialNum;
        $data['comment'] = $plot->newComment;
        $data['huxing'] = $plot->newHuxing;
        $data['newBuilding'] = $plot->newBuilding;
        // $data['huxingStatus'] = PlotHouseTypeExt::getSaleStatus(1);
        $data['totalHuxing'] = PlotHouseTypeExt::model()->enabled()->count(array('condition'=>'hid=:hid','params'=>array(':hid'=>$plot['id'])));
        $data['periods'] =  $plot->period;
        //楼盘资讯
        $sql = "select a.* from article a left join article_plot_rel ap on a.id=ap.aid where ap.hid=".$plot->id." and a.status=1 order by a.sort desc,a.show_time desc limit 2";
        $data['news'] = ArticleExt::model()->findAllBySql($sql);
        $news_rel = ArticlePlotRelExt::model()->with('article')->findAll(array('condition'=>'hid=:hid','params'=>array(':hid'=>$plot->id),'order'=>'article.sort,article.created desc','limit'=>2));
        $data['totalNews'] = $plot->wenzhangNum;
        $data['ask'] = AskExt::model()->normal()->replyed()->newest()->with('plot')->findAll(array('condition'=>'hid=:hid','params'=>array(':hid'=>$plot['id']),'limit'=>3));
        $data['totalAsk'] = AskExt::model()->normal()->with('plot')->count(array('condition'=>'hid=:hid','params'=>array(':hid'=>$plot['id'])));

        $data['relPlots'] = PlotExt::model()->normal()->isNew()->findAll(array(
            'condition' => '(t.street=:street or t.area=:area) and t.price>:priceBegin and t.price<:priceEnd',
            'params' => array(
                ':street' => $plot->street,
                ':area' => $plot->area,
                ':priceBegin' => $plot->price-500,
                ':priceEnd' => $plot->price,
            ),
            'with' => array(
                'areaInfo' => array(
                    'alias' => 'a',
            )),
            'order' => 'a.parent desc, t.price desc',
            'limit' => 4,
        ));

        $this->controller->pageTitle = $plot->title;
        if($plot->tuan){
            $this->controller->pageTitle .= '_'.$plot->tuan->title;
        }elseif($plot->newDiscount){
            $this->controller->pageTitle .= '_'.$plot->newDiscount->title;
        }
        $this->controller->pageTitle .= '_'.SM::urmConfig()->cityName().$plot->title.'价格_'.$plot->title.'户型_'.$plot->title.'电话_'.$plot->title.'环境_'.$plot->title.'图片-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();

        //微信分享设置
        $this->controller->wxshareImg = $plot->image ? ImageTools::fixImage($plot->image) : '';
        $this->controller->wxShareTitle = $this->controller->pageTitle;
        if($plot->data_conf['seo_description']){
            $this->controller->pageDescription = str_replace("\"","'",$plot->data_conf['content']);
        }else {
            $this->controller->pageDescription = SM::GlobalConfig()->siteName().'房产网提供'.$plot->title.'售楼电话（'.$plot->sale_tel.')、最新房价、地址、交通和周边配套、开盘动态、户型图、实景图等楼盘信息。';
        }

        if($plot->red){
            $data['redCount'] = OrderExt::model()->count(array(
                'condition' => 'spm_b=:type and spm_c =:redId',
                'params' => array(':type' => OrderExt::$type['PlotRedExt'][0],':redId'=>$plot->red->id)));
        }
        $this->controller->render('index', $data);
    }
}
