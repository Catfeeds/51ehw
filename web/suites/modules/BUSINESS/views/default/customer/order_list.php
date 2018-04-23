    
<style>
.dingdanzhongxin_01_con02_down .dingdanzhongxin_01_con02_down_btn{ margin-top:7px;}
.dingdanzhongxin_01_con02_down ul li{ height:90px}
.yangshijuzhong{ position:absolute; top:50%;}
.dingdanzhongxin_01_con02_down ul li{width: 98px;}
.dingdanzhongxin_01_con01 ul li{width: 98px;}
</style>
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
                	<li style="width:349px">商品信息</li>
                    <li>价格（提货权）</li>
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
                    <li style="width:148px; border-right:0">交易操作</li>
                </ul>
            </div>
            <!---->
            <?php if(count($orders)>0): ?>
            <?php foreach ($orders as $k=>$v):?>
          <div class="dingdanzhongxin_01_con02">
            	<div class="dingdanzhongxin_01_con02_top">
                	<span><?php echo $v['place_at'];?></span>
                    <span>订单号：<?php echo $v['order_sn'];?></span>
                    <span><?php // $item = $v['items']['0'];?></span>
                </div>
                <div class="dingdanzhongxin_01_con02_down" style="margin-bottom:0; overflow:hidden;">
                	<ul>
                      <div style="overflow:hidden; float:left; position:relative">
                    	<li class="dingdanzhongxin_01_con02_down_li" style="width:329px">
                   	    <samp><img src="<?php echo IMAGE_URL.$v['goods_thumb']; ?>" width="67" alt=""/></samp>
                        <span class="yangshijuzhong"><?php echo $v['product_name'];?></span>
                        </li>
                        <li style="line-height:75px;"><?php echo $v['price'] ?></li>
                        <li style="line-height:75px;"><?php echo $v['total_quantity']?></li>
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
                        <li style="width:148px; border-right:0; display:table;" id='status_submit_<?php echo $v['id']?>'>
                                <?php if(in_array($v['status'],array(6))):?>
                                    <a href="javascript:;" onclick="receive(<?php echo $v['id']?>)" class="dingdanzhongxin_01_con02_down_btn">确认收货</a>
                                     </br>
                                <?php endif;?>
                                
                                <?php if(in_array($v['status'],array(1))):?>
                                    <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" style="background: #ccc"onclick="alert('待商家确认')">立即付款</a>
                                    </br>
                                    <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" onclick="cancel(<?php echo $v['id']?>)">取消订单</a>
                                <?php endif;?>
                                
                                <?php if(in_array($v['status'],array(2))):?>
                                <a href="<?php echo site_url('Member/order/order_pay/'.$v['id'])?>" class="dingdanzhongxin_01_con02_down_btn">立即付款</a>
                                 </br>
                                <a href="javascript:;" class="dingdanzhongxin_01_con02_down_btn" onclick="cancel(<?php echo $v['id']?>)">取消订单</a>
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
                            <?php elseif(in_array($v['status'],array(7,9,14)) ): //elseif(in_array($v['status'],array(7,9))): ?>
                                <a href="<?php echo site_url('member/my_comment/product_comment/'.$v['id'].'/details') ?>" style="color:#fea33b; text-decoration:underline;vertical-align:middle; display:table-cell; ">
                                <?php echo $v['comment_num'] >= $v['item_id_num'] ? '已评价' : '未评价'?>
                                </a><br>
                                <!-- <a href="#" style="color:#fea33b; text-decoration:underline">退换货</a>  -->  
                            <?php endif;?>
                        </li>
                        </div>
                       <!--多选空白--> 
                        <div style="display:none;">
                        <li style="line-height:110px;"></li>
                        <li style="width:114px; display:block"> </li>
                        <li style="width:148px; border-right:0; display:table;">
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
              	<li><span class="pay_left">支付密码：</span><span><input type="password" placeholder="请输入支付密码" name="pay_password_1" class="payNum_input"></span><a  href="<?php echo site_url('member/save_set/paypwd_set/forgetpay')?>" class="payNum_forget">忘记密码？</a></li>
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
          <div class="dingdan4_3_tanchuang_top">您还没有设置支付密码,点击<a href ="<?php echo site_url('member/save_set/paypwd_set')?>" style="color:#fea33b">这里</a>去设置支付密码</div>
        </div>
	</div>
    <!--弹窗 结束-->
    <script>
    
    function sta(){
       var val = $("#status").val();
       document.location = "<?php echo site_url('member/order/index').'/';?>"+val;

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
                  html = '<a href="'+comment+id+'/details" style="color:#fea33b; text-decoration:underline">评价</a><br>'
//                   html += '<a href="#" style="color:#fea33b; text-decoration:underline">退换货</a>'
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
    </script>
     <!--我的订单的字和图片都居中-->
<script type="text/javascript">
	$(".yangshijuzhong").each(function(i){
		height = $(this).height();
      $(this).css("margin-top",- height/2);
		});
    </script>