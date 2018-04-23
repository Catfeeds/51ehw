<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link href="css/theme/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/theme/style.css" rel="stylesheet" type="text/css">
<link href="css/theme/style_v2.css" rel="stylesheet" type="text/css">
<title>51易货网</title>
</head>

<body>


    <div class="top2 manage_fenlei_top2">
    	<ul>
        	<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li  class="tCurrent"><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <div class="Box manage_new_Box clearfix">
    	<div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">订单管理</div>
            <div class="cmLeft_down">
            	<ul>
                    <li><a href="<?php echo site_url('corporate/order/get_list')?>">全部订单(<?php echo $totalcount;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/wait');?>">等待付款(<?php echo $status_1 + $status_2;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/wait_dispatch');?>">等待发货(<?php echo $status_3 + $status_4 + $status_5;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/dispatch');?>">已发货(<?php echo $status_6;?>)</a></li>
                    
                    <li><a href="<?php echo site_url('corporate/order/get_list/cancel');?>">已取消(<?php echo $status_10;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/refund');?>">已退款(<?php echo $status_11;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/return');?>">已退货(<?php echo $status_12;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/return');?>">交易成功(<?php echo $status_9 + $status_13;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/shut');?>">交易关闭(<?php echo $status_10 + $status_11 + $status_12;?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/order/get_list/receive');?>">待提取提货权(<?php echo $status_7?>)</a></li>
                </ul>
                
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">订单详情 <span class="daochu"><a href="<?php echo site_url('corporate/order/get_list');?>">返回</a></span></div>
            <?php if(isset($details) && count($details) > 0):?>
            <!--<div class="dingdan_kehuguanli_top">
                
            	 <!--<div class="search_2 manage_fenlei_search_2">
               	<div><input type="text" class="search2_con manage_fenlei_search2_con"></div>
                    <div class="search2_btn manage_fenlei_search2_btn"><a href="#">店内搜索</a></div>
               </div>--> 
                
              
                
              <!-- </div>
            <!---->
            
            <div class="gouwuche_box_top2 dingdanxiangqing_top2">
                <ul>
                    <li <?php if ($details['status'] == 1 || $details['status'] == 2) echo 'class="dingdan2_current"';?>>
                        <a >1. 买家下单</a>
                    </li>
                    <li><span>></span></li>
                    <li <?php if ($details['status'] == 3 || $details['status'] == 4 || $details['status'] == 5) echo 'class="dingdan2_current"';?>>
                        <a >2. 买家付款</a>
                    </li>
                    <li><span>></span></li>
                    <li <?php if ($details['status'] == 6) echo 'class="dingdan2_current"';?>>
                        <a >3. 发货</a>
                    </li>
                    <li><span>></span></li>
                    <li <?php if ($details['status'] == 7 || $details['status'] == 8 || $details['status'] == 9 || $details['status'] == 13 ) echo 'class="dingdan2_current"';?>>
                        <a >4.买家确认收货</a>
                    </li>      
                </ul>
        	</div>
            
            
            <?php if ($details['status'] == 4 && $details['g_status'] != '' ):?>
                 <?php if ( $details['g_status'] == 1 ):?>
                    <div class="dingdanxiangqing_top3">
                    	<p>当前订单状态：买家已付款，等待卖家发货。</p>
                      	<div class="dingdanxiangqing_btn clearfix">
                        	<ul>
                            	<li><a class="dingdanxiangqing_btn01" href="javascript:;" onclick="dispatch(<?php echo $details['id']?>)">发货</a></li>
                            </ul>
                        </div>
                    </div>
                <?php endif;?>
            <?php elseif($details['status'] == 4):?>
                <div class="dingdanxiangqing_top3">
                	<p>当前订单状态：买家已付款，等待卖家发货。</p>
                  	<div class="dingdanxiangqing_btn clearfix">
                    	<ul>
                        	<li><a class="dingdanxiangqing_btn01" href="javascript:;" onclick="dispatch(<?php echo $details['id']?>)">发货</a></li>
                        </ul>
                    </div>
                 </div>
            <?php endif;?>    
    
            <div class="dingdan2_con">
            <div class="dingdanxiangqing_con1">
            <h4>收货人信息</h4>
            <div class="dingdanxiangqing_con clearfix">
            	<!--<div class="dingdanxiangqing_width_left">
                	<ul>
                    	<li>订单号:</li>
                        <li>支付方式:</li>
                        <li>创建时间:</li>
                        <li>付款时间:</li>
                        <li>发货时间:</li>
                    </ul>
            	</div>-->
                <div class="dingdanxiangqing_width_right">
                	<ul>
                    	<li> <span class="dingdanxiangqing_width_right_zuo">订单号:</span><span class="dingdanxiangqing_width_right_zuo1"><?php echo $details['order_sn'];?></span></li>
                        <li> <span class="dingdanxiangqing_width_right_zuo">支付方式:</span><span class="dingdanxiangqing_width_right_zuo1"><?php echo !empty($details['pay_name']) ? $details['pay_name'] : '暂无';?></span></li>
                        <li>  <span class="dingdanxiangqing_width_right_zuo">创建时间:</span><span class="dingdanxiangqing_width_right_zuo1"><?php echo $details['place_at'];?></span></li>
                        <li> <span class="dingdanxiangqing_width_right_zuo">付款时间:</span><span class="dingdanxiangqing_width_right_zuo1"><?php echo $details['pay_time']?$details['pay_time']:"暂无";?></span></li>
                        <li> <span class="dingdanxiangqing_width_right_zuo">发货时间:</span><span class="dingdanxiangqing_width_right_zuo1">暂无</span></li>
                    </ul>
            	</div>
            </div>
            </div>
            
            <div class="dingdanxiangqing_con2">
            <h4>收货和物流信息</h4>
            <div class="dingdanxiangqing_con clearfix">
            	<!--<div class="dingdanxiangqing_width_left">
                	<ul>
                    	<li>收货地址:</li>
                        <li>运送方式:</li>
                        <li>物流公司名称:</li>
                        <li>物流单号:</li>
                    </ul>
            	</div>-->
                <div class="dingdanxiangqing_width_right">
                	<ul>
                    	<li>
                        <span class="dingdanxiangqing_width_right_zuo">收货地址:</span>
                        <span class="dingdanxiangqing_width_right_zuo1">
                    	<?php if(isset($order_delivery ) && count($order_delivery) > 0){;?>
                    	   <?php echo $order_delivery['consignee']?> <?php echo $order_delivery['contact_mobile']?>  <?php echo $order_delivery["province"];?> <?php echo $order_delivery["city"];?> <?php echo $order_delivery["district"];?> <?php echo $order_delivery['address']?> </span></li>
                        <?php }else{;?>
                         <li>暂无</li>
                        <?php };?>
