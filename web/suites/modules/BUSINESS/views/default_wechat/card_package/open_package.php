<style type="text/css">
	body {background:rgba(0,0,0,1);}
</style>
<link rel="stylesheet" type="text/css" href="css/animate.css">

<!-- 领取红包 -->
<div class="get_red_packet">
  <div class="get_red_packet_box get_goods_packet_box"> 
      <div class="get_red_head get_goods_packet">
<!--         <span class="icon-close close_but"></span> -->
        <div class="user_head_portrait"><img src="<?php echo $sender['wechat_avatar'];?>" alt="" onerror='this.src="images/head.png"'></div>

        <div style="padding-top: 70px;">
          <span class="packet_user_name"><?php echo $sender['wechat_nickname']?$sender['wechat_nickname']:$sender['nick_name'];?></span>
          <span class="packet_user_send">发易货货包</span>
          <span class="packet_user_text"></span>
        </div>
        <a href="javascript:void(0);" class="red_packet_send_but goods_packet_send_but">開</a>
      </div>

<!--      <div class="look_get_details"><a href="javascript:void(0);">查看领取详情<span class="icon-right"></span></a></div> -->
  </div>
</div>





<script type="text/javascript">
  var window_height = $(window).height();
  var height_box  = $(".get_red_packet_box").height();
  $(".get_red_packet").css("padding-top",(window_height - height_box)/2);
   
  var portrait_width = $(".user_head_portrait img").width();
  $(".user_head_portrait img").height(portrait_width);


  $(".get_red_packet").addClass('bounceIn');


  // 点击 开 如果没有红包
  $(".red_packet_send_but").on("click",function(){
     // 添加动画css
     $(".red_packet_send_but").addClass('chai02');
     // 延迟2s执行
     setTimeout(function () { 
   	    window.location.href="<?php echo $url;?>";
     }, 2000);

  })
</script>




