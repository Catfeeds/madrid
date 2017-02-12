<?php

class m160727_093452_add_recom_cate extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$arr = [
			'syzxmk2ycdtw' => [
				'name' => '更多链接',
				'pinyin' => 'syzxmk2ycdtwmore',
				'status' => 1,
			],
			'syzxmk2zjtwlb' => [
				'name' => '更多链接',
				'pinyin' => 'syzxmk2zjtwlbmore',
				'status' => 1,
			],
			'syzxmk2zcwzlb' => [
				'name' => '更多链接',
				'pinyin' => 'syzxmk2zcwzlbmore',
				'status' => 1,
			],
		];
		foreach($arr as $ppy => $v) {
			if($parent = RecomCateExt::model()->find('pinyin=:py',[':py'=>$ppy])) {
				$model = new RecomCateExt;
				$model->attributes = $v;
				$model->parent = $parent->id;
				if(!$model->save()) {
					throw new Exception($v['pinyin'].'保存失败');
				}
			}
		}
	}

	public function safeDown()
	{
		return false;
	}
}
