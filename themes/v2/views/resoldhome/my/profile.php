<?php
$this->pageTitle = '个人资料';
?>
<div class="my-account-mod">
    <div class="gtitle">设置个人资料</div>
    <div class="user-info">
            <div class="ele">
                <div class="label">用户名：</div>
                <div class="option"><?php echo $this->user->username; ?></div>
            </div>
            <div class="ele">
                <div class="label">密码：</div>
                <div class="option">********<a class="edit-pwd" href="<?php  echo Yii::app()->uc->getUpdatePwdPageUrl($this->currentUrl);?>">修改密码</a></div>
            </div>
            <div class="ele">
                <div class="label">手机号码：</div>
                <div class="option">
                    <?php if($this->user->phone){ ?>
                        <span class="phone"><?php echo $this->user->phone ; ?></span>
                        <span class="state">已绑定</span>
                        <a href="<?php  echo Yii::app()->uc->getUpdatePhonePageUrl($this->currentUrl.'?update=phone');?>" class="edit-phone">更换手机号码</a>
                        <?php }else{ ?>
                        <span class="phone">未绑定</span>
                        <a href="<?php  echo Yii::app()->uc->getUpdatePhonePageUrl($this->currentUrl.'?update=phone');?>" class="edit-phone">绑定手机号</a>
                    <?php  } ?>
                </div>
            </div>
    </div>
</div>
