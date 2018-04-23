<div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
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

            <div class="downTittle manage_new_downTittle menu_manage_downTittle" >订单管理</div>
            <div class="cmLeft_down">
            	<ul>
                    <li <?php if( !$order_state) echo'class="houtai_zijin_current"';?> >
                        <a href="<?php echo site_url('corporate/order/get_list');?>">全部订单(<?php echo $totalcount;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'wait') echo'class="houtai_zijin_current"';?>>
                        <a href="<?php echo site_url('corporate/order/get_list/wait');?>">等待付款(<?php echo $status_1 + $status_2;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'wait_dispatch') echo'class="houtai_zijin_current"';?>>
                         <a href="<?php echo site_url('corporate/order/get_list/wait_dispatch');?>">等待发货(<?php echo $status_3 + $status_4 + $status_5;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'dispatch') echo'class="houtai_zijin_current"';?>>
                        <a href="<?php echo site_url('corporate/order/get_list/dispatch');?>">已发货(<?php echo $status_6;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'cancel') echo'class="houtai_zijin_current"';?>>
                        <a href="<?php echo site_url('corporate/order/get_list/cancel');?>">已取消(<?php echo $status_10;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'refund') echo'class="houtai_zijin_current"';?>>
                        <a href="<?php echo site_url('corporate/order/get_list/refund');?>">已退款(<?php echo $status_11;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'return') echo'class="houtai_zijin_current"';?>>
                        <a href="<?php echo site_url('corporate/order/get_list/return');?>">已退货(<?php echo $status_12;?>)</a>
                    </li>
                    <li <?php if( $order_state == 'accomplish') echo'class="houtai_zijin_current"';?>>
                         <a href="<?php echo site_url('corporate/order/get_list/accomplish');?>">交易成功(<?php echo $status_9 + $status_13 + $status_14;?>)</a>
                    </li>
                   
                    <li <?php if( $order_state == 'shut') echo'class="houtai_zijin_current"';?>>
                         <a href="<?php echo site_url('corporate/order/get_list/shut');?>">交易关闭(<?php echo $status_10 + $status_11 + $status_12;?>)</a>
                    </li>
                    
                    <!--   <li <?php if( $order_state == 'receive') echo'class="houtai_zijin_current"';?>>
                        <a href="<?php echo site_url('corporate/order/get_list/receive');?>">待提取提货权(<?php echo $status_7?>)</a>
                    </li>
                    -->
                </ul>
                
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" id="order_index">
            <div class="cmRight_tittle" >全部订单 <span class="daochu"> <a href="<?php echo site_url('Corporate/order/order_excel')?>">导出excel</a></span></div>
            <div class="dingdanguanli_01_top">
            	<form action="<?php echo site_url('corporate/order/get_list').'/'.$order_state;?> "method="get">
                	<ul>
                	
                		<li><label>订单号：<input type="text" class="dingdanguanli_01_input" value="<?php if(isset( $search['or_number'] ) && $search['or_number'] != '') echo $search['or_number'];?>" name="or_number"></label></li>
                        <li><label>快递号：<input type="text" class="dingdanguanli_01_input" value="" name="ep_number"></label></li>
                        <li><label>收件人姓名：<input type="text" class="dingdanguanli_01_input" value="<?php if(isset( $search['name'] ) && $search['name'] != '') echo $search['name'];?>" name="name"></label></li>
                        <li><label>收件人电话：<input type="text" class="dingdanguanli_01_input" value="<?php if(isset( $search['phone'] ) && $search['phone'] != '') echo $search['phone'];?>" name="phone"></label></li>
                        <li><div class="dingdanguanli_01_sousuo"><a href="javascript:sub()">搜索</a></div></li>
                    </ul>
                   
                 </form>
            </div>
            
            <!---->
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con"  style="height:auto;">
            	<div class="dingdanguanli_01_top02">
                    <ul>
                    
                        <li <?php if (!$order_state) echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list');?>">全部(<?php echo $totalcount;?>)</a>
                        </li>
                        <li <?php if ( $order_state =='wait') echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list/wait');?>">等待付款(<?php echo $status_1 + $status_2;?>)</a>
                        </li>
                        <li <?php if ( $order_state =='wait_dispatch') echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list/wait_dispatch');?>">等待发货(<?php echo $status_3 + $status_4 + $status_5;?>)</a>
                        </li>
                        <li <?php if ( $order_state =='dispatch') echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list/dispatch');?>">已发货(<?php echo $status_6;?>)</a>
                        </li>
                       
                        <li <?php if ( $order_state =='accomplish') echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list/accomplish');?>">交易成功(<?php echo $status_9 + $status_13 + $status_14;?>)</a>
                        </li>
                        <li <?php if ( $order_state =='shut') echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list/shut');?>">交易关闭(<?php echo $status_10 + $status_11 + $status_12;?>)</a>
                        </li>
                        <!--  
                         <li <?php if ( $order_state =='receive') echo'class="dingdanguanli_01_top02_current"';?>>
                            <a href="<?php echo site_url('corporate/order/get_list/receive');?>">待提取提货权(<?php echo $status_7?>)</a>
                        </li>
                        -->
                    </ul>
                    
                </div>
                <!---->
                <div class="select1">
                	<!-- <ul>
                    	<li><a href="#">批量删除</a></li>
                    </ul> -->
                    
                    <table width="910" height="34" border="0" cellpadding="0" cellspacing="0" class="table1_1 dingdan_border">
                    	<tr class="tr1" >
                            <th width="140px" style="text-align:left"><input type="checkbox" style="margin-right:50px; margin-left:15px">订单编号</th>
                            <th width="70px">商品数量</th>
                            <th width="100px">订单总款</th>
                            <th width="150px">收货信息</th>
                            <th width="78px">交易状态</th>
                            <th width="78px">团购状态</th>
                            <th width="78px">核销人</th>
                            <th width="150px">核销时间</th>
                            <th width="88px">操作</th>
                    	</tr>
                    
                    </table>
               
                    <?php if(count($orderList)>0): ?>
                    <?php 
                    $pre_order_sn = NULL;
                    
                    foreach ($orderList as $k=> $order): ?>
                    <table width="910" height="120" border="0" cellpadding="0" cellspacing="0" class="table1_2">	
                    	<tr class="tr1">
                            <th width="137px" style="text-align:center">
                            	<p style="width:137px"><?php echo $order['order_sn'];?></p>
                            </th>
                            <th width="70px"><?php echo $order['num'];?></th>
                            <th width="100px">提货权：<?php echo  $order['total_price'];?></th>
                            
                            <th width="150px"><?php echo $order['consignee'];?><br>
							<?php echo  $order['contact_mobile'];?><br>
							<?php echo $order['address'];?></th>
                            <th width="78px" class="status_text_<?php echo $order['id']?>"><?php
											switch ($order ['status']) {
												case 1 :
													echo '等待未确认';
													break;
												case 2 :
													echo '已确认';
													break;
												case 3 :
													echo '等待客户付款'; //用不到
													break;
												case 4 :
													echo '已付款';
													break;
												case 5 :
													echo '确认货到已付款';//暂时用不到
													break;
												case 6 :
													echo '已发货';
													break;
												case 7 :
													echo '待提取提货权';
													break;
												case 8 :
													echo '收货并付款';//暂时用不到
													break;
												case 9 :
													echo '订单完成';
													break;
												case 10 :
													echo '已取消';
													break;
												case 11 :
													echo '已退款';
													break;
												case 12 :
													echo '已退货';
													break;
												case 13 :
													echo '已存货';
													break;
												case 14 :
												    echo '订单完成';
												    break;
											}
											?></th>
			
							<th width="78px"><?php if($order['g_status'] == '0' && $order['enddate'] > date('Y-m-d H:i:s') && $order['status'] != '10') echo '拼团中'; else if ($order['g_status'] == '1' ) echo '拼团成功'; else if( ($order['g_status'] == '0' && $order['enddate'] < date('Y-m-d H:i:s') ) || $order['g_status'] == '2') echo '过期取消';?></th>                
                             <th width="78px"><?php echo $order["real_name"]?$order["real_name"]:$order["verify_by"];?></th>
                              <th width="150px"><?php echo $order["verify_time"];?></th>
                            <th width="88px" style="text-align:center" id="th_<?php echo $order['id']?>">
                           
                            	<!--<a href="#" style="color:#fca543; text-decoration:underline">修改发货</a><br>-->
                                <?php if ($order ['status'] == 4 && $order['g_status'] != '' ):?>
                                    <?php if ( $order['g_status'] == '0' && $order['enddate'] > date('Y-m-d H:i:s') ):?>
                                        <a href="javascript:;" onclick= "alert('未拼团成功,无法发货');" class="dingdanguanli_01_fahuoBtn2" style="background:#ccc">发货</a><br/>
                                    <?php elseif( $order['g_status'] == 1 ):?>
                                        <a href="javascript:;" onclick= "dispatch(<?php echo $order['id']?>)" class="dingdanguanli_01_fahuoBtn2" style="background:#fea33b">发货</a><br/>
                                    <?php endif;?>
                                
                                <?php elseif($order ['status'] == 4 && $order['g_status'] == '' ) :?>
                                        <a href="javascript:;" onclick= "dispatch(<?php echo $order['id']?>)" class="dingdanguanli_01_fahuoBtn2" style="background:#fea33b">发货</a><br/>
                                <?php endif;?>
                                
                                <?php if ($order ['status'] == 1 ) {?>
                            	   <a href="javascript:;" onclick= "receive(<?php echo $order['id']?>)"class="dingdanguanli_01_fahuoBtn2" style="background:#fea33b">确认接单</a><br/>
                            	   <a href="javascript:;" onclick= "cancel(<?php echo $order['id']?>)"class="dingdanguanli_01_fahuoBtn2" style="background:#fea33b">取消订单</a><br/>
                            	  <?php }?>
                            	  <?php if ($order ['status'] == 7 ) {?>
                            	   <a href="javascript:;" onclick= "Load_Pay(<?php echo $order['id']?>)"class="dingdanguanli_01_fahuoBtn2" style="background:#fea33b">支付手续费</a><br/>
                            	   
                            	  <?php }?>
                                <a href="<?php echo site_url('corporate/order/order_details/'.$order['id']);?>" style="color:#fca543; text-decoration:underline">详情</a>
                               
                            </th>
                            
                    	</tr>
                    </table>
                    <?php endforeach;?>
                    <?php else: ?>
                    <div class="result_null">暂无内容</div>
                    <?php endif; ?>                    
                    <!---->
                    
                      <div class="jilu">
                      <p>显示 <?php if(count($orderList) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                    	  </div>
                    <div class="showpage">
                    	<?php echo $page;?>
                    </div>
                </div>
            </div>
         </div>

         
         <!-- 支付确认 -->
         <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" id="pay_index" hidden>
            <div class="cmRight_tittle" >支付确认</div>
           	<div class="order_con" style="display:dlock">
               <ul>
                 <li>
                      <span class="order_tit">订单号</span>：
                      <span class="order_num" style="color:#555;" id="order_sn">20160615123650</span>
                 </li>
                 <li>
                      <span class="order_tit">交易金额（提货权）</span>：
                      <span class="order_num" id="price">10000.00</span>  提货权
                 </li>
                 <li>
                      <span class="order_tit">手续费（现金）</span>：
                      <span class="order_num" id="commission">50.00</span>  元
                 </li>
                 <li>
                      <span class="order_tit">账号余额（现金）</span>：
                      <span class="order_num" id="cash">100.00</span>  元
                 </li>
                 
                 <!-- 有余额时候 start-->
                 <h3 style="font-weight:normal" id="pay_input">
                     <li>
                          <span class="order_tit">支付密码</span>：
                          <span class="order_num"> 
                              <input value="" placeholder=" 请输入支付密码" name="pay_password" class="input-text1" type="password">
                          </span>
                          <a href="<?php echo site_url('member/save_set/paypwd_set/forgetpay')?>" class="order_forgetCode">忘记密码？</a>
                     </li>
                     <li style="color:#c32d05; margin-left:150px;" id="pay_messgag" hidden>请输入支付密码</li><!-- 默认隐藏 -->
                 </h3>
                 <!-- 有余额时候 end-->
                 
                 <!-- 余额不足时候 start-->
                 <h3 style="font-weight:normal" id="not_cash_message" hidden>
                     <li style="margin:30px 0;">
                          <span style="color:#fea33b;">余额不足，请先进行充值！</span>
                     </li>
                 </h3>
				 <!-- 余额不足时候 end-->
               </ul>
               <div class="transformation_btn">
                   <div class="transformation_btn01" style="background:#ccc;"><a href="<?php echo site_url('corporate/order/get_list/receive')?>" >取消</a></div>
                   <div class="transformation_btn02"><a href="javascript:void(0);" id="pay_">确定</a></div>       
               </div>
           </div>
         </div>
         
         <!-- 支付结果 -->
         <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight"id="pay_is_ok" hidden>
            <div class="cmRight_tittle" >支付成功</div>
           	
            <!--支付成功 start-->
            <div class="orderpay_result" >
               <span><img src="images/success1.png"/></span>
               <h5>成功从您的现金账上扣除50.00 元现金手续费，您的账上已增加10000.00提货权</h5>
               <p>接下来，您可以继续以下操作：</p>
               <div class="orderpay_btn">
                   <a href="<?php echo site_url('corporate/order/get_list/receive')?>"class="orderpay_btn01">查看订单</a>
                   <a href="<?php echo site_url('member/property/get_list')?>"class="orderpay_btn02">查看提货权余额</a>     
               </div>
            </div>
         
        </div>
         

    </div>
    
    
    
    
    
    <!--新增支付流程－输入支付密码－弹窗 开始--><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang" hidden id='dingdan4_3_tanchuang'>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">支付确认</div>
          <div class="dingdan4_3_tanchuang_top2">
              <ul class="payNum_ul">
              	<li><span class="pay_left">订单号:</span><span id="order_sn"></span></li>
                <li><span class="pay_left">订单金额:</span><span id ="price"></span></li>
                <li><span class="pay_left">手续费(现金):</span><span id ="commission"></span></li>
                <li><span class="pay_left">现金余额:</span><span id ="cash"></span></li>
                <li><span class="pay_left">支付密码:</span><span><input type="password" placeholder="请输入支付密码" name="pay_password" class="payNum_input"></span><a href="<?php echo site_url('customer/forget_password')?>" class="payNum_forget">忘记密码？</a></li>
                <li hidden id='pass_message'><span class="payNum_tips">*密码错误，请重新输入</span></li>
              </ul>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc; "><a href="javascript:;" onclick="$('.dingdan4_3_tanchuang').hide()">取消支付</a></div>
              <div class="dingdan4_3_btn02"><a href="javascript:;" id='pay_' >确认支付</a></div>
          </div>
          
      </div>
	</div>
    <!--新增支付流程－输入支付密码－弹窗 结束-->
    
    <script>

//     $(window).bind('hashchange', function() {
//         alert(location.hash);
//     	if( location.hash == ''){ 
//     		$('#order_index').show();

//     	}else{ 
//     		$('#order_index').hide();
//             }
    	 
//     });

    function sub(){ 
        $('form').submit();
        }

    function dispatch( id ){
       
        url = "<?php echo site_url('corporate/order/update_status_dispatch')?>"
        sub_incident(id,url);
       
    }

    function receive(id){ 
       	 url = "<?php echo site_url('corporate/order/update_status_receive')?>"
       	 sub_incident(id,url);
    }

    function cancel(id){ 
        url = "<?php echo site_url('corporate/order/cancel_order')?>"
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
                    if(data.status == 10 || data.status == 2){
                       	 $('#th_'+id+' a').eq(0).next().remove();
                       	 $('#th_'+id+' a').eq(0).remove();
                         $('#th_'+id+' a').eq(0).next().remove();
                         $('#th_'+id+' a').eq(0).remove();
                     }else{
                         $('#th_'+id+' a').eq(0).next().remove();
                         $('#th_'+id+' a').eq(0).remove();
                     }
                     if(data.status == 6) $('.status_text_'+id).text('已发货');
                     if(data.status == 2) $('.status_text_'+id).text('已确认');
                     if(data.status == 10)$('.status_text_'+id).text('已取消');
                }else{ 
                    if(!data.role_status){
                        alert("对不起，你暂时还没有权限！");return;
                    }
                    alert('操作失败');
                }
              
            },

        })
    }

    function Load_Pay(o_id){ 
        url = "<?php echo site_url('corporate/order/ds')?>"
    	$.ajax({ 
            url:"<?php echo site_url('order/load_pay_order')?>",
            type:'post',
            data:{order_id:o_id},
            dataType:'json',
            success:function(data){
                if(data){ 
                    $('#order_index').hide();
                    $('#pay_index').show();
                    
                } 
                $('#order_sn').text(data.order_sn);
                $('#price').text(data.price);
                $('#commission').text(data.commission);
                $('#cash').text(data.cash);
//                 $('#dingdan4_3_tanchuang').show();
                $('#pay_').attr('onclick','commission('+o_id+')');
            },
            error:function(){ 
                alert('未知错误');
            }

        })
    }

    function commission(o_id){ 
        var pass = $('input[name=pay_password]').val();
        var commission = $('#commission').text();
        var pirce = $('#price').text();
        if(pass == ''){
            $('#pay_messgag').text('请输入支付密码');
            $('#pay_messgag').show();
            return ;
        }
        
        $.ajax({ 
            url:"<?php echo site_url('order/carry_rebate')?>",
            type:'post',
            data:{order_id:o_id,pass:pass},
            dataType:'json',
            success:function(data){ 
                
              if(data == 1){ 
          	      $('#pay_is_ok').children('.orderpay_result').children('h5').html('成功从您的现金账上扣除'+commission+'元现金手续费，您的账上已增加'+pirce+'提货权');
            	  $('#pay_is_ok').show();
                  $('#pay_index').hide();
                  
                  return;

              }else if(data == 2){ 
            	  $('#not_cash_message').show();
            	  $('#pay_input').hide();
                  $('#not_cash_message').show();
                  $('.transformation_btn02').children('a').text('现金充值');
                  $('.transformation_btn02').children('a').attr('href',"<?php echo site_url('member/property/pay_index')?>");
                  $('.transformation_btn02').children('a').removeAttr('onclick');
                  return;
              }else if(data == 3){ 
                  alert('订单错误');
              }else if(data == 4){ 
            	  $('#pay_messgag').text('支付密码错误');
                  $('#pay_messgag').show();
            	  
              }else{
            	  $('#pay_is_ok').children('.orderpay_result').children('h5').html('支付失败请稍后重试');
           	      $('#pay_is_ok').children('.orderpay_result').children('span').children('img').attr('src','images/fail.png');
            	  $('#pay_is_ok').show();
                  $('#pay_index').hide();
              }
              
            },
            error:function(){ 
                alert('未知错误');
            }

        })
    }


//     $(function(){ 
//     	var obj = $('.table_order').last();
//         var last_order = obj.children('tbody').children('tr').children('th').children('input').eq(0).val();
       
//         $('.showpage a').each(function(){ 
        	
//             var href = $(this).attr('href');
//             href +=last_order;
//             $(this).attr('href',href);

           
//             });
        
//     })
    </script>