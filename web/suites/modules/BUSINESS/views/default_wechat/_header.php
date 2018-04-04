<?php switch ($head_set){
	//旧版首页
	case 1:{?>
     <div class="header new_index_nav" name="top">
        <!--<a href="" target="_self" class="icon-fenlei"></a>-->
       <!--  <a href="#menu" target="_self" class="icon-fenlei"></a>
        <a href="<?php echo site_url('search/wechat_search');?>" target="_self" class="icon-search"></a>        
        <a href="<?php echo site_url('cart');?>" target="_self" class="icon-cartfill fn-right "> -->
       <!--  <span>
        <?php 
			$cartcount = 0;
			foreach($this->cart->contents() as $items){
			    $cartcount = $cartcount + $items['qty'];
			}
			echo $cartcount;
		?>
		</span></a> -->
        <!-- <a href="<?php echo site_url('member/info');?>" target="_self" class="icon-peoplefill fn-right "></a> -->
        <p class="title"><?php echo isset($title)?$title:$this->session->userdata('app_info')['app_name'];?><!-- <b class="icon-xiala"></b> --></p>
    </div><!--header end-->
	<div class="container"  id="leftTabBox">
<!--header end-->
<?php
        break;
           }
	// 无头部导航：个人中心、购物车、商品评论、订单详情、收货地址
    case 2:{?>
    <style type="text/css">
    .page{padding-top:0px;}
    </style>
    <div class="container"  id="leftTabBox"><!--header end-->
<?php
            break;
           }
	// 内页
    case 3:{
        $title = isset($title)?$title:$this->session->userdata('app_info')['app_name'];
        $back = isset($back)?site_url($back):'javascript:history.back()';
        ?>
     <div class="header new_index_nav" name="top">
       <a href="<?php echo $back;?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
       <p class="title"><?php echo $title=='分站点'?'当前站点－'.$title:$title;?></p>
    </div><!--header end-->
    <div class="container"  id="leftTabBox"><!--header end-->
<?php
            break;
           }
	// 
    case 4:{?>
    
<?php
            break;
           }
    // 新首页H5首页
    case 5:{?>
    <!-- 51易货网新版首页 开始 -->
    <div class="index_new_start">
    
    <!-- 头部搜索框 -->
    <div class="index_new_search_bg"  <?php if(!isset($Home)){ echo 'style="display: block;"';} ?>  ></div>
    <div class="index_new_search">
        <!-- 分站点入口 -->
    	<a href="<?php echo site_url('situs/wechat');?>" class="index_new_where"><span class="index_sort_where"><?php  echo isset($title)?$title:$this->session->userdata('app_info')['app_name'];?></span><span class="icon-xiala"></span></a>
    	<!-- 搜索入口 -->
    	<div class="index_new_search_box">
    		<a href="<?php echo site_url('search/wechat_search');?>"><span class="icon-search"></span><input type="text" value="" placeholder="搜索您想找的商品"></a>
    	</div>
    	<?php if(isset($Home)){?>
    	    <!-- 消息入口 -->
        	<a href="<?php echo site_url('Member/Message/MessageCenter')?>" class="index_new_xiaoxi icon-comment">
        	<?php if($Msg_status){?>
        	    <span></span>
        	<?php }?>
        	</a>
    	<?php }?>
    	
    </div>
    
    
    <!--<div class="new_index_nav" style="display: -webkit-inline-box;">
    	<div class="nav_sort"><a href="<?php //echo site_url('situs/wechat');?>"><span class="nav_sort_where">
    	<?php // echo isset($title)?$title:$this->session->userdata('app_info')['app_name'];?>
    	</span><span class="icon-xiala"></span></a></div>
    	<div class="nav_search">
    	<p><a href="<?php //echo site_url('search/wechat_search');?>" class="icon-sousuo"><input type="text" id="search_value" value="" placeholder="搜索您想找的商品"></a></p>
    	</div>
    	-->
        <!-- <div class="nav_scan"><img src="images/saoyisao.png" height="23" width="23" alt=""><a href="javascript:void(0);"><span>扫一扫</span></a></div> 
    </div>
    -->
    <div class="container"  id="leftTabBox">
<?php
            break;
           }
    // 登录
    case 6:{?>
        <div class="new_index_nav">
           <a href="<?php echo site_url('home');?>" class="icon-fanhui" style="color:#fff;position:fixed;top:18px;left:20px;font-size: 16px;"></a>
           <p style="color:#fff;font-size: 16px;line-height: 55px;">登录</p>
           <a href="<?php echo site_url("customer/registration");?>" style="color: #fff;position: absolute;right: 15px;top: 20px;font-size: 16px;">注册</a>
        </div><!--header end-->
    <div class="new_container" style="background-color: #dddddd;">
<?php
            break;
            }
    // 搜索框
    case 7:{?>
    <div class="" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;z-index: 999;">
        <a href="javascript:history.back(0);" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
        <form action="" method="post" id="form_search">
            <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
                <p style="background-color: #fff;width:85%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;margin-right:15px;">
                <a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
                <input type="text" class="search_input" name="search_index" value="<?php echo isset($keywords)?$keywords:"" ?>" placeholder="请输入关键词" 
                	style="width:85%;color:#606060;height:34px;background-color: #fff;border: none;font-size: 15px;"><!-- required 必输 -->
                <a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;">
                	<img src="images/search_close.png" height="15" width="15" alt="">
                </a>
                </p>
            </div>
        </form>
    </div>
    <div class="page">
<?php
            break;
            }
    // 我的资产
    case 8:{?>
		<div class="header new_index_nav" name="top">
            <a href="<?php echo site_url('member/info');?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
            <a href="<?php echo site_url('log/transaction_list')?>" class="detailed" style='color: #fff; position: fixed; right:0;'>交易记录</a>
            <p class="title">我的资产</p>
        </div><!--header end-->
    <div class="container"  id="leftTabBox">
<?php
            break;
            }
    // 我的收藏/浏览记录
    case 9:{?>
		<div class="header">
            <a href="<?php echo site_url('member/info');?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
            <a href="javascript:void(0);" class="detailed" id="widget_submit" style='color: #fff; position: fixed; right:0;'><?php echo $submit_type=="fav"?"编辑":"清空";?></a>
            <p class="title"><?php echo isset($title)?$title:$this->session->userdata('app_info')['app_name'];?></p>
        </div><!--header end-->
    <div class="container"  id="leftTabBox">
<?php
            break;
            }
    //默认
    default:{?>
         <div class="header" name="top">
           <a href="javascript:history.back()" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
           <p class="title"><?php echo isset($title)?($title=='分站点'?'当前站点－'.$title:$title):$this->session->userdata('app_info')['app_name'];?></p>
        </div><!--header end-->
    <div class="container"  id="leftTabBox">
<?php
            break;
            }
	}?>
	
    
