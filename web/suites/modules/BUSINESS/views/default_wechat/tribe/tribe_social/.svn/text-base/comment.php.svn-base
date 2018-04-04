<style type="text/css">
  .container {background:#f6f6f6;}
  .tribe_edit_industry {position: relative;padding-top: 0;}
  .tribe_edit_industry textarea {height: 250px;border: none;padding: 15px 15px 9px 15px;}
  .circle_publish_jia {position: inherit;display: block;margin: 50px 15px 0 15px;width: auto;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <style type="text/css">
     .circle_publish_jia {position: inherit;display: block;margin: 50px 15px 0 15px;width: auto;}
   </style>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>发表评价</span>
</div>
<?php }?>
<!-- 评价 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="clans_personal_description">
   <div class="tribe_edit_industry">
      <textarea placeholder="请输入评价内容" id="msg" maxlength="200"></textarea>
      <span class="clans_description_num" id="wordNumber">200</span>
   </div>


</div>


<a href="javascript:add_comment()" class="circle_publish_jia custom_button">发表评价</a>


<script type="text/javascript">
  //检测输入内容字数的变化
  $("#msg").on("input propertychange",function() {
    var t = 200 - $(this).val().length;
    $("#wordNumber").text(t);

    if (t<0) {
      $("#wordNumber").text(0);
    };
  })
  
  
function add_comment()
{
  	var content = $('textarea').val();

	if( !content )
	{ 
		$(".black_feds").text('评论内容不能为空').show();
		setTimeout("prompt();", 2000); 
       	return false;
	}
    $.ajax({ 
		url:'<?php echo site_url('Tribe_social/Add_Comment')?>',
		type:'post',
		dataType:'json',
		data:{to_customer_id:<?php echo $to_customer_id?>,'content':content},
		beforeSend:function()
		{
			$('.circle_publish_jia').attr('href','javascript:;');
		},
		success:function(data)
		{
			if( data.status == 1 )
			{ 
				window.setTimeout("window.history.go(-1)", 1000);
				
			}else{ 
				
				$('.circle_publish_jia').attr('href','javascript:add_comment()');
			}
			
			$(".black_feds").text(data.message).show();
			setTimeout("prompt();", 2000); 
	       	return false;
		},
		error:function()
		{
			$('.circle_publish_jia').attr('href','javascript:add_comment()');
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
	       	return false;
		}
	})
}
</script>