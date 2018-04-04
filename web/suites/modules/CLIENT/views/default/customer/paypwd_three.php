  
		<!--设置支付密码页面-->
        <div class="passwd_top">
        <div class="passwd_con">
           <p class="pay_t"><a href="<?php echo site_url("home");?>">首页</a> > <a href="<?php echo site_url("Member/info");?>">个人中心</a> > <a href="<?php echo site_url("Member/save_set");?>">安全设置</a> >  <a href="javascript:void(0);" class="pay_current">立即设置</a></p>
           <?php if(isset($type)&&$type=='pay'): ?>
            <img src="images/pay3.png">
            <img src="images/gou_8.png" class="gouzi">
            <h3>您的支付密码已设置成功</h3>
            <?php elseif(isset($type)&&$type=='mobile'): ?>
            <img src="images/mobile3.png">
            <img src="images/gou_8.png" class="gouzi">
            <h3>您的手机绑定成功</h3>
            <?php elseif(isset($type)&&$type=='updatepay'): ?>
            <img src="images/revise3.png">
            <img src="images/gou_8.png" class="gouzi">
            <h3>您的支付密码已修改成功</h3>
            <?php endif; ?>
            
            <div class="pay_link">
                <span>您可以返回<a href="<?php echo site_url('member/info') ?>" class="pay_links">个人中心</a>或去<a href="" class="pay_links">首页逛逛</a></span>
            </div>
        </div>
    </div>
