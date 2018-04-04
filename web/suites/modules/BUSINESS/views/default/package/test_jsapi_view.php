<?php
$signPackage = $this->js_api_sdk->getSignPackage();
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<title>51易货网 - 红包分享</title>
</head>
<body>

	<div class="send_box">
		<!-- <div class="red_envelope_top">
        <ul>
            <a href=""><li class="icon-fanhui"></li></a>
            <li>51易货网</li>
        </ul>
    </div> -->

	<button id="checkJsApi">检查js接口</button>		
	<button id="onMenuShareAppMessage">分享给朋友</button>		
	<button id="onMenuShareAppMessage">分享给朋友</button>
	</div>

</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
          ]
    });

<?php

$news = array(
    "Title" => "51易货网货包",
    "Description" => $package['desc'],
    "PicUrl" => THEMEURL . 'images/weixinhuobao.jpg',
    "Url" => current_url()
);
error_log("PICURL:" . $news['PicUrl']);
?>

wx.ready(function(){

	// 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	  document.querySelector('#checkJsApi').onclick = function () {
	    wx.checkJsApi({
	      jsApiList: [
	          'onMenuShareTimeline',
	          'onMenuShareAppMessage'
	      ],
	      success: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
	  };
	document.querySelector('#onMenuShareAppMessage').onclick = function () {
		alert('测试！');
    	wx.onMenuShareAppMessage({
          title: '测试标题',
          desc: '<?php echo $news['Description'];?>',
          link: '<?php echo $news['Url'];?>',
          imgUrl: '<?php echo $news['PicUrl'];?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
             //alert('用户点击发送给朋友');
          },
          success: function (res) {
             alert('已分享');
          },
          cancel: function (res) {
             alert('已取消');
          },
          fail: function (res) {
             alert(res);
          }
        });
	}

        wx.onMenuShareTimeline({
          title: '<?php echo $news['Title'];?>',
          link: '<?php echo $news['Url'];?>',
          imgUrl: '<?php echo $news['PicUrl'];?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
             //alert('用户点击分享到朋友圈');
          },
          success: function (res) {
             alert('已分享');
          },
          cancel: function (res) {
             alert('已取消');
          },
          fail: function (res) {
             alert(res);
          }
        });

        //alert('已注册获取“分享到朋友圈”状态事件');
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
});

wx.error(function(res){
	alert(res);
}
</script>
</html>