<script type="text/javascript" src="js/common.js" ></script>
<script type="text/javascript" src="js/orderinfo.js" ></script>
<script language="JavaScript"> 

<!--
var base_url = '<?php echo site_url();?>';
$(document).ready(function() {
	
	$(':radio[name="address_id"]').change(function(obj){
		if($(':radio[name="address_id"]:checked').val()=="new")
		{
			if($('#consignee_from').length < 1)
			{
				showForm_consignee(this);
			}
		}else{
			if($('#consignee_from').length > 0)
			{
				$('#consignee_from').remove();
				isNewCon = false;
			}
			
		}
	});
	$(':radio[name="is_invoice"]').change(function(obj){
		if($(':radio[name="address_id"]:checked').val()=="1")
		{
// 			if($('#invoice_from').length < 1)
// 			{
// 				//showForm_consignee(this);
// 				alert('show invoice_from');
				$('#invoice_from').toggle('show');
// 			}
		}else{
// 			if($('#invoice_from').length > 0)
// 			{
// 				alert('hidden invoice_from');
// 				$('#invoice_from').remove();
				$('#invoice_from').toggle('hidden');
// 			}
			
		}
	});

	choose_address();
});

function clickAddress(obj)
{
	document.order_save.address_id.value = $(obj).val();
	choose_address(obj);
    
}

function choose_address(obj)
{ 
	if(!obj)
	{
		var obj = $('input[name=address_id]:checked');

		if(!obj.length)
		{
			return false;
		}
    }

    
	var address_city = $(obj).parents('ul').find('li').eq(1).find('span').html().substr(4);
    var address_street = $(obj).parents('ul').find('li').eq(1).find('span').eq(1).html().substr(6);
    var customer_name = $(obj).parents('ul').find('li').eq(3).find('span').html();//收货人
    var mobile = $(obj).parents('ul').find('li').eq(5).find('span').html();//手机
    var address_info = address_city+address_street;
    $('#address_info').text('寄送至：'+address_info);
    $('#customer_name').text('收货人：'+customer_name);
    $('#mobile').text('联系手机：'+mobile); 
}

function new_address(){
	
	$('#consignee_addressName').val("");
	$('#consignee_postcode').val("");
	$('#consignee_address').val("");
	$('#consignee_message').val("");
	$('#consignee_phone').val("");

	$('#addaddress').show();
	//if($('#consignee_from').length < 1)
	//{
	//	showForm_consignee(this);
	//}
}

function save_consignee()
{
	//clearSubmitError(obj);
	if(check_con())
	{
		var province = $('#province_id').find("option:selected").text()+'省';
		var city = $('#city_id').find("option:selected").text()+'市';
	    var district = $('#district_id').find("option:selected").text();
	    
		
		var form = $('#addressform').serialize();
		
		$.post("<?php echo site_url('member/address/ajax_save')?>",form,function(result){
			
			var data = JSON.parse(result);
			    
			if(data["errorcode"]==0)
			{
				var str = '<div class="dingdan2_con02">'+
                			'<ul>'+
                    			'<li>'+
									'<div class="gouwuche_selectAll dingdan2_selectAll">'+
										'<div class="gouwuche_checkbox">'+
											'<input type="radio" name="address_id" value="'+data["id"]+'"  onclick="clickAddress(this)">'+
										'</div>'+
									'</div>'+
								'</li>'+
							
								'<li><span>所在地:'+province+city+district+'</span><br/><span>街道地址:'+data["address"]+'</span></li>'+
								'<li><span class="gouwuche_m02">'+data["postcode"]+'</span></li>'+
								'<li><span class="gouwuche_m02">'+data["consignee"]+'</span></li>'+
								'<li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;">'+data["phone"]+'</span></li>'+
								'<li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;">'+data["mobile"]+'</span></li>'+
							'</ul>'+
						'</div>';
				$('#addresslist').append(str);

				alert("新建收货地址成功！");
				$('#addaddress').hide();
			}
			else
			{
				alert("新建收货地址失败！");
			}
		});

	}
}


