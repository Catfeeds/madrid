<?php
/**
 * WapLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class WapLinkPager extends CLinkPager
{
    /**
     * Initializes the pager by setting some default property values.
     */
    public function init()
    {
        parent::init();
        $this->prevPageLabel='上一页';
        $this->previousPageCssClass="pagination_button previous";
        $this->nextPageLabel='下一页';
        $this->nextPageCssClass="pagination_button next";
        $this->selectedPageCssClass="active";
        $this->hiddenPageCssClass="ui-pager-disabled";
        $this->htmlOptions=array('class'=>'ui-pager gw');
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $this->registerClientScript();
        $buttons=$this->createPageButtons();
        if(empty($buttons))
            return;
        echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
        echo $this->footer;
    }

    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageButtons()
    {
        if(($pageCount=$this->getPageCount())<=1)
            return array();

        list($beginPage,$endPage)=$this->getPageRange();
        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons=array();

        // prev page
        if ($this->prevPageLabel !== false) {
            if(($page=$currentPage-1)<0)
                $page=0;
            $buttons[]=$this->createPageButton($this->prevPageLabel,$page,'',$currentPage<=0,false);
        }

        // count pages
//        $buttons[] = '<span>'.($currentPage+1).'/'.$this->getPageCount().'</span>';
        $buttons[]='<form action><input type="text" name="page" placeholder="'.($currentPage+1).'/'.$this->getPageCount().'" class="text"></form>';

        // next page
        if ($this->nextPageLabel !== false) {
            if(($page=$currentPage+1)>=$pageCount-1)
                $page=$pageCount-1;
            $buttons[]=$this->createPageButton($this->nextPageLabel,$page,'',$currentPage>=$pageCount-1,false);
        }


        return $buttons;
    }

    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if($hidden || $selected)
            $class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        return CHtml::link($label,$this->createPageUrl($page),array('class'=>$class));
    }

}
