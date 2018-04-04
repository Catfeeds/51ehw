<!doctype html>
<html>
<head>
<base href="<?php echo base_url();?>">
<meta charset="UTF-8">
<meta name="keyword" content="51易货网,易货网,易货,没钱,三角债,解决现金采购">
<meta name="description" content="【51易货网】是一个应时代而生的提供以物易物服务的综合性电子商务服务平台，为中国广大企业主提供高效速配的易货服务。顺应国家现行大势，解决经济周期下行阶段困扰大中小企业的库存积压、产能过剩和销售下降等问题。我们将以全新模式为客户带来全方面的服务，致力于打造全新的专业易货交易模式，立志成为中国最大的易货及采购平台，希望广大企业积极参与，为企业的腾飞插上翅膀。">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="css/theme/reset.css">
<link rel="stylesheet" type="text/css" href="css/theme/style.css">
<link rel="stylesheet" type="text/css" href="css/theme/iconfont.css">
<script src="js/jquery.min.js"></script>
<title>51易货网</title>
<script>
$(document).ready(function(){
    if(parseInt($(window).width())>1080){
        $(".index_headers").show();
    }else{
        $(".index_header_phone").show();
    }
});  
</script>

</head>
<body style="background: #630505;height: auto;">
<form action="<?php echo site_url('customer/check_customer')?>" id="login-form" method="post" name="loginform">
<div class="index_headers" hidden>
        <img src="images/index_guanggao.jpg">
        <ul class="dengluer">
            <p>用户登录</p>
            <li><label>账  户:  <input type="text" class="login_input" name="tbxLoginNickname" placeholder="请输入账户名称"></label></li>
            <li class="index_passwords"><label>密   码:  <input type="password"  class="login_input" name="tbxLoginPassword" placeholder="请输入账户密码"></label></li>
            <a href="<?php echo site_url('customer/registration');?>"><span class="zhuche2">注册</span></a>
            <a href="javascript:document.loginform.submit();"><span class="denglu1">登录</span></a>
        </ul>
    </div>
</form>
<form action="<?php echo site_url('customer/check_customer')?>" id="login-form" method="post" name="loginform2">
    <div class="index_header_phone" hidden>
        <img src="images/index_guanggao_phone.jpg">
        <ul class="dengluers">
            <p>用户登录</p>
            <li><label>账  户:  <input type="text" class="login_input" name="tbxLoginNickname" placeholder="请输入账户名称"></label></li>
            <li class="index_passwords"><label>密   码:  <input type="password" class="login_input" name="tbxLoginPassword" placeholder="请输入账户密码"></label></li>
            <a href="<?php echo site_url('customer/registration');?>"><span class="zhuche2">注册</span></a>
            <a href="javascript:document.loginform2.submit();"><span class="denglu1">登录</span></a>
        </ul>
    </div>

</form>
</body>
</html>
