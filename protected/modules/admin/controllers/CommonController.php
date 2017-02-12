<?php
/**
 * common控制器
 * 后台首页、登录、退出、报错页
 * @author weibaqiu
 * @date 2015-09-07
 */
class CommonController extends AdminController
{
    public function actionIndex()
    {
        // 二手房管理人员跳转二手房首页
        $user = AdminExt::model()->find(['condition'=>'username=:username','params'=>[':username'=>Yii::app()->user->getName()]]);
        if($user->group->chinese == '管理二手房')
            $this->redirect('/admin/common/esfIndex');

        $year = date('Y',strtotime('-1 month'));
        $month = date('m',strtotime('-1 month'));
        $price = PlotPricetrendExt::model()->find(array(
            'condition' => 'year=:year and month=:month',
            'params' => array(':year'=>$year,':month'=>$month)
        ));
        $plotNum = PlotExt::model()->normal()->isNew()->count();
        $userNum = OrderExt::model()->today()->count();
        //统计表
        $beginTime = strtotime('-7 days');
        $endTime = time();
        $ddltj = OrderExt::model()->getByTimeRange($beginTime, $endTime)->findAll(array(
            'select' => 'count(id) as count, created_ymd,created',
            'order' => 'created_ymd asc',
            'group' => 'created_ymd',
        ));
        $chart['series'] = $chart['xAxis'] = array();
        foreach($ddltj as $v)
        {
            $chart['series'][] = (int)$v->count;
            $chart['xAxis'][] = date('m-d', $v->created);
        }
        //问题
        $question = AskExt::model()->normal()->noReply()->findAll(['limit'=>8,'order'=>'created desc']);

        //**************买房顾问统计*****************
        $chartData = array();
        //成交率，本月分配且已成交人数/本月分配人数
        $fenpeirenshu = UserExt::model()->count(array(
            'condition' => 'new_order>='.TimeTools::getMonthBeginTime().' and assign_time>='.TimeTools::getMonthBeginTime(),
        ));
        $chengjiaorenshu = UserExt::model()->chengjiao()->count(array(
            'condition' => 'assign_time>='.TimeTools::getMonthBeginTime()
        ));
        $chartData['chengjiaolv'] = $fenpeirenshu ? round(100*$chengjiaorenshu/$fenpeirenshu) : 0;
        //带看率，本月分配且带看人数/本月分配人数
        $daikanrenshu = UserExt::model()->daikan()->count(array(
            'condition' => 'assign_time>='.TimeTools::getMonthBeginTime(),
        ));
        $chartData['daikanlv'] = $fenpeirenshu ? round(100*$daikanrenshu/$fenpeirenshu) : 0;
        //分配率，分配的也必须是当月提交用户，否则会出现超100%数据
        $jikerenshu = UserExt::model()->count(array(
            'condition' => 'new_order>='.TimeTools::getMonthBeginTime(),
        ));
        $chartData['fenpeilv'] = $jikerenshu ? round(100*$fenpeirenshu/$jikerenshu) : 0;

        //获取升级公告
        $announcement = HttpHelper::get("http://www.hangjiayun.com/api/record?product=fcdsj&page=1&limit=1");
        $ann = array();
        if($announcement['code']=='200'){
            $ann_content = json_decode($announcement['content']);
            $ann_data = $ann_content->data;
            if($ann_data){
                foreach ($ann_data as $key => $value) {
                    $ann[] = $value->title.$value->content;
                }
            }
        }

        $this->render('index', array(
            'price' => $price,
            'plotNum' => $plotNum,
            'userNum' => $userNum,
            'chart' => $chart,
            'announcement'=>$ann,
            'question' => $question,
            'chartData' => $chartData,
        ));
    }

