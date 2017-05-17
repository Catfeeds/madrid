<?php
/**
 * 二手房配置地图
 * @author steven.allen <[<email address>]>
 * @date(2016.11.28)
 */
class MapAction extends CAction
{
	public function run($search='')
	{
		$map = [];
        $allConfig = SM::getAll(1);
        if($search) {
            foreach($allConfig as $model) {
                foreach($model->attributes as $pinyin => $attribute) {
                    if(strpos($model->attributeLabels()[$pinyin], $search)!==false || strpos($attribute->description, $search)!==false) {
                        $map[$model->getClassName()] = $model;
                    }
                }
            }
        } else {
            $map = $allConfig;
        }

        $this->controller->render('/resoldSiteConfig/sitesettingmap', ['map'=>$map, 'search'=>$search]);
	}
}