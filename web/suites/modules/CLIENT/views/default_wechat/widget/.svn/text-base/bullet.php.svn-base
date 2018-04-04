
<style type="text/css">
    a {text-decoration: none;}
    .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:0.5;}
	.h5-forget { z-index: 999;position: fixed;width: 295px;height: 180px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -90px;left: 50%;margin-left: -150px;}
	.h5-lose { z-index: 999;float: right;margin-top: -15px;margin-right: -15px;}
	.forget-password {width: 265px;margin: 48px auto;text-align: center;}
	.password-text span {line-height: 30px;font-size: 16px;color: #333;}
	.password-button {height: 40px;width: 100%;background-color: #fe4101;color: #fff!important;text-align: center;margin-top: 20px;line-height: 40px;font-size: 20px;color: #373422;display: inline-block;}
	.h5-forget2 { z-index: 999;position: fixed;width: 295px;height: 248px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -124px;left: 50%;margin-left: -150px;}
	.forget2-password {width: 265px;margin: 30px auto;text-align: center;}
	.mima-forget {border: 1px solid #E8E8E8;height: 25px;width: 150px;margin-left: 20px;outline: none;}
	.float-left {float: left;margin-left: 10px;}
	.dingdan-num {display: inline-block;margin-left: -15px;}
	.diagndan-monery {display: inline-block;margin-left: -70px;}
	.no-monery {float: left;margin-top: 25px;color: #000000;}
	.no-mima {float: right;margin-top: 25px;color: #000000;}
</style>

<div style="z-index: 997;">
    <!-- 颜色层 -->
    <div class="color-bg" hidden></div>
    <?php 
    switch (isset($bullet_set)?$bullet_set:"0"){
    	case 1:{
    	    // 跳转设置支付密码弹窗
    ?>
    <div class="h5-forget" id="skip_bullet" hidden>
        <div class="h5-lose">
        	<img src="images/51h5-lose.png" id="close_img" height="34" width="34">
        </div>
    	<div class="forget-password">
    		<div class="password-text">
    		  <span>亲，您还没有设置支付密码，您要先 设置支付密码才能支付哦</span>
    		</div>
    		<a href="<?php echo site_url("member/info/paypwd_edit");?>" class="password-button">设置</a>
    	</div>
    </div>
    <?php
            break;
       }
        case 2:{
    	    // 
    ?>
    
    <?php
            break;
       }
        case 3:{
    	// 订单支付窗口
    ?>
	<div class="h5-forget2" id="pay_bullet" hidden>
		<div class="h5-lose">
			<img src="images/51h5-lose.png" height="34" width="34">
		</div>
		<div class="forget2-password">
			<div class="password-text">
				<div id="order_sn_text">
					<span class="float-left"><span style="opacity: 0;">补</span>订单号：</span><span class="dingdan-num" id="order_sn">-------------</span>
				</div>
				<div id="order_money_text" style="margin-top: 5px;">
					<span class="float-left">订单金额：</span><span class="diagndan-monery" id='price'>0.00货豆</span>
				</div>
				<div style="margin-top: 5px;">
					<span class="float-left">支付密码：</span><input type="password" value="" class="mima-forget" name="pay_passwd">
				</div>
			</div>
			<a href="javascript:void(0);" class="password-button" id="pay_">确定支付</a>
			<div>
				<a href="javascript:void(0);" class="no-monery" id="wechat_pay" hidden>没有余额，用微信支付</a>
				<a href="<?php echo site_url("member/info/paypwd_edit")?>" class="no-mima">忘记密码</a>
			</div>
		</div>
	</div>
	<?php
            break;
        }
    }
    ?>
    
    <!-- 通用确认操作 eg：清空浏览记录 -->
    <div class="h5-forget" id="just_sure" hidden>
        <div class="h5-lose">
        	<img src="images/51h5-lose.png" height="34" width="34">
        </div>
    	<div class="forget-password">
    		<div class="password-text">
    		  <span id="sure_test"><?php echo isset($question)?$question:"确认操作？";?></span>
    		</div>
    		<a href="javascript:void(0);" class="password-button" id="sure_submit">确定</a>
    	</div>
    </div>
</div>

<!-- 关闭事件 -->
<script>
$(".h5-lose").on("click",function(){
	$(".color-bg").hide();
	$("#just_sure").hide();
	$("#skip_bullet").hide();
	$("#pay_bullet").hide();
})
</script>
