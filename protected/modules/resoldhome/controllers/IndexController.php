<?php
/**
 *
 * User: jt
 * Date: 2016/10/31 9:17
 */

class IndexController extends ResoldHomeController{

    public function actionIndex(){
    	// 搜索推荐
    	// $recomcate = new ResoldRecomCateExt;
    	// ResoldRecomCateExt::cate = 'pcsyss';
    	$searchRecoms = ResoldRecomCateExt::getAllRecomByCate('pcsyss');
    	// 经纪人推荐
    	$staffRecoms = ResoldRecomCateExt::getAllRecomByCate('pcsyjpjjr',10);
    	// 资讯推荐
    	$newsRecoms = ResoldRecomCateExt::getAllRecomByCate('pcsyzx',15);
    	// 精品二手房
        // 
            //     if($value)
            //     {
            //         foreach ($value as $k => $v) {
            //             $esfRecomIds[] = $v->fid;
            //         }
            //     }
                
            // }
            // $criteria = new CDbCriteria;
            // $criteria->addInCondition('id',$ids);
            // $recomesfs = ResoldEsfExt::model()->findAll($criteria);

    	$esfRecom = ResoldRecomCateExt::getAllRecomByCate('pcsyesf',4);
    	$esfRecoms = $esfRecomIds = $zfRecomIds = [];
    	if($esfRecom)
    	{
    		foreach ($esfRecom as $key => $value) {
                $esfIds = [];
                if($value)
                {
                    foreach ($value as $k => $v) {
                        // $esfIds[] = $v->fid;
                        $esfRecoms[$key][$v->fid] = ['image'=>$v->image,'title'=>$v->title,'config'=>$v->config];
                    }
                } 
                if(!isset($esfRecoms[$key])) 
                    continue;
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id',array_keys($esfRecoms[$key]));
                $recomesfs = ResoldEsfExt::model()->findAll($criteria);
                if($recomesfs)
                    foreach ($recomesfs as $c => $e) {
                        $e && $esfRecoms[$key][$e->id] = array_merge($esfRecoms[$key][$e->id],['info'=>$e]);
                    }
                foreach ($esfRecoms[$key] as $k1 => $value) {
                    if(!isset($esfRecoms[$key]))
                        unset($esfRecoms[$key][$k1]);
                }

            }

    	}
        // var_dump($esfRecoms);exit;
    	// 精品租房
    	$zfRecom = ResoldRecomCateExt::getAllRecomByCate('pcsyzf',4);
    	$zfRecoms = [];
    	if($zfRecom)
    	{
    		foreach ($zfRecom as $key => $value) {
                $zfIds = [];
                if($value)
                {
                    foreach ($value as $k => $v) {
                        // $esfIds[] = $v->fid;
                        $zfRecoms[$key][$v->fid] = ['image'=>$v->image,'title'=>$v->title,'config'=>$v->config];
                    }
                }  
                if(!isset($zfRecoms[$key])) 
                    continue;
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id',array_keys($zfRecoms[$key]));
                $recomzfs = ResoldZfExt::model()->findAll($criteria);
                if($recomzfs)
                    foreach ($recomzfs as $c => $e) {
                        $e && $zfRecoms[$key][$e->id] = array_merge($zfRecoms[$key][$e->id],['info'=>$e]);
                    }
                foreach ($zfRecoms[$key] as $k1 => $value) {
                    if(!isset($zfRecoms[$key]))
                        unset($zfRecoms[$key][$k1]);
                }

            }
    	}
    	// 8个最新二手房/租房
    	// $esfs = ResoldEsfExt::model()->saling()->undeleted()->findAll(['condition'=>'category=1','order'=>'refresh_time desc,sort desc','limit'=>8]);
    	// $zfs = ResoldZfExt::model()->saling()->findAll(['condition'=>'category=1','order'=>'refresh_time desc,sort desc','limit'=>8]);
        $esfs = $zfs = $esfXs = $zfXs = $esfPlots = $zfPlots = $esfStreets = $zfStreets = [];
        $xs =  Yii::app()->search->house_esf;
        $xs->setQuery('');
        $xs->addRange('sale_status',1,1);
        $xs->addRange('status',1,1);
        $xs->addRange('deleted',0,0);
        $xs->addRange('category',1,1);
        
        $xs->setLimit(8);
        $xs->setMultiSort(['refresh_time'=>false]);
        
        $esfXs = $xs->search();
        if($esfXs)
            foreach ($esfXs as $key => $value) {
                $esfs[] = ResoldEsfExt::model()->findByPk($value->id);
            }
        $xs =  Yii::app()->search->house_zf;
        $xs->setQuery('');
        $xs->addRange('sale_status',1,1);
        $xs->addRange('status',1,1);
        $xs->addRange('deleted',0,0);
        $xs->addRange('category',1,1);
        
        $xs->setLimit(8);
        $xs->setMultiSort(['refresh_time'=>false]);
        
        $zfXs = $xs->search();
        if($zfXs)
            foreach ($zfXs as $key => $value) {
                $zfs[] = ResoldZfExt::model()->findByPk($value->id);
            }
    	// 二手房-热门小区
        $xs = Yii::app()->search->house_plot;
		$xs->setQuery('');
        // $xs->addRange('sale_status',2,2);
		$xs->addRange('status',1,1);
		$xs->addRange('deleted',0,0);
		$xs->setMultiSort(['esf_num'=>false,'recommend'=>false,'sort'=>false]);
		$xs->setLimit(12,0);
		$esfPlots = $xs->search();

		// 租房-热门小区
		// $xs = Yii::app()->search->house_plot;
		// $xs->setQuery('');
        // $xs->addRange('sale_status',2,2);
		$xs->addRange('status',1,1);
		$xs->addRange('deleted',0,0);
		$xs->setMultiSort(['zf_num'=>false,'recommend'=>false,'sort'=>false]);
		$xs->setLimit(12,0);
		$zfPlots = $xs->search();

		// 二手房-热门街区
        $transEsfStreets = $transZfStreets = [];
        $allAreas = AreaExt::getAllarea();
        $allStreets = AreaExt::getAllstreet();
        if($allStreets) {
            foreach ($allStreets as $key => $value) {
                foreach ($value as $k => $v) {
                    if(isset($k) && $k && isset($allAreas[$key]))
                        $allstreets[$k] = ['name'=>$v,'area'=>$allAreas[$key]];
                }
            }
        } 
        
        $xs = Yii::app()->search->house_esf;
        $xs->setQuery('');
        $xs->setFacets(['street'],true);
        $xs->addRange('status',1,1);
        $xs->addRange('sale_status',1,1);
        $xs->addRange('category',1,1);
        $xs->addRange('deleted',0,0);
        $xs->addRange('expire_time',time(),null);
        $xs->setLimit(100,0);
        $docs = $xs->search();
        $streetEsfs = $xs->getFacets('street');
        if(isset($streetEsfs)) {
            arsort($streetEsfs); 
            foreach ($streetEsfs as $key => $value) {
                $key && $transEsfStreets[] = ['id'=>$key,'name'=>$allstreets[$key]['name'],'area'=>$allstreets[$key]['area'],'num'=>$value];
                if(count($transEsfStreets) >= 12)
                    break;
            }
        }

        $xs = Yii::app()->search->house_zf;
        $xs->setQuery('');
        $xs->setFacets(['street'],true);
        $xs->addRange('status',1,1);
        $xs->addRange('sale_status',1,1);
        $xs->addRange('category',1,1);
        $xs->addRange('deleted',0,0);
        $xs->addRange('expire_time',time(),null);
        $xs->setLimit(100,0);
        $docs = $xs->search();
        $streetEsfs = $xs->getFacets('street');
        if(isset($streetEsfs)) {
            arsort($streetEsfs); 
            foreach ($streetEsfs as $key => $value) {
                $key && $transZfStreets[] = ['id'=>$key,'name'=>$allstreets[$key]['name'],'area'=>$allstreets[$key]['area'],'num'=>$value];
                if(count($transZfStreets) >= 12)
                    break;
            }
        }
		// 品牌中介
		$shopRecoms = ResoldRecomCateExt::getAllRecomByCate('pcsyppzj',16);
    	// var_dump($zfPlots);exit;
        $this->render('index',[
        	'searchRecoms'=>$searchRecoms,
			'staffRecoms'=>$staffRecoms,
			'newsRecoms'=>$newsRecoms,
			'esfRecoms'=>$esfRecoms,
			'zfRecoms'=>$zfRecoms,
			'esfs'=>$esfs,
			'zfs'=>$zfs,
			'esfPlots'=>$esfPlots,
			'zfPlots'=>$zfPlots,
			'esfStreets'=>$transEsfStreets,
			'zfStreets'=>$transZfStreets,
			'shopRecoms'=>$shopRecoms,
        	]);
    }
}
