<?php 
$is_out = false;//识别是否领取完成
if(count($getter) == $package["num"]){
    $is_out = true;
}

$amount = 0;
$luckyuser = 0; 
foreach ($getter as $man){
    if($man["customer_id"]==$customer_id){
        $my_red = $man;
    }
    if($is_out && $man["amount"] > $amount && $package["type"] == 2){
        $amount = $man["amount"];
        $luckyuser = $man["customer_id"];
    }

}

;?>
<link rel="stylesheet" type="text/css" href="css/animate.css">
<!-- 领取红包 -->
<span id="get_red_packet" hidden>
    <div class="red_packet_ball_bg" ></div>
    <div class="get_red_packet" >
        <div class="get_red_packet_box"> 
            <div class="get_red_head">
                <!-- <span class="icon-close close_but" onclick="history.back(-1);"></span> -->
                <div class="user_head_portrait"><img src="<?php echo $sender['wechat_avatar'];?>" alt="" onerror='this.src="images/head.png"'></div>
                <div style="padding-top: 70px;">
                    <span class="packet_user_name"><?php echo $sender['wechat_nickname']?$sender['wechat_nickname']:$sender['nick_name'];?></span>
                    <span class="packet_user_text packet_user_text_active">手慢了，红包派完了</span>
                </div>
            </div>
            <div class="look_get_details"><a href="javascript:void(0);" onclick="view();" >查看领取详情<span class="icon-right"></span></a></div>
        </div>
    </div>
</span>

  
<!-- 红包 -->
<span id="red_packet" hidden>
<div class="red_packet" >
    <div class="red_packet_box">
    	<div class="red_packet_head">
            <span class='user_red_packet_name'><?php echo $sender['wechat_nickname']?$sender['wechat_nickname']:$sender['nick_name'];?>的易货红包</span>
            <img src="<?php echo $sender['wechat_avatar'];?>" alt="" onerror="this.src='images/member_defult.png'">
        </div> 
       <div class="red_packet_main">
            <?php if(!$is_full){;?>
   	        <span class="red_packet_money"><?php echo $my_red["amount"];?>M</span>
            <span class="red_packet_text">已存入钱包</span>
            <?php };?>
            <div class="red_packet_but">
             	<a href="<?php echo site_url('home');?>">进入商城</a>
             	<a href="<?php echo site_url('member/info');?>">个人中心</a>
            </div>
       </div>
    </div>
    <!-- 红包列表 -->
    <div class="red_packet_list">
    	<div class="red_packet_list_head">
            <!-- 红包被抢光 -->
	        <?php if($is_out){;?>
            <span><?php echo count($getter);?>个红包，已被抢光</span>
            <?php }else{;?>
            <!-- 红包没有被抢光 -->
            <span>已领取 <?php echo count($getter)."/".$package["num"];?>个</span>
            <?php };?>
    	</div>
    	<div class="red_packet_list_main">
    		<ul>
                <?php foreach ($getter as $man){;?>
    		    <li>
    		    	<img src="<?php echo $man['wechat_avatar'];?>" alt="" onerror="this.src='images/member_defult.png'">
    		    	<span class="red_packet_list_text"><i><?php echo $man['wechat_nickname']?$man['wechat_nickname']:$man['nick_name'];?></i><i><?php echo substr($man['receive_at'],5,5)." ".substr($man['receive_at'],10,6) ;?></i></span>
    		    	<span class="red_packet_list_money"><?php if($man['customer_id'] == $luckyuser){?><i class="icon-tubiao27"></i><i>手气最佳</i><?php };?><?php echo $man['amount'];?>M</span>
    		    </li>
    		    <?php };?>
    		</ul>
    	</div>	
    </div>
</div>
</span>


<script type="text/javascript">
$(function(){
	  <?php if($is_full){;?>
	  $("#get_red_packet").show();
	  $(".container").css("background","rgba(0,0,0,1)");
      $("body").css("background","rgba(0,0,0,1)");
	  $(".close_but").css("color","#C5222A");
	  <?php }else{;?>
	  $("#red_packet").show();
      $(".container").css("background","#fff");
      $("body").css("background","#fff");
	  <?php };?>;
	
	  var window_height = $(window).height();
	  // var height_box  = $(".get_red_packet_box").height();
	  $(".get_red_packet").css("padding-top",(window_height - 433)/2);
	   
	  // var portrait_width = $(".user_head_portrait img").width();
	  // $(".user_head_portrait img").height(portrait_width);
	  $(".get_red_packet").addClass('bounceIn');
	  // 点击 开 如果没有红包
	  $(".red_packet_send_but").on("click",function(){
	     // 添加动画css
	     $(".red_packet_send_but").addClass('chai02');
	  })

});

//查看详情
function view(){
	$(".container").css("background","#f6f6f6");
    $("body").css("background","#f6f6f6");
	$('#get_red_packet').hide();
	$("#red_packet").show();
}

</script>

