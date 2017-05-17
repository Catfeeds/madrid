<?php
/**
 * 出租住宅配套
 *
 */
class TagPtWidget extends CWidget{
    public $cate;
    public $id;
    public $get;//保留之前的get
    public $url;
    public function run(){
        //  <ul>
        //       <li><label><input type="checkbox" name="peitao">拎包入住</label></li>
        //       <li><label><input type="checkbox" name="peitao">家电齐全</label></li>
        //       <li><label><input type="checkbox" name="peitao">可上网</label></li>
        //       <li><label><input type="checkbox" name="peitao">可做饭</label></li>
        //       <li><label><input type="checkbox" name="peitao">可洗澡</label></li>
        //       <li><label><input type="checkbox" name="peitao">空调房</label></li>
        //       <li><label><input type="checkbox" name="peitao">可看电视</label></li>
        //       <li><label><input type="checkbox" name="peitao">有暖气</label></li>
        //       <li><label><input type="checkbox" name="peitao">有车位</label></li>
        //   </ul>
        $allowCate = ['zfzzpt','esfzzpt','esfsppt','esfxzlpt','zfsppt','zfxzlpt'];
        if(!in_array($this->cate,$allowCate)){
            throw new CHttpException(404,'分类不存在');
        }
        //获取分类数据
        $tagName = TagExt::model()->findAll(['condition'=>'cate=:cate','params'=>[':cate'=>$this->cate]]);
        $html = Chtml::tag('ul');
        $checked = '';
        foreach($tagName as $k=>$v){
            if(is_array($this->id)){
                if(in_array($v->id,$this->id)){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
            }

            $html.= '<li><label><input type="checkbox" name="'.$this->cate.'[]" '.$checked.' value="'.$v->id.'">'.$v->name.'</label></li>';
        }
        $html .= Chtml::closeTag('ul');
        echo $html;


    }
}
