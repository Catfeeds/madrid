<?php
/**
 * 楼盘评测ajax渲染页面元素
 * @author webaqiu
 * @version 2016-05-31
 */
class ItemAction extends CAction
{
    /**
     * 处理评测元素中的每个段落
     * @param  integer $id    评测数据的主键id
     * @param  integer $index 评测字段中的元素顺序index
     */
    public function run($id=0,$field,$index)
    {
        $model = PlotEvaluateExt::model()->findByPk($id);
        if(!$model){
            $model = new PlotEvaluateExt;
        }
        $this->controller->layout = false;
        $this->controller->render('evaluate/_item', array(
            'model' => $model,
            'field' => $field,
            'index' => $index,
        ));
    }
}
