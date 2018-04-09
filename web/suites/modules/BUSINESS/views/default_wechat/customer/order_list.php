<style type="text/css">
@media screen and (min-width:414px) {
	.notice_word_big {
		width: 302px;
		display: inline-block;
		overflow: hidden;
		word-break: keep-all;
		white-space: nowrap;
		text-overflow: ellipsis;
		text-align: left;
	}
}

@media screen and (min-width:321px) {
	.notice_word_big {
		width: 203px;
		display: inline-block;
		overflow: hidden;
		word-break: keep-all;
		white-space: nowrap;
		text-overflow: ellipsis;
		text-align: left;
	}
}

@media screen and (max-width:320px) {
	.notice_word_big {
		width: 160px;
		display: inline-block;
		overflow: hidden;
		word-break: keep-all;
		white-space: nowrap;
		text-overflow: ellipsis;
		text-align: left;
	}
	.order_list .order_list_title .right_state {
		width: 93px;
		text-align: right;
	}
}

.order_list_title {
	position: relative;
}

.order_list .order_list_title .right_state {
	position: absolute;
	right: 0px;
}

.order_list .order_list_content img {
	object-fit: contain;
	float: left;
	text-align: center;
	font-size: 12px;
	color: #666;
	margin-left: 2px;
	display: block;
	background-color: #fff;
	width: 80px;
}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<div class="page clearfix">
	<div class="tabBox">
		<div class="bd">
			<ul>
                <!--全部订单 开始-->
                <div class="order_list">
                </div>
			</ul>
			<!--全部订单 结束-->
		</div>
	</div>
</div>

<div class="new_order-nav">
	<ul>
		<li class="new_order-nav-active">
		<a href="javascript:navigation(0);">全部</a></li>
		<li >
		<a href="javascript:navigation(1);">待付款</a></li>
		<li >
		<a href="javascript:navigation(6);">待收货</a></li>
		<li>
		<a href="javascript:navigation(4);">已完成</a></li>
	</ul>
</div>


<!-- 顶部导航事件 -->
<script type="text/javascript">
  $(".new_order-nav ul li").on("touchstart",function(){
     var index = $(this).index();
     $(this).addClass('new_order-nav-active').siblings().removeClass("new_order-nav-active");
  })
</script>
<!--订单加载 -->
<script type="text/javascript">
var page = 1;//默认第一页
var type = 0;
dropload = $('.tabBox').dropload({
	  scrollArea : window,
	  loadDownFn : function(me){
		  var result = "";
		  $.post("<?php echo site_url("Member/order/ajax_order_list");?>",{type:type,page:page},function(data){
			  if(data.List.length>0){ 
				  for(var i=0;i<data.List.length;i++){
					  var url = '<?php echo site_url('member/order/detail/');?>/'+data.List[i]['id'];
    				  result += '<div class="order_list_title" >';
    				  result += '<span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-shop"></em></span><span class="notice_word_big">'+data.List[i]['corporation_name']+'</span>';
    				  result += '<a href=""><span class="ml-20"></span></a>';
    				  result += '<span class="notice-word-big right_state" id="order_message_'+data.List[i]['id']+'">';
    				  switch(data.List[i]['status']){
    				  		case '1':
    				  			result += '等待商家确认';
    					  		break;
    				  		case '2':
    				  			result += '待付款';
    					  		break;
    				  		case '3':
    				  			result += '';
    					  		break;
    				  		case '4':
    				  			result += '待发货';
    					  		break;
    				  		case '5':
    				  			result += '待发货';
    					  		break;
    				  		case '6':
    				  			result += '已发货';
    					  		break;
    				  		case '7':
    				  			result += '已完成';
    					  		break;
    				  		case '8':
    				  			result += '';
    					  		break;
    				  		case '9':
    				  			result += '已完成';
    					  		break;
    				  		case '10':
    				  			result += '已取消';
    					  		break;
    				  		case '11':
    				  			result += '已退款';
    					  		break;
    				  		case '12':
    				  			result += '已取消';
    					  		break;
    				  		case '13':
    				  			result += '已存货';
    					  		break;
    				  		case '14':
    				  			result += '已完成';
    					  		break;													
    				  }
    				  result += '</span>';
    				  result += '</div>';
    				  result += '<div class="order_list_content clearfix">';
    				  result += '<div style="width: 100%;height: auto;overflow: hidden;position: relative;">';
    				  result += '<a href="'+url+'" style="width: 600px;display: inline-block;">';
					  if(data.List[i]['items'].length > 0){
						  var error_img  = "this.src='images/default_img_b.jpg'";
						  for(var k=0;k<data.List[i]['items'].length;k++){
								 var img_url = "<?php echo IMAGE_URL?>"+data.List[i]['items'][k]['goods_thumb'];
								 result += '<img src="'+img_url+'" width="64" height="87" onerror="'+error_img+'">';
								 if(data.List[i]['items'].length == 1){
									 result += '<span class="fn-14" style=" margin-left: 10px; text-align: left;  color: #333; position: absolute;">';
									 result += data.List[i]['items'][k]['product_name']+'</span>';
								  }
        				  	 }
							  
						  }
    				  result += '';
    				  result += '</a>';
    				  result += '</div>';
    				  result += '<div>';
    				  result += '<p class="fn-12 c9" style="float: left; font-size: 15px !important; color: #0E0E0E !important;">共';
					  var quantity = 0;
    				  for(var j=0;j<data.List[i]['items'].length;j++){
    					  quantity += Number(data.List[i]['items'][j]['quantity']);
        				  }
					  result += quantity+'件商品</p>';	
    				  result += '<p class="fn-14" style="float: right; font-size: 15px !important;">使用提货权：'+Math.floor(data.List[i]['total_price'])
    				  result += '<span style="font-size: 13px;">';
        			  var  total_price = data.List[i]['total_price'];
    				  var str = total_price.split(".");
            		  result += '.'+str[str.length - 1]+'</span>';
    				  result += '<span style="padding-left: 4px;"></span>';
    				  result += '</p>';
    				  result += '</div>';
    				  result += '</div>';
				  switch(data.List[i]['status']){
				  	case '7':case '9':case '14':
				  		url = '<?php echo site_url('member/my_comment/product_comment/');?>/'+data.List[i]['id'];
				  		result += '<div class="order_list_handle">';
				  		result += ' <span><a href="'+url+'" class="order_list_comment">评价</a></span>';
				  		result += '</div>';
					  	break;
				  	case '2': 	
				  		url = '<?php echo site_url('member/order/order_pay/');?>/'+data.List[i]['id'];
				  		result += '<div class="order_list_handle" id="status_submit_'+data.List[i]['id']+'">';
				  		result += '<span><a href="'+url+'" class="order_list_comment">去支付</a></span>';
				  		result += '<span><a href="javascript:;" onclick="cancel('+data.List[i]['id']+')" class="order_list_comment">取消订单</a></span>';
				  		result += '</div>';
				  		break;
				  	case '6': 	
				  		result += '<div class="order_list_handle" id="status_submit_'+data.List[i]['id']+'">';
				  		result += '<span><a href="javascript:;" onclick="receive('+data.List[i]['id']+')" class="order_list_comment">确定收货</a></span>';
				  		result += '</div>';
				  		break;
				  	case '1': 
				  		result += '<div class="order_list_handle" id="status_submit_'+data.List[i]['id']+'">';
				  		result += '<span><a href="javascript:;" onclick="cancel('+data.List[i]['id']+')" class="order_list_comment">取消订单</a></span>';
				  		result += '</div>';	
				  		break;		
				  }
				  result += '</div>';
				   }
				  $(".order_list").append(result);
				  page++;
	              me.resetload();
			    }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
					$(".dropload-noData").html("没有更多的订单了");
	                
	            }
			  },"json");
		  
		  }
	
});
	//导航切换
	function navigation(types){
		type = types;
		page = 1;//默认第一页

		$(".order_list").empty();
		
		dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();
  	}
