<link rel="stylesheet" type="text/css" href="css/animate.css">
<!-- 领取红包 -->
<span id="get_red_packet" hidden>
<div class="get_red_packet" >
  <div class="get_red_packet_box get_goods_packet_box"> 
      <div class="get_red_head get_goods_packet">
        <!-- <span class="icon-close close_but" onclick="history.back(-1);"></span> -->
        <div class="user_head_portrait"><img src="<?php echo $sender['wechat_avatar'];?>" alt="" onerror='this.src="images/head.png"'></div>
        <div style="padding-top: 70px;">
          <span class="packet_user_name"><?php echo ($sender['wechat_nickname']?$sender['wechat_nickname']:$sender['nick_name']);?></span>
          <span class="packet_user_send">发易货货包</span>
          <span class="packet_user_text packet_user_text_active01">手慢了，货包派完了</span>
        </div>
      </div>
      <div class="look_get_details"><a href="javascript:void(0);" onclick="view();">查看领取详情<span class="icon-right"></span></a></div>
  </div>
</div>
</span>


<style type="text/css">
  .goods_packet_box {background: url(images/packet_goods_bg01.png);background-size: 100% 100%;}

</style>

<!-- 货包 -->
<span id="red_packet" hidden>
<div class="red_packet" >
    <div class="red_packet_box goods_packet_box">
        <div>
        <?php if($package["discount_type"] == 3 && $is_receive){?>
            <?php if($is_use){?>
            <div class="goods_packet_img package_hexiao" ><span>已核销</span><img src="images/hexiao.jpg" alt=""></div> <!-- 已核销 -->
            <?php }else{;?>
            <div class="goods_packet_img" id="code"></div>
            <?php };?>
        <?php }else{;?>
            <span class="user_red_packet_name user_goods_packet_name" style="display: none;">易货红包</span>
            <div class="goods_packet_img" ><img src="<?php echo IMAGE_URL.$package["coupon_image"]?>" alt=""></div>
        <?php };?>
         <!-- 现场核销 -->
            <?php if($package['discount_type']==3){;?>
            <div class="red_packet_but">
                <a href="<?php echo site_url("home");?>">进入商城</a>
                <a href="<?php echo site_url("Member/info");?>">个人中心</a>
            </div>
            <?php }else{;?>
            <!-- 普通 -->
            <div class="red_packet_but goods_packet_but" >
                <!-- 已使用 -->
                <?php if($is_use){?>
                <a href="javascript:void(0);" style="background:#dddddd;color:#aaaaaa;">已使用</a>
                <?php }else{;?>
                <a href="<?php echo site_url("Search/discount_goods/{$package["id"]}");?>">马上使用</a>
                <?php };?>
                <a href="<?php echo site_url("Corporate/card_package/my_package");?>">我的卡包</a>
            </div>
            <?php };?>
        
             <div class="get_goods_packet_explain">
                 <p>使用说明</p>
                 <?php echo $package["describe"];?>
             </div>
        </div>
    </div>
    <!-- 红包列表 -->
    <div class="red_packet_list">
    	<div class="red_packet_list_head">
    	  <span>已领取 <?php echo count($user);?>/<?php echo $total;?> 个</span>
    	</div>
    	<div class="red_packet_list_main">
    		<ul>
    		<?php foreach($user as $v){?>
    		    <li>
    		    	<img src="<?php echo $v["wechat_avatar"];?>" alt="" onerror="this.src='images/member_defult.png'">
    		    	<span class="red_packet_list_text"><i><?php echo $v["wechat_nickname"]?$v["wechat_nickname"]:$v["nick_name"]?></i><i><?php echo $v["collection_at"]?></i></span>
    		    </li>
		    <?php };?>
    		</ul>
    	</div>	
    </div>

</div>
</span>

<script type="text/javascript" src="js/qrcode.min.js"></script>
<script>
$(function(){
    <?php if($is_full && !$is_receive){;?>
    $("body").css("background","rgba(0,0,0,1)");
    $("#get_red_packet").show();
    <?php }else{;?>
    $("#red_packet").show();
    <?php };?> 


	
	<?php if($package["discount_type"] == 3 && $is_receive && !$is_use){?>
    	var str = "<?php echo  site_url('corporate/card_package/sure_verification/'.$id);?>";
    	var qrcode = new QRCode(document.getElementById("code"), {
    		width : 150,
    		height : 150
    	});
    	qrcode.makeCode(str);
	<?php }else if($package['discount_type'] != 3){;?>//不是现场货包执行
    	$(".get_goods_packet_explain").css("color","#333333");
        $(".goods_packet_box").css("background","#f6f6f6");
        // $(".goods_packet_box").css('background','url(images/packet_goods_bg01.png)'); 
        // $('.goods_packet_box').css('background-size','100% 100%');

	<?php };?>


	  var window_height = $(window).height();
	  var height_box  = $(".get_red_packet_box").height();
	  $(".get_red_packet").css("padding-top",(window_height - height_box)/2);
	  var portrait_width = $(".user_head_portrait img").width();
	  $(".user_head_portrait img").height(portrait_width);
	  $(".get_red_packet").addClass('bounceIn');

})


//查看详情
function view(){
	$("body").css("background","#fff");
	$('#get_red_packet').hide();
	$("#red_packet").show();
}
</script>