    /**
     * 后台登陆
     */
    public function actionLogin()
    {
        $this->layout = false;
        if( !Yii::app()->user->isGuest )
            $this->redirect(array('/admin/common/index'));

        $model = new AdminLoginForm;
        if( Yii::app()->request->isPostRequest )
        {
            $model->username = Yii::app()->request->getPost('username', '');
            $model->password = Yii::app()->request->getPost('password', '');
            $model->rememberMe = Yii::app()->request->getPost('rememberMe', 0);
            if( $model->validate() && $model->login() )
                $this->redirect(array('/admin/common/index'));
        }
        $this->render('login', array(
            'model' => $model,
        ));
    }

    public function actionOpenDoc()
    {
        $this->render('opendoc');
    }

    /**
     * 退出登录
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('/admin/common/login'));
    }

    /**
     * 房产v2升级
     * 2016年8月23日全部升级完成，该方法禁止走入，但代码别删除，方便下次升级参考
     */
    public function actionUpgrade($process=0,$token='')
    {
        die;
        if($this->getIsLatest() || !Yii::app()->user->checkAccess('admin')){
            $this->redirect(['index']);
            Yii::app()->end();
        }

        if(time()-$process<30 && $token==md5('123')){
            $this->layout = false;
            set_time_limit(0);
            Yii::app()->clientScript->registerScript('iframePd',"if (self != top) {location.href='about:blank'}",CClientScript::POS_HEAD);
            Yii::import('application.commands.V2');
            $v2 = new V2;
            $v2->process();
            Yii::app()->end();
        }

        $pwRight = false;
        if(Yii::app()->request->isPostRequest) {
            $pw = Yii::app()->request->getPost('pw');
            $admin = AdminExt::model()->findByPk(Yii::app()->user->id);
            if($admin && md5($pw)==$admin->password) {
                $pwRight = true;
            } else {
                $this->setMessage('密码错误，请重新尝试','error');
            }
        }
        $this->render('upgrade', [
            'pwRight' => $pwRight,
        ]);
    }

    public function actionLog()
    {
        $content = file_get_contents(Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'v2upgrade.log');
        echo nl2br($content);
    }

