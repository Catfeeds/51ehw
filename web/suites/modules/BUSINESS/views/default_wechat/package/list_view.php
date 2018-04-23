<style type="text/css">
	.container {background: #f6f6f6;}
	#send_out{background: #F4E8AA;color: #aaaaaa;}
	textarea  { box-shadow:0px 0px 0px rgba(0,0,0,0);-webkit-appearance:none;}
    .h5-forget2 {height: 200px;margin-top: -100px;}
</style>

<!-- 发红包 -->
<div class="send_red_packet">
    <div class="send_red_packet_main">
        <div class="send_input">
            <span class="send_red_money">总金额</span><div class="send_input_text"><input name="per_m" type="text" placeholder="0.00"  onkeyup="checkAmount();"></div><span>M</span>
        </div>
        <div class="send_text"><span>当前为拼手气红包，</span><span class='putong_packet'>改为普通红包</span></div>
        <input type="hidden" name="status" value="2" id="status"><!-- 类型 -->
        <div class="send_input">
            <span>红包个数</span><div class="send_input_text"><input name="num" type="text" placeholder="填写个数"  pattern="[0-9]*" onkeyup="checkNum();"></div><span>个</span>
        </div>
        <textarea placeholder="恭喜发财,大吉大利" id="desc"></textarea>
        <div class="send_money"><span>M</span><span id="total_m">0.00</span></div>
        <div class="send_buttom"><button id="send_out">塞提货权红包</button></div>
    </div>
</div>

<!-- 分享红包 -->
<div class="send_red_packet_share" hidden>
  <img src="images/share_bg.png" alt="">
</div>



<!--验证支付密码是否存在 默认隐藏-->
<div class="wrap_tanchuang" id="no-paswd" hidden>
     <div class="h5-forget">
     	<div class="h5-lose" onclick="$('#no-paswd').hide()">
			<img src="images/51h5-lose.png" height="34" width="34">
		</div>
    	 <div class="forget-password">
    		<div class="password-text">
    		  <span>亲，您还没有设置支付密码，您要先设置支付密码才能支付哦</span>
    		</div>
    		<a href="<?php echo site_url("Member/info/paypwd_edit");?>" class="password-button">设置</a>
    	</div>
	 </div>
</div>
  
<!-- 输入支付密码 -->
<div class="wrap_tanchuang" id="wrap_tanchuang" hidden>
	<div class="h5-forget2" id="pay_bullet" >
	<div class="h5-lose" onclick='$(".wrap_tanchuang").hide(); $("input[type=password]").val("");'>
		<img src="images/51h5-lose.png" height="34" width="34">
	</div>
	<div class="forget2-password">
		<div class="password-text">
			<div style="margin-top: 5px;">
				<span class="float-left">支付密码：</span>
				<input type="password"   class="mima-forget" value="">
			</div>
		</div>
		<a href="javascript:void(0);" class="password-button" id="pay_" onclick="send();">确定支付</a>
		<div>
			<a href="javascript:void(0);" class="no-monery" id="wechat_pay" hidden>没有余额，用微信支付</a>
			<a href="<?php echo site_url("member/info/paypwd_edit")?>" class="no-mima">忘记密码</a>
		</div>
	</div>
 </div>
</div>


<script type="text/javascript">
$(function(){
	//清空
	$("input[name=num]").val("");
	$("input[name=per_m]").val("");
	$("input[name=state]").val(1);// 红包类型
	
})

//把input光标跳转到最后
$("input[name=per_m]").click(function(){
	var per_m = $(this).val();
	$(this).val(per_m)
});

//红包类型切换
var num_but = 0;
$(".putong_packet").on("click",function(){
        var number = $("input[name=num]").val();
        var price_m = $("input[name=per_m]").val();


        num_but ++;
        if(num_but % 2 === 0) {  //偶数取余为0
            $(".putong_packet").html('改为普通红包');
            $(".send_red_money").html('总金额');
            $(".send_text").find("span:first-child").html("当前为拼手气红包，");
            $("#status").val(2);
        	var total = price_m*number;
        } else {
           $(".putong_packet").html('改为拼手气红包');
           $(".send_red_money").html('单个金额');
           $(".send_text").find("span:first-child").html("当前为普通红包，");
           $("#status").val(1);
           var total = price_m/number;
        }
        if(number && price_m){
        	$("input[name=per_m]").val(total.toFixed(2));
        }
        check_send();
})


var per_m = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^[0-9]\.[0-9]([0-9])?$)/ //金额正则
var num = /(^[1-9][0-9]$)|(^[1-9]$)/;//红包数量

