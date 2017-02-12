<?php
$this->pageTitle = '我要求购';
?>
<div class="gtitle"><?php echo $this->pageTitle ; ?></div>
<div class="my-edit my-buy">
    <?php $form = $this->beginWidget('CActiveForm',array('action'=>'/resoldhome/myesf/buysave','htmlOptions'=>array('class'=>'valid-form')));  ?>
    <div class="b1 my-edit-contact">
        <div class="sub-title">联系方式（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 联 系 人</div>
                <div class="option gender">
                    <input class="u-input" type="text" value="<?php echo $this->user->username; ?>" name="username" datatype="*1-10" errormsg="最多输入10个字" nullmsg="请输入联系人" />
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 联系手机</div>
                <div class="option">
                    <input class="u-input" type="text" name="phone"  value="<?php echo $this->user->phone;?>" datatype="m" errormsg="手机号码格式不正确" nullmsg="请输入手机号码"/>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ercode ele-input <?php if($this->user->phone){echo 'dn';} ?>">
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
                        <label><input type="radio" name="category" value="<?php echo $key; ?>" <?php if($key == 1){echo 'checked';}?>/><span><?php echo $category;?></span></label>
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
                            <option value="<?php echo $key ; ?>"><?php echo $area; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="street" name="street">
                        <option value="0">不限</option>
                    </select>
                </div>
            </div>
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 意向楼盘</div>
                <div class="option">
                    <input type="text" class="u-input form-control js-plot-select2" data-name="" value="" name="hid[]"/><span class="unit">或</span>
                    <input type="text" class="u-input form-control js-plot-select2" data-name="" value="" name="hid[]"/><span class="unit">或</span>
                    <input type="text" class="u-input form-control js-plot-select2" data-name="" value="" name="hid[]"/>
                </div>
            </div>
            <div class="ele ele-select display-2 dn">
                <div class="label"><span class="em">*</span> 商铺类型</div>
                <div class="option">
                    <select name="tags[]" data-width="197">
                        <?php if(isset($this->allTag['esfzfsptype'])) foreach($this->allTag['esfzfsptype'] as $type): ?>
                            <option value="<?php echo $type['id'];?>"><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select display-3 dn">
                <div class="label"><span class="em">*</span> 写字楼类型</div>
                <div class="option">
                    <select name="tags[]" data-width="197">
                        <?php if(isset($this->allTag['esfzfxzltype'])) foreach($this->allTag['esfzfxzltype'] as $type): ?>
                            <option value="<?php echo $type['id'];?>"><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele multi-checkbox display-2 dn">
                <div class="label"><span class="em">*</span>经营项目</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['esfspkjyxm'])) foreach($this->allTag['esfspkjyxm'] as $ts): ?>
                            <li><label><input datatype="jyxm" nullmsg="请选择经营项目"  type="checkbox" name="tags[]" value="<?php echo $ts['id'];?>"/><?php echo $ts['name']?></label></li>
                        <?php endforeach; ?>
                        <div class="ui-errormsg"></div>
                    </ul>
                </div>
            </div>

            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 期望价格</div>
                <div class="option">
                    <span class="unit pl0">不超过</span><input type="text" class="u-input w68" name="price" datatype="price" nullmsg="请输入期望价格" errormsg="价格必须在0到100000之间"  />
                    <span class="unit">万元</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 期望面积</div>
                <div class="option">
                    <span class="unit pl0">不小于</span><input type="text" class="u-input w68" name="size" datatype="size" nullmsg="请输入面积" errormsg="面积要大于1平方米小于10000平方米"/><span class="unit">平方米</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-huxing ele-input display-1">
                <div class="label"><span class="em">*</span>  户<span class="em2"></span>型</div>
                <div class="option">
                    <input type="text" name="bedroom" class="u-input" datatype="hx" data-name="卧室" nullmsg="请输入几室" /><span class="unit">室</span>
                    <input type="text" name="livingroom" class="u-input" datatype="hx" data-name="客厅" nullmsg="请输入几厅" /><span class="unit">厅</span>
                    <input type="text" name="bathroom" class="u-input" datatype="hx" data-name="卫生间" nullmsg="请输入几卫" /><span class="unit">卫</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-input display-1">
                <div class="label"> 期望楼层</div>
                <div class="option">
                    <select name="tags[]">
                        <option value="">不限</option>
                        <?php if(isset($this->allTag['qgzzqwlc'])) foreach($this->allTag['qgzzqwlc'] as $lc): ?>
                            <option value="<?php echo $lc['id'];?>"><?php echo $lc['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-input display-1">
                <div class="label"> 期望房龄</div>
                <div class="option">
                    <select name="tags[]">
                        <option value="">不限</option>
                        <?php if(isset($this->allTag['qgzzqwfl'])) foreach($this->allTag['qgzzqwfl'] as $fl): ?>
                            <option value="<?php echo $fl['id'];?>"><?php echo $fl['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select">
                <div class="label"><span class="em"></span> 期望装修</div>
                <div class="option">
                    <select name="decoration">
                        <option value="">不限</option>
                        <?php if(isset($this->allTag['resoldzx'])) foreach($this->allTag['resoldzx'] as $zx): ?>
                            <option value="<?php echo $zx['id'];?>"><?php echo $zx['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select display-1">
                <div class="label"><span class="em"></span> 朝<span class="em2"></span>向</div>
                <div class="option">
                    <select name="towards">
                        <option value="">不限</option>
                        <?php if(isset($this->allTag['resoldface'])) foreach($this->allTag['resoldface'] as $cx): ?>
                            <option value="<?php echo $cx['id'];?>"><?php echo $cx['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele multi-checkbox mb0 display-1">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['esfzzpt'])) foreach($this->allTag['esfzzpt'] as $pt): ?>
                            <li><label><input type="checkbox" name="tags[]" value="<?php echo $pt['id']; ?>"/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="ele multi-checkbox mb0 display-2 dn">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['esfsppt'])) foreach($this->allTag['esfsppt'] as $pt): ?>
                            <li><label><input type="checkbox" name="tags[]" value="<?php echo $pt['id']; ?>"/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="ele multi-checkbox mb0 display-3 dn">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['esfxzlpt'])) foreach($this->allTag['esfxzlpt'] as $pt): ?>
                            <li><label><input type="checkbox" name="tags[]" value="<?php echo $pt['id']; ?>"/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="b1 b4 my-edit-content">
        <div class="sub-title">求购详情（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-input ele-house-title">
                <div class="label"><span class="em">*</span> 求购标题</div>
                <div class="option">
                    <input class="u-input w400" type="text" name="title" placeholder="用简单明了的文字说出房源的特色" datatype="*1-40" errormsg="最多输入40个字" nullmsg="请输入标题" />
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele">
                <div class="label"><span class="em"></span> 求购描述</div>
                <div class="option">
                    <div class="textarea ui-textarea">
                        <textarea name="content" cols="30" rows="10"></textarea>
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
$js = "var realPhone = '{$this->user->phone}';";
Yii::app()->clientScript->registerScript(__CLASS__.'#js',$js,CClientScript::POS_END);
?>