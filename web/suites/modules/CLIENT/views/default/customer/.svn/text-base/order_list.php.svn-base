    
<style>
.dingdanzhongxin_01_con02_down .dingdanzhongxin_01_con02_down_btn{ margin-top:7px;}
.dingdanzhongxin_01_con02_down ul li{ height:90px;}
.yangshijuzhong{ position:absolute; top:50%;}
.pay_left{ width:auto;}
.dingdan4_3_tanchuang_top2 ul li{ margin-bottom:0}
.dingdan4_3_tanchuang_top2 ul{ margin-top:0}
.dingdanzhongxin_01_con02_top{ background:#eeeeee; height:40px; line-height:40px;}
</style>
    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 6;
            $this->load->view('customer/leftmenu',$data);
         ?>

		<div class="huankuan_cmRight clearfix">
        	<div class="huankuan_rTop">我的订单</div>
            <div class="huankuan_rCon01">
            	<ul>
                	<li <?php echo empty($statu) ? 'class="huankuan_rCon01_current"' : ''; ?>><a href="<?php echo site_url('member/order')?>">全部订单</a></li>
                    <li class="huankuan_line"></li>
                    <li <?php echo !empty($statu) && $statu == 1 ? 'class="huankuan_rCon01_current"' : ''; ?>><a href="<?php echo site_url('member/order/index/1')?>">待付款</a></li>
                    <li class="huankuan_line"></li>
                    <li <?php echo !empty($statu) && $statu == 2 ? 'class="huankuan_rCon01_current"' : ''; ?>><a href="<?php echo site_url('member/order/index/2')?>">待发货</a></li>
                    <li class="huankuan_line"></li>
                    <li <?php echo !empty($statu) && $statu == 3 ? 'class="huankuan_rCon01_current"' : ''; ?>><a href="<?php echo site_url('member/order/index/3')?>">待收货</a></li>
                    <li class="huankuan_line"></li>
                    <li <?php echo !empty($statu) && $statu == 4 ? 'class="huankuan_rCon01_current"' : ''; ?>><a href="<?php echo site_url('member/order/index/4')?>">评价</a></li>
                </ul>
            </div>
            <!--内容-->
            <div class="dingdanzhongxin_01_con01">
            	<ul>
                	<li style="width:350px">商品信息</li>
                    <li>价格（货豆）</li>
                    <li>数量</li>
                    <li>总价（元）</li>
                    <!--<li>商品操作</li>-->
                    <li style="width:114px">
                    	<select  class="gongying_span_select" id="status" onchange="javascript:sta();">
                        	<option value=''>交易状态</option>
                            <option value="1" <?php echo isset($statu)&&$statu==1?"selected":"" ?> >等待付款</option>
                            <option value="3" <?php echo isset($statu)&&$statu==3?"selected":"" ?> >等待收货</option>
                            <option value="4" <?php echo isset($statu)&&$statu==4?"selected":"" ?> >已完成</option>
                            <option value="5" <?php echo isset($statu)&&$statu==5?"selected":"" ?> >已取消</option>
                        </select>
                    </li>
                    <li style="width:168px; border-right:0">交易操作</li>
                </ul>
            </div>
            <!---->
            <?php if(count($orders)>0): ?>
            <?php foreach ($orders as $k=>$v):?>
          <div class="dingdanzhongxin_01_con02">
            	<div class="dingdanzhongxin_01_con02_top">
                	<span><?php echo $v['place_at'];?></span>
                    <span>订单号：<?php echo $v['order_sn'];?></span>
                    <span><?php //$item = $v['items']['0'];?></span>

                    <span><?php echo $v['corporation_name']?></span>
                    <?php if( $v['branch_name'] ){?>
                    	<span>消费分店：<?php echo $v['branch_name']?></span>
                    <?php }?>

                    

                </div>
            <div class="dingdanzhongxin_01_con02_down" style="margin-bottom:0; overflow:hidden;">
                	<ul>
                      <div style="overflow:hidden; float:left; position:relative">
                    	<li class="dingdanzhongxin_01_con02_down_li" style="width:329px">
                   	    <samp><img src="<?php echo IMAGE_URL.$v['goods_thumb']; ?>" width="67" onerror="this.src='images/hotSale_pic1.png'" alt=""/></samp>
                        <span class="yangshijuzhong"><?php echo $v['product_name'];?></span>
                        </li>
                        <li style="line-height:75px;"><?php echo $v['price'] ?></li>
                        <li style="line-height:75px;"><?php echo $v['total_quantity'] ?></li>
                        </div>
                       <div>
                        <li style="line-height:75px;"><?php echo $v['total_price'];?></li>
<!--                         <li><a >退款/退货</a></li> -->
                        <li style="width:114px; display:block" id="order_message_<?php echo $v['id']?>">
                        	<a style="color:#a6a6a6; padding-top:15px; display:block ">
                        	<?php 
                                             switch ($v['status']) {
												case 1 :echo '商家未确认';break;
												case 2 :echo '商家已确认';break;
												case 3 :echo '确认客户付款';break;//微信或支付宝支付返回收款，暂时用不到
												case 4 :echo '已付款';break;
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
											}
                                              ?></a>
                            <a href="<?php echo site_url('member/order/detail').'/'.$v['id'];?>">订单详细</a>
                        </li>
                        <li style="width:100px; border-right:0; display:table; float:none;display: table; margin:0 auto; padding-top:0" id='status_submit_<?php echo $v['id']?>'>
                             <div style="vertical-align:middle; display:table-cell; ">
                                <?php if(in_array($v['status'],array(6))):?>
                                    <a href="javascript:;" onclick="receive(<?php echo $v['id']?>)" style="width:110px; margin-top:5px;" class="dingdanzhongxin_01_con02_down_btn">确认收货</a>
                                     </br>
                                <?php endif;?>
                                
                                <?php if(in_array($v['status'],array(1))):?>
                                    <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" style="background: #ccc;width:110px; margin-top:5px;"onclick="alert('待商家确认')">立即付款</a>
                                   
                                    <!-- <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" style="width:110px; margin-top:5px;"onclick="">线上储值卡支付</a>-->
                                     
                                    <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn"  style="width:110px; background:#fff; border:1px solid #555; color:#555;  margin-top:5px;"onclick="cancel(<?php echo $v['id']?>)">取消订单</a>
                                <?php endif;?>
                                
                                <?php if(in_array($v['status'],array(2))):?>
                                <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" style="width:110px; margin-top:5px;"onclick="show_pay(<?php echo $v['id']?>)">立即付款</a>
                                
                                 <!-- <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" style="width:110px; margin-top:5px;"onclick="">线上储值卡支付</a>-->
                                    
                                <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" style="width:110px; background:#fff; border:1px solid #555; color:#555; margin-top:5px;"onclick="cancel(<?php echo $v['id']?>)">取消订单</a>
                                    <?php 
//                                     if( strtotime(date('Y-m-d H:i:s')) - strtotime($v['place_at']) < 864000 ):
//                                     ?>
                                       <!--  剩余<?php 
//                                        echo (10 - date('d',(strtotime(date('Y-m-d H:i:s'))-strtotime($v['place_at']))))>0? 10 - date('d',(strtotime(date('Y-m-d H:i:s'))-strtotime($v['place_at']))):'0' 
                                       ?>天<?php 
//                                        echo (date('H:i:s',strtotime($v['place_at']))-date('H:i:s',strtotime(date('Y-m-d H:i:s'))))>0?date('H:i:s',strtotime($v['place_at']))-date('H:i:s',strtotime(date('Y-m-d H:i:s'))):'0' 
                                       ?>小时 
                                       
                             
                                    <?php
//                                     else:
//                                     ?>
                                    
                            	<?php // endif;?>
                            	-->
                            <?php elseif(in_array($v['status'],array(7,9))): ?>
                                <a href="<?php echo site_url('member/my_comment/product_comment/'.$v['id'].'/details') ?>" style="color:#fea33b; text-decoration:underline;vertical-align:middle; ">
                                <?php echo $v['comment_num'] >= $v['item_id_num'] ? '已评价' : '未评价'?>
                                </a><br>
                            <?php endif;?>
                            </div>
                        </li>
                        </div>
                       <!--多选空白--> 
                        <div style="display:none;">
                        <li style="line-height:110px;"></li>
                        <li style="width:114px; display:block"> </li>
                        <li style="width:168px; border-right:0; display:table;">
                        </li>
                        </div>
                    </ul>
              </div>
          </div>
          <?php endforeach;?>
          <?php else: ?>
          <div class="result_null" style=" width:910px; margin:10px auto;">暂无内容</div>
          <?php endif; ?>
          
           <div class="pingjia_jilu" style="margin-left:30px">
                    <!--  
                    	<p>显示 <?php if(count($orders) > 0) echo ($curr_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($curr_page*$per_page > $allorder) echo $allorder; else echo $curr_page*$per_page; ?> 条数据，共 <?php echo $allorder?> 条数据</p>
                    -->
                    </div>
                    <div class="pingjia_showpage" style="margin-right:30px">
                    	<?php  echo  $pagination;?>
                     <!-- 	 
                    	<a href="#" class="lPage">上一页</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a class="cpage">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">7</a>
                        <a href="#">8</a>
                        <span>…</span>
                        <a href="#" class="lPage">下一页</a>
-->
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
              	<li><span class="pay_left">订单号：</span><span id="order_sn"></span></li>
                <li><span class="pay_left">订单金额：</span><span id ="price"></span></li>
                <li id="card_list" hidden><span class="pay_left">线上储值卡支付：</span>
                <select style="width: 150px;">
                
                </select>
                </li>
                <li id='M_pay_parice'><span class="pay_left">货豆支付：</span></li>
                <li><span class="pay_left">支付密码：</span><span><input type="password" placeholder="请输入支付密码" name="pay_password" class="payNum_input"></span><a href="<?php echo site_url('member/save_set/paypwd_set/forgetpay')?>" class="payNum_forget">忘记密码？</a></li>
                <li hidden id='pass_message'><span class="payNum_tips">*密码错误，请重新输入</span></li>
              </ul>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc; "><a href="javascript:;" onclick="$('.dingdan4_3_tanchuang').hide()">取消支付</a></div>
              <div class="dingdan4_3_btn02"><a href="javascript:;" id='pay_' onclick="pay()">确认支付</a></div>
          </div>
          
      </div>
	</div>
    <!--新增支付流程－输入支付密码－弹窗 结束-->
    
      <!--收货－输入支付密码－-><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang" hidden id='dingdan4_3_tanchuang_1'>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">收货确认</div>
          <div class="dingdan4_3_tanchuang_top2">
              <ul class="payNum_ul">
              	<li><span class="pay_left">支付密码：</span><span><input type="password" placeholder="请输入支付密码" name="pay_password_1" class="payNum_input"></span><a class="payNum_forget">忘记密码？</a></li>
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
	<div class="dingdan4_3_tanchuang" hidden id='dingdan4_3_tanchuang_3' onclick="$('#dingdan4_3_tanchuang_3').hide()">
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">您还没有设置支付密码,点击<a href ="<?php echo site_url('member/save_set/paypwd_set')?>" style="color:#fe4101">这里</a>去设置支付密码</div>
        </div>
	</div>
    <!--弹窗 结束-->
    <script>
    var card_info = {};
    var order_info = {};
    var card_buy_id = 0;
    var card_pay_amount = 0;
    
    function sta(){
       var val = $("#status").val();
        document.location = "<?php echo site_url('member/order/index').'/';?>"+val;

    }

    function show_pay( o_id ){
    	$('input[name=pay_password]').val('');
   	    url = '<?php echo site_url('order/is_pay_passwd')?>'
        $.post(url,{},function (data){
            if(data)
            { 
               	 $.ajax({ 
                     url:'<?php echo site_url('order/order_message')?>',
                     data:{o_id:o_id},
                     dataType:'json',
                     type:'post',
                     async: false,
                     success:function(data)
                     {
                    	 card_buy_id = 0;
                    	 card_pay_amount = 0;
//                          order_info = data.data.order_info;
                         $('#card_amount').remove();
                         $('#order_sn').text(data.order_sn);
                         $('#price').text('M '+data.total_price);
                         $('#pay_').attr('onclick','pay("'+data.id+'")')
						 $('#M_pay_parice').children('span').html('货豆支付：M '+data.total_price);

                         //暂时不需要。
//                          if( data.data.card_list.length > 0 )
//                          { 
//                             var html = '<option value=0>请选择</option>';
                            
//                             $('#card_list select').empty();
                            
//                              for(var i =0 ;i<data.data.card_list.length; i++)
//                              { 
//                             	 card_info[data.data.card_list[i]['id']] = data.data.card_list[i];
//                                  html += '<option value='+data.data.card_list[i]['id']+'>'+data.data.card_list[i]['card_name']+'</option>';
//                              }
                            
// 							 $('#card_list').show();
//                              $('#card_list select').append(html);
//                          }
                         
                     }
                 })
                 $('#pass_message').hide();
                 $('#dingdan4_3_tanchuang').show();
            }else{ 
                 $('#dingdan4_3_tanchuang_3').show();
            }
        });
       
    }

    function pay(id){ 
    	
        var pass  = $('input[name=pay_password]').val();
    	
        
        $.ajax({ 
       	 url:'<?php echo site_url('order/pay_order')?>',
         data:{id:id, pass:pass,card_buy_id:card_buy_id,card_pay_amount:card_pay_amount},
         dataType:'json',
         type:'post',
         success:function(data){
            switch(data.status){ 
                case 1:
                    alert('支付成功');
                    $('#pass_message').hide();
                    $('#dingdan4_3_tanchuang').hide();
                    $('#status_submit_'+id).remove();
                    $('#order_message_'+id+' a').eq(0).text('已付款');
                break;
                case 2:
                    alert('订单错误');
                break;
                case 3:
                    $('#pass_message').show();
                break;
                case 4:
                    alert('余额不足');
                break;
                default:
                    alert('支付失败,请重新支付');
                break;
            }
         }
      })
    }

    function receive(id){ 
    	$('#pass_message_1').hide();
        $('#shouhuo').attr('onclick','ok_receive("'+id+'")');
        $('input[name=pay_password_1]').val('');
   	    $('#dingdan4_3_tanchuang_1').show();
    }

    function ok_receive( id ){
    	
        var pass = $('input[name=pay_password_1]').val();
        var comment = "<?php echo site_url('member/my_comment/product_comment').'/'?>"
        $.ajax({ 
           url:'<?php echo site_url('order/receive')?>',
           data:{pass:pass,id:id},
           dataType:'json',
           type:'post',
           success:function(data){
              if(data == 1){ 
          	      $('#dingdan4_3_tanchuang_1').hide();
            	  $('#order_message_'+id+' a').eq(0).text('交易完成');
                  $('#status_submit_'+id).empty();
                  html = '<a href="'+comment+id+'/details" style="color:#fea33b; text-decoration:underline;vertical-align:middle; display:table-cell; ">未评价</a><br>'
//                   html += '<a href="#" style="color:#fe4101; text-decoration:underline">退换货</a>'
                  $('#status_submit_'+id).append(html);
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
   
    function cancel( id ){ 
        
    	url = "<?php echo site_url('order/cancel_order')?>"
   		 $.ajax({ 
            url:url,
            type:'post',
            data:{id:id},
            dataType:'json',
            success:function(data){ 
                if(data.is_ok){
               	 $('#order_message_'+id+' a').eq(0).text('已取消');
               	 $('#status_submit_'+id).empty();
                }else{ 
                    alert('操作失败');
                }
              
            },

        })
    }

    $('select').on('change',function()
    { 
    	
    	$('#card_amount').remove();
        var id = $("option:selected",this).val();
        
        var remaining_card_amount = 0;
        card_buy_id = id;
        if( id == 0 || !id )
        { 
            
            $('#M_pay_parice').children('span').html('货豆支付：'+order_info['total_price']);
            return;
        }
        
        if( card_info[id] && card_info[id]['level'] == 1 )
        {
        	remaining_card_amount = card_info[id]['remaining_card_amount'];
        	
        }else{ 
			
            if( parseFloat(card_info[id]['level_two_show_card_amount']) >  parseFloat( card_info[id]['remaining_card_amount'] )  )
            { 
                remaining_card_amount = card_info[id]['remaining_card_amount'];
            	
            }else{ 
                
            	remaining_card_amount = card_info[id]['level_two_show_card_amount'];
            }
        }

    
     card_pay_amount = remaining_card_amount;
     
     if( parseFloat( remaining_card_amount) >=  parseFloat( order_info['total_price']) )
     { 
         card_pay_amount = order_info['total_price'];
     }
     
     
     $('#card_list').append('<span id="card_amount">支付金额：'+card_pay_amount+'</span>');
     var m_price = parseFloat(order_info['total_price']) - parseFloat(card_pay_amount);
     
     if( m_price == parseInt(m_price) )
     { 
    	 m_price += '.00';
     }
     $('#M_pay_parice').children('span').html('货豆支付：M '+m_price);
     
		
    })
    </script>
    <!--我的订单的字和图片都居中-->
<script>
$(".yangshijuzhong").each(function(i){
		height = $(this).height();
      $(this).css("margin-top",- height/2);
		});

</script>