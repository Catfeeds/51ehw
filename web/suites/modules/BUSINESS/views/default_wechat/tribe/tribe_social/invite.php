<style type="text/css">
  .invite_ball {position: fixed;top: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);display: none;}
  .invite_ball_box {position: relative;background: #fff;margin: 50% 10%;border-radius: 5px;}
  .tribal_avatar_bottom_ul li a {margin-top: 40px;}
  .invite_close {position: absolute;width: 34px;right: -10px;top: -10px;}
</style>

<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>邀请朋友</span>
</div>
<?php }?>


<!-- 手机号邀请 -->
<div style="min-height: 400px;" class="invite_ball">
  <div class="invite_ball_box">
    <img src="images/51h5-lose.png" class="invite_close">
    <div style="height:40px;"></div>
    <div class="clans_invite_phone">
    <span>+86</span><input type="text" value="" placeholder="输入好友手机号" maxlength="11" name='moblie'>
  </div>
  <div class="tribal_avatar_bottom">
   <ul class="tribal_avatar_bottom_ul">
     <li><a class="tribal_avatar_top_a" href="javascript:ajax_submit()">发送邀请</a></li>
   </ul>
  </div>
  </div>
</div>







<!-- 邀请好友 -->
<div class="clans_invite">
    <ul>
    <?php 
    $mac_type = $this->session->userdata("mac_type");
    if(!$mac_type){ ?>
        <li>
           <a href="<?php echo site_url('Tribe/Invite_View/Customer/'.$tribe_id.'/0/1')?>" class="clans_weixin">
              <i class="icon-we_chat_l"></i>
              <span>微信好友</span>
          </a>
         </li>
   <?php  } ?>
         <li>
           <a href="javascript:void(0);" class="clans_iphone">
              <i class="icon-phone1"></i>
              <span>手机号邀请</span>
          </a>
         </li>
         <li>
           <a href="<?php echo site_url("Tribe/Invite_Code/{$tribe_id}");?>" class="yaoqing">
              <i class="icon-erweimayaoqing"></i>
              <span>二维码邀请</span>
          </a>
         </li>
     </ul> 
</div>    

<!-- 弹窗   -->
  <div class="clans_ball">
      <div class="clans_ball_box">
         <ul>
             <li><a href="javascript:void(0);"><img src="images/pengyouquan.png" alt="" style="height: 40px;width: 40px;"><span>微信朋友圈</span></a></li>
             <li><a href=""><img src="images/weixin.png" alt=""><span>微信好友</span></a></li>
         </ul>
         <div class="clans_ball_box_btn"><span>取消</span></div>
      </div>
  </div>

<script type="text/javascript">
  $(".invite_close").on('click',function(){
    $('.invite_ball').hide();
  }) 
  $(".clans_iphone").on('click',function(){
    $('.invite_ball').show();
    $('.clans_invite_phone input').val('');
  })
</script>

  <script type="text/javascript">
	
  function ajax_submit()
  {
  
  	var tribe_id = '<?php echo $tribe_id?>';
  
    var moblie = $('input[name=moblie]').val();
    var re = /^1\d{10}$/
        
    if( !moblie || !re.test(moblie) )
    { 
    	$(".black_feds").text('请输入正确的手机号码').show();
		setTimeout("prompt();", 2000); 
       	return false;
    }

    
  	if( moblie &&  tribe_id )
  	{ 
  	    $.ajax({ 
  		    url:'<?php echo site_url('Tribe_social/Invite_Moblie')?>',
  		    type:'post',
  		    dataType:'json',
  		    data:{'tribe_id':tribe_id,'moblie':moblie},
  		    beforeSend:function()
            { 
 
	        	$('.tribal_avatar_top_a').text('发送中....');
              	$('.tribal_avatar_top_a').attr('href','javascript:;');
            },
  		    success:function(data)
  		    {

  		    	$(".black_feds").text(data.message).show();
      	        setTimeout("prompt();", 2000);  
	      	        
      	        $('.tribal_avatar_top_a').text('发送邀请');
  			    $('.tribal_avatar_top_a').attr('href','javascript:ajax_submit()');
  			    $('.invite_ball').hide();
  				
  			},
  		    error:function()
  		    {
  		    	$('.invite_ball').hide();
  		    	$('.tribal_avatar_top_a').text('发送邀请');
  		    	$('.tribal_avatar_top_a').attr('href','javascript:ajax_submit()');
  		    	$(".black_feds").text("发送失败,请稍后再试").show();
  		        setTimeout("prompt();", 2000);   
			    return;
  		    }
  	    })	
  	}else{

  		$(".black_feds").text("参数错误").show();
        setTimeout("prompt();", 2000);   
        return false;
  	}
  } 
  </script>













