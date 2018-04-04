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
        <li class="new_order-nav-active" <?php echo $is_sell?'style="width:18%"':'';?> ><a href="javascript:navigation(0);">全部</a></li>
        <li <?php echo $is_sell?'style="width:18%"':'';?> ><a href="javascript:navigation(1);">待付款</a></li>
        <?php if($is_sell):?>
            <li  style="width:18%"><a href="javascript:navigation(2);">待发货</a></li>
            <li  style="width:18%"><a href="javascript:navigation(3);">已发货</a></li>
        <?php else:?>
            <li><a href="javascript:navigation(2);">待收货</a></li>
        <?php endif;?>
        <li <?php echo $is_sell?'style="width:18%"':'';?> ><a href="javascript:navigation(4);">已完成</a></li>
	</ul>
</div>

<div class="tuichu_ball" hidden>
    <div class="tuichu_ball_box">
        <div class="tuichu_ball_main">
            <div class="tuichu_ball_title"><span>提示</span></div>
            <div class="tuichu_ball_text"><span>是否取消订单？</span></div>
            <div class="tuichu_ball_button">
                <a href="javascript:cane(0);">取消</a>
                <a id = 'tuichu_sub' href="javascript:;" >确定</a>
            </div>      
        </div>
    </div>
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
var tribe = "<?php echo $tribe?>";
var is_sell = "<?php echo $is_sell?>";
dropload = $('.tabBox').dropload({
	scrollArea : window,
	loadDownFn : function(me){
		var result = "";
        $.ajax({
            url:"<?php echo site_url("easyshop/order/ajax_order_list");?>",
            type:'post',
            dataType:'json',
            data:{type:type,page:page,tribe:tribe,is_sell:is_sell},
            beforeSend:function (XMLHttpRequest) {
                XMLHttpRequest.setRequestHeader("request_type","ajax");
            },
            success:function(data){
                console.log(data);
                if(data.status==255)
                {
                    $(".black_feds").text(data.message).show();
                    setTimeout("prompt();", 2000);
                    window.setTimeout("window.location.href='"+data.redirect_url+"'", 2000);                  
                }
                if(data.List.length>0){ 
                    for(var i=0;i<data.List.length;i++){
                        var url = '<?php echo site_url('easyshop/order/detail/');?>/'+tribe+'/'+data.List[i]['id']+'/'+is_sell;
                        result += '<div class="order_list_title" >';
                        result += '<span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-shop"></em></span><span class="notice_word_big">'+data.List[i]['name']+' - '+data.List[i]['mobile']+'</span>';
                        result += '<a href=""><span class="ml-20"></span></a>';
                        result += '<span class="notice-word-big right_state" id="order_message_'+data.List[i]['id']+'">';

                        switch(data.List[i]['status']){
                            case '1':
                                    result += '待付款';
                                break;
                            case '2':
                                    result += '待发货';
                                break;
                            case '3':
                                    result += '已发货';
                                break;
                            case '4':
                                    result += '已完成';
                                break;
                            case '5':
                                    result += '已完成';
                                break;
                            case '6':
                                result += '已取消';
                                break;  
                            case '7':
                                result += '已取消';
                                break;                                      
                        }

                        result += '</span>';
                        result += '</div>';
                        result += '<div class="order_list_content clearfix">';
                        result += '<div style="width: 100%;height: auto;overflow: hidden;position: relative;">';
                        result += '<a href="'+url+'" style="width: 600px;display: inline-block;">';

                        var error_img  = "this.src='images/default_img_b.jpg'";
                        var img_url = "<?php echo IMAGE_URL?>"+data.List[i]['product_img'];
                        result += '<img src="'+img_url+'" width="64" height="87" onerror="'+error_img+'">';
                        result += '<span class="fn-14" style=" margin-left: 10px; text-align: left;  color: #333; position: absolute;">';
                        result += data.List[i]['product_name']+'</span>';

                        result += '';
                        result += '</a>';
                        result += '</div>';
                        result += '<div>';
                        result += '<p class="fn-12 c9" style="float: left; font-size: 15px !important; color: #0E0E0E !important;">共';

                        result += data.List[i]['quantity']+'件商品</p>';   

                        result += '<p class="fn-14" style="float: right; font-size: 15px !important;">实付款：<span style="padding-left: 4px;">￥ </span>'+Math.floor(data.List[i]['total_price'])
                        result += '<span style="font-size: 13px;">';
                        var total_price = data.List[i]['total_price'];
                        var str = total_price.split(".");
                        result += '.'+str[str.length - 1]+'</span>';
                        result += '</p>';
                        result += '</div>';
                        result += '</div>';

                        switch(data.List[i]['status']){
                            case '1':
                                result += '<div class="order_list_handle" id="status_submit_'+data.List[i]['id']+'">';
                                result += '<span><a href="javascript:;" onclick="cancel('+data.List[i]['id']+')" class="order_list_comment">取消订单</a></span>';
                                result += '</div>';
                                break;
                            case '2':
                                if(is_sell)
                                {
                                    result += '<div class="order_list_handle" id="status_submit_'+data.List[i]['id']+'">';
                                    result += '<span><a href="javascript:;" onclick="receive('+data.List[i]['id']+')" class="order_list_comment">确定发货</a></span>';
                                    result += '</div>';
                                }
                                break;
                            case '3':
                                if(!is_sell)
                                {  
                                    result += '<div class="order_list_handle" id="status_submit_'+data.List[i]['id']+'">';
                                    result += '<span><a href="javascript:;" onclick="receive('+data.List[i]['id']+')" class="order_list_comment">确定收货</a></span>';
                                    result += '</div>';
                                }
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
            },
            error:function(){
                alert('网络连接超时');
                location.reload();                
            }
        })
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
var tribe_id = "<?php echo $tribe_id?>";
// 确认收货 
function receive( id ){
    var tc = $('#tuichu_sub');
    if(tc.attr('href')=='javascript:;')
    {
        $('.tuichu_ball_text span').text('是否确认收货？');
        tc.attr('href','javascript:receive('+id+');');
        $('.tuichu_ball').show();
    }
    else
    {
        $.ajax({
            url:'<?php echo site_url('easyshop/order/confirm_order')?>',
            data:{id:id,tribe_id:tribe_id},
            dataType:'json',
            type:'post',
            success:function(data){console.log(data.status);
                cane();
                if(data.status){
                    $(".black_feds").text("操作失败").show();
                    setTimeout("prompt();", 1000);
                }else{
                    $('#order_message_'+id).text('订单完成');
                    $('#status_submit_'+id).empty();
                }
            },
            error:function(){ 
                $(".black_feds").text("网络连接超时").show();
                setTimeout("prompt();", 1000);
                setTimeout(location.reload(), 2000);
            }
        })
    }
}

// 取消订单 
function cancel( id ){
    var tc = $('#tuichu_sub');
    if(tc.attr('href')=='javascript:;')
    {
        $('.tuichu_ball_text span').text('是否取消订单？');
        tc.attr('href','javascript:cancel('+id+');');
        $('.tuichu_ball').show();
    }
    else
    {
        url = "<?php echo site_url('easyshop/order/cancel_order')?>";
        var is_sell = "<?php echo $is_sell?>";
        $.ajax({ 
            url:url,
            type:'post',
            data:{id:id,tribe_id:tribe_id,is_sell:is_sell},
            dataType:'json',
            success:function(data){
                cane();
                if(data.status){
                    $(".black_feds").text("操作失败").show();
                    setTimeout("prompt();", 1000);
                }else{
                    $('#order_message_'+id).text('已取消');
                    $('#status_submit_'+id).remove();
                }
            },
            error:function(){
                $(".black_feds").text("网络连接超时").show();
                setTimeout("prompt();", 1000);
                setTimeout(location.reload(), 2000);
            }
        })
    }
}

function cane(){
    $('#tuichu_sub').attr('href','javascript:;');
    $('.tuichu_ball').hide();
}


</script>