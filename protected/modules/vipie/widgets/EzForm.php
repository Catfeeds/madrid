<?php


class EzForm extends CActiveForm{

    public function init()
    {
        $this->htmlOptions['class'] = 'valid-form';
        parent::init();
    }

    public function radioBoxList($model,$attribute,$data,$htmlOptions=array()){
       $name = CHtml::activeName($model, $attribute);
       if(!isset($htmlOptions['type']) || !in_array($htmlOptions['type'],['radio','checkbox'])){
           throw new CException('not define type or uncorrect type');
       }
        $type = $htmlOptions['type'];
        unset($htmlOptions['type']);
        $values = CHtml::resolveValue($model, $attribute);
       echo sprintf($this->outer($htmlOptions),$this->inside($name, $data, $type , $values));
    }

    protected function outer($htmlOptions){
        return CHtml::openTag('ul',$htmlOptions).'%s'.CHtml::closeTag('ul');
    }

    protected function inside($name,$data,$type,$select){
        $s = '';
        foreach ($data as $key=>$value){
            $checked=!is_array($select) && !strcmp($key,$select) || is_array($select) && in_array($key,$select);
            $checked=$checked ? 'checked="checked"' : '';
            $tempName = $type == 'checkbox' ? $name.'[]': $name.'';
            $s .= '<li><label><input type="'.$type.'" name="'.$tempName.'" value="'.$key.'" '.$checked.'/>'.$value.'</label></li>';
        }
        return $s;
    }
}
