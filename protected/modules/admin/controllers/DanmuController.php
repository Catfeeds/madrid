<?php
/**
 * A站弹幕抓取
 * @author tivon 2017.4.15
 */
class DanmuController extends AdminController {

	public function actionIndex()
	{
		$urls = Yii::app()->request->getQuery('urls','');
		if(trim($urls)) {
			$urlArr = explode(' ', $urls);
			$urlArr = array_filter($urlArr);
			if($urlArr)
				foreach ($urlArr as $key => $value) {
					$this->fetch($value);
				}
		}
		// $this->setMessage('抓取成功');
		$this->render('index');
	}

	public function actionList($kw='')
	{
		$criteria = new CDbCriteria;
		$kw && $criteria->addSearchCondition('name',$kw);
		$ms = MovieExt::model()->sorted()->undeleted()->getList($criteria);
		$this->render('list',['infos'=>$ms->data,'pager'=>$ms->pagination,'kw'=>$kw]);
	}

	public function fetch($url='')
	{
		$res = HttpHelper::get($url);
		$totalHtml = $res['content'];
		if(!$totalHtml) {
			$this->setMessage('不存在');
			return false;
		}
		$movie = new MovieExt;
		$movie->url = $url;
		// videoId
		preg_match_all('/videoId":[0-9]+/', $totalHtml, $ids);
		if(isset($ids[0][0]) && $ids = $ids[0][0]) {
			$id = str_replace('videoId":', '', $ids);
		}
		preg_match_all('/title":".+","duration/', $totalHtml, $ids);
		if(isset($ids[0][0]) && $ids = $ids[0][0]) {
			$name = str_replace('title":"', '', $ids);
			$name = str_replace('","duration', '', $name);
			// var_dump($name);exit;
			$movie->name = $name;
		}
		$movie->save();
		$danmuurl = "http://danmu.aixifan.com/V4/{$id}_2/4073558400000/1000?order=-1";
		$res = HttpHelper::get($danmuurl);
		$totalHtml = $res['content'];
		if($totalHtml){
			// var_dump($totalHtml);exit;
			$arrs = json_decode($totalHtml,true);
			if($arrs[2]) {
				foreach ($arrs[2] as $key => $value) {
					$danmu = new DanmuExt;
					$danmu->mid = $movie->id;
					$ta = explode(',', $value['c']);
					$danmu->time = $ta[5];
					$danmu->content = trim($value['m']);
					$danmu->save();
				}
			}
		}
		$this->setMessage('抓取成功');
	}

	public function actionToExcel($id='')
	{
		if(!$id) {
			$this->setMessage('wrong','error');
			return;
		}
		$criteria = new CDbCriteria;
		$criteria->addCondition('mid='.$id);

		$this->exportExcel($criteria);
		$this->setMessage('操作成功');
	}

	public function actionDel($id='')
	{
		$mv = MovieExt::model()->findByPk($id);
		$mv->deleted = 1;
		$mv->save();
		$this->setMessage('操作成功');
	}

	/**
     * 导出excel文件
     * @param  CDbCriteria $criteria 查询条件对象
     */
    private function exportExcel(CDbCriteria $criteria)
    {
        set_time_limit(0);
        $criteria->select = 'time,content';
        $criteria->limit = 5000;//限制最多3000
        $data = DanmuExt::model()->sorted()->findAll($criteria);
        //excel列名
        $fileds = array('时间','内容');
        $content = array();
        foreach($data as $order)
        {
            $content[] = array(date('Y-m-d H:i:s',$order['time']),$order['content']);
        }
        unset($data);
        ExcelHelper::write_browser(date('YmdHis'),$fileds,$content);
        Yii::app()->end();
    }
}