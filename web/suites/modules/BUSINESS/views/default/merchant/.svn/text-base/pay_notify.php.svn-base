<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<link href="css/reset.css" rel="stylesheet" type="text/css"> 注释-->
<link href="css/theme/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/theme/style.css" rel="stylesheet" type="text/css">
<link href="css/theme/style_v2.css" rel="stylesheet" type="text/css">
<title>51易货网</title>
</head>
<body>

	<div class="Box member_Box clearfix">
         <!--货豆余额纪录开始-->
		<div class="huankuan_cmRight" style="display:block;width:100%;">
            <div class="huankuan_rTop_5" style="display: block">支付通知</div>
                <div class="transformation_1" >
                    <?php if(isset($code)){ ;?>
                         <span><img src="<?php echo $code == 1 ? 'images/success1.png' : 'images/fail.png'?>"></span>
                        <h5><?php echo isset($message) ? $message : '';?></h5>
                        <?php if($code == 1):?>
                            <?php 
                                echo '<script>
                                    setTimeout(function(){
                                       window.location.href="<?php echo site_url("corporate/info");?>"; 
                                   },2000);
                                </script>';
                            ?>
                        <?php endif;?>
                        <?php //redirect('corporate/info');?>
                    <?php }?> 
                  
                   <!-- <p><a href="<?php //echo site_url('member/property/get_list/2');?>">点击查看我的资产</a></p> -->

                 </div>
            </div>
        </div>
</body>
</html>
