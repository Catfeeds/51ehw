<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
    <link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
    <link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<body>
<form action="<?php echo site_url("package/save_mobile/".$package_id);?>" method="post" name="form1">
    <div class="red_envelope_header">
        <!-- <div class="red_envelope_top">
            <ul>
                <a href=""><li class="icon-fanhui"></li></a>
                <li>51易货网</li>
            </ul>
        </div> -->
        <div class="envelope_content envelope_two">
            <img src="images/yihuohongma5.png">
            <input placeholder="请输入您的手机号获取红包" name="mobile" type="number" pattern="[0-9]*" dir="rtl">
            <a href="javascript:document.form1.submit();"><span>领取货豆</span></a>
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