
<form action="<?php echo site_url('customer/check_customer')?>" id="login-form" method="post">
	<div class="con">
		<div class="Box BBox BBBox" style="height:540px;">
			<div class="bTop bbTop">
				<ul>
					<li class="cCurrent"><a href="#">账户登录</a></li>
				</ul>
				<p class="bp">
					未有账号，马上<span><a href="<?php echo site_url('customer/registration');?>">注册</a></span>
				</p>
			</div>
			<div class="bBox" style="display: block;">
				<ul id="login_input">
					<li>
						<p>用户名：</p>
						<input type="text" name="tbxLoginNickname" class="p1" id="account_name" placeholder="请输入账号">
					</li>
					<li class="mima-li">
						<p>密码：</p>
						<input type="password" name="tbxLoginPassword" id="password" class="p1" placeholder="请输入密码">
						<a href="javascript:void(0);" class="icon-zhuceiconmimabukejian13" id="mima-bukejian"></a>
						<a href="javascript:void(0);" class="icon-zhuceiconmimakejian21" id="mima-kejian"></a>
					</li>
				</ul>

				<div class="pp pppp">
					<label> <input type="checkbox" checked="checked"> 自动登录
						<p class="pp2">
							<a href="<?php echo site_url('customer/forget_password')?>">忘记密码？</a>
						</p>
					</label>
				</div>
				
				<div class="pp denglu_pp">
					<input type="submit" value="立即登录" class="p111">
				</div>

				<div class="tips" hidden>
					<div class="hline fl"></div>
					<div class="tiptext fl">或</div>
					<div class="hline fr"></div>
				</div>

				<div class="other" hidden>
					<div class="weixin">
						<a href="javascript:void(0);">微信扫描登录</a>
					</div>
				</div>

				<div class="pp">
					<p><?php echo $err_msg;?></p>
				</div>

				<!-- 扫码登录功能 s -->
				<div style="text-align: right;" class="pp" >
					<a id="wechat_code_login" href="<?php echo site_url('third_signin/wechat_code_login');?>" target="_Blank" >微信扫码登录</a><!-- &nbsp;|&nbsp; -->
					<a href="<?php echo site_url('customer/registration');?>" hidden>注册新帐号</a>
				</div>
				<div id="wechat_login_code" style="text-align: center; margin-left: 88px; margin-bottom: 20px;" hidden>
					<div id="qrcode"></div>
				</div>
				<!-- 扫码登录功能 e -->
			</div>

			<!-- 扫描二维码 开始 -->
            <div class="bBox" style="display: none;">
            	<div class="weixin-erweima">
            		<img src="images/logo-weixin-erweima.png" alt="">
            		<span>请使用微信扫描二维码登录51易货网</span>
            	</div>

				<div class="tips2">
					<div class="hline2 fl"></div>
					<div class="tiptext2 fl">或</div>
					<div class="hline2 fr"></div>
				</div>

				<div class="pp denglu_pp">
					<input type="submit" value="账号密码登录" class="zhanghao-logo">
				</div>
            </div>
			<!-- 扫描二维码 结束 -->

			<!-- 绑定手机号 开始 -->
			 <div class="bBox bBox2" style="display: none;">
				<div class="logo-bangding-shouji">
					<div><span class="jinggao icon-gantanhao"></span><span class="jinggao-text">您需要先绑定51易货网账号才能进行更多操作</span></div>
					<div class="bangding-shoujihao">
						<ul id="login_input">
					      <li>
						   <p>绑定手机号:</p>
						   <input type="text"  class="p2" placeholder="请输入手机号码" maxlength="11" onkeyup='this.value=this.value.replace(/\D/gi,"")'>
					     </li>
				        </ul>
					</div>
					<div class="pp3 denglu_pp">
					   <input type="submit" value="下一步" class="zhanghao-logo2">
				    </div>
				</div>
			 </div>
			<!-- 绑定手机号 结束 -->

			<!-- 绑定手机号下一步 开始 -->
			<div class="bBox bBox2" style="display: none;">
				<div class="logo-bangding-shouji">
					<div><span class="jinggao icon-gantanhao"></span><span class="jinggao-text">您需要先绑定51易货网账号才能进行更多操作</span></div>
					<div class="bangding-shoujihao">
						<ul id="login_input">
					      <li class="huoqu-li">
						   <p>验证码:</p>
						   <input type="text"  class="p4" placeholder="请输入手机验证码" maxlength="6" onkeyup='this.value=this.value.replace(/\D/gi,"")'>
						  <span class="huoqu-haoma"><span class="huoqu-haoma-text">重新获取验证码</span><span class="huoqu-haoma-time">(60s)</span></span>
					     </li>
					     <li class="mima-li">
						<p>密码设置：</p>
						<input type="password" name="tbxLoginPassword1" id="password1" class="p1" maxlength="16"  placeholder="6-16位数字/英文字母组成">
						<a href="javascript:void(0);" class="icon-zhuceiconmimabukejian13" id="mima-bukejian1"></a>
						<a href="javascript:void(0);" class="icon-zhuceiconmimakejian21" id="mima-kejian1"></a>
					</li>
				        </ul>
					</div>
					<div class="pp3 denglu_pp">
					   <input type="submit" value="确定" class="zhanghao-logo2">
				    </div>
				</div>
			 </div>
			<!-- 绑定手机号下一步 结束 -->


			<!-- 绑定成功 开始 -->
			<div class="bBox" style="display:none;">
				<div class="bangding-ok">
					<span class="bangding-icon icon-chenggong"></span>
				    <div class="bangding-ok-text">绑定成功，马上跳转到 <a href="<?php echo site_url("home");?>">首页</a>  <span>( 9s )</span></div>
				</div>
			</div>
			<!-- 绑定成功 结束	 -->

		</div>
	</div>
</form>

<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
<script type="text/javascript">

$("#wechat_login_code").on("click",function(){
	document.getElementById('qrcode').innerHTML = '';
	$("#login_input").show();
	$(".pp").show();
	$("#wechat_login_code").hide();
})
    // 密码可见与不可见
	  $("#mima-bukejian").on("click",function(){
	  	$("#password").attr('type', 'text');
	  	$("#mima-kejian").css("display","block");
	  })
	  $("#mima-kejian").on("click",function(){
	  	$("#password").attr('type', 'password');
	  	$("#mima-kejian").css("display","none");
	  })

	  	  $("#mima-bukejian1").on("click",function(){
	  	$("#password1").attr('type', 'text');
	  	$("#mima-kejian1").css("display","block");
	  })
	  $("#mima-kejian1").on("click",function(){
	  	$("#password1").attr('type', 'password');
	  	$("#mima-kejian1").css("display","none");
	  })

	  $(".huoqu-haoma").on("click",function(){
	  	$(".huoqu-haoma-text").css("line-height","0");
	  	$(".huoqu-haoma").css("background","#DCDCDC");
	  	$(".huoqu-haoma-text").css("color","#fff");
	  	$(".huoqu-haoma-time").css("display","block");
	  })

</script>