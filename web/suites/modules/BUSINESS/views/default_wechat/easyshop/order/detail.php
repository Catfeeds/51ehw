<style type="text/css">
.page {padding-top: 0px;}
.footer {bottom: 0px;}
.pintuan-wanfang ul li {float: left;}
.pintuan-xuanze {margin: 5px 5px 5px 0px;float: left;text-align: center;;width: 25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-yaoqing {margin-top: 5px;margin-right: 5px;float: left;text-align: center;;width: 25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-renshu {margin-top: 5px;margin-right: 5px;float: left;text-align: center;;width: 25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-shijian {padding-left: 10px;color: #FA6C32;}
.pintuan-xianxia {font-size: 17px;color: #22AA1E;padding-right: 10px;}
@media screen and (max-width:320px) {
	.pintuan-shijian {
		padding-left: 3px;
	}
	.pintuan-xianxia {
		padding-right: 0px;
	}
}
.good_list_img {border: 1px solid #ccc;}
.mm01_font1 {margin-left: 10px;}  
.mm01_font1 {padding-bottom: 0px;}
@media screen and (min-width:414px) {
	.goods_list_text {
		width: 300px!important;
	}
}
@media screen and (min-width:320px) and (max-width:375px){
}
@media screen and (max-width:320px) {
	.goods_list_text {
		width: 180px!important;
	}
}

/*查看收货二维码*/
.look-code {padding: 10px;border-bottom: 5px solid #E6E6E6;font-size: 14px;}
.look-code span {float: right;font-size: 20px;}
.code-ball {position: fixed;top: 0;background:rgba(0,0,0,0.5);width: 100%;height: 100%;display: none;}
.code-ball-main {text-align: center;margin-top: 28%;color: #fff;font-size: 15px;}
.code-ball-main img {width: 75%;padding: 10px 0;}

/*核销员／时间*/
.verification {padding: 10px;border-bottom: 5px solid #E6E6E6;font-size: 14px;}


</style>
<div class="page clearfix">

	<div class="order_detail">

		<p class="c9"
			style="float: left; margin-left: 10px; margin-top: 15px; font-size: 15px; color: #444444 !important">订单号：<?php echo $order['order_sn'];?></p>
		<!--状态 start-->
		<section>
			<div class="notice_box" style="margin-top: 6px;">
				<p class="fn-14" id="status_name"
					style="float: right; color: #DC4A5F;">
        <?php
        switch ($order['status']) {
            case 1:
                echo '等待付款';
                break;
            case 2:
                echo '等待发货';
                break;
            case 3:
                echo '已发货';
                break;
            case 4:
            case 5:
                echo '已完成';
                break;
            case 9:
            	echo '订单异常';
            	break;
            default:
                echo '已取消';
                break;
        }
        ?></p>
			</div>
		</section>
		<!--状态 end-->
		

		 <!--收货地址 开始-->
		<div class="order_confirm order_address">
			<a href="javascript:void(0);" class="order_list" style="margin-left: 20px;">
				<h3>
					<span class="c9"><?php echo isset($order_delivery['consignee']) ? $order_delivery['consignee'] :''?></span>
					<span style="padding-left: 60px;" class="c9"><?php echo isset($order_delivery['contact_mobile']) ? $order_delivery['contact_mobile'] :''?></span>
				</h3>
				<em class="icon-dingwei1 c9" style="float: left; margin-left: -20px; margin-top: 2px;"></em>
				<p class="c9" style=""> <?php echo $order_delivery["province"];?><?php echo $order_delivery["city"];?><?php echo $order_delivery["district"];?><?php echo isset($order_delivery['address']) ? $order_delivery['address'] :''?></p>
				<!-- <em class="icon-right  firm_order_font"></em> -->
			</a>
		</div>
		<div style="margin-bottom: 10px;">
			<img src="images/goods_list_bottom.png" alt="">
		</div>
		<!--收货地址 结束-->

		<!--商品列表 start-->
		
		<div class="order_list_title">
			<span class="fn-left " style="padding-right: 10px; font-size: 15px; padding-left: 10px;">
				<em class="icon-shop"></em></span><span style="font-size: 14px;">
					<?php echo $order['name'],' -- ',$order['mobile'];?>
				</span>
				<a href=""></a>
		</div>
                
		<section style="padding-bottom: 0px;border-bottom: 1px solid #ccc;">
			<div class="good_list clearfix" >
				<div style="margin-bottom: 10px;">
				
					<!-- 标题 -->
					<a href="<?php echo site_url('Easyshop/product/good_detail/'.$order['product_id']).'?tribe_id='.$tribe_id?>" style="">
    					<img src="<?php echo IMAGE_URL.$order['product_img']; ?>" width="62" height="83" onerror="this.src='images/default_img_b.jpg'" class="good_list_img">
    					<div style="float:left;margin-top: -85px;margin-left: 75px;">
    						<p class="fn-14 goods_list_text"><?php echo $order['product_name'];?></p>
    					</div>
					</a>
        			
        			<!-- 小计 -->
					<p class="fn-14" style="float:left;margin-top: -17px;margin-left: 85px;">
						<span style="font-size: 13px;"></span><span style="font-size: 12px !important; padding-left: 4px;">￥</span>
						<?php echo $order['total_price']?>
					</p>
                    <p class="" style="float:right;margin-top: -17px;">x<?php echo $order['quantity']?></p>
				</div>
			</div>
		</section>
		
	   <!--商品列表 end-->

	   <!-- 结算 start -->
	   
		<section style="padding-top: 0px; border-top: 5px solid #E6E6E6; border-bottom: 5px solid #E6E6E6; padding-bottom: 10px;">
			<div class="notice_box">
				<p style="padding-top: 8px;">商品总额
					<span style="float: right;" class="c9">
    					<span style="padding-left: 5px;">￥</span>
						<span><?php echo $order['total_price'];?></span>
    					<span style="font-size: 12px !important;"></span>
					</span>
				</p>

				<p style="padding-top: 8px;">实付款
					<span style="float: right;">
						<span style="padding-left: 5px;">￥</span>
						<span><?php echo $order['total_price'];?></span>
						<span style="font-size: 12px !important;"></span>
					</span>
				</p>
							
				<?php foreach($order_log as $v):if(in_array($v['status'],[1,3,6,7])):?>
					<p style="padding-top: 10px;"><?php echo $order_log_status[$v['status']];?>
						<span style="float: right;" class="c9">
							<?php if( $v['status'] == 6 || $v['status'] == 7 ):?>
								<?php echo $v['remark']?>
							<?php else:?>
								<?php echo $v['created_at'];?>
							<?php endif;?>
						</span>
					</p>
				<?php endif;endforeach;?>
				
			</div>
		</section>

    		<!-- 备注 start -->
    	<!-- <?php if( isset( $order_delivery['shipping_remark'] ) ):?>
        	<p style="padding-top: 10px; padding-left: 10px; font-size: 14px; border-bottom: 5px solid #E6E6E6; padding-bottom: 10px;">备注：
        		<?php echo $order_delivery['shipping_remark'];?>
        	</p>
        <?php endif;?> -->
    		<!-- 备注 end -->

		<!-- 结算 end -->

		<section class="noborder" id="show_order_message">

		<?php if($is_sell):?>

	        <?php if(in_array($order['status'],array(1))):?>
	        	<a href="javascript:;" onclick="cancel(<?php echo $order['id']?>)" class="order_list_comment" id="cancel_submit">取消订单</a>
	        <?php elseif($order['status'] == 2) :?>
	        	<!-- <a href="javascript:;" onclick="receive(<?php echo $order['id']?>)" class="order_list_comment" id="receive_submit"><i class="c9"></i>确认发货</a> -->
	        	<a href="javascript:;" onclick="cancel(<?php echo $order['id']?>)" class="order_list_comment" id="cancel_submit"><i class="c9"></i>取消订单</a>
	        <?php endif;?>

		<?php else:?>

	        <?php if(in_array($order['status'],array(1))):?>
	        	<a href="javascript:;" class="order_list_comment" id="pay_submit"
	        	style="background: #FED609 !important; border: none; margin-left: 10px; margin-right: 0;">去支付</a>
	        	<a href="javascript:;" onclick="cancel(<?php echo $order['id']?>)" class="order_list_comment" id="cancel_submit">取消订单</a>
	        <?php elseif($order['status'] == 3) : ?>
				<a href="javascript:;" onclick="receive(<?php echo $order['id']?>)" class="order_list_comment" id="receive_submit"><i class="c9"></i>确认收货</a>
	        <?php endif;?>

	        <?php if( $order['status'] > 2 && $is_pay):?>
	        	<a href="<?php echo site_url("easyshop/order/complain/".$tribe_id.'/'.$order['id'])?>" class="order_list_comment" id="cancel_submit"><i class="c9"></i>去投诉</a>
	        <?php endif;?>

		<?php endif;?>
		
		</section>
	</div>
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

<script>

function cane(){
    $('#tuichu_sub').attr('href','javascript:;');
    $('.tuichu_ball').hide();
}

var tribe_id = "<?php echo $tribe_id?>";
var show_bullet_id = "<?php echo $bullet_set == 1? "skip_bullet":"pay_bullet";?>";

// 确认收货 - show
function receive( id ){
    $.ajax({ 
        url:'<?php echo site_url('Easyshop/order/detail')?>',
        data:{ order_id:id,tribe_id:tribe_id },
        dataType:'json',
        type:'post',
        success:function(data){
            $("#pay_").text("确认收货");
            $('#pay_').attr('onclick','ok_receive("'+data.id+'")');
            $('#order_sn').text(data.order_sn);
            $('#price').text('￥ '+data.total_price);
            $(".color-bg").show();
            $("#"+show_bullet_id).show();
        }
    })
}

// 确认收货 - sure
function ok_receive( id ){
    var pass = $('input[name=pay_passwd]').val();
    $.ajax({
        url:'<?php echo site_url('Easyshop/order/confirm_order')?>',
        data:{pass:pass,id:id,tribe_id:tribe_id},
        dataType:'json',
        type:'post',
        success:function(data){
            if(data.status == 0){
                $(".color-bg").hide();
                $("#pay_bullet").hide();
                
                $('#order_message_'+id).text('订单完成');
                $('#status_submit_'+id).empty();
            }else if(data.status == 3){ 
                $(".black_feds").text("密码错误，请重新输入").show();
                setTimeout("prompt();", 1000);
            }else if(data.status == 1){
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
		url = "<?php echo site_url('Easyshop/order/cancel_order')?>";
		var is_sell = "<?php echo $is_sell?>";
		$.ajax({ 
	        url:url,
	        type:'post',
	        data:{id:id,tribe_id:tribe_id},
	        dataType:'json',
	        success:function(data){
	        	cane();
	            if(data.status){
	                $(".black_feds").text("操作失败").show();
	                setTimeout("prompt();", 1000);
	            }else{
			       	$('#status_name').text('已取消');
			       	$('#cancel_submit').remove();
			       	$('#pay_submit').remove();
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

// 去支付
$('#pay_submit').click(function(){
	var url = "<?php echo site_url('Easyshop/order/order_pay')?>";
	var id = "<?php echo $order['id'];?>";
	$.ajax({
        url:url,
        type:'post',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data.status){
				$(".black_feds").text(data.errorMessage).show();
			    setTimeout("prompt();", 3000);
			    return;
            }else{
            	location.href = "<?php echo site_url('Easyshop/Payment/pay/index')?>"+'/'+id;
            	return;
            }
        },
    })
})

</script>
<!--page end-->