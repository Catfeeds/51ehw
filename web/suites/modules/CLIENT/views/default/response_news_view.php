 <?php if($style == 'news'){?>
 <xml>
 <ToUserName><![CDATA[<?=$to?>]]></ToUserName>
 <FromUserName><![CDATA[<?=$from?>]]></FromUserName>
 <CreateTime><?=time()?></CreateTime>
 <MsgType><![CDATA[<?=$type?>]]></MsgType>
 <ArticleCount><?=count($contents)?></ArticleCount>
 <Articles>
 <?php foreach($contents as $content){?>
 <item>
 <Title><![CDATA[<?=$content['name']?>]]></Title> 
 <Description><![CDATA[<?=strip_tags($content['description'])?>]]></Description>
 <PicUrl><![CDATA[<?php echo $content['wechat_image']?>]]></PicUrl>
 <?php if(is_null($content['jump_url'])){?>
 <Url><![CDATA[<?php echo site_url('/wx_controller/get_product/'.$content['id']);?>]]></Url>
 <?php } else {?>
 <Url><![CDATA[<?=$content['jump_url']?>]]></Url>
 <?php }?>
 </item>
 <?php }?>
 </Articles>
 </xml> 
 <?php } else {?>
 <xml>
 <ToUserName><![CDATA[<?=$to?>]]></ToUserName>
 <FromUserName><![CDATA[<?=$from?>]]></FromUserName>
 <CreateTime><?=time()?></CreateTime>
 <MsgType><![CDATA[<?=$type?>]]></MsgType>
 <ArticleCount><?=count($content)?></ArticleCount>
 <Articles>
 <?php for($i = 0; $i < count($content);$i++){?>
 <item>
 <Title><![CDATA[<?=$content[$i]['name']?>]]></Title> 
 <Description><![CDATA[<?=strip_tags($content[$i]['description'])?>]]></Description>
 <PicUrl><![CDATA[<?=base_url($content[$i]['productimage']);?>]]></PicUrl>
 <Url><![CDATA[<?=site_url('wx_controller/get_product/'.$content[$i]['id']);?>]]></Url>
 </item>
 <?php }?>
 </Articles>
 </xml> 
 <?php }?>
 