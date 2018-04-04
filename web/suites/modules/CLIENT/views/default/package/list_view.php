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
<title>51易货网</title>
</head>
<body>
	<form action="<?php echo site_url("package/send_package");?>"
		method="post" onsubmit="javascript:return send();" name="red_form">
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
					<span>红包个数</span><span class="send_last">个</span> <input name="num"
						type="number" pattern="[0-9]*" dir="rtl" placeholder="填写个数"
						id="num_m"> <span id="error_num" style="display: none">红包个数错误！</span>
				</h1>
				<h1 class="send_content_last">
					<span id="normal_package">单个金额</span>
					<span id="random_package" style="display: none">总金额</span>
					<span class="send_last">M</span> <input
						name="per_m" type="number" pattern="[0-9]*" dir="rtl"
						placeholder="输入金额" id="single_m"> <span id="error_single"
						style="display: none">单个金额错误！</span>
				</h1>
				<h2 id="normal_text">
					当前为普通货包，<a id="change_normal">改为拼手气货包</a>
				</h2>
				<h2 id="random_text" style="display: none">
					当前为拼手气货包，<a id="change_random">改为普通货包</a>
				</h2>
				<textarea onfocus="this.value='恭喜发财，万事大吉！'" rows="3"
					placeholder="51易货网祝您新年快乐，万事如意！" name="desc"></textarea>
				<h4>
					<b id="total_m">0</b>&nbsp;M 
				</h4>
				<input type="hidden" name="state" value="1" id="state">
				<a id="send_out"><h5>发红包</h5></a>
			</div>
		</div>

</body>
</html>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("#num_m").keyup(function(){
		if(!isNaN($("#single_m").val())){
			if($('#state').val() == '1'){
				$("#total_m").text($("#num_m").val()*$("#single_m").val());
			}else{
				$("#total_m").text($("#single_m").val());
			}
		}
	});

	$("#single_m").keyup(function(){
		if(!isNaN($("#num_m").val())){
			if($('#state').val() == '1'){
				$("#total_m").text($("#num_m").val()*$("#single_m").val());
			}else{
				$("#total_m").text($("#single_m").val());
			}
		}
	});

	$("#change_normal").click(function(){
		$('#random_package').css('display','block');
		$('#normal_package').css('display','none');
		$('#random_text').css('display','block');
		$('#normal_text').css('display','none');
		$("#total_m").text($("#single_m").val());
		$('#state').val('2');
	});

	$("#change_random").click(function(){
		$('#random_package').css('display','none');
		$('#normal_package').css('display','block');
		$('#random_text').css('display','none');
		$('#normal_text').css('display','block');
		$("#total_m").text($("#num_m").val()*$("#single_m").val());
		$('#state').val('1');
	});

	$("#send_out").click(function(){
		if($('#state').val() == '2'){
			if($("#single_m").val() / $("#num_m").val() < 1){
				alert('单个货包金额不可低于1货豆，请重新填写金额');
				return false;
			}else{
				document.red_form.submit();
			}
		}
		else if($('#state').val() == '1'){
			document.red_form.submit();
		}

	});
});
</script>







