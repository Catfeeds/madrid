<?php
    $this->pageTitle = $seoArr[$type]['t'];
    $this->keyword = $seoArr[$type]['k'];
    $this->description = $seoArr[$type]['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/map-findhouse.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/map.css');
?>
    <script type="text/javascript">
        var map_type = '<?php echo $type?>';
        var pc_city_name = '<?=SM::urmConfig()->cityName()?>';
    </script>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
        <form method="get" id="search-form" action="<?=$type==3?$this->createUrl('/resoldhome/esf/list'):$this->createUrl('/resoldhome/zf/list')?>">
        <div class="search-input fl">
            <input class="input" name="kw" value="" placeholder="<?=$type==3?'请输入二手房名称':'请输入租房名称'?>">
        </div>
        <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
        </form>
        <div class="search-list-box">
            <ul>
                <li>
                    <span>大名城<em>新北三井</em></span>
                    <span class="right">约469条房源</span>
                </li>
                <li>
                    <span>大名城别墅<em>新北三井</em></span>
                    <span class="right">约469条房源</span>
                </li>
            </ul>
        </div>
       <?php $this->widget('CommonWidget',['type'=>1])?>

    </div>
</div>
<div class="blank20"></div>
<div class="wapper ovisible">
    <div class="select-box map-select-box">
       <div class="left-box">
            <ul>
	            <?php foreach ($ftags as $key => $value) { ?>
	            	<li class="filter" data-name="<?=$value[0]['cate']?>">
	                    <div class="fl filter_sel dropdown open">
	                        <a class="dropdown_toggle" data-toggle="dropdown"><?=$key?><span class="caret list-icon"></span></a>
	                        <ul class="filter_sel_box dropdown-menu dn">
	                        <?php foreach ($value as $k => $v) {?>
	                        	<li><a href="#" data-id="<?=$v['id']?>"><?=$v['name']?></a></li>
	                        <?php }?>
	                        </ul>
	                    </div>
	                </li>
	            <?php }?>
            
            	<li class="more-select">更多条件</li>


                <li class="delete-all"><p>清空全部</p></li>
            </ul>
            <ul class="last-ul fl dn">
                <?php foreach ($ltags as $key => $value) {?>
            	<li class="filter" data-name="<?=$value[0]['cate']?>">
                    <div class="fl filter_sel dropdown open">
                        <a class="dropdown_toggle" data-toggle="dropdown"><?=$key?><span class="caret list-icon"></span></a>
                        <ul class="filter_sel_box dropdown-menu dn">
                        <?php foreach ($value as $k => $v) {?>
                        	<li><a href="#" data-id="<?=$v['id']?>"><?=$v['name']?></a></li>
                        <?php }?>
                        </ul>
                    </div>
                </li>
            <?php }?>
            </ul>
        </div>

        <div class="right-box">
            <div class="location"></div>
            <a href="<?=$type==3?$this->createUrl('/resoldhome/esf/list'):$this->createUrl('/resoldhome/zf/list')?>"><div class="right-list">列表</div></a>
        </div>
    </div>
</div>
<div class="blank20"></div>

<div class="map-box">
    <div id="allmap">
    </div>
    <div class="map-list">
        <div class="map-list-box">
        </div>
    </div>
</div>

<script type="text/template" id="area-tpl">
    <div class="area-container">
        <div class="map-title"><p>共 <span>{{total}}</span> 套相关房源</p></div>
        <div class="map-content j-nicescroll">
            <ul>
                {{each lists as value k}}
                <li><a class="area-item" data-area="{{value.id}}"><span class="con-span-1">{{value.name}}</span><span class="con-span-2">{{value.num}}套</span></a></li>
                {{/each}}
            </ul>
        </div>
    </div>
</script>
<script type="text/template" id="street-tpl">
    <div class="street-container">
        <div class="map-title"><p>共 <span>{{total}}</span> 套相关房源</p></div>
        <div class="map-content j-nicescroll">
            <ul>
                {{each lists as value k}}
                <li><a class="street-item" data-street="{{value.id}}"><span class="con-span-1">{{value.name}}</span><span class="con-span-2">{{value.num}}套</span></a></li>
                {{/each}}
            </ul>
        </div>
    </div>
</script>
<script type="text/template" id="plot-tpl">
    <div class="plot-container">
        <div class="map-title"><p>共 <span>{{total}}</span> 套相关房源</p></div>
        <div class="map-content j-nicescroll">
            <ul>
                {{each lists as value k}}
                <li><a class="plot-item" data-plot="{{value.id}}"><span class="con-span-1">{{value.name}}</span><span class="con-span-2">{{value.num}}套</span></a></li>
                {{/each}}
            </ul>
        </div>
    </div>
