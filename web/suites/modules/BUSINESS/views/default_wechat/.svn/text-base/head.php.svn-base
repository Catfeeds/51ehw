<!DOCTYPE html>
<html lang="en" class="no-js"><head>
<meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no" />
<meta name="MobileOptimized" content="640">
<title><?php echo isset($title)?$title:'51易货网';?></title>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/swiper3.08.min.css">
<link rel="stylesheet" type="text/css" href="css/fonts.css">
<link rel="stylesheet" type="text/css" href="css/style1.css">
<link rel="stylesheet" type="text/css" href="css/swipes_style.css">
<link rel="stylesheet" type="text/css" href="css/swipeslider.css">
<link rel="stylesheet" type="text/css" href="css/WdatePicker.css">
<link rel="stylesheet" type="text/css" href="js/timechoice/mobiscroll.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/swiper3.08.jquery.min.js"></script>
<script type="text/javascript" src="js/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.parsley/parsley.js"></script>
<script type="text/javascript" src="js/behaviour/general.js"></script>
<script src="js/My97DatePicker/WdatePicker.js"></script>
<script src="js/timechoice/mobiscroll_002.js"></script>
<script src="js/timechoice/mobiscroll.js"></script>
<script src="js/Popt.js"></script>
<script src="js/cityJson.js"></script>


