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
			<!--  <em class="i icon-edit"></em> -->
			<div class="notice_box" style="margin-top: 6px;">
				<p class="fn-14" id="status_name"
					style="float: right; color: #DC4A5F;">
        <?php
        switch ($order['status']) {
            case 1:
                echo '等待商家确认';
                break;
            case 2:
                echo '等待付款';
                break;
            case 3:
                echo '支付成功'; // 团购状态
                break;
            case 4:
                echo '等待发货';
                break;
            case 5:
                echo '等待发货';
                break;
            case 6:
                echo '已发货';
                break;
            case 7:
                echo '订单完成';
                break;
            case 8:
                ;
                break;
            case 9:
                echo '订单完成';
                break;
            case 10:
                echo '已取消';
                break;
            case 11:
                echo '已退款';
                break;
            case 12:
                echo '已取消';
                break;
            case 13:
                echo '已存货';
                break;
            case 14:
                echo '订单完成';
                break;
            case 15:
                echo '未成团'; // 团购状态
                break;
            case 16:
                echo '拼团订单失效'; // 团购状态
                break;
            default:
                echo '';
                break;
        }
        ?></p>
			</div>
		</section>
		<!--状态 end-->
		
		<?php if ($order['payment_id'] != 5):?>
		<!--地址 start-->
		<?php if(!isset($order_delivery) || count($order_delivery) == 0):?>
        <ul class="address_manage_new">
			<a href="<?php echo site_url("member/address/get_address/".$order['id']);?>" class="add">
				<li class="add_address_btn_new  c"><i class="icon-add"></i> 选择地址</li>
			</a>
		</ul>
		<?php else:?>
		 <!--收货地址 开始-->
		<div class="order_confirm order_address">
			<a href="javascript:void(0);" class="order_list" style="margin-left: 20px;">
				<h3>
					<span class="c9"><?php echo isset($order_delivery['consignee']) ? $order_delivery['consignee'] :''?></span>
					<span style="padding-left: 60px;" class="c9"><?php echo isset($order_delivery['contact_mobile']) ? $order_delivery['contact_mobile'] :''?></span>
				</h3>
				<em class="icon-dingwei1 c9" style="float: left; margin-left: -20px; margin-top: 2px;"></em>
				<p class="c9" style=""> <?php echo isset($order_delivery['address']) ? $order_delivery['address'] :''?><?php echo $order_delivery["province"];?><?php echo $order_delivery["city"];?><?php echo $order_delivery["district"];?></p>
				<!-- <em class="icon-right  firm_order_font"></em> -->
			</a>
		</div>
		<div style="margin-bottom: 10px;">
			<img src="images/goods_list_bottom.png" alt="">
		</div>
		<!--order_address end-->
		<!--收货地址 结束-->
        <?php endif;?>
            
		<!--地址 end-->	
		<?php endif;?>

		<!-- 物流信息 start -->
		<!-- 物流信息 end -->

		<!--商品列表 start-->
		
		<div class="order_list_title">
			<span class="fn-left " style="padding-right: 10px; font-size: 15px; padding-left: 10px;">
				<em class="icon-shop"></em></span><span style="font-size: 14px;">
					<?php echo isset($corporation['corporation_name'])?$corporation['corporation_name']:"&nbsp;&nbsp;&nbsp;";?>
				</span>
				<a href=""></a>
		</div>
                
		<?php  $pingjia = 0; foreach ($order_items as $k=>$v): if( $v['oc_id'] ) { $pingjia++;} ?>
		<section style="padding-bottom: 0px;border-bottom: 1px solid #ccc;">
			<div class="good_list clearfix" >
				<div style="margin-bottom: 10px;">
				
					<!-- 标题 -->
					<a href="<?php echo site_url('goods/detail/'.$v['product_id'])?>" style="">
    					<img src="<?php echo IMAGE_URL.$v['goods_thumb']; ?>" width="62" height="83" onerror="this.src='images/default_img_b.jpg'" class="good_list_img">
    					<div style="float:left;margin-top: -85px;margin-left: 75px;">
    						<p class="fn-14 goods_list_text"><?php echo $v['product_name'];?></p>

    			        <?php if(!isset($order['activity_id']) || $order['activity_id'] ==''):?>
               		    <!-- sku info -->
					    <p class="mm01_font1">
                        <?php if(isset($v['sku_name'])&&$v['sku_name']!=null): ?>
                        <?php foreach($v['sku_name'] as $sku_name):?>
                          <span><?php echo $sku_name ?></span>&nbsp;&nbsp;
                        <?php endforeach;?>
                        <?php endif;?>
                        </p>
    				    <?php endif;?>
    					</div>
					</a>
        			
        			<!-- 小计 -->
					<p class="fn-14" style="float:left;margin-top: -17px;margin-left: 85px;">
						<?php echo (isset($order['activity_id']) && $order['activity_id'] !='')?$v['groupbuy_price']:$v['price']?>
						<span style="font-size: 13px;"></span><span style="font-size: 12px !important; padding-left: 4px;">货豆</span>
					</p>
                    <p class="" style="float:right;margin-top: -17px;">x<?php echo $v['quantity']?></p>
                    <?php if(isset($order['activity_id']) && $order['activity_id'] !=''):?>
                    <p class="fn-12" style="font-size: 13px !important; color: #0E0E0E !important; margin-top: -20px; margin-right: 5px; border: 1px solid #A2A2A2;width:55px;float:right;text-align: center;"><?php echo $v['menber_num'];?>人团</p>
                    <?php endif;?>
					
               		
    				
				</div>
			</div>
		</section>
		<?php endforeach;?>
		
	   <!--商品列表 end-->

	   <!-- 结算 start -->
	   
		<section style="padding-top: 0px; border-top: 5px solid #E6E6E6; border-bottom: 5px solid #E6E6E6; padding-bottom: 10px;">
			<div class="notice_box">
				<p style="padding-top: 8px;">商品总额
					<span style="float: right;" class="c9">
						<span><?php echo $order['total_product_price'];?></span>
    					<span style="font-size: 12px !important;"></span>
    					<span style="padding-left: 5px;">货豆</span>
					</span>
				</p>
				<p style="padding-top: 8px;">运费
					<span style="float: right;" class="c9"><span></span>
					<span style="font-size: 12px !important;">＋<?php echo $order['auto_freight_fee']?></span>
					<span style="padding-left: 5px;">货豆</span></span>
				</p>
				
				<p style="padding-top: 8px;">优惠
					<span style="float: right;" class="c9"><span></span>
					<span style="font-size: 12px !important;">－<?php echo ($order['auto_freight_fee']+$order['total_product_price'])-$order['total_price'];?></span>
					<span style="padding-left: 5px;">货豆</span></span>
				</p>
       
				<p style="padding-top: 8px;">实付款
					<span style="float: right;">
						<span><?php echo $order['total_price'];?></span>
						<span style="font-size: 12px !important;"></span>
						<span class="c9" style="padding-left: 5px;">货豆</span>
					</span>
				</p>
				
				  <p style="padding-top: 8px;">手续费(现金)
					<span style="float: right;">
						<span><?php echo !empty($order['commission']) ? $order['commission'] : '0.00'?></span>
						<span style="font-size: 12px !important;"></span>
						<span class="c9" style="padding-left: 17px;">元</span>
					</span>
				</p>
				
				<p style="padding-top: 10px;">下单时间
					<span style="float: right;" class="c9"><?php echo $order['place_at'];?></span>
				</p>

			</div>
		</section>

		<!-- 查看收货二维码 -->
		<!-- 
		<p class="look-code">查看收货二维码
			<span class="icon-erweima"></span>
		</p>
		 -->
		<!-- 二维码弹窗 -->
		<!-- 
		<div class="code-ball">
			<div class="code-ball-main">
			   	<span>此二维码仅供商家核销订单使用</span>
			    <img src="images/tmp_code.jpg" alt="">
			    <span>二维编码号：ERKHKLJKK</span>
			</div>
		</div>
         -->
		<?php if(isset($order['activity_id']) && $order['activity_id'] !=''):?>	
		<!-- 拼团玩法 start -->	
		<div class="order_list_title" style="position: relative; padding: 10px 0; border-bottom: 1px solid #E8E8E8; margin-left: 10px;">
			<span style="font-size: 14px;">拼团玩法</span>
		</div>
		<!-- 拼团玩法 end -->

		 <div style="position: relative;padding:10px 20px;" class="pintuan-wanfang">
            <ul style="overflow: hidden;">
               <li style="groupbuy_home.php"><div class="pintuan-xuanze" >1</div><div style="float:left;"><p>选择商品</p><p>付款开团/参团</p></div></li>
               <li style="width:120px;margin-left: 10px;margin-right: 10px;"><div class="pintuan-yaoqing">2</div><div style="float:left;"><p>邀请并等待好友</p><p>支付参团</p></div></li>
               <li style=""><div class="pintuan-renshu" style="background:#FECF0A;">3</div><div style="float:left;"><p>达到人数</p><p>顺利成团</p></div></li>
            </ul>
        </div>






		<?php else:
    		if($order['customer_remark']!=''):?>
    		<!-- 备注 start -->
        	<p style="padding-top: 10px; padding-left: 10px; font-size: 14px; border-bottom: 5px solid #E6E6E6; padding-bottom: 10px;">备注：<?php echo $order['customer_remark'];?></p>
    		<!-- 备注 end -->
    		<?php 
    		endif;
		endif;?>

		<!-- 核销员／时间 -->
		<!-- 
		<p class="verification">核销员：xxx
			<span style="float: right;">核销时间：2016-07-25 12:12:12</span>
		</p>
		-->
		<!-- 结算 end -->

		<section class="noborder" id="show_order_message">
        <?php if(in_array($order['status'],array(2))):?>
        <a href="<?php echo site_url('member/order/order_pay/'.$order['id'])?>" class="order_list_comment" id="pay_submit"
        	style="background: #FED609 !important; border: none; margin-left: 10px; margin-right: 0;">去支付</a>
        <a href="javascript:;" onclick="cancel(<?php echo $order['id']?>)" class="order_list_comment" id="cancel_submit">取消订单</a>
        <?php endif;
       
        if ($order['status'] == 1) :?>
        <a href="javascript:;" onclick="cancel(<?php echo $order['id']?>)" class="order_list_comment" id="cancel_submit"><i class="c9"></i>取消订单</a>
        <?php endif;
        
        if ($order['status'] == 5) : ?>
		<a href="<?php echo site_url("home");?>" class="pay-style gray-but c10"><i class=""></i>继续购物</a>
		<?php endif;
        
        if ($order['status'] == 6) : ?>
		<a href="javascript:;" onclick="receive(<?php echo $order['id']?>)" class="order_list_comment" id="receive_submit"><i class="c9"></i>确认收货</a>
		<!-- class="pay-style pay-weixin" -->
		<?php endif;

        if ( $order['status'] == 9 && $pingjia < count($order_items) ) :?>
        <a href="<?php echo site_url("member/my_comment/product_comment/".$order['id']."/details")?>" class="order_list_comment" id="cancel_submit"><i class="c9"></i>去评价</a>
        <?php endif;?>
		
		</section>
	</div>
