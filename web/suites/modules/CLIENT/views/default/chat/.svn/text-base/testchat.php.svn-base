<html>
<head>
<meta charset="utf-8">
<title>WebSoket Demo</title>
<script type="text/JavaScript">
            //验证浏览器是否支持WebSocket协议
            if (!window.WebSocket) {
                alert("WebSocket not supported by this browser!");
            }
             var ws;
            function display() {
                //var valueLabel = document.getElementById("valueLabel");
                //valueLabel.innerHTML = "";
                ws=new WebSocket("ws://localhost:9236/");
                //监听消息
                ws.onmessage = function(event) {
                    //valueLabel.innerHTML+ = event.data;
                    log(event.data);
                };
                // 打开WebSocket
                ws.onclose = function(event) {
                  //WebSocket Status:: Socket Closed
                };
                // 打开WebSocket
                ws.onopen = function(event) {
                   //WebSocket Status:: Socket Open
                    //// 发送一个初始化消息
                    ws.send("欢迎光临!");
                };
                ws.onerror =function(event){
                    //WebSocket Status:: Error was reported
                };
            }
            var log = function(s) {
   if (document.readyState !== "complete") {
       log.buffer.push(s);
   } else {
       document.getElementById("contentId").innerHTML += (decodeURI(s) + "\n");
   }
}
            function sendMsg(){
                var msg=document.getElementById("messageId");
                //alert(msg.value);
                ws.send(msg.value);
            }
        </script>
</head>
<body onload="display();">
	<div id="valueLabel"></div>
	<textarea rows="20" cols="30" id="contentId"></textarea>
	<br />
	<input name="message" id="messageId" />
	<button id="sendButton" onClick="javascript:sendMsg()">发出</button>
</body>
</html>