<?php 
//环信即时通信
$user_id = $this->session->userdata("user_id");
if($user_id){
    $logo = '';
    if(!empty($to_customer['logo'])){
        $logo = $to_customer['logo'];
    }
?>
<script type='text/javascript' src='js/webim/webim.config.js'></script>
<script type='text/javascript' src='js/webim/strophe-1.2.8.js'></script>
<script type='text/javascript' src='js/webim/websdk-1.4.11.js'></script>  
<script>
$.ajax({ 
    url:'<?php echo site_url("Webim/Control/getUser/{$user_id}")?>',
    type:'post',
    dataType:'json',
    data:{},
    success:function(data)
    {
        if(data.status == 5 ){
        	console.log("即时通信后台注册成功");
        	console.log(data.msg);
            }else{
            	console.log("即时通信后台注册失败");
            	console.log(data.msg);
                }
	},
    error:function()
    {
    	console.log("即时通信后台注册失败");
    }
})	
var conn = new WebIM.connection({  
    isMultiLoginSessions: WebIM.config.isMultiLoginSessions,  
    https: typeof WebIM.config.https === 'boolean' ? WebIM.config.https : location.protocol === 'https:',  
    url: WebIM.config.xmppURL,  
    heartBeatWait: WebIM.config.heartBeatWait,  
    autoReconnectNumMax: WebIM.config.autoReconnectNumMax,  
    autoReconnectInterval: WebIM.config.autoReconnectInterval,  
    apiUrl: WebIM.config.apiURL,  
    isAutoLogin: true  
}); 
var current_interval = 0;
var Channel_id = '<?php echo empty($Channel_id) ? 0:$Channel_id;?>';
var error_defult_img = "this.src='images/member_defult.png'";
conn.listen({
    onOpened: function ( message ) {          //连接成功回调
        // 如果isAutoLogin设置为false，那么必须手动设置上线，否则无法收消息
        // 手动上线指的是调用conn.setPresence(); 如果conn初始化时已将isAutoLogin设置为true
        // 则无需调用conn.setPresence();             
    },  
    onClosed: function ( message ) {},         //连接关闭回调
    onTextMessage: function ( message ) {
//         console.log(message);
         $.ajax({ 
 			 url:'<?php echo site_url("Webim/Control/getSingleChatlog")?>',
 			 type:'post',
		     dataType:'json',
		     data:{"Msg_id":message.ext.Msg_id},
  		     success:function(data)
 		     {
  		    	 console.log(data);
  		    	if( Channel_id != 0 && Channel_id == message.ext.Channel_id  && message.from != '<?php echo $user_id; ?>'){
  		    		 var myDate = new Date();//获取系统当前时间
 	  		    	 var stamp = Date.parse(myDate);
 	  		    	 var diff = stamp - current_interval;
 	  		    	 current_interval = stamp;
 	  		    	 var show = 'hidden';
 	  		    	 if(diff > 18000){
 	  		    		show = '';
 	  			    	}
 	  		    	 var dtime = timeDate();
 	  		    	 //在当前聊天室
 	 	  		     var result_str = '';
				
 	  		    	 result_str += '<li>';
 	  		    	 result_str += '<div class="personal_chat_time"'+show+'><span>'+dtime+'</span></div>';
 	  		    	 result_str += '<div class="personal_chat_img"><img src="'+data.user_logo+'"  onerror="'+error_defult_img+'" alt=""></div>	';
	 	  		 	 if(message.type == 'chat'){
						 //单人
		 	  		 	}else{
			 	  		 result_str += 	'<span class="personal_chat_name_left">'+data.user_name+'</span>';
						 }	
 	  		    	 result_str += '<em class="personal_chat_triangle_left"></em>';
 	  		    	 result_str += '<div class="personal_chat_content">';
 	  			     if(data.message_type == 0){
 	  			    	result_str += '<span>'+data.message+'</span>';
 	  		    	    }else if(data.message_type == 1){
 	  		    	    	result_str += '<img src="'+data.message_url+'" alt="">';
 	  		        	    }else if(data.message_type == 2){
 	  		        	    	result_str += '<span><a href="'+data.message_url+'">'+data.message_url+'</a></span>';
 	  		            	    }
 	  			     result_str += '</div>';
 	  			     result_str += ' </li>';
						 
 	  				 $("#chat_wrap").append(result_str);
 	 		    	 slide();
  	 		    	 refashMsgStatus(Channel_id);
  	  	 		     }else if(message.from != '<?php echo $user_id; ?>'){
  	  	  	 		    <?php 
						 if(empty($chatListTag)){
						 //消息列表不提醒
						 ?>
						 changeBullet(data);
		  	  	 		 refashNotReadCount(message.ext.tribe_id);
						 <?php }?>	
  	  	  	 		     }
 			 },
 		     error:function()
 		     {
 		    	console.log("接收信息失败");
 		     }
 	   	 })	
        },    //收到文本消息
    onEmojiMessage: function ( message ) {
    	
      },   //收到表情消息
    onPictureMessage: function ( message ) {
    	$.ajax({ 
			 url:'<?php echo site_url("Webim/Control/getSingleChatlog")?>',
			 type:'post',
		     dataType:'json',
		     data:{"Msg_id":message.ext.Msg_id},
		     success:function(data)
		     {
		    	if( Channel_id != 0 && Channel_id == message.ext.Channel_id && message.from != '<?php echo $user_id; ?>'){
		    		var myDate = new Date();//获取系统当前时间
	  		    	 var stamp = Date.parse(myDate);
	  		    	 var diff = stamp - current_interval;
	  		    	 current_interval = stamp;
	  		    	 var show = 'hidden';
	  		    	 if(diff > 18000){
	  		    		show = '';
	  			    	}
		  		     var dtime = timeDate();
		  		     
	  		    	 //在当前聊天室
	  		    	 var result_str = '';
	  		    	 result_str += '<li>';
	  		    	 result_str += '<div class="personal_chat_time"'+show+'><span>'+dtime+'</span></div>';
	  		    	 result_str += '<div class="personal_chat_img"><img src="'+data.user_logo+'"  onerror="'+error_defult_img+'" alt=""></div>	';
	  		    	 if(message.type == 'chat'){
						 //单人
		 	  		 	}else{
			 	  		 result_str += 	'<span class="personal_chat_name_left">'+data.user_name+'</span>';
						 }	
	  		    	 result_str += '<em class="personal_chat_triangle_left"></em>';
	  		    	 result_str += '<div class="personal_chat_content">';
	  			     if(data.message_type == 0){
	  			    	result_str += '<span>'+data.message+'</span>';
	  		    	    }else if(data.message_type == 1){
	  		    	    	result_str += '<img src="'+data.message_url+'" alt="">';
	  		        	    }else if(data.message_type == 2){
	  		        	    	result_str += '<span><a href="'+data.message_url+'">'+data.message_url+'</a></span>';
	  		            	    }
	  			     result_str += '</div>';
	  			     result_str += ' </li>';
	  				 $("#chat_wrap").append(result_str);
	 		    	 slide();
		 		     refashMsgStatus(Channel_id);
	  	 		     }else if(message.from != '<?php echo $user_id; ?>'){
	  	  	 		    <?php 
						 if(empty($chatListTag)){
						 //消息列表不提醒
						 ?>
						 changeBullet(data);
		  	  	 		 refashNotReadCount(message.ext.tribe_id);
						 <?php }?>	
	  	  	 		     }
			 },
		     error:function()
		     {
		    	console.log("接收信息失败");
		     }
	   	 })
        }, //收到图片消息
    onCmdMessage: function ( message ) {},     //收到命令消息
    onAudioMessage: function ( message ) {},   //收到音频消息
    onLocationMessage: function ( message ) {},//收到位置消息
    onFileMessage: function ( message ) {},    //收到文件消息
    onVideoMessage: function (message) {
        var node = document.getElementById('privateVideo');
        var option = {
            url: message.url,
            headers: {
              'Accept': 'audio/mp4'
            },
            onFileDownloadComplete: function (response) {
                var objectURL = WebIM.utils.parseDownloadResponse.call(conn, response);
                node.src = objectURL;
            },
            onFileDownloadError: function () {
                console.log('File down load error.')
            }
        };
        WebIM.utils.download.call(conn, option);
    },   //收到视频消息
    onPresence: function ( message ) {},       //处理“广播”或“发布-订阅”消息，如联系人订阅请求、处理群组、聊天室被踢解散等消息
    onRoster: function ( message ) {},         //处理好友申请
    onInviteMessage: function ( message ) {},  //处理群组邀请
    onOnline: function () {},                  //本机网络连接成功
    onOffline: function () {},                 //本机网络掉线
    onError: function ( message ) {},          //失败回调
    onBlacklistUpdate: function (list) {       //黑名单变动
        // 查询黑名单，将好友拉黑，将好友从黑名单移除都会回调这个函数，list则是黑名单现有的所有好友信息
        console.log(list);
    },
    onReceivedMessage: function(message){
        console.log(message)
        },    //收到消息送达服务器回执
    onDeliveredMessage: function(message){},   //收到消息送达客户端回执
    onReadMessage: function(message){},        //收到消息已读回执
    onCreateGroup: function(message){},        //创建群组成功回执（需调用createGroupNew）
    onMutedMessage: function(message){}        //如果用户在A群组被禁言，在A群发消息会走这个回调并且消息不会传递给群其它成员
});
var options = { 
		  apiUrl: WebIM.config.apiURL,
		  user: '<?php echo $user_id;?>',
		  pwd: '51ehwhuanxin',
		  appKey: WebIM.config.appkey
		};
conn.open(options);
function refashMsgStatus(Channel_id){
	//更新信息
	 $.ajax({ 
		 url:'<?php echo site_url("Webim/Control/updateList")?>/'+Channel_id,
		 type:'post',
	     dataType:'json',
	     data:{},
	   success:function(data)
	    {
	    	console.log("更新信息成功");
		},
	    error:function()
	    {
	    	console.log("更新信息失败");
	    }
  	 })	
}
function refashNotReadCount(tribe_id){
	$.ajax({
		url:'<?php echo site_url("Webim/Control/getNotReadCount")?>/'+tribe_id,
	    type:'post',
	    dataType:'json',
	    data:{},
	    success:function(data)
	    {
	   	  console.log("获取未读消息成功");
	   	  $("#huanxin_chatNum").html(data.MsgCount);
	     	
	    },
	    error:function()
	    {
	        console.log("获取未读消息失败");
	    }
	})
}

var BulletStatus = 0;//默认隐藏
function changeBullet(data){
	 if(data.tribe_id){
		 //群聊提示
		 $("#inform_ball_a").attr("src",data.url);
		 if(data.logo){
			 $("#inform_ball_img").attr("src",data.logo);
			 }
		 $("#inform_ball_img").attr("onerror","this.src='images/51_logo.png'");
		 $("#inform_ball_span").html(data.name);
		 //0表示文本消息包含表情，1表示图片消息，2表示外链信息
		 if(data.message_type == 1){
			 $("#inform_ball_content").html('[图片]');
			 }else if(data.message_type == 2){
				 $("#inform_ball_content").html(data.message_url);
				 }else{
					 $("#inform_ball_content").html(data.message);
					 }
		}else{
		//单人聊天提示
			$("#inform_ball_a").attr("src",data.url);
			 if(data.user_logo){
				 $("#inform_ball_img").attr("src",data.user_logo);
				 }
			 $("#inform_ball_img").attr("onerror","this.src='images/member_defult.png'");
			 $("#inform_ball_span").html(data.user_name);
			 //0表示文本消息包含表情，1表示图片消息，2表示外链信息
			 if(data.message_type == 1){
				 $("#inform_ball_content").html('[图片]');
				 }else if(data.message_type == 2){
					 $("#inform_ball_content").html(data.message_url);
					 }else{
						 $("#inform_ball_content").html(data.message);
						 }
	  }
	  if(!BulletStatus){
		  //隐藏
		  //全站提醒信息
	 	  $(".inform_ball").show();
	  	  BulletStatus = 1;//显示
		   setTimeout(function(){
					$(".inform_ball").hide();
					BulletStatus = 0;//隐藏
					}, 3500);
		  }
}

//获取当前时间
function p(s) {
    return s < 10 ? '0' + s: s; //返回是个位数的时候前面加0
    time();
}
function timeDate() {
    var myDate = new Date();
    //获取当前年
    var year=myDate.getFullYear();
    //获取当前月
    var month=myDate.getMonth()+1;
    //获取当前日
    var date=myDate.getDate(); 
    var h=myDate.getHours();  //获取当前小时数(0-23)
    var m=myDate.getMinutes();//获取当前分钟数(0-59)
    var s=myDate.getSeconds();//获取当前秒数(0-59)  
    // 年月日时分秒
    var time_01 =year+'-'+p(month)+"-"+p(date)+" "+p(h)+':'+p(m)+":"+p(s);
    // 年月日时分
    var time_02 =year+'-'+p(month)+"-"+p(date)+" "+p(h)+':'+p(m);
    // 年月日时
    var time_03 =year+'-'+p(month)+"-"+p(date)+" "+p(h);
    // 年月日
    var time_04 =year+'-'+p(month)+"-"+p(date);
    // 年月
    var time_05 =year+'-'+p(month);
    // 年
    var time_06 =year;
    return time_02;
}
</script>
<?php }?>
<script>
function prompt(){
	$(".black_feds").toggle();
}
function show_prompt(){ 
	$("#pay_").css('background-color','#FECF0A');
	$("#pay_").text('确定支付');
}