<!-- 微信JSDK -->    
<?php
    if($this->session->userdata('app_info')['wechat_appid'] != NULL){
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
      timestamp: <?php echo $signPackage["timestamp"];?>,
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
      ]
  });

  wx.ready(function () {
	  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	  document.querySelector('#checkJsApi').onclick = function () {
	    wx.checkJsApi({
	      jsApiList: [
	        'getNetworkType',
	        'previewImage'
	      ],
	      success: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
	  };
    <?php if(!empty($wxevent)){;?>
        // 2. 分享接口
        // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
        <?php if(in_array("onMenuShareAppMessage",$wxevent)){;?>
        wx.onMenuShareAppMessage({
      		title: '<?php echo !empty($title)?$title:"51易货网";?>',
    		desc: '我在52易货网发现了一款不错的商品，赶快来看看吧!',
    		link: '<?php echo !empty($link)?link:current_url()."?parent_id=".$this->session->userdata("user_id");?>',
    		imgUrl: '<?php echo !empty($imgurl)?$imgurl:base_url()."/uploads/app/20150727182030.jpg";?>',
            trigger: function (res) {
            	console.log('用户点击发送给朋友');
            },
            success: function (res) {
            	console.log('已分享');
            },
            cancel: function (res) {
            	console.log('已取消');
            },
            fail: function (res) {
            	console.log(JSON.stringify(res));
            }
        });
        <?php };?>
        
    	// 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
        <?php if(in_array("onMenuShareTimeline",$wxevent)){;?>
        wx.onMenuShareTimeline({
        	title: '<?php echo !empty($title)?$title:"51易货网";?>',
        	link: '<?php echo !empty($link)?link:current_url()."?parent_id=".$this->session->userdata("user_id");?>',
        	imgUrl: '<?php echo !empty($imgurl)?$imgurl:base_url()."/uploads/app/20150727182030.jpg";?>',
            trigger: function (res) {
            	console.log('用户点击分享到朋友圈');
            },
            success: function (res) {
            	console.log('已分享');
            },
            cancel: function (res) {
            	console.log('已取消');
            },
            fail: function (res) {
            	console.log(JSON.stringify(res));
            }
        });
        <?php };?>
    
    <?php }else{;?>
        wx.hideAllNonBaseMenuItem({
            success: function () {
              console.log('已隐藏所有非基本菜单项');
            }
        });
    <?php };?>
  });
</script>
<?php };?>

<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>

<!-- 提示文本框隐藏js -->
<script type="text/javascript">
var base_url = "<?php echo site_url();?>";
</script>



