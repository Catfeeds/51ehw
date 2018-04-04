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

			<!-- 绑定成功 开始 -->
			<div class="bBox" style="display: block;">
				<div class="bangding-ok">
					<span class="bangding-icon icon-chenggong"></span>
				    <div class="bangding-ok-text">绑定成功，马上跳转到 <a href="<?php echo site_url("home");?>">首页</a>  <span id="times">( 9s )</span></div>
				</div>
			</div>
			<!-- 绑定成功 结束	 -->
		</div>
	</div>

<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
<script type="text/javascript">

$('#times').html(5);
timeprocess = setTimeout(remainTime,1000);
function remainTime(){
	var times = $('#times').html();
	if(times < 1){
		window.location.href='<?php echo site_url('member/info');?>';
		clearTimeout(timeprocess);
	}else{
		times -= 1;
		$('#times').html(times);
		timeprocess = setTimeout("remainTime()",1000);
	}
}


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