//-->
</script>
    <div class="gouwuche_box">
    	<div class="gouwuche_box_top">结算中心</div>
        <div class="gouwuche_box_top2">
        	<ul>
            	<li><a href="<?php echo site_url("cart");?>">1. 我的购物车</a></li>
                <li><span>></span></li>
                <li class="dingdan2_current"><a href="javascript:;">2. 核对订单信息</a></li>
                <li><span>></span></li>
                <li><a>3.成功提交订单</a></li>      
            </ul>
        </div>
		
        <div class="dingdan2_con">
            <div class="dingdan2_con01"><a href="javascript:new_address();">新建收货地址</a></div>
			<!--新增收货地址内容开始-->
			<form name="addressform" method="post" id="addressform">
            <div class="xinzeng_01" id="addaddress" style="display:none">
            	<p class="xinzeng_p">新增收货地址</p>
                <div class="gerenzhongxin_01_con clearfix xinzeng_con">
            	<div class="gerenzhongxin_01_con_left xinzeng_con_left">
                	<ul>    	
                        <li><span>*</span>收货人姓名：</li>
                        <li><span>*</span>所在地：</li>
                        <li><span>*</span>邮编：</li>
                        <li><span>*</span>收货地址：</li>
                        <li><span>*</span>手机号码：</li>
                        <li>固定电话：</li>
                    </ul>
                </div>
                
                <div class="gerenzhongxin_01_con_right">
                	<ul>
                    	<li>
							<input type="text" class="gerenzhongxin_01_con_input" id="consignee_addressName" name="consignee"  onblur="check_addressName()">
                        </li>
                        <li> 
							<?php 
							
							$data['province_selected'] ='';
							$data['city_selected'] = '';
							$data['district_selected'] = '';
							
							?>
							<?php $this->load->view('widget/district_select',$data); ?>
						</li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_postcode" onblur="check_postcode()" name="postcode"  value=""></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_address" name="address" onblur="check_address()" value=""></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_message" onblur="check_message()" name="mobile" 　value=""></li> 
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_phone"  onblur="check_phone()" name="phone"　value=""></li>
                    </ul>
                    <div class="gerenzhongxin_01_xiugai_btn"><a onclick="save_consignee(this);">保存</a></div>
                </div>
            </div>
            </div>
			</form>
            <!--新增收货地址内容结束-->
            <p>收货人信息</p>
			<div id="addresslist" class="clearfix">
			<div class="dingdan2_con02 clearfix">
				<?php
				$default_address = 0;
				foreach ($address as $k=>$v):?>
				
                	<ul class="clearfix">
                    	<li>
                            <div class="gouwuche_selectAll dingdan2_selectAll">
                                <div class="gouwuche_checkbox">
                                    <input type="radio"  name="address_id" value="<?php echo $v['id'];?>" <?php if($v['is_default']){ echo "checked"; $default_address = $v['id'];}?> onclick="clickAddress(this)">
                                </div>
                            </div>
                        </li>
                        <li> <span><?php echo '所在地:'.$v['address_for_name'];?></span><br/>
                            <span><?php echo '街道地址: '.$v['address'];?></span></li>
                        <li><span class="gouwuche_m02"><?php echo $v['postcode'];?></span></li>
                        <li><span class="gouwuche_m02"><?php echo $v['consignee'];?></span></li>
                        <li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;"><?php echo $v['phone'];?></span></li>
                        <li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;"><?php echo $v['mobile'];?></span></li>
                    </ul>
				
				<?php endforeach;?>
				</div>
			</div>
				
            <!--<p class="dingdan2_p">支付方式</p>
            <div class="dingdan2_con02">
                	<ul>
                    	<li>
                            <div class="gouwuche_selectAll dingdan2_selectAll">
                                <div class="gouwuche_checkbox">
                                    <input type="checkbox" value="true">
                                </div>
                            </div>
                        </li>
                        <li><span>现金支付</span></li>
                    </ul>
            </div>-->
			<form action="<?php echo site_url('order/save')?>" id="order_save" method="post" name="order_save">
			<input type="hidden" name="address_id" value="<?php echo $default_address?>"/>
            <div class="dingdan2_con03">
            	<div class="dingdan2_con03_top" style="margin-bottom:10px;">
                	<ul>
                        <li class="dingdan2_con03_li">商品信息</li>
                        <li>单价（货豆）</li>
                        <li>数量</li>
                        <li>小计（货豆）</li>
                    </ul>
                </div>
            
            <!--选择店铺全选店铺开始 结束-->
            <!--cart_border 开始-->
            <div class="cart_border cart_border-n">
            
            <?php  $total = 0; foreach($corp_product as $k => $val): ?>
            <input style="display:none"; value="0" name="discount" id='discount_<?php echo $val['corporation_id']?>'><!-- 记录优惠金额 -->
            <?php  $val['total_price'] = 0; ?>

            <!--店铺01 开始-->
            <!--选择店铺全选店铺开始 开始-->
            <span id="corp_<?php echo $val['corporation_id'];?>">
            <div class="cart_store1">
                <ul>
                    <li>
                        <span>店铺：<a><?php echo $val["corporation_name"];?></a></span>
                    </li>
                </ul>
            </div>
            <?php foreach( $val['product_info'] as $v):?>
                <?php 
                    
                    if( $v['is_on_sale'] ){
                        
                        $product_data[$v['id']]['id'] = $v['id'];
                        $product_data[$v['id']]['rowid'] = $v['rowid'];
                        $product_data[$v['id']]['qty'] = $v['qty'];
                        $product_data[$v['id']]['cid'] = $v['cid'];
                        $product_data[$v['id']]['special_price_start_at'] = $v['options']['special_price_start_at'];
                        $product_data[$v['id']]['special_price_end_at'] = $v['options']['special_price_end_at'];
                    }
                
                ?>
                
                    <div class="dingdan2_con03_con" style="border-bottom:none; border-top: 1px solid #ccc; <?php echo !$v['is_on_sale'] ? 'background-color:#EEE9E9;' : ''?>">
                        <ul>
                            <li class="dingdan2_con03_con_li">
                                <span class="gouwuche_mm01">
                                   <span class="gouwuche_mm01_img"><a href="<?php echo site_url('goods/detail/'.$v['id']);?>"><img src="<?php echo IMAGE_URL.$v['options']['goods_img'];?>" alt=""></a></span>
                                   <span class="gouwuche_mm01_font">
                                      <a href="<?php echo site_url('goods/detail/'.$v['id']);?>" target="_blank">
                                            <?php echo $v['name']; ?>
                                      </a>
                                      <p class="mm01_font1">
                                        <?php echo !$v['is_on_sale'] ? '(商品失效)' : ''?>
                                      
                                        <?php if(isset($v['sku_name']) && $v['sku_name']!=null): ?>
                                        
                                            <?php foreach ($v['sku_name'] as $sku_name): ?>
                                                  <span><?php echo $sku_name ?></span>
                                                  <!-- <span class="mm01_font2">容量：5</span>-->
                                            <?php endforeach; ?>
                                        <?php endif;?>
                                      </p>
                                   </span>
                               </span>
                            </li>
                            <li class="dingdan2_con03_juzhong" id="price"><?php echo $v['price'][0] =='.' ? '0'.number_format($v['price'], 2, '.', '') : number_format($v['price'], 2, '.', '');?>
                               <?php if( !empty($v['special_status']) ):?>
                                    <br/><span style="color:red">(特价活动结束,已恢复原价)</span>
                               <?php endif; ?>
                            </li>
                            <li class="dingdan2_con03_juzhong"><?php echo $v['qty']; ?><input type="hidden" name="quantity" value="<?php echo $v['qty']; ?>"></li>
                            <li class="dingdan2_con03_juzhong" style=" color:#ff0000;" ><?php echo number_format($v['price']*$v['qty'], 2, '.', ''); $val['total_price'] += $v['is_on_sale'] ? $v['price']*$v['qty'] : 0;?></li>
                    </ul>
                    </div>
                    <?php if($v['is_on_sale']){; ?>
                        <input style="display:none"; value="<?php echo $v['product_id'];?>" class="product_id"><!-- 记录商品id -->
                        <input style="display:none"; value="<?php echo $v['price']*$v['qty'];?>" ><!-- 数量x单价格 -->
                    <?php };?>
            <?php endforeach;?>
            
                <div class="liuyans">
                 <div class="liuyans-left">
                    <h5>备注留言：</h5>
                    <div class="liuyans-left-nei"> <textarea class="remark_<?php echo $k;?>" name="customer_remark" placeholder="输入您对卖家的留言"></textarea>
                         <p>为避免订单纠纷，备注填写前，请先和供货商商议</p>
                    </div>
                 </div>
                 <div class="liuyans-right" style="float:none; ">
                    <h6 style="min-height:55px; height:auto; line-height:auto; overflow:hidden"><span>配送方式：普通配送</span>
                    <div style="float:right;"><span>店铺优惠：</span>
                    <select  class="app_id select-coupon" onchange='use(this,<?php echo $k;?>)'>
                        <?php if(isset($val['package'])){;?>
                        <option value="0">未使用</option>
                        <?php foreach ($val['package'] as $v){;?>
				            <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
    			        <?php };?>
    			        <?php }else{;?>
    			            <option value="0">无</option>
    			        <?php };?>
    			    </select>
                    </div>
                    <br>
                    
