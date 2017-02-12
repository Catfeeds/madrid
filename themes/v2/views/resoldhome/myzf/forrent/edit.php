<?php
$this->pageTitle = '编辑求租';
?>
<div class="gtitle"><?php echo $this->pageTitle ; ?></div>
<div class="my-edit my-buy">
    <?php $form = $this->beginWidget('CActiveForm',array('action'=>$this->createUrl('/resoldhome/myzf/forrentsave'),'htmlOptions'=>array('class'=>'valid-form')));  ?>
    <input type="hidden" name="id" value="<?php echo $model->id; ?>">
    <div class="b1 my-edit-contact">
        <div class="sub-title">联系方式（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 联 系 人</div>
                <div class="option gender">
                    <input class="u-input" type="text" value="<?php echo $model->username; ?>" name="username" datatype="*1-10" errormsg="最多输入10个字" nullmsg="请输入联系人"/>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 联系手机</div>
                <div class="option">
                    <input class="u-input" type="text" name="phone"  value="<?php echo $model->phone;?>" datatype="m" errormsg="手机号码格式不正确" nullmsg="请输入手机号码"/>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ercode ele-input <?php if($model->phone){echo 'dn';} ?>">
                <div class="label"><span class="em">*</span> 验 证 码</div>
                <div class="option">
                    <input class="u-input" type="text" name="code" datatype="code" nullmsg="请输入验证码" errormsg="验证码错误" />
                    <a href="javascript:;" id="send-code" data-origin="我要发布" class="get-sms-code">获取验证码</a>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="b1 ele-radios my-edit-type">
        <div class="sub-title">发布方式（<span class="em">*</span>为必填）</div>
        <div class="fabu-category">
            <ul>
                <li class="u-radio-group">
                    <?php foreach (Yii::app()->params->category as $key => $category): ?>
                        <label><input type="radio" name="category" value="<?php echo $key; ?>" <?php if($key == $model->category){echo 'checked';}?>/><span><?php echo $category;?></span></label>
                    <?php endforeach; ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="b3 my-edit-params">
        <div class="sub-title">发布方式（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-name ele-select">
                <div class="label"><span class="em">*</span> 意向区域</div>
                <div class="option">
                    <select id="area" name="area">
                        <?php foreach (AreaExt::getAllarea() as $key => $area): ?>
                            <option value="<?php echo $key ; ?>" <?php if($model->area == $key){echo 'selected';}?>><?php echo $area; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="street" name="street">
                        <?php if($model->street): ?>
                            <?php $streets =  AreaExt::model()->getByParent($model->area)->normal()->findAll();
                            foreach ($streets as $street):
                                ?>
                                <option value="<?php echo $street->id ; ?>" <?php if($model->street == $street->id){echo 'selected';}?>><?php echo $street->name; ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="0">不限</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 意向楼盘</div>
                <div class="option">
                    <?php $plots = $model->getPlots();?>
                    <input type="text" class="u-input form-control js-plot-select2" data-name="<?php echo isset($plots[0]) ? $plots[0]['plot_name'] : ''; ?>" value="<?php echo isset($plots[0]) ? $plots[0]['id'] : ''; ?>" name="hid[]"/><span class="unit">或</span>
                    <input type="text" class="u-input form-control js-plot-select2" data-name="<?php echo isset($plots[1]) ? $plots[1]['plot_name'] : ''; ?>" value="<?php echo isset($plots[1]) ? $plots[1]['id'] : ''; ?>" name="hid[]"/><span class="unit">或</span>
                    <input type="text" class="u-input form-control js-plot-select2" data-name="<?php echo isset($plots[2]) ? $plots[2]['plot_name'] : ''; ?>" value="<?php echo isset($plots[2]) ? $plots[2]['id'] : ''; ?>" name="hid[]"/>
                </div>
            </div>

            <div class="ele ele-radios display-1 <?php if($model->category != 1){echo 'dn';} ?>">
                <div class="label"><span class="em">*</span> 期望方式</div>
                <div class="option u-radios">
                    <?php foreach ($this->allTag['zfmode'] as $key => $zfmode): ?>
                        <label><input type="radio" name="rent_type" value="<?php echo $zfmode['id'];?>" <?php if($zfmode['id'] == $model->rent_type){echo 'checked';}?>/><span><?php echo $zfmode['name'];?></span></label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="ele multi-checkbox display-1 <?php if($model->category != 1){echo 'dn';} ?>">
                <div class="label"><span class="em">*</span> 期望户型</div>
                <div class="option">
                    <ul>
                    <?php foreach ($this->allTag['resoldhuxing'] as $hx): ?>
                        <li><label><input type="checkbox" name="resoldhuxing[]" value="<?php echo $hx['id']; ?>" <?php if(isset($model->data_conf['resoldhuxing']) && !empty($model->data_conf['resoldhuxing'])) foreach ($model->data_conf['resoldhuxing'] as $check){ if($check == $hx['id']){ echo 'checked';} } ?> datatype="qwhx" nullmsg="请选择期望户型"/><?php echo $hx['name'];?></label></li>
                    <?php endforeach; ?>
                        </ul>
                </div>
            </div>

            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 期望租金</div>
                <div class="option">
                    <span class="unit pl0">不超过</span><input type="text" class="u-input" name="price" value="<?php echo $model->price; ?>" datatype="rent" nullmsg="请输入租金" errormsg="租金必须在0到1000000之间"  />
                    <span class="unit">元/月</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>

            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 期望面积</div>
                <div class="option">
                    <span class="unit pl0">不小于</span><input type="text" class="u-input w68" name="size" value="<?php echo $model->size; ?>" datatype="size" nullmsg="请输入面积" errormsg="面积要大于1平方米小于10000平方米"/><span class="unit">平方米</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>

            <div class="ele ele-select display-2 <?php if($model->category != 2){echo 'dn';} ?>">
                <div class="label"><span class="em">*</span> 商铺类型</div>
                <div class="option">
                    <select name="esfzfsptype" data-width="197">
                        <?php foreach($this->allTag['esfzfsptype'] as $type): ?>
                            <option value="<?php echo $type['id'];?>" <?php if(isset($model->data_conf['esfzfsptype']) && $model->data_conf['esfzfsptype'] == $type['id']){echo 'selected';} ?>><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select display-3 <?php if($model->category != 3){echo 'dn';} ?>">
                <div class="label"><span class="em">*</span> 写字楼类型</div>
                <div class="option">
                    <select name="esfzfxzltype" data-width="197">
                        <?php foreach($this->allTag['esfzfxzltype'] as $type): ?>
                            <option value="<?php echo $type['id'];?>" <?php if(isset($model->data_conf['esfzfxzltype']) && $model->data_conf['esfzfxzltype'] == $type['id']){echo 'selected';} ?>><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="ele multi-checkbox display-2 <?php if($model->category != 2){echo 'dn';} ?>">
                <div class="label"><span class="em">*</span> 经营项目</div>
                <div class="option">
                    <ul>
                        <?php foreach ($this->allTag['zfspkjyxm'] as $xm): ?>
                            <li><label><input datatype="jyxm" nullmsg="请选择经营项目"  type="checkbox" name="zfspkjyxm[]" value="<?php echo $xm['id'];?>" <?php if(isset($model->data_conf['zfspkjyxm']) && !empty($model->data_conf['zfspkjyxm'])) foreach ($model->data_conf['zfspkjyxm'] as $check){ if($check == $xm['id']){ echo 'checked';} } ?>/><?php echo $xm['name']?></label></li>
                        <?php endforeach; ?>
                        <div class="ui-errormsg"></div>
                    </ul>
                </div>
            </div>
            <div class="ele ele-select">
                <div class="label"><span class="em"></span> 期望装修</div>
                <div class="option">
                    <select name="decoration">
                        <option value="0">不限</option>
                        <?php foreach($this->allTag['resoldzx'] as $zx): ?>
                            <option value="<?php echo $zx['id'];?>" <?php if($model->decoration == $zx['id']){echo 'selected';} ?>><?php echo $zx['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="ele multi-checkbox mb0 display-1 <?php if($model->category != 1){echo 'style="dn';} ?>">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php foreach ($this->allTag['zfzzpt'] as $pt): ?>
                            <li><label><input type="checkbox" name="zfzzpt[]" value="<?php echo $pt['id']; ?>" <?php if(isset($model->data_conf['zfzzpt']) && !empty($model->data_conf['zfzzpt'])) foreach ($model->data_conf['zfzzpt'] as $check){ if($check == $pt['id']){ echo 'checked';} } ?>/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="ele multi-checkbox mb0 display-2 <?php if($model->category != 2){echo 'dn';} ?>">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php foreach ($this->allTag['zfsppt'] as $pt): ?>
                            <li><label><input type="checkbox" name="zfsppt[]" value="<?php echo $pt['id']; ?>" <?php if(isset($model->data_conf['zfsppt']) && !empty($model->data_conf['zfsppt'])) foreach ($model->data_conf['zfsppt'] as $check){ if($check == $pt['id']){ echo 'checked';} } ?>/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="ele multi-checkbox mb0 display-3 <?php if($model->category != 3){echo 'dn';} ?>">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php foreach ($this->allTag['zfxzlpt'] as $pt): ?>
                            <li><label><input type="checkbox" name="zfxzlpt[]" value="<?php echo $pt['id']; ?>" <?php if(isset($model->data_conf['zfxzlpt']) && !empty($model->data_conf['zfxzlpt'])) foreach ($model->data_conf['zfxzlpt'] as $check){ if($check == $pt['id']){ echo 'checked';} } ?> /><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="b1 b4 my-edit-content">
        <div class="sub-title">求租详情（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-input ele-house-title">
                <div class="label"><span class="em">*</span> 标题</div>
                <div class="option">
                    <input class="u-input w400" type="text" value="<?php echo $model->title ; ?>" name="title" placeholder="用简单明了的文字说出房源的特色" datatype="*1-40" errormsg="最多输入40个字" nullmsg="请输入标题" />
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele">
                <div class="label"><span class="em"></span> 需求描述</div>
                <div class="option">
                    <div class="textarea ui-textarea">
                        <textarea name="content" cols="30" rows="10"><?php echo $model->content ; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="ele">
                <div class="label">&#160;</div>
                <div class="option">
                    <div class="btn">
                        <input type="submit" value="确认发布" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget();  ?>
</div>

<?php
$js = "var realPhone = '{$model->phone}';";
Yii::app()->clientScript->registerScript(__CLASS__.'#js',$js,CClientScript::POS_END);
?>
