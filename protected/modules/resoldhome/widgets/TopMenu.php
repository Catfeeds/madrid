<?php
/**
 * 顶部菜单按钮
 * User: jt
 * Date: 2016/11/11 15:43
 */
Yii::import('zii.widgets.CMenu');
class TopMenu extends CMenu{

    public $a_activeCssClass = 'on';

    public $activeCssClass='current';

    public $itemCssClass = 'sub-nav';

    public $linkOptionsCssClass = 'cbox';

    public function init()
    {
        $this->items = $this->owner->menu;
        if(!isset($this->submenuHtmlOptions['class'])){
            $this->submenuHtmlOptions['class']  = 'lis';

        }
        if(!isset($this->htmlOptions['class'])){
            $this->htmlOptions['class'] = 'clearfix';
        }
        parent::init();
    }

    public function run()
    {
        $this->renderMenu($this->items);
    }

    protected function renderMenuRecursive($items)
    {
        $count=0;
        $n=count($items);
        foreach($items as $item)
        {
            $count++;
            $options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
            $class=array();
            if($count===1 && $this->firstItemCssClass!==null)
                $class[]=$this->firstItemCssClass;
            if($count===$n && $this->lastItemCssClass!==null)
                $class[]=$this->lastItemCssClass;
            if($this->itemCssClass!==null && isset($item['items']))
                $class[]=$this->itemCssClass;
            if($class!==array())
            {
                if(empty($options['class']))
                    $options['class']=implode(' ',$class);
                else
                    $options['class'].=' '.implode(' ',$class);
            }

            echo CHtml::openTag('li', $options);

            $itemCssClass = '';
            if(isset($item['items']) && count($item['items']))
                $itemCssClass  .= $this->linkOptionsCssClass.' ';
            if(isset($item['active']) && $item['active'])
                $itemCssClass .= $this->a_activeCssClass;
            $item['linkOptions']['class'] = $itemCssClass;
            $menu=$this->renderMenuItem($item);
            if(isset($this->itemTemplate) || isset($item['template']))
            {
                $template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
                echo strtr($template,array('{menu}'=>$menu));
            }
            else
                echo $menu;

            if(isset($item['items']) && count($item['items']))
            {
                echo "\n".CHtml::openTag('ol',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
                $this->renderMenuRecursive($item['items']);
                echo CHtml::closeTag('ol')."\n";
            }

            echo CHtml::closeTag('li')."\n";
        }
    }
}