<!--                     <div style="float:right;"><span>线上储值卡：</span>-->
<!--                     <select  class="app_id select-coupon" onchange='use(this,)'> -->
<!--                         <option value="0">无</option> -->
<!-- 				            <option value=""></option> -->
<!--     			            <option value="0">无</option> -->
<!--     			    </select> -->
<!--                     </div> -->
                    </h6>
                 </div>
                 
                 
                 
                 <div class="liuyans-ri">
                   <p>运费:<span> 0.00</span></p>
                   <p>店铺合计(含运费):<span><?php echo number_format($val['total_price'], 2, '.', ''); $total+=$val['total_price'];?></span></p>
                 </div>
                </div>
            
            <?php endforeach;?>
            
        </div>
        </span>
        <!--cart_border 结束-->
        <!--店铺01 结束-->
        
<!--         <div class="liuyans-right1"> -->
<!--                 <h6><span>易货优惠：</span> -->
<!--                 <select name="app_id" class="app_id"> -->
<!-- 					   <option value="1">全场满500减50货豆</option> -->
<!-- 					   <option value="0">全场满1000减100货豆</option> -->
<!-- 			    </select></h6> -->
<!--              </div> -->
        
        <!--备注结算 开始-->
        <div class="gouwuche_box_con_down dingdan2_down" style="overflow:hidden">    
            <!--添加备注 开始-->
            <!--<p class="cart_textaP">交易备注：（为避免订单纠纷，备注填写前，请先和供货商商议）</p>
            <textarea class="cart_texta" name="customer_remark"></textarea>-->
            <!--添加备注 结束-->
    
            <span class="gouwuche_d03">
                <p id="customer_name">收货人：无</p>
                <p id="mobile">联系手机：无</p>
                <p id="address_info">寄送至：无</p>
                <!--<p>总商品金额：<?php //echo number_format($total, 2, '.', '');?> 货豆</p>-->
                <!--<p><span>- 货豆：</span>    0</p>-->
                <!--<p>配送运费：<?php //echo $freight;?> 货豆</p>-->
                <p class="gouwuche_dd03 gouwuche_dd05" style="color:#ff0000;margin-top:20px;">实付款：<strong id="order_total"><?php echo number_format($total+$freight, 2, '.', '');?></strong> 货豆</p>
                <!--  <p class="gouwuche_dd03 gouwuche_dd05" style="color:#ff0000;margin-top:20px;"><strong id="order_total"></strong>储值卡货豆</p>-->
               <div style="line-height:73px;"> <a href="<?php echo site_url('Cart')?>" style=" color:#fea33b; margin-right:20px; text-decoration: underline">返回购物车</a><div class="gouwuche_dd04"><a href="javascript:submitOrder();" id="order_submit_status">提交订单</a></div></div>
            </span>
        </div>
        <!--备注结算 结束-->
          <div class="jiageb">若价格变动，请在提交订单后联系卖家改价，并查看已买到的宝贝</div>
        </div>
		</form>
		</div>
		</div>
        
		  <div class="gouwuche_box_con">   
          </div>
            
        </div>
        
    </div>
    
   
    
    <!--通用操作 弹窗start-->
    <div class="dingdan4_3_tanchuang" style="display:none" id="teshi">
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">温馨提示</div>
          <div class="dingdan4_3_tanchuang_top2">
              <p id='prompt'></p>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
              <div class="dingdan4_3_btn02"><a href="javascript:sure();" >确定</a></div>  
                 
          </div>
      </div>
    </div>
    <!--通用操作 弹窗end-->
    
     <!--新增支付流程－输入支付密码－弹窗 开始--><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang"  hidden id='pay_view'>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">支付确认</div>
          <div class="dingdan4_3_tanchuang_top2">
              <ul class="payNum_ul">
              	<li><span>订单金额：</span><span id ="all_order_price"></span></li>
              	<li id="M_pay_parice"><span>货豆支付：</span></li>
                <li><span>支付密码：</span><span><input type="password" placeholder="请输入支付密码" name="pay_password" class="payNum_input"></span><a href="<?php echo site_url('member/save_set/paypwd_set/forgetpay')?>" class="payNum_forget">忘记密码？</a></li>
                <li hidden id='pass_message'><span class="payNum_tips"></span></li>
              </ul>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc; "><a href="javascript:;" onclick="cancel_pay()">取消支付</a></div>
              <div class="dingdan4_3_btn02"><a href="javascript:;" id='pay_' onclick="all_order_pay()">确认支付</a></div>
          </div>
          
      </div>
	</div>
	 <!--新增支付流程－输入支付密码－弹窗 结束--><!--默认隐藏-->
     <script>

     
        var product_data = new Array();
        product_data = jQuery.parseJSON('<?php echo !empty($product_data) ?  json_encode($product_data) : ''?>');//订单信息
    
    //特价恢复原价确定继续购买
    function sure(){
    	submitOrder('',1);
    	
    }
    function cancel_pay()
    {
   	 
       	if(confirm("确定要取消支付吗？"))
    	{
       		location.href= base_url+"/Member/order";
    	} 
    }
    //隐藏弹窗
    function hiding(){
    	$("#prompt").text("");
    	$("#teshi").hide();
    }

    function all_order_pay(  ){
    	 
        
        var pass = $('input[name=pay_password]').val();
        
        if(!pass)
        {
            $('#pass_message').show().find('span').text('支付密码不能为空！');
            return; 
        }
        if( !order_data )
        {
            alert('支付失败'); 
            return;
        }
        
        $.ajax({ 
            url:base_url+'/order/All_order_pay',
            data:{'order':order_data,'pass':pass},
            type:'post',
            dataType:'json',
            success:function(data)
            { 
            	switch (data.status){
            	
    				case 'success'://成功
    					alert('支付成功');
    					location.href = base_url+'/Member/order/';
    					break;
    				case 'fail'://订单生成失败执行
    					alert('支付失败');
    					break;
    				case 'wrong'://密码错误
    					 $('#pass_message').show().find('span').text('支付密码错误,请重新输入！');
    					break;
    				case 'no_money':
    					if(confirm("余额不足无法支付，立即去充值？"))
    			    	{
    			       		location.href= base_url+"/Member/property/get_list";
    			    	}
    					break;
    				default://未知问题执行
    					alert('支付失败');
    					break;
				}    
            },
            error:function(){
            	alert('支付失败');
    	    }
            
        })
    }


    //选择优惠券，运算
    function use(obj,corp_id){
    	var order_total = "<?php echo $total+$freight;?>";//订单总额（优惠前）
    	var package_id = $(obj).val();//卡包id
    	var discount_price = 0;//店铺优惠的金额
        var discount_price_total = 0;//订单优惠总金额
    	//判断是否使用优惠券
    	if(package_id != 0){
        	
 		    //查询卡包相关商品
 		    $.post("<?php echo site_url('order/discount_goods');?>",{package_id:package_id},function(data){
                if(data.length>0){
                    for(var i=0;i<data.length;i++){
                        $("#corp_"+corp_id+" .product_id").each(function(k,v){

                            if(data[i]['id'] == $(this).val()){
                                if(data[i]['discount_type']==1){//打折
                                   p_price = $(this).next().val();//商品总价（单价*数量）
                             	   discount_price += Number(p_price* (10-data[i]['discount'])/10);//优惠金额
                                }else{//满减
                             	   discount_price = data[i]['deduction_price'];//优惠金额
                                }
                            }
                            
                         });
                    }
                    
                    $("#discount_"+corp_id).val(discount_price);//记录每家店铺优惠金额
                    //获取订单优惠总金额
                    $("input[name=discount]").each(function(){
                    	discount_price_total += Number($(this).val());
                     });
                    order_total = Number(order_total - discount_price_total);
                    $("#order_total").text(order_total.toFixed(2) );//订单总额（优惠后）
                    
                }else{//找不到相关商品
                	window.location.reload();
                	return;
                }
 		    },"json");
 		    
        }else{//不使用优惠券
        	$("#discount_"+corp_id).val(0);
            
            //获取订单优惠总金额
            $("input[name=discount]").each(function(){
            	discount_price_total += Number($(this).val());
             });
            order_total = Number(order_total - discount_price_total);
            $("#order_total").text(order_total.toFixed(2) );//订单总额（优惠后）

        }

    }
    </script>



  
