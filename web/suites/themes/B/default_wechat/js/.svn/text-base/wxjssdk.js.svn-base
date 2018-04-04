 /*
   * 注意：
   * 友情提示：微信JSSDK方法，后续需要扩展方法的话到官网查询相关方法，补上即可，各方法不需要处理结果则无视。
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */

//初始化。
var WxJssdk = function (appId, timestamp,nonceStr,signature)
{
	
    //初始化配置。
    wx.config({
    	debug: true,
        appId: appId,
        timestamp: timestamp,
        nonceStr: nonceStr,
        signature: signature,
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

   
	//初始化。
	wx.ready(function () {
		
		//查看地址-打开地图
		WxJssdk.openLocation = function (latitude,longitude,name,address,scale,infoUrl)
		{ 
			wx.openLocation({
	 	        latitude: latitude,//23.099994,//纬度
	 	        longitude: longitude,//113.324520,//经度
	 	        name: name,//右下角目标名称，例如：天天超市
	 	        address: address,//右下角目标详细地址，例如：广州市番禺区南浦丰收路26号
	 	        scale: scale,//14 地图缩放级别。
	 	        infoUrl: infoUrl//底部查看更多的转跳连接
	 	    });
		}
		
		 
		//获取当前地址
		WxJssdk.getLocation = function (type)
		{
			var result = {};result.status = 0;//初始化
			
		    wx.getLocation({
		    	type: type, // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
		        success: function (res) {
		        	result.status = 1;//成功
		        	result.latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		        	result.longitude = res.longitude ; // 经度，浮点数，范围为180 ~ -180。
		        	result.speed = res.speed; // 速度，以米/每秒计
		        	result.accuracy = res.accuracy; // 位置精度
		        },
		        cancel: function (res) 
		        {
		        	result.status = 2;//取消
		        	result.messgae = '用户拒绝授权获取地理位置';
		        }
		    });
		    
		    return result;
		}
		
		
		//分享给微信朋友
		WxJssdk.ShareFriend = function (title,desc,link,imgUrl)
		{ 
			var result = {};result.status = 0;//初始化
			
			wx.onMenuShareAppMessage({
				
				title: title,
			    desc: desc,
			    link: link,
			    imgUrl: imgUrl,
			    trigger: function (res) 
			    {
			        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
			    	result.message = '用户发送给朋友';
			    	result.status = 1;
			    },
			    success: function (res)
			    {
			    	result.message = '已分享';
			    	result.status = 2;
			    },
			    cancel: function (res) 
			    {
			    	result.message = '已取消';
			    	result.status = 3;
			    },
			    fail: function (res) 
			    {
			    	console.log(JSON.stringify(res));
			    }
			    
		    });
			
			return result;
		}
		
		//分享微信朋友圈
		WxJssdk.Share = function (title,link,imgUrl)
		{ 
			var result = {};result.status = 0;//初始化
			
	        wx.onMenuShareTimeline({
	            title: title,
			    link: link,
			    imgUrl: imgUrl,
			    trigger: function (res) 
			    {
			        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
			        result.message = '用户分享到朋友圈';
				    result.status = 1;
			    },
			    success: function (res)
			    {
			        result.message = '已分享';
				    result.status = 2;
			    },
			    cancel: function (res)
			    {
			        result.message = '已取消';
				    result.status = 3;
			    },
			    fail: function (res) 
			    {
			    	console.log('fail:'+JSON.stringify(res));
			    }
		    });
	        
	        return result;
		}
		
		
		//分享到QQ.
		WxJssdk.ShareQQ = function (title,desc,link,imgUrl)
		{ 
			var result = {};result.status = 0;//初始化
			
		    wx.onMenuShareQQ({
		    	title: title,
			    desc: desc,
			    link: link,
			    imgUrl: imgUrl,
			    trigger: function (res)
			    {
			    	result.message = '用户点击分享到QQ';
				    result.status = 1;
				},
			    complete: function (res)
			    {
			    	//回调函数。
			    	console.log('complete:'+JSON.stringify(res));
			    },
			    success: function (res)
			    {
			        result.message = '已分享';
				    result.status = 2;
			    },
			    cancel: function (res)
			    {
			    	result.message = '已取消';
				    result.status = 3;
			    },
			    fail: function (res)
			    {
			    	console.log('fail:'+JSON.stringify(res));
			    }
			});
		    
		    return result;
		}
		
		//分享到腾讯微博
		WxJssdk.ShareWeibo = function (title,desc,link,imgUrl)
		{ 
			var result = {};result.status = 0;//初始化
			
	        wx.onMenuShareWeibo({
	        	title: title,
		        desc: desc,
		        link: link,
		        imgUrl: imgUrl,
		        trigger: function (res)
		        {
		        	result.message = '用户点击分享到微博';
				    result.status = 1;
		        },
		        complete: function (res){
		        	//回调函数
		        	console.log('complete:'+JSON.stringify(res));
		        },
		        success: function (res) 
		        {
		        	result.message = '已分享';
				    result.status = 2;
				},
		        cancel: function (res) 
		        {
		        	result.message = '已取消';
				    result.status = 3;
		        },
		        fail: function (res) 
		        {
		        	console.log('fail:'+JSON.stringify(res));
		        }
	        });
	        
	        return result;
	    }
		
		//分享到QQ空间。
		WxJssdk.ShareQZone = function (title,desc,link,imgUrl)
	    { 
			var result = {};result.status = 0;//初始化
			
			wx.onMenuShareQZone({
			    title: title,
			    desc: desc,
			    link: link,
			    imgUrl:imgUrl,
			    trigger: function (res)
			    {
			    	result.message = '用户点击分享到QZone';
				    result.status = 1;
			    },
			    complete: function (res) 
			    {
			    	//回调函数
			    	console.log('complete:'+JSON.stringify(res));
			    },
			    success: function (res)
			    {
			    	result.message = '已分享';
				    result.status = 2;
			    },
			    cancel: function (res)
			    {
			    	result.message = '已取消';
				    result.status = 3;
			    },
			    fail: function (res)
			    {
			    	console.log('fail:'+JSON.stringify(res));
			    }
		    });
			
			return result;
	    }
		
		//隐藏界面操作接口-分享等。
		WxJssdk.hideOptionMenu = function ()
		{ 
			wx.hideOptionMenu();
		}
		
		//显示界面操作接口-分享等。
		WxJssdk.showOptionMenu = function ()
		{ 
			wx.showOptionMenu();
		}
		
		
    });
    
	//检测是否有权限-有需要才用。
//    wx.checkJsApi({
//        jsApiList: [
//            'getLocation',
//            'onMenuShareTimeline',
//            'onMenuShareAppMessage'
//        ],
//        success: function (res) {
//            console.log(JSON.stringify(res));
//        }
//    });

    
  //error
//	  wx.error(function(res){
//		  console.log('err', res)
//	  });
    
   
}








  