

<!-- app下载 -->
<div class="go_home">
   <div><img src="images/commerce/huijia_img.png" alt=""></div>
   <div class="go_home_app">
      <a href="javascript:download('ios')"><img src="images/commerce/huijia_ip.png" alt=""></a>
      <a href="javascript:download('android')"><img src="images/commerce/huijia_android.png" alt=""></a>
   </div>
   <div class="go_home_text"><span>由51易货网提供计算服务</span></div>


</div>

<div id="shareit" style="display:none;">
   <div class="shareit_top">
       <img src="images/curv.png">
   </div>
 </div>
 
 <script>

 function download(obj){
 	var type = obj;
	var weixin = '<?php echo $is_weixin;?>';
 	if(type == 'ios'){
 		<?php if($agent_type == 'ios'){?>
 			if(weixin == '1'){
 				$('#shareit').show();
 	 		}else{
 	 	 		  window.location.href = 'https://itunes.apple.com/cn/app/id1321197407?mt=8';
 	 	 		}
 		<?php }else{ ?>
 			$(".black_feds").text("你的是安卓手机，请选择安卓版下载").show();
         	setTimeout("prompt();", 2000);   
 		<?php }?>
 		}else{
 			<?php if($agent_type == 'ios'){?>
 				$(".black_feds").text("你的是iphone,请选择iphone版下载").show();
 	        	setTimeout("prompt();", 2000);   
 			<?php }else{ ?>
 				if(weixin == '1'){
 					$('#shareit').show();
 	 			}else{
 	 				window.location.href = 'http://www.51ehw.com/app/gongshang.apk';
 	 	 		}
 			 	
 			<?php }?>
 			}
 }
$('#shareit').click(function(){
	$('#shareit').hide();
})
</script>
