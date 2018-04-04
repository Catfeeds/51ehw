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
	      title: '<?php echo $info['title'];?>',
	      desc: '<?php echo strip_tags(str_replace(array("\r\n", "\r", "\n"), '', str_replace("'","\'",$info['content'])));?>',
	      link: '<?php echo site_url("Tribe/announcement_detaile/").'/'.$info['id'].'/'.($info['tribe_id'] > 0?$info['tribe_id']:0);?>',
	      imgUrl: '<?php echo IMAGE_URL.$info['title_img'];?>',
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
	      title: '<?php echo $info['title'];?>',
	      link: '<?php echo site_url("Tribe/announcement_detaile/").'/'.$info['id'].'/'.($info['tribe_id'] > 0?$info['tribe_id']:0);?>',
	      imgUrl: '<?php echo IMAGE_URL.$info['title_img'];?>',
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
	      title: '<?php echo $info['title'];?>',
	      desc: '<?php echo strip_tags(str_replace(array("\r\n", "\r", "\n"), '', str_replace("'","\'",$info['content'])));?>',
	      link: '<?php echo site_url("Tribe/announcement_detaile/").'/'.$info['id'].'/'.($info['tribe_id'] > 0?$info['tribe_id']:0);?>',
	      imgUrl: '<?php echo IMAGE_URL.$info['title_img'];?>',
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
	      title: '<?php echo $info['title'];?>',
	      desc: '<?php echo strip_tags(str_replace(array("\r\n", "\r", "\n"), '', str_replace("'","\'",$info['content'])));?>',
	      link: '<?php echo site_url("Tribe/announcement_detaile/").'/'.$info['id'].'/'.($info['tribe_id'] > 0?$info['tribe_id']:0);?>',
	      imgUrl: '<?php echo IMAGE_URL.$info['title_img'];?>',
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
<?php endif; ?>
<?php 
$mac_type = $this->session->userdata("mac_type");

if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
   <?php //echo $mac_type;?>

<?php }else{?>
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<?php }?>


<div class="essay_share_details">
	<!-- 标题 -->
	<div class="essay_share_details_title">
		<span><?php echo $info['title']?></span>
	</div>
	<!-- 时间／作者 -->
	<div class="essay_share_details_time">
		<span><?php echo $info['last_updated_time']?></span>
	</div>
	<!-- 文章内容 -->
	<div class="essay_share_details_main">
		<p><?php echo $info['content']?></p>
        
    </div>
</div>