<!--                         <li> <span class="dingdanxiangqing_width_right_zuo">运送方式:</span> <span class="dingdanxiangqing_width_right_zuo1">暂无</span></li> -->
<!--                         <li> <span class="dingdanxiangqing_width_right_zuo">物流公司名称:</span> <span class="dingdanxiangqing_width_right_zuo1">天天快递</span></li> -->
<!--                         <li> <span class="dingdanxiangqing_width_right_zuo">物流单号:</span> <span class="dingdanxiangqing_width_right_zuo1">3483483478</span></li> -->
                    </ul>
            	</div>
            </div>
            </div>
            
            <div class="dingdanxiangqing_con2">
            	<h4>商品信息</h4>
                <div class="dingdanxiangqing_con3">
                <ul>
                	<li class="dingdanxiangqing_con3_span"><span>商品信息</span></li>
                    <li><span>数量</span></li> 
                    
                    <li><span>单价</span></li>
                </ul>
                	
                </div>
                
                <?php if(isset($order_items) && count($order_items) > 0):?>
                    <?php foreach ($order_items as $v):?>
                        <div class="dingdan2_con03_con dingdanxiangqing_con3_li">
                        	<ul>
                                <li class="dingdanxiangqing_con3_margin">
                                    <span class="gouwuche_mm01">
                                       <img src=<?php echo isset($v['goods_thumb'])&&$v['goods_thumb']!=null? IMAGE_URL.$v['goods_thumb']:"images/shouhuo_shili.jpg" ?> width="67"  alt=""/ style="margin-top:10px;">
                                       <span class="gouwuche_mm01_font">
                                          <a><?php echo $v['product_name']?></a>
                                          <p class="mm01_font1">
                                          <?php foreach ( explode(',',$v['sku_value']) as $val):?>
                                          <span><?php echo $val?></span>
                                          <?php endforeach;?>
                                         </p>
                                       </span>
                                   </span>
                           		</li>
                                <li class="dingdanxiangqing_con3_juzhong"><span><?php echo $v['quantity']?></span></li>
                                <li class="dingdanxiangqing_con4"><span style="margin-left:17px;">
                                <?php if($details['status'] == 1 || $details['status'] == 2):?>
                                    <input type="text" value="<?php echo $v['price']?>" id="goods_<?php echo $v['id']?>"><span class="queding"  onclick="up_price(<?php echo $details['id']?>,<?php echo $v['id']?>)">确定</span>
                                <?php else:
                                    echo $v['price'];
                                ;?>
                                </span></li>
                                <?php endif;?>
                            </ul>
                        </div>
                    <?php endforeach;?>
                <?php endif?>
                
            </div>
            <?php if($details['status'] == 1 || $details['status'] == 2):?>
              <div class="dingdanxiangqing_con4">
              <div><span>运费合计：</span><input class="" type="text" name="auto_freight_fee" value="<?php echo $details['auto_freight_fee']?>" onkeyup="value=value.replace(/[^\-?\d.]/g,'')"><span class="queding" onclick="up_freight(<?php echo $details['id']?>)">确定</span></div>
              </div>
            <?php endif;?>
            <div class="dingdanxiangqing_con2">
            
            <div class="gouwuche_box_con_down dingdan2_down dingdanxiangqing_width">
            	<!--添加备注 开始-->
                <p class="cart_textaP" style="text-align:left; margin-left:30px;">交易备注：（为避免订单纠纷，备注填写前，请先和供货商商议）</p>
                <textarea class="cart_texta" style="margin-left:0; width:650px;"><?php echo $details['customer_remark']?></textarea>
                <!--添加备注 结束-->
                <span class="gouwuche_d03">
                    <p>总商品金额：<?php echo $details['total_product_price']?></p>
                    <p>+ 运费：<?php echo $details['auto_freight_fee']?></p><br>
                    <?php if($details['status'] >3 && $details['status'] <=9 || $details['status'] == 14):?>
                        <p class="gouwuche_dd03">实际支付：<?php echo $details['total_price']?></p>
                    <?php endif;?>
                    
                    <?php if ( ($details['status'] == 3 || $details['status'] == 4 || $details['status'] == 5) && $details['g_status'] != '' ):?>
                         <?php if ( $details['g_status'] == 1 ):?>
                             <div class="gouwuche_dd04"><a href="javascript:;" onclick="dispatch(<?php echo $details['id']?>)">发货</a></div>
                        <?php endif;?>
                    <?php elseif($details['status'] == 3 || $details['status'] == 4 || $details['status'] == 5):?>
                              <div class="gouwuche_dd04"><a href="javascript:;" onclick="dispatch(<?php echo $details['id']?>)">发货</a></div>
                    <?php endif;?>                       
                     
                     <?php if (in_array($details['status'],array(1))):?>
                     <div class="dingdanzhongxin_01_con02_down" style="background: none"; id="dingdanzhongxin_01_con02_down">
                         <a href="javascript:;" onclick="receive(<?php echo $details['id']?>)" class="dingdanzhongxin_01_con02_down_btn">确认接单</a>
                         <a href="javascript:;" onclick="cancel(<?php echo $details['id']?>)" class="dingdanzhongxin_01_con02_down_btn">取消订单</a>
                     </div>
                     <?php endif;?>
                     
                </span>
                
            </div>
            </div>
        </div>
    
    <?php endif;?>
    </div><!--cmRight-->
    </div><!--Box-->

 
