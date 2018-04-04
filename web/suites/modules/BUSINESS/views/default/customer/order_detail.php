    

    <div class="Box member_Box clearfix">
        <div class="kehu_Left">
        	<ul class="kehu_Left_ul">
            	<li class="kehu_title"><a>个人中心</a></li>
                <li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
                <li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
                <!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
                <li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
                <li><a href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>订单中心 </a></li>
                <li  class="kehu_current"><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
                <li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
                <li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户中心</a></li>
                <li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
                <li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
                <!--<li><a href="#">分红结算</a></li>-->
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户服务</a></li>
            	<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
                <li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
                <!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
                <!--<li><a href="#">在线客服</a></li>-->
                <!--<li><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
            </ul>
            <ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		    </ul>
        </div>

		<div class="huankuan_cmRight clearfix">
        	<div class="huankuan_rTop">我的订单</div>
            <div class="huankuan_rCon01">
            	<ul>
                	<li><a href="<?php echo site_url('member/info')?>">我的易货</a></li>
                    <li><span>></span></li>
                    <li><a href="<?php echo site_url('member/order') ?>">订单中心</a></li>
                    <li><span>></span></li>
                    <li class="huankuan_rCon01_current"><a href="javascript:void(0)">订单详细</a></li>
                </ul>
            </div>
            <!--内容-->
            
            <div class="dingdanxiangqing_01_con01">
                <p class="dingdanxiangqing_01_con01_p01">订单号：<?php echo $order['order_sn']?>    状态：<strong id='status_name'>
                                            <?php 
                                                switch ($order['status']) {
												case 1 :echo '商家未确认';break;
												case 2 :echo '商家已确认';break;
												case 3 :echo '确认客户付款';break;//微信或支付宝支付返回收款，暂时用不到
												case 4 :echo '已支付';break;
												case 5 :echo '货到付款';break;//暂时用不到
												case 6 :echo '已发货';break;
												case 7 :echo '订单完成';break;
												case 8 :echo '收货并付款';break;//暂时用不到
												case 9 :echo '订单完成';break;
												case 10 :echo '已取消';break;
												case 11 :echo '已退款';break;
												case 12 :echo '已退货';break;
												case 13 :echo '已存货';break;
												case 14 :echo '订单完成';break;
												case 15 :echo '未成团'; break; // 团购状态
												case 16 :echo '拼团订单失效';break; // 团购状态
											}?></strong>。</p>
                <p id="message_name">
                <?php 
                $message = '';
                switch ($order['status']) {
                    case 1 :echo '';break;
                    case 2 :echo '';break;
                    case 3 :echo '';break;
                    case 4 :echo '';break;
                    case 5 :echo '';break;
                    case 6 :echo '';break;
//                     case 7 :echo '订单已经完成，感谢您在51易货网购物，欢迎您对本次交易及所购商品。<a href="'.site_url('member/my_comment/product_comment/'.$order['id'].'/details').'" class="dingdanxiangqing_01_con01_a">'.$message.'</a>';break;
                    case 8 :echo '';break;
//                     case 9 :echo '订单已经完成，感谢您在51易货网购物，欢迎您对本次交易及所购商品。<a href="'.site_url('member/my_comment/product_comment/'.$order['id'].'/details').'" class="dingdanxiangqing_01_con01_a">'.$message.' </a>';break;
                    case 10 :echo '';break;
                    case 11 :echo '';break;
                    case 12 :echo '';break;
                    case 13 :echo '';break;
//                     case 14 :echo '订单已经完成，感谢您在51易货网购物，欢迎您对本次交易及所购商品。<a href="'.site_url('member/my_comment/product_comment/'.$order['id'].'/details').'" class="dingdanxiangqing_01_con01_a">'.$message.' </a>';break;
                   
                 }?>
                
                </p>
            </div>
            <div class="dingdanxiangqing_02_con02 clearfix">
            	<h4>付款信息</h4>
                <div class="dingdanxiangqing_02_con02_1 dingdanxiangqing_01_con01_p02">
                <p>付款方式：<?php echo $order['pay_name']?>   </p>

                <?php //foreach ($order_items as $k=>$v):?>
                <p>
                    <span>总商品金额：<?php echo isset($order['total_price'])?$order['total_price']:''//$v['price']?>货豆</span>
                    <span>应支付金额：<?php echo isset($order['total_price'])?$order['total_price']:''//$v['price']* $v['quantity']?>货豆</span>
                    <span><!-- 货豆：0--></span>
                    <span>运费金额：<?php echo $order['actual_freight_fee']?$order['actual_freight_fee']:'0.00'; ?>货豆</span>
                </p>
                <?php //endforeach;?>	
                	
                </div>
            
            </div>
            
            <div class="dingdanxiangqing_02_con02 clearfix">
                <div class="dingdanxiangqing_02_con02_top">
                    <h4>订单信息</h4>
                    <div class="dingdanxiangqing_02_con02_1">
                        <h5>收货人信息</h5>
                        <p>收 货 人：<?php echo isset($order_delivery['consignee']) ? $order_delivery['consignee'] :''?></p>
                        <p>地    址：<?php echo isset($order_delivery["province"]) ? $order_delivery["province"] : '';?> <?php echo isset($order_delivery["city"]) ? $order_delivery["city"] :'';?> <?php echo isset($order_delivery["district"]) ? $order_delivery["district"] : '';?> <?php echo isset($order_delivery['address']) ? $order_delivery['address'] :''?> </p>
                        <p>手机号码：<?php echo isset($order_delivery['contact_mobile']) ? $order_delivery['contact_mobile'] :''?></p>
                    </div>
                 
                </div>
                <!---->
                    <!--<div class="dingdanxiangqing_02_con02_1">
                        <h5>支付及配送方式</h5>
                        <p>支付方式：</p>
                        <p>运    费：</p>
                        <p>配    送：</p>
                        <p>快递订单号：</p>
                    </div>
                    <div class="dingdanxiangqing_02_con02_1">
                        <h5>发票信息</h5>
                        <p>发票类型：</p>
                        <p>发票抬头：</p>
                        <p>发票内容：</p>
                    </div>-->
               
                
            </div>
            <!---->
            <div class="dingdanzhongxin_01_shouhuo_con">
              <div class="shoushuo_con01">
               	<p>商品清单</p>
                <div class="shouhuo_con01_1">
                    	<ul>
                        	<li style="width:130px">商品编号</li>
                            <li style="width:130px">商品图片</li>
                            <li style="width:300px">商品名称</li>
                            <li>价格</li>
                            <li>商品规格</li>
                            <li>商品数量</li>
                            <li style="border-right:0">操作</li>
                        </ul>
               </div>
               <?php  foreach ($order_items as $k=>$v): ?>
                    <div class="shouhuo_con01_1 shouhuo_con01_2">
                    	<ul>
                        	<li style="width:130px"><?php echo isset($v['productnum'])&&$v['productnum']!=null?$v['productnum']:'';?></li>
                            <li style="width:130px"><img src=<?php echo isset($v['goods_thumb'])&&$v['goods_thumb']!=null?IMAGE_URL.$v['goods_thumb']:"images/shouhuo_shili.jpg" ?> width="67"  alt=""/ style="margin-top:10px;"></li>
                            <li style="width:300px"><a href="<?php echo site_url('goods/detail/'.$v['product_id'])?>"><p>
                            <?php echo isset($v['product_name'])&&$v['product_name']?$v['product_name']:''?></p></a>
                            </li>
                            <li>M<?php echo isset($v['price'])&&$v['price']!=null?$v['price']:''?></li>
                            <li>
                            <p class="mm01_font1" style="margin-top:0px;">
                            <?php if(isset($v['sku_name'])&&$v['sku_name']!=null): ?>
                            <?php foreach($v['sku_name'] as $sku_name): ?>
                                  <span><?php echo $sku_name ?></span><br/>
                                  <!-- <span class="mm01_font2">容量：5</span>-->
                            <?php endforeach; ?>
                            <?php endif;?>
                            </p>
                            </li>
                            <li><?php echo isset($v['quantity'])&&$v['quantity']!=null?$v['quantity']:''?></li>
                            <li style="border-right:0; line-height:30px;">
                            	<!-- <a href="#" style="color:#fea33b; text-decoration:underline">评价</a><br>
                                <a href="#" style="color:#fea33b; text-decoration:underline">退换货</a>  -->
                            </li>
                        </ul> 
                  </div>
                 <?php endforeach; ?>
                  <div class="xiangqing_01_con03">
                  <!--添加备注 开始-->
                  <p class="cart_textaP" style="margin:0;">交易备注：（为避免订单纠纷，备注填写前，请先和供货商商议）</p>
                  <textarea class="cart_texta" style="margin-left:0; width:650px;"><?php echo $order['customer_remark']?></textarea>
                  <!--添加备注 结束-->
                  <div class="xiangqing_01_con03_ul">
                  	<ul>
                    	<li>总商品金额：</li>
                        <li><!-- 货豆：--></li>
                        <li>+ 运费： </li>
                    </ul>
                    <ul>
                    	<li><?php echo $order['total_product_price']?>货豆</li>
                        <li></li>
                        <li> <?php echo $order['auto_freight_fee']?$order['auto_freight_fee']:'0.00'; ?>货豆</li>
                    </ul><br><br>
                    <?php if(in_array($order['status'],array(1,2,10,11,12))):?>
                    <p class="xiangqing_01_con03_p" id="yingzhifu" >应付总额：<span style="margin-left: 15px;"><?php echo $order['total_price'] ?>货豆</span></p>
                    <?php else: ?>
                    <p class="xiangqing_01_con03_p">已支付</p>
                    <?php endif;?>
                    <p class="xiangqing_01_con03_p" >手续费(现金)：<?php echo $order['commission'] .'元'?></p>
                        <div class="dingdanzhongxin_01_con02_down" id="pay_submit">
                   <?php if(in_array($order['status'],array(2))):?>
                            	<a href="<?php echo site_url('Member/order/order_pay/'.$order['id'])?>"  class="dingdanzhongxin_01_con02_down_btn">立即付款</a>
                    <?php endif;?>
                    <?php if(in_array($order['status'],array(1,2))):?>
                            	<a href="javascript:;" onclick="cancel(<?php echo $order['id']?>)" class="dingdanzhongxin_01_con02_down_btn">取消订单</a>
                    <?php endif;?>
                    <?php if(in_array($order['status'],array(6))):?>
                            	<a href="javascript:;" onclick="receive(<?php echo $order['id']?>)" class="dingdanzhongxin_01_con02_down_btn">确认收货</a>
                    <?php endif;?>
                        </div>
                  
                   </div>
                  </div>
                  <?php if($order['status'] == 1):?>
                      <button onclick="up_remark(<?php echo $order['id']?>)" id="remark">修改备注</button>
                  <?php endif;?>
              </div>
            </div>

      </div>



    </div>

    
    	 <!--弹窗开始-->
     	<!--弹窗--><!--
