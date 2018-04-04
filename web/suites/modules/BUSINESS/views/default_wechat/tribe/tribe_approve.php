<style type="text/css">
  .container {background:#f6f6f6;}
  .invite_ball {position: fixed;top: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);display: none;}
  .invite_ball_box {position: relative;background: #fff;margin: 50% 10%;border-radius: 5px;}
  .clans_invite_phone {padding-top: 50px;}
  .tribal_avatar_bottom_ul li a {margin-top: 40px;}
  .invite_close {position: absolute;width: 34px;right: -10px;top: -10px;}
  .tribe_people_ball {padding-top: 50px;text-align: center;}
  .tribe_people_ball span {font-size: 16px;color: #333;}
</style>
<?php 
if($this->session->userdata('app_info')['wechat_appid'] != NULL):
$this->load->library("js_api_sdk");
$this->js_api_sdk = new js_api_sdk();
$this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
$signPackage = $this->js_api_sdk->GetSignPackage();
?>
<script type="text/javascript"	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
      debug: false,
      appId: '<?php echo $this->session->userdata('app_info')['wechat_appid'];?>',
      timestamp: '<?php echo $signPackage["timestamp"];?>',
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'onMenuShareTimeline',
      ]
  });
  <?php if($type == 'Corp'){ ?>
  
  		var _title = "<?php echo $real_name ? $real_name.'邀请您上51易货网开店':$invite_info['member_name'].'邀请您上51易货网开店'?>";
 		var _desc = '填写资料，开店可享更多特权。';
 		var _link = "<?php echo site_url('Navigation/cooperate_nav')?>";
  <?php }else{ 
      $path = "部落";
      if( !is_numeric(strpos($invite_info['name'], $path))){
          $tribe_name = "【".$invite_info['name']."】部落";
      }else{
          $tribe_name = "【".$invite_info['name']."】";
      }
      if($real_name){
          $name = $real_name;
      }else{
          $name = $invite_info['member_name'];
      }
      ?>
        var _title = "<?php echo '【'.$name.'】邀请您加入'.$tribe_name;?>";
    	var _desc = "<?php echo '部落互助，资源共享，'.$invite_info['name'].'诚意邀请您加入'?>";
    	var _link = "<?php echo site_url('Login/code_login/'.$tribe_id.'?in_id='.$invite_info['from_customer_id'])?>";
  <?php }?>
  wx.ready(function(){
	  wx.onMenuShareAppMessage({
	      title: _title,
	      desc: _desc,
	      link: _link,
	      imgUrl: 'http://image.51ehw.com/logo.png',
	      trigger: function (res) {
// 	        alert('用户点击发送给朋友');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareTimeline({
	      title: _title,
	      link: _link,
	      imgUrl: 'http://image.51ehw.com/logo.png',
	      trigger: function (res) {
// 	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareQQ({
	      title: _link,
	      desc: _desc,
	      link: _link,
	      imgUrl: 'http://image.51ehw.com/logo.png',
	      trigger: function (res) {
// 	        alert('用户点击分享到QQ');
	      },
	      complete: function (res) {
// 	        alert(JSON.stringify(res));
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareWeibo({
	      title: _title,
	      desc: _desc,
	      link: _link,
	      imgUrl: 'http://image.51ehw.com/logo.png',
	      trigger: function (res) {
// 	        alert('用户点击分享到微博');
	      },
	      complete: function (res) {
// 	        alert(JSON.stringify(res));
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  });
  
</script>
<?php
    endif;
?>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span><?php echo $type == 'Corp' ? '邀请企业认证' : '邀请加入部落' ?></span>
</div>
<?php }?>

<!-- 邀请企业认证 -->
<div class="tribe_approve">
    <img src="<?php echo $type == 'Corp' ? 'images/tribe_approve.jpg' : 'images/tribe_invite.jpg' ?>" alt="">
    
    <?php if( $invite_status != 1){?>
        <style type="text/css">
           .tribe_approve img {margin-bottom: 50px;}
        </style>
        <div class="tribe_join">
        	<?php if( empty( $_COOKIE['invite_dx_'.$type.'_'.$tribe_staff] ) ){?>
            <a href="javascript:;" id="sub"style="color: black;"><?php echo $type == 'Corp' ? '邀请企业认证' : '邀请加入部落' ?></a>
            <?php }else{?>
            <a href="javascript:;" style="color: black; background-color:#ccc" >已邀请</a>
            <?php }?>
        </div>
    <?php }?>
</div>

<?php if( $invite_status == 1 ){?>
    <!-- 蒙层 -->
    <div class="tribe_invite_ball">
    	<span>点击右上角，分享给好友~！</span>
    	<span class="icon-curv"></span>
    </div>
<?php }?>


<!-- 弹窗 -->
<div style="min-height: 400px;" class="invite_ball">
  <div class="invite_ball_box">
    <img src="images/51h5-lose.png" class="invite_close">
    <div class="tribe_people_ball">
      <span id="message_">您的短信邀请已经发送成功</span>
    </div>
  <div class="tribal_avatar_bottom">
   <ul class="tribal_avatar_bottom_ul">
     <li><a class="tribal_avatar_top_a" href="javascript:;" onclick="$('.invite_ball').hide();">确定</a></li>
   </ul>
  </div>
  </div>
</div>





<script type="text/javascript">
//分享
function  wx_share(){
	 window.location.href='<#invite_share#>title='+_title+'&desc='+_desc+'&img=http://image.51ehw.com/logo.png&link='+_link;
}
  $(".invite_close").on('click',function(){
    $('.invite_ball').hide();
  }) 
//   $(".tribe_join").on('click',function(){
   
//   })

<?php if( empty( $_COOKIE['invite_dx_'.$type.'_'.$tribe_staff] ) ){?>
// 	document.getElementById('sub').addEventListener('click',ajax_submit);
<?php }?>
function ajax_submit()
{
	var type = '<?php echo $type?>';
	var tribe_id = '<?php echo $tribe_id?>';
    var tribe_staff = '<?php echo $tribe_staff?>';
    var button_message = '<?php echo $type == 'Corp' ? '邀请企业认证':'邀请加入部落'?>'
	if( type && tribe_id && tribe_staff )
	{ 
	    $.ajax({ 
		    url:'<?php echo site_url('Tribe/Invite')?>',
		    type:'post',
		    dataType:'json',
		    data:{'type':type,'tribe_id':tribe_id,'tribe_staff':tribe_staff},
		    beforeSend:function()
            { 
            	document.getElementById('sub').style.background='#ccc';
	        	document.getElementById('sub').text='短信发送中....';
	        	document.getElementById('sub').removeEventListener("click", ajax_submit);
            },
		    success:function(data)
		    {
				var background = '#FECF0A';
				
				if( data.status == 1)
				{ 
					var background = '#ccc';
					button_message = '已邀请';
					
				}else{ 

					document.getElementById('sub').addEventListener('click',ajax_submit);
					
				}
		    	$('#message_').text(data.message);;
		    	$('.invite_ball').show();
		        
			    document.getElementById('sub').style.background=background;
		        document.getElementById('sub').text= button_message;
		         
				
			},
		    error:function()
		    {
			    
		    	$(".black_feds").text("发送失败,请稍后再试").show();
		        setTimeout("prompt();", 2000);   
		    	document.getElementById('sub').addEventListener('click',ajax_submit);
	            document.getElementById('sub').style.background='#FECF0A';
	            document.getElementById('sub').text= button_message;
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




