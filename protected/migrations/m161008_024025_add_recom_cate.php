<?php

class m161008_024025_add_recom_cate extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$jchd=[
			'name' => '精彩活动',
			'pinyin' => 'syjchd',
			'status' => 1
		];
		if($parent = RecomCateExt::model()->find('pinyin=:py',[':py'=>'sy'])) {
			$model = new RecomCateExt;
			$model->attributes = $jchd;
			$model->parent = $parent->id;
			if(!$model->save()) {
				throw new Exception($jchd['pinyin'].'保存失败');
			}
		}
	}

	public function safeDown()
	{
		return false;
	}
}