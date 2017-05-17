<div class="search-wrap clearfix">
    <div class="search-box clearfix pd-t15 pd-b15">
        <form method="get" action="<?=$this->createUrl('list')?>" id="search-form">
            <div class="search-input fl">
                <input autocomplete="off" class="input"  data-type="3" data-url="<?=$this->createUrl('/api/resoldwapapi/plotsearchajax')?>" data-category="1" name="kw" value="<?=$this->kw?>" placeholder="请输入小区名称">
            </div>
            <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
            </form>
    <div class="search-list-box">
    </div>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
