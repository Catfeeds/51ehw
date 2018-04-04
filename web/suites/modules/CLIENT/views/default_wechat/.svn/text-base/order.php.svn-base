<script type="text/javascript" src="js/orderinfo.js"></script>
<style type="text/css">
.page {padding-bottom: 100px;}
.footer{bottom:0px;}
.pintuan-wanfang ul li {float: left;}
.pintuan-xuanze {margin: 5px 5px 5px 0px;float:left;text-align: center;;width:25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-yaoqing {margin-top: 5px;margin-right: 5px;float:left;text-align: center;;width:25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-renshu {margin-top: 5px;margin-right: 5px;float:left;text-align: center;;width:25px;line-height: 25px;border-radius: 50%;background: #D5D5D5;}
.pintuan-shijian {padding-left: 10px;color:#FA6C32;}
.pintuan-xianxia {font-size: 17px;color:#22AA1E;padding-right: 10px;}
.order_tijiao_button {bottom: 50px;}
.queding-bt {width: 100%;height: 40px;background: #fe4101;text-align: center;margin: auto;margin-bottom: 50px;margin-top: 35px;}
.queding-bt a {display: inline-block;line-height: 44px;width: 100%;font-size: 17px;color: #fff;}
.client_commodity_block_nav ul li {width: 50%;}
.commodity_record ul li {position: relative;}
.choose-icon {position: absolute;right: 30px;bottom: 40px;font-size: 25px;color: #999;}
.color-red {color: red!important;}
.juan {display: none;}
.juan-header {position: relative;height: 50px;line-height: 50px;text-align: center;background: black;color: #fff;font-size: 16px;}
.juan-icon {position: absolute;top: 15px;left: 10px;}
@media screen and (max-width:320px) {
.pintuan-shijian {padding-left: 3px;}
.pintuan-xianxia {padding-right: 0px;}
}
.choose-icon {left: 0px;}
input[type=checkbox]{
  border: 0!important;background:rgba(0,0,0,0);
}
</style>
<div class="order-detail">
<form id="order_save" method="post" name="order_save">
	<div class="page clearfix">
		<?php if (count($address) === 0):?>
		<!-- 新订单页收货地址为空时 -->
		<div>
			<a href="<?php echo isset($activity)?site_url("member/address/index/2"):site_url("member/address/index/1");?>">
    			<div class="" style="position: relative; margin-left: 40px; margin-top: 10px; font-size: 14px; color: #363636;">
    				<em class="icon-locationfill c9" style="position: absolute; top: 5px; left: -29px; font-size: 20px;"></em>
    				<span style="display: block; padding-top: 5px;">您还没有创建收货地址</span>
    			</div>
			</a>
		</div>
		<!-- 新订单页收货地址为空时 end -->
		<?php else: ?>
		<!-- 收货地址new 开始 -->
		<div class="" style="position: relative; margin-left: 40px; margin-top: 10px; font-size: 14px; color: #363636;">
			<a href="<?php echo isset($activity)?site_url("member/address/index/2"):site_url("member/address/index/1");?>">
    			<em class="icon-locationfill" style="position: absolute; top: 18px; left: -29px; color: #fe4101; font-size: 20px;"></em>
    			<span>
        			<span style="opacity: 0">字</span>收货人：
        			<span><?php echo $address['0']['consignee'];?></span>
    			</span><br>
    			<span class="c9" style="float:right;">
    				<em class="icon-right  firm_order_font"></em>
    			</span>
    			<span style="display: block; padding-top: 5px;">联系电话：
    				<span><?php echo $address['0']['mobile'];?></span>
    			</span>
    			<span style="padding-top: 5px;">收货地址：
    				<span><?php echo $address['0']['address_for_name'].$address['0']['address'];?></span>
    			</span>
			</a>
		</div>
		<!--收货地址 结束-->
		<?php 
		endif;?>
		<div style="display:none;"><input type="text" id="address_id" value="<?php echo isset($address['0']['id'])?$address['0']['id']:""; ?>"></div>
		<div style="margin-top: 10px;">
			<img src="images/goods_list_bottom.png" alt="">
		</div>
		
		<!--商品列表 开始-->
		<div class="order_confirm firm_order_list">

			<!--只能提交一家店铺的订单-->
			<!--新增店铺信息 开始-->

			<!--新增店铺信息 结束-->
			<!--商品信息 开始-->
            <?php
            if(isset($activity) && $activity=='groupbuy'):?>
            <ul style="border-bottom: 1px solid #e6e6e6; font-size: 14px;">
				<li><em class="icon-shop"></em> <span
					style="margin-left: 10px; line-height: 30px;"><?php echo $groupbuy_product['corporation_name'] ?></span>
				</li>
			</ul>
			<ul class="order_list" style="margin-top: 5px;border-bottom: 1px solid #e6e6e6;">
				<li>
					<img src="<?php echo IMAGE_URL.$groupbuy_product['goods_img'];?>"
					alt="<?php echo $groupbuy_product['name']; ?>"
					class="fn-left good_list_img"
					onerror="this.src='images/default_img_b.jpg'">
					<div class="order_info">
						<h2 class="goods_list_text" style="margin-left: 0px;"><?php echo $groupbuy_product['name']; ?></h2>
						    <p class="c9">
							    
							    <lable class="item detail-itme-num" style="width:43px;">数量:</lable>
                                <span class="add-del">
                                    <a href="javascript:jQuery.reduce('#item_num');" class="btn-del num_oper num_min detail-jian-num"><span>－</span></a>
                                    <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="<?php echo $groupbuy_product['set_limit'] ? ($buy_amount >= $groupbuy_product['least_purchase'] && $buy_amount <=$groupbuy_product['most_purchase'] ? $buy_amount : $groupbuy_product['least_purchase'] ) : $buy_amount;?>" onblur="jQuery.modify('#item_num');" onkeyup="jQuery.finishing('#item_num');"/>
                                    <a href="javascript:jQuery.add('#item_num')" class="btn-add num_oper num_plus"><span >+</span></a>
                                    
                                </span>
							</p>
						<p class="order_price">
						<lable class="item ">单价:&nbsp;
							<span><em id="group_by_price"><?php echo number_format($groupbuy_product['groupbuy_price'],2); ?></em> 货豆</span>
						</lable>
						</p>
						<p class="fn-12 c9"
							style="float: right; font-size: 13px !important; color: #0E0E0E !important; margin-top: -25px; border: 1px solid #A2A2A2; padding-top: 0px;">
							<?php echo $groupbuy_product['menber_num']; ?>人团
						</p>
					</div></li>
			</ul>
			<?php else:
            $total = 0;
            $total_qty = 0;
            
            foreach($corp_product as $k => $val){?>
            <span id="corp_<?php echo $val['corporation_id'];?>"><!-- 包住店铺 -->
            <input style="display:none"; value="0" name="discount" id='discount_<?php echo $val['corporation_id']?>'><!-- 记录优惠金额 -->
            <?php $val['total_price']  = 0;?>
            
                <ul style="border-bottom: 1px solid #e6e6e6; font-size: 14px;">
                    <li><em class="icon-shop"></em>
                        <span style="margin-left: 10px; line-height: 30px;"><?php echo $val["corporation_name"];?></span>
                    </li>
    			</ul>
			
    			 <?php foreach( $val['product_info'] as $v):?>
        			 <?php 
                        $total += $v['is_on_sale'] ? $v['price']*$v['qty'] : 0 ;
                        
                        $total_qty += $v['is_on_sale'] ? $v['qty'] : 0 ;
                        if( $v['is_on_sale'] ){
                            
                            $product_data[$v['id']]['id'] = $v['id'];
                            $product_data[$v['id']]['rowid'] = $v['rowid'];
                            $product_data[$v['id']]['qty'] = $v['qty'];
                            $product_data[$v['id']]['cid'] = $v['cid'];
                            $product_data[$v['id']]['special_price_start_at'] = $v['options']['special_price_start_at'];
                            $product_data[$v['id']]['special_price_end_at'] = $v['options']['special_price_end_at'];
                            $product_data[$v['id']]['freight'] = $v['freight'];
                        }
                    
                     ?>
                
        		    <ul class="order_list" style="margin-top: 5px;border-bottom: 1px solid #e6e6e6; <?php echo !$v['is_on_sale'] ? 'background-color:#EEE9E9;' : ''?>" >
        				<li>
        				
        					<img src="<?php echo IMAGE_URL.$v['options']['goods_img'];?>" alt="<?php echo $v['name']; ?>" class="fn-left good_list_img" onerror="this.src='images/default_img_b.jpg'">
        					<div class="order_info">
        						<h2 class="goods_list_text" style="margin-left: 0px;"><?php echo $v['name']; ?></h2>
        						<?php if( !empty($v['special_status']) ):?>
                                    <br/><span style="color:red">(特价活动结束,已恢复原价)</span>
                               <?php endif; ?>
        						<p class="mm01_font1">
        						  
                                <?php if(isset($v['sku_name']) && $v['sku_name']!=null): ?>
                                        
                                    <?php foreach ($v['sku_name'] as $sku_name): ?>
                                          <span><?php echo $sku_name ?></span>
                                          <!-- <span class="mm01_font2">容量：5</span>-->
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php echo !$v['is_on_sale'] ? '(商品失效)' : ''?>
                                
                                </p>
        						<p class="c9">
        							<span>数量：<em><?php echo $v['qty']; ?></em></span>
        						</p>
        						<p class="order_price">
        							
        						</p>
        					</div>
        				</li>
        			</ul>
	
                <?php if($v['is_on_sale']){; ?>
                    <input style="display:none"; value="<?php echo $v['product_id'];?>" class="product_id"><!-- 记录商品id -->
                    <input style="display:none"; value="<?php echo $v['price']*$v['qty'];?>" ><!-- 数量x单价格 -->
                <?php };?>
    			<?php endforeach;?>
    			<ul style="border-bottom: 1px solid #e6e6e6; font-size: 14px;">
        			<li style="padding: 10px 10px; font-size: 14px">
        				备注:<h3>
        					<textarea class="remark_<?php echo $k;?>" name="customer_remark" placeholder="输入您对卖家的留言" style="resize: none; width:80%;height:80px;border: 1px solid #ddd;outline: none;"></textarea>
        				</h3>
    			    </li>
			    </ul>
			<br/>
			</span>
			<?php };?>
            
			
			<?php endif;?>
            <!--商品信息 结束-->

		</div>
		<!--商品列表 结束-->

        <?php if(isset($activity) && $activity=='groupbuy'):?>
		<!-- 拼团玩法 -->
		<div class="order_list_title"
			style="position: relative; padding: 10px 0; border-bottom: 1px solid #E8E8E8; margin-left: 10px;">
			<span style="font-size: 14px;">拼团玩法</span>
		</div>
		 <div style="position: relative;padding:10px 20px;" class="pintuan-wanfang">
            <ul style="overflow: hidden;">
               <li style="groupbuy_home.php"><div class="pintuan-xuanze"  style="background:#FECF0A;">1</div><div style="float:left;"><p>选择商品</p><p>付款开团/参团</p></div></li>
               <li style="width:120px;margin-left: 10px;margin-right: 10px;"><div class="pintuan-yaoqing">2</div><div style="float:left;"><p>邀请并等待好友</p><p>支付参团</p></div></li>
               <li style=""><div class="pintuan-renshu">3</div><div style="float:left;"><p>达到人数</p><p>顺利成团</p></div></li>
            </ul>
        </div>
		<?php endif ;?>

		<!--结算、支付 开始-->
		<div class="order_total">
			<div class="section" style="position: fixed; bottom: 50px;padding-left: 10px; font-size: 14px;border-top: 1px solid #999;width:100%;padding-top: 10px;z-index: 998;background: #fff;">
		<?php // 拼团结算 ?>
        <?php if(isset($activity) && $activity=='groupbuy'):?>
				<span class="price_tit"><span></span>总计:</span>
				<span class="st" style="visibility: hidden;"></span><span id="group_by_total"><?php echo number_format($groupbuy_product['groupbuy_price'] * ( $groupbuy_product['set_limit'] ? ($buy_amount >= $groupbuy_product['least_purchase'] && $buy_amount <=$groupbuy_product['most_purchase'] ? $buy_amount : $groupbuy_product['least_purchase'] ) : $buy_amount ),2);?> </span> 货豆<em></em>
			</div>
			<?php if(isset($group_info) && count($group_info)>0 && $group_info['status'] == 1):?>
			<a href="<?php echo site_url("goods/detail/".$groupbuy_product['id']."/0/groupbuy/")?>" class="order_tijiao_button" style="width: 180px;">已成团，重新开团</a>
			<?php else:?>
			<a href="javascript:submitgroupbuy();" class="order_tijiao_button" style="width: 180px;">去支付，拼团开启</a>
			<?php endif;?>
        <?php else:?>
		<?php // 普通结算 ?>
                <span class="price_tit">运费：<?php echo number_format($freight, 2, '.', '');?> 货豆</span><br/>
				
				<span class="price_tit"><span><?php echo isset($total_qty) ? $total_qty:"0";?>件</span>总计:</span>
				<span class="st" style="visibility: hidden;"></span><span id="zong"><?php echo number_format($total+$freight, 2);?></span> 货豆<em></em>
			</div>
			<span id="gtotal" hidden><?php echo number_format($total+$freight, 2);?></span>
			<a href="javascript:submitOrder();" class="order_tijiao_button" id="order_submit_status">提交订单</a>
        <?php endif?>
		</div>
		<!--结算、支付 结束-->
        <!-- 优惠劵 
        <ul style="border-top: 5px solid #f4f4f4;">
            <li style="padding: 10px 0; font-size: 13px;margin:0px 10px;border-bottom: 1px solid #ddd;font-size: 14pxl;">
               <a href="javascript:void(0);">优惠劵<span style="float:right;">100.00货豆<span class="icon-right" style="float: right;font-size: 17px;margin-top: -3px;padding-left: 5px;color: #999;"></span></span></a>
            </li>
        </ul>
		-->

		<!--添加备注信息 开始-->
        <?php if(isset($activity) && $activity=='groupbuy'):?>  
		<ul style="display:none;">    
        <?php else:?>
		<ul>
        <?php endif?>
			
		</ul>
		<!--添加备注信息 结束-->

        

        <!-- 商品金额／运费／优惠劵 -->
        <ul style="border-top: 5px solid #f4f4f4;border-bottom: 1px solid #f4f4f4;">
            <!-- <li style="padding: 10px 0; font-size: 13px;margin:0px 10px;border-bottom: 1px solid #ddd;font-size: 14px;">
               <a href="javascript:void(0);">商品金额<span style="float:right;">1600.00货豆</span></a>
            </li>  -->
            <?php if(!isset($activity) || !$activity=='groupbuy'):?>
            <li class="juan-list"  style="position: relative;padding: 10px 0; font-size: 13px;margin:0px 10px;border-bottom: 1px solid #ddd;font-size: 14px;">
                   <a href="javascript:void(0);">优惠劵(<?php 
                   if(!empty($package)){
                       foreach ($package as $key=>$val){
                           $pack =$val;
                       }
                       echo count($pack);
                   }else{
                       echo  0;
                   }
                 ?>)<span style="float:right;padding-right: 10px;" id="total"><?php echo empty($package)?'不可用':'未使用';?><span class="icon-right" style="position: absolute;right:0;top: 12px;"></span></span></a>
            </li>
            <?php endif;?>
           
        </ul>
		
	</div>
</form>
</div>
<!--page end-->

<!-- 可用优惠劵 -->
<div class="juan">
<div class="juan-header">
    <span class="icon-back juan-icon" onclick="revert();">返回</span><span>使用优惠劵</span>
</div>
<div class="client_commodity_block_nav">
    <ul>
        <li class="client_commodity_block_active">可使用优惠劵</li>
        <li >不可使用优惠劵</li>
    </ul>
</div>
<?php if(empty($package)){?>
<div class="client_commodity_block_not">
    <span class="icon-kong client_block_icon"></span>
    <span class="client_block_not_text">暂无可用优惠劵</span>
</div>
<?php };?> 
<div class="commodity_record" id="shopping-cart-list">
    <!-- 可以使用 -->
    <ul style="display: block;">
        <?php if(!empty($package)){?>
        <?php foreach ($package as $key => $val){;?>
        <?php foreach ($val as $v){;?>
        <li class="commodity_detail-list" >
           <a href="javascript:void(0);">
            <div>
              <img src="<?php echo IMAGE_URL.$v["coupon_image"];?>" alt="" onerror="this.src='images/default_img_b.jpg'">
           </div>
           </a>
           <label onclick="select(this,<?php echo $key;?>);"><input type="checkbox"  name="coupon" value="<?php echo $v['id'];?>" class="icon-roundcheckfill icon-quan choose-icon coupon_<?php echo $key;?>"></label>
        </li>
        <?php };?>
        <?php };?>
        <?php };?>
        
        <?php if(!empty($package)){?>
        <div class="queding-bt">
            <a href="javascript:revert();">确定</a>
        </div>
        <?php };?>
    </ul>

    <!-- 不可以使用 -->
    <ul style="display: none;">
    <?php if(!empty($not_package)){?>
    <?php foreach ($not_package as $v){;?>
        <li class="commodity_detail-list">
           <a href="javascript:void(0);">
            <div>
              <img src="<?php echo IMAGE_URL.$v["coupon_image"];?>" alt="" onerror="this.src='images/default_img_b.jpg'">
           </div>
           </a>
        </li>
    <?php };?>
    <?php };?>
    </ul>
</div>


</div>
<!--wrap 新增支付流程－输入支付密码－弹窗 开始-->
	<!--默认隐藏-->
	<div class="wrap_tanchuang" hidden id="wrap_tanchuang_zhifu">
		<div class="wrap_tanchuang_con">
			<div class="wrap_tanchuang_top">支付确认</div>
			<div class="wrap_tanchuang_top2">
				<ul class="payNum_ul clearfix">
					<li><span class="pay_left">订单金额：</span><span id="all_order_price"></span></li>
					<li><span class="pay_left">支付密码：</span><span><input type="password"
							placeholder="请输入支付密码" name="pay_password" class="payNum_input"></span>
						<a href="<?php echo  site_url('Member/info/paypwd_edit') ?>" class="payNum_forget">忘记密码？</a></li>
					<li hidden id='pass_message'><span class="payNum_tips"></span></li>
				</ul>
			</div>
			<div class="wrap_tanchuang_btn clearfix">
				<ul>
					<li class="wrap_tanchuang_btn01" style="background: #ccc;"><a
						href="javascript:;" onclick="cancel_pay()">取消支付</a></li>
					<li class="wrap_tanchuang_btn01"><a href="javascript:;" id='pay_' onclick="all_order_pay()">确认支付</a></li>
				</ul>
			</div>

		</div>
	</div>
	<!--wrap 新增支付流程－输入支付密码－弹窗 结束-->


<script type="text/javascript">
    $(".client_commodity_block_nav ul li").on("click",function(){
        var index = $(this).index();
        $(this).addClass("client_commodity_block_active").siblings().removeClass("client_commodity_block_active");
        $(".commodity_record ul").eq(index).show().siblings().hide();
        $(".client_commodity_block_not").hide();
    })




    $(".juan-list").on("click",function(){
        $(".juan").css("display","block");
        $(".order-detail").css("display","none");
    })


    function revert(){
        $(".juan").css("display","none");
        $(".order-detail").css("display","block");
    }

    var product_data = new Array();
    product_data = jQuery.parseJSON('<?php echo !empty($product_data) ?  json_encode($product_data) : ''?>');

</script>

<script>


//弹窗：特价恢复原价确定继续购买
function sure_bullet(sure_text){
	$(".color-bg").show();
	$("#just_sure").show();
	$("#sure_test").text(sure_text)
	$("#sure_submit").attr("href","javascript:sure();");
}

//选择优惠卷，实时运算优惠金额
function select(obj,corpid){
	id = $(obj).children().val();//当前选中的
    $(".coupon_"+corpid).each(function (){
        if($(this).val()==id && $(obj).children().is(':checked')){
            $(this).removeClass('icon-quan');   
            $(this).addClass('color-red');
        }else{
            //筛选卡包
            $(this).prop("checked",false)
            $(this).addClass('icon-quan');   
            $(this).removeClass('color-red'); 

        }
    });
    
    var order_total =  Number("<?php echo $total+$freight;?>");//订单总价（优惠前）
	var discount_price = 0;//店铺优惠的金额
    var discount_price_total = 0;//订单优惠总金额
	var package_id = new Array();//卡包id
	var i = 0;
    $("input[name=coupon]").each(function (){
        if($(this).is(":checked")){
        	package_id[i] = $(this).val();
            i++;
        }
    });
    
    //判断是否使用优惠券
    if(package_id.length){
        $.post("<?php echo site_url('order/discount_goods');?>",{package_id:package_id},function(data){//优惠券相关商品
        if(data.length>0){
            for(var i=0;i<data.length;i++){
                $("#corp_"+corpid+" .product_id").each(function(k,v){//循环获取店铺商品id
                    if(data[i]['id'] == $(this).val()){
                        if(data[i]['discount_type']==1){//打折
                    	   p_price = $(this).next().val();//商品总价（单价*数量）
                     	   discount_price += Number(p_price * (10-data[i]['discount'])/10);//优惠金额
                        }else{//满减
                     	   discount_price = Number(data[i]['deduction_price']);//优惠金额
                        }
                    }
                 });
            }
            
            $("#discount_"+corpid).val(discount_price);//记录每家店铺优惠金额
            //获取订单优惠总金额
            $("input[name=discount]").each(function(){
                discount_price_total += Number($(this).val());
            });
            if(discount_price_total == parseInt(discount_price_total)){
             	 var s = discount_price_total+'.00';
                  }else{
                    	 var s = discount_price_total+'';
                      }
            var discount_price_str = s.substring(0,s.indexOf(".") + 3)
            var discount_prices =  parseFloat(discount_price_str);
            //获取订单优惠总金额
            order_total = Number(order_total - discount_prices);
            $("#total").html('-'+discount_prices+'货豆');//优惠金额
            $("#zong").html( (order_total).toFixed(2) );//优惠后的总额


            
        }else{//找不到相关商品
        	window.location.reload();
        	return;
        }
        },"json");
    }else{
    	$("#total").html('未使用<span class="icon-right" style="position: absolute;right:0;top: 12px;"></span>');//优惠金额
        $("#zong").html((order_total).toFixed(2) );//优惠后的总额
    }
    
}



function cancel_pay()
{
	 
   	if(confirm("确定要取消支付吗？"))
	{
   		location.href= base_url+"/Member/order";
	} 
}

</script>

<?php if(isset($activity) && $activity=='groupbuy'):?>
<!-- 团购直接支付 -->
<script>



var show_bullet_id = "<?php echo $bullet_set == 1?"skip_bullet":"pay_bullet";?>";
var is_wechat = "<?php echo strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false?"true":"false";?>";
function submitgroupbuy(){
	if(!$("#address_id").val()){
		$(".black_feds").text("请先添加收货地址").show();
		setTimeout("prompt();", 3000);
		return;
	}
	
    var address_id = $('#address_id').val();
    var product_id = '<?php echo isset($groupbuy_product['id'])?$groupbuy_product['id']:0;?>';
    var buy_num = '<?php echo isset($buy_num)?$buy_num:0;?>';
    var customer_remark = $("#customer_remark").val();
    var buy_amount = $('input[name=item_num]').val();// 购买数量
    
	//跳转支付
	window.location.href=base_url+"/Member/order/groupbuy_pay/?address_id="+address_id+"&product_id="+product_id+"&buy_num="+buy_num+"&customer_remark="+customer_remark+"&buy_amount="+buy_amount;
}


var stock = "<?php echo $groupbuy_product['stock']?>";
var set_limit = "<?php  echo $groupbuy_product['set_limit']?>";
var min = 1;
var max = stock;
if( set_limit ){ 
	var min = "<?php echo $groupbuy_product['least_purchase'] ?>" ;
    var most_purchase = "<?php echo $groupbuy_product['most_purchase']?>";
    max = most_purchase;
}

jQuery.extend( {
	
    reg : function(x) {
    	jQuery('#item-error').html("");
        jQuery('#item-error').hide();
        return new RegExp("^[1-9]\\d*$").test(x);
    },
    amount : function(obj, mode) {
        
        var x = jQuery(obj).val();
        if (this.reg(parseInt(x))) {
            if (mode) {
                x++;
            } else {
                x--;
            }
        } else {
            jQuery(obj).val(1);
			$(".black_feds").text("请输入正确的数量！").show();
	    	setTimeout("prompt();", 2000);
	    	return;
        }
        return x;
    },
    reduce : function(obj) { //-
        
    	var x = this.amount(obj, false);
    	if(parseInt(x) > parseInt(stock) ){
        	
    		jQuery(obj).val(parseInt(stock));
            calculate_price(x);
        }else if (parseInt(x) >= min) {
            
            jQuery(obj).val(x);
            calculate_price(x);
        } else {
            $(".black_feds").text("购买数量不能小于指定数量").show();
	    	setTimeout("prompt();", 2000);
	    	return;
        }
    },
    add : function(obj) { //+
        var x = this.amount(obj, true);

        if(set_limit){ 
            
           	 if( parseInt(x) > parseInt(most_purchase) ){ 
               	$(".black_feds").text("超过限购数量").show();
              	setTimeout("prompt();", 2000);
              	return;
              }
        }
        if (parseInt(x) <= parseInt(stock)) {
            jQuery(obj).val(x);
            calculate_price(x);
        }else{ 
        	$(".black_feds").text("超过库存").show();
	    	setTimeout("prompt();", 2000);
	    	return;
        }
    },
    modify : function(obj) {
    	
        var x = jQuery(obj).val();
        if(!x || x==0){ 
        	jQuery(obj).val(min);
        	calculate_price(min);
        }
        
    },
    finishing : function(obj){
        var x = jQuery(obj).val();

        if(set_limit){
            
            if( parseInt(x) > parseInt(most_purchase) ){
            	$(".black_feds").text("超过限购数量").show();
         	    setTimeout("prompt();", 2000);
         	    jQuery(obj).val(most_purchase); // 禁止输入中文
            	calculate_price(most_purchase);
            	
            	return;
            }
        }
        if(parseInt(x) > parseInt(stock)){
        	$(".black_feds").text("超过库存").show();
     	    setTimeout("prompt();", 2000);
     	    chulinum = stock;
      	    jQuery(obj).val(chulinum.replace(/[^0-9]/ig,"")); // 禁止输入中文
        	calculate_price(parseInt(jQuery(obj).val().replace(/[^0-9]/ig,"")));
        	return;
       }else{ 
    	   jQuery(obj).val(x); // 禁止输入中文
           calculate_price(parseInt(x) );
       }

        
        
    }
});

function calculate_price(total_num){ 
	if(!total_num)
		var total_num = 1;

	var group_by_price = $('#group_by_price').text();//单价
	$('#group_by_total').text( formatCurrency( (group_by_price.replace(/,/g,"")* total_num).toFixed(2) ) );
	
}

function formatCurrency(num) {  
    num = num.toString().replace(/\$|\,/g,'');  
    if(isNaN(num))  
        num = "0";  
    sign = (num == (num = Math.abs(num)));  
    num = Math.floor(num*100+0.50000000001);  
    cents = num%100;  
    num = Math.floor(num/100).toString();  
    if(cents<10)  
    cents = "0" + cents;  
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)  
    num = num.substring(0,num.length-(4*i+3))+','+  
    num.substring(num.length-(4*i+3));  
    return (((sign)?'':'-') + num + '.' + cents);  
} 
$(function(){ 
	
	 var moren_price = $('#group_by_price').text();//单价
	 var moren_num = $('#item_num').val();;
	 $('#group_by_total').text( formatCurrency( (moren_price.replace(/,/g,"")* parseInt(moren_num) ).toFixed(2) ) );
	
})
</script>

<script>
function wecht_pay(){
	var address_id = $('#address_id').val();
    var product_id = '<?php echo isset($groupbuy_product['id'])?$groupbuy_product['id']:0;?>';
    var buy_num = '<?php echo isset($buy_num)?$buy_num:0;?>';
    var customer_remark = $("#customer_remark").val();
    var buy_amount = $('input[name=item_num]').val();// 购买数量
    window.location.href="<?php echo site_url("activity/groupbuy/groupbuy_charge");?>"+'?address_id='+address_id+'&payment_id='+2+"&product_id="+product_id+"&customer_remark="+customer_remark+"&buy_num="+buy_num+"&shipping_fee=0&buy_amount="+buy_amount;
}
</script>
<?php endif?>