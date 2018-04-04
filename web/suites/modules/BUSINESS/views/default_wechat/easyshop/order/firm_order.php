
<style type="text/css">
.footer{bottom:0px;}
.pintuan-wanfang ul li {float: left;}
.pintuan-xuanze {margin: 5px 5px 5px 0px;float:left;text-align: center;;width:25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-yaoqing {margin-top: 5px;margin-right: 5px;float:left;text-align: center;;width:25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-renshu {margin-top: 5px;margin-right: 5px;float:left;text-align: center;;width:25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-shijian {padding-left: 10px;color:#FA6C32;}
.pintuan-xianxia {font-size: 17px;color:#22AA1E;padding-right: 10px;}
.order_tijiao_button {bottom: 50px;}
@media screen and (max-width:320px) {
.pintuan-shijian {padding-left: 3px;}
.pintuan-xianxia {padding-right: 0px;}
}
.choose-icon {left: 0px;}
input[type=checkbox]{
  border: 0!important;background:rgba(0,0,0,0);
}
.h5-forget2_ball {position: fixed;top: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);z-index: 999; }
</style>
<div class="order-detail">
<form id="order_save" method="post" name="order_save">
	<div class="page clearfix">
		<?php if (count($address) === 0){?>
		<!-- 新订单页收货地址为空时 -->
		<div>
			<a href="<?php echo site_url("easyshop/address/index/2")?>">
    			<div class="" style="position: relative; margin-left: 40px; margin-top: 10px; font-size: 14px; color: #363636;">
    				<em class="icon-locationfill c9 custom_color" style="position: absolute; top: 5px; left: -29px; font-size: 20px;"></em>
    				<span style="display: block; padding-top: 5px;">您还没有创建收货地址</span>
    			</div>
			</a>
		</div>
		<!-- 新订单页收货地址为空时 end -->
		<?php }else{ ?>
		<!-- 收货地址new 开始 -->
		<div class="" style="position: relative; margin-left: 40px; margin-top: 10px; font-size: 14px; color: #363636;">
			<a href="<?php echo site_url("easyshop/address/index/2")?>">
    			<em class="icon-locationfill custom_color" style="position: absolute; top: 18px; left: -29px; color: #FED609; font-size: 20px;"></em>
    			<span>
        			<span style="opacity: 0">字</span>收货人：
        			<span><?php echo $address['consignee'];?></span>
    			</span><br>
    			<span class="c9" style="float:right;">
    				<em class="icon-right  firm_order_font"></em>
    			</span>
    			<span style="display: block; padding-top: 5px;">联系电话：
    				<span><?php echo $address['mobile'];?></span>
    			</span>
    			<span style="padding-top: 5px;">收货地址：
    				<span><?php echo $address['address_for_name'].$address['address'];?></span>
    			</span>
			</a>
		</div>
		<!--收货地址 结束-->
		<?php };?>
		<div style="display:none;"><input type="text" id="address_id" value="<?php echo isset($address['id'])?$address['id']:""; ?>"></div>
		<div style="margin-top: 10px;">
			<img src="images/goods_list_bottom.png" alt="">
		</div>
		<!--商品列表 开始-->
		<div class="order_confirm firm_order_list">

			<!--只能提交一家店铺的订单-->
			<!--新增店铺信息 开始-->

			<!--新增店铺信息 结束-->
			<!--商品信息 开始-->

            <ul style="border-bottom: 1px solid #e6e6e6; font-size: 14px;">
                <li><em class="icon-shop"></em>
                    <span style="margin-left: 10px; line-height: 30px;"><?php echo isset($corporation_name)?$corporation_name:"111"; ?></span>
                </li>
			</ul>
            
            
			<ul class="order_list" style="margin-top: 5px;">
				<li>
				<input type="checkbox" checked class="selected_info selected_info_<?php echo 1 ?>" id="<?php echo 1 ?>" name="item[]" value="<?php echo 1 ?>" style="display: none">
				<input type="hidden" class="product_id" value="<?php echo $items['product_id'];?>">
				<!--选中添加上面<em class="icon-squarecheckfill">，未选中取消class里面的icon-squarecheckfill-->
					<img src="<?php echo IMAGE_URL;?>" alt="" class="fn-left good_list_img"
					onerror="this.src='images/default_img_b.jpg'">
					<div class="order_info">
						<h2 class="goods_list_text" style="margin-left: 0px;"><?php echo $items['product_name']; ?></h2>
						<p class="mm01_font1">
                        </p>
						<p class="c9">
							<span>数量：<em><?php echo $items['quantity']; ?></em></span>
						</p>
						<p class="order_price">
							<span><em>￥<?php echo number_format($items['total_price'],2); ?></em></span>
						</p>
					</div>
				</li>
			</ul>
            <!--商品信息 结束-->

		</div>
		<!--商品列表 结束-->

		<!--结算、支付 开始-->
		<div class="order_total">
    		<div class="section" style="position: fixed; bottom: 50px;padding-left: 10px; font-size: 14px;border-top: 1px solid #999;width:100%;padding-top: 10px;background: #fff;">
    			<span class="price_tit"><span><?php echo isset($items['quantity']) ? $items['quantity']:"0";?>件</span>总计:</span>
    			<span class="st" style="visibility: hidden;"></span>￥<span id="zong"><?php echo number_format($items['total_price'], 2);?></span><em></em>
    			<input type="hidden" value="<?php echo number_format($items['total_price'], 2);?>" id="order_total">
    			<a href="javascript:submitOrder();" class="order_tijiao_button custom_button" id="order_submit_status">提交订单</a>
    		</div>
            
    		<!--添加备注信息 开始-->
    		<!-- <ul>    
    			<li style="padding: 10px 10px; font-size: 14px">
    				<h3>
    					备注:<input type="text" value="" id="customer_remark" placeholder="选填" style="border: 0; width: 80%; margin-left: 10px;">
    				</h3>
    			</li>
    		</ul> -->
    		<!--添加备注信息 结束-->
	   </div>
</form>
</div>
    

	
	
<script>

function submitOrder() {

    var address_id = $('#address_id').val();

    if( address_id )
    {
        var product_id = "<?php echo $items['product_id'];?>";
        var quantity = "<?php echo $items['quantity'];?>";
        var tribe_id = "<?php echo $tribe_id;?>";

        $('#order_submit_status').text('结算中...');
        $('#order_submit_status').parent('div').css('background','#ccc');
        $('#order_submit_status').attr("href",'javascript:void(0)');

        var base_url = "<?php echo site_url()?>";

        $.ajax({
            url :base_url + '/easyshop/order/save',
            type:'post',
            dataType : "json",
            data:{'product_id':product_id,'quantity':quantity,'address_id':address_id,'tribe_id':tribe_id},
            beforeSend:function (XMLHttpRequest) {
                
                XMLHttpRequest.setRequestHeader("request_type","ajax");
                
            },
            success:function(data){
                console.log(data);
                switch(data.status){
                    case 0:
                        alert(data.errorMessage);
                        break;
                    case 255:
                        $(".black_feds").text(data.message).show();
                        setTimeout("prompt();", 2000);
                        window.setTimeout("window.location.href='"+data.redirect_url+"'", 2000);       
                        break;
                    case 'address':
                        alert(data['errorMessage']);
                        break;
                    default:
                        alert(data['errorMessage']);
                        location.href = base_url + '/easyshop/product';
                        break;
                }
            },
            error:function() {
                alert('网络连接超时');
                location.reload();
            }
        });
    }
    else
    {
        $(".black_feds").text("请先添加收货地址").show();
        setTimeout("prompt();", 3000);
        return;        
    }

}

</script>

