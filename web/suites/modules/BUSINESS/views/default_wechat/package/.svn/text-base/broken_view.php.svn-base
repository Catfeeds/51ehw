<style type="text/css">
	.container {background:rgba(0,0,0,1);}
</style>
<link rel="stylesheet" type="text/css" href="css/animate.css">

<!-- 领取红包 -->
<div class="get_red_packet">
  <div class="get_red_packet_box"> 
      <div class="get_red_head">
        <!-- <span class="icon-close close_but" onclick="history.back(-1);"></span> -->
        <div class="user_head_portrait"><img src="<?php echo $sender['wechat_avatar'];?>" alt="" onerror='this.src="images/head.png"'></div>


       <div style="padding-top: 70px;">
        <span class="packet_user_name"><?php echo $sender['wechat_nickname']?$sender['wechat_nickname']:$sender['nick_name'];?></span>
        <span class="packet_user_send">发易货红包了</span>
        <span class="packet_user_text">恭喜發財，大吉大利</span>
       </div>
        <a href="javascript:void(0);" class="red_packet_send_but">開</a>
      </div>
      <div class="look_get_details"><a href="javascript:void(0);"></a></div>
  </div>
</div>



 


<script type="text/javascript">
  var window_height = $(window).height();
  // var height_box  = $(".get_red_packet_box").height();
  $(".get_red_packet").css("padding-top",(window_height - 433)/2);
  // var portrait_width = $(".user_head_portrait").width();
  // $(".user_head_portrait").height(portrait_width);

  $(".get_red_packet").addClass('bounceIn');

  // 点击 开 如果没有红包
  $(".red_packet_send_but").on("click",function(){
     // 添加动画css
     $(".red_packet_send_but").addClass('chai02');
     // 延迟1.5s执行
     setTimeout(function () { 
 	    window.location.href="<?php echo site_url("package/get_package/".$package_id);?>";
     }, 1500);

  })

 

</script>






