<?php
 $this->pageTitle = '我要出租';
?>

<div class="gtitle"><?php echo $this->pageTitle ; ?></div>
<div class="my-edit my-zu">
    <?php $form = $this->beginWidget('CActiveForm',array('action'=>$this->createUrl('/resoldhome/myzf/rentsave'),'htmlOptions'=>array('class'=>'valid-form')));  ?>
    <div class="b1 my-edit-contact">
        <div class="sub-title">联系方式（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 联 系 人</div>
                <div class="option gender">
                    <input class="u-input" type="text" value="<?php echo $this->user->username; ?>" name="username" datatype="*1-10" errormsg="最多输入10个字" nullmsg="请输入联系人"/>
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
    <div class="b1 my-edit-type">
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
    <div class="b3 my-edit-params my-zu-house">
        <div class="sub-title">发布方式（<span class="em">*</span>为必填）</div>
        <div class="form my-zu-house">
            <div class="ele ele-name ele-input">
                <div class="label"><span class="em">*</span> 楼盘名称</div>
                <div class="option">
                    <input type="hidden" class="u-input form-control js-plot-select2" data-name="" value="" name="hid" datatype="n" errormsg="无法找到小区" nullmsg="请输入小区名称" />
                    <span class="unit">（若没有匹配的小区，建议选择“其他小区”）</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-radios display-1">
                <div class="label"><span class="em">*</span> 出租方式</div>
                <div class="option u-radios">
                    <?php if(isset($this->allTag['zfmode'])) foreach($this->allTag['zfmode'] as $key => $zfmode): ?>
                        <label><input type="radio" name="rent_type" value="<?php echo $zfmode['id'];?>" <?php if($key == 0){echo 'checked';}?>/><span><?php echo $zfmode['name'];?></span></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="ele ele-select display-2 dn">
                <div class="label"><span class="em">*</span>类<span class="em2"></span>型</div>
                <div class="option">
                    <select name="esfzfsptype" data-width="197">
                        <?php if(isset($this->allTag['esfzfsptype'])) foreach($this->allTag['esfzfsptype'] as $type): ?>
                            <option value="<?php echo $type['id'];?>"><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select display-3 dn">
                <div class="label"><span class="em">*</span>类<span class="em2"></span>型</div>
                <div class="option">
                    <select name="esfzfxzltype" data-width="197">
                        <?php if(isset($this->allTag['esfzfxzltype'])) foreach($this->allTag['esfzfxzltype'] as $type): ?>
                            <option value="<?php echo $type['id'];?>"><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-huxing ele-input display-1">
                <div class="label"><span class="em">*</span> 户<span class="em2"></span>型</div>
                <div class="option">
                    <input type="text" name="bedroom" class="u-input" datatype="hx" data-name="卧室" nullmsg="请输入几室" /><span class="unit">室</span>
                    <input type="text" name="livingroom" class="u-input" datatype="hx" data-name="客厅" nullmsg="请输入几厅" /><span class="unit">厅</span>
                    <input type="text" name="bathroom" class="u-input" datatype="hx" data-name="卫生间" nullmsg="请输入几卫" /><span class="unit">卫</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 面<span class="em2"></span>积</div>
                <div class="option">
                    <input class="u-input w68" type="text" name="size" datatype="size" nullmsg="请输入产证面积" errormsg="产证面积要大于1平方米小于10000平方米"/><span class="unit">平米</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>

            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 楼<span class="em2"></span>层</div>
                <div class="option">
                    <input class="u-input w68" type="text" name="floor" data-name="楼层" datatype="floor" nullmsg="请输入楼层"/><span class="unit">层，共</span>
                    <input class="u-input w68" type="text" name="total_floor" data-name="总层数" datatype="floor,floors" nullmsg="请输入总层数"/><span class="unit"> 层（地下室楼层在数字前加“-”）</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>

            <div class="ele ele-input">
                <div class="label"><span class="em">*</span> 租<span class="em2"></span>金</div>
                <div class="option">
                    <input class="u-input" type="text" name="price" datatype="rent" nullmsg="请输入租金" errormsg="租金必须在0到1000000之间" ><span class="unit">元/月</span><span class="unit">（输入0元显示为面议）</span>
                    <div class="ui-errormsg"></div>
                </div>
            </div>

            <div class="ele multi-checkbox display-2 dn">
                <div class="label"><span class="em">*</span> 经营项目</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfspkjyxm'])) foreach($this->allTag['zfspkjyxm'] as $xm): ?>
                            <li><label><input datatype="jyxm" nullmsg="请选择经营项目" type="checkbox" name="zfspkjyxm[]" value="<?php echo $xm['id'];?>"/><?php echo $xm['name']?></label></li>
                        <?php endforeach; ?>
                        <div class="ui-errormsg"></div>
                    </ul>
                </div>
            </div>
            <div class="ele ele-input dn" id="wuye-fee">
                <div class="label"><span class="em"></span> 物<span class="em1_2"></span>业<span class="em1_2"></span>费</div>
                <div class="option">
                    <input class="u-input w98" type="text" name="wuye_fee" /><span class="unit">元/㎡</span>
                </div>
            </div>

            <div class="ele ele-select display-2 dn">
                <div class="label"><span class="em"></span> 级<span class="em2"></span>别</div>
                <select name="esfsplevel">
                    <option value="">不限</option>
                    <?php if(isset($this->allTag['esfsplevel'])) foreach($this->allTag['esfsplevel'] as $splevel): ?>
                        <option value="<?php echo $splevel['id'];?>"><?php echo $splevel['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ele ele-select display-3 dn">
                <div class="label"><span class="em"></span> 级<span class="em2"></span>别</div>
                <select name="zfxzllevel">
                    <option value="">不限</option>
                    <?php if(isset($this->allTag['zfxzllevel'])) foreach($this->allTag['zfxzllevel'] as $xzllevel): ?>
                        <option value="<?php echo $xzllevel['id'];?>"><?php echo $xzllevel['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="ele ele-select">
                <div class="label"><span class="em"></span> 朝<span class="em2"></span>向</div>
                <div class="option">
                    <select name="towards">
                        <option value="0">不限</option>
                        <?php if(isset($this->allTag['resoldface'])) foreach($this->allTag['resoldface'] as $cx): ?>
                            <option value="<?php echo $cx['id'];?>"><?php echo $cx['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select">
                <div class="label"><span class="em"></span> 装<span class="em2"></span>修</div>
                <div class="option">
                    <select name="decoration">
                        <option value="0">不限</option>
                        <?php if(isset($this->allTag['resoldzx'])) foreach($this->allTag['resoldzx'] as $zx): ?>
                            <option value="<?php echo $zx['id'];?>"><?php echo $zx['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="ele ele-select display-3">
                <div class="label"><span class="em"></span> 年<span class="em2"></span>代</div>
                <select name="age">
                    <option value="0">不限</option>
                    <?php for($i=date('Y');$i>=(date('Y')-20);$i--): ?>
                        <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select><span class="unit">年</span>
            </div>

            <div class="ele ele-input">
                <div class="label">付款方式</div>
                <div class="option">
                    <span class="unit">交</span>
                    <input type="text" class="u-input w68" name="pay_jiao">
                    <span class="unit">押</span>
                    <input type="text" class="u-input w68" name="pay_ya">
                </div>
            </div>
            <div class="ele multi-checkbox display-1">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfzzpt'])) foreach($this->allTag['zfzzpt'] as $pt): ?>
                            <li><label><input type="checkbox" name="zfzzpt[]" value="<?php echo $pt['id']; ?>"/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="ele multi-checkbox display-2 dn">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfsppt'])) foreach($this->allTag['zfsppt'] as $pt): ?>
                            <li><label><input type="checkbox" name="zfsppt[]" value="<?php echo $pt['id']; ?>"/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="ele multi-checkbox display-3 dn">
                <div class="label"><span class="em"></span> 配套设施</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfxzlpt'])) foreach($this->allTag['zfxzlpt'] as $pt): ?>
                            <li><label><input type="checkbox" name="zfxzlpt[]" value="<?php echo $pt['id']; ?>"/><?php echo $pt['name'];?></label></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>


            <div class="ele multi-checkbox mb0 display-1">
                <div class="label"><span class="em"></span> 房屋特色</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfzzts'])) foreach($this->allTag['zfzzts'] as $ts): ?>
                            <li><label><input datatype="ts" errormsg="特色最多可选择5个" type="checkbox" name="zfzzts[]" value="<?php echo $ts['id'];?>"/><?php echo $ts['name']?></label></li>
                        <?php endforeach; ?>
                        <div class="ui-errormsg"></div>
                    </ul>
                </div>
            </div>

            <div class="ele multi-checkbox mb0 display-2 dn">
                <div class="label"><span class="em"></span> 商铺特色</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfspts'])) foreach($this->allTag['zfspts'] as $ts): ?>
                            <li><label><input datatype="ts" errormsg="特色最多可选择5个" type="checkbox" name="zfspts[]" value="<?php echo $ts['id'];?>"/><?php echo $ts['name']?></label></li>
                        <?php endforeach; ?>
                        <div class="ui-errormsg"></div>
                    </ul>
                </div>
            </div>

            <div class="ele multi-checkbox mb0 display-3 dn">
                <div class="label"><span class="em"></span> 写字楼特色</div>
                <div class="option">
                    <ul>
                        <?php if(isset($this->allTag['zfxzlts'])) foreach($this->allTag['zfxzlts'] as $ts): ?>
                            <li><label><input datatype="ts" errormsg="特色最多可选择5个" type="checkbox" name="zfxzlts[]" value="<?php echo $ts['id'];?>"/><?php echo $ts['name']?></label></li>
                        <?php endforeach; ?>
                        <div class="ui-errormsg"></div>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="b4">
        <div class="sub-title">房源详情（<span class="em">*</span>为必填）</div>
        <div class="form">
            <div class="ele ele-input ele-house-title">
                <div class="label"><span class="em">*</span> 房源标题</div>
                <div class="option">
                    <input class="u-input w400" type="text" name="title" placeholder="用简单明了的文字说出房源的特色" datatype="*1-40" errormsg="最多输入40个字" nullmsg="请输入标题" />
                    <div class="ui-errormsg"></div>
                </div>
            </div>
            <div class="ele">
                <div class="label"><span class="em"></span> 房源自评</div>
                <div class="option">
                    <div class="textarea ui-textarea">
                        <textarea name="content" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="ele ui-load-img ele-input">
                <div class="label"><span class="em"></span> 图片上传</div>
                <div class="option">
                    <div class="u-file">
                        <!--                        <div class="select-img">请选择图片上传</div><div class="select-btn">浏览文件</div>-->
                        <?php $this->widget('ResoldHomeUpload',array('file_name'=>'images[]', 'multi'=>true, 'width'=>150,'height'=>150,'mode'=>2)); ?>
                        <div class="tip">
                            <div class="p1">选择文件后，点击上传按钮，上传图片<span class="warn">（点击已上传图片可以设置封面）</span></div>
                            <div class="p2"><span class="warn">上传真实的照片 有利于你的成交</span>，支持jpg、bmp、gif、png格式，每张最大2M</div>
                        </div>
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
    <?php $this->endWidget(); ?>
</div>
<?php
$js = "var realPhone = '{$this->user->phone}';";
Yii::app()->clientScript->registerScript(__CLASS__.'#js',$js,CClientScript::POS_END);
?>