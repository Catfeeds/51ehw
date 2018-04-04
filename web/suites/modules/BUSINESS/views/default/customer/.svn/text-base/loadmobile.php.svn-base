<form action="<?php echo site_url('customer/save_mobile_wechat')?>" id="login-form" method="post" name="form1" >
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
			<!-- 绑定手机号 开始 -->
			 <div class="bBox bBox2"  style="display: block;" id="bangding-box">
				<div class="logo-bangding-shouji">
					<div><span class="jinggao icon-gantanhao"></span><span class="jinggao-text">您需要先绑定51易货网账号才能进行更多操作</span></div>
					<div class="bangding-shoujihao">
						<ul id="login_input" style="width:520px;">
					      <li style="width:520px;">
						   <p style="float:left;">绑定手机号:&nbsp;&nbsp;</p>
						   <span class="eh_msgerror icon-cha" style="display: none;float:right;font-size: 13px;padding-top: 6px;" id="bingdingMobile"></span>
						   <input type="text" style="float:left;" class="p2" name="tbxBindingMobile" id="tbxBindingMobile" placeholder="请输入手机号码" maxlength="11" onkeyup='this.value=this.value.replace(/\D/gi,"")'>
						   
					     </li>
				        </ul>
					</div>
					<div class="pp3 denglu_pp">
					   <input type="button" value="下一步" id ="loadmobile" class="zhanghao-logo2">
				    </div>
				</div>
			 </div>
			<!-- 绑定手机号 结束 -->

			<!-- 绑定手机号下一步 开始 -->
			<div class="bBox bBox2" id="bangding-box2" style="display: none;">
				<div class="logo-bangding-shouji">
					<div><span class="jinggao icon-gantanhao"></span><span class="jinggao-text">您需要先绑定51易货网账号才能进行更多操作</span></div>
					<div class="bangding-shoujihao">
						<ul id="login_input">
						
						 <li class="huoqu-li" >
						   <p>验证码:</p>
						   <input type="text"  class="p4" autocomplete = "off" placeholder="请输入手机验证码" name="bingdingcode"  maxlength="6" onkeyup='this.value=this.value.replace(/\D/gi,"")'>
						   <span class="huoqu-haoma"><span class="huoqu-haoma-text" style="font-size: 14px;">获取验证码</span></span>
						   <span class="eh_msgerror icon-cha" style="display: none;" ></span>
					     </li>
					     <li class="mima-li"  id="mima1">
							<p>密码设置：</p>
							<input type="password" id="tbxLoginPassword" name="tbxLoginPassword" autocomplete = "off" id="password1" onblur="pwdonblur();"  class="p1" maxlength="16" onkeyup='value=value.replace(/[^\w\.\/]/ig,"")' placeholder="6-16位数字/英文字母组成">
							<span class="eh_msgerror icon-cha" style="display: none;float:right;font-size: 13px;padding-top: 6px;" id="bingdingpwd"></span>
							<a href="javascript:void(0);" class="icon-zhuceiconmimabukejian13" id="mima-bukejian1"></a>
							<a href="javascript:void(0);" class="icon-zhuceiconmimakejian21" id="mima-kejian1"></a>
						 </li>
						
					      
				        </ul>
					</div>
					<div class="pp3 denglu_pp">
					   <input type="button" id="submit1" value="确定" class="zhanghao-logo2">
				    </div>
				</div>
			 </div>
			<!-- 绑定手机号下一步 结束 -->


			<!-- 绑定成功 开始 -->
			<div class="bBox" style="display:none;">
				<div class="bangding-ok">
					<span class="bangding-icon icon-chenggong"></span>
				    <div class="bangding-ok-text">绑定成功，马上跳转到 <a href="javascript:void(0);">首页</a>  <span>( 9s )</span></div>
				</div>
			</div>
			<!-- 绑定成功 结束	 -->

		</div>
	</div>
</form>

<script src="js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/verificationCode.js"></script> -->
<script type="text/javascript">
 
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
  
  //密码判断
  function pwdonblur(){
	    var passwd = $('#tbxLoginPassword').val();
	  	var partten_passwd  = /^[a-zA-Z0-9]{6,16}$/;
	  	if(passwd==''||!partten_passwd.test(passwd)){
			$('#bingdingpwd').attr("class","onError");
	        $('#bingdingpwd').html("密码长度只能在6-16位字符之间,<br>只能由英文、数字及“_”、“-”组成");
	        $('#bingdingpwd').show();
			return;
		}
	
	  }
 //定义获取验证码按钮可点击状态
  var click = true;
	// 获取验证码
  $(".huoqu-haoma").on("click",function(){
	  if(click){
		  var mobile = $('#tbxBindingMobile').val();
			$.ajax({
			    url: base_url+'/customer/ajax_send/3',
			    type: 'POST',
			    data:{
				    mobile:mobile
				    },
			    dataType: 'html',
			    success: function(data){
				    alert('发送成功！');
				    click = false;
			    	$('.huoqu-haoma-text').html('60S');
			    	timeprocess = setTimeout(remainTime,1000);
			    	},
			    error:function(){
			    	click = true;
					alert('网络出错，请重试！');
					return;
				}
			});
		  }
	
	
  })
function remainTime(){
	 $(".huoqu-haoma").css("background","#DCDCDC");
	var times = parseInt($('.huoqu-haoma-text').html());
	if(times < 1){
		$('.huoqu-haoma-text').html('重新获取验证码');
		$(".huoqu-haoma").css("background","#ACACAC");
		click = true;
		clearTimeout(timeprocess);
	}else{
		times -= 1;
		$('.huoqu-haoma-text').html(times+'S');
		timeprocess = setTimeout("remainTime()",1000);
	}
}
  $("#submit1").on("click",function(){
	  document.form1.submit();
   })
  $("#loadmobile").on("click",function(){
  	var name = $('#tbxBindingMobile').val();
  	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
    //验证手机
	if(name=='' || isNaN(name) || name.length!=11 || !partten_mobile.test(name)){
		$('#bingdingMobile').attr("class","onError");
        $('#bingdingMobile').html("请输入正确的手机号");
        $('#bingdingMobile').show();
		return;
	}else{

		$.ajax({
			url:'<?php echo site_url("customer/check_mobile_phone") ?>',
			dataType:'json',
			type:'get',
			data:{
		    	  mobile:name
				 },
			success:function(data){
				if(data['Result']){
					$("#bangding-box").hide();
				   	$("#bangding-box2").show();
				   	//显示密码输入框
				   	$("#mima1").css('display','block');
				  
				}else{
					$.ajax({
					    url:'<?php echo site_url("customer/check_mobile_binding_info") ?>',
					    dataType:'json',
					    type:'get',
					    data:{
				    	    mobile:name
						    },
						success:function(data){
						    if(data['Result']){
							   	$("#bangding-box").hide();
							   	$("#bangding-box2").show();
								//隐藏密码输入框
							   	$("#mima1").css('display','none');
						    }else{
								$('#bingdingMobile').attr("class","onError");
			                    $('#bingdingMobile').html("该手机号码已绑定微信");
			                    $('#bingdingMobile').show();
								return;
						    }
						},
					    error:function(){
							alert('网络出错，请重试！');
							return;
						}
						})
					
					}
				},
				error:function(){
					alert('网络出错，请重试！');
					return;
				}
			})
		
		}


  })


</script>