</div>



<script>

var show_bullet_id = "<?php echo $bullet_set == 1?"skip_bullet":"pay_bullet";?>";

//确认收货 - show
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
           $('#price').text(data.total_price+' 货豆');
           $(".color-bg").show();
           $("#"+show_bullet_id).show();
       }
    })
}

//确认收货 - sure
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

               $('#status_name').text('订单完成');
               $('#status_submit_'+id).empty();
               
               html = '<span><a href="'+comurl+id+'/details" class="order_list_comment">评价</a></span>';
               $("#receive_submit").remove();
               $("#show_order_message").append(html);
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

//取消订单
function cancel( id ){
	url = "<?php echo site_url('order/cancel_order')?>"
	 $.ajax({ 
   url:url,
   type:'post',
   data:{id:id},
   dataType:'json',
   success:function(data){ 
       if(data.is_ok){
       	$('#status_name').text('已取消');
       	$('#cancel_submit').remove();
       	$('#pay_submit').remove();
       }else{
   		$(".black_feds").text("操作失败").show();
   		setTimeout("prompt();", 2000);
       }
   },
})
}

// 点击查看收货二维码
$(".look-code").on("click",function(){
	$(".code-ball").css("display","block");
})
$(".code-ball").on("click",function(){
	$(".code-ball").css("display","none");
})
</script>
<!--page end-->