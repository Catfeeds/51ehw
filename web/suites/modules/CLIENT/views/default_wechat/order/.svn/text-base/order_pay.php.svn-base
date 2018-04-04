<style type="text/css">
	.container {background: #f4f4f4!important;}
	.container {background: #f4f4f4!important;}
    a {text-decoration: none;}
    .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:0.5;}
	.h5-forget { z-index: 999;position: fixed;width: 295px;height: 180px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -90px;left: 50%;margin-left: -150px;}
	.h5-lose { z-index: 999;float: right;margin-top: -15px;margin-right: -15px;}
	.forget-password {width: 265px;margin: 48px auto;text-align: center;}
	.password-text span {line-height: 30px;font-size: 16px;color: #333;}
	.password-button {height: 40px;width: 100%;background-color: #FECF0A;text-align: center;margin-top: 20px;line-height: 40px;font-size: 20px;color: #373422;display: inline-block;}
	
</style>
<div class="order-pay">



    <!--验证支付密码是否存在－-><!--默认隐藏-->
<div class="wrap_tanchuang"  id='no-paswd' hidden>
     <div class="h5-forget" >
     	<div class="h5-lose" onclick="$('#no-paswd').hide()">
			<img src="images/51h5-lose.png" height="34" width="34">
		</div>
    	 <div class="forget-password" >
    		<div class="password-text">
    		  <span>亲，您还没有设置支付密码，您要先设置支付密码才能支付哦</span>
    		</div>
    		<a href="<?php echo site_url("member/info/paypwd_edit");?>" class="password-button">设置</a>
    	</div>
	 </div>
</div>

<?php $prices = 0;?>
<?php if($show_m_pay):?>
    <!-- 有余额的时候 -->
	<div class="order-pay-yes" >
		<ul>
		  <li><span>订单金额</span><span class="fn-right order-pay-money-color"><?php echo $total_price?> 货豆</span></li>
		  <li class="order-pay-money"><span>货豆支付</span><span class="fn-right"><?php echo $total_price?> 货豆</span></li>
		  <li class="order-pay-money">请输入支付密码<input type="password" name="pay_passwd"></li>
		  <li class="order-pay-forget"><span class="order-pay-money-color" hidden >密码错误，请重新输入</span><a href="<?php echo site_url('member/info/paypwd_edit')?>" class="fn-right">忘记支付密码？</a></li>
	   </ul>	
	</div>
<?php else:?>
	<!-- 余额不足的时候 -->
	<div class="order-pay-no" >
		<ul>
		  <li><span>订单金额</span><span class="fn-right order-pay-money-color"><?php echo $total_price?> 货豆</span></li>
		  <li><span>货豆余额</span><span class="fn-right"><?php echo round($user_total_price,2);?> 货豆</span></li>
		  <li class="order-pay-money mb-10" id="order-pay-way">请选择支付方式<span class="order-pay-way-active">混合支付</span><span>微信支付</span><span>银联支付</span></li>
	   </ul>	
	</div>
	<div class="order-pay-no order-pay-way" >
		<ul>
		  <li class="order-pay-money"><span>货豆支付金额</span><span class="fn-right"><?php  echo round($user_total_price,2);?> 货豆</span></li>
		  <li class="order-pay-money"><span>微信支付金额</span><span class="fn-right"><?php echo round($total_price - $user_total_price,2)?> 元</span></li>
		  <?php $prices = round($user_total_price,2);
		  if($prices != 0){?>
		      <li class="order-pay-money">请输入支付密码<input type="password" name="pay_passwd"></li>
		  <li class="order-pay-forget"><span class="order-pay-money-color" hidden>密码错误，请重新输入</span><a href="<?php echo site_url('member/info/paypwd_edit')?>" class="fn-right">忘记支付密码？</a></li>
		  <?php }?>
		</ul>
		<ul hidden>
		  <li class="order-pay-money"><span >微信支付金额</span><span class="fn-right"><?php echo $total_price ?> 元</span></li>
		</ul>
		<ul hidden>
		   <li class="order-pay-money"><span >银联支付金额</span><span class="fn-right"><?php echo $total_price ?> 元</span></li>
		</ul>
	</div>	


<?php endif;?>



	<!-- 确认支付 -->
	<div class="order-pay-tishi" hidden>
	   
		<span>货豆扣款成功，将在3秒内跳转微信支付，请勿关闭页面</span>
	</div>
	<a href="javascript:;" onclick="is_pay()" class="order-pay-confirm" id="order-pay-confirm">确认支付</a>


	
</div>	


<script type="text/javascript">
var Third_pay = 'wechat';
	$("#order-pay-way span").on("click",function(){
		var index = $(this).index();
		status = index;
		if(status == 1){
			Third_pay = 'wechat';
			}
		if(status == 2){
			Third_pay = 'acppay';
			}
		$(this).addClass("order-pay-way-active").siblings().removeClass("order-pay-way-active");
		$(".order-pay-way ul").eq(index).show().siblings().hide();
	})
	// 点击确认支付
	function is_pay(){ 
		
		var pass = $('input[name=pay_passwd]').val();
    	if(!status || status == 0){   
    		<?php if($prices != 0){?>
    		<?php if(!empty($not_password)):?>
 		        $('#no-paswd').show();
 		        return;
    		<?php else:?>
    		
    		if(!pass){ 

    			$(".black_feds").text("请输入支付密码").show();
                setTimeout("prompt();", 1000);
                return;
            }
            <?php endif;?>
            <?php }?>
    	}
    	<?php if($type == 1):?>
            pay('<?php echo $order_id?>',pass);
        <?php elseif($type == 2):?>
            pay('<?php echo $address_id?>','<?php echo $buy_num?>','<?php echo $product_id?>','<?php echo $customer_remark?>','<?php echo $buy_amount?>',pass);
        <?php elseif( $type == 3):?>
            pay(pass,'<?php echo $total_price;?>','<?php echo $corp_id;?>', <?php echo $product_id;?>);
        <?php else:?>
            pay('<?php echo $order_id?>',pass);
        <?php endif;?>
    }
	
	
	// 去支付 - pay
<?php if($type == 1): //1 = 普通订单货豆的支付?> 
    function pay( id,pass ){
    	$.ajax({
            <?php if($show_m_pay):?>
                url:'<?php echo site_url('order/pay_order')?>', //普通货豆支付
                data:{id:id, pass:pass},
            <?php else:?>
                url:'<?php echo site_url('member/order/wechat_pay')?>', //微信
                <?php if($prices !=0){?>
				 data:{id:id, pass:pass, status:status },
				<?php }else{?>
				    data:{id:id, pass:pass, status:status ,no_pwd:'no_pwd'},
				<?php }?>
            <?php endif;?>
            
            dataType:'json',
            type:'post',
            beforeSend:function(){     
            	$('#order-pay-confirm').removeAttr('onclick');
                $('#order-pay-confirm').text('支付中....').css('background','#ccc');
    	    },
            success:function(data){
                switch(data.status){
                    case 1:
                    	<?php if($show_m_pay):?>
                        $(".black_feds").text("支付成功").show();
                        setTimeout("prompt();", 2000);
                        window.location.href=base_url+"/Order/payfinish?new_order_id="+id+"&status=4";
                        <?php else:?>
                        if(Third_pay == 'acppay'){
                        	window.location.href=base_url+"/Acppay/Notify_url/charge_pay/"+data.charge_id;
                            }
                        if(Third_pay == 'wechat'){
                       	 window.location.href=base_url+"/Wechatpay/js_api_call/pay/"+data.charge_id+'_3_C';
                        }
                        <?php endif;?>
                    	
                        break;
                    case 2:
                        $(".black_feds").text("订单错误").show();
                        setTimeout("prompt();", 2000);
                        window.location.href=base_url+"/member/order/";
                    	break;
                    case 3:
                        $(".black_feds").text("密码错误，请重新输入").show();
                        setTimeout("prompt();", 2000);
                        break;
                    case 4:
                    	location.reload();  
                        break;
                    case 5:
                    	$(".black_feds").text("支付失败,请重试").show();
                        setTimeout("prompt();", 2000);
                        break;
                    case 6:
                    	$(".black_feds").text("该订单或已完成支付").show();
                        setTimeout("prompt();", 2000);
                        window.location.href=base_url+"/member/order/detail/"+data.id;
                        break;
                    default:
                        $(".black_feds").text("支付失败,请重新支付").show();
                        setTimeout("prompt();", 2000);
                        break;
                }

                $('#order-pay-confirm').attr('onclick','is_pay()');
                $('#order-pay-confirm').text('确认支付').css('background','#fe2424');
            },
            error:function(){
            	$(".black_feds").text("支付失败").show();
                setTimeout("prompt();", 2000);
                $('#order-pay-confirm').attr('onclick','is_pay()');
                $('#order-pay-confirm').text('确认支付').css('background','#fe2424');
    	    }
        })
    }
<?php elseif($type == 2) ://拼团的支付?>
	
    function pay(address_id,buy_num,product_id,customer_remark,buy_amount,pass){
	
        $.ajax({
        	<?php if($show_m_pay):?> 
            url:"<?php echo site_url("activity/groupbuy/groupbuy_save_order")?>",
            <?php else:?>
        	url:"<?php echo site_url("activity/groupbuy/groupbuy_charge")?>",
            <?php endif;?>
            data:{pay_passwd:pass, address_id:address_id,buy_num:buy_num,product_id:product_id,customer_remark:customer_remark,buy_amount:buy_amount,status:status},
            dataType:'json',
            type:'post',
            beforeSend:function(){     
            	$('#order-pay-confirm').removeAttr('onclick');
                $('#order-pay-confirm').text('支付中....').css('background','#ccc');
    	    },
            success:function(data){
                switch(data['status']){
                    case 0:
                    	<?php if($show_m_pay):?>
                            $(".black_feds").text("支付成功").show();
                            setTimeout("prompt();", 1000);
                        	window.location.href=base_url+"/activity/groupbuy/group_detail?buy_num="+data['buy_num']+"&head_menber="+data['head_menber']+'&productid='+product_id;
                        <?php else:?>
                            if(Third_pay == 'acppay'){
    	                     	window.location.href=base_url+"/Acppay/Notify_url/charge_pay/"+data.charge_id;
    	                         }
    	                     if(Third_pay == 'wechat'){
    	                    	 window.location.href=base_url+"/Wechatpay/js_api_call/pay/"+data.charge_id+'_2_C';
    	                     }
                        <?php endif;?>
                    break;
                    case 1:
                    	$(".black_feds").text("已参加该团团购,自动跳转团购列表").show();
                    	setTimeout("prompt();", 3000);
                    	window.location.href=base_url+"/activity/groupbuy/group_detail?buy_num="+data['buy_num']+"&head_menber="+data['head_menber']+'&productid='+product_id;
                    break;
                    case 2:
                      $(".black_feds").text("订单生成失败").show();
                      setTimeout("prompt();", 3000);
                      window.location.reload();
                    break;
                    case 3:
                    	$(".black_feds").text("团人数已满，请重新开团").show();
                    	setTimeout("prompt();", 3000);
                    	window.location.href="<?php echo site_url("order/groupbuy/".$product_id."/0");?>";
                    break;
                    case 4:
                    	$(".black_feds").text("支付失败，密码错误").show();
                    	setTimeout("prompt();", 3000);
                    break;
                    case 5:
                        $(".black_feds").text("支付失败，余额不足").show();
                        setTimeout("prompt();", 3000);
                        break;
                    case 6:
                        $(".black_feds").text("订单生成失败").show();
                        setTimeout("prompt();", 3000);
                        window.location.reload();
                        break;
                    case 7:
                        $(".black_feds").text("网络错误，支付失败").show();
                        setTimeout("prompt();", 3000);
                        window.location.reload();
                        break;
                    case 8:
                        $(".black_feds").text("订单生成失败,请重试").show();
                        setTimeout("prompt();", 3000);
                        window.location.reload();
                        break;
                    case 10:
                        $(".black_feds").text("团购失败，余额不足，使用微信支付").show();
                        setTimeout("prompt();", 3000);
                        window.location.reload();
                    break;
                    case 11:
                        $(".black_feds").text("团购过期，欢迎选购其他团购商品").show();
                        setTimeout("prompt();", 3000);
                        window.location.href=base_url+"/activity/groupbuy/";
                    break;
                    case 12:
                        $(".black_feds").text("团购失败，购买数量不符合团购限制或库存不足").show();
                        setTimeout("prompt();", 3000);
                        setTimeout("history.back();",2000);
                    break;
                    case 13:
                        $(".black_feds").text("团购失败，库存不足").show();
                        setTimeout("prompt();", 3000);
                        setTimeout("history.back();",2000);
                    break;
                    default:
                        $(".black_feds").text("订单生成失败").show();
                        setTimeout("prompt();", 3000);
                        window.location.reload();
                    break;
                }
                $('#order-pay-confirm').attr('onclick','is_pay()');
                $('#order-pay-confirm').text('确认支付').css('background','#fe2424');
            },
            
            error:function(){
            	$(".black_feds").text("支付失败").show();
                setTimeout("prompt();", 2000);
                $('#order-pay-confirm').attr('onclick','is_pay()');
                $('#order-pay-confirm').text('确认支付').css('background','#fe2424');
    	    }
    	})
    	
    }

<?php elseif($type == 3) :?>
function pay( pass, total_price, corp_id, product_id ){
	
	$.ajax({
        <?php if($show_m_pay):?>
            url:'<?php echo site_url('member/order/pay_code_order')?>', //面对面货豆支付
            data:{pass:pass, total_price:total_price, corp_id:corp_id, product_id:product_id},
        <?php else:?>
            url:'<?php echo site_url('member/order/wechat_code_pay')?>', //微信需要生成订单
            data:{pass:pass, total_price:total_price, corp_id:corp_id, product_id:product_id, status:status },
        <?php endif;?>
        dataType:'json',
        type:'post',
        beforeSend:function(){     
        	$('#order-pay-confirm').removeAttr('onclick');
            $('#order-pay-confirm').text('支付中....').css('background','#ccc');
	    },
        success:function(data){
            switch(data.status){
                case 1:
                	<?php if($show_m_pay):?>
                        $(".black_feds").text("支付成功").show();
                        setTimeout("prompt();", 2000);
                        window.location.href=base_url+"/order/payfinish?new_order_id="+data.id+"&status=4";
                    <?php else:?>
                    if(Third_pay == 'acppay'){
                     	window.location.href=base_url+"/Acppay/Notify_url/charge_pay/"+data.charge_id;
                         }
                     if(Third_pay == 'wechat'){
                    	 window.location.href=base_url+"/Wechatpay/js_api_call/pay/"+data.charge_id+'_3_C';
                     }
                    <?php endif;?>
                    break;
                case 2:
                    $(".black_feds").text("商品错误，请联系店主").show();
                    setTimeout("prompt();", 2000);
                    break;
                case 3:
                    $(".black_feds").text("密码错误").show();
                    setTimeout("prompt();", 2000);
                    break;
                case 4:
                	$(".black_feds").text("货豆余额不足").show();
                    setTimeout("prompt();", 2000);
                    window.location.reload();
                    break;
                case 5:
                	$(".black_feds").text("无支付账户").show();
                    setTimeout("prompt();", 2000);
                    break;
                default:
                	$(".black_feds").text("支付失败").show();
                    setTimeout("prompt();", 2000);
                    break;
            }

            $('#order-pay-confirm').attr('onclick','is_pay()');
            $('#order-pay-confirm').text('确认支付').css('background','#fe2424');
        },
        error:function(){
        	$(".black_feds").text("支付失败").show();
            setTimeout("prompt();", 2000);
            $('#order-pay-confirm').attr('onclick','is_pay()');
            $('#order-pay-confirm').text('确认支付').css('background','#fe2424');
	    }
    })
}

<?php else:?>

jQuery(document).ready(function($) {

	  if (window.history && window.history.pushState) {

	    $(window).on('popstate', function() {
	      var hashLocation = location.hash;
	      var hashSplit = hashLocation.split("#!/");
	      var hashName = hashSplit[1];

	      if (hashName !== '') {
	        var hash = window.location.hash;
	        if (hash === '') {
	        	if(confirm("确定要取消支付吗？若取消后可在我的订单中进行支付！"))
	        	{
	           		location.href= base_url+"/Member/info";
	        	} 
	        }
	      }
	    });
	    
	    window.history.pushState('forward', null, window.location.href);
	  }

	});



function pay( order, pass ){
    
    $.ajax({ 
    	<?php if($show_m_pay):?>
   			url:'<?php echo site_url('order/All_order_pay')?>', 
     		data:{'order':order,'pass':pass,'status':status},
        <?php else:?>
   			url:'<?php echo site_url('member/order/wechat_allorder_pay')?>', 
      		 <?php if($prices !=0){?>
       		data:{'order':order,'pass':pass,'status':status},
    		<?php }else{?>
    		data:{'order':order,'pass':pass,'status':status,no_pwd:'no_pwd'},
    		<?php }?>
    	<?php endif;?>
        type:'post',
        dataType:'json',
        success:function(data)
        { 
        	switch (data.status){
        	
				case 'success'://成功
					<?php if($show_m_pay):?>
    					$(".black_feds").text("支付成功").show();
                        setTimeout("prompt();", 2000);
                        
    				    var total_price = data.total_price+'';
    					
    					if( total_price.indexOf('.') == -1 )
    				    { 
    						total_price = total_price+'.00'
    				    }
    					window.location.href=base_url+"/order/payfinish?total_price="+total_price;
					<?php else:?>
					 	if(Third_pay == 'acppay'){
	                     	window.location.href=base_url+"/Acppay/Notify_url/charge_pay/"+data.charge_id;
	                         }
	                     if(Third_pay == 'wechat'){
	                    	 window.location.href=base_url+"/Wechatpay/js_api_call/pay/"+data.charge_id+'_4_C';
	                     }
                    <?php endif;?>
					break;
				case 'fail'://订单生成失败执行
					$(".black_feds").text("支付失败").show();
			        setTimeout("prompt();", 1000);
					break;
				case 'wrong'://密码错误
					$(".black_feds").text("密码错误").show();
                    setTimeout("prompt();", 2000);
					break;
				case 'no_money':
					window.location.reload();
// 					if(confirm("余额不足无法支付，立即去充值？"))
// 			    	{
// 			       		location.href= base_url+"/Member/property/get_list";
// 			    	}
					break;
				case 'recur':
					$(".black_feds").text("订单错误或已经支付,请勿重复发起支付").show();
			        setTimeout("prompt();", 1000);
			        break;
				default://未知问题执行
					$(".black_feds").text("支付失败").show();
				    setTimeout("prompt();", 2000);
					break;
			}    
        },
        error:function(){
        	$(".black_feds").text("支付失败").show();
            setTimeout("prompt();", 2000);
	    }
        
    })
}
<?php endif;?>

</script>


