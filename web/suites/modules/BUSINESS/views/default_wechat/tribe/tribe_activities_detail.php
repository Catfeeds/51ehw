
<script type="text/javascript"	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php 

if($this->session->userdata('app_info')['wechat_appid'] != NULL):
$this->load->library("js_api_sdk");
$this->js_api_sdk = new js_api_sdk();
$this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
$signPackage = $this->js_api_sdk->GetSignPackage();

?>
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
  wx.ready(function(){
	  wx.onMenuShareAppMessage({
	      title: '<?php echo $activity_info['name'];?>',
	      desc: '<?php echo strip_tags(str_replace(array("\r\n", "\r", "\n"), '', str_replace("'","\'",$activity_info['content'])));?>',
	      link: '<?php echo site_url("Tribe/activity_detaile").'/'.$activity_info['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$activity_info['banner_img'];?>',
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
	      title: '<?php echo $activity_info['name'];?>',
	      link: '<?php echo site_url("Tribe/activity_detaile").'/'.$activity_info['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$activity_info['banner_img'];?>',
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
	      title: '<?php echo $activity_info['name'];?>',
	      desc: '<?php echo strip_tags(str_replace(array("\r\n", "\r", "\n"), '', str_replace("'","\'",$activity_info['content'])));?>',
	      link: '<?php echo site_url("Tribe/activity_detaile").'/'.$activity_info['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$activity_info['banner_img'];?>',
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
	      title: '<?php echo $activity_info['name'];?>',
	      desc: '<?php echo strip_tags(str_replace(array("\r\n", "\r", "\n"), '', str_replace("'","\'",$activity_info['content'])));?>',
	      link: '<?php echo site_url("Tribe/activity_detaile").'/'.$activity_info['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$activity_info['banner_img'];?>',
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
		<style type="text/css">
           img {width: auto!important;height: auto!important;}
		</style>
   <!--我的活动开始-->

<?php 
$mac_type = $this->session->userdata("mac_type");

if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
   <?php //echo $mac_type;?>

<?php }else{?>
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<?php }?>
   <!-- <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a> -->
     <div class="my_activities">
             <div class="activities_nei_li">
              <div class="tribe_activities_title"><span><?php echo $activity_info['name']?></span></div> 
               <div class="activities_nei_li_top"> 
                  <a href="javascript:void(0); <?php //echo $activity_info['tribe_id'] > 0 ? site_url('Tribe/home/'.$activity_info['tribe_id'] ) : 'javascript:void(0)'?>"><i><img src="<?php echo !empty($activity_info) ? IMAGE_URL.$activity_info["logo"] : 'images/tmp_logo.jpg' ?>" alt="" onerror="this.src='images/tmp_logo.jpg'"></i></a>
                  <div class="activities_nei_li_xia">
                  
                   <h2 class="tribe_activities_name"><?php echo !empty($activity_info['tr_name']) ? $activity_info['tr_name'] : '五一易货网'?></h2>
                   <p><span><?php echo $activity_info['update_at']?></span></p>
                   </a>
                   </div>
               </div>
               <div class="activities_neirong">
               
               <div style="margin-left:5px;margin-right: 5px; margin-bottom: 20px;">
                  <?php echo $activity_info['content']?>
                </div>
              
               </div>
             </div>
        
     </div>
     <!-- 立即报名 
     <div class="tribe_join tribe_activities_baoming">
     	<?php //if( $activity_info['register'] ) {?>
        <a  style="background-color:#ccc;" id="a_register">已报名</a>
        <?php // }else{?>
        	<?php //if( $activity_info["start_time"] > date("Y-m-d H:i:s") ){?>
        	    <a id="a_register" style="background-color:#ccc">活动未开始</a>
        	<?php // }else if( $activity_info["end_time"] < date("Y-m-d H:i:s") ) {?>
        		<a id="a_register" style="background-color:#ccc">活动已结束</a>
        	<?php // }else{  ?>
        	    <a onclick="register()" id="a_register" >立即报名</a>
        	<?php //}?>
        <?php // }?>
    </div>
   <!--我的活动结束-->

<script type="text/javascript">
    function wx_share()
    {
        <?php 
        $desc = preg_replace("#<!--.*?-->#", "", $activity_info['content']);
        $desc =  strip_tags($desc);
        $desc = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$desc);
        $desc = mb_substr($desc,0,500);
        ?>
    	window.location.href="<#share#>name=<?php echo $activity_info['name'].'@desc='.$desc.'@link='.site_url("Tribe/activity_detaile").'/'.$activity_info['id'].'@img='.$activity_info['banner_img'];?>";
    }
    
	function register()
	{
		$.ajax
		({ 
			type:'get',
			url:"<?php echo site_url('Tribe/activity_signup/'.$activity_info['id'])?>",
			dataType:'json',
// 			data:{},
			success:function(data)
			{
				if( data.status == 1 )
				{
					 $('#a_register').css('background-color','#ccc');
					 $('#a_register').text('已报名');
					 $('#a_register').removeAttr('onclick');
					 
				}

				$(".black_feds").text(data.message).show();
    	        setTimeout("prompt();", 2000);   
			},
			error:function()
			{ 
		        $(".black_feds").text('网络错误，请稍后再试').show();
	        	setTimeout("prompt();", 2000); 
	        }
		})
	}
</script>