</body>

<script type="text/javascript">
function dispatch( id ){
    url = "<?php echo site_url('corporate/order/update_status_dispatch')?>"
   	sub_incident(id,url);
  
}

function sub_incident(id, url){ 
    $.ajax({ 
        url:url,
        type:'post',
        data:{id:id},
        dataType:'json',
        success:function(data){  
            if(data.is_ok){
                if(data.status == 6){
                   	$('.dingdanxiangqing_top3').remove();
             	    $('.gouwuche_dd04').remove();
             	    $('.dingdanxiangqing_top2 ul li').eq(4).attr('class','dingdan2_current');
             	    $('.dingdanxiangqing_top2 ul li').eq(2).attr('class','');
                }

                if(data.status == 2){ 
               	     $('#dingdanzhongxin_01_con02_down').remove();
                }
                if(data.status == 10){ 
                     $('#dingdanzhongxin_01_con02_down').remove();
               	     $('.dingdanxiangqing_top2 ul li').eq(0).attr('class','');
                }
            }else{ 
                if(!data.role_status){
                    alert("对不起，你暂时还没有权限！");return;
                }
                alert('操作失败');
            }
          
        },

    })
}

function up_price(o_id,id){ 
    var price = $('#goods_'+id).val();
     $.ajax({ 
	        url:"<?php echo site_url('corporate/order/up_product_price')?>",
	        type:'post',
	        data:{id:id,o_id:o_id,price:price},
	        dataType:'json',
	        success:function(data){ 
		        if(data.role_status){
			        alert("对不起，你暂时还没有权限！");return;
			    }
			    
	            if(data){
	             $('.gouwuche_d03 p').eq(0).text('总商品金额： '+data.total_price);
	            }else{ 
	                alert('操作失败');
	            }
	          
	        },

	    })
}

function up_freight(o_id){ 
	var freight = $('input[name=auto_freight_fee]').val();
	
    $.ajax({ 
	        url:"<?php echo site_url('corporate/order/update_order_freight')?>",
	        type:'post',
	        data:{o_id:o_id,freight:freight},
	        dataType:'json',
	        success:function(data){ 
		        if(data.role_status){
			        alert("对不起，你暂时还没有权限！");return;
			    }
	            if(data){
	            	if(freight.indexOf(".") > 0 )
                	{
	                	$('.gouwuche_d03 p').eq(1).text('+ 运费：'+freight);
                	}else{
                		$('.gouwuche_d03 p').eq(1).text('+ 运费：'+freight+'.00');
                	}
	             
	            }else{ 
	                alert('修改失败');
	            }
	          
	        },

	    })
}
function receive(id){ 
	 url = "<?php echo site_url('corporate/order/update_status_receive')?>"
     sub_incident(id,url);
}

function cancel(id){
	url = "<?php echo site_url('corporate/order/cancel_order')?>"
	sub_incident(id,url);
	
}
</script>
</html>
    