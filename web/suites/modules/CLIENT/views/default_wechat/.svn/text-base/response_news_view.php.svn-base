 <?php 
 if($style == 'news'){?>
 <xml>
 <ToUserName><![CDATA[<?=$to?>]]></ToUserName>
 <FromUserName><![CDATA[<?=$from?>]]></FromUserName>
 <CreateTime><?=time()?></CreateTime>
 <MsgType><![CDATA[<?=$type?>]]></MsgType>
 <ArticleCount><?=count($contents)?></ArticleCount>
 <Articles>
 <?php foreach($contents as $content){?>
 <item>
 <Title><![CDATA[<?=$content['title']?>]]></Title> 
 <Description><![CDATA[<?=strip_tags($content['content'])?>]]></Description>
 <PicUrl><![CDATA[<?=$content['title_img']?>]]></PicUrl>
 <Url><![CDATA[<?=site_url('content/detail/'.$content['id']);?>]]></Url>
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
 <Title><![CDATA[<?=$content[$i]['title']?>]]></Title> 
 <Description><![CDATA[<?=strip_tags($content[$i]['content'])?>]]></Description>
 <PicUrl><![CDATA[<?=base_url($content[$i]['title_img']);?>]]></PicUrl>
 <Url><![CDATA[<?=site_url('content/detail/'.$content[$i]['id']);?>]]></Url>
 </item>
 <?php }?>
 </Articles>
 </xml> 
 <?php }?>
 