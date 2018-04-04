<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
    <link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
    <link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<title></title>
</head>
<body>

<div class="splie_env_header">
    <!-- <div class="red_envelope_top">
        <ul>
            <a href=""><li class="icon-fanhui"></li></a>
            <li>51易货网</li>
        </ul>
    </div> -->
    <div class="red_envelope_background">
        <div class="red_envelope_dis">
            <h1><img src="<?php echo IMAGE_URL.$sender['img_avatar'];?>"></h1>
            <h2><?php echo $sender['nick_name'];?></h2>
            <h3>发易货红包了</h3>
            <a href="<?php echo site_url("package/get_package/".$package_id);?>"><div class="chai" id="chai">
                <span id="broke">拆红包</span>
            </div></a>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
    var oChai = document.getElementById("chai");
    var oClose = document.getElementById("close");
    var oContainer = document.getElementById("container");

    oChai.onclick = function (){
        oChai.setAttribute("class", "rotate");
    }
    oClose.onclick = function (){
        oContainer.style.display = "none";
    }

    </script>
</html>