</script>
<style type="text/css">
	.error{
		font-size: 14px;
	    color: #cd1a1a;
	    vertical-align: middle;
	    margin-left: 10px;
	    box-shadow: 0 0 black;
	}
	<?php if( $this->session->userdata("labe_foot_nav_color") ){ ?>
	
	<?php $color = $this->session->userdata("labe_foot_nav_color").'!important'; ?>
	   .custom_button{ background:<?php echo $color?>;}
	   .custom_color{ color:<?php echo $color?>;}
	   .custom_color_border{ color:<?php echo $color?>;border-bottom-color:<?php echo $color?>;}
	   .essay_active_a { color:<?php echo $color?>;border-bottom-color:<?php echo $color?>;}
	   .bounceIn {color:<?php echo $color?>;}
	   .classifyBox_current {color:<?php echo $color?>;}
	   .client_commodity_block_active {color:<?php echo $color?>;}
	   .address_color {color:<?php echo $color?>;}
	   .custom_border{ background:<?php echo $color?>;border-color:<?php echo $color?>;}
	   .my-needs-nav-active-li {border-bottom-color:<?php echo $color?>;}
	   .my-needs-nav-active-li a {color:<?php echo $color?>;}
	   .active-line {border-bottom-color:<?php echo $color?>;}
	   .active_nav {color:<?php echo $color?>;}
	   .ner_x ul li .ner_x_r a {border-color:<?php echo $color?>;}
	   .tribe_shop_footer_active {color:<?php echo $color?>;}
	   .icon-choose {color:<?php echo $color?>;}
	   .tribe-go-count {background:<?php echo $color?>;}
	   .cf {color:<?php echo $color?>;}
	   .purchase-finish_button button {background:<?php echo $color?>;border-color:<?php echo $color?>;}
	   .business_record_active {color:<?php echo $color?>;}
	   .needs-offer-qita-active {color:<?php echo $color?>;}
	   .active_color {color:<?php echo $color?>;}
	   .commodity_record_send {border-color:<?php echo $color?>;}
	   .commodity_detail_send {background:<?php echo $color?>;}
	   .commerce_publish_colse {color:<?php echo $color?>;}
	   .offer-details-confirm { background:<?php echo $color?>;}
	   .yellow-but { background:<?php echo $color?>;}
	   .bg-red {background:<?php echo $color?>;}
	   .order_list_cancel {background:<?php echo $color?>;border-color:<?php echo $color?>;}
	   .circle_publish_jia {background:<?php echo $color?>;}
	   .search_but a {color:<?php echo $color?>;}
	   .commodity_send_bt button {background:<?php echo $color?>;border-color:<?php echo $color?>;}
	   #check_binding_button {background:<?php echo $color?>;border-color:<?php echo $color?>;}
	   .tribal_customization_bottom a { background:<?php echo $color?>;}
	   .publish_inform_active {color:<?php echo $color?>;}
	   .publish_accept a em {color:<?php echo $color?>;}
	   .new_order-nav-active a {color:<?php echo $color?>;border-bottom-color:<?php echo $color?>;}
	   .register-button {background:<?php echo $color?>;}
	   .password-button { background:<?php echo $color?>;}
	   .input_but_class {color:<?php echo $color?>;}
/*	   .commerce_message_footer a {background:<?php echo $color?>;}
	   .commerce_yuan {background:<?php echo $color?>;}*/
	   .aui-switch:checked {background:<?php echo $color?>;border-color:<?php echo $color?>;}
	<?php }?>
	
</style>
</head>
<body>
<!-- 消息通知 -->
<div class="inform_ball" hidden>
   <a id='inform_ball_a' href="javascript:void(0);">
   <p><img  id='inform_ball_img' src="images/member_defult.png"  onerror="" alt=""></p>
   <p><span id='inform_ball_span'>西北部落</span><span id="inform_ball_content">有0条消息未读</span></p>
   </a>
</div>