//验证数量
function checkNum(){
	number = $("input[name=num]").val();
	if(!num.test(number)){//不可以
		number = number.substring(0,number.length-1);
		$("input[name=num]").val(number);
	}
	check_send();
}

//验证金额
function checkAmount(){
	single_m = $("input[name=per_m]").val();
	if(!per_m.test(single_m)){//可以
		regular = /(^[1-9]([0-9]+)?(\.){1}?$)|(^[0-9]\.){1}$|^0$/;
		if(!regular.test(single_m) && single_m != "" && single_m != null){
			single_m = single_m.substring(0,single_m.length-1);
			$("input[name=per_m]").val(single_m);
		}else{
			$("#send_out").css("background","#F4E8AA");//不可以
			$("#total_m").text('0.00');
			return;
		}
	}
	check_send();
}


//检查是否可以发送
function check_send(){
	red = $("#status").val();// 红包类型
	number = Number($("input[name=num]").val());
	price_m = Number($("input[name=per_m]").val());
	$("#send_out").removeAttr("onclick").css("background","#F4E8AA");//不可以
	$("#send_out").removeAttr("onclick").css("color","#aaaaaa");//不可以
	//判断是否可以发送
	if(per_m.test(price_m) && num.test(number) && (red==1 || red==2)){//可以
		var average = price_m/number;//平均
		
		if(red==2 && average < 0.01){//保证手气红包每个用户最少获得0.01
			$("#total_m").text('0.00');
			return;
		}
		
	}else{
		$("#total_m").text('0.00');
		return;
	}
	
	$("#send_out").attr("onclick","send()").css("background","#ffd600");//可以
	$("#send_out").attr("onclick","send()").css("color","#333");//可以

    //计算总额
    switch(red){
        case "1"://普通
        	total = price_m*number;
            break;
        case "2"://手气
        	total = price_m;
            break;
        default:
     	   window.location.reload();
        break;
    }
	$("#total_m").text(total.toFixed(2));
}

//发送卡包
function send(){
    $.post("<?php echo site_url("customer/check_pay_passwod");?>",function(data){
        if(data['status']== 1){
            window.location.href="<?php echo site_url("customer/login");?>";//没有登录
        }else if(data['status']== 2){
        	//支付密码
        	var password = $("input[type=password]").val();
        	if(!password){
        		$("#wrap_tanchuang").show();
        	    return;
        	}else if(password.length < 6){
        	    alert("请输入正确的支付密码！");
        	    return;
        	}
        	
        	var status = $("#status").val();// 红包类型
        	var num = $("input[name=num]").val();
        	var per_m = $("input[name=per_m]").val();
        	var desc = $("#desc").val();
        	if(!desc){
        		var desc = "恭喜发财,大吉大利";
        	}
        
        	$.post("<?php echo site_url("package/send_package");?>",{num:num,per_m:per_m,status:status,desc:desc,password:password},function(data){
        		if(data["status"]==2){
        	    	location.href="<?php echo site_url("package/share");?>"+"/"+data["id"];
        	    } else if(data["status"]==3){
        	    	alert("请输入正确的支付密码！");
        	    } else if(data["status"]==4){
        	    	alert("余额不足！");
        	    	window.location.reload();
        	    }else{
        	    	window.location.reload();
    	    	}
        	},"json");

        }else{
            //设置支付密码
            $("#no-paswd").show();
        }
    },"json");
}

</script>



<!-- 判断安卓苹果手机 -->
<script language="javascript">
window.onload = function () {
var u = navigator.userAgent;
if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
// alert("安卓手机");
} else if (u.indexOf('iPhone') > -1) {//苹果手机
	$(".send_input_text input").css("margin-top","-10px");
// alert("苹果手机");
} else if (u.indexOf('Windows Phone') > -1) {//winphone手机
// alert("winphone手机");
}
}
</script>


