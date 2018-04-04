<style type="text/css">
.container {background: #d6d6d6;}
.tribe_my_share_list {min-height: auto;}
.tribal_share_details_num_input input {background: #fff;}
.new_package_details { margin: 15px 0;}
</style>
<script type="text/javascript"	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php 
if( $this->session->userdata('app_info')['wechat_appid'] != NULL):
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
	      title: '<?php echo $detail['title'];?>',
	      desc: '<?php echo $detail['desc'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$detail['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$detail['image'];?>',
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
	      title: '<?php echo $detail['title'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$detail['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$detail['image'];?>',
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
	      title: '<?php echo $detail['title'];?>',
	      desc: '<?php echo $detail['desc'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$detail['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$detail['image'];?>',
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
	      title: '<?php echo $detail['title'];?>',
	      desc: '<?php echo $detail['desc'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$detail['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$detail['image'];?>',
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
	
<!-- 分享详情 -->
<div class="tribe_my_share">
    <div class="tribe_my_share_list">
        <div class="tribal_share_details">
           <!-- 标题 -->
           <div class="new_package_share_title">
             <span>标题</span>
             <div><p><input type="text" disabled id="title" maxlength="20" placeholder="" value="<?php echo $detail['title'];?>"><em><i>0</i>/20</em></p></div>
           </div>
           <!-- 描述 -->
           <div class="tribal_share_details_title tribe_build_share_describe"><span>描述</span><p><textarea disabled id="desc"  maxlength="50" placeholder=""><?php echo $detail['desc'];?></textarea><em><i>0</i>/50</em></p></div>
        </div>
        <!-- 选择发送的产品  -->
<!--         <div class="tribal_share_details_choice"><a href="javscript:void(0);">选择发送的产品<span>已选择<i class="icon-right"></i></span></a></div> -->

        <!-- 新奖品 -->
        <div class="new_package_details">
        <div class="new_package_details_left">
           <p><?php echo $detail['tribe_package_name'];?></p>
           <p><?php echo $detail['tribe_package_desc'];?></p>
           <p><?php echo $detail['start_at'].' - '.$detail['valid_date']?></p>
        </div>
        <div class="new_package_details_right"><span>免费</span></div>
       </div>

        <div class="tribal_share_details_choice tribal_share_details_num"><a href="javscript:void(0);">发放数量 <div class="tribal_share_details_num_input"><input type="text" value="<?php echo $detail['quanity'];?>" disabled="false" placeholder=""></div><i>个</i></a></div>
        <!-- 已领货包 -->
        <div class="tribal_share_details_choice tribal_share_details_num" style="border-bottom: 1px solid #ddd;padding-bottom: 15px;"><a href="javscript:void(0);">已领货包 <div class="tribal_share_details_num_input"><input type="text" value="<?php echo $surplus_num;?>" disabled="false" placeholder=""></div><i>个</i></a></div>
         <!-- 已选部落 -->
         <div class="tribe_share_invite">
            <span>已选部落</span>
            <p><input name="Fruit" type="checkbox" value="<?php echo $tribe_info['id'];?>" disabled="disabled" checked=''/><?php echo $tribe_info['name'];?></p>
           
         </div>
    </div>   
    <?php if($detail['edit_status']){?>
        <div class="tribal_share_details_get">
          <!-- <a href="<?php //echo site_url("Activity/Tribe_package/share_edit/").'/'.$detail['id'];;?>" class="" alt="">编辑</a> -->
          <a href="javscript:void(0);" class="tribe_share_get" style="width: 100%;">分享</a>
        </div> 
    <?php  }?>
</div> 
    <div style="height:50px;"></div>
    <!-- 分享弹窗 -->
    <div class="tribe_share_ball" hidden><img src="images/indicate.png" alt=""></div>



<script language="javascript">

$(".tribe_share_get").on("click",function(){
    $(".tribe_share_ball").show();
  })
  $(".tribe_share_ball").on("click",function(){
    $(".tribe_share_ball").hide();
  })

var length_title = $('#title').val().length;
$(".new_package_share_title p em i").text(length_title);  
var length_desc = $('#desc').val().length;
$(".tribe_build_share_describe p em i").text(length_desc);

window.onload = function () {
// alert("1");
var u = navigator.userAgent;
if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
// alert("安卓手机");

} else if (u.indexOf('iPhone') > -1) {//苹果手机
// alert("苹果手机");
  $(".tribal_share_details_num_input").css("margin-top","-5px");
} else if (u.indexOf('Windows Phone') > -1) {//winphone手机
// alert("winphone手机");
}
}
</script>



