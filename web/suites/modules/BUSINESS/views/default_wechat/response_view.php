<?php 

$text = "<xml><ToUserName><![CDATA[".$to."]]></ToUserName><FromUserName><![CDATA[".$from."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[".$type."]]></MsgType><Content><![CDATA[".$content."]]></Content><MsgId><![CDATA[".$msgid."]]></MsgId></xml>";

echo $text;
?>