</script>
<script type="text/template" id="plot-detail-tpl">
        <div class="mdetail-box">
            <div class="mhouse-info clearfix">
                <div class="minfo-left">
                    <div class="minfo-name clearfix">
                        <h3>{{plot_name}}</h3>
                        <p class="area"><span>{{area}}</span><span>{{street}}</span></p>
                    </div>
                    <div class="mhouse-num">
                        <span>二手房<em>{{esf_num}}</em>套</span>
                        <span>租房<em>{{zf_num}}</em>套</span>
                    </div>
                </div>
                <div class="minfo-right">
                    {{if esf_price != 0}}
                    <p class="mprice"><span>{{esf_price}}</span>元/㎡</p>
                    {{else}}
                    <p class="mprice">面议</p>
                    {{/if}}
                </div>
           </div>
           <div class="ms-nav">
                <div class="fr">
                    共找到<span>{{esf_num}}</span>套房源
                </div>
                <div>
                    <ul>
                        <li><a class="{{if filter['sort'] == 0}}on{{/if}} sort_normal">默认</a></li>
                        <li><a class="{{if filter['sort'] == 1}}on{{/if}} sort_new">最新</a></li>
                        <li><a class="{{if filter['sort'] == 2 || filter['sort'] == 3}}on{{/if}} sort_price">价格<em class="{{if filter['sort'] == 2}}down{{/if}}"></em></a></li>
                    </ul>
                </div>
           </div>
           <div class="mhouse-list j-nicescroll">
                <ul class="clearfix">
                    {{each data as value k}}
                    <li>
                        <a target="_blank" href="{{value.url}}">
                            <div class="pic"><img src="{{value.image}}"></div>
                            <div class="info">
                                {{if value.price == 0}}
                                <p class="price" style="font-size:18px">面议</p>
                                {{else}}
                                <p class="price"><em>{{value.price}}</em>万</p>
                                {{/if}}
                                <p class="other-info">
                                <span>{{value.bedroom}}室{{value.livingroom}}厅{{value.bathroom}}卫</span><em>|</em><span>{{value.size}}㎡</span><em>|</em>
                                {{if value.ave_price == 0}}
                                <span>面议</span>
                                {{else}}
                                <span>{{value.ave_price}}元/㎡</span>
                                {{/if}}
                                </p>
                            </div>
                        </a>
                    </li>
                    {{/each}}
                </ul>
                {{if pageCount > 1}}
                <div class="sfenye">
                    {{each pageCount as value k}}
                    <a {{if k == 0}} class="on" {{/if}}>{{k + 1}}</a>
                    {{/each}}
                </div>
                {{/if}}
           </div>
        </div>
</script>
<script type="text/template" id="plot-zu-detail-tpl">
        <div class="mdetail-box">
            <div class="mhouse-info clearfix">
                <div class="minfo-left">
                    <div class="minfo-name clearfix">
                        <h3>{{plot_name}}</h3>
                        <p class="area"><span>{{area}}</span><span>{{street}}</span></p>
                    </div>
                    <div class="mhouse-num">
                        <span>二手房<em>{{esf_num}}</em>套</span>
                        <span>租房<em>{{zf_num}}</em>套</span>
                    </div>
                </div>
           </div>
           <div class="ms-nav">
                <div class="fr">
                    共找到<span>{{zf_num}}</span>套房源
                </div>
                <div>
                    <ul>
                        <li><a class="{{if filter['sort'] == 0}}on{{/if}} sort_normal">默认</a></li>
                        <li><a class="{{if filter['sort'] == 1}}on{{/if}} sort_new">最新</a></li>
                        <li><a class="{{if filter['sort'] == 2 || filter['sort'] == 3}}on{{/if}} sort_price">价格<em class="{{if filter['sort'] == 2}}down{{/if}}"></em></a></li>
                    </ul>
                </div>
           </div>
           <div class="mhouse-list">
                <ul class="clearfix">
                    {{each data as value k}}
                    <li>
                        <a target="_blank" href="{{value.url}}">
                            <div class="pic"><img src="{{value.image}}"></div>
                            <div class="info">
                                {{if value.price == 0}}
                                <p class="price" style="font-size:18px">面议</p>
                                {{else}}
                                <p class="price"><em>{{value.price}}</em>元/月</p>
                                {{/if}}
                                <p class="other-info">
                                <span>{{value.bedroom}}室{{value.livingroom}}厅{{value.bathroom}}卫</span><em>|</em><span>{{value.size}}㎡</span><em></em>
                                </p>
                            </div>
                        </a>
                    </li>
                    {{/each}}
                </ul>
                {{if pageCount > 1}}
                    <div class="sfenye">
                        {{each pageCount as value k}}
                        <a {{if k == 0}} class="on" {{/if}}>{{k + 1}}</a>
                        {{/each}}
                    </div>
                {{/if}}
           </div>
        </div>
</script>
