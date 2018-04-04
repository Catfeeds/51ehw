<style type="text/css">
   .go_home_app a {display: block;width: 60%;margin: auto;}
   .go_home_text {position: initial;margin-left: 0;text-align: center;margin-top: 30px;margin-bottom: 15px;}
</style>

<!-- app下载 -->
<div class="go_home">
   <div><img src="images/commerce/commerce_download_01.png" alt=""></div>
   <div class="go_home_app">
      <a href="javascript:download('android')" style="margin-top: 80px;"><img src="images/commerce/commerce_download_02.png" alt=""></a>
      <a href="javascript:download('ios')" style="margin-top: 25px;"><img src="images/commerce/commerce_download_03.png" alt=""></a>
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
              window.location.href = 'https://itunes.apple.com/cn/app/id1335912136?mt=8';
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
               window.location.href = 'http://www.51ehw.com/app/sxecom.apk';
            }
            
         <?php }?>
         }
 }
$('#shareit').click(function(){
   $('#shareit').hide();
})
</script>
