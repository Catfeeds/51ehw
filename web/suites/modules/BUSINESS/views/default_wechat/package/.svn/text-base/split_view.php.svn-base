<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
<base href="<?php echo THEMEURL;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
    <link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
    <link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<body>
<form action="<?php echo site_url("package/save_mobile/".$package_id);?>" method="post" id="form1">
    <div class="red_envelope_header">
        <!-- <div class="red_envelope_top">
            <ul>
                <a href=""><li class="icon-fanhui"></li></a>
                <li>51易货网</li>
            </ul>
        </div> -->
        <div class="envelope_content envelope_two">
            <img src="images/yihuohongma5.png">
            <input placeholder="请输入您的手机号获取红包" name="mobile" type="number" id="mobile" pattern="[0-9]*" >
            <a href="javascript:check_submit();"><span>领取提货权</span></a>
            <ul>
                <li>1.易货红包新老用户共享 </li>
                <li>2.易货红包将放入与手机号绑定的账户</li>
                <li>3.本活动最终解释权归51易货网所有.</li>
            </ul>
        </div>
    </div>
</form>
</body>

</html>
<script>
  //提交验证
  function check_submit(){
	  var mobile = document.getElementById("mobile").value;
	   if(mobile.search(/^[1][3|5|8][0-9]{9}$/)==-1){
		   alert("请输入正确的手机！");
		   }else{
			   document.getElementById("form1").submit();
			   }
	   
	  } 
</script> 