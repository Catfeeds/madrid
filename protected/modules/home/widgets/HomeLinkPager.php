<?php
/**
 * 前台home模块所用的分页类，继承CLinkPager
 * @author weibaqiu
 * @date 2015-05-28
 */
class HomeLinkPager extends CLinkPager
{
	const CSS_FIRST_PAGE='first';
	const CSS_LAST_PAGE='last';
	const CSS_PREVIOUS_PAGE='pre-page';
	const CSS_NEXT_PAGE='next-page';
	const CSS_INTERNAL_PAGE=NULL;
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='currents';

	private $request_uri = '';

	/**
	 * @var string the CSS class for the previous page button. Defaults to 'previous'.
	 * @since 1.1.11
	 */
	public $previousPageCssClass=self::CSS_PREVIOUS_PAGE;
	/**
	 * @var string the CSS class for the next page button. Defaults to 'next'.
	 * @since 1.1.11
	 */
	public $nextPageCssClass=self::CSS_NEXT_PAGE;
	/**
	 * @var string the CSS class for the internal page buttons. Defaults to 'page'.
	 * @since 1.1.11
	 */
	public $internalPageCssClass=self::CSS_INTERNAL_PAGE;
	/**
	 * @var string the CSS class for the hidden page buttons. Defaults to 'hidden'.
	 * @since 1.1.11
	 */
	public $hiddenPageCssClass=self::CSS_HIDDEN_PAGE;
	/**
	 * @var string the CSS class for the selected page buttons. Defaults to 'selected'.
	 * @since 1.1.11
	 */
	public $selectedPageCssClass=self::CSS_SELECTED_PAGE;
	/**
	 * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
	 */
	public $maxButtonCount=8;
	/**
	 * @var string the text label for the next page button. Defaults to 'Next &gt;'.
	 */
	public $nextPageLabel = '下一页';
	/**
	 * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
	 */
	public $prevPageLabel = '上一页';

	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer='';
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile;
	/**
	 * @var array HTML attributes for the pager container tag.
	 */
	public $htmlOptions=array();

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','Next &gt;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt; Previous');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','首页');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','末页');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='yiiPager';

		$this->request_uri = $_SERVER['REQUEST_URI'];
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

		// echo '<p class="fl">第'.($this->currentPage+1).'/'.$this->pageCount.'页，每页'.$this->pageSize.'条，共'.$this->itemCount.'条</p>';
		echo implode("\n", $buttons);

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

		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->previousPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{


		if( $selected )
		{
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
			return CHtml::tag('span', array('class'=> $class), $label);
		}
		else
		{
			if( empty(Yii::app()->request->queryString) )//无参数，则直接添加?page
				$uri = $this->request_uri . '?page=' . ($page + 1);
			elseif( strpos($this->request_uri, 'page=') )//有参数并且有page，则替换值
				$uri = preg_replace('/page=\d+/' , 'page=' . ($page + 1), $this->request_uri );
			else//有参数但没page，则加上?page
				$uri = $this->request_uri . '&page=' . ($page + 1);
			// $uri = strpos($this->request_uri , '?page' )!==false ? preg_replace('/\?page=\d+/' , '?page=' . ($page+1) , $this->request_uri ) : $this->request_uri . '?page=' . ($page + 1) ;
			return CHtml::link(CHtml::tag('span',array('class'=>$class),$label) , $uri);
		}
	}

	/**
	 * @return array the begin and end pages that need to be displayed.
	 */
	protected function getPageRange()
	{
		$currentPage=$this->getCurrentPage();
		$pageCount=$this->getPageCount();

		$beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));
		if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
		{
			$endPage=$pageCount-1;
			$beginPage=max(0,$endPage-$this->maxButtonCount+1);
		}
		return array($beginPage,$endPage);
	}

	/**
	 * Registers the needed client scripts (mainly CSS file).
	 */
	public function registerClientScript()
	{
		if($this->cssFile!==false)
			self::registerCssFile($this->cssFile);
	}

	/**
	 * Registers the needed CSS file.
	 * @param string $url the CSS URL. If null, a default CSS URL will be used.
	 */
	public static function registerCssFile($url=null)
	{

		if($url===null)
			$url=CHtml::asset(Yii::getPathOfAlias('system.web.widgets.pagers.pager').'.css');
		Yii::app()->getClientScript()->registerCssFile($url);

	}
}
