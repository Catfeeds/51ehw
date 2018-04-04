<style type="text/css">
   .go_home {position: relative;margin-top: 0;background: url(images/commerce/qinshang_bg.png) no-repeat;background-size: 100% 100%;overflow: hidden;}
</style>

<!-- app下载 -->
<div class="go_home">
   <!-- 五一易货APP -->
   <div class="qinshang_one">
     <div class="qinshang_one_text"><span>五一易货APP</span></div>
        <div class="qinshang_one_img"><img src="images/commerce/qinshang_img01.png" alt=""></div>
        <div class="qinshang_one_but">
         <a href="javascript:download('a ndroid')"><img src="images/commerce/qinshang_but01.png" alt=""></a>
         <a href="javascript:download('ios')"><img src="images/commerce/qinshang_but02.png" alt=""></a>
        </div>
   </div>
   <!-- 秦商会APP -->
   <div class="qinshang_two">
     <div class="qinshang_two_text"><span>秦商会APP</span></div>
        <div class="qinshang_two_img"><img src="images/commerce/qinshang_img02.png" alt=""></div>
        <div class="qinshang_two_but">
         <a href="javascript:download_qinshang('a ndroid')"><img src="images/commerce/qinshang_but03.png" alt=""></a>
         <a href="javascript:download_qinshang('ios')"><img src="images/commerce/qinshang_but04.png" alt=""></a>
        </div>
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
              window.location.href = 'https://itunes.apple.com/cn/app/51yi-huo-wang/id1102365749';
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
               window.location.href = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.nineleaf.yhw';
            }
            
         <?php }?>
         }
 }


 function download_qinshang(obj){
   var type = obj;
   var weixin = '<?php echo $is_weixin;?>';
   if(type == 'ios'){
      <?php if($agent_type == 'ios'){?>
         if(weixin == '1'){
            $('#shareit').show();
         }else{
              window.location.href = 'https://itunes.apple.com/cn/app/id1320818265?mt=8';
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
               window.location.href = 'http://www.51ehw.com/app/qinshang.apk';
            }
            
         <?php }?>
         }
 }



$('#shareit').click(function(){
   $('#shareit').hide();
})
</script>
