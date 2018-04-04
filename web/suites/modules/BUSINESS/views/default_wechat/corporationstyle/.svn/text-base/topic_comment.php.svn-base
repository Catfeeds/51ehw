<div id="topic_comment"  >
    <div class="header new_index_nav" name="top" >
        <a href="javascript:history.back()" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
        <a href="javascript:void(0);" onclick="Add_Comment();" class="send_but_text">发送</a> 
        <input type="hidden" id="back" value="0">  
        <p class="title">评论</p>
    </div><!--header end-->
    
	<div class="container" ><!--header end-->

    <div class="create_circle" >
        <div class="ning_input">
        	<textarea class="example" id="taContent" rows="10"  placeholder="<?php echo $to_name ? '回复'.$to_name.'：': '请输入评论内容（50字以内）'?>" maxlength="50" ></textarea>
         </div>
    </div>  
	</div>
	
</div>

<script type="text/javascript">

//添加评论
function Add_Comment()
{ 
	var id = '<?php echo $id;?>';//回复id
	var obj_id = '<?php echo $obj_id?>';//对象id
	var content = $('#taContent').val();//内容
	if( !content || content.trim().length == 0 )
	{ 
		$(".black_feds").text('请输入评论内容').show();
		setTimeout("prompt();", 2000);
		return false;
	}
	$('.send_but_text').removeAttr('onclick');
	
	$.ajax({ 
		url:'<?php echo site_url('Corporation_style/Add_Comment')?>',
		type:'post',
		dataType:'json',
		data:{'obj_id':obj_id,'content':content,'id':id},
		success:function (data)
		{
			$(".black_feds").text( data.message ).show();
			setTimeout("prompt();", 2000);
			if( data.status )	
			{
			    
				$('#back').val(1);
				window.setTimeout("history.back();", 1000);
        		return;
			}

			$('.send_but_text').attr("onclick",'Add_Comment()');
		},
		error:function()
		{
			$(".black_feds").text( '服务器异常，请稍后再试' ).show();
			setTimeout("prompt();", 2000);
			$('.send_but_text').attr("onclick",'Add_Comment()');
		}
		
	})
}

</script>
