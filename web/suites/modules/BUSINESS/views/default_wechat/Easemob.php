<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/webim/webim.config.js'></script>
<script type='text/javascript' src='js/webim/strophe-1.2.8.js'></script>
<script type='text/javascript' src='js/webim/websdk-1.4.11.js'></script>
<style>  
/**重置标签默认样式*/   
    * {   
        margin: 0;   
        padding: 0;   
        list-style: none;   
        /*font-family: '微软雅黑'   */
    }     
      img {   
        width:50px;   
        height:50px;   
    }   
    .content {   
        font-size: 15px;   
        width:100%;   
        overflow: auto;   
        margin-top: 10px;
        padding:0px;  
    } 
     .content li {    
        width:100%;   
        display: block;   
        clear: both;   
        overflow: hidden;   
    } 
    .content li img {   
        float: left;   
    	margin: 0px 10px;
    	
    }   
    .content li span{   
        background: #fff;   
        padding: 5px;   
        border-radius: 5px;   
        float: left;   
        margin: 5px 10px 0 -1px;   
        max-width: 60%;   
        border: 1px solid #fff;   
        box-shadow: 0 0 3px #ccc;  
    	word-wrap:break-word; 
    }  
    .content p {
       width: 40%;
       height:20px;
       line-height:20px;
       text-align: center;
       background: #dcdcdc;
       color: #fff;
       font-size:12px;
       margin-left:30%;
       margin-top: 20px;
       margin-bottom: 10px;
    }
    /*右边*/
    .content-right p {
        width: 40%;
        height:20px;
        line-height:20px;
        text-align: center;
        background: #dcdcdc;
        color: #fff;
        font-size:12px;
        margin-left:30%;
        margin-top: 20px;
        margin-bottom: 10px; 
    }
     .content-right img {
        float: right;
     	margin: 0px 10px;
     }
    .content-right {
        font-size: 15px;   
        width:100%;   
        overflow: auto;   
        margin-top: 10px;
    }
    .content-right li span{   
        background: #fff;   
        padding: 5px;   
        border-radius: 5px;   
        float: right;   
        margin: 6px -2px 0 10px;   
        max-width: 60%;   
        border: 1px solid #C8C8C8;   
        box-shadow: 0 0 3px #ccc;  
    	word-wrap:break-word; 
    }
    .wrap{
	padding-top: 50px;
    margin-bottom: 50px;
    height: calc(100% - 100px);
    overflow: hidden;
    } 
    .new_index_nav .title{
	text-align: left;
    margin-left: 40px;
    }
.search_gongg{display: -webkit-box; display: -moz-box; display: -ms-flexbox;display: box;}
.foot_bottom {
    position: fixed;
    bottom: 0;
    width: 100%;
    border-top: 1px solid #cccccc;
    z-index: 799;
    background: #fff;
}.foot_xia{
    box-sizing: border-box;
    box-flex: 1;
    -webkit-box-flex: 1;
    -moz-box-flex: 1;
    -ms-flex: 1;
    }
#form_article{width: calc(100% - 65px);max-height:80px;overflow-y: auto;border-right:1px solid #dddddd;border-radius:0;min-height:26px;padding:10px 5px;outline:none;}
#form_article::-webkit-scrollbar {width: 0;}
.send_t_btn{
    height:38px;
	line-height:38px;
	text-align:center;
    display: inline-block;
    border-radius: 2px;
	font-size:13px;
	position:absolute; bottom:0px; right:0;
    width: 65px;
    background: #ffd600;
    color: #fff;
	
}
.send_fail{
	font-size: 12px;
    float: right;
    padding-top: 6px;
    margin-right: 15px;
}
.send_fail a{
	color: #460a8e;
}


