<!-- 分享货包 -->
<div class="send_red_packet_share">
  <img src="images/goods_share_bg.png" alt="">
</div>
<?php
    if($this->session->userdata('app_info')['wechat_appid'] != NULL){
        $this->load->library("js_api_sdk");
        $this->js_api_sdk = new js_api_sdk();
        $this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
        $signPackage = $this->js_api_sdk->GetSignPackage();
    }
?>
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



wx.ready(function(){ 
        wx.onMenuShareAppMessage({
            title: '<?php echo "51易货网货包大放送";//$headline;?>',
            desc: '<?php echo str_replace(array("\r\n", "\r", "\n"), " ", $desc);?>',
            link: '<?php echo $url;?>',
            imgUrl: '<?php echo THEMEURL . 'images/weixinhuobao01.png';?>',
            trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
             //alert('用户点击发送给朋友');
            },
            success: function (res) {
            	var type = "<?php echo !empty($type);?>";
                if(type){
                    $.post("<?php echo site_url("corporate/card_package/give/$id");?>",function(data){
                        })
                }
            },
            cancel: function (res) {
             //alert('已取消');
            },
            fail: function (res) {
             //alert(res);
            }
        });

        wx.onMenuShareTimeline({
    	  title: '<?php echo $headline;?>',
    	  link: '<?php echo $url;?>',
    	  imgUrl: '<?php echo THEMEURL . 'images/weixinhuobao01.png';?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
             //alert('用户点击分享到朋友圈');
          },
          success: function (res) {
             //alert('已分享');
              var type = "<?php echo !empty($type);?>";
              if(type){
                  $.post("<?php echo site_url("corporation/card_package/give/$id");?>",function(data){
                      })
              }
          },
          cancel: function (res) {
             //alert('已取消');
          },
          fail: function (res) {
             //alert(res);
          }
        });

        //alert('已注册获取“分享到朋友圈”状态事件');
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
});
</script>
</html>