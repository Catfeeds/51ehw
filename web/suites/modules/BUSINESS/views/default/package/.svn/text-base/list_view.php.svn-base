<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<title><?php echo $title;?></title>
</head>
<body>
	<form action="<?php echo site_url("package/send_package");?>" method="post"  name="red_form">
		<div class="send_box">
			<!--  class="red_envelope_top">
				<ul>
					<a href=""><li class="icon-fanhui"></li></a>
					<li>51易货网</li>
					<!--<li class="as_this"><a href=""><img src="images/dian09.png"></a> &nbsp;&nbsp; </li>
				</ul>
			</div> -->
			<div class="send_content">
				<h1>
					<span>红包个数</span><span class="send_last">个</span> 
					<input name="num" type="text"    oninput="if(value.length>2)value=value.slice(0,2)" placeholder="填写个数" pattern="[0-9]*" id="num_m"> 
				</h1>

				<h1 class="send_content_last">
					<span id="normal_package">单个金额</span>
					<span id="random_package" style="display: none">总金额</span>
					<span class="send_last">M</span> 
					<input name="per_m" type="number"   placeholder="输入金额" id="single_m"> 
				</h1>
				<h2 id="normal_text">
					当前为普通货包，<a onclick="change_normal(1)">改为拼手气货包</a>
				</h2>
				<textarea onfocus="this.value='恭喜发财，万事大吉！'" rows="3"
					placeholder="51易货网祝您新年快乐，万事如意！" name="desc"></textarea>
				<h4>
					<b id="total_m">0</b> &nbsp;M
				</h4>
				<input type="hidden" name="state" value="1" id="state">
				<a id="send_out"><h5 style="background:#d2cfcc">发红包</h5></a>
			</div>
		</div>
</body>
</html>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	//清空
	$("input[name=num]").val("");
	$("input[name=per_m]").val("");
	$("input[name=state]").val(1);// 红包类型
})


var per_m = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^[0-9]\.[0-9]([0-9])?$)/ //金额正则
var num = /(^[1-9][0-9]$)|(^[1-9]$)/;//红包数量

//验证数量
$("#num_m").keyup(function(){
	number = $("input[name=num]").val();
	if(num.test(number)){//可以
		check_send();
	}else{
		number = number.substring(0,number.length-1);
		$("input[name=num]").val(number);
	}
});

//验证金额
$("#single_m").keyup(function(){
	single_m = $("input[name=per_m]").val();
	if(!per_m.test(single_m)){//可以
		regular = /(^[1-9]([0-9]+)?(\.){1}?$)|(^[0-9]\.){1}$|^0$/;
		if(!regular.test(single_m) && single_m != "" && single_m != null){
			single_m = single_m.substring(0,single_m.length-1);
			$("input[name=per_m]").val(single_m);
		}else{
			$("#send_out").removeAttr("onclick").children().css("background","#d2cfcc");//不可以
			$("#total_m").text('0.00');
			return;
		}
	}
	check_send();
});



//改变红包类型
function change_normal(status){
    var number = $("input[name=num]").val();
    var price_m = $("input[name=per_m]").val();
    m_price = "";
	switch(status){
	   case 1:
		   html = '当前为拼手气货包，<a id="change_random">改为普通货包</a>';
		   $("#m_price").text("总金额");
		   $('#normal_text').attr("onclick","change_normal(2)").html(html);

		   if(price_m !="" && number!=""){
			   m_price = (price_m*number).toFixed(2);//总金额
		   }
		   
		   $("input[name=state]").val(2);// 红包类型
		   break;
	   case 2:
		   html = '当前为普通货包，<a id="change_normal">改为拼手气货包</a>';
		   $("#m_price").text("单个金额");
		   $('#normal_text').attr("onclick","change_normal(1)").html(html);

		   if(price_m !="" && number!=""){
			   m_price = (price_m/number).toFixed(2);//单个金额
		   }
		   $("input[name=state]").val(1);// 红包类型
		   break;
	   default:
		   window.location.reload();
		   break;
	}

    //赋值	   
    $("#m_price").next().next().text(m_price);
    $("input[name=per_m]").val(m_price);
    check_send();//检查是否能发送
}

//检查是否可以发送
function check_send(){
	red = $("input[name=state]").val();// 红包类型
	number = Number($("input[name=num]").val());
	price_m = Number($("input[name=per_m]").val());
	//判断是否可以发送
	if(per_m.test(price_m) && num.test(number)){//可以
		//保证手气红包每个用户最少获得0.01
		if(red==2 && (price_m/number) < 0.01){
			$("#send_out").removeAttr("onclick").children().css("background","#d2cfcc");//不可以
			$("#total_m").text('0.00');
			return;
		}
		$("#send_out").attr("onclick","send()").children().css("background","#72c312");//可以
	}else{
		$("#send_out").removeAttr("onclick").children().css("background","#d2cfcc");//不可以
		$("#total_m").text('0.00');
		return;
	}

    //计算总额
    switch(red){
        case "1":
        	total = price_m*number;
            break;
        case "2":
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
	document.red_form.submit();
}

</script>







