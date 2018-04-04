<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo THEMEURL;?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/iconfont.css">
    <style>
        .envelope_content{background: url("../images/hongbao.png") repeat-x fixed top;}
    </style>
<body>
    <div class="box">
        <div class="envelope_header">
            <ul>
                <li class="icon-fanhui"></li>
                <li>51易货网</li>
                <li class="as_this"><a href=""><img src="../images/dian09.png"></a> &nbsp;&nbsp; </li>
            </ul>
        </div>
        <div class="envelope_content envelope_two">
            <img src="../images/hongbao3.png">
            <form action="<?php echo site_url("package/receive");?>" method="post" id='sunmit'>
            <input type="text" name="phone" placeholder="请输入您的手机号获取51易货M卷"  maxlength='11' onkeyup="value=this.value.replace(/\D+/g,'')">
            </form> 
            <a href="javascript:void(0)" onclick=submit()><span>领取优惠劵</span></a>
            <ul>
                <li>1.货包货豆新老用户共享 </li>
                <li>2.货豆货包将放入与手机号绑定的账户</li>
                <li>3.本活动最终解释权归美团外卖所有.</li>
            </ul>
        </div>
    </div>
</body>

</html>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
function submit(){
	var phone = $("input[name=phone]").val();
    var re = /^(((13[0-9]{1})|159|153)+\d{8})$/;

         if (re.test(phone)) {
             $('#sunmit').submit();
         } else {
             alert("请输入正确的手机号码");
         }

}
</script>