</script>
<!-- 订单操作事件 -->
<script type="text/javascript">

var show_bullet_id = "<?php echo $bullet_set == 1? "skip_bullet":"pay_bullet";?>";

// 确认收货 - show
function receive( id ){
    $.ajax({ 
        url:'<?php echo site_url('order/order_message')?>',
        data:{ o_id:id },
        dataType:'json',
        type:'post',
        success:function(data){
            $("#pay_").text("确认收货");
            $('#pay_').attr('onclick','ok_receive("'+data.id+'")');
            $('#order_sn').text(data.order_sn);
            $('#price').text(data.total_price+' ');
            $(".color-bg").show();
            $("#"+show_bullet_id).show();
        }
    })
}

// 确认收货 - sure
function ok_receive( id ){
    var pass = $('input[name=pay_passwd]').val();
    var comurl = "<?php echo site_url('member/my_comment/product_comment').'/'?>";
    $.ajax({
        url:'<?php echo site_url('order/receive')?>',
        data:{pass:pass,id:id},
        dataType:'json',
        type:'post',
        success:function(data){
            if(data == 1){
                $(".color-bg").hide();
                $("#pay_bullet").hide();
                
                $('#order_message_'+id).text('订单完成');
                $('#status_submit_'+id).empty();
                
                html = '<span><a href="'+comurl+id+'/details" class="order_list_comment">评价</a></span>';
                $('#status_submit_'+id).append(html);
            }else if(data == 3){ 
                $(".black_feds").text("密码错误，请重新输入").show();
                setTimeout("prompt();", 1000);
            }else if(data == 2){
                $(".black_feds").text("订单错误").show();
                setTimeout("prompt();", 1000);
            }else{ 
            	$(".black_feds").text("服务器无响应").show();
                setTimeout("prompt();", 1000);
            }
        },
        error:function(){ 
        	$(".black_feds").text("操作失败").show();
            setTimeout("prompt();", 1000);
        }
    })
}

// 取消订单 - cancel
function cancel( id ){
	url = "<?php echo site_url('order/cancel_order')?>"
	 $.ajax({ 
        url:url,
        type:'post',
        data:{id:id},
        dataType:'json',
        success:function(data){ 
            if(data.is_ok){
            	$('#order_message_'+id).text('已取消');
            	$('#status_submit_'+id).remove();
            }else{
                $(".black_feds").text("操作失败").show();
                setTimeout("prompt();", 1000);
            }
        },
    })
}

</script>
