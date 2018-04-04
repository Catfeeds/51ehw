<style type="text/css">
	.container {background: #F6F6F6;}
	.cart_num1 {position: absolute;right: 20%;top: 5px;width: auto;min-width: 14px;}
	.tribe_shop_footer ul li {width: 20%;}
</style>
<!-- 聊天消息 -->
<div class="chat_news">
    <!-- 部落消息 -->
	<?php if (!empty($group_chat)) {?>
	  <ul>
	    <li>
	    	<a href="<?php echo site_url("Webim/Control/chats/{$group_chat['id']}");?>">
	    	<div class="chat_news_left"><span><img src="<?php echo IMAGE_URL.$group_chat['logo']?>" alt="" onerror="this.src='images/51_logo.png'"></span>
            <?php if($group_chat['Msg_count']>99){?>
	    		<i>99+</i>
	    	<?php }?>
	    	<?php if($group_chat['Msg_count']<99&&$group_chat['Msg_count']>0){?>
	    		<i><?php  echo $group_chat['Msg_count'];?></i> 
	    	<?php }?>
	    	</div>
	    	<div class="chat_news_right">
	    		<p class="chat_news_right_name"><span><?php echo  $group_chat['name'];?><i class='chat_list_icon'><em class='icon-qunliao'></em>群聊</i></span><em><?php echo empty($group_chat['Msg_info']) ? '':substr($group_chat['Msg_info']['create_at'],0,10);?></em></p>
	    		<p>
	    		<?php if(empty($group_chat['Msg_info'])){
	    		    echo '';
	    		}else if($group_chat['Msg_info']['message_type']==1){
	    		    echo '[图片]';
	    		}else if($group_chat['Msg_info']['message_type'] == 2){
	    		    echo $group_chat['Msg_info']['message_url'];
	    		}else{
	    		    echo $group_chat['Msg_info']['message'];
	    		}?>
	    		</p>
	    	</div>
	    	</a>
	    </li>
	</ul>
	<?php }?>
	<!-- 个人消息 -->
	<?php if (!empty($single_chat)) {?>
	<ul style="margin-top: 6px;">
	<?php foreach ($single_chat as $k => $v){
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
	    	<a href="<?php echo site_url("Webim/Control/chat/{$tribe_id}/{$v['Send_info']['from_customer_id']}");?>">
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
	   <?php   }?>
	</ul>
	<?php }?>
</div>	
<!-- 底部导航 -->
    <div class="container-center tribe_shop_footer">
         <ul>
            <li class="footer-icon01"><a href="<?php echo site_url('Tribe/home/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-shouye_"></span>首页</a></li>
            <li class="footer-icon02"><a href="<?php echo site_url('Tribe/shop/'.$tribe_id.'/'.$label_id)?>" class=" "><span class="icon-shangcheng_"></span>商城</a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Circles/index/'.$label_id.'?tribe_id='.$tribe_id)?>" class=""><span class="icon-quanzi_"></span>圈子</a></li>
            <li class="footer-icon03" style="position: relative;"><a href="<?php echo site_url('Webim/Control/chatList/'.$tribe_id);?>" class="cf tribe_shop_footer_active"><span class="icon-xiaoxi2 cf tribe_shop_footer_active"></span>消息<em class="cart_num1" id ='huanxin_chatNum' hidden>0</em></a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Tribe/Members_List/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-zuyuan_"></span>族员</a></li>
        </ul>
    </div>
    
<?php 
$user_id = $this->session->userdata("user_id");
if($user_id){?>
<script>

$.ajax({
    url:'<?php echo site_url("Webim/Control/getNotReadCount/{$tribe_id}")?>',
    type:'post',
    dataType:'json',
    data:{},
    success:function(data)
    {
   	  console.log("获取未读消息成功");
   	  var MsgCount = data.MsgCount;
   	  if(MsgCount > 0){
   	  	if(MsgCount >= 99){
   	  		MsgCount = '99+';	
   	  	}
   	  	$("#huanxin_chatNum").html(MsgCount);
   	  	$("#huanxin_chatNum").show();
   	  }
	  
    },
    error:function()
    {
        console.log("获取未读消息失败");
    }
})
</script>
<?php }?>
<script>
$(function(){
	setInterval(function(){
		window.location.reload();
		},30000);
});
</script>

