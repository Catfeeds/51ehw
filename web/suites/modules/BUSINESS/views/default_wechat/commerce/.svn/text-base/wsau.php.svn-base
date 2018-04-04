<style type="text/css">
   .go_home_app {position: absolute;top: 20%;}
   .go_home_app a {display: block;width: 60%;margin: auto;}
   .go_home_text {position: initial;margin-left: 0;text-align: center;margin-top: 30px;margin-bottom: 15px;}
   .go_home {position: relative;margin-top: 0;background: url(images/commerce/wsau_bg_01.png) no-repeat;background-size: 100% 100%;}
   .wsau_logo {display: block;width: 22%;margin: auto;}
</style>

<!-- app下载 -->
<div class="go_home">
   <!-- <div><img src="images/commerce/wsau_bg.png" alt=""></div> -->

   <div class="go_home_app">
      <div class="wsau_logo"><img src="images/commerce/wsau_04.png" alt=""></div>
      <a href="javascript:download('a ndroid')" style="margin-top: 80px;"><img src="images/commerce/wsau_05.png" alt=""></a>
      <a href="javascript:download('ios')" style="margin-top: 25px;"><img src="images/commerce/wsau_06.png" alt=""></a>
      <div class="go_home_text"><span>由51易货网提供计算服务</span></div>
   </div>
  


</div>

<div id="shareit" style="display:none;">
   <div class="shareit_top">
       <img src="images/curv.png">
   </div>
 </div>
 
 <script>
  var height = $(document).height();
  $('.go_home').css('height',height);


 function download(obj){
   var type = obj;
   var weixin = '<?php echo $is_weixin;?>';
   if(type == 'ios'){
      <?php if($agent_type == 'ios'){?>
         if(weixin == '1'){
            $('#shareit').show();
         }else{
              window.location.href = 'https://itunes.apple.com/cn/app/id1342069122?mt=8';
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
               window.location.href = 'http://www.51ehw.com/app/wsau.apk';
            }
            
         <?php }?>
         }
 }
$('#shareit').click(function(){
   $('#shareit').hide();
})
</script>
