<?php
/**
 * @author weibaqiu
 * @date 2015-10-19
 */
class RestController extends Controller
{
	public $layout = 'rest.views.layouts.main';

    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    /**
     * 访问控制器过滤器
     */
    public function filterAccessControl($filterChain)
    {
        header('content-type:application/json;charset=utf8');
        $token = Yii::app()->request->getParam('token');
        if(!Yii::app()->request->isPostRequest && $token!=md5(SM::urmConfig()->siteID()))
            throw new CHttpException(401, 'token is invalid');
        else
            $filterChain->run();
    }

    /**
     * 渲染json输出格式
     * @param  integer $count 总记录数
     * @param  array  $data  数据
     * @return json
     */
    public function renderJson($count, array $data)
    {
        foreach($data as $k=>$v)
        {
            if($v instanceof CActiveRecord)
                $data[$k] = $v->getAttributes();
        }

        $jsonTemplate = array(
            'count' => $count,
            'data' => $data,
        );
        return CJSON::encode($jsonTemplate);
    }



    /**
     * 过滤不需要的字段
     * @param  CActiveRecord $model 要获取属性的AR对象
     * @param  array $attributes 想要返回的属性列表
     * @return [type]               [description]
     */
    public function _filterAttribute(CActiveRecord $model, $attributes=array())
    {
        $criteria = $model->getDbCriteria();
        $data = $attributes ? $model->getAttributes($attributes) : $model->getAttributes(null);
        foreach($data as $k=>$v)
        {
            if($v===null) unset($data[$k]);
            // if($attributes!==array() && !in_array($k, $attributes)) unset($data[$k]);
        }
        return $data;
    }
}
