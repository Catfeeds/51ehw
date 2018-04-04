
<!-- 点击投票共用 -->
<script type="text/javascript">

//点击对象，投票ID，原票数,请求地址
function votestaff_sub(obj,id,staff_num,url)
{ 
	$.ajax({ 
		url: url,
		type:'get',
	    dataType:'json',
	    data:{},
	    beforeSend:function (XMLHttpRequest) {
	        
        	XMLHttpRequest.setRequestHeader("request_type","ajax");
        	
        },
	    success:function(data)
	    {
		    if( data.message )
		    { 
		    	$(".black_feds").text(data.message).show();
	    		setTimeout("prompt();", 1000);
		    }
		    
	    	if( data.status  == 1 )
	    	{ 
	    		$(obj).removeAttr('onclick');
		    	$('#staff_option_'+id).text( (staff_num+1)+'票');
		    	$(obj).css('background','#ECECEC');
		    	$(obj).val('已投票');
		    	is_show_staff = true;
		    	$('.vote_item_num').show();
		    	$('.vote_detail_item_num').show();
			}

			if( data.redirect_url )
			{ 
				window.setTimeout("window.location.href='"+data.redirect_url+"'", 1000);   
			}
    	  	
    	  
		},
	    error:function()
	    {
	    	
	    	$(".black_feds").text('服务器繁忙，请稍后再试').show();
    		setTimeout("prompt();", 2000);
		},
	    
	})
}

</script>