    /**
     * [actionEsfIndex 二手房首页]
     * @return [type] [description]
     */
    public function actionEsfIndex()
    {
        $data = [];
        $data['newEsfs'] = ResoldEsfExt::model()->undeleted()->count([
            'condition'=>'created>=:start and created<=:end',
            'params'=>[':start'=>TimeTools::getDayBeginTime(),':end'=>TimeTools::getDayEndTime()]
            ]);
        $data['totalEsfs'] = ResoldEsfExt::model()->undeleted()->count();

        $data['newZfs'] = ResoldZfExt::model()->undeleted()->count([
            'condition'=>'created>=:start and created<=:end',
            'params'=>[':start'=>TimeTools::getDayBeginTime(),':end'=>TimeTools::getDayEndTime()]
            ]);
        $data['totalZfs'] = ResoldZfExt::model()->undeleted()->count();

        $data['newZfs'] = ResoldZfExt::model()->undeleted()->count([
            'condition'=>'created>=:start and created<=:end',
            'params'=>[':start'=>TimeTools::getDayBeginTime(),':end'=>TimeTools::getDayEndTime()]
            ]);
        $data['totalZfs'] = ResoldZfExt::model()->undeleted()->count();

        $data['newQgs'] = ResoldQgExt::model()->undeleted()->count([
            'condition'=>'created>=:start and created<=:end',
            'params'=>[':start'=>TimeTools::getDayBeginTime(),':end'=>TimeTools::getDayEndTime()]
            ]);
        $data['totalQgs'] = ResoldQgExt::model()->undeleted()->count();

        $data['newQzs'] = ResoldQzExt::model()->undeleted()->count([
            'condition'=>'created>=:start and created<=:end',
            'params'=>[':start'=>TimeTools::getDayBeginTime(),':end'=>TimeTools::getDayEndTime()]
            ]);
        $data['totalQzs'] = ResoldQzExt::model()->undeleted()->count();

        $data['newPackages'] = ResoldStaffPackageExt::model()->count([
            'condition'=>'created>=:start and created<=:end',
            'params'=>[':start'=>TimeTools::getDayBeginTime(),':end'=>TimeTools::getDayEndTime()]
            ]);
        $data['totalPackages'] = ResoldStaffPackageExt::model()->count();

        $data['checkEsfs'] = Yii::app()->db->createCommand('select * from resold_esf where status=2 and deleted=0 order by created desc limit 5')->queryAll();

        $data['checkZfs'] = Yii::app()->db->createCommand('select * from resold_zf where status=2 and deleted=0 order by created desc limit 5')->queryAll();

        // $data['checkEsfs'] = ResoldEsfExt::model()->undeleted()->findAll([
        //     'condition'=>'status=2','order'=>'created desc','limit'=>5
        //     ]);

        // $data['checkZfs'] = ResoldZfExt::model()->undeleted()->findAll([
        //     'condition'=>'status=2','order'=>'created desc','limit'=>5
        //     ]);

        $data['reports'] = ResoldReportExt::model()->findAll([
            'condition'=>'deal=0','order'=>'created desc','limit'=>5
            ]);

        $data['reports'] = ResoldReportExt::model()->findAll([
            'condition'=>'deal=0','order'=>'created desc','limit'=>5
            ]);

        $data['staffPackages'] = ResoldStaffPackageExt::model()->findAll([
            'condition'=>'expire_time<:end and expire_time>=:start','order'=>'created desc','limit'=>5,
            'params'=>[':end'=>(TimeTools::getDayEndTime() + 30*86400),':start'=>TimeTools::getDayBeginTime()]
            ]);

        $data['totalCheckEsfs'] = Yii::app()->db->createCommand('select count(id) from resold_esf where deleted=0 and status=2')->queryScalar();

        $data['totalCheckZfs'] = Yii::app()->db->createCommand('select count(id) from resold_zf where deleted=0 and status=2')->queryScalar();

        $data['totalReports'] = ResoldReportExt::model()->count([
            'condition'=>'deal=0'
            ]);

        $data['totalStaffPackages'] = ResoldStaffPackageExt::model()->count([
            'condition'=>'expire_time<:end and expire_time>=:start',
            'params'=>[':end'=>(TimeTools::getDayEndTime() + 30*86400),':start'=>TimeTools::getDayBeginTime()]
            ]);

        //价格走势 往前12个月的价格趋势
        $now = date('Y-m',time());
        $nowYear = substr($now, 0,4);
        $nowMonth = substr($now, -2);
        $type = Yii::app()->request->getQuery('type',0);

        $thisYearPriceTrend = ResoldPricetrendExt::model()->findAll(array(
                    'condition'=>'year=:year and month<:month',
                    'params'=>[':year'=>$nowYear,':month'=>$nowMonth],
                    'order'=>'month asc'
                ));
        $lastYearPriceTrend = ResoldPricetrendExt::model()->findAll(array(
                    'condition'=>'year=:year and month>=:month',
                    'params'=>[':year'=>$nowYear-1,':month'=>$nowMonth],
                    'order'=>'month asc'
                ));
        $priceTrends = array_merge($lastYearPriceTrend,$thisYearPriceTrend);

        $data['chart'] = $data['chart']['series'] = $data['chart']['xAxis'] = array();
        $data['chart']['area'] = AreaExt::model()->findByPk($type);
        foreach($priceTrends as $v)
        {
            $price = $v->data;
            $data['chart']['series'][] = (int)$price[$type];
            $data['chart']['xAxis'][] = $v['year'].'-'.$v['month'];
        }
        $data['chart']['average'] = $priceTrends ? array_sum($data['chart']['series'])/count($data['chart']['series']) : 0;
        $data['chart']['max'] = $priceTrends ? max($data['chart']['series']) : 0;
        $data['chart']['min'] = $priceTrends ? min($data['chart']['series']) : 0;

        $this->render('esfIndex',$data);
    }

    public function actionTest()
    {
        
        $this->layout = '/layouts/modal_base';
        $this->render('test');
    }
}
?>
