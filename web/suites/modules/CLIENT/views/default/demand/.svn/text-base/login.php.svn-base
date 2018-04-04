
<form action="<?php echo site_url('customer/check_customer')?>"
	id="login-form" method="post">
	<div class="con">
		<div class="Box BBox BBBox">
			<div class="bTop bbTop">
				<ul>
					<li class="cCurrent"><a href="#">账户登录</a></li>
				</ul>
				<p class="bp">
					未有账号，马上<span><a
						href="<?php echo site_url('customer/registration');?>"> 注册</a></span>
				</p>
			</div>
			<div class="bBox">
				<ul>
					<li>
						<p>用户名：</p> <input type="text" name="tbxLoginNickname" class="p1" id="account_name">
					</li>
					<li>
						<p>密码：</p> <input type="password" name="tbxLoginPassword" id="password" class="p1">
					</li>
				</ul><!--
				<div class="message2">
					<div class="mQing1">
						<p>验证码：</p>
						<div class="message1">
							<input type="text" name="name" class="p2"> <img src=<?php echo site_url('customer/yzm_img'); ?>>
						</div>
					</div>
					<div class="mQing2">
						<p>看不清？</p>
						<a href="<?php echo site_url("");?>"><span class="mBox">换一张</span></a>
					</div>
				</div> -->
				<div class="pp pppp">
					<label> <input type="checkbox" checked="checked"> 自动登录
						<p class="pp2">
							<a href="<?php echo site_url('customer/forget_password')?>"> 忘记密码？</a>
						</p>
					</label>
				</div>
				<div class="pp denglu_pp">
					<input type="submit" value="立即登录" class="p111">
				</div>
				<div class="pp">
					<p><?php echo $err_msg;?></p>
				</div>
                <!--前期隐藏功能 开始--><!--
				<div class="tips">
					<div class="hline fl"></div>
					<div class="tiptext fl">或</div>
					<div class="hline fr"></div>
				</div>
				<div class="other">
					<div class="weixin">
						<a href="javascript:location='<?php echo site_url('third_signin/wechat')?>'">微信登录</a>
					</div>
					<div class="pay">
						<a href="javascript:location='<?php echo site_url('third_signin/alipay')?>'">支付宝登录</a>
					</div>
				</div> -->
				<!--前期隐藏功能 结束-->
			</div>


		</div>

	</div>
</form>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'>您的账户未通过企业认证，企业认证能够更好的帮助您</p>
          <p>找到想要的产品</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;margin-left: 200px;"><a onclick=hiding()>继续发布</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">前去认证</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->