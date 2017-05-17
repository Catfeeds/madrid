<?php

class m161021_040113_add_recom_cate extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$zxtj=[
			'name' => 'wap首页资讯推荐',
			'pinyin' => 'wapsyzxtj',
			'status' => 1
		];
		if($parent = RecomCateExt::model()->find('pinyin=:py',[':py'=>'wapsy'])) {
			$model = new RecomCateExt;
			$model->attributes = $zxtj;
			$model->parent = $parent->id;
			if(!$model->save()) {
				throw new Exception($zxtj['pinyin'].'保存失败');
			}
		}
	}

	public function safeDown()
	{
		return false;
	}
}