</style>  
<body>
<div class="wrap">
<!--  
 <div class="left">
 		   <ul class="content">
               <li>
                  <p>22:50</p> 
                   <img src="images/admin.jpeg">
                   <span>您好！</span>
               </li>
           </ul>
 </div>
 <div class="right">
 		  <ul class="content-right">
               <li>
                    <p>23:13</p> 
                   <img src="images/shy.jpeg">
                   <span>你好！</span>
               </li>
           </ul>
 </div>
 -->
</div>
<div class="foot_bottom search_gongg">
         <div class="foot_xia">
             <div id="form_article" contenteditable="true"></div>
          </div>   
            <span onclick="sendText()" class="send_t_btn">发送</span>
        </div>
</body>
<script>
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
var error_img = "this.src='images/member_defult.png'";
conn.listen({
    onOpened: function ( message ) {          //连接成功回调
        // 如果isAutoLogin设置为false，那么必须手动设置上线，否则无法收消息
        // 手动上线指的是调用conn.setPresence(); 如果conn初始化时已将isAutoLogin设置为true
        // 则无需调用conn.setPresence();             
    },  
    onClosed: function ( message ) {},         //连接关闭回调
    onTextMessage: function ( message ) {
        
		var result = '';
		result += '<div class="left">';
		result += '<ul class="content">';
		result += '<li>';
		result += '<img src="<?php echo $to_customer['logo'];?>" onerror='+error_img+'>';
		result += ' <span>'+message.data+'</span>';
		result += '</li>';
		result += '</ul>';
		result += '<div>';
		$(".wrap").append(result);
        },    //收到文本消息
    onEmojiMessage: function ( message ) {},   //收到表情消息
    onPictureMessage: function ( message ) {}, //收到图片消息
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
    onReceivedMessage: function(message){},    //收到消息送达服务器回执
    onDeliveredMessage: function(message){},   //收到消息送达客户端回执
    onReadMessage: function(message){},        //收到消息已读回执
    onCreateGroup: function(message){},        //创建群组成功回执（需调用createGroupNew）
    onMutedMessage: function(message){}        //如果用户在A群组被禁言，在A群发消息会走这个回调并且消息不会传递给群其它成员
});

var options = { 
		  apiUrl: WebIM.config.apiURL,
		  user: '<?php echo $from_customer['id'];?>',
		  pwd: '51ehwhuanxin',
		  appKey: WebIM.config.appkey
		};
conn.open(options);

function sendText(parms){
	if(!parms){
		var obj = $("#form_article").html();
		}else{
			$('#'+parms+'<?php echo $from_customer['id'];?>').hide();
			var obj = $('#'+parms+'<?php echo 'Text'.$from_customer['id'];?>').html();
			}
	
	var timestamp = Date.parse(new Date());
	
	 $.ajax({ 
		    url:'<?php echo site_url('Webim/Control/sendText')?>',
		    type:'post',
		    dataType:'json',
		    data:{'user':<?php echo $to_customer['id'];?>,'content':obj},
		    beforeSend:function()
      		{ 
		    	var result = '';
				result += '<div class="right" id="'+timestamp+'<?php echo $from_customer['id'];?>">';
				result += '<ul class="content-right">';
				result += '<li>';
				result += '<div style="overflow: hidden;"><img src="<?php echo $from_customer['logo'];?>" onerror='+error_img+'>';;
				result += '<span id="'+timestamp+'<?php echo 'Text'.$from_customer['id'];?>">'+obj+'</span></div>';
                var href = 'javascript:sendText('+timestamp+')';
				result += '<div class="send_fail" id ="'+timestamp+'fail" hidden>发送失败,<a href= '+href+' >重新发送</a></div>';
				result += '</li>';
				result += '</ul>';
				result += '<div>';
				$(".wrap").append(result);
				$("#form_article").html('');
      		},
		    success:function(data)
		    {
		    	console.log("发送成功");
			},
		    error:function()
		    {
		    	$('#'+timestamp+'fail').show();
		    	$(".black_feds").text("发送失败,请重试").show();
		        setTimeout("prompt();", 2000);   
			    return;
		    }
	    })	
}
</script>
</html>

