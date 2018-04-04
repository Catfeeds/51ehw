<style type="text/css">
	.container {background-color: #f4f4f4!important;}
    .red_packet_box{background: #fff!important;}
</style>
<link rel="stylesheet" type="text/css" href="css/animate.css">
<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>
<!-- <div class="commodity_h50"></div> -->
<div class="commodity_detail">
	<div>
		<img src="<?php echo IMAGE_URL.$package["ad_image"]?>" alt="" onerror="this.src='images/discount_error.png'">
	</div>	
	<div class="commodity_detail_main">
		<div class="commodity_detail_main_title">
			<h3>货包类型：</h3>
			<?php if($package["discount_type"]==1){;?>
			<span><?php echo $package["discount"];?> 折优惠券</span>
			<?php }elseif($package["discount_type"]==2){;?>
			<span><?php echo $package["deduction_price"];?> 货豆抵用券</span>
			<?php }else{?>
			<span><?php echo $package["deduction_price"];?> 现场礼包</span>
			<?php }?>
		</div>
	</div>	

	<div class="commodity_detail_explain">
		<div class="commodity_detail_explain_title">
			<h3>使用说明：</h3>
			<div class="commodity_detail_explain_text">
			<span><?php echo $package["describe"]?></span>
			</div>
		</div>
	</div>	
	
</div>	
<?php 
if(!$mac_type){//H5
    if($index){//首页推荐
        if($status){//已领取详情
            if($package["discount_type"] == 3){
                $current_times = date("Y-m-d");
                if( $package['coupon_end_at'] >= $current_times &&  $current_times >= $package['coupon_start_at']){ ?>
                                <div class="red_packet" >
                                  <div class="red_packet_box goods_packet_box">
                    					<div>
                    					<div class="goods_packet_img" id="code"></div>
                    					</div>
                				 </div>
                				 </div>
         <?php      }
                        }else{
            switch($package['status']){
                case 1: ?>
           <!--      <div class="commodity_detail_send" style="margin-top: 5px;">
                	         <style>
                                    .commodity_detail_send{background:#a5a294;}
                             </style>
                              <a href="javascript:void(0);">已使用</a>
                </div>    -->            
    <?php           break;
                case 2:
                    $current_time = date("Y-m-d");
                if($package['coupon_end_at'] < $current_time){
                    ?>
               <!--  <div class="commodity_detail_send" style="margin-top: 5px;">
                     <style>
                     .commodity_detail_send{background:#a5a294;}
                     </style>
                     <a href="javascript:void(0);">已过期</a>
                 </div> -->
    <?php       }elseif($current_time < $package['coupon_start_at'] ){?>
    			<div class="commodity_detail_send" style="margin-top: 5px;">
   					<a href="javascript:void(0);" onclick="time_message();">立即使用</a>
   				</div>
    <?php }else{?>
                <div class="commodity_detail_send" style="margin-top: 5px;">
           			 <a href="<?php echo site_url('Search/discount_goods').'/'.$package['p_id'];?>">立即使用</a>
           		</div>
    <?php       }  break;   
                case 4:?>
               <!--   <div class="commodity_detail_send" style="margin-top: 5px;">
                     <style>
                     .commodity_detail_send{background:#a5a294;}
                     </style>
                     <a href="javascript:void(0);">已失效</a>
                     </div>  -->
    <?php       break;   } }
        }else{//首页未领取详情?>
           <div class="commodity_detail_send" style="margin-top: 5px;">
            <a href="javascript:void(0);" onclick="message();">立即领取</a>
            </div>
      
    <?php  }   }else{//内页未领取详情 
       if($status){
           $current_time = date("Y-m-d");
           if($package["discount_type"] == 3){
               if( $package['coupon_end_at'] >= $current_time &&  $current_time >= $package['coupon_start_at']){ ?>
                                               <div class="red_packet" >
                                                 <div class="red_packet_box goods_packet_box">
                                   					<div>
                                   					<div class="goods_packet_img" id="code"></div>
                                   					</div>
                               				 </div>
                               				 </div>
                        <?php      }
               
           }else{
               if($package['coupon_end_at'] < $current_time){ //超过有效期?>
               <?php  }
               if($current_time < $package['coupon_start_at']){//未到使用时间?>
                <div class="commodity_detail_send" style="margin-top: 5px;">
   					<a href="javascript:void(0);" onclick="time_message();">立即使用</a>
   				</div>
            <?php    }else{ ?>
            <div class="commodity_detail_send" style="margin-top: 5px;">
           			 <a href="<?php echo site_url('Search/discount_goods').'/'.$package['p_id'];?>">立即使用</a>
           		</div>
      <?php  }?>
       <!--   <div class="commodity_detail_send" style="margin-top: 5px;">
        	<a href="javascript:void(0);" onclick="message();">立即领取</a>
        </div>	 -->
    <?php    } }}
}else{//app
    if($status){//已领取详情
        if($package["discount_type"] == 3){
            $current_time = date("Y-m-d");
            if( $package['coupon_end_at'] >= $current_time &&  $current_time >= $package['coupon_start_at']){ ?>
               <div class="red_packet" >
                 <div class="red_packet_box goods_packet_box">
   					<div>
   					<div class="goods_packet_img" id="code"></div>
   					</div>
    			  </div>
    		  </div>
        <?php   } }else{
        switch($package['status']){
            case 1: ?>
            <!--   <div class="commodity_detail_send" style="margin-top: 5px;">
               	         <style>
                                   .commodity_detail_send{background:#a5a294;}
                            </style>
                             <a href="javascript:void(0);">已使用</a>
               </div>      -->          
   <?php           break;
               case 2:
               $current_time = date("Y-m-d");
               if($package['coupon_end_at'] < $current_time){?>
             <!--   <div class="commodity_detail_send" style="margin-top: 5px;">
                    <style>
                    .commodity_detail_send{background:#a5a294;}
                    </style>
                    <a href="javascript:void(0);">已过期</a>
               </div> -->
    <?php       }elseif($current_time < $package['coupon_start_at'] ){?>
                 <div class="commodity_detail_send" style="margin-top: 5px;">
   					<a href="javascript:void(0);" onclick="time_message();">立即使用</a>
   				</div>
   <?php       }else{?>
               <div class="commodity_detail_send" style="margin-top: 5px;">
   					<a href="javascript:void(0);" onclick="package_goods();">立即使用</a>
   				</div>
   <?php        }   break;   
               case 4:?>
                 <!--    <div class="commodity_detail_send" style="margin-top: 5px;">
                    <style>
                    .commodity_detail_send{background:#a5a294;}
                    </style>
                    <a href="javascript:void(0);">已失效</a>
                    </div>-->
   <?php       break;   }
        }
    }else{//未领取详情 ?>
        <div class="commodity_detail_send" style="margin-top: 5px;">
        <a href="javascript:void(0);" onclick="gain_package();">立即领取</a>
        </div>
    <?php     }
} ?>
 
<?php if(!empty($package["donation"]) && $package["donation"]==1 && $status==1){?>
<?php if(!$mac_type){?>
	<?php if($package["discount_type"] == 3){
	           if($package['status']){ ?>
	      <div class="commodity_detail_send" style="margin-top: 5px;">
            	<a href="<?php echo site_url("corporate/card_package/share/1/".$package["p_id"]);?>">转赠优惠券</a>
          </div>
	 <?php     }?>
	<?php }else{?>
	       <div class="commodity_detail_send" style="margin-top: 5px;">
            	<a href="<?php echo site_url("corporate/card_package/share/1/".$package["p_id"]);?>">转赠优惠券</a>
           </div>
	<?php }?>
<?php } };?>

<script type="text/javascript" src="js/qrcode.min.js"></script>
<script>
<?php  if($package["discount_type"] == 3){
    if(isset($package['id'])){?>
    var str = "<?php echo  site_url('corporate/card_package/sure_verification/'.$package['id']);?>";
    var qrcode = new QRCode(document.getElementById("code"), {
        width : 150,
        height : 150
    });
        qrcode.makeCode(str);
 <?php  } }?>
function time_message(){
	
	$(".black_feds").text("此货包未到使用时间！请在<?php echo $package['coupon_start_at']?> 00:00:00 至<?php echo $package['coupon_end_at'];?> 24:00:00 期间使用！").show();
	setTimeout("prompt();", 2000);
	return;
}
function message(){
	$(".black_feds").text("此货包仅限APP领取，快下载“五一易货”APP去领取吧！！").show();
	setTimeout("prompt();", 2000);
	return;
}
function gain_package(){
	<?php if($status){?>
	 window.location.href="<#gain_package#>id=<?php echo $package['p_id'];?>";
	<?php }else{?>
	 window.location.href="<#gain_package#>id=<?php echo $package['id'];?>";
	<?php }?>
	
}
function package_goods(){
	<?php if($status){?>
	 window.location.href="<#package_goods#>id=<?php echo $package['p_id'];?>";
	<?php }else{?>
	 window.location.href="<#package_goods#>id=<?php echo $package['id'];?>";
	<?php }?>
	
}

//领取卡包
function receive(obj,id){
	if(!id){
		window.location.reload();
		return ;
		}
	$.post("<?php echo site_url("corporate/card_package/gain_package");?>",{id:id},function(data){
		   switch(data["status"]){
		       case 1:
			       window.location.reload();
			       break;
		       case 2:
		    	   $(".black_feds").text("已经被抢光！").show();
		    	   setTimeout("prompt();", 2000);
		    	   window.location.reload();
			       break;
		       case 3:
		    	   $(".black_feds").text("领取成功！").show();
		    	   setTimeout("prompt();", 2000);
		    	   window.location.reload();
// 		    	   $(obj).removeAttr("onclick").text("已领取");
			       break;
		       case 4:
		    	   $(".black_feds").text("领取失败！").show();
		    	   setTimeout("prompt();", 2000);
		    	   window.location.reload();
			       break;
		       case 5:
		    	   $(".black_feds").text("领取时间还没到！").show();
		    	   setTimeout("prompt();", 2000);
		    	   window.location.reload();
			       break;
		       case 6:
		    	   $(".black_feds").text("领取时间结束！").show();
		    	   setTimeout("prompt();", 2000);
		    	   window.location.reload();
			       break;
		       case 7:
		    	   $(".black_feds").text("领取成功！").show();
		    	   setTimeout("prompt();", 2000);
		    	   window.location.reload();
// 		    	   $(obj).removeAttr("onclick").text("已领取");
			       break;
		   }
		},"json");
}

</script>