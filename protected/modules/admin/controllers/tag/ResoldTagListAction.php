<?php
class ResoldTagListAction extends CAction
{
    public function run()
    {
    	$data = TagExt::model()->findAll(array(
            'order' => 'sort asc'
        ));
        $list = array();
        foreach ($data as $v) {
            $list[$v->cate][] = $v;
        }
        asort($list);
        // 通用标签
        $commonArr = ['resoldface','resoldzx','esffloorcate','resoldhuxing','resoldage','resoldfloor','plotprice'];
        // 住宅标签
        $zzArr = [
            'direct'=>['esfzfzztype','esfzzts','zfzzts','esfzzpt','zfzzpt','zfmode',],
            'between'=>['esfzzprice','zfzzprice','esfzzsize','qgzzqwlc','qgzzqwfl',],
            ];
        // 商铺标签
        $spArr = [  
            'direct'=>['esfzfsptype','esfspts','zfspts','esfsppt','zfsppt','esfspkjyxm','zfspkjyxm','esfsplevel'],
            'between'=>['esfspprice','zfspprice','esfspsize'],
            ];
        // 写字楼标签
        $xzlArr = [
            'direct'=>['esfzfxzltype','esfxzlts','zfxzlts','esfxzlpt','zfxzlpt','esfxzllevel','zfxzllevel'],
            'between'=>['esfxzlprice','zfxzlprice','esfxzlsize'],
            ];

        $this->controller->render('resoldTagList', array(
            'list' => $list,
            'commonArr'=>$commonArr,
            'zzArr'=>$zzArr,
            'spArr'=>$spArr,
            'xzlArr'=>$xzlArr,
        ));
    }
}