<div class="dingdan4_3_tanchuang" style="display:block">
    <div class="dingdan4_3_tanchuang_con shouhuo_tanchuang_con">
        <div class="dingdan4_3_tanchuang_top2 shouhuo_tanchuang_top2">
            <p>点击确定后,您之前付款到易货网的 3000.00 元将直接到商家的帐户里,请务必收到货再确认!</p>
        </div>
        <div class="dingdan4_3_tanchuang_btn">
        	<div class="dingdan4_3_btn01 shouhuo_quxiao_btn"><a href="#">取消</a></div>
            <div class="dingdan4_3_btn02"><a href="#">确定</a></div>
        </div>
        
    </div>
</div>-->
     <!--弹窗结束-->
     

    
     <!--收货－输入支付密码－-><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang" hidden id='dingdan4_3_tanchuang_1'>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">收货确认</div>
          <div class="dingdan4_3_tanchuang_top2">
              <ul class="payNum_ul">
              	<li><span class="pay_left">支付密码：</span><span><input type="password" placeholder="请输入支付密码" name="pay_password_1" class="payNum_input" value=""></span><a href="<?php echo site_url('member/save_set/paypwd_set/forgetpay')?>" class="payNum_forget">忘记密码？</a></li>
                <li hidden id='pass_message_1'><span class="payNum_tips">*密码错误，请重新输入</span></li>
              </ul>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc; "><a href="javascript:;" onclick="$('.dingdan4_3_tanchuang').hide()">取消支付</a></div>
              <div class="dingdan4_3_btn02"><a href="javascript:;" onclick="ok_receive()" id="shouhuo">确认收货</a></div>
          </div>
          
      </div>
	</div>
    <!--新增支付流程－输入支付密码－弹窗 结束-->
    
     <!--验证支付密码是否存在－-><!--默认隐藏-->

    <!--弹窗 结束-->
    
    <script>
    function up_remark( id ){
        
        var remark = $('textarea').val();
        $.ajax({ 
           url:'<?php echo site_url('order/update_remark')?>',
           data:{id:id, remark:remark},
           dataType:'json',
           type:'post',
           success:function(data){
        	   switch(data){ 
               case 1:
                   alert('修改成功');
               break;
               case 2:
            	   alert('订单错误或商家已经接单无法修改');
               break;
               case 3:
            	   alert('未更新内容');
               break;
               default:
                   alert('修改失败');
               break;
              
               }
           }
        })
    }

    function carry_out( id, url ){ 
        $.ajax({ 
            url:url,
            type:'post',
            data:{id:id},
            dataType:'json',
            success:function(data){ 
                if(data.is_ok){
                    if(data.status == 10){
                        $('#pay_submit').remove();
                        $('#status_name').text('已取消');
                        $('#remark').remove();
                     }
              	  
                }else{ 
                   alert('操作失败');
                }
            
            },
    
        })
    }

    //收货
    function receive(id)
    { 
    	$('#pass_message_1').hide();
        $('#shouhuo').attr('onclick','ok_receive("'+id+'")');
        $('input[name=pay_password_1]').val('');
   	    $('#dingdan4_3_tanchuang_1').show();
    }

    //取消订单
    function cancel(id){ 
    	url = "<?php echo site_url('order/cancel_order')?>"
    	carry_out(id,url)
       
    }

    function ok_receive( id ){
        
        var pass = $('input[name=pay_password_1]').val();
       
        var comment = "<?php echo site_url('member/my_comment/product_comment').'/'?>"
        $.ajax({ 
           url:'<?php  echo site_url('order/receive')?>',
           data:{pass:pass,id:id},
           dataType:'json',
           type:'post',
           success:function(data){
              if(data == 1){ 
                  alert('成功收货');
            	  $('#pay_submit').remove();
                  $('#status_name').text('订单完成');
                  $('#dingdan4_3_tanchuang_1').hide();
                  $('#message_name').append('订单已经完成，感谢您在51易货网购物，欢迎您对本次交易及所购商品。<a href="'+comment+id+'/details" class="dingdanxiangqing_01_con01_a">进行评价 </a>');
              }else if(data == 3){ 
            	  $('#pass_message_1').show();
              }else if(data == 2){ 
                  alert('错误订单');
              }else{ 
            	  alert('收货失败');
              }
           }
        })
    }
    </script>


