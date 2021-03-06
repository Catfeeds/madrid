<div class="big-filter">
   <div class="tabs clearfix">
       <div class="btn-right">
           <a href="<?=$this->createUrl('/resoldhome/myesf/sellinput')?>">免费发布房源</a>
           <a href="<?=$this->createUrl('/vip/common/index')?>">中介入口</a>
       </div>
       <?php if($this->get['type']==2 || $this->get['type']==3):?>
           <ul class="clearfix">
             <li><a href="<?=$this->createUrl('/resoldhome/esf/list',['type'=>$this->get['type']])?>">出售</a></li>
             <li><a href="<?=$this->createUrl('list',['type'=>$this->get['type']])?>" class="on">出租</a></li>
             <li><a href="<?=$this->createUrl('/resoldhome/qg/index',['type'=>$this->get['type']])?>">求购</a></li>
             <li><a href="<?=$this->createUrl('/resoldhome/qz/index',['type'=>$this->get['type']])?>">求租</a></li>
           </ul>
       <?php else:?>
       <ul class="clearfix">
         <li><a href="<?=$this->createUrl('list')?>" <?php if($this->get['type']==1):?>class="on"<?php endif;?>>按区域查询</a></li>
         <!-- <li><a href="" >按学校查询</a></li> -->
         <li><a href="<?=$this->createUrl('/resoldhome/map/index',['type'=>2])?>" >切换到地图搜索</a></li>
       </ul>
   <?php endif;?>
   </div>
   <div class="category-select">
       <dl class="clearfix">
         <dt>区域：</dt>
         <dd>
             <?php $this->widget('TagInfoWidget',['cate'=>'area','id'=>$this->get['area']?$this->get['area']:$this->get['street'],'get'=>$_GET,'url'=>'/resoldhome/zf/list'])?>
         </dd>
       </dl>

       <!--商铺 面积-->
       <?php if($this->get['type'] != 1):?>
           <dl class="clearfix">
             <dt>面积：</dt>
             <dd>
                 <?php
                 if($this->get['type'] == 2){
                    $this->widget('TagInfoWidget',['cate'=>'zfspsize','id'=>$this->get['size'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
                }elseif($this->get['type'] == 3){
                    $this->widget('TagInfoWidget',['cate'=>'zfxzlsize','id'=>$this->get['size'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
                }

                 ?>
             </dd>
           </dl>
       <?php endif;?>
       <!--面积end-->

       <!--租金-->
       <dl class="clearfix">
         <dt>租金：</dt>
         <dd>
            <?php
                if($this->get['type']==2){
                    $this->widget('TagInfoWidget',['cate'=>'zfspprice','id'=>$this->get['price'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
                }elseif ($this->get['type']==3) {
                    $this->widget('TagInfoWidget',['cate'=>'zfxzlprice','id'=>$this->get['price'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
                }else{
                    $this->widget('TagInfoWidget',['cate'=>'zfzzprice','id'=>$this->get['price'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
                }
            ?>
         </dd>
       </dl>
       <!--租金end-->

       <!--出租住宅 户型 和 租房方式-->
       <?php if($this->get['type']==1):?>
       <dl class="clearfix">
         <dt>户型：</dt>
         <dd>
           <?php $this->widget('TagInfoWidget',['cate'=>'resoldhuxing','id'=>$this->get['bedroom'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);?>
         </dd>
       </dl>
       <dl class="clearfix">
         <dt>方式：</dt>
         <dd>
           <?php $this->widget('TagInfoWidget',['cate'=>'zfmode','id'=>$this->get['way'],'get'=>$_GET,'url'=>'/resoldhome/zf/list'])?>
         </dd>
       </dl>
       <?php endif;?>
       <!--end-->

       <!--商铺 类型-->
       <?php if($this->get['type']==2):?>
           <dl class="clearfix">
             <dt>类型：</dt>
             <dd>
               <?php $this->widget('TagInfoWidget',['cate'=>'esfzfsptype','id'=>$this->get['cate'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);?>
             </dd>
           </dl>
       <?php endif;?>
       <!--类型 end-->
       <?php if($this->get['type']==3):?>
           <dl class="clearfix">
             <dt>类型：</dt>
             <dd>
               <?php $this->widget('TagInfoWidget',['cate'=>'esfzfxzltype','id'=>$this->get['cate'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);?>
             </dd>
           </dl>
       <?php endif;?>
       <!--类型 end-->

       <!--类别-->
       <?php if($this->get['type']==2):?>
       <?php endif;?>
       <!--end类别-->

       <!--商铺特色-->
       <dl class="clearfix">
         <dt>特色：</dt>
         <dd>
             <?php
             if($this->get['type']==2){
                 $this->widget('TagInfoWidget',['cate'=>'zfspts','id'=>$this->get['ts'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
             }elseif($this->get['type']==3){
                 $this->widget('TagInfoWidget',['cate'=>'zfxzlts','id'=>$this->get['ts'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
             }else{
                 $this->widget('TagInfoWidget',['cate'=>'zfzzts','id'=>$this->get['ts'],'get'=>$_GET,'url'=>'/resoldhome/zf/list']);
             }
             ?>
         </dd>
       </dl>
       <!--end 特色-->

       <!--only zfzz-->
       <dl class="other">
         <dt>更多找房条件：</dt>
         <dd class="clearfix">
           <div class="filter gc3 fs14">

               <div class="fl filter_sel dropdown open">
                   <a class="dropdown_toggle" data-toggle="dropdown"><?=$this->get['towards']?TagExt::getNameByTag($this->get['towards']):'朝向'?><span class="caret list-icon"></span></a>
                   <?php $towards = TagExt::model()->getTagByCate('resoldface')->normal()->findAll(['order'=>'sort asc']);?>
                   <ul class="filter_sel_box dropdown-menu dn">
                       <?php if($towards)
                       {
                           $tmpGet = $this->get;
                           unset($tmpGet['towards']);
                           ?>
                           <li><a href="<?=$this->createUrl('list',array_filter($tmpGet))?>">不限</a></li>
                           <?php
                           foreach ($towards as $key => $v) { ?>
                              <li><a href="<?=$this->createUrl('list',array_merge(['towards'=>$v->id],array_filter($tmpGet)))?>"><?=$v->name?></a></li>
                            <?php }
                       }
                       ?>
                   </ul>
               </div>

               <div class="fl filter_sel dropdown open">
                   <a class="dropdown_toggle" data-toggle="dropdown"><?=$this->get['floor']?TagExt::getNameByTag($this->get['floor']):'楼层'?><span class="caret list-icon"></span></a>
                   <?php
                       $topAndLowFloor = TagExt::model()->getTagByCate('esffloorcate')->normal()->findAll(['order'=>'sort asc']);
                   ?>
                   <ul class="filter_sel_box dropdown-menu dn">
                       <?php if($topAndLowFloor)
                       {
                           $tmpGet = $this->get;
                           unset($tmpGet['floor']);
                           ?>
                           <li><a href="<?=$this->createUrl('list',array_filter($tmpGet))?>">不限</a></li>
                           <?php
                           foreach ($topAndLowFloor as $key => $v) { ?>
                              <li><a href="<?=$this->createUrl('list',array_merge(['floor'=>$v->id],array_filter($tmpGet)))?>"><?=$v->name?></a></li>
                            <?php }
                       }
                       ?>
                   </ul>
               </div>
               <div class="fl filter_sel dropdown open">
                   <a class="dropdown_toggle" data-toggle="dropdown"><?=$this->get['decoration']?TagExt::getNameByTag($this->get['decoration']):'装修'?><span class="caret list-icon"></span></a>
                   <?php $decorations = TagExt::model()->getTagByCate('resoldzx')->normal()->findAll(['order'=>'sort asc']);?>
                   <ul class="filter_sel_box dropdown-menu dn">
                       <?php if($decorations)
                       {
                           $tmpGet = $this->get;
                           unset($tmpGet['decoration']);
                           ?>
                           <li><a href="<?=$this->createUrl('list',array_filter($tmpGet))?>">不限</a></li>
                           <?php
                           foreach ($decorations as $key => $v) { ?>
                              <li><a href="<?=$this->createUrl('list',array_merge(['decoration'=>$v->id],array_filter($tmpGet)))?>"><?=$v->name?></a></li>
                            <?php }
                       }
                       ?>
                   </ul>
               </div>
           </div>
         </dd>
       </dl>
       <!--租房住宅 add-->
       <dl class="hascheck">
         <dt>当前选择条件：</dt>
         <dd>
             <ul class="clearfix">
             <?php if(array_filter($this->get))
             foreach (array_filter($this->get) as $key => $value) {?>

                 <?php if($key=='area'||$key=='street'):
                     $tag = AreaExt::model()->findByPk($value);
                     $tmpGets = array_filter($this->get);
                     unset($tmpGets['area']);
                     unset($tmpGets['street']);
                 ?>
                 <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$tag->name?><i class="list-icon icon-12"></i></a></li>
                 <?php elseif($key=='source'):
                     $tag = Yii::app()->params['source'];
                     $tmpGets = array_filter($this->get);
                     unset($tmpGets['source']);
                 ?>
                 <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$tag[$value]?><i class="list-icon icon-12"></i></a></li>
                 <?php elseif($key=='kw'):
                     $tmpGets = array_filter($this->get);
                     unset($tmpGets['kw']);
                 ?>
                 <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$this->get[$key]?><i class="list-icon icon-12"></i></a></li>
                 <?php elseif($key=='hid'):
                     $tmpGets = array_filter($this->get);
                     unset($tmpGets['hid']);
                 ?>
                 <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$this->otherParams['plot']?$this->otherParams['plot']->title:'未知楼盘'?><i class="list-icon icon-12"></i></a></li>
                <?php elseif($key=='hurry'):
                    $tmpGets = array_filter($this->get);
                    unset($tmpGets['hurry']);
                ?>
                <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1">加急<i class="list-icon icon-12"></i></a></li>


                 <?php elseif($key != 'saletime' && $key != 'sort' && $key != 'type' && $key != 'page'):
                     $tag = TagExt::getNameByTag($value);
                     $tmpGets = array_filter($this->get);
                     unset($tmpGets[$key]);
                 ?>
                 <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$tag?><i class="list-icon icon-12"></i></a></li>
                 <?php endif;?>
             <?php }?>
                 <li><a href="<?=$this->createUrl('list')?>" class="k-select-2"><i class="list-icon icon-clear"></i>清空所有条件</a></li>
             </ul>
         </dd>
       </dl>
   </div>
</div>
