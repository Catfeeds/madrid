<div class="wenda-search">
    <div class="inner">
       <h1>房产问答</h1>
        <div class="search-box">
            <div class="search-form">
                <form action="<?php echo $this->createUrl('/home/wenda/index')?>" method="get" class="clearfix">
                    <input id="textquestion" class="question-txt" type="text" name="kw" placeholder="搜索问题、话题" value="<?php echo isset($kw)?$kw:''; ?>" /><input type="submit" value="搜索答案" />
                </form>
            </div>
            <div class="aside clearfix">
                <dl class="hot-keys">
                    <dt><span>热门搜索：</span></dt>
                    <?php foreach(RecomExt::model()->getRecom('pcwdrs', 5)->findAll() as $v): ?>
                    <dd><a href="<?php echo $v->url; ?>" target="_blank"><?php echo $v->title; ?></a></dd>
                    <?php endforeach; ?>
                </dl>
                <!--<a href="" class="tiwenmark">我的提问记录</a>-->
            </div>
        </div>
    </div>
</div>
