<script type="text/javascript"	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
<?php 
if($this->session->userdata('app_info')['wechat_appid'] != NULL):
$this->load->library("js_api_sdk");
$this->js_api_sdk = new js_api_sdk();
$this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
$signPackage = $this->js_api_sdk->GetSignPackage();
?>
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
	      title: '关注五一易货网 码上赠豪礼',
	      desc: '迪比斯免费赠、牛背梁6.5折，悦豪酒店5折抢，超划算呢手慢无！',
	      link: 'http://www.51ehw.com/siteinfo/app_action/93',
	      imgUrl: 'http://images.51ehw.com/B/uploads/action/93/images/active_index_01.png',
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
	      title: '关注五一易货网 码上赠豪礼',
	      link: 'http://www.51ehw.com/siteinfo/app_action/93',
	      imgUrl: 'http://images.51ehw.com/B/uploads/action/93/images/active_index_01.png',
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
	      title: '关注五一易货网 码上赠豪礼',
	      desc: '迪比斯免费赠、牛背梁6.5折，悦豪酒店5折抢，超划算呢手慢无！',
	      link: 'http://www.51ehw.com/siteinfo/app_action/93',
	      imgUrl: 'http://images.51ehw.com/B/uploads/action/93/images/active_index_01.png',
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
	      title: '关注五一易货网 码上赠豪礼',
	      desc: '迪比斯免费赠、牛背梁6.5折，悦豪酒店5折抢，超划算呢手慢无！',
	      link: 'http://www.51ehw.com/siteinfo/app_action/93',
	      imgUrl: 'http://images.51ehw.com/B/uploads/action/93/images/active_index_01.png',
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
<!-- 迪比斯水上乐园 -->

<div class="bidisi_main">
 <div class="active_index_head dibisi_active_head">
    <img src="images/dibisi_head.png" alt="">
 </div>
 <div class="dibisi_active_text">
   <!-- 立即领取 -->
   <div class="dibisi_active_get">
       <a href="javascript:void(0);">立即领取</a>
   </div>
   <!-- 活动规则 -->
   <div class="dibisi_active_rule_box">
      <fieldset class="scheduler_border">
       <legend class="scheduler_border1">活动规则</legend>
      </fieldset>
      <div class="dibisi_active_rule_text">
         <p>1、凡参与此次活动，赠送158元优惠券一张；</p>
         <p>2、由于数量有限，每个账号仅限领取一张；</p>
         <p>3、此优惠券仅限购买单价为158元的迪比斯水上乐园门票；</p>
         <p>4、使用优惠券所购买的单价为158元的迪比斯门票不收取邮费  ，包邮；</p>
         <p>5、收货人的手机号、账号中的手机号码需为同一手机号，为了保证及时收货，活动期间请保持手机畅通；</p>
         <p>6、本活动所购买的门票，如无票务问题，不支持退票；</p>
         <p>7、其它未尽事宜，请咨询客服，咨询热线：4000-029-777</p>
         <p>8、本活动的最终解释权归51易货网所有；</p>
         <p>9、温馨提示：迪比斯门票有效截止日期：2017年9月28日</p>
      </div>
   </div>
       

        

</div>
</div>

