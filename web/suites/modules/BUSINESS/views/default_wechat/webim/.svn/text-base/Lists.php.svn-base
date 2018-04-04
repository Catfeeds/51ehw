<style type="text/css">
	.container {background: #F6F6F6;}
	.cart_num1 {position: absolute;right: 20%;top: 5px;width: auto;min-width: 14px;}
	.tribe_shop_footer ul li {width: 20%;}
</style>
<!-- 聊天消息 -->
<div class="chat_news">
     <ul>
	<?php 
	if (!empty($list)) {
	     foreach ($list as $key =>$v){
	         if(!empty($v['tribe_info'])){?>
	       <li>
	    	<a href="<?php echo site_url("Webim/Control/chats/{$v['chat_channel_id']}");?>">
	    	<div class="chat_news_left"><span><img src="<?php echo IMAGE_URL.$v['tribe_info']['logo']?>" alt="" onerror="this.src='images/51_logo.png'"></span>
            <?php if($v['Msg_count']>99){?>
	    		<i>99+</i>
	    	<?php }?>
	    	<?php if($v['Msg_count']<99&&$v['Msg_count']>0){?>
	    		<i><?php  echo $v['Msg_count'];?></i> 
	    	<?php }?>
	    	</div>
	    	<div class="chat_news_right">
	    		<p class="chat_news_right_name"><span><?php echo  $v['tribe_info']['name'];?><i class='chat_list_icon'><em class='icon-qunliao'></em>群聊</i></span><em><?php echo empty($v['Msg_info']) ? '':substr($v['Msg_info']['create_at'],0,10);?></em></p>
	    		<p>
	    		<?php if(empty($v['Msg_info'])){
	    		    echo '';
	    		}else if($v['Msg_info']['message_type']==1){
	    		    echo '[图片]';
	    		}else if($v['Msg_info']['message_type'] == 2){
	    		    echo $v['Msg_info']['message_url'];
	    		}else{
	    		    echo $v['Msg_info']['message'];
	    		}?>
	    		</p>
	    	</div>
	    	</a>
	    </li>
	<?php    }else{ 
	    $name = '';
	    $logo = '';
	    if($v['Send_info']['real_name']){
	        $name = $v['Send_info']['real_name'];
	    }else if($v['Send_info']['nick_name']){
	        $name = $v['Send_info']['nick_name'];
	    }else{
	        $name = $v['Send_info']['wechat_nickname'];
	    }
	    if($v['Send_info']['brief_avatar']){
	        $logo = IMAGE_URL.$v['Send_info']['brief_avatar'];
	    }else{
	        $logo = $v['Send_info']['wechat_avatar'];
	    }
	    ?>
	     <li>
	    	<a href="<?php echo site_url("Webim/Control/chat/{$v['tribe_id']}/{$v['Send_info']['from_customer_id']}");?>">
	    	<div class="chat_news_left"><img src="<?php echo $logo; ?>" alt="" onerror="this.src='images/member_defult.png'">
	    	<?php if($v['Msg_count']>99){?>
	    		<i>99+</i>
	    	<?php }?>
	    	<?php if($v['Msg_count']<99&&$v['Msg_count']>0){?>
	    		<i><?php  echo $v['Msg_count'];?></i> 
	    	<?php }?>
	    	</div>
	    	<div class="chat_news_right">
	    		<p class="chat_news_right_name"><span><?php echo $name;?></span><em><?php echo empty($v['Msg_info']) ? '':substr($v['Msg_info']['create_at'],0,10);?></em></p>
	    		<p>
	    		<?php if(empty($v['Msg_info'])){
	    		    echo '';
	    		}else if($v['Msg_info']['message_type']==1){
	    		    echo '[图片]';
	    		}else if($v['Msg_info']['message_type'] == 2){
	    		    echo $v['Msg_info']['message_url'];
	    		}else{
	    		    echo $v['Msg_info']['message'];
	    		}?>
	    		</p>
	    	</div>
	    	</a>
	    </li>
	 
	  
	<?php }
	     }
	}else{?>
	   <div style="text-align: center;padding: 20px;"><span>暂无更多消息</span></div>
	<?php }?>
	 </ul>
</div>	
<script>
$(function(){
	setInterval(function(){
		window.location.reload();
		},30000);
});
</script>

