<?php
$user_id = $this->session->userdata("user_id");
if(!$user_id){
    $this->session->set_userdata('ref_activity_url', 'http://www.51ehw.com/siteinfo/app_action/93');
    redirect("http://www.51ehw.com/index.php/_BUSINESS/Member/info");
}
?>
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
      debug: true,
      appId: '<?php echo $this->session->userdata('app_info')['wechat_appid'];?>',
      timestamp: <?php echo $signPackage["timestamp"];?>,
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
	        alert('用户点击发送给朋友');
	      },
	      success: function (res) {
	        alert('已分享');
	      },
	      cancel: function (res) {
	        alert('已取消');
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
	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
	        alert('已分享');
	      },
	      cancel: function (res) {
	        alert('已取消');
	      },
	      fail: function (res) {
	        alert(JSON.stringify(res));
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>关注五一易货网 码上赠豪礼</title>
 <link rel="stylesheet" type="text/css" href="http://images.51ehw.com/B/uploads/action/93/css/style.css">
</head>
<body>
<style type="text/css">
 .container {background: #32b0eb;}
</style>
<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>

<div>
    <!-- 头部 -->
    <div class="active_index_head">
        <img src="http://images.51ehw.com/B/uploads/action/93/images/active_index_01.png" alt="">
    </div>
    <!-- 内容 -->
    <div class="active_index_main">
        <!-- 活动时间 -->
        <div class="active_index_time">
            <h2>活动时间</h2>
            <span>2017年8月1日——2017年8月31日</span>
        </div>  
        <!-- 活动详情 -->
        <div class="active_index_details">
            <h2>活动详情</h2>
            <div class="active_index_details_list" style="margin-top: 0px;">
                <p class="active_details_title"><em></em>免费送 [迪比斯欢乐水世界] 门票1张  </p>
                <p class="active_details_money"><s>原价:158元</s><span> 抢购价:<i>0元</i></span><a href="http://mp.weixin.qq.com/s/MJsB9BSCrbSrh_JO7IculQ"><img src="http://images.51ehw.com/B/uploads/action/93/images/active_index_03.png" alt=""></a></p>
                <p class="active_details_guanzhu">(关注微信公众号“五一易货网”,免费抢迪比斯门票1张,仅限50名)</p>
            </div>
            <div class="active_index_details_list">
                <p class="active_details_title"><em></em>买 [牛背梁] 门票1张 赠 [青峰峡] 门票1张</p>
                <p class="active_details_money"><s>原价:150元</s><span> 抢购价:<i>110元</i></span><a href="javascript:check_product(3128);"><img src="http://images.51ehw.com/B/uploads/action/93/images/active_index_03.png" alt=""></a></p>
            </div>
            <div class="active_index_details_list">
                <p class="active_details_title"><em></em>买 [悦豪酒店]<i>(青峰峡店)</i>1晚 赠 [青峰峡] 门票2张</p>
                <p class="active_details_money"><s>原价:678元</s><span> 抢购价:<i>358元</i></span><a href="javascript:check_product(3129);"><img src="http://images.51ehw.com/B/uploads/action/93/images/active_index_03.png" alt=""></a></p>
            </div>
        </div>

        <!-- 申办 -->
        <div class="active_index_bid">
            <h2>在线申办兴业银行信用卡首刷专享</h2>
            <div class="active_index_bid_list">  
            <a href="http://www.51ehw.com/index.php/_BUSINESS/Home/GetShopGoods/712">    
                <ul>
                    <li>
                        <p><em></em>买<span>[乐华城欢乐世界]</span>赠 温泉乐园门票</p>
                        <p class="active_index_bid_money"><s style="padding-right: 10px;">原价429元</s>抢购价 ¥ <i>230</i></p>
                    </li>
                     <li>
                        <p><em></em>买<span>[乐华城温泉乐园门票]</span>赠 牛背梁门票</p>
                        <p class="active_index_bid_money"><s style="padding-right: 10px;">原价308元</s>抢购价 ¥ <i>198</i></p>
                    </li>
                     <li>
                        <p><em></em>买<span>[乐华城温泉乐园门票]</span>赠 亚辰自助餐券2张</p>
                        <p class="active_index_bid_money"><s style="padding-right: 10px;">原价302元</s>抢购价 ¥ <i>198</i></p>
                    </li>
                </ul>
            </a>    
            </div>

            <div class="active_index_bid_text"><span>快速申卡 优惠尽享</span></div>
            <div class="active_index_bid_import">
                <p>真实姓名 <input type="text" id="name" value="" placeholder="输入申办兴业银行的姓名" onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')"></p>
                <p>手机号<span style="opacity: 0;">补</span> <input type="text" id="mobile" value="" maxlength="11" onkeyup='this.value=this.value.replace(/\D/gi,"")' placeholder="输入申办兴业银行的手机号码"></p>
                <button id="btn">抢豪礼</button>
            </div>
        </div>

        <!-- 活动规则 -->
        <div class="active_index_time">
            <h2>活动规则</h2>
            <div class="active_index_rule">
                <p>1.活动商品每个ID限购一个套餐，多次购买无效；</p>
                <p>2.参加活动的手机号码、真实姓名需于申办兴业银行信用卡电话、姓名一致；</p>
                <p>3.乐华城套餐仅限在线申办兴业银行信用卡首刷专享，非兴业信用卡首刷用户购买将不发货，误下单的用户货款原路退回</p>
                <img src="http://images.51ehw.com/B/uploads/action/93/images/active_index_04.png" alt="" style="margin-top: 20px;">
            </div>

        </div>  
        

    </div>
</div>
</body>
<script src="http://images.51ehw.com/B/uploads/action/93/js/jquery.js"></script>
<script>
$("#btn").click(function(){
    var name = $("#name").val();
    var mobile = $("#mobile").val();
    if(name == ''){
        $(".black_feds").text("真实姓名不能为空！").show();
        setTimeout("prompt();", 2000);
        return;
        }
    if(mobile == ''){
        $(".black_feds").text("手机号码不能为空！").show();
        setTimeout("prompt();", 2000);
        return;
    }
    var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
    if(isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
        $(".black_feds").text("请输入正确的手机号码！").show();
        setTimeout("prompt();", 2000);
        return;
     }  

    $.ajax({
        url:"http://www.51ehw.com/index.php/_BUSINESS/Order/ajax_insert_CIB",
        type:'get',
        async: false, 
        DataType:'html',
        data:{name:name,mobile:mobile},
        success:function(data){
            var msg=eval('('+data+')');
            if(msg.Result){
                if(msg.Result == '300' || msg.Result == 300){
                    $(".black_feds").text("您已申办成功,无需重复申请！").show();
                    setTimeout("prompt();", 2000);
                    return;
                }else{
                    $(".black_feds").text("申办成功！").show();
                    setTimeout("prompt();", 2000);
                    setTimeout(function(){
                        window.location.href = 'https://wm.cib.com.cn/application/cardapp/cappl/ApplyCard/toSelectCard?id=2f246842b7ef4babb30bedb4b2c33625';
                    }, 3000);

                    return;
                    }
                }else{
                    $(".black_feds").text("申办失败！").show();
                    setTimeout("prompt();", 2000);
                    return;
                    }
            },
        error:function(){
            $(".black_feds").text("网络错误！请重试！").show();
            setTimeout("prompt();", 2000);
            return;
            }
        });
    
});

function prompt(){
    $(".black_feds").toggle();
}

function check_product(id){
    var pro_id = id;
    $.ajax({
        url:"http://www.51ehw.com/index.php/_BUSINESS/Order/ajax_check_order",
        type:'get',
        DataType:'json',
        data:{pro_id:pro_id},
        success:function(data){
            var msg=eval('('+data+')');
            if(msg.Result){
                     window.location.href = 'http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/'+id;
                }else{
                    $(".black_feds").text("每个商品只能购买一次哦！").show();
                    setTimeout("prompt();", 2000);
                    return;
                    }
            },
        error:function(){
            $(".black_feds").text("网络错误！请重试！").show();
            setTimeout("prompt();", 2000);
            return;
            }
        });

    
}

</script>
</html>